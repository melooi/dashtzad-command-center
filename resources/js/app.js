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
        btn.classList.remove('bg-brand-primary/10', 'text-brand-primary');
        btn.classList.add('text-slate-400');
    });

    document.getElementById('page-' + tabId)?.classList.remove('hidden');

    const navBtn = document.getElementById('nav-' + tabId);
    if (navBtn) {
        navBtn.classList.add('bg-brand-primary/10', 'text-brand-primary');
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
        if (res.status === 401) {
            const data = await res.json().catch(() => ({}));
            window.location.href = data.redirect ?? '/auth/login';
            return;
        }
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
        btn.classList.remove('bg-brand-primary/10', 'text-brand-primary');
        btn.classList.add('text-slate-400');
    });

    if (state.tab) {
        const el = document.getElementById('nav-' + state.tab);
        if (el) { el.classList.add('bg-brand-primary/10', 'text-brand-primary'); el.classList.remove('text-slate-400'); }
    }

    if (state.path) {
        document.querySelectorAll('[data-nav-path]').forEach(btn => {
            if (btn.dataset.navPath === state.path) {
                btn.classList.add('bg-brand-primary/10', 'text-brand-primary');
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

// ─── Theme Toggle ────────────────────────────────────────────────────────────

function toggleTheme() {
    const isDark = document.documentElement.classList.toggle('dark');
    localStorage.setItem('dashtzad_theme', isDark ? 'dark' : 'light');
    _updateThemeIcon();
}

function _updateThemeIcon() {
    const icon = document.getElementById('theme-icon');
    if (!icon) return;
    const isDark = document.documentElement.classList.contains('dark');
    icon.className = isDark ? 'fa-solid fa-sun text-brand-tertiary text-lg' : 'fa-solid fa-moon text-slate-400 text-lg';
}

// ─── Task Manager ─────────────────────────────────────────────────────────────

const _TM_COLS = [
    { id: 'backlog',     title: 'در صف',        dot: '#64748b' },
    { id: 'today',       title: 'امروز',         dot: '#315A3A' },
    { id: 'in_progress', title: 'در حال انجام',  dot: '#3b82f6' },
    { id: 'review',      title: 'بررسی',         dot: '#a855f7' },
    { id: 'done',        title: 'انجام‌شده',     dot: '#10b981' },
    { id: 'blocked',     title: 'مسدود',         dot: '#f43f5e' },
];

const _TM_PRI = {
    high:      { label: 'فوری',  cls: 'text-rose-500 bg-rose-500/10',   icon: 'fa-fire text-rose-500'   },
    important: { label: 'مهم',   cls: 'text-amber-400 bg-amber-400/10', icon: 'fa-bolt text-amber-400'  },
    normal:    { label: 'عادی', cls: 'text-slate-400 bg-slate-400/10', icon: 'fa-minus text-slate-400' },
};

let _tmTasks = [
    { id: 1, title: 'طراحی دیتابیس محصولات', status: 'in_progress', priority: 'high',      date: '۲۵ خرداد', overdue: false, category: 'بک‌اند',  assignee: 'علی رضایی',  ai: 'ع‌ر', project: 'دشت‌زاد' },
    { id: 2, title: 'اتصال به WooCommerce',   status: 'blocked',     priority: 'normal',    date: '۲۳ خرداد', overdue: true,  category: 'توسعه',    assignee: 'سارا محمدی', ai: 'س‌م', project: 'باملو'    },
    { id: 3, title: 'محتوای محصولات جدید',    status: 'today',       priority: 'important', date: '۲۱ خرداد', overdue: false, category: 'محتوا',    assignee: 'تیم محتوا',  ai: 'ت‌م', project: 'دشت‌زاد' },
    { id: 4, title: 'بررسی گزارش‌های ماهانه', status: 'review',      priority: 'important', date: '۲۴ خرداد', overdue: false, category: 'مدیریت',   assignee: 'علی رضایی',  ai: 'ع‌ر', project: 'دشت‌زاد' },
    { id: 5, title: 'راه‌اندازی ارسال پیامک',  status: 'backlog',     priority: 'normal',    date: '—',         overdue: false, category: 'توسعه',    assignee: 'تیم فنی',    ai: 'ت‌ف', project: 'هسته'    },
    { id: 6, title: 'بهینه‌سازی تصاویر سایت', status: 'done',        priority: 'normal',    date: '۲۰ خرداد', overdue: false, category: 'سایت',     assignee: 'سارا محمدی', ai: 'س‌م', project: 'دشت‌زاد' },
];

let _tmCurrentId = null;
let _tmDragId    = null;

function _tmRenderMetrics() {
    const g = id => document.getElementById(id);
    if (!g('tm-m-total')) return;
    g('tm-m-total').textContent   = _tmTasks.filter(t => t.status === 'today').length;
    g('tm-m-overdue').textContent = _tmTasks.filter(t => t.overdue && t.status !== 'done').length;
    g('tm-m-urgent').textContent  = _tmTasks.filter(t => t.priority === 'high' && t.status !== 'done').length;
    g('tm-m-review').textContent  = _tmTasks.filter(t => t.status === 'review').length;
    g('tm-m-done').textContent    = _tmTasks.filter(t => t.status === 'done').length;
}

function _tmRenderList() {
    const c = document.getElementById('tm-list-container');
    if (!c) return;
    if (!_tmTasks.length) {
        c.innerHTML = '<div class="text-center p-10 text-slate-500 text-sm">هیچ تسکی یافت نشد.</div>';
        _tmRenderMetrics();
        return;
    }
    c.innerHTML = _tmTasks.map(t => {
        const done = t.status === 'done';
        const col  = _TM_COLS.find(c => c.id === t.status) || _TM_COLS[0];
        const pri  = _TM_PRI[t.priority] || _TM_PRI.normal;
        return `
        <div class="flex items-center justify-between p-4 hover:bg-slate-800/30 transition-colors cursor-pointer"
             onclick="tmOpenModal(${t.id})">
            <div class="flex items-center gap-4 flex-1 min-w-0">
                <input type="checkbox" class="task-checkbox shrink-0" ${done ? 'checked' : ''}
                       onclick="event.stopPropagation(); tmChangeStatus(${t.id}, '${done ? 'today' : 'done'}')">
                <div class="min-w-0">
                    <div class="flex items-center gap-2 mb-0.5">
                        <h4 class="text-sm font-bold truncate ${done ? 'text-slate-500 line-through' : 'text-slate-200'}">${t.title}</h4>
                        ${t.overdue && !done ? '<span class="shrink-0 text-[10px] bg-rose-500/10 text-rose-500 px-1.5 py-0.5 rounded font-bold">عقب‌افتاده</span>' : ''}
                    </div>
                    <div class="flex items-center gap-3 text-[11px] text-slate-500">
                        <span class="px-1.5 py-0.5 rounded border border-slate-800 bg-slate-800/50">${t.category}</span>
                        <span><i class="fa-regular fa-calendar text-[10px]"></i> ${t.date}</span>
                        <span>${t.project}</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <span class="hidden md:flex items-center gap-1 px-2 py-0.5 rounded text-[10px] ${pri.cls}">
                    <i class="fa-solid ${pri.icon} text-[10px]"></i> ${pri.label}
                </span>
                <div class="hidden sm:flex items-center gap-2 px-2 py-1 rounded-lg border border-slate-800 bg-slate-900">
                    <span class="w-2 h-2 rounded-full inline-block" style="background:${col.dot}"></span>
                    <span class="text-[11px] font-bold text-slate-400">${col.title}</span>
                </div>
                <div class="w-7 h-7 rounded-full bg-brand-primary/10 text-brand-primary flex items-center justify-center text-[10px] font-bold">${t.ai}</div>
            </div>
        </div>`;
    }).join('');
    _tmRenderMetrics();
}

function _tmRenderKanban() {
    const board = document.getElementById('tm-kanban-board');
    if (!board) return;
    board.innerHTML = '';
    _TM_COLS.forEach(col => {
        const tasks = _tmTasks.filter(t => t.status === col.id);
        const el    = document.createElement('div');
        el.className = 'w-72 shrink-0 flex flex-col bg-slate-900/50 rounded-2xl border border-slate-800 kanban-col';
        el.style.minHeight = '200px';
        el.setAttribute('ondragover',  'tmAllowDrop(event)');
        el.setAttribute('ondragleave', 'tmDragLeave(event)');
        el.setAttribute('ondrop',      `tmDrop(event,'${col.id}')`);
        el.innerHTML = `
            <div class="p-3 border-b border-slate-800/60 flex justify-between items-center sticky top-0 z-10 bg-slate-900 rounded-t-2xl">
                <h3 class="font-bold text-sm text-slate-300 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full inline-block" style="background:${col.dot}"></span>
                    ${col.title}
                </h3>
                <span class="bg-slate-800 text-slate-400 text-[10px] px-2 py-0.5 rounded-full font-bold border border-slate-700">${tasks.length}</span>
            </div>
            <div class="p-3 space-y-3 overflow-y-auto flex-1 hide-scrollbar">
                ${tasks.map(t => {
                    const done  = t.status === 'done';
                    const pri   = _TM_PRI[t.priority] || _TM_PRI.normal;
                    const border = t.overdue && !done ? 'border-rose-500/40' : 'border-slate-800 hover:border-brand-primary/30';
                    return `
                    <div class="kanban-card bg-slate-900 p-3 rounded-xl border ${border} cursor-grab transition-all shadow-sm"
                         draggable="true"
                         ondragstart="tmDrag(event,${t.id})"
                         onclick="tmOpenModal(${t.id})">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-[10px] font-bold px-1.5 py-0.5 bg-slate-800 text-slate-400 rounded border border-slate-700">${t.category}</span>
                            ${t.overdue && !done ? '<span class="text-[9px] text-rose-500 bg-rose-500/10 px-1 rounded font-bold">عقب‌افتاده</span>' : ''}
                        </div>
                        <h4 class="text-sm font-bold text-slate-200 mb-3 ${done ? 'line-through opacity-40' : ''}">${t.title}</h4>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-brand-primary/10 text-brand-primary flex items-center justify-center text-[9px] font-bold">${t.ai}</div>
                                <span class="flex items-center gap-1 px-1.5 py-0.5 rounded ${pri.cls} text-[10px]">
                                    <i class="fa-solid ${pri.icon} text-[10px]"></i>
                                </span>
                            </div>
                            <div class="text-[10px] text-slate-500 flex items-center gap-1">
                                <i class="fa-regular fa-calendar"></i> ${t.date}
                            </div>
                        </div>
                    </div>`;
                }).join('')}
                ${tasks.length === 0 ? '<div class="text-center text-slate-700 text-xs py-6">خالی</div>' : ''}
            </div>`;
        board.appendChild(el);
    });
}

function tmDrag(ev, taskId) {
    ev.stopPropagation();
    _tmDragId = taskId;
    ev.dataTransfer.setData('taskId', taskId);
    ev.currentTarget?.classList.add('dragging');
}

function tmAllowDrop(ev) {
    ev.preventDefault();
    ev.currentTarget?.closest('.kanban-col')?.classList.add('drag-over');
}

function tmDragLeave(ev) {
    if (!ev.currentTarget.contains(ev.relatedTarget)) {
        ev.currentTarget?.closest('.kanban-col')?.classList.remove('drag-over');
    }
}

function tmDrop(ev, newStatus) {
    ev.preventDefault();
    document.querySelectorAll('.kanban-col').forEach(c => c.classList.remove('drag-over'));
    document.querySelectorAll('.kanban-card').forEach(c => c.classList.remove('dragging'));
    const id = parseInt(ev.dataTransfer.getData('taskId'));
    if (!isNaN(id)) tmChangeStatus(id, newStatus);
}

function tmChangeStatus(taskId, newStatus) {
    const idx = _tmTasks.findIndex(t => t.id === taskId);
    if (idx === -1) return;
    if (newStatus === 'done') _tmTasks[idx].overdue = false;
    _tmTasks[idx].status = newStatus;
    _tmRenderList();
    _tmRenderKanban();
    if (_tmCurrentId === taskId) {
        const sel = document.getElementById('tm-modal-status');
        if (sel) sel.value = newStatus;
    }
}

function tmQuickCreate(e) {
    e.preventDefault();
    const inp = document.getElementById('tm-quick-input');
    const val = inp?.value.trim();
    if (!val) return;
    _tmTasks.unshift({
        id: Date.now(), title: val, status: 'today', priority: 'normal',
        date: 'امروز', overdue: false, category: 'عمومی',
        assignee: 'علی رضایی', ai: 'ع‌ر', project: 'دشت‌زاد',
    });
    inp.value = '';
    _tmRenderList();
    _tmRenderKanban();
}

function tmFilterSet(filter) {
    document.querySelectorAll('.tm-filter-btn').forEach(b => {
        b.classList.remove('bg-brand-primary/10', 'text-brand-primary', 'border-brand-primary/20', 'font-bold');
        b.classList.add('bg-slate-800', 'text-slate-400', 'border-slate-700', 'font-medium');
    });
    const act = document.getElementById('tmf-' + filter);
    if (act) {
        act.classList.add('bg-brand-primary/10', 'text-brand-primary', 'border-brand-primary/20', 'font-bold');
        act.classList.remove('bg-slate-800', 'text-slate-400', 'border-slate-700', 'font-medium');
    }
}

function tmOpenModal(taskId) {
    const task = taskId ? _tmTasks.find(t => t.id === taskId) : null;
    _tmCurrentId = taskId;
    if (task) {
        document.getElementById('tm-modal-title').textContent      = task.title;
        document.getElementById('tm-modal-status').value           = task.status;
        document.getElementById('tm-modal-priority').value         = task.priority;
        document.getElementById('tm-modal-date').textContent       = task.date;
        document.getElementById('tm-modal-assignee').textContent   = task.assignee;
        document.getElementById('tm-modal-assignee-initial').textContent = task.ai;
        document.getElementById('tm-modal-project').textContent    = task.project;
        document.getElementById('tm-modal-category').textContent   = task.category;
        const pri = _TM_PRI[task.priority] || _TM_PRI.normal;
        document.getElementById('tm-header-badges').innerHTML = `
            <span class="px-2 py-0.5 bg-slate-800 text-slate-400 text-[10px] font-bold rounded border border-slate-700">${task.project}</span>
            <span class="text-[10px] font-bold flex items-center gap-1 ${pri.cls} px-2 py-0.5 rounded">
                <i class="fa-solid ${pri.icon} text-[10px]"></i> ${pri.label}
            </span>`;
    }
    tmModalTab('chat');
    const bd = document.getElementById('tm-modal-backdrop');
    const md = document.getElementById('tm-modal');
    if (!bd || !md) return;
    bd.classList.replace('hidden-fade', 'visible-fade');
    requestAnimationFrame(() => md.classList.remove('scale-95'));
}

function tmCloseModal() {
    const bd = document.getElementById('tm-modal-backdrop');
    const md = document.getElementById('tm-modal');
    if (!bd || !md) return;
    md.classList.add('scale-95');
    bd.classList.replace('visible-fade', 'hidden-fade');
    _tmCurrentId = null;
}

function tmSaveModal() {
    if (!_tmCurrentId) { tmCloseModal(); return; }
    const idx = _tmTasks.findIndex(t => t.id === _tmCurrentId);
    if (idx !== -1) {
        const s = document.getElementById('tm-modal-status')?.value;
        const p = document.getElementById('tm-modal-priority')?.value;
        if (s) _tmTasks[idx].status   = s;
        if (p) _tmTasks[idx].priority = p;
        _tmRenderList();
        _tmRenderKanban();
    }
    tmCloseModal();
}

function tmModalTab(tab) {
    ['chat', 'log', 'ai'].forEach(t => {
        const c = document.getElementById('tm-tcontent-' + t);
        const b = document.getElementById('tm-tab-' + t);
        if (c) { c.classList.add('hidden'); c.classList.remove('flex'); }
        if (b && t !== 'ai') {
            b.classList.remove('text-brand-primary', 'border-brand-primary');
            b.classList.add('text-slate-400', 'border-transparent');
        }
    });
    const ac = document.getElementById('tm-tcontent-' + tab);
    const ab = document.getElementById('tm-tab-' + tab);
    if (ac) { ac.classList.remove('hidden'); ac.classList.add('flex'); }
    if (ab && tab !== 'ai') {
        ab.classList.add('text-brand-primary', 'border-brand-primary');
        ab.classList.remove('text-slate-400', 'border-transparent');
    }
}

function tmAISubmit() {
    const inp = document.getElementById('tm-ai-input');
    if (!inp) return;
    const val = inp.value.trim();
    if (!val) return;
    const chat = document.getElementById('tm-ai-messages');
    if (!chat) return;
    chat.innerHTML += `
        <div class="flex gap-3 flex-row-reverse mt-3">
            <div class="w-8 h-8 rounded-xl bg-slate-700 flex items-center justify-center text-white shrink-0 text-[10px] font-bold">شما</div>
            <div class="bg-brand-primary text-white p-3 rounded-xl rounded-tl-sm text-sm max-w-[85%] leading-relaxed">${val}</div>
        </div>`;
    const loadId = 'tml-' + Date.now();
    chat.innerHTML += `
        <div id="${loadId}" class="flex gap-3 mt-3">
            <div class="w-8 h-8 rounded-xl bg-brand-primary flex items-center justify-center text-white shrink-0"><i class="fa-solid fa-robot text-sm"></i></div>
            <div class="bg-slate-800 border border-slate-700 p-3 rounded-xl rounded-tr-sm flex items-center gap-1">
                <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay:0s"></span>
                <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay:.15s"></span>
                <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay:.3s"></span>
            </div>
        </div>`;
    chat.scrollTop = chat.scrollHeight;
    inp.value = '';
    setTimeout(() => {
        document.getElementById(loadId)?.remove();
        chat.innerHTML += `
            <div class="flex gap-3 mt-3">
                <div class="w-8 h-8 rounded-xl bg-brand-primary flex items-center justify-center text-white shrink-0"><i class="fa-solid fa-robot text-sm"></i></div>
                <div class="bg-slate-800 border border-slate-700 p-3 rounded-xl rounded-tr-sm text-sm text-slate-200 max-w-[85%] leading-relaxed">
                    در حال حاضر این یک شبیه‌ساز است. در نسخه نهایی به API متصل خواهد شد.
                </div>
            </div>`;
        chat.scrollTop = chat.scrollHeight;
    }, 1000);
}

// ─── Init ────────────────────────────────────────────────────────────────────

function updateHeaderDateTime() {
    const el = document.querySelector('[data-header-datetime]');
    if (!el) return;
    try {
        const now = new Date();
        const tz  = 'Asia/Tehran';
        const pc  = 'fa-IR-u-ca-persian';
        const fmt = opts => new Intl.DateTimeFormat(pc, { timeZone: tz, ...opts }).format(now);
        const weekday = fmt({ weekday: 'long' });
        const day     = fmt({ day: 'numeric' });
        const month   = fmt({ month: 'long' });
        const time    = new Intl.DateTimeFormat('fa-IR', { hour: '2-digit', minute: '2-digit', hour12: false, timeZone: tz }).format(now);
        el.textContent = `${weekday} ${day} ${month} | ${time}`;
    } catch {
        el.textContent = '—';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    initSidebar();
    updateHeaderDateTime();
    setInterval(updateHeaderDateTime, 60000);
    _updateThemeIcon();

    // Determine which tab to show (from URL ?tab= param or default)
    const urlTab  = new URLSearchParams(window.location.search).get('tab');
    const hasSPA  = !!document.getElementById('page-tasks-list');
    const startTab = (urlTab && hasSPA && document.getElementById('page-' + urlTab))
        ? urlTab : 'tasks-list';

    if (hasSPA) {
        switchTab(startTab);
        history.replaceState({ tab: startTab }, '', '/?tab=' + startTab);
        renderConnectionCards();
        _tmRenderList();
        _tmRenderKanban();
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
window.toggleTheme          = toggleTheme;
window.tmOpenModal          = tmOpenModal;
window.tmCloseModal         = tmCloseModal;
window.tmSaveModal          = tmSaveModal;
window.tmModalTab           = tmModalTab;
window.tmQuickCreate        = tmQuickCreate;
window.tmChangeStatus       = tmChangeStatus;
window.tmFilterSet          = tmFilterSet;
window.tmDrag               = tmDrag;
window.tmAllowDrop          = tmAllowDrop;
window.tmDragLeave          = tmDragLeave;
window.tmDrop               = tmDrop;
window.tmAISubmit           = tmAISubmit;
