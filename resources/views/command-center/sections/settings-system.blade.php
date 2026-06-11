{{-- PAGE: پیکربندی سیستم (id=page-settings-system) --}}
<div id="page-settings-system" class="max-w-3xl mx-auto space-y-5 hidden pb-10">

    {{-- ── امنیت و دسترسی ──────────────────────────────────────── --}}
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-800 flex items-center gap-2.5">
            <i class="fa-solid fa-shield-halved text-brand-primary"></i>
            <h2 class="font-bold text-slate-200 text-sm">امنیت و دسترسی</h2>
        </div>

        {{-- Panel auth toggle --}}
        <div class="p-5 flex items-start justify-between gap-6">
            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-slate-200 mb-1">فعال‌سازی ورود به پنل</h3>
                <p class="text-sm text-slate-400 leading-relaxed">
                    با فعال کردن این گزینه، همه صفحات پنل پشت صفحه ورود قرار می‌گیرند.
                    فقط کاربرانی که توسط مدیر تأیید شده‌اند می‌توانند وارد شوند.
                </p>
                <div id="auth-toggle-notice" class="hidden mt-3 flex items-start gap-2 bg-amber-500/10 border border-amber-500/20 rounded-xl px-4 py-3 text-xs text-amber-400 leading-relaxed">
                    <i class="fa-solid fa-triangle-exclamation shrink-0 mt-0.5"></i>
                    <span>قبل از فعال‌سازی، اطمینان حاصل کنید که شماره ادمین در <span class="font-mono bg-slate-800 px-1 rounded">PANEL_ADMIN_PHONE</span> در فایل .env تنظیم شده است، تا بتوانید وارد پنل شوید.</span>
                </div>
            </div>
            <div class="shrink-0 mt-0.5">
                <button id="auth-toggle-btn"
                    onclick="sysTogglePanelAuth()"
                    class="relative w-12 h-6 rounded-full transition-colors duration-200 focus:outline-none border-2 {{ ($authEnabled ?? false) ? 'bg-brand-primary border-brand-primary' : 'bg-slate-700 border-slate-600' }}"
                    title="{{ ($authEnabled ?? false) ? 'غیرفعال‌سازی ورود' : 'فعال‌سازی ورود' }}"
                    data-enabled="{{ ($authEnabled ?? false) ? '1' : '0' }}">
                    <span id="auth-toggle-knob"
                        class="absolute top-0.5 w-4 h-4 bg-white rounded-full shadow transition-all duration-200 {{ ($authEnabled ?? false) ? 'right-0.5' : 'left-0.5' }}">
                    </span>
                </button>
            </div>
        </div>
        <div class="px-5 pb-4">
            <div class="flex items-center gap-2 text-xs {{ ($authEnabled ?? false) ? 'text-brand-primary' : 'text-slate-500' }}" id="auth-status-label">
                <i class="fa-solid {{ ($authEnabled ?? false) ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                {{ ($authEnabled ?? false) ? 'ورود به پنل فعال است' : 'پنل بدون نیاز به ورود در دسترس است' }}
            </div>
        </div>
    </div>

    {{-- ── تنظیمات عمومی (placeholder) ────────────────────────── --}}
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-800 flex items-center gap-2.5">
            <i class="fa-solid fa-server text-slate-500"></i>
            <h2 class="font-bold text-slate-200 text-sm">پیکربندی سیستم</h2>
        </div>
        <div class="p-5 text-sm text-slate-500 text-center py-10">
            <i class="fa-solid fa-gears text-2xl mb-3 block"></i>
            تنظیمات کش، صف‌های کاری و پیکربندی فنی در نسخه‌های بعدی اضافه می‌شوند.
        </div>
    </div>

</div>

<script>
async function sysTogglePanelAuth() {
    const btn    = document.getElementById('auth-toggle-btn');
    const knob   = document.getElementById('auth-toggle-knob');
    const label  = document.getElementById('auth-status-label');
    const notice = document.getElementById('auth-toggle-notice');
    const enabled = btn.dataset.enabled === '1';
    const next   = !enabled;

    btn.disabled = true;
    try {
        const res  = await fetch('/settings/toggle-auth', {
            method:  'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '' },
            body:    JSON.stringify({ enabled: next }),
        });
        const data = await res.json();
        if (!data.ok) return;

        btn.dataset.enabled = next ? '1' : '0';
        if (next) {
            btn.classList.replace('bg-slate-700', 'bg-brand-primary');
            btn.classList.replace('border-slate-600', 'border-brand-primary');
            knob.classList.replace('left-0.5', 'right-0.5');
            label.innerHTML = '<i class="fa-solid fa-circle-check"></i> ورود به پنل فعال است';
            label.className = 'flex items-center gap-2 text-xs text-brand-primary';
            notice.classList.remove('hidden');
            notice.classList.add('flex');
        } else {
            btn.classList.replace('bg-brand-primary', 'bg-slate-700');
            btn.classList.replace('border-brand-primary', 'border-slate-600');
            knob.classList.replace('right-0.5', 'left-0.5');
            label.innerHTML = '<i class="fa-solid fa-circle-xmark"></i> پنل بدون نیاز به ورود در دسترس است';
            label.className = 'flex items-center gap-2 text-xs text-slate-500';
            notice.classList.add('hidden');
            notice.classList.remove('flex');
        }
    } catch {
        // ignore
    } finally {
        btn.disabled = false;
    }
}
</script>
