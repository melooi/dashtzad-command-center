// ─── Sidebar ─────────────────────────────────────────────────────────────────

const SIDEBAR_KEY = 'dashtzad_sidebar_v1';

function initSidebar() {
    const sidebar = document.getElementById('sidebar');
    if (!sidebar) return;

    // Restore desktop collapsed state
    if (window.innerWidth >= 768 && localStorage.getItem(SIDEBAR_KEY) === '1') {
        sidebar.classList.add('sb-collapsed');
        const btn = document.getElementById('sb-toggle-btn');
        if (btn) btn.title = 'باز کردن منو';
    }

    // ESC closes mobile drawer
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeMobileSidebar();
    });

    // Clean up mobile state when resizing to desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) closeMobileSidebar();
    });
}

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    if (!sidebar) return;
    sidebar.classList.toggle('sb-collapsed');
    const isCollapsed = sidebar.classList.contains('sb-collapsed');
    // Close open groups to avoid visual glitch on re-expand
    if (isCollapsed) {
        sidebar.querySelectorAll('details[open]').forEach(d => d.removeAttribute('open'));
    }
    const btn = document.getElementById('sb-toggle-btn');
    if (btn) btn.title = isCollapsed ? 'باز کردن منو' : 'جمع کردن منو';
    localStorage.setItem(SIDEBAR_KEY, isCollapsed ? '1' : '0');
}

function openMobileSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    if (!sidebar || !overlay) return;
    sidebar.classList.add('sb-mobile-open');
    overlay.classList.replace('hidden-fade', 'visible-fade');
    document.body.style.overflow = 'hidden';
}

function closeMobileSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    if (!sidebar || !overlay) return;
    sidebar.classList.remove('sb-mobile-open');
    overlay.classList.replace('visible-fade', 'hidden-fade');
    document.body.style.overflow = '';
}

// ─── Tab / Page Switching ────────────────────────────────────────────────────

const PAGE_IDS = [
    'dashboard',
    'tasks-list', 'tasks-kanban',
    'products-list', 'products-create', 'products-incomplete', 'products-review', 'products-ready',
    'ai-product-content', 'ai-blog-content', 'ai-image-generation', 'ai-outputs',
    'site-blog', 'site-cookbook', 'site-ideas', 'site-ready',
    'sales-orders', 'sales-customers', 'sales-invoices',
    'inventory-stock', 'inventory-suppliers', 'inventory-alerts',
    'connections',
    'activity-today', 'activity-changes', 'activity-errors',
    'reports',
    'settings-users', 'settings-roles', 'settings-brand', 'settings-system',
];

const PAGE_TITLES = {
    'dashboard':            'داشبورد',
    'tasks-list':           'کارهای امروز',
    'tasks-kanban':         'نمای کانبان',
    'products-list':        'همه محصولات',
    'products-create':      'افزودن محصول',
    'products-incomplete':  'محصولات ناقص',
    'products-review':      'صف بررسی',
    'products-ready':       'آماده انتشار',
    'ai-product-content':   'تولید محتوای محصول',
    'ai-blog-content':      'تولید محتوای وبلاگ',
    'ai-image-generation':  'ساخت تصویر',
    'ai-outputs':           'تاریخچه تولید',
    'site-blog':            'مقالات وبلاگ',
    'site-cookbook':        'دستور پخت',
    'site-ideas':           'ایده‌پردازی',
    'site-ready':           'صف انتشار',
    'sales-orders':         'سفارش‌ها',
    'sales-customers':      'مشتریان',
    'sales-invoices':       'فاکتورها',
    'inventory-stock':      'مدیریت موجودی',
    'inventory-suppliers':  'تأمین‌کننده‌ها',
    'inventory-alerts':     'هشدار موجودی',
    'connections':          'اتصالات و یکپارچگی‌ها',
    'activity-today':       'فعالیت امروز',
    'activity-changes':     'تغییرات اخیر',
    'activity-errors':      'خطاهای سیستم',
    'reports':              'گزارش‌ها و آمار',
    'settings-users':       'مدیریت کاربران',
    'settings-roles':       'نقش‌ها و دسترسی',
    'settings-brand':       'تنظیمات برند',
    'settings-system':      'پیکربندی سیستم',
};

function switchTab(tabId) {
    PAGE_IDS.forEach(id => {
        document.getElementById('page-' + id)?.classList.add('hidden');
    });

    document.querySelectorAll('.nav-btn').forEach(btn => {
        btn.classList.remove('bg-indigo-600/10', 'text-indigo-400');
        btn.classList.add('text-slate-400');
    });

    document.getElementById('page-' + tabId)?.classList.remove('hidden');

    const navBtn = document.getElementById('nav-' + tabId);
    if (navBtn) {
        navBtn.classList.add('bg-indigo-600/10', 'text-indigo-400');
        navBtn.classList.remove('text-slate-400');
    }

    const titleEl = document.getElementById('header-title');
    if (titleEl) titleEl.textContent = PAGE_TITLES[tabId] ?? 'دشت‌زاد';

    closeMobileSidebar();
}

// ─── Activity Drawer ─────────────────────────────────────────────────────────

function toggleDrawer() {
    const overlay = document.getElementById('drawer-overlay');
    const drawer  = document.getElementById('activity-drawer');
    if (!overlay || !drawer) return;

    if (overlay.classList.contains('visible-fade')) {
        overlay.classList.replace('visible-fade', 'hidden-fade');
        drawer.classList.add('-translate-x-full');
    } else {
        overlay.classList.replace('hidden-fade', 'visible-fade');
        drawer.classList.remove('-translate-x-full');
    }
}

// ─── Modal ───────────────────────────────────────────────────────────────────

function openModal(id) {
    const backdrop = document.getElementById(id + '-backdrop');
    const modal    = document.getElementById(id);
    if (!backdrop || !modal) return;
    backdrop.classList.replace('hidden-fade', 'visible-fade');
    requestAnimationFrame(() => modal.classList.remove('scale-95'));
}

function closeModal(id) {
    const backdrop = document.getElementById(id + '-backdrop');
    const modal    = document.getElementById(id);
    if (!backdrop || !modal) return;
    modal.classList.add('scale-95');
    backdrop.classList.replace('visible-fade', 'hidden-fade');
}

// ─── Connections — Service Data ──────────────────────────────────────────────

