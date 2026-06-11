{{-- PAGE: تنظیمات ظاهری و برند (id=page-settings-theme) --}}
<div id="page-settings-theme" class="max-w-[1400px] mx-auto hidden pb-10">

    {{-- Header bar --}}
    <div class="flex items-center justify-between gap-4 mb-5">
        <div>
            <h1 class="font-bold text-text-main text-base">تنظیمات ظاهری و برند</h1>
            <p class="text-xs text-text-muted mt-0.5">رنگ‌ها، تایپوگرافی، شعاع‌ها و هویت بصری کل پنل</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="themeReset()"
                    class="px-3 py-2 text-xs font-medium text-text-muted hover:text-text-main bg-border hover:bg-border/80 border border-border rounded-lg transition-colors">
                <i class="fa-solid fa-rotate-left ml-1 text-xs"></i>بازنشانی
            </button>
            <button id="theme-save-btn" onclick="themeSave()"
                    class="px-4 py-2 text-xs font-semibold text-white bg-primary hover:bg-primary/80 rounded-lg transition-colors flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk text-xs"></i>ذخیره طرح
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">

        {{-- ── کنترل‌ها (col 7) ─────────────────────────────────────────── --}}
        <div class="xl:col-span-7 flex flex-col gap-5">

            {{-- ══ رنگ‌ها و تم ════════════════════════════════════════════ --}}
            <div class="bg-surface border border-border rounded-card overflow-hidden">
                <div class="px-5 py-4 border-b border-border">
                    <h2 class="font-bold text-text-main text-sm">رنگ‌ها و تم</h2>
                </div>

                {{-- dark / light tabs --}}
                <div class="px-5 pt-4 pb-2">
                    <div class="flex items-center gap-0.5 bg-border/40 p-0.5 rounded-btn w-fit border border-border/40">
                        <button onclick="themeSwitchPaletteTab('dark')" id="theme-tab-dark"
                                class="palette-tab active px-3.5 py-1.5 rounded-btn text-xs font-semibold transition-all">
                            <i class="fa-solid fa-moon text-[10px] ml-1"></i>دارک
                        </button>
                        <button onclick="themeSwitchPaletteTab('light')" id="theme-tab-light"
                                class="palette-tab px-3.5 py-1.5 rounded-btn text-xs font-semibold transition-all">
                            <i class="fa-solid fa-sun text-[10px] ml-1"></i>لایت
                        </button>
                    </div>
                </div>

                {{-- contrast warning --}}
                <div id="theme-contrast-warn"
                     class="hidden mx-5 mb-3 flex items-start gap-2 bg-danger/10 text-danger border border-danger/20 rounded-xl px-4 py-3 text-xs font-bold">
                    <i class="fa-solid fa-triangle-exclamation shrink-0 mt-0.5"></i>
                    <span>کنتراست رنگ اصلی (Primary) با متن سفید ضعیف است — دکمه‌ها ممکن است ناخوانا شوند.</span>
                </div>

                {{-- DARK palette --}}
                <div id="theme-palette-dark" class="p-5 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                    @foreach([
                        ['primary',          'رنگ اصلی',       'Primary'],
                        ['secondary',        'رنگ مکمل',       'Secondary'],
                        ['accent',           'برجسته',         'Accent'],
                        ['success',          'موفقیت',         'Success'],
                        ['warning',          'هشدار',          'Warning'],
                        ['danger',           'خطا',            'Danger'],
                        ['info',             'اطلاع',          'Info'],
                        ['dark_bg',          'پس‌زمینه',       'Background'],
                        ['dark_surface',     'کارت / سطح',     'Surface'],
                        ['dark_border',      'حاشیه',          'Border'],
                        ['dark_text_main',   'متن اصلی',       'Text Main'],
                        ['dark_text_muted',  'متن کم‌رنگ',     'Text Muted'],
                        ['dark_sidebar',     'سایدبار',        'Sidebar'],
                        ['dark_header',      'هدر',            'Header'],
                    ] as [$key, $faLbl, $enLbl])
                    <button type="button" onclick="ccpOpen('{{ $key }}', this)"
                            class="color-card w-full bg-border/50 border border-border/60 rounded-xl p-3 flex items-center gap-2.5 hover:border-primary/60 active:scale-95 transition-all group text-right">
                        <div data-swatch="{{ $key }}"
                             class="w-9 h-9 rounded-lg border border-black/10 shrink-0 shadow-sm transition-colors"
                             style="background:#020617"></div>
                        <div class="flex flex-col min-w-0 flex-1">
                            <span class="text-[11px] font-bold text-text-main leading-tight">{{ $faLbl }}</span>
                            <span class="text-[10px] text-text-muted/60 leading-tight mb-0.5">{{ $enLbl }}</span>
                            <span data-hex="{{ $key }}" class="text-[10px] font-mono text-text-muted tabular-nums" dir="ltr">—</span>
                        </div>
                        <input type="color" data-picker="{{ $key }}" class="sr-only" tabindex="-1" aria-hidden="true">
                    </button>
                    @endforeach
                </div>

                {{-- LIGHT palette (hidden by default) --}}
                <div id="theme-palette-light" class="hidden p-5 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                    @foreach([
                        ['primary',          'رنگ اصلی',       'Primary'],
                        ['secondary',        'رنگ مکمل',       'Secondary'],
                        ['accent',           'برجسته',         'Accent'],
                        ['success',          'موفقیت',         'Success'],
                        ['warning',          'هشدار',          'Warning'],
                        ['danger',           'خطا',            'Danger'],
                        ['info',             'اطلاع',          'Info'],
                        ['light_bg',         'پس‌زمینه',       'Background'],
                        ['light_surface',    'کارت / سطح',     'Surface'],
                        ['light_border',     'حاشیه',          'Border'],
                        ['light_text_main',  'متن اصلی',       'Text Main'],
                        ['light_text_muted', 'متن کم‌رنگ',     'Text Muted'],
                        ['light_sidebar',    'سایدبار',        'Sidebar'],
                        ['light_header',     'هدر',            'Header'],
                    ] as [$key, $faLbl, $enLbl])
                    @php
                        $isShared = in_array($key, ['primary','secondary','accent','success','warning','danger','info']);
                        $ccpKey   = $isShared ? $key : 'l_'.$key;
                        $swatchKey = $isShared ? $key : 'l_'.$key;
                    @endphp
                    <button type="button" onclick="ccpOpen('{{ $ccpKey }}', this)"
                            class="color-card w-full bg-border/50 border border-border/60 rounded-xl p-3 flex items-center gap-2.5 hover:border-primary/60 active:scale-95 transition-all group text-right">
                        <div data-swatch="{{ $swatchKey }}"
                             class="w-9 h-9 rounded-lg border border-black/10 shrink-0 shadow-sm transition-colors"
                             style="background:#f4f4f5"></div>
                        <div class="flex flex-col min-w-0 flex-1">
                            <span class="text-[11px] font-bold text-text-main leading-tight">{{ $faLbl }}</span>
                            <span class="text-[10px] text-text-muted/60 leading-tight mb-0.5">{{ $enLbl }}</span>
                            <span data-hex="{{ $swatchKey }}" class="text-[10px] font-mono text-text-muted tabular-nums" dir="ltr">—</span>
                        </div>
                        <input type="color" data-picker="{{ $swatchKey }}" class="sr-only" tabindex="-1" aria-hidden="true">
                    </button>
                    @endforeach
                </div>
            </div>

            {{-- ══ تایپوگرافی ═══════════════════════════════════════════ --}}
            <div class="bg-surface border border-border rounded-card overflow-hidden">
                <div class="px-5 py-4 border-b border-border">
                    <h2 class="font-bold text-text-main text-sm">تایپوگرافی</h2>
                </div>
                <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-text-muted mb-2">فونت فارسی</label>
                        <select id="theme-font-family" onchange="themeSelectChange('font_family', this.value)"
                                class="w-full bg-border border border-border/80 rounded-lg p-2.5 text-sm text-text-main outline-none focus:border-primary transition-colors appearance-none">
                            <option value="IRANYekanX">IRANYekanX (پیش‌فرض)</option>
                            <option value="Vazirmatn">وزیرمتن (Vazirmatn)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-text-muted mb-2">فونت اعداد و LTR</label>
                        <select id="theme-font-english" onchange="themeSelectChange('font_english', this.value)"
                                class="w-full bg-border border border-border/80 rounded-lg p-2.5 text-sm text-text-main outline-none focus:border-primary transition-colors appearance-none" dir="ltr">
                            <option value="Inter">Inter</option>
                            <option value="Monospace">Monospace</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- ══ دکمه‌ها ════════════════════════════════════════════════ --}}
            <div class="bg-surface border border-border rounded-card overflow-hidden">
                <div class="px-5 py-4 border-b border-border">
                    <h2 class="font-bold text-text-main text-sm">دکمه‌ها</h2>
                </div>
                <div class="p-5">
                    <p class="text-xs text-text-muted mb-4">انحنای دکمه (Button Radius)</p>
                    <div class="grid grid-cols-3 gap-3" id="theme-btn-radius-group">
                        <button onclick="themeSetRadius('radius_btn', 4, this)" data-rg="btn"
                                class="theme-rg-btn bg-border border border-border hover:border-primary rounded-xl p-3 flex flex-col items-center gap-2 transition-colors">
                            <div class="w-12 h-6 bg-primary rounded-sm"></div>
                            <span class="text-xs text-text-main">Sharp (4px)</span>
                        </button>
                        <button onclick="themeSetRadius('radius_btn', 8, this)" data-rg="btn"
                                class="theme-rg-btn bg-border border border-primary bg-primary/10 rounded-xl p-3 flex flex-col items-center gap-2 transition-colors">
                            <div class="w-12 h-6 bg-primary rounded-md"></div>
                            <span class="text-xs text-text-main">Normal (8px)</span>
                        </button>
                        <button onclick="themeSetRadius('radius_btn', 9999, this)" data-rg="btn"
                                class="theme-rg-btn bg-border border border-border hover:border-primary rounded-xl p-3 flex flex-col items-center gap-2 transition-colors">
                            <div class="w-12 h-6 bg-primary rounded-full"></div>
                            <span class="text-xs text-text-main">Pill</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- ══ کارت‌ها ════════════════════════════════════════════════ --}}
            <div class="bg-surface border border-border rounded-card overflow-hidden">
                <div class="px-5 py-4 border-b border-border">
                    <h2 class="font-bold text-text-main text-sm">کارت‌ها و فرم‌ها</h2>
                </div>
                <div class="p-5">
                    <p class="text-xs text-text-muted mb-4">انحنای کارت (Card Radius)</p>
                    <div class="grid grid-cols-3 gap-3">
                        <button onclick="themeSetRadius('radius_card', 8, this)" data-rg="card"
                                class="theme-rg-card bg-border border border-border hover:border-primary rounded-xl p-3 flex flex-col items-center gap-2 transition-colors">
                            <div class="w-16 h-10 bg-border/80 border border-border rounded-md"></div>
                            <span class="text-xs text-text-main">Compact (8px)</span>
                        </button>
                        <button onclick="themeSetRadius('radius_card', 16, this)" data-rg="card"
                                class="theme-rg-card bg-border border border-primary bg-primary/10 rounded-xl p-3 flex flex-col items-center gap-2 transition-colors">
                            <div class="w-16 h-10 bg-border/80 border border-border rounded-card"></div>
                            <span class="text-xs text-text-main">Normal (16px)</span>
                        </button>
                        <button onclick="themeSetRadius('radius_card', 24, this)" data-rg="card"
                                class="theme-rg-card bg-border border border-border hover:border-primary rounded-xl p-3 flex flex-col items-center gap-2 transition-colors">
                            <div class="w-16 h-10 bg-border/80 border border-border rounded-[1.5rem]"></div>
                            <span class="text-xs text-text-main">Rounded (24px)</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- ══ بج‌ها ═══════════════════════════════════════════════════ --}}
            <div class="bg-surface border border-border rounded-card overflow-hidden">
                <div class="px-5 py-4 border-b border-border">
                    <h2 class="font-bold text-text-main text-sm">وضعیت‌ها (Badges)</h2>
                </div>
                <div class="p-5">
                    <p class="text-xs text-text-muted mb-4">انحنای بج (Badge Radius)</p>
                    <div class="grid grid-cols-3 gap-3">
                        <button onclick="themeSetRadius('radius_badge', 4, this)" data-rg="badge"
                                class="theme-rg-badge bg-border border border-border hover:border-primary rounded-xl p-3 flex flex-col items-center gap-2 transition-colors">
                            <div class="w-12 h-6 bg-success/20 border border-success/30 rounded-sm"></div>
                            <span class="text-xs text-text-main">Sharp</span>
                        </button>
                        <button onclick="themeSetRadius('radius_badge', 8, this)" data-rg="badge"
                                class="theme-rg-badge bg-border border border-border hover:border-primary rounded-xl p-3 flex flex-col items-center gap-2 transition-colors">
                            <div class="w-12 h-6 bg-success/20 border border-success/30 rounded-md"></div>
                            <span class="text-xs text-text-main">Normal</span>
                        </button>
                        <button onclick="themeSetRadius('radius_badge', 9999, this)" data-rg="badge"
                                class="theme-rg-badge bg-border border border-primary bg-primary/10 rounded-xl p-3 flex flex-col items-center gap-2 transition-colors">
                            <div class="w-12 h-6 bg-success/20 border border-success/30 rounded-full"></div>
                            <span class="text-xs text-text-main">Pill</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- ══ مودال ═════════════════════════════════════════════════ --}}
            <div class="bg-surface border border-border rounded-card overflow-hidden">
                <div class="px-5 py-4 border-b border-border flex items-center justify-between">
                    <h2 class="font-bold text-text-main text-sm">مودال و کشو</h2>
                    <button onclick="themeTogglePreviewModal()"
                            class="text-xs bg-primary text-white px-3 py-1.5 rounded-lg hover:bg-primary/80 transition-colors">
                        نمایش مودال در Preview
                    </button>
                </div>
                <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-text-muted mb-2">شدت تار شدن (Blur)</label>
                        <input type="range" id="theme-modal-blur" min="0" max="20" value="8"
                               class="w-full accent-primary"
                               oninput="themeRangeChange('modal_blur', this.value, '--modal-blur', 'px', 'theme-modal-blur-val')">
                        <span id="theme-modal-blur-val" class="text-xs text-text-muted mt-1 block">8px</span>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-text-muted mb-2">تیرگی پس‌زمینه (%)</label>
                        <input type="range" id="theme-modal-overlay" min="0" max="100" value="60"
                               class="w-full accent-primary"
                               oninput="themeRangeChange('modal_overlay', this.value, null, null, 'theme-modal-overlay-val')">
                        <span id="theme-modal-overlay-val" class="text-xs text-text-muted mt-1 block">60%</span>
                    </div>
                </div>
            </div>

            {{-- ══ جداول ═════════════════════════════════════════════════ --}}
            <div class="bg-surface border border-border rounded-card overflow-hidden">
                <div class="px-5 py-4 border-b border-border">
                    <h2 class="font-bold text-text-main text-sm">جداول و لیست‌ها</h2>
                </div>
                <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-text-muted mb-2">هاور ردیف جدول</label>
                        <select id="theme-table-row-hover" onchange="themeSelectChange('table_row_hover', this.value)"
                                class="w-full bg-border border border-border/80 rounded-lg p-2.5 text-sm text-text-main outline-none focus:border-primary transition-colors appearance-none">
                            <option value="light_highlight">هایلایت روشن</option>
                            <option value="primary_tint">رنگ اصلی کم‌رنگ</option>
                            <option value="none">بدون تغییر</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- ══ مدیریت لوگو و تصاویر برند ══════════════════════════════ --}}
            <div class="bg-surface border border-border rounded-card overflow-hidden">
                <div class="px-5 py-4 border-b border-border">
                    <h2 class="font-bold text-text-main text-sm">مدیریت لوگو و تصاویر برند</h2>
                </div>
                <div class="p-5 grid grid-cols-2 sm:grid-cols-3 gap-4" id="logo-slots-container">
                    @foreach([
                        ['logo_main',       'لوگو اصلی',       'fa-image',   'PNG/JPG/WEBP'],
                        ['logo_dark',       'لوگو تاریک',      'fa-moon',    'برای پس‌زمینه تیره'],
                        ['logo_light',      'لوگو روشن',       'fa-sun',     'برای پس‌زمینه روشن'],
                        ['favicon',         'فاوآیکن',         'fa-star',    'ICO/PNG 32×32'],
                        ['brand_mark',      'نشان برند',       'fa-bolt',    'آیکن مربع کوچک'],
                        ['default_avatar',  'آواتار پیش‌فرض', 'fa-user',    'PNG/JPG مربع'],
                    ] as [$slot, $label, $icon, $hint])
                    <div class="flex flex-col gap-2">
                        <label class="text-[11px] font-bold text-text-muted">{{ $label }}</label>
                        <div class="relative group">
                            <div id="logo-preview-{{ $slot }}"
                                 class="w-full h-16 bg-border/50 border border-border rounded-xl flex flex-col items-center justify-center gap-1 overflow-hidden transition-colors">
                                <i class="fa-solid {{ $icon }} text-text-muted/60 text-xl logo-placeholder-icon-{{ $slot }}"></i>
                                <span class="text-[9px] text-text-muted/60 logo-placeholder-hint-{{ $slot }}">{{ $hint }}</span>
                                <img id="logo-img-{{ $slot }}" class="hidden w-full h-full object-contain p-1" alt="{{ $label }}">
                            </div>
                            <label for="logo-file-{{ $slot }}"
                                   class="absolute inset-0 cursor-pointer rounded-xl opacity-0 group-hover:opacity-100 bg-bg/70 flex items-center justify-center transition-all">
                                <span class="text-[10px] font-bold text-text-main bg-border px-2 py-1 rounded-lg">
                                    <i class="fa-solid fa-arrow-up-from-bracket ml-1 text-xs"></i>آپلود
                                </span>
                            </label>
                            <input type="file" id="logo-file-{{ $slot }}" accept="image/png,image/jpeg,image/webp,image/gif,image/x-icon"
                                   class="hidden" onchange="logoUpload('{{ $slot }}', this)">
                        </div>
                        <div id="logo-status-{{ $slot }}" class="text-[10px] text-text-muted/60 truncate font-mono">—</div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- ── پیش‌نمایش زنده (col 5 sticky) ─────────────────────────── --}}
        <div class="xl:col-span-5">
            <div class="bg-surface border border-border rounded-card overflow-hidden xl:sticky xl:top-4 xl:max-h-[calc(100vh-7rem)]">
                <div class="px-5 py-4 border-b border-border flex items-center gap-2.5">
                    <i class="fa-solid fa-eye text-text-muted text-sm"></i>
                    <h2 class="font-bold text-text-main text-sm">پیش‌نمایش زنده</h2>
                </div>

                {{-- Preview canvas --}}
                <div class="xl:overflow-y-auto xl:max-h-[calc(100vh-12rem)] hide-scrollbar">
                <div id="theme-preview-canvas"
                     class="p-4 flex flex-col gap-4"
                     style="
                         background-color: var(--pv-bg, #020617);
                         font-family: var(--font-family);
                         --pv-primary:       #315A3A;
                         --pv-secondary:     #A8794A;
                         --pv-accent:        #C9A66B;
                         --pv-success:       #10B981;
                         --pv-warning:       #F59E0B;
                         --pv-danger:        #EF4444;
                         --pv-info:          #3B82F6;
                         --pv-bg:            #020617;
                         --pv-surface:       #0f172a;
                         --pv-border:        #1e293b;
                         --pv-text-main:     #e2e8f0;
                         --pv-text-muted:    #64748b;
                         --pv-radius-btn:    0.5rem;
                         --pv-radius-card:   1rem;
                         --pv-radius-badge:  9999px;
                         --pv-radius-modal:  1.5rem;">

                    {{-- Badges --}}
                    <div>
                        <div class="text-[10px] font-bold mb-2" style="color:var(--pv-text-muted)">BADGES / STATUSES</div>
                        <div class="flex flex-wrap gap-1.5">
                            <span class="px-2.5 py-0.5 text-xs font-bold" style="background:color-mix(in srgb,var(--pv-success) 15%,transparent);color:var(--pv-success);border:1px solid color-mix(in srgb,var(--pv-success) 30%,transparent);border-radius:var(--pv-radius-badge)">متصل</span>
                            <span class="px-2.5 py-0.5 text-xs font-bold" style="background:color-mix(in srgb,var(--pv-warning) 15%,transparent);color:var(--pv-warning);border:1px solid color-mix(in srgb,var(--pv-warning) 30%,transparent);border-radius:var(--pv-radius-badge)">در انتظار</span>
                            <span class="px-2.5 py-0.5 text-xs font-bold" style="background:color-mix(in srgb,var(--pv-danger) 15%,transparent);color:var(--pv-danger);border:1px solid color-mix(in srgb,var(--pv-danger) 30%,transparent);border-radius:var(--pv-radius-badge)">خطا</span>
                            <span class="px-2.5 py-0.5 text-xs font-bold" style="background:color-mix(in srgb,var(--pv-info) 15%,transparent);color:var(--pv-info);border:1px solid color-mix(in srgb,var(--pv-info) 30%,transparent);border-radius:var(--pv-radius-badge)">منتشر شده</span>
                            <span class="px-2.5 py-0.5 text-xs font-bold" style="background:var(--pv-border);color:var(--pv-text-muted);border:1px solid var(--pv-border);border-radius:var(--pv-radius-badge)">پیش‌نویس</span>
                        </div>
                    </div>

                    {{-- Empty state card --}}
                    <div class="flex flex-col items-center justify-center py-6"
                         style="background:var(--pv-surface);border:1px solid var(--pv-border);border-radius:var(--pv-radius-card)">
                        <div class="w-12 h-12 mb-3 flex items-center justify-center" style="background:var(--pv-border);border-radius:calc(var(--pv-radius-card)*0.6);border:1px dashed color-mix(in srgb,var(--pv-border) 60%,transparent)">
                            <i class="fa-solid fa-inbox text-lg" style="color:var(--pv-text-muted)"></i>
                        </div>
                        <p class="text-sm font-bold" style="color:var(--pv-text-muted)">هیچ داده‌ای یافت نشد</p>
                        <p class="text-xs mt-0.5" style="color:color-mix(in srgb,var(--pv-text-muted) 70%,transparent)">برای شروع یک مورد جدید اضافه کنید.</p>
                    </div>

                    {{-- Inputs --}}
                    <div style="background:var(--pv-surface);border:1px solid var(--pv-border);border-radius:var(--pv-radius-card);padding:0.75rem">
                        <div class="text-xs font-bold mb-3" style="color:var(--pv-text-main)">ورودی‌ها (Input States)</div>
                        <div class="flex flex-col gap-2">
                            <input type="text" placeholder="حالت عادی (Normal)" readonly
                                   style="background:var(--pv-bg);border:1px solid var(--pv-border);border-radius:calc(var(--pv-radius-card)*0.5);padding:0.5rem 0.625rem;font-size:0.75rem;color:var(--pv-text-main);outline:none;width:100%">
                            <input type="text" placeholder="حالت فوکوس" readonly
                                   style="background:var(--pv-bg);border:1px solid var(--pv-primary);box-shadow:0 0 0 1px var(--pv-primary);border-radius:calc(var(--pv-radius-card)*0.5);padding:0.5rem 0.625rem;font-size:0.75rem;color:var(--pv-text-main);outline:none;width:100%">
                            <input type="text" value="ورودی نامعتبر" readonly
                                   style="background:color-mix(in srgb,var(--pv-danger) 5%,transparent);border:1px solid var(--pv-danger);border-radius:calc(var(--pv-radius-card)*0.5);padding:0.5rem 0.625rem;font-size:0.75rem;color:var(--pv-danger);outline:none;width:100%">
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div style="background:var(--pv-surface);border:1px solid var(--pv-border);border-radius:var(--pv-radius-card);padding:0.75rem">
                        <div class="text-xs font-bold mb-3" style="color:var(--pv-text-main)">دکمه‌ها (Button States)</div>
                        <div class="flex flex-wrap gap-2">
                            <button style="background:var(--pv-primary);color:#fff;border:none;border-radius:var(--pv-radius-btn);padding:0.4rem 0.75rem;font-size:0.7rem;font-weight:700;cursor:pointer">عادی</button>
                            <button style="background:color-mix(in srgb,var(--pv-primary) 80%,transparent);color:#fff;border:none;border-radius:var(--pv-radius-btn);padding:0.4rem 0.75rem;font-size:0.7rem;font-weight:700;cursor:pointer;opacity:0.85">هاور</button>
                            <button style="background:var(--pv-primary);color:#fff;border:none;border-radius:var(--pv-radius-btn);padding:0.4rem 0.75rem;font-size:0.7rem;font-weight:700;cursor:not-allowed;opacity:0.4">غیرفعال</button>
                            <button style="background:transparent;color:var(--pv-text-main);border:1px solid var(--pv-border);border-radius:var(--pv-radius-btn);padding:0.4rem 0.75rem;font-size:0.7rem;font-weight:700;cursor:pointer">ثانویه</button>
                            <button style="background:color-mix(in srgb,var(--pv-danger) 10%,transparent);color:var(--pv-danger);border:1px solid color-mix(in srgb,var(--pv-danger) 30%,transparent);border-radius:var(--pv-radius-btn);padding:0.4rem 0.75rem;font-size:0.7rem;font-weight:700;cursor:pointer">حذف</button>
                        </div>
                    </div>

                    {{-- Table --}}
                    <div style="background:var(--pv-surface);border:1px solid var(--pv-border);border-radius:var(--pv-radius-card);overflow:hidden">
                        <table style="width:100%;font-size:0.7rem;text-align:right;border-collapse:collapse">
                            <thead>
                                <tr style="background:var(--pv-surface);border-bottom:1px solid var(--pv-border)">
                                    <th style="padding:0.5rem 0.75rem;color:var(--pv-text-muted);font-weight:700">کاربر</th>
                                    <th style="padding:0.5rem 0.75rem;color:var(--pv-text-muted);font-weight:700">وضعیت</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="pv-hover-row" style="border-bottom:1px solid var(--pv-border);background:var(--table-row-hover,rgba(255,255,255,0.05))">
                                    <td style="padding:0.5rem 0.75rem;color:var(--pv-text-main)">علی محمدی (Hover)</td>
                                    <td style="padding:0.5rem 0.75rem;color:var(--pv-success)">فعال</td>
                                </tr>
                                <tr>
                                    <td style="padding:0.5rem 0.75rem;color:var(--pv-text-main)">مریم احمدی</td>
                                    <td style="padding:0.5rem 0.75rem;color:var(--pv-text-muted)">غیرفعال</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Modal preview (hidden by default) --}}
                    <div id="pv-modal" class="hidden" style="position:relative;overflow:hidden;border-radius:var(--pv-radius-card)">
                        <div style="position:absolute;inset:0;background:var(--modal-overlay,rgba(0,0,0,0.6));backdrop-filter:blur(var(--modal-blur,8px))"></div>
                        <div style="position:relative;margin:1rem;background:var(--pv-surface);border:1px solid var(--pv-border);border-radius:var(--pv-radius-modal);overflow:hidden">
                            <div style="padding:0.75rem 1rem;border-bottom:1px solid var(--pv-border);display:flex;justify-content:space-between;align-items:center">
                                <span style="font-size:0.75rem;font-weight:700;color:var(--pv-text-main)">تنظیمات پیشرفته</span>
                                <button onclick="themeTogglePreviewModal()" style="background:none;border:none;color:var(--pv-text-muted);cursor:pointer;font-size:0.75rem">✕</button>
                            </div>
                            <div style="padding:0.75rem 1rem">
                                <p style="font-size:0.7rem;color:var(--pv-text-muted);line-height:1.5">این نمونه مودال است. گوشه‌ها و بلر از تنظیمات کنترل می‌شوند.</p>
                            </div>
                            <div style="padding:0.6rem 1rem;background:var(--pv-bg);border-top:1px solid var(--pv-border);display:flex;justify-content:flex-end;gap:0.5rem">
                                <button style="background:transparent;color:var(--pv-text-main);border:1px solid var(--pv-border);border-radius:var(--pv-radius-btn);padding:0.3rem 0.75rem;font-size:0.7rem;font-weight:700;cursor:pointer">بستن</button>
                                <button style="background:var(--pv-primary);color:#fff;border:none;border-radius:var(--pv-radius-btn);padding:0.3rem 0.75rem;font-size:0.7rem;font-weight:700;cursor:pointer">تایید</button>
                            </div>
                        </div>
                    </div>

                </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ── Custom Color Picker Panel ─────────────────────────────────────────── --}}
