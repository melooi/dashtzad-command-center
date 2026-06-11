{{-- Sidebar navigation --}}
<aside id="sidebar" class="bg-slate-900 border-l border-slate-800/80 flex flex-col z-20">

    {{-- Logo + toggle buttons --}}
    <div class="sb-logo-area h-16 flex items-center justify-between shrink-0 px-4 border-b border-slate-800/80">

        <div class="flex items-center gap-3 min-w-0">
            <div class="w-8 h-8 bg-brand-primary rounded-lg flex items-center justify-center
                        shadow-lg shadow-brand-primary/20 shrink-0">
                <i class="fa-solid fa-bolt text-white text-sm"></i>
            </div>
            <div class="sb-text min-w-0">
                <span class="font-bold text-slate-200 text-base tracking-wide">دشت‌زاد</span>
                <span class="text-xs font-normal text-brand-secondary mr-1">پنل</span>
            </div>
        </div>

        {{-- Mobile: close button --}}
        <button onclick="closeMobileSidebar()"
                class="md:hidden p-1.5 text-slate-400 hover:text-white hover:bg-slate-800 rounded-lg transition-colors shrink-0"
                title="بستن">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>

    </div>

    {{-- Nav --}}
    <nav class="flex-1 py-4 px-2.5 space-y-0.5 overflow-y-auto hide-scrollbar">

        {{-- داشبورد --}}
        <x-nav.item tab="dashboard" title="داشبورد">
            <i class="fa-solid fa-gauge-high text-lg shrink-0"></i>
            <span class="mr-3 font-medium sb-text text-sm">داشبورد</span>
        </x-nav.item>

        {{-- مدیریت وظایف --}}
        <x-nav.group title="مدیریت وظایف" :open="true">
            <x-slot:icon>
                <i class="fa-solid fa-list-check text-lg"></i>
            </x-slot:icon>
            <x-nav.subitem tab="tasks-list">کارهای امروز</x-nav.subitem>
            <x-nav.subitem tab="tasks-kanban">نمای کانبان</x-nav.subitem>
        </x-nav.group>

        {{-- محصولات --}}
        <x-nav.group title="محصولات" :open="request()->is('products/*')">
            <x-slot:icon>
                <i class="fa-solid fa-box text-lg"></i>
            </x-slot:icon>
            <x-nav.subitem tab="products-list">همه محصولات</x-nav.subitem>
            <button
                onclick="navigateTo('/products/quick-create')"
                data-nav-path="/products/quick-create"
                class="nav-btn w-full text-right flex items-center gap-2 px-3 py-2 text-xs font-medium rounded-lg transition-colors
                       {{ request()->is('products/quick-create') ? 'text-brand-primary bg-brand-primary/10' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/50' }}">
                افزودن سریع (شیت)
            </button>
            <x-nav.subitem tab="products-incomplete">محصولات ناقص</x-nav.subitem>
            <x-nav.subitem tab="products-review">صف بررسی</x-nav.subitem>
            <x-nav.subitem tab="products-ready">آماده انتشار</x-nav.subitem>
        </x-nav.group>

        {{-- دستیار هوشمند --}}
        <x-nav.group title="دستیار هوشمند">
            <x-slot:icon>
                <i class="fa-solid fa-wand-magic-sparkles text-lg text-indigo-400"></i>
            </x-slot:icon>
            <x-nav.subitem tab="ai-product-content">محتوای محصول</x-nav.subitem>
            <x-nav.subitem tab="ai-blog-content">محتوای وبلاگ</x-nav.subitem>
            <x-nav.subitem tab="ai-image-generation">ساخت تصویر</x-nav.subitem>
            <x-nav.subitem tab="ai-outputs">تاریخچه تولید</x-nav.subitem>
        </x-nav.group>

        {{-- محتوای سایت --}}
        <x-nav.group title="محتوای سایت">
            <x-slot:icon>
                <i class="fa-solid fa-file-lines text-lg"></i>
            </x-slot:icon>
            <x-nav.subitem tab="site-blog">مقالات وبلاگ</x-nav.subitem>
            <x-nav.subitem tab="site-cookbook">دستور پخت</x-nav.subitem>
            <x-nav.subitem tab="site-ideas">ایده‌پردازی</x-nav.subitem>
            <x-nav.subitem tab="site-ready">صف انتشار</x-nav.subitem>
        </x-nav.group>

        {{-- مدیریت فروش --}}
        <x-nav.group title="مدیریت فروش">
            <x-slot:icon>
                <i class="fa-solid fa-cart-shopping text-lg"></i>
            </x-slot:icon>
            <x-nav.subitem tab="sales-orders">سفارش‌ها</x-nav.subitem>
            <x-nav.subitem tab="sales-customers">مشتریان</x-nav.subitem>
            <x-nav.subitem tab="sales-invoices">فاکتورها</x-nav.subitem>
        </x-nav.group>

        {{-- انبار و تأمین --}}
        <x-nav.group title="انبار و تأمین">
            <x-slot:icon>
                <i class="fa-solid fa-warehouse text-lg"></i>
            </x-slot:icon>
            <x-nav.subitem tab="inventory-stock">مدیریت موجودی</x-nav.subitem>
            <x-nav.subitem tab="inventory-suppliers">تأمین‌کننده‌ها</x-nav.subitem>
            <x-nav.subitem tab="inventory-alerts">هشدار موجودی</x-nav.subitem>
        </x-nav.group>

        {{-- اتصالات --}}
        <x-nav.group title="اتصالات">
            <x-slot:icon>
                <i class="fa-solid fa-link text-lg"></i>
            </x-slot:icon>
            <x-nav.subitem tab="connections">مدیریت اتصالات</x-nav.subitem>
        </x-nav.group>

        {{-- تاریخچه فعالیت --}}
        <x-nav.group title="تاریخچه فعالیت">
            <x-slot:icon>
                <i class="fa-solid fa-bell text-lg"></i>
            </x-slot:icon>
            <x-nav.subitem tab="activity-today">فعالیت امروز</x-nav.subitem>
            <x-nav.subitem tab="activity-changes">تغییرات اخیر</x-nav.subitem>
            <x-nav.subitem tab="activity-errors">خطاهای سیستم</x-nav.subitem>
        </x-nav.group>

        {{-- گزارش آپدیت‌ها --}}
        <x-nav.item
            onclick="navigateTo('/changelog')"
            data-nav-path="/changelog"
            title="گزارش آپدیت‌ها"
            class="{{ request()->is('changelog') ? 'bg-brand-primary/10 !text-brand-primary' : '' }}">
            <i class="fa-solid fa-book-open text-lg shrink-0"></i>
            <span class="mr-3 font-medium sb-text text-sm">گزارش آپدیت‌ها</span>
        </x-nav.item>

        {{-- گزارش‌ها --}}
        <x-nav.item tab="reports" title="گزارش‌ها و آمار">
            <i class="fa-solid fa-chart-bar text-lg shrink-0"></i>
            <span class="mr-3 font-medium sb-text text-sm">گزارش‌ها و آمار</span>
        </x-nav.item>

        {{-- تنظیمات --}}
        <x-nav.group title="تنظیمات سیستم">
            <x-slot:icon>
                <i class="fa-solid fa-gear text-lg"></i>
            </x-slot:icon>
            <x-nav.subitem tab="settings-users">مدیریت کاربران</x-nav.subitem>
            <x-nav.subitem tab="settings-roles">نقش‌ها و دسترسی</x-nav.subitem>
            <x-nav.subitem tab="settings-brand">تنظیمات برند</x-nav.subitem>
            <x-nav.subitem tab="settings-system">پیکربندی سیستم</x-nav.subitem>
        </x-nav.group>

    </nav>

    {{-- Desktop collapse toggle (bottom, desktop only) --}}
    <div class="hidden md:block border-t border-slate-800/60 p-2">
        <button onclick="toggleSidebar()"
                id="sb-toggle-btn"
                class="sb-toggle-btn w-full flex items-center gap-3 px-3 py-2 rounded-xl
                       text-slate-500 hover:text-slate-300 hover:bg-slate-800/60 transition-colors"
                title="جمع کردن منو">
            <i class="fa-solid fa-angles-right text-lg shrink-0"></i>
            <span class="sb-text text-sm font-medium">جمع کردن</span>
        </button>
    </div>

</aside>
