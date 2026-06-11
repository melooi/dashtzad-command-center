<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use App\Models\OtpCode;
use App\Models\PanelUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        if (session('panel_user_id')) {
            $user = PanelUser::find(session('panel_user_id'));
            if ($user && $user->status === 'approved') {
                return redirect('/');
            }
        }
        return view('auth.login');
    }

    public function sendOtp(Request $request): JsonResponse
    {
        $phone = $this->normalizePhone($request->input('phone', ''));

        if (!preg_match('/^09\d{9}$/', $phone)) {
            return response()->json(['ok' => false, 'message' => 'شماره موبایل نامعتبر است']);
        }

        // Blocked user check
        $user = PanelUser::where('phone', $phone)->first();
        if ($user && $user->status === 'blocked') {
            LoginLog::record(['phone' => $phone, 'status' => 'blocked', 'ip_address' => $request->ip()]);
            return response()->json(['ok' => false, 'message' => 'این شماره مسدود شده است. با پشتیبانی تماس بگیرید.']);
        }

        // Rate limit: max 3 OTPs per phone per 10 minutes
        $limitKey = 'otp:' . $phone;
        if (RateLimiter::tooManyAttempts($limitKey, 3)) {
            $seconds = RateLimiter::availableIn($limitKey);
            return response()->json(['ok' => false, 'message' => "درخواست زیاد. {$seconds} ثانیه صبر کنید."]);
        }
        RateLimiter::hit($limitKey, 600);

        // Invalidate old OTPs
        OtpCode::invalidatePhone($phone);

        // Generate OTP
        $length  = (int) config('panel.otp_length', 4);
        $min     = 10 ** ($length - 1);
        $max     = (10 ** $length) - 1;
        $code    = (string) random_int($min, $max);
        $hashed  = hash('sha256', $code);
        $otp     = OtpCode::create([
            'phone'      => $phone,
            'code'       => $hashed,
            'expires_at' => now()->addMinutes(2),
            'ip_address' => $request->ip(),
        ]);

        // Send OTP via SMS (or log in development)
        \App\Services\SmsService::sendOtp($phone, $code);

        session(['auth_phone' => $phone, 'auth_otp_id' => $otp->id]);

        LoginLog::record(['phone' => $phone, 'status' => 'otp_sent', 'ip_address' => $request->ip(), 'user_agent' => $request->userAgent()]);

        $response = ['ok' => true, 'phone' => $phone];
        if (app()->environment('local')) {
            $response['dev_otp'] = $code;
        }
        return response()->json($response);
    }

    public function verifyOtp(Request $request): JsonResponse
    {
        $phone = session('auth_phone');
        $otpId = session('auth_otp_id');

        if (!$phone || !$otpId) {
            return response()->json(['ok' => false, 'message' => 'جلسه منقضی شده است. دوباره شماره وارد کنید.']);
        }

        $rawCode   = preg_replace('/[^0-9]/', '', (string) $request->input('code', ''));
        $otpLength = (int) config('panel.otp_length', 4);
        if (strlen($rawCode) !== $otpLength) {
            return response()->json(['ok' => false, 'message' => "کد {$otpLength} رقمی وارد کنید"]);
        }

        $otp = OtpCode::find($otpId);
        if (!$otp || !$otp->isValid()) {
            LoginLog::record(['phone' => $phone, 'status' => 'otp_failed', 'ip_address' => $request->ip()]);
            return response()->json(['ok' => false, 'message' => 'کد منقضی شده یا تعداد تلاش بیش از حد. دوباره امتحان کنید.']);
        }

        if (!hash_equals($otp->code, hash('sha256', $rawCode))) {
            $otp->incrementAttempts();
            LoginLog::record(['phone' => $phone, 'status' => 'otp_failed', 'ip_address' => $request->ip(), 'attempts' => $otp->fresh()->attempts]);
            $remaining = 3 - $otp->fresh()->attempts;
            $msg = $remaining > 0 ? "کد اشتباه است. {$remaining} تلاش باقی مانده." : 'کد اشتباه است و اتمام تلاش. دوباره درخواست کد بدهید.';
            return response()->json(['ok' => false, 'message' => $msg]);
        }

        $otp->markUsed();
        LoginLog::record(['phone' => $phone, 'status' => 'otp_verified', 'ip_address' => $request->ip()]);

        $user = PanelUser::where('phone', $phone)->first();

        if (!$user) {
            return response()->json(['ok' => true, 'redirect' => 'profile']);
        }

        // Auto-approve admin phone even if previously stuck in pending
        $adminPhone = $this->normalizePhone(env('PANEL_ADMIN_PHONE', ''));
        if ($adminPhone && $adminPhone === $phone && $user->status !== 'approved') {
            $user->update(['status' => 'approved', 'role' => 'super_admin', 'approved_at' => now()]);
            $user->refresh();
        }

        return match($user->status) {
            'approved' => $this->loginUser($user, $request),
            'pending_approval', 'pending_profile' => response()->json(['ok' => true, 'redirect' => 'pending']),
            'rejected', 'blocked', 'inactive' => response()->json(['ok' => true, 'redirect' => 'denied']),
            default => response()->json(['ok' => false, 'message' => 'وضعیت حساب نامشخص است']),
        };
    }

    public function saveProfile(Request $request): JsonResponse
    {
        $phone = session('auth_phone');
        if (!$phone) {
            return response()->json(['ok' => false, 'message' => 'جلسه منقضی شده است.']);
        }

        $name = trim($request->input('name', ''));
        if (strlen($name) < 2) {
            return response()->json(['ok' => false, 'message' => 'نام الزامی است (حداقل ۲ کاراکتر)']);
        }

        $data = [
            'name'           => $name,
            'telegram_id'    => $request->input('telegram_id') ?: null,
            'email'          => $request->input('email')       ?: null,
            'department'     => $request->input('department')  ?: null,
            'position'       => $request->input('position')    ?: null,
            'access_reason'  => $request->input('access_reason') ?: null,
            'referrer'       => $request->input('referrer')    ?: null,
            'status'         => 'pending_approval',
            'role'           => 'viewer',
        ];

        // Auto-approve if this phone matches the configured admin phone
        $adminPhone = $this->normalizePhone(env('PANEL_ADMIN_PHONE', ''));
        if ($adminPhone && $adminPhone === $phone) {
            $data['status']      = 'approved';
            $data['role']        = 'super_admin';
            $data['approved_at'] = now();
        }

        $user = PanelUser::updateOrCreate(['phone' => $phone], $data);

        if ($user->status === 'approved') {
            $this->loginUser($user, $request);
            return response()->json(['ok' => true, 'redirect' => 'dashboard']);
        }

        return response()->json(['ok' => true, 'redirect' => 'pending']);
    }

    public function logout(Request $request): RedirectResponse
    {
        session()->forget(['panel_user_id', 'auth_phone', 'auth_otp_id']);
        return redirect()->route('auth.login');
    }

    // ── Private helpers ───────────────────────────────────────────────────────

    private function loginUser(PanelUser $user, Request $request): JsonResponse
    {
        $user->update(['last_login_at' => now()]);
        session(['panel_user_id' => $user->id]);
        session()->forget(['auth_phone', 'auth_otp_id']);
        LoginLog::record(['phone' => $user->phone, 'panel_user_id' => $user->id, 'status' => 'login_success', 'ip_address' => $request->ip(), 'user_agent' => $request->userAgent()]);
        return response()->json(['ok' => true, 'redirect' => 'dashboard']);
    }

    private function normalizePhone(string $phone): string
    {
        return preg_replace('/\D/', '', $phone);
    }
}
