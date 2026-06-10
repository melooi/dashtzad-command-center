{{-- PAGE: صف انتشار (id=page-site-ready) --}}
<div id="page-site-ready" class="max-w-7xl mx-auto hidden pb-10">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <x-ui.empty-state
            title="صف انتشار خالی است"
            description="محتواهایی که آماده انتشار در سایت هستند و منتظر زمان‌بندی می‌باشند اینجا قرار می‌گیرند.">
            <x-slot:icon>
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/>
                </svg>
            </x-slot:icon>
        </x-ui.empty-state>
    </div>
</div>