const connectionServices = [
    // AI
    { id: 'OpenAI', group: 'ai', name: 'OpenAI', desc: 'مدل‌های قدرتمند GPT برای پردازش متن و تصویر', connected: false, summaryLabel: 'Model', summaryValue: '-', hasSecret: false, icon: `<i class="fa-solid fa-robot text-xl"></i>` },
    { id: 'Claude', group: 'ai', name: 'Claude', desc: 'مدل‌های تحلیلی و استدلالی Anthropic', connected: false, summaryLabel: 'Model', summaryValue: '-', hasSecret: false, icon: `<i class="fa-solid fa-brain text-xl"></i>` },
    { id: 'Gemini', group: 'ai', name: 'Gemini', desc: 'هوش مصنوعی گوگل (Google DeepMind)', connected: false, summaryLabel: 'Model', summaryValue: '-', hasSecret: false, icon: `<i class="fa-solid fa-star text-xl"></i>` },
    // Site & Shop
    { id: 'WordPress', group: 'site', name: 'WordPress', desc: 'اتصال به سایت محتوایی برای انتشار خودکار', connected: false, summaryLabel: 'URL', summaryValue: '-', hasSecret: false, icon: `<i class="fa-brands fa-wordpress text-xl"></i>` },
    { id: 'WooCommerce', group: 'site', name: 'WooCommerce', desc: 'همگام‌سازی محصولات، قیمت‌ها و سفارشات', connected: false, summaryLabel: 'URL', summaryValue: '-', hasSecret: false, icon: `<i class="fa-brands fa-woocommerce text-xl"></i>` },
    // SMS
    { id: 'MSGway', group: 'sms', name: 'MSGway', desc: 'مسیریابی هوشمند پیامک، تماس صوتی و پیام‌رسان‌ها', connected: false, summaryLabel: 'Provider', summaryValue: '-', hasSecret: false, icon: `<i class="fa-solid fa-comment-sms text-xl"></i>` },
    // Google
    { id: 'GoogleCustomSearch', group: 'google', name: 'Custom Search', desc: 'API جستجوی سفارشی وب', connected: false, summaryLabel: 'CX', summaryValue: '-', hasSecret: false, icon: `<i class="fa-solid fa-magnifying-glass text-xl"></i>` },
    { id: 'GoogleSearchConsole', group: 'google', name: 'Search Console', desc: 'مدیریت ایندکس و خطاهای سایت', connected: false, summaryLabel: 'URL', summaryValue: '-', hasSecret: false, icon: `<i class="fa-solid fa-magnifying-glass-chart text-xl"></i>` },
    { id: 'GoogleAnalytics', group: 'google', name: 'Google Analytics', desc: 'دریافت آمار بازدیدکنندگان و رویدادها', connected: false, summaryLabel: 'Property ID', summaryValue: '-', hasSecret: false, icon: `<i class="fa-solid fa-chart-line text-xl"></i>` },
    { id: 'GoogleSheets', group: 'google', name: 'Google Sheets', desc: 'خروجی داده‌ها و گزارشات به شیت', connected: false, summaryLabel: 'Sheet ID', summaryValue: '-', hasSecret: false, icon: `<i class="fa-solid fa-table text-xl"></i>` },
    // Messengers
    { id: 'TelegramBot', group: 'messengers', name: 'Telegram Bot', desc: 'ربات تلگرام برای نوتیفیکیشن‌ها', connected: false, summaryLabel: 'Bot', summaryValue: '-', hasSecret: false, icon: `<i class="fa-brands fa-telegram text-xl"></i>` },
    { id: 'BaleBot', group: 'messengers', name: 'Bale Bot', desc: 'ربات بله برای پیام‌های داخلی ایران', connected: false, summaryLabel: 'Bot', summaryValue: '-', hasSecret: false, icon: `<i class="fa-solid fa-message text-xl"></i>` },
    { id: 'SMTPEmail', group: 'messengers', name: 'SMTP Email', desc: 'پروتکل ارسال ایمیل سیستمی', connected: false, summaryLabel: 'Host', summaryValue: '-', hasSecret: false, icon: `<i class="fa-solid fa-envelope text-xl"></i>` },
];

const connectionServiceFields = {
    'OpenAI': [
        { name: 'api_key', label: 'API Key', type: 'secret' },
        { name: 'default_text_model', label: 'مدل متنی پیش‌فرض (Default Text Model)', type: 'select', options: ['gpt-5.4-thinking', 'gpt-5.3-instant', 'gpt-5.4-mini', 'gpt-4.5'] },
        { name: 'economy_model', label: 'مدل اقتصادی (Economy Model)', type: 'select', options: ['gpt-5.4-mini', 'gpt-5.3-instant'] },
        { name: 'strong_model', label: 'مدل پیشرفته (Strong Model)', type: 'select', options: ['gpt-5.4-thinking', 'gpt-5.2'] },
        { name: 'image_model', label: 'مدل تصویر (Image Model)', type: 'select', options: ['dall-e-3'] },
        { name: 'daily_limit', label: 'محدودیت درخواست روزانه', type: 'number' },
    ],
    'Claude': [
        { name: 'api_key', label: 'API Key', type: 'secret' },
        { name: 'default_model', label: 'مدل پیش‌فرض (Default Model)', type: 'select', options: ['claude-opus-4.8', 'claude-sonnet-4.6', 'claude-haiku-4.5'] },
        { name: 'max_tokens', label: 'حداکثر توکن (Max Tokens)', type: 'number', placeholder: '8192' },
        { name: 'daily_limit', label: 'محدودیت درخواست روزانه', type: 'number' },
    ],
    'Gemini': [
        { name: 'api_key', label: 'API Key', type: 'secret' },
        { name: 'default_model', label: 'مدل پیش‌فرض (Default Model)', type: 'select', options: ['gemini-3.1-pro', 'gemini-3.1-deep-think', 'gemini-3-flash'] },
        { name: 'daily_limit', label: 'محدودیت درخواست روزانه', type: 'number' },
    ],
    'WordPress': [
        { name: 'site_url', label: 'آدرس سایت (Site URL)', type: 'url', placeholder: 'https://...' },
        { name: 'username', label: 'نام کاربری (Username)', type: 'text' },
        { name: 'application_password', label: 'رمز عبور اپلیکیشن (Application Password)', type: 'secret' },
    ],
    'WooCommerce': [
        { name: 'site_url', label: 'آدرس سایت (Site URL)', type: 'url', placeholder: 'https://...' },
        { name: 'consumer_key', label: 'Consumer Key', type: 'secret' },
        { name: 'consumer_secret', label: 'Consumer Secret', type: 'secret' },
        { name: 'api_version', label: 'نسخه API', type: 'text', placeholder: 'wc/v3' },
        { name: 'default_publish_status', label: 'وضعیت پیش‌فرض انتشار', type: 'text', placeholder: 'draft / publish' },
    ],
    'MSGway': [
        { name: 'api_key', label: 'کلید دسترسی (API Key)', type: 'secret' },
        { name: 'default_provider', label: 'ارائه‌دهنده پیش‌فرض (Provider)', type: 'text', placeholder: 'مثلاً: 1 (پیامک)، 2 (تماس صوتی)، 5 (هوشمند)' },
        { name: 'otp_template_id', label: 'آیدی قالب پیش‌فرض (OTP Template ID)', type: 'text', placeholder: 'مثال: 1024' },
        { name: 'sender', label: 'شماره فرستنده (اختیاری)', type: 'text', placeholder: 'فقط برای ارسال متنی بدون الگو' },
        { name: 'webhook_secret', label: 'وب‌هوک سکرت (Webhook Secret)', type: 'secret' },
        { name: 'resend_seconds', label: 'تاخیر ارسال مجدد (ثانیه)', type: 'number', placeholder: '120' },
    ],
    'GoogleCustomSearch': [
        { name: 'api_key', label: 'API Key', type: 'secret' },
        { name: 'cx', label: 'آیدی موتور جستجو (CX)', type: 'text' },
        { name: 'country', label: 'کشور (GL)', type: 'text', placeholder: 'ir' },
        { name: 'language', label: 'زبان (HL)', type: 'text', placeholder: 'fa' },
    ],
    'GoogleSearchConsole': [
        { name: 'site_url', label: 'آدرس سایت (Site URL Property)', type: 'url' },
        { name: 'oauth_client_id', label: 'OAuth Client ID', type: 'text' },
        { name: 'oauth_client_secret', label: 'OAuth Client Secret', type: 'secret' },
        { name: 'refresh_token', label: 'Refresh Token', type: 'secret' },
    ],
    'GoogleAnalytics': [
        { name: 'property_id', label: 'Property ID', type: 'text' },
        { name: 'service_account_json', label: 'Service Account JSON', type: 'textarea_secret' },
    ],
    'GoogleSheets': [
        { name: 'service_account_json', label: 'Service Account JSON', type: 'textarea_secret' },
        { name: 'default_spreadsheet_id', label: 'آیدی پیش‌فرض شیت', type: 'text' },
        { name: 'default_sheet_name', label: 'نام پیش‌فرض تب شیت', type: 'text' },
    ],
    'TelegramBot': [
        { name: 'bot_token', label: 'توکن ربات (Bot Token)', type: 'secret' },
        { name: 'default_chat_id', label: 'آیدی چت پیش‌فرض (Default Chat ID)', type: 'text' },
        { name: 'admin_chat_id', label: 'آیدی چت ادمین (Admin Chat ID)', type: 'text' },
    ],
    'BaleBot': [
        { name: 'bot_token', label: 'توکن ربات (Bot Token)', type: 'secret' },
        { name: 'default_chat_id', label: 'آیدی چت پیش‌فرض (Default Chat ID)', type: 'text' },
        { name: 'api_base_url', label: 'آدرس پایه API', type: 'url', placeholder: 'https://tapi.bale.ai' },
    ],
    'SMTPEmail': [
        { name: 'host', label: 'هاست (SMTP Host)', type: 'text' },
        { name: 'port', label: 'پورت (SMTP Port)', type: 'number' },
        { name: 'username', label: 'نام کاربری (Username)', type: 'text' },
        { name: 'password', label: 'رمز عبور (Password)', type: 'secret' },
        { name: 'encryption', label: 'رمزنگاری (Encryption)', type: 'text', placeholder: 'tls / ssl' },
        { name: 'from_email', label: 'ایمیل فرستنده (From Email)', type: 'text' },
        { name: 'from_name', label: 'نام فرستنده (From Name)', type: 'text' },
    ],
};

