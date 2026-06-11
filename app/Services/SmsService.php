<?php

namespace App\Services;

use App\Http\Controllers\ConnectionsMsgwayController;
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
        $apiKey     = ConnectionsMsgwayController::resolveApiKey();
        $templateId = ConnectionsMsgwayController::resolveTemplateId();

        if (empty($apiKey)) {
            Log::error('[SMS] MSGway API key not configured — OTP not sent');
            return false;
        }

        if (empty($templateId)) {
            Log::error('[SMS] MSGway template ID not configured — OTP not sent');
            return false;
        }

        $result = ConnectionsMsgwayController::callMsgway($apiKey, $templateId, $phone, [$code]);

        if ($result['ok']) {
            return true;
        }

        Log::warning('[SMS] MSGway send failed', ['phone' => $phone, 'message' => $result['message']]);
        return false;
    }
}
