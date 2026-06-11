{{-- PAGE: آماده انتشار (id=page-products-ready) --}}
<div id="page-products-ready" class="max-w-7xl mx-auto hidden pb-10">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <x-ui.empty-state
            title="هیچ محصولی آماده انتشار نیست"
            description="محصولاتی که تمام مراحل تکمیل شده و منتظر انتشار در سایت هستند اینجا قرار می‌گیرند.">
            <x-slot:icon>
                <i class="fa-solid fa-circle-check text-2xl"></i>
            </x-slot:icon>
        </x-ui.empty-state>
    </div>
</div>