// ─── Connections — localStorage persistence ───────────────────────────────────

const CONN_STORAGE_KEY = 'dashtzad_connections_v1';

function loadConnStates() {
    try { return JSON.parse(localStorage.getItem(CONN_STORAGE_KEY) || '{}'); }
    catch { return {}; }
}

function saveConnState(id, state) {
    const all = loadConnStates();
    all[id] = state;
    localStorage.setItem(CONN_STORAGE_KEY, JSON.stringify(all));
}

function removeConnState(id) {
    const all = loadConnStates();
    delete all[id];
    localStorage.setItem(CONN_STORAGE_KEY, JSON.stringify(all));
}

// ─── Connections — Card Renderer ─────────────────────────────────────────────

let _currentModalSrvId = null;

function renderConnectionCards() {
    // پاک کردن containerها قبل از رندر مجدد
    ['ai', 'site', 'sms', 'google', 'messengers'].forEach(g => {
        const el = document.getElementById('group-' + g);
        if (el) el.innerHTML = '';
    });

    const states = loadConnStates();

    connectionServices.forEach(srv => {
        const container = document.getElementById(`group-${srv.group}`);
        if (!container) return;

        // وضعیت واقعی از localStorage
        const saved      = states[srv.id] || {};
        const connected  = !!saved.connected;
        const hasSecret  = connected;
        const summary    = saved.summaryValue || '-';

        const borderColor = connected ? 'border-emerald-500/50' : 'border-slate-800';
        const hoverBorder = connected ? 'hover:border-emerald-400' : 'hover:border-slate-600';
        const badge       = connected
            ? `<span class="px-2 py-1 bg-emerald-500/10 text-emerald-400 text-[10px] font-bold rounded-md border border-emerald-500/20 shadow-sm">متصل</span>`
            : `<span class="px-2 py-1 bg-slate-800 text-slate-400 text-[10px] font-bold rounded-md border border-slate-700 shadow-sm">متصل نیست</span>`;
        const keySaved    = hasSecret
            ? `<span class="text-xs text-slate-500 block text-left">Key Saved</span>` : '';
        const actionBtns  = connected
            ? `<div class="flex gap-2 mt-2" onclick="event.stopPropagation()">
                   <button onclick="openConfigModal('${srv.id}')" class="flex-1 bg-slate-800 hover:bg-slate-700 text-slate-200 text-sm font-bold py-2 rounded-lg transition-colors border border-slate-700">پیکربندی</button>
                   <button onclick="disconnectService('${srv.id}', event)" class="px-3 bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 rounded-lg transition-colors border border-rose-500/20" title="قطع اتصال">
                       <i class="fa-solid fa-ban text-sm"></i>
                   </button>
               </div>`
            : `<div class="flex gap-2 mt-2" onclick="event.stopPropagation()">
                   <button onclick="openConfigModal('${srv.id}')" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-bold py-2 rounded-lg transition-colors">اتصال</button>
               </div>`;

        container.innerHTML += `
            <div onclick="openConfigModal('${srv.id}')" class="clickable-card group relative bg-slate-900 border ${borderColor} rounded-2xl p-5 ${hoverBorder} transition-all shadow-sm flex flex-col h-full">
                ${connected ? '<div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 rounded-bl-full pointer-events-none"></div>' : ''}
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div class="w-12 h-12 rounded-xl bg-slate-800/80 flex items-center justify-center border border-slate-700/50 text-slate-400 shadow-inner group-hover:bg-slate-800 group-hover:text-indigo-400 group-hover:border-indigo-500/30 transition-all duration-300">${srv.icon}</div>
                    <div class="flex flex-col gap-1 items-end">${badge}${keySaved}</div>
                </div>
                <h3 class="card-title text-base font-bold text-slate-200 mb-1 transition-colors relative z-10" dir="ltr" style="text-align:left;">${srv.name}</h3>
                <p class="text-xs text-slate-400 mb-4 line-clamp-2 relative z-10 leading-relaxed">${srv.desc}</p>
                <div class="mt-auto pt-4 border-t border-slate-800/80 flex flex-col gap-3 relative z-10">
                    <div class="flex justify-between items-center text-xs ${!connected ? 'opacity-50' : ''}">
                        <span class="text-slate-500 font-mono">${srv.summaryLabel}:</span>
                        <span class="text-slate-300 bg-slate-800 px-2 py-0.5 rounded font-mono" dir="ltr">${summary}</span>
                    </div>
                    ${actionBtns}
                </div>
            </div>`;
    });
}

