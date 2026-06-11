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
    { id: 'OpenAI', group: 'ai', name: 'OpenAI', desc: 'مدل‌های قدرتمند GPT برای پردازش متن و تصویر', connected: false, summaryLabel: 'Model', summaryValue: '-', hasSecret: false, icon: `<svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M22.2819 9.8211a5.9847 5.9847 0 0 0-.5157-4.9108 6.0462 6.0462 0 0 0-6.5098-2.9A6.0651 6.0651 0 0 0 4.9807 4.1818a5.9847 5.9847 0 0 0-3.1586 5.4426 6.0462 6.0462 0 0 0 .7411 6.8117 5.9847 5.9847 0 0 0 .5157 4.9108 6.0462 6.0462 0 0 0 6.5098 2.9 6.0651 6.0651 0 0 0 10.2757-2.1709 5.9847 5.9847 0 0 0 3.1586-5.4426 6.0462 6.0462 0 0 0-.7411-6.8117zm-9.0684 9.9242a4.4636 4.4636 0 0 1-2.876-1.0408l.1428-.0814 4.7783-2.7582a.7948.7948 0 0 0 .3927-.6813v-6.7369l2.02 1.1686a.071.071 0 0 1 .038.052v5.5826a4.504 4.504 0 0 1-4.4958 4.4954zm-7.1423-2.5255a4.4636 4.4636 0 0 1-1.0264-2.882l.1428.0814 4.7783 2.7582a.7948.7948 0 0 0 .7855 0l5.8428-3.3685V15.98a.071.071 0 0 1-.0359.0617l-4.8236 2.7844a4.504 4.504 0 0 1-5.6635-1.6062zm-2.0911-7.1423a4.4636 4.4636 0 0 1 1.8496-2.4228l-.0011.1628v5.5165a.7948.7948 0 0 0 .3927.6813l5.8428 3.3685-2.02 1.1686a.071.071 0 0 1-.074-.0104l-4.8236-2.7844a4.504 4.504 0 0 1-1.1664-5.68zm12.3995-1.8496a4.4636 4.4636 0 0 1 1.0264 2.882l-.1428-.0814-4.7783-2.7582a.7948.7948 0 0 0-.7855 0L5.9458 11.66v-2.186a.071.071 0 0 1 .0359-.0617l4.8236-2.7844a4.504 4.504 0 0 1 5.6635 1.6062zm2.0911 7.1423a4.4636 4.4636 0 0 1-1.8496 2.4228l.0011-.1628v-5.5165a.7948.7948 0 0 0-.3927-.6813l-5.8428-3.3685 2.02-1.1686a.071.071 0 0 1 .074.0104l4.8236 2.7844a4.504 4.504 0 0 1 1.1664 5.68zM12 13.9185a1.8687 1.8687 0 1 1 1.8687-1.8687A1.8687 1.8687 0 0 1 12 13.9185z"/></svg>` },
    { id: 'Claude', group: 'ai', name: 'Claude', desc: 'مدل‌های تحلیلی و استدلالی Anthropic', connected: false, summaryLabel: 'Model', summaryValue: '-', hasSecret: false, icon: `<svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>` },
    { id: 'Gemini', group: 'ai', name: 'Gemini', desc: 'هوش مصنوعی گوگل (Google DeepMind)', connected: false, summaryLabel: 'Model', summaryValue: '-', hasSecret: false, icon: `<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.25c.34 3.73 3.02 6.41 6.75 6.75-3.73.34-6.41 3.02-6.75 6.75-.34-3.73-3.02-6.41-6.75-6.75 3.73-.34 6.41-3.02 6.75-6.75z"/></svg>` },
    // Site & Shop
    { id: 'WordPress', group: 'site', name: 'WordPress', desc: 'اتصال به سایت محتوایی برای انتشار خودکار', connected: false, summaryLabel: 'URL', summaryValue: '-', hasSecret: false, icon: `<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.158 12.786l-2.698 7.84c.806.236 1.657.365 2.54.365 1.047 0 2.05-.18 2.986-.51-.024-.037-.046-.078-.065-.123l-2.763-7.572zM3.008 12c0 3.56 2.07 6.634 5.068 8.092L3.788 8.341c-.506 1.117-.78 2.36-.78 3.659zm15.06-.208c0-.98-.316-1.577-.665-2.059-.447-.568-.867-1.026-.867-1.652 0-.69.52-1.31 1.25-1.31.028 0 .056.002.083.004C16.892 4.965 14.62 3.5 12 3.5c-2.88 0-5.412 1.432-6.853 3.61.127.003.247.006.353.006 1.126 0 2.85-.145 2.85-.145.58-.04.654.808.073.882 0 0-.58.074-1.233.108l3.935 11.696 2.36-7.075-1.688-4.62c-.58-.035-1.125-.108-1.125-.108-.58-.036-.506-.883.073-.883 0 0 1.761.146 2.815.146 1.127 0 2.852-.146 2.852-.146.58-.04.653.808.073.883 0 0-.58.073-1.234.108l3.89 11.455c1.472-1.642 2.37-3.802 2.37-6.147 0-.638-.13-1.236-.308-1.802zM12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm0 22.5C6.201 22.5 1.5 17.799 1.5 12S6.201 1.5 12 1.5 22.5 6.201 22.5 12 17.799 22.5 12 22.5z"/></svg>` },
    { id: 'WooCommerce', group: 'site', name: 'WooCommerce', desc: 'همگام‌سازی محصولات، قیمت‌ها و سفارشات', connected: false, summaryLabel: 'URL', summaryValue: '-', hasSecret: false, icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>` },
    // SMS
    { id: 'MSGway', group: 'sms', name: 'MSGway', desc: 'مسیریابی هوشمند پیامک، تماس صوتی و پیام‌رسان‌ها', connected: false, summaryLabel: 'Provider', summaryValue: '-', hasSecret: false, icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>` },
    // Google
    { id: 'GoogleCustomSearch', group: 'google', name: 'Custom Search', desc: 'API جستجوی سفارشی وب', connected: false, summaryLabel: 'CX', summaryValue: '-', hasSecret: false, icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>` },
    { id: 'GoogleSearchConsole', group: 'google', name: 'Search Console', desc: 'مدیریت ایندکس و خطاهای سایت', connected: false, summaryLabel: 'URL', summaryValue: '-', hasSecret: false, icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>` },
    { id: 'GoogleAnalytics', group: 'google', name: 'Google Analytics', desc: 'دریافت آمار بازدیدکنندگان و رویدادها', connected: false, summaryLabel: 'Property ID', summaryValue: '-', hasSecret: false, icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>` },
    { id: 'GoogleSheets', group: 'google', name: 'Google Sheets', desc: 'خروجی داده‌ها و گزارشات به شیت', connected: false, summaryLabel: 'Sheet ID', summaryValue: '-', hasSecret: false, icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>` },
    // Messengers
    { id: 'TelegramBot', group: 'messengers', name: 'Telegram Bot', desc: 'ربات تلگرام برای نوتیفیکیشن‌ها', connected: false, summaryLabel: 'Bot', summaryValue: '-', hasSecret: false, icon: `<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.54.295l.188-2.85 5.176-4.664c.224-.2-.049-.308-.344-.112l-6.4 4.02-2.76-.864c-.6-.188-.61-.6.126-.888l10.814-4.168c.5-.188.95.106.828.91z"/></svg>` },
    { id: 'BaleBot', group: 'messengers', name: 'Bale Bot', desc: 'ربات بله برای پیام‌های داخلی ایران', connected: false, summaryLabel: 'Bot', summaryValue: '-', hasSecret: false, icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/></svg>` },
    { id: 'SMTPEmail', group: 'messengers', name: 'SMTP Email', desc: 'پروتکل ارسال ایمیل سیستمی', connected: false, summaryLabel: 'Host', summaryValue: '-', hasSecret: false, icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>` },
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
                       <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
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
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
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

