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

document.addEventListener('DOMContentLoaded', () => switchTab('tasks-list'));
