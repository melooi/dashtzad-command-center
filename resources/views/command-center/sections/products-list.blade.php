{{-- PAGE: همه محصولات (id=page-products-list) --}}
<div id="page-products-list" class="max-w-7xl mx-auto hidden pb-10">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <x-ui.empty-state
            title="هنوز محصولی ثبت نشده"
            description="محصولات فروشگاه را از اینجا مدیریت کنید. با افزودن اولین محصول شروع کنید.">
            <x-slot:icon>
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/>
                </svg>
            </x-slot:icon>
        </x-ui.empty-state>
    </div>
</div>
