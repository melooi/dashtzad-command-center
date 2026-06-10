{{-- Top sticky header --}}
<header class="bg-slate-950/80 backdrop-blur-md border-b border-slate-800/80 h-16
               px-4 md:px-8 flex items-center justify-between shrink-0 z-30 relative">

    {{-- Left: Page title --}}
    <div class="flex items-center gap-4">
        <h1 id="header-title"
            class="text-base font-bold text-white hidden sm:block tracking-tight">
            مدیریت کارها
        </h1>
    </div>

    {{-- Right: Actions --}}
    <div class="flex items-center gap-3 md:gap-5">

        {{-- Search —— desktop only --}}
        <div class="relative hidden lg:block">
            <svg class="w-4 h-4 text-slate-500 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text"
                   placeholder="جستجو..."
                   class="bg-slate-900 border border-slate-800 text-slate-200 text-sm
                          rounded-full pr-9 pl-4 py-1.5 w-44 focus:outline-none
                          focus:border-indigo-500 transition-colors placeholder:text-slate-500">
        </div>

        {{-- Jalali date —— desktop only --}}
        <div class="hidden lg:block text-sm text-slate-400 border-l border-slate-800 pl-5 ml-1">
            امروز: <span class="text-slate-200 font-medium">—</span>
        </div>

        {{-- Notifications bell --}}
        <button onclick="toggleDrawer()"
                class="relative p-2 text-slate-400 hover:text-slate-200
                       hover:bg-slate-800 rounded-full transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18
                         9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64
                         3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3
                         3 0 1 1-5.714 0"/>
            </svg>
        </button>

        {{-- User avatar --}}
        <div class="flex items-center gap-2.5 cursor-pointer pl-1 border-r border-slate-800 pr-4">
            <div class="text-left hidden sm:block">
                <div class="text-sm font-semibold text-slate-200 leading-none">مدیر سیستم</div>
            </div>
            <div class="w-9 h-9 rounded-full bg-indigo-600/20 border border-indigo-500/30
                        flex items-center justify-center text-indigo-400 font-bold text-sm
                        shrink-0">
                م
            </div>
        </div>

    </div>
</header>
