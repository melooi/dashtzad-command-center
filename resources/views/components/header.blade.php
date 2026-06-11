{{-- Top sticky header --}}
<header class="bg-slate-950/80 backdrop-blur-md border-b border-slate-800/80 h-16
               px-4 md:px-8 flex items-center justify-between shrink-0 z-30 relative">

    {{-- Left: Hamburger (mobile) + Page title --}}
    <div class="flex items-center gap-3">
        <button onclick="openMobileSidebar()"
                class="md:hidden p-2 text-slate-400 hover:text-slate-200 hover:bg-slate-800 rounded-xl transition-colors"
                title="باز کردن منو">
            <i class="fa-solid fa-bars text-lg"></i>
        </button>
        <h1 id="header-title"
            class="text-base font-bold text-slate-200 hidden sm:block tracking-tight">
            مدیریت کارها
        </h1>
    </div>

    {{-- Right: Actions --}}
    <div class="flex items-center gap-3 md:gap-4">

        {{-- Search — desktop only --}}
        <div class="relative hidden lg:block">
            <i class="fa-solid fa-magnifying-glass text-slate-500 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-sm"></i>
            <input type="text"
                   placeholder="جستجو..."
                   class="bg-slate-900 border border-slate-800 text-slate-200 text-sm
                          rounded-full pr-9 pl-4 py-1.5 w-44 focus:outline-none
                          focus:border-brand-primary transition-colors placeholder:text-slate-500">
        </div>

        {{-- Jalali date — desktop only --}}
        <div class="hidden lg:block text-sm text-slate-400 border-l border-slate-800 pl-4 ml-1">
            <span data-header-datetime>—</span>
        </div>

        {{-- Theme toggle --}}
        <button onclick="toggleTheme()"
                class="p-2 text-slate-400 hover:text-slate-200 hover:bg-slate-800 rounded-full transition-colors"
                title="تغییر تم">
            <i id="theme-icon" class="fa-solid fa-sun text-brand-tertiary text-lg"></i>
        </button>

        {{-- Notifications bell --}}
        <button onclick="toggleDrawer()"
                class="relative p-2 text-slate-400 hover:text-slate-200
                       hover:bg-slate-800 rounded-full transition-colors">
            <i class="fa-solid fa-bell text-lg"></i>
        </button>

        {{-- User avatar --}}
        <div class="flex items-center gap-2.5 cursor-pointer pl-1 border-r border-slate-800 pr-4">
            <div class="text-left hidden sm:block">
                <div class="text-sm font-semibold text-slate-200 leading-none">مدیر سیستم</div>
            </div>
            <div class="w-9 h-9 rounded-full bg-brand-primary/20 border border-brand-primary/30
                        flex items-center justify-center text-brand-primary font-bold text-sm shrink-0">
                م
            </div>
        </div>

    </div>
</header>
