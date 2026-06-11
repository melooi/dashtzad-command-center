{{-- PAGE: نمای کانبان (id=page-tasks-kanban) --}}
<div id="page-tasks-kanban" class="hidden h-full flex flex-col pb-6">

    {{-- Toolbar --}}
    <div class="flex justify-between items-center mb-4 shrink-0">
        <x-ui.btn variant="primary" size="sm">
            <i class="fa-solid fa-plus text-sm"></i>
            وظیفه جدید
        </x-ui.btn>
        <div class="flex gap-2">
            <button class="px-3 py-1.5 bg-indigo-600/20 text-indigo-400 border border-indigo-500/30
                           rounded-lg text-xs font-medium">وظایف من</button>
            <button class="px-3 py-1.5 bg-slate-800 text-slate-400 hover:text-slate-200
                           rounded-lg text-xs font-medium border border-slate-700">همه</button>
        </div>
    </div>

    {{-- Kanban columns —— empty states --}}
    <div class="flex gap-4 overflow-x-auto pb-4 hide-scrollbar items-start flex-1">
        @foreach([
            ['id' => 'backlog',     'label' => 'صف انجام',        'color' => 'slate'],
            ['id' => 'today',       'label' => 'امروز',           'color' => 'indigo'],
            ['id' => 'in_progress', 'label' => 'در حال انجام',    'color' => 'blue'],
            ['id' => 'blocked',     'label' => 'مسدود',           'color' => 'amber'],
            ['id' => 'review',      'label' => 'در انتظار بررسی', 'color' => 'purple'],
            ['id' => 'done',        'label' => 'انجام‌شده',       'color' => 'emerald'],
        ] as $col)
        <div class="w-64 shrink-0 flex flex-col bg-slate-900/50 rounded-2xl
                    border border-{{ $col['color'] }}-500/20 kanban-col"
             style="min-height: 200px">
            <div class="p-3 border-b border-slate-800/50 flex justify-between items-center
                        bg-slate-900/80 rounded-t-2xl sticky top-0 z-10">
                <h3 class="font-bold text-sm text-{{ $col['color'] }}-400 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-{{ $col['color'] }}-500 inline-block"></span>
                    {{ $col['label'] }}
                </h3>
                <span class="bg-slate-800 text-slate-500 text-[10px] px-2 py-0.5
                             rounded-full font-bold">۰</span>
            </div>
            <div class="p-3 flex-1">
                <div class="text-center text-slate-600 text-xs py-6">خالی</div>
            </div>
        </div>
        @endforeach
    </div>

</div>