function saveConnectionsModal() {
    if (!_currentModalSrvId) { closeModal('config-modal'); return; }

    const srv = connectionServices.find(s => s.id === _currentModalSrvId);
    const SENSITIVE = ['secret', 'textarea_secret'];
    const allFieldEls = [...document.querySelectorAll('#modal-fields-container [data-field-type]')];

    // Select elements always have a value — only non-select inputs count as "user actively filled something"
    const fillableEls = allFieldEls.filter(el => el.tagName.toLowerCase() !== 'select');
    const hasAnyValue = fillableEls.some(el => el.value.trim() !== '');

    const existing = loadConnStates()[_currentModalSrvId];
    const alreadyConnected = !!(existing?.connected);

    if (hasAnyValue) {
        // summaryValue: only from non-sensitive, non-select fields — prefer url/text over number
        const nonSensitive = allFieldEls.filter(el =>
            !SENSITIVE.includes(el.dataset.fieldType) && el.tagName.toLowerCase() !== 'select'
        );
        const summaryField =
            nonSensitive.find(el => (el.dataset.fieldType === 'url' || el.dataset.fieldType === 'text') && el.value.trim()) ||
            nonSensitive.find(el => el.value.trim());
        const summaryValue = summaryField ? summaryField.value.trim() : 'ذخیره شده';

        saveConnState(_currentModalSrvId, {
            connected: true,
            summaryLabel: srv ? srv.summaryLabel : '',
            summaryValue,
            updatedAt: new Date().toISOString(),
        });

        // Clear all sensitive inputs — credentials must never linger in the DOM
        allFieldEls.forEach(el => {
            if (SENSITIVE.includes(el.dataset.fieldType)) el.value = '';
        });

        renderConnectionCards();
    } else if (!alreadyConnected) {
        closeModal('config-modal');
        return;
    }
    // Already connected + no new values entered → preserve existing state, just close

    closeModal('config-modal');
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
    btn.innerHTML = `<svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
    </svg> در حال پردازش...`;
    btn.disabled = true;

    setTimeout(() => {
        btn.innerHTML = originalHTML;
        btn.disabled  = false;
        document.getElementById('ai-empty-state')?.classList.add('hidden');
        document.getElementById('ai-result-state')?.classList.remove('hidden');
    }, 1800);
}

// ─── Init ────────────────────────────────────────────────────────────────────

document.addEventListener('DOMContentLoaded', () => {
    switchTab('tasks-list');
    renderConnectionCards();
});

// ─── Global Exports (required for onclick in Blade templates) ─────────────────
// Vite bundles as <script type="module"> — functions must be on window to be
// reachable from inline onclick attributes in server-rendered HTML.
window.switchTab          = switchTab;
window.toggleDrawer       = toggleDrawer;
window.openModal          = openModal;
window.closeModal         = closeModal;
window.generateContent    = generateContent;
window.openConfigModal      = openConfigModal;
window.saveConnectionsModal = saveConnectionsModal;
window.disconnectService    = disconnectService;
