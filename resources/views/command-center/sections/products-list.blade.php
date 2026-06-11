{{-- PAGE: همه محصولات (id=page-products-list) --}}
<div id="page-products-list" class="max-w-7xl mx-auto hidden pb-10">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <x-ui.empty-state
            title="هنوز محصولی ثبت نشده"
            description="محصولات فروشگاه را از اینجا مدیریت کنید. با افزودن اولین محصول شروع کنید.">
            <x-slot:icon>
                <i class="fa-solid fa-boxes-stacked text-2xl"></i>
            </x-slot:icon>
        </x-ui.empty-state>
    </div>
</div>
