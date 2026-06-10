{{-- Activity side-drawer + backdrop --}}

{{-- Backdrop overlay --}}
<div id="drawer-overlay"
     class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 hidden-fade"
     onclick="toggleDrawer()">
</div>

{{-- Drawer panel (slides in from left in RTL layout) --}}
<div id="activity-drawer"
     class="fixed top-0 bottom-0 left-0 w-80 max-w-full bg-slate-900 border-r border-slate-800
            transform -translate-x-full transition-transform duration-300 z-50 flex flex-col shadow-2xl">

    {{-- Header --}}
    <div class="h-16 flex items-center justify-between px-5 border-b border-slate-800/80 shrink-0">
        <h2 class="text-base font-bold text-white">تاریخچه فعالیت‌ها</h2>
        <button onclick="toggleDrawer()"
                class="p-2 text-slate-400 hover:text-white rounded-lg hover:bg-slate-800 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Body --}}
    <div class="flex-1 overflow-y-auto p-5">
        <x-ui.empty-state
            title="هنوز فعالیتی ثبت نشده"
            description="هر بار که تغییری در سیستم ایجاد شود اینجا نمایش داده می‌شود."
        />
    </div>
</div>
