<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function togglePanelAuth(Request $request): JsonResponse
    {
        $enabled = $request->boolean('enabled');
        AppSetting::set('panel_auth_enabled', $enabled ? '1' : '0');
        return response()->json(['ok' => true, 'enabled' => $enabled]);
    }
}
