<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ConnectionsMsgwayController extends Controller
{
    public function status(): JsonResponse
    {
        $connected  = AppSetting::get('msgway_connected', '0') === '1';
        $templateId = AppSetting::get('msgway_template_id', env('MESSAGE_WAY_SMS_TEMPLATE_ID', ''));
        $lastTest   = AppSetting::get('msgway_last_test', '');
        $lastError  = AppSetting::get('msgway_last_error', '');

        return response()->json([
            'connected'   => $connected,
            'template_id' => $templateId,
            'last_test'   => $lastTest,
            'last_error'  => $lastError,
        ]);
    }

    public function save(Request $request): JsonResponse
    {
        $apiKey     = trim($request->input('api_key', ''));
        $templateId = trim($request->input('template_id', ''));

        $alreadyConnected = AppSetting::get('msgway_connected', '0') === '1';

        // If both empty and already connected → no-op
        if (empty($apiKey) && empty($templateId) && $alreadyConnected) {
            return response()->json(['ok' => true, 'message' => 'تنظیمات بدون تغییر باقی ماند']);
        }

        if (empty($apiKey) && !$alreadyConnected) {
            return response()->json(['ok' => false, 'message' => 'API Key الزامی است']);
        }

        if (!empty($apiKey)) {
            AppSetting::set('msgway_api_key', encrypt($apiKey));
        }
        if (!empty($templateId)) {
            AppSetting::set('msgway_template_id', $templateId);
        }

        AppSetting::set('msgway_connected', '1');
        AppSetting::set('msgway_last_save', now()->toISOString());

        return response()->json([
            'ok'          => true,
            'message'     => 'تنظیمات MSGway ذخیره شد',
            'template_id' => AppSetting::get('msgway_template_id', ''),
        ]);
    }

    public function testSms(Request $request): JsonResponse
    {
        $phone = preg_replace('/\D/', '', $request->input('phone', ''));
        if (!preg_match('/^09\d{9}$/', $phone)) {
            return response()->json(['ok' => false, 'message' => 'شماره موبایل نامعتبر است (مثال: 09120857856)']);
        }

        $apiKey     = $this->resolveApiKey();
        $templateId = $this->resolveTemplateId();

        if (empty($apiKey)) {
            return response()->json(['ok' => false, 'message' => 'API Key تنظیم نشده است. ابتدا اتصال را ذخیره کنید.']);
        }

        $length   = (int) config('panel.otp_length', 4);
        $testCode = (string) random_int(10 ** ($length - 1), (10 ** $length) - 1);
        $result   = $this->callMsgway($apiKey, $templateId, $phone, $testCode);

        if ($result['ok']) {
            AppSetting::set('msgway_last_test', now()->toISOString());
            AppSetting::set('msgway_last_error', '');
        } else {
            AppSetting::set('msgway_last_error', $result['message'] ?? 'خطای ناشناخته');
        }

        return response()->json($result);
    }

    public function disconnect(): JsonResponse
    {
        AppSetting::set('msgway_connected', '0');
        AppSetting::set('msgway_api_key', '');
        AppSetting::set('msgway_template_id', '');
        AppSetting::set('msgway_last_error', '');
        return response()->json(['ok' => true]);
    }

    // ── Shared helpers ───────────────────────────────────────────────────────

    private static function normalizePhoneForMsgway(string $phone): string
    {
        $phone = preg_replace('/\D+/', '', $phone);

        if (str_starts_with($phone, '09')) {
            return '+98' . substr($phone, 1);
        }
        if (str_starts_with($phone, '989')) {
            return '+' . $phone;
        }
        if (str_starts_with($phone, '9')) {
            return '+98' . $phone;
        }
        return '+' . $phone;
    }

    public static function resolveApiKey(): string
    {
        try {
            $stored = AppSetting::get('msgway_api_key', '');
            if ($stored) return decrypt($stored);
        } catch (\Throwable) {}

        return env('MESSAGE_WAY_APIKEY', env('MSGWAY_API_KEY', ''));
    }

    public static function resolveTemplateId(): string
    {
        $stored = AppSetting::get('msgway_template_id', '');
        if ($stored) return $stored;
        return (string) env('MESSAGE_WAY_SMS_TEMPLATE_ID', '');
    }

    public static function callMsgway(string $apiKey, string $templateId, string $phone, string $code): array
    {
        $mobile = self::normalizePhoneForMsgway($phone);

        try {
            $res  = Http::timeout(12)->withHeaders([
                'apiKey'          => $apiKey,
                'accept-language' => 'fa',
                'Content-Type'    => 'application/json',
            ])->post('https://api.msgway.com/send', [
                'mobile'     => $mobile,
                'method'     => 'sms',
                'templateID' => (int) $templateId,
                'code'       => $code,
            ]);

            $body = $res->json() ?? [];

            if ($res->successful() && ($body['status'] ?? '') === 'success') {
                return ['ok' => true, 'message' => 'پیامک ارسال شد', 'ref' => $body['referenceID'] ?? ''];
            }

            if ($res->status() === 401 || $res->status() === 403) {
                return ['ok' => false, 'message' => 'API Key نامعتبر است'];
            }

            $msg = $body['message'] ?? $body['error'] ?? ('خطا: HTTP ' . $res->status());
            Log::warning('[MSGway] send error', ['status' => $res->status(), 'body' => $body]);
            return ['ok' => false, 'message' => $msg];

        } catch (\Throwable $e) {
            Log::error('[MSGway] exception: ' . $e->getMessage());
            return ['ok' => false, 'message' => 'خطا در ارتباط با MSGway'];
        }
    }
}
