{{-- PAGE: محصولات ناقص (id=page-products-incomplete) --}}
<div id="page-products-incomplete" class="max-w-7xl mx-auto hidden pb-10">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <x-ui.empty-state
            title="هیچ محصول ناقصی وجود ندارد"
            description="محصولاتی که اطلاعات ناقص دارند یا نیاز به تکمیل دارند اینجا نمایش داده می‌شوند.">
            <x-slot:icon>
                <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
            </x-slot:icon>
        </x-ui.empty-state>
    </div>
</div>
