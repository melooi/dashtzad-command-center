<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'دشت‌زاد') }} — پنل فرماندهی</title>
    <script>
        (function(){
            var t = localStorage.getItem('dashtzad_theme');
            if (t !== 'light') document.documentElement.classList.add('dark');
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- ── Runtime theme injection ──────────────────────────────────────── --}}
    @php
        try {
            $tv = json_decode(\App\Models\AppSetting::get('panel_theme', '{}'), true) ?? [];
        } catch (\Throwable) { $tv = []; }

        $hx  = '/^#[0-9A-Fa-f]{6}$/';
        $num = fn($v, $min=0, $max=9999) => is_numeric($v) && (float)$v>=$min && (float)$v<=$max ? (float)$v : null;
        $hex = fn($v) => is_string($v) && preg_match('/^#[0-9A-Fa-f]{6}$/', $v) ? $v : null;

        // Shared brand/semantic tokens (:root)
        $root = [];
        foreach (['primary','secondary','accent','success','warning','danger','info'] as $k) {
            if ($c = $hex($tv[$k] ?? null)) $root["--color-$k"] = $c;
        }
        // Radius tokens
        $rMap = ['radius_btn'=>'--radius-btn','radius_card'=>'--radius-card','radius_modal'=>'--radius-modal'];
        foreach ($rMap as $field => $var) {
            if (null !== ($v = $num($tv[$field] ?? null, 0, 200))) $root[$var] = round($v/16,4).'rem';
        }
        if (null !== ($v = $num($tv['radius_badge'] ?? null, 0, 9999))) $root['--radius-badge'] = ($v >= 9999 ? '9999px' : round($v/16,4).'rem');
        // Modal/table tokens
        if (null !== ($v = $num($tv['modal_blur'] ?? null, 0, 20)))     $root['--modal-blur'] = $v.'px';
        if (null !== ($v = $num($tv['modal_overlay'] ?? null, 0, 100))) $root['--modal-overlay'] = 'rgba(0,0,0,'.round($v/100,2).')';
        $trh = ['light_highlight'=>'rgba(255,255,255,0.05)','primary_tint'=>'color-mix(in srgb,var(--color-primary) 8%,transparent)','none'=>'transparent'];
        if (!empty($tv['table_row_hover']) && isset($trh[$tv['table_row_hover']])) $root['--table-row-hover'] = $trh[$tv['table_row_hover']];
        // Font
        $fontMap = ['IRANYekanX'=>"'IRANYekanX',Tahoma,Arial,sans-serif",'Vazirmatn'=>"'Vazirmatn',sans-serif"];
        $fontEnMap = ['Inter'=>"'Inter',sans-serif",'Monospace'=>'monospace'];
        if (!empty($tv['font_family']) && isset($fontMap[$tv['font_family']])) {
            $root['--font-family'] = $fontMap[$tv['font_family']];
            $root['--font-sans']   = $fontMap[$tv['font_family']];
        }
        if (!empty($tv['font_english']) && isset($fontEnMap[$tv['font_english']])) {
            $root['--font-english'] = $fontEnMap[$tv['font_english']];
        }

        // Dark mode surface tokens (html.dark)
        $dark = [];
        foreach (['bg','surface','border','text_main'=>'text-main','text_muted'=>'text-muted','sidebar','header'] as $k => $cssK) {
            $field = is_string($k) ? $k : $cssK;
            $cssProp = '--color-'.str_replace('_','-',$cssK);
            if ($c = $hex($tv['dark_'.$field] ?? null)) $dark[$cssProp] = $c;
        }

        // Light mode surface tokens (html:not(.dark))
        $light = [];
        foreach (['bg','surface','border','text_main'=>'text-main','text_muted'=>'text-muted','sidebar','header'] as $k => $cssK) {
            $field = is_string($k) ? $k : $cssK;
            $cssProp = '--color-'.str_replace('_','-',$cssK);
            if ($c = $hex($tv['light_'.$field] ?? null)) $light[$cssProp] = $c;
        }

        // Build CSS string
        $css = '';
        if ($root)  { $lines = implode('', array_map(fn($k,$v)=>"    $k:$v;\n",array_keys($root),$root)); $css .= ":root {\n{$lines}}\n"; }
        if ($dark)  { $lines = implode('', array_map(fn($k,$v)=>"    $k:$v;\n",array_keys($dark),$dark));  $css .= "html.dark {\n{$lines}}\n"; }
        if ($light) { $lines = implode('', array_map(fn($k,$v)=>"    $k:$v;\n",array_keys($light),$light)); $css .= "html:not(.dark) {\n{$lines}}\n"; }

        // Vazirmatn needs external CDN
        $needVazirmatn = ($tv['font_family'] ?? '') === 'Vazirmatn';
    @endphp
    @if($needVazirmatn)
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css">
    @endif
    @if($css)<style id="panel-theme">{!! $css !!}</style>@endif

</head>
<body class="bg-bg text-text-main antialiased h-screen flex overflow-hidden selection:bg-primary/20 transition-colors duration-200">

    {{-- Sidebar --}}
    <x-sidebar />

    {{-- Content Wrapper --}}
    <div class="flex-1 flex flex-col relative w-full overflow-hidden">
        <x-header />
        <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8 relative">
            {{ $slot }}
        </main>
    </div>

    {{-- Activity Drawer --}}
    <x-activity-drawer />

    {{-- Mobile sidebar overlay --}}
    <div id="sidebar-overlay"
         class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden-fade md:hidden"
         onclick="closeMobileSidebar()">
    </div>

    {{-- PJAX loading bar --}}
    <div id="pjax-bar"></div>

</body>
</html>
