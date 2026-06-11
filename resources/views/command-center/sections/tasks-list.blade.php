{{-- PAGE: مدیریت وظایف — لیست (id=page-tasks-list) --}}
<div id="page-tasks-list" class="max-w-7xl mx-auto space-y-5 pb-10">

    {{-- Stats row --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
        <x-ui.stat-card value="۰" label="کارهای امروز" />
        <x-ui.stat-card value="۰" label="عقب‌افتاده!" color="danger" />
        <x-ui.stat-card value="۰" label="فوری" color="warning" />
        <x-ui.stat-card value="۰" label="در انتظار بررسی" color="info" />
        <x-ui.stat-card value="۰" label="مسدود" color="muted" />
    </div>

    {{-- Quick-add + filters --}}
    <div class="flex flex-col md:flex-row gap-3 items-center justify-between
                bg-slate-900 p-3 rounded-2xl border border-slate-800">
        <div class="flex-1 w-full relative">
            <i class="fa-solid fa-plus text-indigo-500 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-base"></i>
            <input type="text"
                   placeholder="عنوان وظیفه جدید را بنویسید و Enter بزنید..."
                   class="w-full bg-slate-950 border border-slate-800 rounded-xl pr-10 pl-4 py-2.5
                          text-slate-200 text-sm focus:outline-none focus:border-indigo-500
                          focus:ring-1 focus:ring-indigo-500 transition-all placeholder:text-slate-500">
        </div>
        <div class="flex gap-2 w-full md:w-auto overflow-x-auto hide-scrollbar shrink-0">
            <button class="px-3 py-1.5 bg-indigo-600/20 text-indigo-400 border border-indigo-500/30
                           rounded-lg text-xs font-medium whitespace-nowrap">
                وظایف من
            </button>
            <button class="px-3 py-1.5 bg-slate-800 text-slate-400 hover:text-slate-200
                           rounded-lg text-xs font-medium whitespace-nowrap border border-slate-700">
                ارجاع داده‌ام
            </button>
            <button class="px-3 py-1.5 bg-slate-800 text-slate-400 hover:text-rose-400
                           rounded-lg text-xs font-medium whitespace-nowrap border border-slate-700">
                عقب‌افتاده‌ها
            </button>
        </div>
    </div>

    {{-- Task list —— empty state --}}
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <x-ui.empty-state
            title="هیچ وظیفه‌ای وجود ندارد"
            description="وظایف امروز شما اینجا نمایش داده می‌شوند. برای شروع، یک وظیفه جدید اضافه کنید.">
            <x-slot:icon>
                <i class="fa-solid fa-list-check text-2xl"></i>
            </x-slot:icon>
        </x-ui.empty-state>
    </div>

</div>
