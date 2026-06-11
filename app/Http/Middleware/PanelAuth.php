<?php

namespace App\Http\Middleware;

use App\Models\AppSetting;
use App\Models\PanelUser;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PanelAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $authEnabled = AppSetting::get('panel_auth_enabled', '0') === '1';

        if (!$authEnabled) {
            return $next($request);
        }

        $userId = session('panel_user_id');

        if (!$userId) {
            return $this->redirectOrJson($request);
        }

        $user = PanelUser::find($userId);

        if (!$user || $user->status !== 'approved') {
            session()->forget('panel_user_id');
            return $this->redirectOrJson($request);
        }

        return $next($request);
    }

    private function redirectOrJson(Request $request): Response
    {
        if ($request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json(['redirect' => route('auth.login')], 401);
        }
        return redirect()->route('auth.login');
    }
}
