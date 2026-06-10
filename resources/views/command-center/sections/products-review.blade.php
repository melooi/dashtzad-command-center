{{-- PAGE: صف بررسی (id=page-products-review) --}}
<div id="page-products-review" class="max-w-7xl mx-auto hidden pb-10">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <x-ui.empty-state
            title="هیچ محصولی در صف بررسی نیست"
            description="محصولاتی که آماده بررسی نهایی قبل از انتشار هستند اینجا نمایش داده می‌شوند.">
            <x-slot:icon>
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                </svg>
            </x-slot:icon>
        </x-ui.empty-state>
    </div>
</div>
