{{-- PAGE: تسک‌منیجر — لیست و داشبورد (id=page-tasks-list) --}}
<div id="page-tasks-list" class="max-w-5xl mx-auto space-y-4 pb-10">

    {{-- Metrics --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
        <div class="bg-slate-900 border border-slate-800 rounded-xl p-4 flex flex-col items-center text-center">
            <span class="text-3xl font-bold text-slate-200" id="tm-m-total">۰</span>
            <span class="text-xs text-brand-neutral mt-1">تسک امروز</span>
        </div>
        <div class="bg-slate-900 border border-rose-500/30 rounded-xl p-4 flex flex-col items-center text-center relative overflow-hidden">
            <div class="absolute inset-0 bg-rose-500/5 pointer-events-none"></div>
            <span class="text-3xl font-bold text-rose-500 relative z-10" id="tm-m-overdue">۰</span>
            <span class="text-xs text-rose-400 mt-1 font-bold relative z-10">عقب‌افتاده</span>
        </div>
        <div class="bg-slate-900 border border-slate-800 rounded-xl p-4 flex flex-col items-center text-center">
            <span class="text-3xl font-bold text-brand-secondary" id="tm-m-urgent">۰</span>
            <span class="text-xs text-brand-neutral mt-1">فوری</span>
        </div>
        <div class="bg-slate-900 border border-slate-800 rounded-xl p-4 flex flex-col items-center text-center">
            <span class="text-3xl font-bold text-brand-tertiary" id="tm-m-review">۰</span>
            <span class="text-xs text-brand-neutral mt-1">نیاز به بررسی</span>
        </div>
        <div class="bg-slate-900 border border-slate-800 rounded-xl p-4 flex flex-col items-center text-center">
            <span class="text-3xl font-bold text-brand-primary" id="tm-m-done">۰</span>
            <span class="text-xs text-brand-neutral mt-1">انجام‌شده</span>
        </div>
    </div>

    {{-- Task List Container --}}
    <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden flex flex-col">

        {{-- Quick Add --}}
        <form onsubmit="tmQuickCreate(event)" class="p-3 border-b border-slate-800 relative">
            <i class="fa-solid fa-plus text-brand-primary absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-sm"></i>
            <input type="text" id="tm-quick-input"
                placeholder="تسک جدید را تایپ کنید و Enter بزنید..."
                class="w-full bg-slate-950 border border-slate-800 rounded-lg pr-10 pl-4 py-2 text-slate-200 text-sm
                       focus:outline-none focus:border-brand-primary transition-all placeholder:text-slate-500">
        </form>

        {{-- Filters --}}
        <div class="px-3 py-2 border-b border-slate-800 flex items-center gap-2 overflow-x-auto hide-scrollbar">
            <button onclick="tmFilterSet('mine')" id="tmf-mine"
                class="tm-filter-btn px-3 py-1 bg-brand-primary/10 text-brand-primary border border-brand-primary/20 rounded-full text-xs font-bold whitespace-nowrap">
                تسک‌های من
            </button>
            <button onclick="tmFilterSet('assigned')" id="tmf-assigned"
                class="tm-filter-btn px-3 py-1 bg-slate-800 text-slate-400 rounded-full text-xs font-medium whitespace-nowrap border border-slate-700 transition-colors">
                من داده‌ام
            </button>
            <button onclick="tmFilterSet('overdue')" id="tmf-overdue"
                class="tm-filter-btn px-3 py-1 bg-slate-800 text-slate-400 rounded-full text-xs font-medium whitespace-nowrap border border-slate-700 transition-colors">
                عقب‌افتاده‌ها
            </button>
        </div>

        {{-- List --}}
        <div class="flex-1 divide-y divide-slate-800" id="tm-list-container"></div>

    </div>

</div>

{{-- ── Task Detail Modal (fixed — outside page div) ───────────────────────── --}}
<div id="tm-modal-backdrop"
     class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center hidden-fade p-4"
     onclick="tmCloseModal()">
    <div id="tm-modal"
         class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-[1100px] shadow-2xl
                transform scale-95 transition-transform duration-200 flex flex-col"
         style="height:88vh;max-height:88vh"
         onclick="event.stopPropagation()">

        {{-- Modal Header --}}
        <div class="flex items-start justify-between p-5 border-b border-slate-800 shrink-0 bg-slate-950/40 rounded-t-2xl">
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 mb-2" id="tm-header-badges"></div>
                <h3 id="tm-modal-title" class="text-xl font-bold text-slate-100 truncate">عنوان تسک</h3>
            </div>
            <button onclick="tmCloseModal()"
                class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-rose-400
                       transition-colors bg-slate-800 rounded-lg border border-slate-700 shrink-0 mr-3">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        {{-- Modal Body: 3 columns --}}
        <div class="flex flex-col lg:flex-row flex-1 overflow-hidden">

            {{-- Col 1: Meta --}}
            <div class="w-full lg:w-60 flex flex-col shrink-0 overflow-y-auto border-l border-slate-800
                        p-4 space-y-4 bg-slate-950/30">
                <div>
                    <span class="block text-xs font-bold text-brand-neutral mb-2">وضعیت</span>
                    <select id="tm-modal-status"
                        class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm
                               text-slate-200 outline-none focus:border-brand-primary appearance-none cursor-pointer font-bold">
                        <option value="backlog">در صف</option>
                        <option value="today">امروز</option>
                        <option value="in_progress">در حال انجام</option>
                        <option value="review">نیاز به بررسی</option>
                        <option value="done">انجام‌شده</option>
                        <option value="blocked">مسدود</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <span class="block text-[11px] font-bold text-brand-neutral mb-1.5">اولویت</span>
                        <select id="tm-modal-priority"
                            class="w-full bg-slate-900 border border-slate-700 rounded-lg px-2 py-1.5 text-xs
                                   text-slate-200 outline-none appearance-none cursor-pointer">
                            <option value="high">فوری</option>
                            <option value="important">مهم</option>
                            <option value="normal">عادی</option>
                        </select>
                    </div>
                    <div>
                        <span class="block text-[11px] font-bold text-brand-neutral mb-1.5">ددلاین</span>
                        <div class="bg-slate-900 border border-slate-700 rounded-lg px-2 py-1.5 text-xs
                                    font-bold text-slate-200 flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar text-brand-neutral"></i>
                            <span id="tm-modal-date">انتخاب</span>
                        </div>
                    </div>
                </div>
                <div class="space-y-2 bg-slate-900 p-3 rounded-xl border border-slate-800">
                    <div>
                        <span class="block text-[10px] font-bold text-brand-neutral mb-1">مسئول انجام</span>
                        <div class="flex items-center gap-2 bg-slate-950/50 border border-slate-700 rounded-lg px-2 py-1.5">
                            <div class="w-6 h-6 rounded-md bg-brand-primary/20 text-brand-primary flex items-center justify-center text-[10px] font-bold"
                                 id="tm-modal-assignee-initial">ع‌ر</div>
                            <span class="text-xs font-bold text-slate-200" id="tm-modal-assignee">علی رضایی</span>
                        </div>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold text-brand-neutral mb-1">ناظر</span>
                        <div class="flex items-center gap-2 bg-slate-950/50 border border-slate-700 rounded-lg px-2 py-1.5">
                            <div class="w-6 h-6 rounded-md bg-brand-secondary/20 text-brand-secondary flex items-center justify-center text-[10px] font-bold">م‌ا</div>
                            <span class="text-xs font-bold text-slate-200">مهدی احمدی</span>
                        </div>
                    </div>
                </div>
                <div>
                    <span class="block text-[11px] font-bold text-brand-neutral mb-1.5">پروژه</span>
                    <div class="text-xs font-bold text-slate-300 px-2 py-1.5 bg-slate-900 border border-slate-800 rounded-lg"
                         id="tm-modal-project">دشت‌زاد</div>
                </div>
                <div>
                    <span class="block text-[11px] font-bold text-brand-neutral mb-1.5">دسته‌بندی</span>
                    <div class="text-xs font-bold text-slate-300 px-2 py-1.5 bg-slate-900 border border-slate-800 rounded-lg"
                         id="tm-modal-category">عمومی</div>
                </div>
            </div>

            {{-- Col 2: Content --}}
            <div class="flex-1 flex flex-col border-l border-slate-800 overflow-y-auto p-5 space-y-5">
                <div>
                    <h4 class="text-sm font-bold text-slate-200 flex items-center gap-2 mb-3">
                        <i class="fa-solid fa-align-right text-brand-primary"></i> شرح کار
                    </h4>
                    <div class="text-sm text-slate-400 leading-relaxed bg-slate-950/40 p-4 rounded-xl border border-slate-800"
                         id="tm-modal-desc">جزئیات تسک اینجا نمایش داده می‌شود.</div>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-brand-secondary flex items-center gap-2 mb-3">
                        <i class="fa-solid fa-bullseye"></i> خروجی مورد انتظار
                    </h4>
                    <div class="bg-brand-secondary/10 border border-brand-secondary/25 p-4 rounded-xl text-sm text-slate-300"
                         id="tm-modal-dod">تعریف دقیق خروجی تسک.</div>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-200 flex items-center gap-2 mb-3">
                        <i class="fa-solid fa-list-check text-brand-tertiary"></i> چک‌لیست
                    </h4>
                    <div class="space-y-2 bg-slate-950/40 p-4 rounded-xl border border-slate-800"
                         id="tm-modal-checklist">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" class="task-checkbox" checked>
                            <span class="text-sm text-slate-500 line-through">طراحی اولیه</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" class="task-checkbox">
                            <span class="text-sm text-slate-300">پیاده‌سازی</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Col 3: Chat / Log / AI --}}
            <div class="w-full lg:w-80 flex flex-col bg-slate-950/30 border-t lg:border-t-0 border-slate-800">

                {{-- Tab bar --}}
                <div class="flex items-center justify-between border-b border-slate-800 px-2 pt-2 shrink-0">
                    <div class="flex items-center gap-0.5">
                        <button onclick="tmModalTab('chat')" id="tm-tab-chat"
                            class="px-4 py-2.5 text-sm font-bold text-brand-primary border-b-2 border-brand-primary transition-colors">
                            گزارش و چت
                        </button>
                        <button onclick="tmModalTab('log')" id="tm-tab-log"
                            class="px-4 py-2.5 text-sm font-medium text-slate-400 border-b-2 border-transparent transition-colors">
                            لاگ <i class="fa-solid fa-lock text-[10px] ml-1"></i>
                        </button>
                    </div>
                    <button onclick="tmModalTab('ai')" id="tm-tab-ai"
                        class="ml-2 px-3 py-1.5 text-xs font-bold text-brand-primary bg-brand-primary/10
                               rounded-lg flex items-center gap-1.5 mb-1 border border-brand-primary/20">
                        <i class="fa-solid fa-robot"></i> دستیار
                    </button>
                </div>

                {{-- Chat --}}
                <div id="tm-tcontent-chat" class="flex-1 flex flex-col overflow-hidden">
                    <div class="flex-1 overflow-y-auto p-4 space-y-4" id="tm-chat-list">
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-full bg-brand-secondary/20 text-brand-secondary flex items-center justify-center text-xs font-bold shrink-0">م‌ا</div>
                            <div class="bg-slate-800 border border-slate-700 p-3 rounded-xl rounded-tr-sm text-sm text-slate-200">
                                <div class="font-bold text-xs text-brand-secondary mb-1">مهدی احمدی (ناظر)</div>
                                لطفاً بخش موبایل را هم تست کنید.
                            </div>
                        </div>
                    </div>
                    <div class="p-3 border-t border-slate-800">
                        <div class="relative bg-slate-900 border border-slate-700 rounded-xl overflow-hidden focus-within:border-brand-primary transition-all">
                            <textarea rows="2" placeholder="گزارش کار یا پیام..."
                                class="w-full bg-transparent px-4 py-3 text-slate-200 text-sm outline-none resize-none hide-scrollbar placeholder:text-slate-500"></textarea>
                            <div class="flex items-center justify-between px-2 pb-2">
                                <button class="text-slate-500 hover:text-brand-primary p-1.5 transition-colors">
                                    <i class="fa-solid fa-paperclip"></i>
                                </button>
                                <button class="bg-brand-primary text-white text-xs px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-brand-primary/90 transition-colors">
                                    ارسال <i class="fa-solid fa-paper-plane transform rtl:-scale-x-100"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Log --}}
                <div id="tm-tcontent-log" class="flex-1 overflow-y-auto p-5 hidden">
                    <div class="text-xs font-bold text-brand-neutral mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-lock text-[10px]"></i> لاگ سیستمی — غیرقابل ویرایش
                    </div>
                    <div class="space-y-4 relative">
                        <div class="absolute right-2 top-0 bottom-0 w-px bg-slate-800"></div>
                        <div class="flex gap-4 pr-6">
                            <div class="flex-1 p-3 rounded-lg border border-slate-800 bg-slate-900">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="font-bold text-brand-primary text-xs">تغییر وضعیت</span>
                                    <time class="text-[10px] text-brand-neutral">۱۴:۳۰</time>
                                </div>
                                <div class="text-xs text-slate-400">به <span class="font-bold">در حال انجام</span> توسط علی رضایی</div>
                            </div>
                        </div>
                        <div class="flex gap-4 pr-6">
                            <div class="flex-1 p-3 rounded-lg border border-slate-800 bg-slate-900">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="font-bold text-brand-secondary text-xs">ایجاد تسک</span>
                                    <time class="text-[10px] text-brand-neutral">۱۱:۰۰</time>
                                </div>
                                <div class="text-xs text-slate-400">توسط مدیر سیستم</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- AI --}}
                <div id="tm-tcontent-ai" class="hidden flex-1 flex-col overflow-hidden bg-brand-primary/5">
                    <div class="flex-1 overflow-y-auto p-4 space-y-4" id="tm-ai-messages">
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-xl bg-brand-primary flex items-center justify-center text-white shrink-0">
                                <i class="fa-solid fa-robot text-sm"></i>
                            </div>
                            <div class="bg-slate-900 border border-slate-700 p-3 rounded-xl rounded-tr-sm text-sm text-slate-200">
                                سلام! دستیار دشت‌زاد هستم. چه کمکی نیاز دارید؟
                            </div>
                        </div>
                    </div>
                    <div class="p-3 border-t border-slate-800">
                        <div class="relative flex items-center">
                            <input type="text" id="tm-ai-input" placeholder="سوال خود را بپرسید..."
                                class="w-full bg-slate-900 border border-slate-700 rounded-full pl-12 pr-4 py-2.5
                                       text-sm outline-none focus:border-brand-primary placeholder:text-slate-500 text-slate-200">
                            <button onclick="tmAISubmit()"
                                class="absolute left-1.5 w-8 h-8 flex items-center justify-center bg-brand-primary text-white rounded-full hover:bg-brand-primary/90 transition-colors">
                                <i class="fa-solid fa-paper-plane transform rtl:-scale-x-100 text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        {{-- Modal Footer --}}
        <div class="p-4 border-t border-slate-800 flex justify-end gap-3 bg-slate-950/30 rounded-b-2xl shrink-0">
            <button onclick="tmCloseModal()"
                class="px-4 py-2 text-sm font-medium text-slate-400 bg-slate-800 border border-slate-700
                       rounded-lg hover:border-slate-600 transition-colors">بستن</button>
            <button onclick="tmSaveModal()"
                class="px-5 py-2 text-sm font-bold text-white bg-brand-primary hover:bg-brand-primary/90
                       rounded-lg transition-colors shadow-lg shadow-brand-primary/20">ذخیره تغییرات</button>
        </div>

    </div>
</div>
