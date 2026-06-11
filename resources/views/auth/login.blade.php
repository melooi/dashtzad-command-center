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
<body class="bg-slate-950 text-slate-300 antialiased min-h-screen flex items-end sm:items-center justify-center selection:bg-brand-primary/20">

    {{-- Dark overlay for desktop --}}
    <div class="hidden sm:block fixed inset-0 bg-slate-950" aria-hidden="true"></div>

    {{-- Card: bottom-sheet on mobile, centered card on desktop --}}
    <div class="relative z-10 w-full sm:max-w-sm bg-slate-900 border-t sm:border border-slate-800
                rounded-t-3xl sm:rounded-2xl shadow-2xl flex flex-col overflow-hidden"
         style="min-height: 72vh; max-height: 100vh; sm:min-height:auto">

        {{-- Drag handle (mobile) --}}
        <div class="sm:hidden flex justify-center pt-3 pb-1 shrink-0">
            <div class="w-10 h-1 rounded-full bg-slate-700"></div>
        </div>

        {{-- View container --}}
        <div id="view-container" class="flex-1 flex flex-col px-6 py-8 sm:p-8 overflow-y-auto">

            {{-- VIEW: شماره موبایل ──────────────────────────────── --}}
            <div id="view-phone" class="flex flex-col items-center w-full">

                <div class="w-14 h-14 bg-brand-primary rounded-2xl flex items-center justify-center mb-5 shadow-lg shadow-brand-primary/20">
                    <i class="fa-solid fa-bolt text-white text-xl"></i>
                </div>

                <h2 class="text-xl font-bold text-slate-100 mb-1.5">ورود به دشت‌زاد</h2>
                <p class="text-sm text-slate-400 mb-8 text-center">شماره موبایل خود را وارد کنید تا کد تأیید ارسال شود</p>

                <div class="w-full mb-5">
                    <label class="block text-sm font-bold text-slate-300 mb-2">شماره موبایل</label>
                    <div class="relative">
                        <i class="fa-solid fa-mobile-screen text-slate-500 absolute right-3.5 top-1/2 -translate-y-1/2 text-sm pointer-events-none"></i>
                        <input type="tel" id="phone-input" inputmode="numeric" dir="ltr"
                            placeholder="09---------"
                            class="w-full bg-slate-950 border border-slate-700 rounded-xl py-3 pl-4 pr-10
                                   text-slate-100 text-sm focus:outline-none focus:border-brand-primary
                                   transition-colors placeholder:text-slate-600 tracking-widest">
                    </div>
                    <p id="phone-error" class="text-xs text-rose-400 mt-1.5 hidden"></p>
                </div>

                <button onclick="authSendOtp()"
                    class="w-full bg-brand-primary hover:bg-brand-primary/90 text-white font-bold
                           py-3 rounded-xl transition-colors shadow-lg shadow-brand-primary/20 flex items-center justify-center gap-2"
                    id="btn-send-otp">
                    دریافت کد تأیید
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </button>

                <p class="text-xs text-slate-500 mt-5 text-center leading-relaxed">
                    با ورود به دشت‌زاد، <span class="text-slate-400">قوانین استفاده</span> را می‌پذیرم
                </p>

            </div>

            {{-- VIEW: کد OTP ──────────────────────────────────────── --}}
            <div id="view-otp" class="hidden flex-col items-center w-full">

                <div class="w-14 h-14 bg-brand-primary/10 border border-brand-primary/20 rounded-2xl flex items-center justify-center mb-5">
                    <i class="fa-solid fa-lock text-brand-primary text-xl"></i>
                </div>

                <h2 class="text-xl font-bold text-slate-100 mb-1.5">تأیید شماره همراه</h2>
                <p class="text-sm text-slate-400 mb-1 text-center">کد ۵ رقمی ارسال شده به</p>
                <p id="display-phone" dir="ltr" class="text-sm font-bold text-brand-primary mb-7 tracking-widest"></p>

                {{-- OTP inputs --}}
                <div class="flex justify-center gap-2.5 mb-6 w-full max-w-[260px]" dir="ltr" id="otp-inputs">
                    <input type="tel" maxlength="1" inputmode="numeric" class="otp-box" id="otp1" oninput="otpMove(this,'otp2')">
                    <input type="tel" maxlength="1" inputmode="numeric" class="otp-box" id="otp2" oninput="otpMove(this,'otp3')">
                    <input type="tel" maxlength="1" inputmode="numeric" class="otp-box" id="otp3" oninput="otpMove(this,'otp4')">
                    <input type="tel" maxlength="1" inputmode="numeric" class="otp-box" id="otp4" oninput="otpMove(this,'otp5')">
                    <input type="tel" maxlength="1" inputmode="numeric" class="otp-box" id="otp5">
                </div>

                <p id="otp-error" class="text-xs text-rose-400 mb-4 hidden"></p>

                {{-- Timer --}}
                <div class="flex items-center gap-1.5 text-sm text-slate-400 mb-7">
                    <i class="fa-regular fa-clock text-xs"></i>
                    <span id="otp-timer-text">ارسال مجدد تا</span>
                    <span id="otp-countdown" dir="ltr" class="font-bold text-brand-tertiary">۰۲:۰۰</span>
                    <button id="btn-resend" onclick="authSendOtp(true)" class="hidden text-brand-primary font-bold hover:underline">ارسال مجدد کد</button>
                </div>

                <button onclick="authVerifyOtp()"
                    class="w-full bg-brand-primary hover:bg-brand-primary/90 text-white font-bold
                           py-3 rounded-xl transition-colors shadow-lg shadow-brand-primary/20 mb-4"
                    id="btn-verify-otp">
                    تأیید و ادامه
                </button>

                <button onclick="authSwitchView('view-phone')"
                    class="flex items-center justify-center gap-1.5 text-sm text-slate-400 hover:text-slate-200 transition-colors">
                    <i class="fa-solid fa-pen text-xs"></i>
                    ویرایش شماره همراه
                </button>
            </div>

            {{-- VIEW: تکمیل اطلاعات ──────────────────────────────── --}}
            <div id="view-profile" class="hidden flex-col items-center w-full">

                <h2 class="text-xl font-bold text-slate-100 mb-1.5 w-full">تکمیل اطلاعات</h2>
                <p class="text-sm text-slate-400 mb-6 w-full">اطلاعات خود را برای دریافت دسترسی وارد کنید</p>

                <div class="w-full space-y-4 mb-7">
                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1.5">نام و نام خانوادگی <span class="text-rose-400">*</span></label>
                        <input type="text" id="pf-name" placeholder="مثال: علی رضایی"
                            class="w-full bg-slate-950 border border-slate-700 rounded-xl py-3 px-4
                                   text-slate-100 text-sm focus:outline-none focus:border-brand-primary transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1.5">شماره موبایل</label>
                        <input type="tel" id="pf-phone" dir="ltr" disabled
                            class="w-full bg-slate-800/50 border border-slate-700 rounded-xl py-3 px-4
                                   text-slate-500 text-sm cursor-not-allowed tracking-widest">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-1.5">بخش کاری</label>
                            <input type="text" id="pf-department" placeholder="مثال: فنی"
                                class="w-full bg-slate-950 border border-slate-700 rounded-xl py-3 px-4
                                       text-slate-100 text-sm focus:outline-none focus:border-brand-primary transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-1.5">سمت</label>
                            <input type="text" id="pf-position" placeholder="مثال: توسعه‌دهنده"
                                class="w-full bg-slate-950 border border-slate-700 rounded-xl py-3 px-4
                                       text-slate-100 text-sm focus:outline-none focus:border-brand-primary transition-colors">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1.5">آیدی تلگرام</label>
                        <div class="relative">
                            <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-sm font-bold">@</span>
                            <input type="text" id="pf-telegram" dir="ltr" placeholder="username"
                                class="w-full bg-slate-950 border border-slate-700 rounded-xl py-3 pl-4 pr-10
                                       text-slate-100 text-sm focus:outline-none focus:border-brand-primary transition-colors">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1.5">ایمیل <span class="text-xs text-slate-500 font-normal">(اختیاری)</span></label>
                        <input type="email" id="pf-email" dir="ltr" placeholder="example@mail.com"
                            class="w-full bg-slate-950 border border-slate-700 rounded-xl py-3 px-4
                                   text-slate-100 text-sm focus:outline-none focus:border-brand-primary transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1.5">دلیل درخواست دسترسی <span class="text-rose-400">*</span></label>
                        <textarea id="pf-reason" rows="2" placeholder="چرا به دسترسی پنل نیاز دارید؟"
                            class="w-full bg-slate-950 border border-slate-700 rounded-xl py-3 px-4
                                   text-slate-100 text-sm focus:outline-none focus:border-brand-primary transition-colors resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1.5">معرف / تأییدکننده <span class="text-xs text-slate-500 font-normal">(اختیاری)</span></label>
                        <input type="text" id="pf-referrer" placeholder="نام شخصی که شما را معرفی کرده"
                            class="w-full bg-slate-950 border border-slate-700 rounded-xl py-3 px-4
                                   text-slate-100 text-sm focus:outline-none focus:border-brand-primary transition-colors">
                    </div>
                </div>

                <p id="profile-error" class="text-xs text-rose-400 mb-3 hidden w-full"></p>

                <button onclick="authSaveProfile()"
                    class="w-full bg-brand-primary hover:bg-brand-primary/90 text-white font-bold
                           py-3 rounded-xl transition-colors shadow-lg shadow-brand-primary/20"
                    id="btn-save-profile">
                    ثبت اطلاعات و ادامه
                </button>
            </div>

            {{-- VIEW: در انتظار تأیید ───────────────────────────── --}}
            <div id="view-pending" class="hidden flex-col items-center w-full text-center">

                <div class="w-16 h-16 bg-brand-secondary/10 border border-brand-secondary/20 rounded-2xl flex items-center justify-center mb-5">
                    <i class="fa-solid fa-hourglass-half text-brand-secondary text-2xl"></i>
                </div>

                <h2 class="text-xl font-bold text-slate-100 mb-2">ثبت‌نام موفق!</h2>
                <p class="text-sm text-slate-400 leading-relaxed mb-8 px-4">
                    اطلاعات شما ثبت شد.<br>
                    پس از تأیید مدیر سیستم، می‌توانید وارد پنل شوید.<br>
                    معمولاً این فرآیند کمتر از ۲۴ ساعت طول می‌کشد.
                </p>

                <a href="https://t.me/dasthzad_support" target="_blank"
                    class="w-full flex items-center justify-center gap-2.5 border-2 border-brand-primary
                           text-brand-primary hover:bg-brand-primary/10 font-bold py-3 rounded-xl transition-colors mb-4">
                    <i class="fa-brands fa-telegram"></i>
                    تماس با پشتیبانی
                </a>

            </div>

            {{-- VIEW: عدم دسترسی ────────────────────────────────── --}}
            <div id="view-denied" class="hidden flex-col items-center w-full text-center">

                <div class="w-16 h-16 bg-rose-500/10 border border-rose-500/20 rounded-2xl flex items-center justify-center mb-5">
                    <i class="fa-solid fa-ban text-rose-500 text-2xl"></i>
                </div>

                <h2 class="text-xl font-bold text-rose-400 mb-2">عدم دسترسی</h2>
                <p class="text-sm font-bold text-slate-300 mb-2">دسترسی شما مجاز نیست</p>
                <p class="text-sm text-slate-400 leading-relaxed mb-8 px-4">
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

