<!DOCTYPE html>
<html lang="fa" dir="rtl" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ورود به دشت‌زاد</title>
    <script>
        (function(){ if(localStorage.getItem('dashtzad_theme')!=='light') document.documentElement.classList.add('dark'); })();
    </script>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

{{-- Desktop: fixed backdrop + centered card  |  Mobile: bottom-sheet --}}
<body class="bg-slate-950 text-slate-300 antialiased selection:bg-brand-primary/20">

    {{-- Backdrop (always visible) --}}
    <div class="fixed inset-0 bg-slate-950 sm:bg-slate-950/95 sm:backdrop-blur-sm z-0"
         aria-hidden="true"></div>

    {{-- Wrapper: bottom-sheet on mobile, full-centered on desktop --}}
    <div class="fixed inset-0 z-10 flex flex-col sm:items-center sm:justify-center overflow-y-auto">

        {{-- Push card to bottom on mobile --}}
        <div class="flex-1 sm:hidden pointer-events-none" aria-hidden="true"></div>

        {{-- Card --}}
        <div class="relative w-full sm:max-w-sm
                    bg-slate-900
                    border-t sm:border border-slate-800/80
                    rounded-t-3xl sm:rounded-2xl
                    shadow-2xl shadow-black/50
                    sm:my-8">

            {{-- Mobile drag handle --}}
            <div class="sm:hidden flex justify-center pt-3 pb-0 shrink-0">
                <div class="w-9 h-1 rounded-full bg-slate-700/80"></div>
            </div>

            {{-- View container --}}
            <div id="view-container" class="px-6 pt-6 pb-8 sm:p-8 overflow-y-auto">

                {{-- ── VIEW: شماره موبایل ─────────────────────────────── --}}
                <div id="view-phone" class="flex flex-col items-center">

                    <div class="w-12 h-12 bg-brand-primary rounded-2xl flex items-center justify-center mb-4 shadow-lg shadow-brand-primary/20">
                        <i class="fa-solid fa-bolt text-white text-lg"></i>
                    </div>

                    <h2 class="text-lg font-bold text-slate-100 mb-1">ورود به دشت‌زاد</h2>
                    <p class="text-sm text-slate-400 mb-6 text-center">شماره موبایل خود را وارد کنید</p>

                    <div class="w-full mb-4">
                        <label class="block text-sm font-bold text-slate-300 mb-2">شماره موبایل</label>
                        <div class="relative">
                            <i class="fa-solid fa-mobile-screen text-slate-500 absolute right-3.5 top-1/2 -translate-y-1/2 text-sm pointer-events-none"></i>
                            <input type="tel" id="phone-input" inputmode="numeric" dir="ltr"
                                placeholder="09---------"
                                autocomplete="tel"
                                class="w-full bg-slate-950 border border-slate-700 rounded-xl py-3 pl-4 pr-10
                                       text-slate-100 text-sm focus:outline-none focus:border-brand-primary
                                       transition-colors placeholder:text-slate-600 tracking-widest">
                        </div>
                        <p id="phone-error" class="text-xs text-rose-400 mt-1.5 hidden"></p>
                    </div>

                    <button onclick="authSendOtp()"
                        class="w-full bg-brand-primary hover:bg-brand-primary/90 text-white font-bold
                               py-3 rounded-xl transition-colors flex items-center justify-center gap-2"
                        id="btn-send-otp">
                        دریافت کد تأیید
                        <i class="fa-solid fa-arrow-left text-sm"></i>
                    </button>

                    <p class="text-xs text-slate-500 mt-5 text-center leading-relaxed">
                        با ورود به دشت‌زاد، <span class="text-slate-400">قوانین استفاده</span> را می‌پذیرم
                    </p>
                </div>

                {{-- ── VIEW: کد OTP ──────────────────────────────────── --}}
                <div id="view-otp" class="hidden flex-col items-center">

                    <div class="w-12 h-12 bg-brand-primary/10 border border-brand-primary/20 rounded-2xl flex items-center justify-center mb-4">
                        <i class="fa-solid fa-lock text-brand-primary text-lg"></i>
                    </div>

                    <h2 class="text-lg font-bold text-slate-100 mb-1">تأیید شماره همراه</h2>
                    @php($otpLength = (int) config('panel.otp_length', 4))
                    <p class="text-sm text-slate-400 mb-0.5 text-center">کد {{ $otpLength }} رقمی ارسال‌شده به</p>
                    <p id="display-phone" dir="ltr"
                       class="text-sm font-bold text-brand-primary mb-5 tracking-widest font-mono"></p>

                    {{-- DEV banner --}}
                    @if(app()->environment('local'))
                    <div id="dev-otp-banner" class="hidden w-full mb-4 bg-amber-500/10 border border-amber-500/20 rounded-xl px-4 py-2.5 flex items-center gap-2.5">
                        <i class="fa-solid fa-flask text-amber-400 text-xs shrink-0"></i>
                        <span class="text-xs text-amber-400">DEV — کد OTP:</span>
                        <span id="dev-otp-code" dir="ltr" class="font-mono font-bold text-amber-300 tracking-[0.25em] text-base"></span>
                    </div>
                    @endif

                    {{-- OTP boxes (count from config) --}}
                    <div class="flex justify-center gap-2 mb-1 w-full" dir="ltr"
                         id="otp-inputs" data-otp-length="{{ $otpLength }}">
                        @for ($i = 0; $i < $otpLength; $i++)
                            <input type="tel" maxlength="1" inputmode="numeric"
                                   class="otp-box" data-otp-index="{{ $i }}"
                                   autocomplete="one-time-code">
                        @endfor
                    </div>

                    <p id="otp-error" class="text-xs text-rose-400 mt-2 mb-2 min-h-[1rem] text-center"></p>

                    {{-- Timer --}}
                    <div class="flex items-center gap-1.5 text-xs text-slate-400 mb-5">
                        <i class="fa-regular fa-clock"></i>
                        <span id="otp-timer-text">ارسال مجدد تا</span>
                        <span id="otp-countdown" dir="ltr" class="font-bold text-brand-tertiary font-mono">02:00</span>
                        <button id="btn-resend" onclick="authSendOtp(true)"
                            class="hidden text-brand-primary font-bold hover:underline text-sm">
                            ارسال مجدد کد
                        </button>
                    </div>

                    <button onclick="authVerifyOtp()"
                        id="btn-verify-otp"
                        class="w-full bg-brand-primary text-white font-bold py-3 rounded-xl
                               transition-all mb-3 opacity-50 cursor-not-allowed"
                        disabled>
                        تأیید و ادامه
                    </button>

                    <button onclick="authSwitchView('view-phone')"
                        class="flex items-center justify-center gap-1.5 text-sm text-slate-400 hover:text-slate-200 transition-colors py-1">
                        <i class="fa-solid fa-pen text-xs"></i>
                        ویرایش شماره
                    </button>
                </div>

                {{-- ── VIEW: تکمیل اطلاعات ────────────────────────── --}}
                <div id="view-profile" class="hidden flex-col items-center">

                    <h2 class="text-lg font-bold text-slate-100 mb-1 w-full">تکمیل اطلاعات</h2>
                    <p class="text-sm text-slate-400 mb-5 w-full">اطلاعات خود را برای دریافت دسترسی وارد کنید</p>

                    <div class="w-full space-y-3.5 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-1.5">نام و نام خانوادگی <span class="text-rose-400">*</span></label>
                            <input type="text" id="pf-name" placeholder="مثال: علی رضایی"
                                class="w-full bg-slate-950 border border-slate-700 rounded-xl py-2.5 px-4
                                       text-slate-100 text-sm focus:outline-none focus:border-brand-primary transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-1.5">شماره موبایل</label>
                            <input type="tel" id="pf-phone" dir="ltr" disabled
                                class="w-full bg-slate-800/50 border border-slate-700 rounded-xl py-2.5 px-4
                                       text-slate-500 text-sm cursor-not-allowed tracking-widest font-mono">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-bold text-slate-300 mb-1.5">بخش کاری</label>
                                <input type="text" id="pf-department" placeholder="مثال: فنی"
                                    class="w-full bg-slate-950 border border-slate-700 rounded-xl py-2.5 px-4
                                           text-slate-100 text-sm focus:outline-none focus:border-brand-primary transition-colors">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-300 mb-1.5">سمت</label>
                                <input type="text" id="pf-position" placeholder="مثال: توسعه‌دهنده"
                                    class="w-full bg-slate-950 border border-slate-700 rounded-xl py-2.5 px-4
                                           text-slate-100 text-sm focus:outline-none focus:border-brand-primary transition-colors">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-1.5">آیدی تلگرام</label>
                            <div class="relative">
                                <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-sm font-bold select-none">@</span>
                                <input type="text" id="pf-telegram" dir="ltr" placeholder="username"
                                    class="w-full bg-slate-950 border border-slate-700 rounded-xl py-2.5 pl-4 pr-10
                                           text-slate-100 text-sm focus:outline-none focus:border-brand-primary transition-colors">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-1.5">
                                ایمیل <span class="text-xs text-slate-500 font-normal">(اختیاری)</span>
                            </label>
                            <input type="email" id="pf-email" dir="ltr" placeholder="example@mail.com"
                                class="w-full bg-slate-950 border border-slate-700 rounded-xl py-2.5 px-4
                                       text-slate-100 text-sm focus:outline-none focus:border-brand-primary transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-1.5">دلیل درخواست دسترسی <span class="text-rose-400">*</span></label>
                            <textarea id="pf-reason" rows="2" placeholder="چرا به دسترسی پنل نیاز دارید؟"
                                class="w-full bg-slate-950 border border-slate-700 rounded-xl py-2.5 px-4
                                       text-slate-100 text-sm focus:outline-none focus:border-brand-primary transition-colors resize-none"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-1.5">
                                معرف / تأییدکننده <span class="text-xs text-slate-500 font-normal">(اختیاری)</span>
                            </label>
                            <input type="text" id="pf-referrer" placeholder="نام شخصی که شما را معرفی کرده"
                                class="w-full bg-slate-950 border border-slate-700 rounded-xl py-2.5 px-4
                                       text-slate-100 text-sm focus:outline-none focus:border-brand-primary transition-colors">
                        </div>
                    </div>

                    <p id="profile-error" class="text-xs text-rose-400 mb-3 hidden w-full"></p>

                    <button onclick="authSaveProfile()"
                        class="w-full bg-brand-primary hover:bg-brand-primary/90 text-white font-bold
                               py-3 rounded-xl transition-colors"
                        id="btn-save-profile">
                        ثبت اطلاعات و ادامه
                    </button>
                </div>

                {{-- ── VIEW: در انتظار تأیید ──────────────────────── --}}
                <div id="view-pending" class="hidden flex-col items-center text-center">
                    <div class="w-14 h-14 bg-brand-secondary/10 border border-brand-secondary/20 rounded-2xl flex items-center justify-center mb-4">
                        <i class="fa-solid fa-hourglass-half text-brand-secondary text-xl"></i>
                    </div>
                    <h2 class="text-lg font-bold text-slate-100 mb-2">ثبت‌نام موفق!</h2>
                    <p class="text-sm text-slate-400 leading-relaxed mb-6 px-2">
                        اطلاعات شما ثبت شد.<br>
                        پس از تأیید مدیر سیستم وارد پنل می‌شوید.<br>
                        معمولاً این فرآیند کمتر از ۲۴ ساعت طول می‌کشد.
                    </p>
                    <a href="https://t.me/dasthzad_support" target="_blank"
                        class="w-full flex items-center justify-center gap-2.5 border-2 border-brand-primary
                               text-brand-primary hover:bg-brand-primary/10 font-bold py-3 rounded-xl transition-colors">
                        <i class="fa-brands fa-telegram"></i>
                        تماس با پشتیبانی
                    </a>
                </div>

                {{-- ── VIEW: عدم دسترسی ──────────────────────────── --}}
                <div id="view-denied" class="hidden flex-col items-center text-center">
                    <div class="w-14 h-14 bg-rose-500/10 border border-rose-500/20 rounded-2xl flex items-center justify-center mb-4">
                        <i class="fa-solid fa-ban text-rose-500 text-xl"></i>
                    </div>
                    <h2 class="text-lg font-bold text-rose-400 mb-1.5">عدم دسترسی</h2>
                    <p class="text-sm font-bold text-slate-300 mb-2">دسترسی شما مجاز نیست</p>
                    <p class="text-sm text-slate-400 leading-relaxed mb-6 px-2">
                        حساب شما رد یا مسدود شده است.<br>
                        در صورت نیاز با مدیر سیستم تماس بگیرید.
                    </p>
                    <a href="https://t.me/dasthzad_support" target="_blank"
                        class="w-full flex items-center justify-center gap-2.5 border-2 border-slate-700
                               text-slate-300 hover:border-slate-600 font-bold py-3 rounded-xl transition-colors">
                        <i class="fa-brands fa-telegram"></i>
                        ارتباط با پشتیبانی
                    </a>
                </div>

            </div>
        </div>

        {{-- Bottom spacer on desktop so card doesn't touch edge --}}
        <div class="hidden sm:block h-8 shrink-0"></div>
    </div>

<style>
.otp-box {
    flex: 1;
    min-width: 0;
    max-width: 3rem;
    aspect-ratio: 1 / 1;
    text-align: center;
    font-size: 1.35rem;
    font-weight: 700;
    background: #0f172a;
    border: 1.5px solid #334155;
    border-radius: 0.75rem;
    color: #f1f5f9;
    outline: none;
    transition: border-color 0.15s, box-shadow 0.15s;
    caret-color: transparent;
}
.otp-box:focus {
    border-color: #315A3A;
    box-shadow: 0 0 0 2.5px rgba(49,90,58,0.25);
}
.otp-box.filled {
    border-color: #315A3A;
    background: rgba(49,90,58,0.08);
}
.otp-box.error {
    border-color: #f43f5e;
    animation: otp-shake 0.3s ease;
}
@keyframes otp-shake {
    0%, 100% { transform: translateX(0); }
    25%       { transform: translateX(-3px); }
    75%       { transform: translateX(3px); }
}
</style>

<script>
const _csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
let _otpTimer = null;
let _authPhone = '';
let OTP_LEN = 4; // will be set from DOM on DOMContentLoaded

// ── Digit normalisation (Persian ۰-۹ and Arabic ٠-٩ → 0-9) ─────────────
function _normDigits(str) {
    return str
        .replace(/[۰-۹]/g, d => String.fromCharCode(d.charCodeAt(0) - 0x6F0 + 48))
        .replace(/[٠-٩]/g, d => String.fromCharCode(d.charCodeAt(0) - 0x660 + 48));
}

// ── HTTP helper ──────────────────────────────────────────────────────────
async function _post(url, data) {
    const res = await fetch(url, {
        method:  'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': _csrf },
        body:    JSON.stringify(data),
    });
    return res.json();
}

// ── View switcher ────────────────────────────────────────────────────────
function authSwitchView(id) {
    ['view-phone','view-otp','view-profile','view-pending','view-denied'].forEach(v => {
        const el = document.getElementById(v);
        if (!el) return;
        el.classList.add('hidden');
        el.classList.remove('flex');
    });
    const el = document.getElementById(id);
    if (el) { el.classList.remove('hidden'); el.classList.add('flex'); }
}

// ── Send OTP ─────────────────────────────────────────────────────────────
async function authSendOtp(resend = false) {
    const rawPhone = resend ? _authPhone : _normDigits(document.getElementById('phone-input').value.trim());
    const errEl    = document.getElementById('phone-error');
    const btn      = document.getElementById(resend ? 'btn-resend' : 'btn-send-otp');

    if (errEl) { errEl.textContent = ''; errEl.classList.add('hidden'); }
    if (btn)   { btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>'; }

    try {
        const data = await _post('/auth/phone', { phone: rawPhone });
        if (!data.ok) {
            if (errEl) { errEl.textContent = data.message; errEl.classList.remove('hidden'); }
            return;
        }
        _authPhone = data.phone;
        // Display formatted: split into groups  09xx xxx xxxx
        const dp = document.getElementById('display-phone');
        if (dp) dp.textContent = _authPhone.replace(/^(09\d\d)(\d{3})(\d{4})$/, '$1 $2 $3');
        const pfPhone = document.getElementById('pf-phone');
        if (pfPhone) pfPhone.value = _authPhone;

        _clearOtpBoxes();
        authSwitchView('view-otp');
        startOtpTimer(120);
        document.querySelector('.otp-box')?.focus();

        if (data.dev_otp) {
            const banner = document.getElementById('dev-otp-banner');
            const code   = document.getElementById('dev-otp-code');
            if (banner && code) {
                code.textContent = data.dev_otp;
                banner.classList.remove('hidden');
                banner.classList.add('flex');
            }
        }
    } catch {
        if (errEl) { errEl.textContent = 'خطا در ارتباط با سرور'; errEl.classList.remove('hidden'); }
    } finally {
        if (btn && !resend) {
            btn.disabled = false;
            btn.innerHTML = 'دریافت کد تأیید <i class="fa-solid fa-arrow-left text-sm"></i>';
        }
        if (btn && resend) {
            btn.disabled = false;
            btn.textContent = 'ارسال مجدد کد';
        }
    }
}

// ── Verify OTP ───────────────────────────────────────────────────────────
async function authVerifyOtp() {
    const boxes  = [...document.querySelectorAll('.otp-box')];
    const code   = boxes.map(b => b.value).join('');
    const errEl  = document.getElementById('otp-error');
    const btn    = document.getElementById('btn-verify-otp');

    if (errEl) { errEl.textContent = ''; }
    boxes.forEach(b => b.classList.remove('error'));

    if (btn) { btn.disabled = true; btn.textContent = 'در حال بررسی...'; }

    try {
        const data = await _post('/auth/verify', { code });
        if (!data.ok) {
            if (errEl) errEl.textContent = data.message;
            boxes.forEach(b => { b.classList.add('error'); b.value = ''; b.classList.remove('filled'); });
            setTimeout(() => boxes.forEach(b => b.classList.remove('error')), 400);
            document.querySelector('.otp-box')?.focus();
            _updateVerifyBtn();
            return;
        }
        if (data.redirect === 'dashboard') { window.location.href = '/'; return; }
        if (data.redirect === 'profile') {
            const pfPhone = document.getElementById('pf-phone');
            if (pfPhone) pfPhone.value = _authPhone;
            authSwitchView('view-profile');
        } else {
            authSwitchView('view-' + data.redirect);
        }
    } catch {
        if (errEl) errEl.textContent = 'خطا در ارتباط با سرور';
    } finally {
        if (btn) {
            btn.disabled = false;
            btn.textContent = 'تأیید و ادامه';
            _updateVerifyBtn();
        }
    }
}

// ── Save profile ─────────────────────────────────────────────────────────
async function authSaveProfile() {
    const errEl = document.getElementById('profile-error');
    const btn   = document.getElementById('btn-save-profile');

    if (errEl) { errEl.textContent = ''; errEl.classList.add('hidden'); }
    if (btn)   { btn.disabled = true; btn.textContent = 'در حال ثبت...'; }

    const payload = {
        name:          document.getElementById('pf-name')?.value.trim(),
        telegram_id:   document.getElementById('pf-telegram')?.value.trim(),
        email:         document.getElementById('pf-email')?.value.trim(),
        department:    document.getElementById('pf-department')?.value.trim(),
        position:      document.getElementById('pf-position')?.value.trim(),
        access_reason: document.getElementById('pf-reason')?.value.trim(),
        referrer:      document.getElementById('pf-referrer')?.value.trim(),
    };

    try {
        const data = await _post('/auth/profile', payload);
        if (!data.ok) {
            if (errEl) { errEl.textContent = data.message; errEl.classList.remove('hidden'); }
            return;
        }
        if (data.redirect === 'dashboard') { window.location.href = '/'; return; }
        authSwitchView('view-' + data.redirect);
    } catch {
        if (errEl) { errEl.textContent = 'خطا در ارتباط با سرور'; errEl.classList.remove('hidden'); }
    } finally {
        if (btn) { btn.disabled = false; btn.textContent = 'ثبت اطلاعات و ادامه'; }
    }
}

// ── OTP helpers ──────────────────────────────────────────────────────────
function _clearOtpBoxes() {
    document.querySelectorAll('.otp-box').forEach(b => {
        b.value = '';
        b.classList.remove('filled', 'error');
    });
    _updateVerifyBtn();
}

function _updateVerifyBtn() {
    const all    = [...document.querySelectorAll('.otp-box')];
    const filled = all.every(b => b.value.length === 1);
    const btn    = document.getElementById('btn-verify-otp');
    if (!btn) return;
    if (filled) {
        btn.disabled = false;
        btn.classList.remove('opacity-50', 'cursor-not-allowed');
        btn.classList.add('hover:bg-brand-primary/90', 'cursor-pointer');
    } else {
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
        btn.classList.remove('hover:bg-brand-primary/90', 'cursor-pointer');
    }
}

// ── Timer ─────────────────────────────────────────────────────────────────
function startOtpTimer(secs) {
    clearInterval(_otpTimer);
    const countdown = document.getElementById('otp-countdown');
    const timerText = document.getElementById('otp-timer-text');
    const resendBtn = document.getElementById('btn-resend');

    if (resendBtn) resendBtn.classList.add('hidden');
    if (timerText) timerText.classList.remove('hidden');
    if (countdown) countdown.classList.remove('hidden');

    function tick() {
        if (countdown) {
            const m = String(Math.floor(secs / 60)).padStart(2, '0');
            const s = String(secs % 60).padStart(2, '0');
            countdown.textContent = m + ':' + s;
        }
        if (secs <= 0) {
            clearInterval(_otpTimer);
            if (timerText) timerText.classList.add('hidden');
            if (countdown) countdown.classList.add('hidden');
            if (resendBtn) resendBtn.classList.remove('hidden');
            return;
        }
        secs--;
    }
    tick();
    _otpTimer = setInterval(tick, 1000);
}

// ── DOMContentLoaded ─────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    OTP_LEN = Number(document.getElementById('otp-inputs')?.dataset.otpLength || 4);
    const boxes = [...document.querySelectorAll('.otp-box')];

    boxes.forEach((box, idx) => {
        // Input: normalize + advance
        box.addEventListener('input', () => {
            // Normalize Persian/Arabic
            const norm = _normDigits(box.value).replace(/\D/g, '');
            box.value  = norm.slice(-1);
            box.classList.toggle('filled', box.value.length > 0);
            if (box.value && idx < boxes.length - 1) boxes[idx + 1].focus();
            _updateVerifyBtn();
        });

        // Keydown: backspace navigation
        box.addEventListener('keydown', e => {
            if (e.key === 'Backspace') {
                if (box.value) {
                    box.value = '';
                    box.classList.remove('filled');
                    _updateVerifyBtn();
                } else if (idx > 0) {
                    boxes[idx - 1].focus();
                    boxes[idx - 1].value = '';
                    boxes[idx - 1].classList.remove('filled');
                    _updateVerifyBtn();
                }
                e.preventDefault();
            } else if (e.key === 'Enter') {
                authVerifyOtp();
            } else if (e.key === 'ArrowRight' && idx > 0) {
                boxes[idx - 1].focus();
            } else if (e.key === 'ArrowLeft' && idx < boxes.length - 1) {
                boxes[idx + 1].focus();
            }
        });

        // Paste: fill all boxes
        box.addEventListener('paste', e => {
            e.preventDefault();
            const pasted = _normDigits((e.clipboardData || window.clipboardData).getData('text'));
            const digits = pasted.replace(/\D/g, '').slice(0, OTP_LEN);
            digits.split('').forEach((d, i) => {
                if (boxes[i]) {
                    boxes[i].value = d;
                    boxes[i].classList.add('filled');
                }
            });
            boxes[Math.min(digits.length, OTP_LEN - 1)].focus();
            _updateVerifyBtn();
            if (digits.length === OTP_LEN) authVerifyOtp();
        });

        // Click: select content
        box.addEventListener('click', () => box.select());
    });

    // Phone input: normalize on input + Enter key
    const phoneInput = document.getElementById('phone-input');
    if (phoneInput) {
        phoneInput.addEventListener('input', () => {
            const norm = _normDigits(phoneInput.value).replace(/[^0-9]/g, '');
            if (norm !== phoneInput.value) phoneInput.value = norm;
        });
        phoneInput.addEventListener('keydown', e => {
            if (e.key === 'Enter') authSendOtp();
        });
    }

    _updateVerifyBtn();
});
</script>

</body>
</html>