function openConfigModal(serviceId) {
    const srv    = connectionServices.find(s => s.id === serviceId);
    const fields = connectionServiceFields[serviceId] || [];
    if (!srv) return;

    _currentModalSrvId = serviceId;

    const states    = loadConnStates();
    const connected = !!(states[serviceId]?.connected);

    document.getElementById('modal-service-name').innerText = srv.name;
    const container = document.getElementById('modal-fields-container');
    container.innerHTML = '';

    const savedBadge = `<span class="text-[10px] text-emerald-400 bg-emerald-500/10 px-1.5 py-0.5 rounded border border-emerald-500/20">ذخیره شده</span>`;
    const inputBase  = 'w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-left transition-all placeholder-slate-600 font-mono';

    fields.forEach(f => {
        let html = '';
        if (f.type === 'secret') {
            html = `<label class="block text-sm font-bold text-slate-300 mb-1.5 flex justify-between">${f.label}${connected ? savedBadge : ''}</label>
                    <input type="password" data-field-type="secret" data-field-name="${f.name}" dir="ltr" placeholder="${connected ? 'برای تغییر، مقدار جدید وارد کنید...' : f.placeholder || ''}" class="${inputBase}">
                    ${connected ? `<p class="text-[10px] text-slate-500 mt-1 leading-relaxed">مقدار ذخیره شده به دلایل امنیتی نمایش داده نمی‌شود. در صورت خالی گذاشتن، مقدار قبلی حفظ می‌شود.</p>` : ''}`;
        } else if (f.type === 'textarea_secret') {
            html = `<label class="block text-sm font-bold text-slate-300 mb-1.5 flex justify-between">${f.label}${connected ? savedBadge : ''}</label>
                    <textarea rows="3" data-field-type="textarea_secret" data-field-name="${f.name}" dir="ltr" placeholder="${connected ? 'Paste new JSON here to update...' : 'Paste JSON here...'}" class="${inputBase} resize-none"></textarea>
                    ${connected ? `<p class="text-[10px] text-slate-500 mt-1 leading-relaxed">محتوای فایل JSON مخفی است. در صورت خالی ماندن، دیتای قبلی حفظ خواهد شد.</p>` : ''}`;
        } else if (f.type === 'select') {
            const opts = f.options.map(o => `<option value="${o}">${o}</option>`).join('');
            html = `<label class="block text-sm font-bold text-slate-300 mb-1.5">${f.label}</label>
                    <div class="relative">
                        <select data-field-type="select" data-field-name="${f.name}" dir="ltr" class="${inputBase} appearance-none cursor-pointer">${opts}</select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>`;
        } else {
            html = `<label class="block text-sm font-bold text-slate-300 mb-1.5">${f.label}</label>
                    <input type="${f.type}" data-field-type="${f.type}" data-field-name="${f.name}" dir="ltr" placeholder="${f.placeholder || ''}" class="${inputBase}">`;
        }
        container.innerHTML += `<div>${html}</div>`;
    });

    const backdrop = document.getElementById('config-modal-backdrop');
    const modal    = document.getElementById('config-modal');
    backdrop.classList.replace('hidden-fade', 'visible-fade');
    requestAnimationFrame(() => modal.classList.remove('scale-95'));
}

async function saveConnectionsModal() {
    if (!_currentModalSrvId) { closeModal('config-modal'); return; }

    const srv         = connectionServices.find(s => s.id === _currentModalSrvId);
    const SENSITIVE   = ['secret', 'textarea_secret'];
    const allFieldEls = [...document.querySelectorAll('#modal-fields-container [data-field-type]')];
    const fillableEls = allFieldEls.filter(el => el.tagName.toLowerCase() !== 'select');
    const hasAnyValue = fillableEls.some(el => el.value.trim() !== '');

    const existing         = loadConnStates()[_currentModalSrvId];
    const alreadyConnected = !!(existing?.connected);

    _connHideError();

    // No new credentials + already connected → preserve state, just close
    if (!hasAnyValue && alreadyConnected) { closeModal('config-modal'); return; }
    // No credentials + not connected → just close
    if (!hasAnyValue) { closeModal('config-modal'); return; }

    // Collect field values for backend test
    const fields = {};
    allFieldEls.forEach(el => { fields[el.dataset.fieldName] = el.value.trim(); });

    const btn = document.getElementById('modal-save-btn');
    if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-sm"></i> در حال بررسی...'; }

    try {
        const res  = await fetch('/connections/test', {
            method:  'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
            },
            body: JSON.stringify({ service: _currentModalSrvId, fields }),
        });
        const data = await res.json();

        if (!data.ok) {
            _connShowError(data.message || 'اتصال برقرار نشد');
            if (btn) { btn.disabled = false; btn.innerHTML = 'ذخیره تغییرات'; }
            return;
        }

        // Test passed → persist UI state (never store credentials in localStorage)
        const nonSensitive  = allFieldEls.filter(el =>
            !SENSITIVE.includes(el.dataset.fieldType) && el.tagName.toLowerCase() !== 'select'
        );
        const summaryField  =
            nonSensitive.find(el => (el.dataset.fieldType === 'url' || el.dataset.fieldType === 'text') && el.value.trim()) ||
            nonSensitive.find(el => el.value.trim()) ||
            allFieldEls.find(el => el.tagName.toLowerCase() === 'select');
        const summaryValue  = summaryField ? summaryField.value.trim() : 'ذخیره شده';

        saveConnState(_currentModalSrvId, {
            connected:    true,
            summaryLabel: srv?.summaryLabel ?? '',
            summaryValue,
            updatedAt:    new Date().toISOString(),
        });

        allFieldEls.forEach(el => { if (SENSITIVE.includes(el.dataset.fieldType)) el.value = ''; });
        renderConnectionCards();
        if (btn) { btn.disabled = false; btn.innerHTML = 'ذخیره تغییرات'; }
        closeModal('config-modal');

    } catch (_) {
        _connShowError('خطا در ارتباط با سرور');
        if (btn) { btn.disabled = false; btn.innerHTML = 'ذخیره تغییرات'; }
    }
}

function _connShowError(msg) {
    const box = document.getElementById('modal-conn-error');
    const txt = document.getElementById('modal-conn-error-msg');
    if (txt) txt.textContent = msg;
    if (box) box.classList.remove('hidden');
}

function _connHideError() {
    document.getElementById('modal-conn-error')?.classList.add('hidden');
}

function disconnectService(id, event = null) {
    if (event) event.stopPropagation();
    removeConnState(id);
    renderConnectionCards();
}

// ─── AI Content — Demo Form ──────────────────────────────────────────────────

function generateContent(e) {
    e.preventDefault();
    const btn = document.getElementById('gen-btn');
    if (!btn) return;

    const originalHTML = btn.innerHTML;
    btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin text-lg"></i> در حال پردازش...`;
    btn.disabled = true;

    setTimeout(() => {
        btn.innerHTML = originalHTML;
        btn.disabled  = false;
        document.getElementById('ai-empty-state')?.classList.add('hidden');
        document.getElementById('ai-result-state')?.classList.remove('hidden');
    }, 1800);
}

// ─── Products Quick Create ───────────────────────────────────────────────────

let qcRowCount = 0;
const qcRowLastEdits = {};

const qcCategories = ['برنج', 'حبوبات', 'ادویه', 'خشکبار', 'نوشیدنی‌ها', 'مواد غذایی آماده'];