<style>
/* Palette tab token-based styling */
.palette-tab { color: var(--color-text-muted); }
.palette-tab:hover { color: var(--color-text-main); }
.palette-tab.active { background: var(--color-surface); color: var(--color-text-main); box-shadow: 0 1px 3px rgba(0,0,0,0.2); }
/* Hue slider thumb */
#ccp-hue-range { -webkit-appearance:none; appearance:none; height:10px; border-radius:9999px; outline:none; border:none; cursor:pointer; background: linear-gradient(to right,#f00 0%,#ff0 17%,#0f0 33%,#0ff 50%,#00f 67%,#f0f 83%,#f00 100%); }
#ccp-hue-range::-webkit-slider-thumb { -webkit-appearance:none; width:16px; height:16px; border-radius:50%; background:#fff; border:2px solid rgba(0,0,0,0.3); box-shadow:0 1px 4px rgba(0,0,0,0.4); cursor:pointer; }
#ccp-hue-range::-moz-range-thumb { width:16px; height:16px; border-radius:50%; background:#fff; border:2px solid rgba(0,0,0,0.3); box-shadow:0 1px 4px rgba(0,0,0,0.4); cursor:pointer; }
</style>

<div id="ccp" style="display:none;position:fixed;z-index:9999;width:280px;
    background:var(--color-surface);border:1px solid var(--color-border);
    border-radius:var(--radius-card,1rem);
    box-shadow:0 24px 60px rgba(0,0,0,0.5),0 4px 16px rgba(0,0,0,0.3);
    font-family:var(--font-family,'IRANYekanX',sans-serif);overflow:hidden;
    user-select:none;">

    {{-- Gradient field (HSV) --}}
    <div id="ccp-field" onpointerdown="ccpFieldDown(event)" style="
        position:relative;height:148px;cursor:crosshair;flex-shrink:0;
        --ccp-h:120;
        background:linear-gradient(to bottom,transparent,#000),linear-gradient(to right,#fff,transparent),hsl(var(--ccp-h,120),100%,50%)">
        <div id="ccp-cursor" style="
            position:absolute;width:14px;height:14px;border-radius:50%;
            border:2px solid #fff;box-shadow:0 0 0 1px rgba(0,0,0,0.5);
            transform:translate(-50%,-50%);pointer-events:none;
            left:100%;top:0%"></div>
    </div>

    {{-- Hue row --}}
    <div style="padding:0.6rem 0.75rem 0.4rem;display:flex;align-items:center;gap:0.6rem">
        <div id="ccp-preview-swatch" style="
            width:2.25rem;height:2.25rem;border-radius:var(--radius-btn,0.5rem);flex-shrink:0;
            border:1px solid var(--color-border);background:#315A3A"></div>
        <input id="ccp-hue-range" type="range" min="0" max="359" step="1" value="120"
               style="flex:1" oninput="ccpHueMove(this.value)">
    </div>

    {{-- HEX + RGB --}}
    <div style="padding:0 0.75rem 0.6rem;display:flex;gap:0.5rem;align-items:flex-end">
        <div style="flex:1;display:flex;flex-direction:column;gap:0.2rem">
            <label style="font-size:0.55rem;font-weight:700;color:var(--color-text-muted);letter-spacing:.06em;text-transform:uppercase">HEX</label>
            <input id="ccp-hex-in" type="text" dir="ltr" maxlength="7" spellcheck="false"
                   style="width:100%;background:var(--color-bg);border:1px solid var(--color-border);
                          border-radius:var(--radius-btn,0.5rem);padding:0.35rem 0.5rem;
                          font-size:0.7rem;font-family:monospace;color:var(--color-text-main);outline:none"
                   oninput="ccpHexTyped(this.value)" onfocus="this.select()">
        </div>
        @foreach([['R','r'],['G','g'],['B','b']] as [$ch,$id])
        <div style="width:2.6rem;display:flex;flex-direction:column;gap:0.2rem;align-items:center">
            <label style="font-size:0.55rem;font-weight:700;color:var(--color-text-muted);letter-spacing:.06em;text-transform:uppercase">{{ $ch }}</label>
            <input id="ccp-{{ $id }}-in" type="number" dir="ltr" min="0" max="255"
                   style="width:100%;background:var(--color-bg);border:1px solid var(--color-border);
                          border-radius:var(--radius-btn,0.5rem);padding:0.35rem 0.2rem;
                          font-size:0.68rem;font-family:monospace;color:var(--color-text-main);
                          outline:none;text-align:center"
                   oninput="ccpRgbTyped()">
        </div>
        @endforeach
    </div>

    {{-- Presets --}}
    <div style="padding:0 0.75rem 0.6rem">
        <label style="font-size:0.55rem;font-weight:700;color:var(--color-text-muted);
                      letter-spacing:.06em;text-transform:uppercase;display:block;margin-bottom:0.35rem">رنگ‌های پیش‌فرض</label>
        <div id="ccp-presets" style="display:flex;flex-wrap:wrap;gap:0.3rem"></div>
    </div>

    {{-- Footer --}}
    <div style="padding:0.5rem 0.75rem;border-top:1px solid var(--color-border);
                display:flex;gap:0.4rem;align-items:center">
        <button id="ccp-btn-default" onclick="ccpDefault()"
                title="بازگشت به مقدار پیش‌فرض"
                style="padding:0.3rem 0.5rem;font-size:0.65rem;font-weight:700;
                       background:transparent;color:var(--color-text-muted);
                       border:1px solid var(--color-border);border-radius:var(--radius-btn,0.5rem);
                       cursor:pointer;display:flex;align-items:center;gap:0.25rem;white-space:nowrap">
            <i class="fa-solid fa-rotate-left" style="font-size:0.6rem"></i>
            <span id="ccp-default-label" dir="ltr" style="font-family:monospace;font-size:0.6rem"></span>
        </button>
        <div style="flex:1"></div>
        <button onclick="ccpCancel()"
                style="padding:0.3rem 0.65rem;font-size:0.7rem;font-weight:700;
                       background:var(--color-border);color:var(--color-text-main);
                       border:none;border-radius:var(--radius-btn,0.5rem);cursor:pointer">انصراف</button>
        <button onclick="ccpConfirm()"
                style="padding:0.3rem 0.65rem;font-size:0.7rem;font-weight:700;
                       background:var(--color-primary,#315A3A);color:#fff;
                       border:none;border-radius:var(--radius-btn,0.5rem);cursor:pointer">تأیید</button>
    </div>
</div>

<script>
(function () {

/* ── DEFAULTS ───────────────────────────────────────────────────────────── */
const D = {
    primary:'#315A3A', secondary:'#A8794A', accent:'#C9A66B',
    success:'#10B981', warning:'#F59E0B', danger:'#EF4444', info:'#3B82F6',
    dark_bg:'#020617', dark_surface:'#0f172a', dark_border:'#1e293b',
    dark_text_main:'#e2e8f0', dark_text_muted:'#64748b',
    dark_sidebar:'#0f172a', dark_header:'#020617',
    light_bg:'#f4f4f5', light_surface:'#ffffff', light_border:'#e4e4e7',
    light_text_main:'#374151', light_text_muted:'#71717a',
    light_sidebar:'#ffffff', light_header:'#f4f4f5',
    radius_btn:8, radius_card:16, radius_modal:24, radius_badge:9999,
    modal_blur:8, modal_overlay:60,
    font_family:'IRANYekanX', font_english:'Inter',
    table_row_hover:'light_highlight',
};

/* in-memory state */
const S = Object.assign({}, D);

/* ── PREVIEW VARIABLE MAP ───────────────────────────────────────────────── */
let activePalette = 'dark';

const PV_SEMANTIC = {
    primary:'--pv-primary', secondary:'--pv-secondary', accent:'--pv-accent',
    success:'--pv-success', warning:'--pv-warning', danger:'--pv-danger', info:'--pv-info',
};
const PV_DARK  = { dark_bg:'--pv-bg', dark_surface:'--pv-surface', dark_border:'--pv-border', dark_text_main:'--pv-text-main', dark_text_muted:'--pv-text-muted' };
const PV_LIGHT = { light_bg:'--pv-bg', light_surface:'--pv-surface', light_border:'--pv-border', light_text_main:'--pv-text-main', light_text_muted:'--pv-text-muted' };

function pv() { return document.getElementById('theme-preview-canvas'); }

function setPvVar(key, val) {
    let pvVar = PV_SEMANTIC[key];
    if (!pvVar) pvVar = activePalette === 'dark' ? PV_DARK[key] : PV_LIGHT[key];
    if (pvVar && pv()) pv().style.setProperty(pvVar, val);
}

/* ── COLOR CONVERSION ───────────────────────────────────────────────────── */
function hexToRgb(hex) {
    const m = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return m ? { r:parseInt(m[1],16), g:parseInt(m[2],16), b:parseInt(m[3],16) } : null;
}
function rgbToHex(r,g,b) {
    return '#' + [r,g,b].map(x => Math.max(0,Math.min(255,Math.round(x))).toString(16).padStart(2,'0')).join('');
}
function rgbToHsv(r,g,b) {
    r/=255; g/=255; b/=255;
    const max=Math.max(r,g,b), min=Math.min(r,g,b), d=max-min;
    let h=0;
    if (d!==0) {
        if (max===r)      h=(((g-b)/d)%6+6)%6;
        else if (max===g) h=(b-r)/d+2;
        else              h=(r-g)/d+4;
        h*=60;
    }
    return { h, s: max===0?0:d/max, v:max };
}
function hsvToRgb(h,s,v) {
    const c=v*s, x=c*(1-Math.abs((h/60)%2-1)), m=v-c;
    let r=0,g=0,b=0;
    if      (h<60)  { r=c;g=x; } else if (h<120) { r=x;g=c; }
    else if (h<180) { g=c;b=x; } else if (h<240) { g=x;b=c; }
    else if (h<300) { r=x;b=c; } else             { r=c;b=x; }
    return { r:Math.round((r+m)*255), g:Math.round((g+m)*255), b:Math.round((b+m)*255) };
}

/* ── CUSTOM COLOR PICKER (CCP) ──────────────────────────────────────────── */
const CCP = { key:null, orig:null, h:0, s:1, v:1, dragging:false };

function ccpStoreKey(key) {
    // 'l_light_bg' → 'light_light_bg' would be wrong; l_ prefix maps raw key directly
    // dark palette keys: 'primary', 'dark_bg' → stored as-is
    // light palette keys: 'l_light_bg' → stored as 'light_bg', 'l_primary' → 'primary'
    if (key.startsWith('l_')) return key.slice(2);
    return key;
}

function ccpSyncUI() {
    const rgb = hsvToRgb(CCP.h, CCP.s, CCP.v);
    const hex = rgbToHex(rgb.r, rgb.g, rgb.b);
    const hi  = document.getElementById('ccp-hex-in');
    const ri  = document.getElementById('ccp-r-in');
    const gi  = document.getElementById('ccp-g-in');
    const bi  = document.getElementById('ccp-b-in');
    if (hi) hi.value = hex;
    if (ri) ri.value = rgb.r;
    if (gi) gi.value = rgb.g;
    if (bi) bi.value = rgb.b;
    const sw = document.getElementById('ccp-preview-swatch');
    if (sw) sw.style.background = hex;
    const field = document.getElementById('ccp-field');
    if (field) field.style.setProperty('--ccp-h', CCP.h);
    const cursor = document.getElementById('ccp-cursor');
    if (cursor) { cursor.style.left = (CCP.s*100)+'%'; cursor.style.top = ((1-CCP.v)*100)+'%'; }
    const hs = document.getElementById('ccp-hue-range');
    if (hs) hs.value = Math.round(CCP.h);
    return hex;
}

function ccpLiveApply() {
    const hex = ccpSyncUI();
    if (CCP.key) themePickerChange(CCP.key, hex);
}

window.ccpOpen = function(key, triggerEl) {
    CCP.key  = key;
    CCP.orig = S[ccpStoreKey(key)] || D[ccpStoreKey(key)] || '#315A3A';
    const rgb = hexToRgb(CCP.orig);
    if (rgb) { const hsv=rgbToHsv(rgb.r,rgb.g,rgb.b); CCP.h=hsv.h; CCP.s=hsv.s; CCP.v=hsv.v; }
    ccpSyncUI();
    ccpBuildPresets();

    const defVal = D[ccpStoreKey(key)] || null;
    const defBtn = document.getElementById('ccp-btn-default');
    const defLbl = document.getElementById('ccp-default-label');
    if (defBtn) defBtn.style.display = defVal ? '' : 'none';
    if (defLbl) defLbl.textContent = defVal || '';

    const ccp  = document.getElementById('ccp');
    ccp.style.display = 'block';

    const rect = triggerEl.getBoundingClientRect();
    const W=280, H=ccp.offsetHeight||400;
    let left = rect.right + 10;
    let top  = rect.top;
    if (left + W > window.innerWidth - 8)  left = rect.left - W - 10;
    if (top  + H > window.innerHeight - 8) top  = window.innerHeight - H - 8;
    if (left < 8) left = 8;
    if (top  < 8) top  = 8;
    ccp.style.left = left + 'px';
    ccp.style.top  = top  + 'px';
};

window.ccpClose = function() {
    const ccp = document.getElementById('ccp');
    if (ccp) ccp.style.display = 'none';
    CCP.key = null;
};

window.ccpConfirm = function() {
    const hex = document.getElementById('ccp-hex-in')?.value || '';
    if (/^#[0-9A-Fa-f]{6}$/.test(hex) && CCP.key) themePickerChange(CCP.key, hex);
    ccpClose();
};

window.ccpCancel = function() {
    if (CCP.key && CCP.orig) themePickerChange(CCP.key, CCP.orig);
    ccpClose();
};

window.ccpDefault = function() {
    const defVal = D[ccpStoreKey(CCP.key)];
    if (!defVal) return;
    const rgb = hexToRgb(defVal);
    if (rgb) { const hsv=rgbToHsv(rgb.r,rgb.g,rgb.b); CCP.h=hsv.h; CCP.s=hsv.s; CCP.v=hsv.v; }
    ccpLiveApply();
};

window.ccpHueMove = function(val) {
    CCP.h = parseFloat(val);
    ccpLiveApply();
};

window.ccpHexTyped = function(val) {
    const hex = val.startsWith('#') ? val : '#'+val;
    if (!/^#[0-9A-Fa-f]{6}$/.test(hex)) return;
    const rgb = hexToRgb(hex);
    if (!rgb) return;
    const hsv = rgbToHsv(rgb.r, rgb.g, rgb.b);
    CCP.h=hsv.h; CCP.s=hsv.s; CCP.v=hsv.v;
    ccpLiveApply();
};

window.ccpRgbTyped = function() {
    const r=parseInt(document.getElementById('ccp-r-in')?.value)||0;
    const g=parseInt(document.getElementById('ccp-g-in')?.value)||0;
    const b=parseInt(document.getElementById('ccp-b-in')?.value)||0;
    const hsv=rgbToHsv(r,g,b);
    CCP.h=hsv.h; CCP.s=hsv.s; CCP.v=hsv.v;
    ccpLiveApply();
};

window.ccpFieldDown = function(e) {
    CCP.dragging=true;
    ccpFieldUpdate(e);
    e.preventDefault();
};

function ccpFieldUpdate(e) {
    const field = document.getElementById('ccp-field');
    if (!field) return;
    const rect = field.getBoundingClientRect();
    CCP.s = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
    CCP.v = 1 - Math.max(0, Math.min(1, (e.clientY - rect.top) / rect.height));
    ccpLiveApply();
}

document.addEventListener('pointermove', e => { if (CCP.dragging) ccpFieldUpdate(e); });
document.addEventListener('pointerup',   () => { CCP.dragging = false; });
document.addEventListener('pointerdown', e => {
    const ccp = document.getElementById('ccp');
    if (ccp && ccp.style.display !== 'none' && !ccp.contains(e.target) && !e.target.closest('.color-card')) {
        ccpClose();
    }
});

function ccpBuildPresets() {
    const c = document.getElementById('ccp-presets');
    if (!c) return;
    c.innerHTML = '';
    const colors = [D.primary,D.secondary,D.accent,D.success,D.warning,D.danger,D.info,
                    '#ffffff','#f1f5f9','#94a3b8','#475569','#1e293b','#0f172a','#020617'];
    colors.forEach(col => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.title = col;
        btn.style.cssText = `width:1.4rem;height:1.4rem;border-radius:var(--radius-btn,0.5rem);background:${col};border:2px solid transparent;cursor:pointer;transition:transform .1s,border-color .1s;flex-shrink:0`;
        btn.onmouseenter = () => btn.style.borderColor = 'var(--color-text-muted)';
        btn.onmouseleave = () => btn.style.borderColor = 'transparent';
        btn.onclick = () => {
            const rgb=hexToRgb(col);
            if (!rgb) return;
            const hsv=rgbToHsv(rgb.r,rgb.g,rgb.b);
            CCP.h=hsv.h; CCP.s=hsv.s; CCP.v=hsv.v;
            ccpLiveApply();
        };
        c.appendChild(btn);
    });
}

/* ── CONTRAST CHECK ─────────────────────────────────────────────────────── */
function luminance(hex) {
    const r = parseInt(hex.slice(1,3),16)/255;
    const g = parseInt(hex.slice(3,5),16)/255;
    const b = parseInt(hex.slice(5,7),16)/255;
    const toLinear = v => v <= 0.03928 ? v/12.92 : Math.pow((v+0.055)/1.055, 2.4);
    return 0.2126*toLinear(r) + 0.7152*toLinear(g) + 0.0722*toLinear(b);
}
function checkContrast(hex1, hex2) {
    const l1 = luminance(hex1); const l2 = luminance(hex2);
    const hi = Math.max(l1,l2); const lo = Math.min(l1,l2);
    return (hi+0.05)/(lo+0.05);
}

/* ── COLOR PICKER CHANGE ────────────────────────────────────────────────── */
window.themePickerChange = function(key, val) {
    // key: 'primary' | 'dark_bg' | 'l_light_bg' | 'l_primary'
    const storeKey = ccpStoreKey(key);
    S[storeKey] = val;

    // update all swatches, hex labels, native pickers with this key
    document.querySelectorAll(`[data-swatch="${key}"]`).forEach(el => el.style.background = val);
    document.querySelectorAll(`[data-hex="${key}"]`).forEach(el => el.textContent = val.toUpperCase());
    document.querySelectorAll(`[data-picker="${key}"]`).forEach(el => el.value = val);

    // update preview var
    setPvVar(storeKey, val);

    // contrast warning for primary
    if (storeKey === 'primary') {
        const ratio = checkContrast(val, '#ffffff');
        const warn  = document.getElementById('theme-contrast-warn');
        if (warn) warn.classList.toggle('hidden', ratio >= 4.5);
    }
};

/* ── RADIUS PRESETS ─────────────────────────────────────────────────────── */
window.themeSetRadius = function(field, px, btn) {
    S[field] = px;
    // update active button
    const group = btn.dataset.rg;
    document.querySelectorAll(`.theme-rg-${group}`).forEach(b => {
        b.classList.remove('border-primary','bg-primary/10');
        b.classList.add('border-border');
    });
    btn.classList.remove('border-border');
    btn.classList.add('border-primary','bg-primary/10');
    // update preview var
    const pvVarMap = { radius_btn:'--pv-radius-btn', radius_card:'--pv-radius-card', radius_badge:'--pv-radius-badge', radius_modal:'--pv-radius-modal' };
    const pvVar = pvVarMap[field];
    if (pvVar && pv()) pv().style.setProperty(pvVar, px >= 9999 ? '9999px' : (px/16).toFixed(4)+'rem');
    // also apply to live panel immediately for instant feedback
    const cssVarMap = { radius_btn:'--radius-btn', radius_card:'--radius-card', radius_badge:'--radius-badge', radius_modal:'--radius-modal' };
    if (cssVarMap[field]) document.documentElement.style.setProperty(cssVarMap[field], px >= 9999 ? '9999px' : (px/16).toFixed(4)+'rem');
};

/* ── SELECT & RANGE CHANGES ─────────────────────────────────────────────── */
window.themeSelectChange = function(field, val) { S[field] = val; };
window.themeRangeChange = function(field, val, cssVar, unit, labelId) {
    S[field] = parseFloat(val);
    const lbl = document.getElementById(labelId);
    if (lbl) lbl.textContent = field === 'modal_overlay' ? val+'%' : val+(unit||'');
    if (cssVar) document.documentElement.style.setProperty(cssVar, val+(unit||''));
};

/* ── PALETTE TAB SWITCH ─────────────────────────────────────────────────── */
window.themeSwitchPaletteTab = function(mode) {
    activePalette = mode;
    const dark  = document.getElementById('theme-palette-dark');
    const light = document.getElementById('theme-palette-light');
    if (mode === 'dark') {
        dark.classList.remove('hidden'); light.classList.add('hidden');
    } else {
        light.classList.remove('hidden'); dark.classList.add('hidden');
    }
    // toggle tab active class
    document.querySelectorAll('.palette-tab').forEach(t => t.classList.remove('active'));
    document.getElementById('theme-tab-' + mode)?.classList.add('active');

    // update preview canvas surface vars to match the selected palette
    const surfaceMap = mode === 'dark' ? PV_DARK : PV_LIGHT;
    Object.entries(surfaceMap).forEach(([k, pvVar]) => {
        const val = S[k] || D[k];
        if (val && pv()) pv().style.setProperty(pvVar, val);
    });
    // update preview background color
    const bgKey = mode === 'dark' ? 'dark_bg' : 'light_bg';
    if (pv()) pv().style.backgroundColor = S[bgKey] || D[bgKey];
};

/* ── MODAL PREVIEW TOGGLE ───────────────────────────────────────────────── */
window.themeTogglePreviewModal = function() {
    const m = document.getElementById('pv-modal');
    if (m) m.classList.toggle('hidden');
};

/* ── APPLY THEME TO CONTROLS ────────────────────────────────────────────── */
function applyToControls(theme) {
    Object.assign(S, theme);
    // colors — use data-* selectors to handle shared tokens across both palettes
    Object.keys(D).forEach(storeKey => {
        if (typeof D[storeKey] !== 'string' || !D[storeKey].startsWith('#')) return;
        const val = S[storeKey] || D[storeKey];
        // map store key → ccp key (l_* prefix for light-specific keys)
        const isLightSpecific = storeKey.startsWith('light_');
        const ccpKey = isLightSpecific ? 'l_' + storeKey : storeKey;
        document.querySelectorAll(`[data-swatch="${ccpKey}"]`).forEach(el => el.style.background = val);
        document.querySelectorAll(`[data-hex="${ccpKey}"]`).forEach(el => el.textContent = val.toUpperCase());
        document.querySelectorAll(`[data-picker="${ccpKey}"]`).forEach(el => el.value = val);
        setPvVar(storeKey, val);
    });
    // radii
    const radiusMap = { radius_btn:'btn', radius_card:'card', radius_badge:'badge' };
    Object.entries(radiusMap).forEach(([field, rg]) => {
        const val = S[field] || D[field];
        document.querySelectorAll(`.theme-rg-${rg}`).forEach(b => {
            b.classList.remove('border-primary','bg-primary/10');
            b.classList.add('border-border');
        });
        // find the matching button by its onclick attr and mark active
        document.querySelectorAll(`[data-rg="${rg}"]`).forEach(b => {
            if (b.getAttribute('onclick')?.includes(`, ${val},`)) {
                b.classList.remove('border-border');
                b.classList.add('border-primary','bg-primary/10');
            }
        });
        const pvVarMap = { radius_btn:'--pv-radius-btn', radius_card:'--pv-radius-card', radius_badge:'--pv-radius-badge' };
        if (pvVarMap[field] && pv()) pv().style.setProperty(pvVarMap[field], val >= 9999 ? '9999px' : (val/16).toFixed(4)+'rem');
    });
    // modal sliders
    const blurSlider  = document.getElementById('theme-modal-blur');
    const overlaySlider = document.getElementById('theme-modal-overlay');
    if (blurSlider)    { blurSlider.value = S.modal_blur; document.getElementById('theme-modal-blur-val').textContent = S.modal_blur+'px'; }
    if (overlaySlider) { overlaySlider.value = S.modal_overlay; document.getElementById('theme-modal-overlay-val').textContent = S.modal_overlay+'%'; }
    // selects
    ['font_family','font_english','table_row_hover'].forEach(f => {
        const el = document.getElementById('theme-' + f.replace('_','-'));
        if (el && S[f]) el.value = S[f];
    });
}

/* ── SAVE ────────────────────────────────────────────────────────────────── */
window.themeSave = async function() {
    const btn = document.getElementById('theme-save-btn');
    if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-xs"></i>'; }
    try {
        const res  = await fetch('/settings/theme', {
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]')?.content ?? ''},
            body: JSON.stringify(S),
        });
        const data = await res.json();
        if (data.ok) {
            // Apply brand tokens live
            const st = document.getElementById('panel-theme') || (() => {
                const s = document.createElement('style'); s.id = 'panel-theme';
                document.head.appendChild(s); return s;
            })();
            const toRem = v => v >= 9999 ? '9999px' : (v/16).toFixed(4)+'rem';
            const trh   = { light_highlight:'rgba(255,255,255,0.05)', primary_tint:'color-mix(in srgb,var(--color-primary) 8%,transparent)', none:'transparent' };
            let css = `:root {\n`;
            ['primary','secondary','accent','success','warning','danger','info'].forEach(k => { if (S[k]) css += `    --color-${k}:${S[k]};\n`; });
            css += `    --radius-btn:${toRem(S.radius_btn||8)};\n`;
            css += `    --radius-card:${toRem(S.radius_card||16)};\n`;
            css += `    --radius-modal:${toRem(S.radius_modal||24)};\n`;
            css += `    --radius-badge:${toRem(S.radius_badge||9999)};\n`;
            css += `    --modal-blur:${S.modal_blur||8}px;\n`;
            css += `    --modal-overlay:rgba(0,0,0,${((S.modal_overlay||60)/100).toFixed(2)});\n`;
            css += `    --table-row-hover:${trh[S.table_row_hover]||trh.light_highlight};\n`;
            if (S.font_family === 'Vazirmatn') { css += `    --font-family:'Vazirmatn',sans-serif;\n    --font-sans:'Vazirmatn',sans-serif;\n`; }
            css += `}\nhtml.dark {\n`;
            ['bg','surface','border','text_main','text_muted','sidebar','header'].forEach(k => {
                const field = 'dark_'+k; const cssK = k.replace('_','-');
                if (S[field]) css += `    --color-${cssK}:${S[field]};\n`;
            });
            css += `}\nhtml:not(.dark) {\n`;
            ['bg','surface','border','text_main','text_muted','sidebar','header'].forEach(k => {
                const field = 'light_'+k; const cssK = k.replace('_','-');
                if (S[field]) css += `    --color-${cssK}:${S[field]};\n`;
            });
            css += `}\n`;
            st.textContent = css;
            if (btn) { btn.innerHTML = '<i class="fa-solid fa-check text-xs"></i>ذخیره شد'; }
            setTimeout(() => { if (btn) { btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-floppy-disk text-xs"></i>ذخیره طرح'; } }, 2000);
        } else {
            alert(data.message || 'خطا در ذخیره');
            if (btn) { btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-floppy-disk text-xs"></i>ذخیره طرح'; }
        }
    } catch {
        if (btn) { btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-floppy-disk text-xs"></i>ذخیره طرح'; }
    }
};

/* ── RESET ───────────────────────────────────────────────────────────────── */
window.themeReset = function() { applyToControls(D); };

/* ── LOGO UPLOAD ─────────────────────────────────────────────────────────── */
window.logoUpload = async function(slot, input) {
    const file = input.files[0];
    if (!file) return;
    const MAX = 2 * 1024 * 1024;
    if (file.size > MAX) { alert('حجم فایل نباید بیش از ۲ مگابایت باشد'); input.value = ''; return; }
    const allowed = ['image/jpeg','image/png','image/webp','image/gif','image/x-icon','image/vnd.microsoft.icon'];
    if (!allowed.includes(file.type)) { alert('فرمت مجاز نیست (PNG, JPG, WEBP, ICO)'); input.value = ''; return; }

    const status = document.getElementById('logo-status-' + slot);
    if (status) status.textContent = 'در حال آپلود...';

    const fd = new FormData();
    fd.append('slot', slot);
    fd.append('logo', file);
    try {
        const res  = await fetch('/settings/upload-logo', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '' },
            body: fd,
        });
        const data = await res.json();
        if (data.ok) {
            if (status) status.textContent = data.url;
            const img = document.getElementById('logo-img-' + slot);
            if (img) { img.src = data.url; img.classList.remove('hidden'); }
            document.querySelectorAll('.logo-placeholder-icon-' + slot + ', .logo-placeholder-hint-' + slot).forEach(el => el.classList.add('hidden'));
        } else {
            if (status) status.textContent = data.message || 'خطا';
            alert(data.message || 'خطا در آپلود');
        }
    } catch {
        if (status) status.textContent = 'خطا در اتصال';
    }
    input.value = '';
};

/* ── INIT ────────────────────────────────────────────────────────────────── */
function initLogoSlots() {
    @php
    $savedLogos = [];
    foreach (['logo_main','logo_dark','logo_light','favicon','brand_mark','default_avatar'] as $slot) {
        $v = \App\Models\AppSetting::get($slot, '');
        if ($v) $savedLogos[$slot] = $v;
    }
    @endphp
    const saved = @json($savedLogos);
    Object.entries(saved).forEach(([slot, url]) => {
        if (!url) return;
        const img = document.getElementById('logo-img-' + slot);
        const st  = document.getElementById('logo-status-' + slot);
        if (img) { img.src = url; img.classList.remove('hidden'); }
        if (st)  st.textContent = url;
        document.querySelectorAll('.logo-placeholder-icon-' + slot + ', .logo-placeholder-hint-' + slot).forEach(el => el.classList.add('hidden'));
    });
}

function init() {
    fetch('/settings/theme')
        .then(r => r.json())
        .then(data => { applyToControls(data.ok && data.theme ? Object.assign({}, D, data.theme) : D); })
        .catch(() => applyToControls(D));
    initLogoSlots();
}

const section = document.getElementById('page-settings-theme');
if (section) {
    const obs = new MutationObserver(() => {
        if (!section.classList.contains('hidden')) { init(); obs.disconnect(); }
    });
    obs.observe(section, { attributes: true, attributeFilter: ['class'] });
    if (!section.classList.contains('hidden')) { init(); obs.disconnect(); }
}

})();
</script>
