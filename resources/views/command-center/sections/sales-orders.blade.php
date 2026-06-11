{{-- PAGE: سفارش‌ها (id=page-sales-orders) --}}
<div id="page-sales-orders" class="max-w-7xl mx-auto hidden pb-10">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <x-ui.empty-state
            title="هنوز سفارشی ثبت نشده"
            description="سفارش‌های دریافتی از فروشگاه را پردازش و پیگیری کنید.">
            <x-slot:icon>
                <i class="fa-solid fa-bag-shopping text-2xl"></i>
            </x-slot:icon>
        </x-ui.empty-state>
    </div>
</div>