const qcStatuses = [
    { id: 'draft',        label: 'پیش‌نویس',     color: 'text-slate-400' },
    { id: 'incomplete',   label: 'ناقص',           color: 'text-rose-400' },
    { id: 'review',       label: 'نیاز به بررسی', color: 'text-indigo-400' },
    { id: 'approved',     label: 'تأیید شده',      color: 'text-blue-400' },
    { id: 'ready',        label: 'آماده انتشار',   color: 'text-emerald-400' },
    { id: 'published',    label: 'منتشر شده',      color: 'text-emerald-500' },
    { id: 'out_of_stock', label: 'ناموجود',        color: 'text-slate-500' },
    { id: 'archived',     label: 'آرشیو شده',      color: 'text-slate-600' },
];

// .sheet-input indices within each row <tr>
// 0:title 1:url 2:sku 3:category(select) 4:weight 5:regPrice 6:salePrice 7:stock 8:status(select)
const QC = { title: 0, url: 1, sku: 2, cat: 3, weight: 4, regPrice: 5, salePrice: 6, stock: 7, status: 8 };

function qcTimeSince(date) {
    const s = Math.floor((new Date() - date) / 1000);
    if (s < 60) return 'همین الان';
    const m = Math.floor(s / 60);
    if (m < 60) return `${m} دقیقه پیش`;
    return 'قبل‌تر';
}

function qcUpdateTimers() {
    Object.keys(qcRowLastEdits).forEach(idx => {
        const tr = document.getElementById(`row-${idx}`);
        if (!tr) return;
        const cell = tr.querySelector('.time-cell');
        if (cell) cell.textContent = qcTimeSince(qcRowLastEdits[idx]);
    });
}

function checkCompleteness(tr) {
    const idx = tr.id.split('-')[1];
    qcRowLastEdits[idx] = new Date();

    const badge = document.getElementById('autosave-badge');
    if (badge) {
        badge.innerHTML = '<span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-500 ml-1"></span>ذخیره شد';
        badge.classList.add('saving-indicator');
        setTimeout(() => badge.classList.remove('saving-indicator'), 1500);
    }

    const inputs = tr.querySelectorAll('.sheet-input');

    // Validate URL: English, digits, hyphens only
    const urlInput = inputs[QC.url];
    const urlVal   = urlInput ? urlInput.value : '';
    const urlOk    = /^[a-zA-Z0-9\-\/]*$/.test(urlVal);
    if (urlInput) {
        if (!urlOk && urlVal.length > 0) {
            urlInput.classList.add('invalid-field');
            urlInput.title = 'فقط حروف انگلیسی و خط‌تیره';
        } else {
            urlInput.classList.remove('invalid-field');
            urlInput.title = '';
        }
    }

    // Required: title, url, salePrice, stock, category  (image excluded — always a separate task)
    const missing = [];
    let filled = 0;
    const total  = 5;

    const titleVal = inputs[QC.title]?.value.trim() ?? '';
    if (!titleVal)           { missing.push('عنوان'); }     else filled++;
    if (!urlVal || !urlOk)   { missing.push('URL'); }       else filled++;

    const salePriceVal = inputs[QC.salePrice]?.value.trim() ?? '';
    if (!salePriceVal)       { missing.push('قیمت فروش'); } else filled++;

    const stockVal = inputs[QC.stock]?.value.trim() ?? '';
    if (!stockVal)           { missing.push('موجودی'); }    else filled++;

    const catVal = inputs[QC.cat]?.value ?? '';
    if (!catVal)             { missing.push('دسته‌بندی'); } else filled++;

    // Progress bar
    const pct = Math.round((filled / total) * 100);
    const pctColor = pct < 40 ? 'bg-rose-500' : pct < 90 ? 'bg-amber-500' : 'bg-emerald-500';
    const barEl  = tr.querySelector('.progress-bar-fill');
    const textEl = tr.querySelector('.progress-text');
    if (barEl)  { barEl.style.width = `${pct}%`; barEl.className = `progress-bar-fill h-1.5 rounded-full transition-all duration-500 ${pctColor}`; }
    if (textEl) textEl.textContent = `${pct}٪`;

    // Status select + error label
    const statusSel  = tr.querySelector('.status-select');
    const errorLabel = tr.querySelector('.error-label');
    if (statusSel && errorLabel) {
        if (missing.length > 0) {
            statusSel.value = 'incomplete';
            statusSel.className = 'sheet-input status-select appearance-none text-sm cursor-pointer font-bold text-rose-400 p-0 h-auto pointer-events-auto';
            const shown = missing.slice(0, 3).join('، ') + (missing.length > 3 ? '...' : '');
            errorLabel.innerHTML = `ناقص: <span class="text-[9px] text-rose-500/70 font-normal">${shown}</span>`;
        } else {
            if (['incomplete', 'draft'].includes(statusSel.value)) statusSel.value = 'review';
            const st    = qcStatuses.find(s => s.id === statusSel.value) ?? qcStatuses[0];
            statusSel.className = `sheet-input status-select appearance-none text-sm cursor-pointer font-bold ${st.color} p-0 h-auto pointer-events-auto`;
            errorLabel.innerHTML = '<span class="text-[9px] text-emerald-500/80">تکمیل شده ✓</span>';
        }
    }
}

