{{-- PAGE: محصولات ناقص (id=page-products-incomplete) --}}
<div id="page-products-incomplete" class="max-w-7xl mx-auto hidden pb-10">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <x-ui.empty-state
            title="هیچ محصول ناقصی وجود ندارد"
            description="محصولاتی که اطلاعات ناقص دارند یا نیاز به تکمیل دارند اینجا نمایش داده می‌شوند.">
            <x-slot:icon>
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                </svg>
            </x-slot:icon>
        </x-ui.empty-state>
    </div>
</div>
