{{-- PAGE: اتصالات و یکپارچگی‌ها (id=page-connections) --}}
<div id="page-connections" class="max-w-7xl mx-auto space-y-12 hidden pb-10">

    {{-- 1. AI --}}
    <section>
        <h2 class="text-lg font-bold text-slate-200 mb-4 flex items-center gap-2">
            <span class="w-1.5 h-6 bg-indigo-500 rounded-full"></span> مدل‌های هوش مصنوعی (AI)
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="group-ai"></div>
    </section>

    {{-- 2. Site & Shop --}}
    <section>
        <h2 class="text-lg font-bold text-slate-200 mb-4 flex items-center gap-2">
            <span class="w-1.5 h-6 bg-pink-500 rounded-full"></span> سایت و فروشگاه
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="group-site"></div>
    </section>

    {{-- 3. SMS --}}
    <section>
        <h2 class="text-lg font-bold text-slate-200 mb-4 flex items-center gap-2">
            <span class="w-1.5 h-6 bg-amber-500 rounded-full"></span> پیامک و تماس
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="group-sms"></div>
    </section>

    {{-- 4. Google --}}
    <section>
        <h2 class="text-lg font-bold text-slate-200 mb-4 flex items-center gap-2">
            <span class="w-1.5 h-6 bg-blue-500 rounded-full"></span> سرویس‌های گوگل
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5" id="group-google"></div>
    </section>

    {{-- 5. Messengers --}}
    <section>
        <h2 class="text-lg font-bold text-slate-200 mb-4 flex items-center gap-2">
            <span class="w-1.5 h-6 bg-emerald-500 rounded-full"></span> پیام‌رسان‌ها و ایمیل
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="group-messengers"></div>
    </section>

</div>

{{-- ============================================================
     Config Modal — connections page (fixed, rendered via JS)
     ============================================================ --}}
<div id="config-modal-backdrop" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center hidden-fade p-4">
    <div id="config-modal" class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-lg shadow-2xl transform scale-95 transition-transform duration-200 flex flex-col max-h-[90vh]">

        <div class="flex items-center justify-between p-5 border-b border-slate-800/80 shrink-0">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                تنظیمات <span id="modal-service-name" class="font-mono text-indigo-400" dir="ltr"></span>
            </h3>
            <button onclick="closeModal('config-modal')" class="text-slate-500 hover:text-white transition-colors bg-slate-800/50 hover:bg-slate-700 p-1.5 rounded-lg">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <div class="p-6 space-y-5 overflow-y-auto" id="modal-fields-container">
            {{-- Fields injected by JS --}}
        </div>

        <div class="p-5 border-t border-slate-800/80 flex gap-3 bg-slate-850/50 rounded-b-2xl shrink-0">
            <button onclick="closeModal('config-modal')" class="flex-1 py-2.5 text-sm font-bold text-slate-300 bg-slate-800 hover:bg-slate-700 rounded-xl transition-colors">انصراف</button>
            <button onclick="saveConnectionsModal()" class="flex-[2] py-2.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl transition-colors shadow-lg shadow-indigo-900/20">ذخیره تغییرات</button>
        </div>

    </div>
</div>
