{{-- PAGE: تسک‌منیجر — کانبان بورد (id=page-tasks-kanban) --}}
<div id="page-tasks-kanban" class="hidden h-full flex flex-col pb-4">

    {{-- Toolbar --}}
    <div class="flex justify-between items-center mb-4 shrink-0">
        <button onclick="tmOpenModal(null)"
            class="flex items-center gap-2 bg-brand-primary hover:bg-brand-primary/90 text-white
                   text-sm font-bold py-1.5 px-4 rounded-lg transition-colors shadow-sm">
            <i class="fa-solid fa-plus text-sm"></i> وظیفه جدید
        </button>
        <div class="flex gap-2">
            <button class="px-3 py-1.5 bg-brand-primary/10 text-brand-primary border border-brand-primary/20
                           rounded-lg text-xs font-bold">وظایف من</button>
            <button class="px-3 py-1.5 bg-slate-900 text-slate-400 hover:text-slate-200
                           rounded-lg text-xs font-medium border border-slate-800">همه</button>
        </div>
    </div>

    {{-- Kanban Board (populated by JS) --}}
    <div class="flex gap-4 overflow-x-auto pb-4 hide-scrollbar items-start flex-1"
         id="tm-kanban-board"></div>

</div>
