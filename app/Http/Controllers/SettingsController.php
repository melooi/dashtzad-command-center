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

    public function getTheme(): JsonResponse
    {
        $json  = AppSetting::get('panel_theme', '{}');
        $theme = json_decode($json, true) ?? [];
        return response()->json(['ok' => true, 'theme' => $theme]);
    }

    public function uploadLogo(Request $request): JsonResponse
    {
        $allowedSlots = ['logo_main', 'logo_dark', 'logo_light', 'favicon', 'brand_mark', 'default_avatar'];
        $slot = $request->input('slot');

        if (!in_array($slot, $allowedSlots, true)) {
            return response()->json(['ok' => false, 'message' => 'اسلات نامعتبر است']);
        }

        $file = $request->file('logo');
        if (!$file || !$file->isValid()) {
            return response()->json(['ok' => false, 'message' => 'فایلی انتخاب نشده یا خطا در آپلود']);
        }

        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/x-icon', 'image/vnd.microsoft.icon'];
        if (!in_array($file->getMimeType(), $allowedMimes, true)) {
            return response()->json(['ok' => false, 'message' => 'فرمت مجاز نیست (PNG, JPG, WEBP, ICO)']);
        }

        if ($file->getSize() > 2 * 1024 * 1024) {
            return response()->json(['ok' => false, 'message' => 'حجم فایل بیش از ۲ مگابایت است']);
        }

        $logosDir = public_path('logos');
        if (!is_dir($logosDir)) {
            mkdir($logosDir, 0755, true);
        }

        $ext      = $file->getClientOriginalExtension() ?: 'png';
        $filename = $slot . '_' . time() . '.' . strtolower($ext);
        $file->move($logosDir, $filename);

        $url = '/logos/' . $filename;
        AppSetting::set($slot, $url);

        return response()->json(['ok' => true, 'url' => $url]);
    }

    public function saveTheme(Request $request): JsonResponse
    {
        $hx = '/^#[0-9A-Fa-f]{6}$/';

        $colorFields = [
            // Shared brand/semantic
            'primary','secondary','accent','success','warning','danger','info',
            // Dark surface
            'dark_bg','dark_surface','dark_border','dark_text_main','dark_text_muted','dark_sidebar','dark_header',
            // Light surface
            'light_bg','light_surface','light_border','light_text_main','light_text_muted','light_sidebar','light_header',
        ];
        $numFields  = ['radius_btn','radius_card','radius_modal','radius_badge','modal_blur','modal_overlay'];
        $enumFields = [
            'table_row_hover' => ['light_highlight','primary_tint','none'],
            'font_family'     => ['IRANYekanX','Vazirmatn'],
            'font_english'    => ['Inter','Monospace'],
        ];

        $theme = [];

        foreach ($colorFields as $f) {
            $v = $request->input($f);
            if ($v === null || $v === '') continue;
            if (!preg_match($hx, $v)) {
                return response()->json(['ok' => false, 'message' => "رنگ $f نامعتبر است"]);
            }
            $theme[$f] = $v;
        }

        foreach ($numFields as $f) {
            $v = $request->input($f);
            if ($v === null) continue;
            if (!is_numeric($v) || (float)$v < 0 || (float)$v > 9999) {
                return response()->json(['ok' => false, 'message' => "مقدار $f نامعتبر است"]);
            }
            $theme[$f] = (float) $v;
        }

        foreach ($enumFields as $f => $allowed) {
            $v = $request->input($f);
            if ($v === null) continue;
            if (!in_array($v, $allowed, true)) {
                return response()->json(['ok' => false, 'message' => "مقدار $f نامعتبر است"]);
            }
            $theme[$f] = $v;
        }

        AppSetting::set('panel_theme', json_encode($theme));
        return response()->json(['ok' => true]);
    }
}