function qcCreateRowHTML(index, data = {}) {
    const catOpts    = qcCategories.map(c =>
        `<option value="${c}"${data.category === c ? ' selected' : ''}>${c}</option>`
    ).join('');
    const statusOpts = qcStatuses.map(s =>
        `<option value="${s.id}">${s.label}</option>`
    ).join('');
    qcRowLastEdits[index] = new Date();

    const esc = v => String(v || '').replace(/"/g, '&quot;').replace(/'/g, '&#39;');

    return `
    <tr class="group hover:bg-slate-800/30 transition-colors" id="row-${index}">
        <td class="border-l border-slate-800/50 px-2 py-0 text-center text-slate-500 text-[11px] font-mono select-none w-10">${index}</td>
        <td class="border-l border-slate-800/50 p-1.5 text-center w-14">
            <div class="mx-auto w-8 h-8 bg-slate-800 rounded-md flex items-center justify-center border border-slate-700/80 cursor-pointer hover:border-indigo-500 hover:bg-slate-700 text-slate-600 hover:text-indigo-400 transition-colors" title="آپلود تصویر">
                <i class="fa-solid fa-image text-sm"></i>
            </div>
        </td>
        <td class="border-l border-slate-800/50 p-0 relative min-w-[200px]"><input type="text" placeholder="عنوان محصول..." class="sheet-input" oninput="checkCompleteness(this.closest('tr'))" value="${esc(data.title)}"></td>
        <td class="border-l border-slate-800/50 p-0 relative min-w-[160px]"><input type="text" dir="ltr" placeholder="product-slug" class="sheet-input font-mono text-[12px]" style="text-align:left" oninput="checkCompleteness(this.closest('tr'))" value="${esc(data.url)}"></td>
        <td class="border-l border-slate-800/50 p-0 relative min-w-[110px]"><input type="text" dir="ltr" placeholder="SKU-001" class="sheet-input font-mono text-[12px]" style="text-align:left" oninput="checkCompleteness(this.closest('tr'))" value="${esc(data.sku)}"></td>
        <td class="border-l border-slate-800/50 p-0 relative min-w-[130px]">
            <select class="sheet-input appearance-none text-sm cursor-pointer" onchange="checkCompleteness(this.closest('tr'))">
                <option value="" disabled selected>انتخاب...</option>${catOpts}
            </select>
        </td>
        <td class="border-l border-slate-800/50 p-0 relative min-w-[90px]"><input type="text" placeholder="۱ کیلو" class="sheet-input text-sm text-center" oninput="checkCompleteness(this.closest('tr'))"></td>
        <td class="border-l border-slate-800/50 p-0 relative min-w-[120px]"><input type="number" dir="ltr" placeholder="0" class="sheet-input font-mono text-[12px] text-slate-400" style="text-align:left;text-decoration:line-through;text-decoration-color:#475569" oninput="checkCompleteness(this.closest('tr'))"></td>
        <td class="border-l border-slate-800/50 p-0 relative min-w-[120px]"><input type="number" dir="ltr" placeholder="0" class="sheet-input font-mono text-[12px] font-bold text-emerald-400" style="text-align:left" oninput="checkCompleteness(this.closest('tr'))"></td>
        <td class="border-l border-slate-800/50 p-0 relative min-w-[80px]"><input type="number" dir="ltr" placeholder="0" class="sheet-input font-mono text-[12px] text-center" oninput="checkCompleteness(this.closest('tr'))"></td>
        <td class="border-l border-slate-800/50 p-0 relative min-w-[150px]">
            <div class="absolute inset-0 flex flex-col justify-center px-3 pointer-events-none">
                <select class="sheet-input status-select appearance-none text-sm cursor-pointer font-bold text-slate-400 p-0 h-auto pointer-events-auto" onchange="checkCompleteness(this.closest('tr'))">
                    ${statusOpts}
                </select>
                <div class="error-label text-[9px] text-rose-500/80 font-bold truncate pointer-events-none mt-0.5">ناقص: عنوان، قیمت...</div>
            </div>
        </td>
        <td class="border-l border-slate-800/50 px-2 py-0 text-center select-none min-w-[100px]">
            <div class="flex items-center gap-1.5 justify-center">
                <div class="w-14 bg-slate-800 rounded-full h-1.5 overflow-hidden shrink-0"><div class="progress-bar-fill bg-rose-500 h-1.5 rounded-full" style="width:0%"></div></div>
                <span class="progress-text text-[10px] font-mono text-slate-400 w-7 shrink-0">0٪</span>
            </div>
        </td>
        <td class="time-cell border-l border-slate-800/50 px-2 py-0 text-center text-[10px] text-slate-500 select-none min-w-[90px]">همین الان</td>
        <td class="p-0 text-center sticky left-0 z-10 bg-slate-900 group-hover:bg-slate-800/60 transition-colors shadow-[-4px_0_8px_rgba(0,0,0,0.25)] min-w-[120px]">
            <div class="flex items-center justify-center gap-0.5 opacity-0 group-hover:opacity-100 transition-opacity px-1.5">
                <button onclick="openTaskModal('ردیف',${index})" tabindex="-1" title="ایجاد تسک" class="text-slate-500 hover:text-amber-400 p-1.5 rounded-lg transition-colors">
                    <i class="fa-solid fa-clipboard-check text-sm"></i>
                </button>
                <button onclick="qcDuplicateRow(${index})" tabindex="-1" title="تکرار ردیف" class="text-slate-500 hover:text-sky-400 p-1.5 rounded-lg transition-colors">
                    <i class="fa-solid fa-copy text-sm"></i>
                </button>
                <button onclick="openEditModal(${index})" tabindex="-1" title="ویرایش جامع" class="text-slate-500 hover:text-indigo-400 p-1.5 rounded-lg transition-colors">
                    <i class="fa-solid fa-pen text-sm"></i>
                </button>
                <button onclick="qcDeleteRow(${index})" tabindex="-1" title="حذف ردیف" class="text-slate-500 hover:text-rose-400 p-1.5 rounded-lg transition-colors">
                    <i class="fa-solid fa-trash text-sm"></i>
                </button>
            </div>
        </td>
    </tr>`;
}

function addRow(data = {}) {
    const tbody = document.getElementById('sheet-body');
    if (!tbody) return;
    qcRowCount++;
    tbody.insertAdjacentHTML('beforeend', qcCreateRowHTML(qcRowCount, data));
    const newRow = document.getElementById(`row-${qcRowCount}`);
    if (newRow) {
        checkCompleteness(newRow);
        document.getElementById('table-scroll-container')?.scrollTo({ top: 999999, behavior: 'smooth' });
    }
}

function qcDeleteRow(index) {
    document.getElementById(`row-${index}`)?.remove();
}

function qcDuplicateRow(index) {
    const row = document.getElementById(`row-${index}`);
    if (!row) return;
    const inputs = row.querySelectorAll('.sheet-input');
    addRow({
        title:    (inputs[QC.title]?.value ?? '') + ' (کپی)',
        url:      inputs[QC.url]?.value   ? inputs[QC.url].value + '-copy' : '',
        sku:      inputs[QC.sku]?.value   ? inputs[QC.sku].value + '-2'   : '',
        category: inputs[QC.cat]?.value   ?? '',
    });
}

function openEditModal(index) {
    const row    = document.getElementById(`row-${index}`);
    const nameEl = document.getElementById('modal-product-name');
    if (row && nameEl) {
        nameEl.textContent = row.querySelectorAll('.sheet-input')[QC.title]?.value || 'محصول جدید';
    }
    const backdrop = document.getElementById('edit-modal-backdrop');
    const modal    = document.getElementById('edit-modal');
    if (!backdrop || !modal) return;
    backdrop.classList.replace('hidden-fade', 'visible-fade');
    requestAnimationFrame(() => modal.classList.remove('scale-95'));
}

function closeEditModal() {
    const backdrop = document.getElementById('edit-modal-backdrop');
    const modal    = document.getElementById('edit-modal');
    if (!backdrop || !modal) return;
    modal.classList.add('scale-95');
    backdrop.classList.replace('visible-fade', 'hidden-fade');
}

function switchModalTab(tabId) {
    document.querySelectorAll('.modal-tab-content').forEach(el => {
        el.classList.add('hidden');
        el.classList.remove('block');
    });
    document.querySelectorAll('.modal-tab-btn').forEach(btn => {
        btn.classList.remove('bg-indigo-600/10', 'text-indigo-400', 'font-bold');
        // Restore default colour; SEO tab gets amber when inactive
        btn.classList.add(btn.id === 'tab-seo' ? 'text-amber-500' : 'text-slate-400');
        btn.classList.add('font-medium');
    });
    document.getElementById(`content-${tabId}`)?.classList.replace('hidden', 'block');
    const activeBtn = document.getElementById(`tab-${tabId}`);
    if (activeBtn) {
        activeBtn.classList.remove('text-slate-400', 'text-amber-500', 'font-medium');
        activeBtn.classList.add('bg-indigo-600/10', 'text-indigo-400', 'font-bold');
    }
}

function openTaskModal(contextType, contextName) {
    let text = 'محصول فعلی';
    if (contextType === 'فیلد') text = `تکمیل فیلد [ ${contextName} ]`;
    else if (contextType === 'ردیف') text = `بررسی ردیف شیت شماره ${contextName}`;
    const el = document.getElementById('task-context-info');
    if (el) el.textContent = text;
    const backdrop = document.getElementById('task-modal-backdrop');
    const modal    = document.getElementById('task-modal');
    if (!backdrop || !modal) return;
    backdrop.classList.replace('hidden-fade', 'visible-fade');
    requestAnimationFrame(() => modal.classList.remove('scale-95'));
}

function closeTaskModal() {
    const backdrop = document.getElementById('task-modal-backdrop');
    const modal    = document.getElementById('task-modal');
    if (!backdrop || !modal) return;
    modal.classList.add('scale-95');
    backdrop.classList.replace('visible-fade', 'hidden-fade');
}

function initQuickCreate() {
    const tbody = document.getElementById('sheet-body');
    if (!tbody) return;

    // Set page header title
    const titleEl = document.getElementById('header-title');
    if (titleEl) titleEl.textContent = 'افزودن سریع محصولات';

    // Seed 3 initial rows
    for (let i = 0; i < 3; i++) addRow();

    // Periodic last-edit label refresh
    setInterval(qcUpdateTimers, 30000);

    // ── Keyboard navigation ──────────────────────────────────────────────────
    tbody.addEventListener('keydown', function (e) {
        const target = e.target;
        if (!target.classList.contains('sheet-input')) return;

        const tr          = target.closest('tr');
        const rows        = Array.from(tbody.children);
        const rowIdx      = rows.indexOf(tr);
        const allInputs   = Array.from(tr.querySelectorAll('.sheet-input'));
        const colIdx      = allInputs.indexOf(target);
        const isSelect    = target.tagName === 'SELECT';
        let nextInput     = null;

        if (e.key === 'Escape') { target.blur(); return; }

        if (e.ctrlKey && e.key === 'd') {
            e.preventDefault();
            qcDuplicateRow(tr.id.split('-')[1]);
            return;
        }

        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            const badge = document.getElementById('autosave-badge');
            if (badge) {
                badge.innerHTML = '<span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-500 ml-1"></span>ذخیره شد';
                badge.classList.add('saving-indicator');
                setTimeout(() => badge.classList.remove('saving-indicator'), 1500);
            }
            return;
        }

        // Delete: remove empty row
        if (e.key === 'Delete' && !isSelect && target.value === '' && rows.length > 1) {
            e.preventDefault();
            const prevTr = rows[rowIdx - 1] ?? rows[rowIdx + 1];
            qcDeleteRow(tr.id.split('-')[1]);
            if (prevTr) nextInput = prevTr.querySelectorAll('.sheet-input')[colIdx];
        } else if (e.key === 'ArrowUp' && !isSelect) {
            e.preventDefault();
            if (rowIdx > 0) nextInput = rows[rowIdx - 1].querySelectorAll('.sheet-input')[colIdx];
        } else if (e.key === 'ArrowDown' && !isSelect) {
            e.preventDefault();
            if (rowIdx < rows.length - 1) {
                nextInput = rows[rowIdx + 1].querySelectorAll('.sheet-input')[colIdx];
            } else { addRow(); nextInput = tbody.lastElementChild.querySelectorAll('.sheet-input')[colIdx]; }
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (e.shiftKey) {
                if (rowIdx > 0) nextInput = rows[rowIdx - 1].querySelectorAll('.sheet-input')[colIdx];
            } else {
                if (rowIdx < rows.length - 1) {
                    nextInput = rows[rowIdx + 1].querySelectorAll('.sheet-input')[colIdx];
                } else { addRow(); nextInput = tbody.lastElementChild.querySelectorAll('.sheet-input')[colIdx]; }
            }
        } else if (e.key === 'Tab' && !e.shiftKey) {
            // Tab → move left in RTL (previous column visually)
            e.preventDefault();
            if (colIdx > 0) nextInput = allInputs[colIdx - 1];
            else if (rowIdx > 0) nextInput = rows[rowIdx - 1].querySelectorAll('.sheet-input')[allInputs.length - 1];
        } else if (e.key === 'Tab' && e.shiftKey) {
            e.preventDefault();
            if (colIdx < allInputs.length - 1) nextInput = allInputs[colIdx + 1];
            else if (rowIdx < rows.length - 1) nextInput = rows[rowIdx + 1].querySelectorAll('.sheet-input')[0];
            else { addRow(); nextInput = tbody.lastElementChild.querySelectorAll('.sheet-input')[0]; }
        } else if (e.key === 'ArrowRight' && !isSelect) {
            if (target.selectionStart === 0 || target.value === '' || target.type === 'number') {
                e.preventDefault();
                if (colIdx > 0) nextInput = allInputs[colIdx - 1];
                else if (rowIdx > 0) nextInput = rows[rowIdx - 1].querySelectorAll('.sheet-input')[allInputs.length - 1];
            }
        } else if (e.key === 'ArrowLeft' && !isSelect) {
            if (target.selectionEnd === target.value.length || target.value === '' || target.type === 'number') {
                e.preventDefault();
                if (colIdx < allInputs.length - 1) nextInput = allInputs[colIdx + 1];
                else if (rowIdx < rows.length - 1) nextInput = rows[rowIdx + 1].querySelectorAll('.sheet-input')[0];
                else { addRow(); nextInput = tbody.lastElementChild.querySelectorAll('.sheet-input')[0]; }
            }
        }

        if (nextInput) {
            const container = document.getElementById('table-scroll-container');
            if (container) {
                const cr = container.getBoundingClientRect();
                const ir = nextInput.getBoundingClientRect();
                if (ir.right > cr.right) container.scrollLeft += (ir.right - cr.right) + 60;
                else if (ir.left < cr.left) container.scrollLeft -= (cr.left - ir.left) + 60;
            }
            nextInput.focus();
            if (nextInput.tagName === 'INPUT') setTimeout(() => nextInput.select(), 10);
        }
    });

    // Auto-select text on focus
    tbody.addEventListener('focusin', e => {
        if (e.target.tagName === 'INPUT') setTimeout(() => e.target.select(), 0);
    });

    // ── Excel paste (multi-row, multi-column) ────────────────────────────────
    tbody.addEventListener('paste', function (e) {
        const active = document.activeElement;
        if (!active.classList.contains('sheet-input')) return;
        const raw = (e.clipboardData || window.clipboardData).getData('text');
        if (!raw.includes('\t') && !raw.includes('\n')) return;

        e.preventDefault();
        const pasteRows = raw.split('\n').filter(r => r.trim() !== '');

        pasteRows.forEach((rowData, rIdx) => {
            const cols = rowData.split('\t');
            if (rIdx === 0) {
                const tr       = active.closest('tr');
                const inputs   = tr.querySelectorAll('.sheet-input');
                const startCol = Array.from(inputs).indexOf(active);
                cols.forEach((val, cIdx) => {
                    const target = inputs[startCol + cIdx];
                    if (target) target.value = val.trim();
                });
                checkCompleteness(tr);
            } else {
                // New row: map col0→title, col1→url, col2→sku
                addRow({
                    title: cols[0]?.trim() ?? '',
                    url:   cols[1]?.trim() ?? '',
                    sku:   cols[2]?.trim() ?? '',
                });
                // Fill remaining columns (index 3+)
                if (cols.length > 3) {
                    const newTr  = tbody.lastElementChild;
                    const inputs = newTr.querySelectorAll('.sheet-input');
                    for (let c = 3; c < cols.length && c < inputs.length; c++) {
                        if (cols[c].trim()) inputs[c].value = cols[c].trim();
                    }
                    checkCompleteness(newTr);
                }
            }
        });
    });

    // Close modals on backdrop click
    document.getElementById('edit-modal-backdrop')?.addEventListener('click', function (e) {
        if (e.target === this) closeEditModal();
    });
    document.getElementById('task-modal-backdrop')?.addEventListener('click', function (e) {
        if (e.target === this) closeTaskModal();
    });
}

