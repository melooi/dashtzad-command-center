{{-- PAGE: سفارش‌ها (id=page-sales-orders) --}}
<div id="page-sales-orders" class="max-w-7xl mx-auto hidden pb-10">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <x-ui.empty-state
            title="هنوز سفارشی ثبت نشده"
            description="سفارش‌های دریافتی از فروشگاه را پردازش و پیگیری کنید.">
            <x-slot:icon>
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                </svg>
            </x-slot:icon>
        </x-ui.empty-state>
    </div>
</div>
