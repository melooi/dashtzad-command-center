{{-- PAGE: هشدار موجودی (id=page-inventory-alerts) --}}
<div id="page-inventory-alerts" class="max-w-7xl mx-auto hidden pb-10">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <x-ui.empty-state
            title="هیچ هشداری وجود ندارد"
            description="محصولاتی که موجودی آن‌ها به حد هشدار رسیده اینجا نمایش داده می‌شوند.">
            <x-slot:icon>
                <i class="fa-solid fa-bell text-2xl"></i>
            </x-slot:icon>
        </x-ui.empty-state>
    </div>
</div>