// ─── PJAX Router ─────────────────────────────────────────────────────────────

let _pjaxXHR = null;

function navigateTo(target) {
    const isPath  = target.startsWith('/');
    const hasSPA  = !isPath && !!document.getElementById('page-' + target);

    if (hasSPA) {
        // SPA tab already in DOM — instant switch
        switchTab(target);
        history.pushState({ tab: target }, '', '/?tab=' + target);
        return;
    }

    const url = isPath ? target : ('/?tab=' + target);
    _pjaxLoad(url, isPath ? { path: target } : { tab: target });
}

async function _pjaxLoad(url, state, { push = true } = {}) {
    if (_pjaxXHR) { _pjaxXHR.abort(); }
    _pjaxXHR = new AbortController();

    _pjaxBar(true);
    const main = document.querySelector('main');
    if (main) { main.style.opacity = '0.45'; main.style.transition = 'opacity 0.15s'; }

    try {
        const res = await fetch(url, {
            signal: _pjaxXHR.signal,
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        });
        if (!res.ok) throw new Error('HTTP ' + res.status);

        const html    = await res.text();
        const doc     = new DOMParser().parseFromString(html, 'text/html');
        const newMain = doc.querySelector('main');
        if (!newMain) throw new Error('no-main');

        if (main) {
            main.innerHTML        = newMain.innerHTML;
            main.style.opacity    = '1';
            main.style.transition = 'opacity 0.2s';
        }

        if (push) history.pushState(state, '', url);
        _pjaxAfterLoad(state);

    } catch (err) {
        if (err.name === 'AbortError') return;
        window.location.href = url;
    } finally {
        _pjaxBar(false);
        if (main) { main.style.opacity = ''; main.style.transition = ''; }
        _pjaxXHR = null;
    }
}