<style>
.otp-box {
    width: 100%; aspect-ratio: 1;
    text-align: center;
    font-size: 1.4rem; font-weight: 700;
    background: #0f172a;
    border: 1.5px solid #334155;
    border-radius: 0.75rem;
    color: #f1f5f9;
    outline: none;
    transition: border-color 0.15s;
}
.otp-box:focus { border-color: #315A3A; box-shadow: 0 0 0 2px rgba(49,90,58,0.25); }
.otp-box.filled { border-color: #315A3A; }
</style>

<script>
const _csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
let _otpTimer = null;
let _authPhone = '';

async function _post(url, data) {
    const res = await fetch(url, {
        method:  'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': _csrf },
        body:    JSON.stringify(data),
    });
    return res.json();
}

function authSwitchView(id) {
    ['view-phone','view-otp','view-profile','view-pending','view-denied'].forEach(v => {
        const el = document.getElementById(v);
        if (el) { el.classList.add('hidden'); el.classList.remove('flex'); }
    });
    const el = document.getElementById(id);
    if (el) { el.classList.remove('hidden'); el.classList.add('flex'); }
}

// Phone submit
async function authSendOtp(resend = false) {
    const phone = resend ? _authPhone : document.getElementById('phone-input').value.trim();
    const errEl = document.getElementById('phone-error');
    const btn   = document.getElementById(resend ? 'btn-resend' : 'btn-send-otp');

    if (errEl) errEl.classList.add('hidden');
    if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>'; }

    try {
        const data = await _post('/auth/phone', { phone });
        if (!data.ok) {
            if (errEl) { errEl.textContent = data.message; errEl.classList.remove('hidden'); }
            return;
        }
        _authPhone = data.phone;
        document.getElementById('display-phone').textContent = _authPhone;
        const pfPhone = document.getElementById('pf-phone');
        if (pfPhone) pfPhone.value = _authPhone;
        authSwitchView('view-otp');
        startOtpTimer(120);
        document.getElementById('otp1')?.focus();
    } catch {
        if (errEl) { errEl.textContent = 'خطا در ارتباط با سرور'; errEl.classList.remove('hidden'); }
    } finally {
        if (btn && !resend) { btn.disabled = false; btn.innerHTML = 'دریافت کد تأیید <i class="fa-solid fa-arrow-left text-sm"></i>'; }
    }
}

// OTP verify
async function authVerifyOtp() {
    const code = [1,2,3,4,5].map(i => document.getElementById('otp'+i)?.value ?? '').join('');
    const errEl = document.getElementById('otp-error');
    const btn   = document.getElementById('btn-verify-otp');

    if (errEl) errEl.classList.add('hidden');
    if (btn) { btn.disabled = true; btn.textContent = 'در حال بررسی...'; }

    try {
        const data = await _post('/auth/verify', { code });
        if (!data.ok) {
            if (errEl) { errEl.textContent = data.message; errEl.classList.remove('hidden'); }
            [1,2,3,4,5].forEach(i => { const el = document.getElementById('otp'+i); if(el) el.value = ''; });
            document.getElementById('otp1')?.focus();
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
        if (errEl) { errEl.textContent = 'خطا در ارتباط با سرور'; errEl.classList.remove('hidden'); }
    } finally {
        if (btn) { btn.disabled = false; btn.textContent = 'تأیید و ادامه'; }
    }
}

// Save profile
async function authSaveProfile() {
    const errEl = document.getElementById('profile-error');
    const btn   = document.getElementById('btn-save-profile');

    if (errEl) errEl.classList.add('hidden');
    if (btn) { btn.disabled = true; btn.textContent = 'در حال ثبت...'; }

    const payload = {
        name:           document.getElementById('pf-name')?.value.trim(),
        telegram_id:    document.getElementById('pf-telegram')?.value.trim(),
        email:          document.getElementById('pf-email')?.value.trim(),
        department:     document.getElementById('pf-department')?.value.trim(),
        position:       document.getElementById('pf-position')?.value.trim(),
        access_reason:  document.getElementById('pf-reason')?.value.trim(),
        referrer:       document.getElementById('pf-referrer')?.value.trim(),
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

// OTP move-to-next
function otpMove(el, nextId) {
    el.classList.toggle('filled', el.value.length > 0);
    if (el.value.length >= el.maxLength) document.getElementById(nextId)?.focus();
}

// Timer
function startOtpTimer(secs) {
    clearInterval(_otpTimer);
    const countdown = document.getElementById('otp-countdown');
    const timerText = document.getElementById('otp-timer-text');
    const resendBtn = document.getElementById('btn-resend');

    if (resendBtn) resendBtn.classList.add('hidden');
    if (timerText) timerText.classList.remove('hidden');
    if (countdown) countdown.classList.remove('hidden');

    _otpTimer = setInterval(() => {
        secs--;
        if (countdown) {
            const m = String(Math.floor(secs/60)).padStart(2,'0');
            const s = String(secs%60).padStart(2,'0');
            countdown.textContent = m + ':' + s;
        }
        if (secs <= 0) {
            clearInterval(_otpTimer);
            if (timerText) timerText.classList.add('hidden');
            if (countdown) countdown.classList.add('hidden');
            if (resendBtn) resendBtn.classList.remove('hidden');
        }
    }, 1000);
}

// Backspace in OTP
document.addEventListener('DOMContentLoaded', () => {
    const inputs = document.querySelectorAll('.otp-box');
    inputs.forEach((inp, idx) => {
        inp.addEventListener('keydown', e => {
            if (e.key === 'Backspace' && !inp.value && idx > 0) inputs[idx-1].focus();
        });
        inp.addEventListener('input', () => {
            inp.classList.toggle('filled', inp.value.length > 0);
        });
    });

    // Phone input: Enter key
    document.getElementById('phone-input')?.addEventListener('keydown', e => {
        if (e.key === 'Enter') authSendOtp();
    });

    // Last OTP input: Enter key
    document.getElementById('otp5')?.addEventListener('keydown', e => {
        if (e.key === 'Enter') authVerifyOtp();
    });
});
</script>

</body>
</html>
