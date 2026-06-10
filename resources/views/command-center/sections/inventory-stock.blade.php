{{-- PAGE: مدیریت موجودی (id=page-inventory-stock) --}}
<div id="page-inventory-stock" class="max-w-7xl mx-auto hidden pb-10">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <x-ui.empty-state
            title="اطلاعات موجودی در دسترس نیست"
            description="وضعیت موجودی انبار، ورود و خروج کالا و تغییرات استاک را اینجا مدیریت کنید.">
            <x-slot:icon>
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M20.25 7.5 19.625 18.132a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/>
                </svg>
            </x-slot:icon>
        </x-ui.empty-state>
    </div>
</div>