function _pjaxAfterLoad(state) {
    if (document.getElementById('group-ai'))  renderConnectionCards();
    if (document.getElementById('sheet-body')) initQuickCreate();
    if (state.tab && document.getElementById('page-' + state.tab)) switchTab(state.tab);
    _pjaxUpdateNav(state);
}

function _pjaxUpdateNav(state) {
    document.querySelectorAll('.nav-btn').forEach(btn => {
        btn.classList.remove('bg-indigo-600/10', 'text-indigo-400');
        btn.classList.add('text-slate-400');
    });

    if (state.tab) {
        const el = document.getElementById('nav-' + state.tab);
        if (el) { el.classList.add('bg-indigo-600/10', 'text-indigo-400'); el.classList.remove('text-slate-400'); }
    }

    if (state.path) {
        document.querySelectorAll('[data-nav-path]').forEach(btn => {
            if (btn.dataset.navPath === state.path) {
                btn.classList.add('bg-indigo-600/10', 'text-indigo-400');
                btn.classList.remove('text-slate-400');
            }
        });
    }
}

function _pjaxBar(on) {
    document.getElementById('pjax-bar')?.classList.toggle('pjax-running', on);
}

window.addEventListener('popstate', e => {
    const s = e.state;
    if (!s) { window.location.reload(); return; }
    if (s.tab && document.getElementById('page-' + s.tab)) {
        switchTab(s.tab);
    } else {
        _pjaxLoad(window.location.href, s, { push: false });
    }
});

// ─── Init ────────────────────────────────────────────────────────────────────

function updateHeaderDateTime() {
    const el = document.querySelector('[data-header-datetime]');
    if (!el) return;
    const now  = new Date();
    const date = new Intl.DateTimeFormat('fa-IR-u-ca-persian', {
        weekday: 'long', month: 'long', day: 'numeric',
        timeZone: 'Asia/Tehran',
    }).format(now);
    const time = new Intl.DateTimeFormat('fa-IR', {
        hour: '2-digit', minute: '2-digit', hour12: false,
        timeZone: 'Asia/Tehran',
    }).format(now);
    el.textContent = `${date} | ${time}`;
}

document.addEventListener('DOMContentLoaded', () => {
    initSidebar();
    updateHeaderDateTime();
    setInterval(updateHeaderDateTime, 60000);

    // Determine which tab to show (from URL ?tab= param or default)
    const urlTab  = new URLSearchParams(window.location.search).get('tab');
    const hasSPA  = !!document.getElementById('page-tasks-list');
    const startTab = (urlTab && hasSPA && document.getElementById('page-' + urlTab))
        ? urlTab : 'tasks-list';

    if (hasSPA) {
        switchTab(startTab);
        history.replaceState({ tab: startTab }, '', '/?tab=' + startTab);
        renderConnectionCards();
    }

    initQuickCreate();
});

// ─── Global Exports (required for onclick in Blade templates) ─────────────────
// Vite bundles as <script type="module"> — functions must be on window to be
// reachable from inline onclick attributes in server-rendered HTML.
window.navigateTo           = navigateTo;
window.switchTab            = switchTab;
window.toggleDrawer         = toggleDrawer;
window.openModal            = openModal;
window.closeModal           = closeModal;
window.generateContent      = generateContent;
window.openConfigModal      = openConfigModal;
window.saveConnectionsModal = saveConnectionsModal;
window.disconnectService    = disconnectService;
window.toggleSidebar        = toggleSidebar;
window.openMobileSidebar    = openMobileSidebar;
window.closeMobileSidebar   = closeMobileSidebar;
window.qcSendAll            = function () {
    const badge = document.getElementById('autosave-badge');
    if (badge) {
        badge.innerHTML = '<span class="inline-block w-1.5 h-1.5 rounded-full bg-indigo-500 ml-1"></span>ارسال به صف بررسی...';
        badge.classList.add('saving-indicator');
        setTimeout(() => { badge.classList.remove('saving-indicator'); badge.innerHTML = 'آفلاین'; }, 2000);
    }
};
window.checkCompleteness    = checkCompleteness;
window.addRow               = addRow;
window.qcDeleteRow          = qcDeleteRow;
window.qcDuplicateRow       = qcDuplicateRow;
window.openEditModal        = openEditModal;
window.closeEditModal       = closeEditModal;
window.switchModalTab       = switchModalTab;
window.openTaskModal        = openTaskModal;
window.closeTaskModal       = closeTaskModal;
