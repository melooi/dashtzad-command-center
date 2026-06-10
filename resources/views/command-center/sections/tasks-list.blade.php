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
            <svg class="w-5 h-5 text-indigo-500 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
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
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z"/>
                </svg>
            </x-slot:icon>
        </x-ui.empty-state>
    </div>

</div>
