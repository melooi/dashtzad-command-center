<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public static function sendOtp(string $phone, string $code): bool
    {
        if (app()->environment('local')) {
            Log::info("[OTP-DEV] Phone: {$phone} — Code: {$code}");
            return true;
        }

        return static::sendViaMsgway($phone, $code);
    }

    private static function sendViaMsgway(string $phone, string $code): bool
    {
        $apiKey    = config('services.msgway.api_key');
        $sender    = config('services.msgway.sender', '3000xxx');
        $template  = config('services.msgway.otp_template', 'کد ورود به پنل دشت‌زاد: %s');
        $message   = sprintf($template, $code);

        if (empty($apiKey)) {
            Log::error('[SMS] MSGway API key not configured');
            return false;
        }

        try {
            $res = Http::timeout(10)->post('https://api.msgway.com/sms/send', [
                'api_key' => $apiKey,
                'sender'  => $sender,
                'receptor'=> $phone,
                'message' => $message,
            ]);

            if ($res->successful() && ($res->json('status') === 'success' || $res->json('status') === 200)) {
                return true;
            }

            Log::warning('[SMS] MSGway error', ['phone' => $phone, 'response' => $res->body()]);
            return false;

        } catch (\Throwable $e) {
            Log::error('[SMS] MSGway exception: ' . $e->getMessage(), ['phone' => $phone]);
            return false;
        }
    }
}
