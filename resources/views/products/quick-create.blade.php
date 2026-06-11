<x-layouts.app>

{{-- ═══════════════════════════════════════════════════════
     Page Header
════════════════════════════════════════════════════════ --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-4">
    <div class="flex items-center gap-3">
        <div class="w-9 h-9 bg-indigo-600/20 border border-indigo-500/20 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                      d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375
                         19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125
                         1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125
                         1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0
                         0h-7.5M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125
                         1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0
                         1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125
                         1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0
                         .621-.504 1.125-1.125 1.125m-17.25 0h7.5"/>
            </svg>
        </div>
        <div>
            <h2 class="text-base font-bold text-white leading-tight">افزودن سریع محصولات</h2>
            <p class="text-[11px] text-slate-500 mt-0.5">ورود سریع اطلاعات چندین محصول به‌صورت جدولی</p>
        </div>
        {{-- Autosave badge --}}
        <span id="autosave-badge"
              class="flex items-center gap-1 bg-slate-800/80 text-slate-400 border border-slate-700/80 text-[10px] px-2 py-1 rounded-md font-mono">
            آفلاین
        </span>
    </div>

    <div class="flex items-center gap-2">
        <button class="flex items-center gap-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-medium py-1.5 px-3 rounded-lg transition-colors border border-slate-700/80"
                title="درون‌ریزی از فایل اکسل">
            <svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414
                         5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span class="hidden sm:inline">درون‌ریزی</span>
        </button>
        <button class="flex items-center gap-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-medium py-1.5 px-3 rounded-lg transition-colors border border-slate-700/80"
                title="برون‌بری به فایل اکسل">
            <svg class="w-3.5 h-3.5 text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 14v-6m0 0l3 3m-3-3l-3 3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414
                         5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span class="hidden sm:inline">برون‌بری</span>
        </button>
        <div class="h-5 w-px bg-slate-700"></div>
        <button onclick="qcSendAll()"
                class="flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold py-1.5 px-4 rounded-lg transition-colors shadow-lg shadow-indigo-900/20">
            ارسال همه به بررسی
        </button>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     Sheet Container
════════════════════════════════════════════════════════ --}}
<div class="bg-slate-900 border border-slate-800/80 rounded-xl overflow-hidden shadow-sm flex flex-col">

    {{-- Scrollable table --}}
    <div class="overflow-auto hide-scrollbar max-h-[calc(100dvh-240px)]" id="table-scroll-container">
        <table class="w-full text-sm text-right whitespace-nowrap border-collapse" style="min-width:1180px">

            {{-- Sticky header --}}
            <thead class="bg-slate-900 border-b border-slate-800/80 select-none sticky top-0 z-20 shadow-sm">
                <tr>
                    <th class="w-10 px-2 py-3 text-center text-slate-500 text-xs font-medium border-l border-slate-800/50">#</th>
                    <th class="w-14 px-2 py-3 text-center text-slate-500 text-xs font-medium border-l border-slate-800/50">تصویر</th>
                    <th class="px-4 py-3 text-slate-300 text-xs font-semibold border-l border-slate-800/50 min-w-[200px]">
                        عنوان محصول <span class="text-rose-500">*</span>
                    </th>
                    <th class="px-4 py-3 text-slate-300 text-xs font-semibold border-l border-slate-800/50 min-w-[160px]">
                        URL / Slug <span class="text-rose-500">*</span>
                    </th>
                    <th class="px-4 py-3 text-slate-400 text-xs font-medium border-l border-slate-800/50 min-w-[110px]">SKU</th>
                    <th class="px-4 py-3 text-slate-400 text-xs font-medium border-l border-slate-800/50 min-w-[130px]">دسته‌بندی</th>
                    <th class="px-4 py-3 text-slate-400 text-xs font-medium border-l border-slate-800/50 min-w-[90px]">وزن (kg)</th>
                    <th class="px-4 py-3 text-slate-400 text-xs font-medium border-l border-slate-800/50 min-w-[120px]">قیمت خط‌خورده</th>
                    <th class="px-4 py-3 text-emerald-400 text-xs font-semibold border-l border-slate-800/50 min-w-[120px]">
                        قیمت فروش <span class="text-rose-500">*</span>
                    </th>
                    <th class="px-4 py-3 text-slate-400 text-xs font-medium border-l border-slate-800/50 min-w-[80px]">موجودی</th>
                    <th class="px-4 py-3 text-slate-400 text-xs font-medium border-l border-slate-800/50 min-w-[150px]">وضعیت و نواقص</th>
                    <th class="px-3 py-3 text-slate-400 text-xs font-medium border-l border-slate-800/50 text-center min-w-[100px]">تکمیل</th>
                    <th class="px-2 py-3 text-slate-500 text-xs font-medium border-l border-slate-800/50 text-center min-w-[90px]">آخرین ویرایش</th>
                    <th class="px-2 py-3 text-center text-slate-500 text-xs font-medium sticky left-0 bg-slate-900 z-10 min-w-[120px]
                               shadow-[-4px_0_8px_rgba(0,0,0,0.25)]">عملیات و تسک</th>
                </tr>
            </thead>

            {{-- Rows injected by JS --}}
            <tbody id="sheet-body" class="divide-y divide-slate-800/60"></tbody>

            {{-- Add row footer --}}
            <tfoot>
                <tr class="group cursor-pointer hover:bg-slate-800/40 transition-colors" onclick="addRow()">
                    <td colspan="14" class="py-3 px-4 border-t border-dashed border-slate-700/60">
                        <div class="flex items-center justify-center gap-2 text-indigo-400 text-xs font-bold
                                    opacity-70 group-hover:opacity-100 transition-opacity">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            افزودن ردیف جدید
                        </div>
                    </td>
                </tr>
            </tfoot>

        </table>
    </div>

    {{-- Hint bar --}}
    <div class="bg-slate-900/60 border-t border-slate-800/60 px-4 py-2.5 flex items-center gap-4 shrink-0">
        <p class="text-[11px] text-slate-500 leading-relaxed">
            <span class="font-bold text-slate-400">راهنما:</span>
            کپی از اکسل و <kbd class="px-1 py-0.5 bg-slate-800 rounded border border-slate-700 font-mono text-[10px]">Ctrl+V</kbd> در هر سلول
            — <kbd class="px-1 py-0.5 bg-slate-800 rounded border border-slate-700 font-mono text-[10px]">Tab</kbd> / فلش‌ها برای ناوبری
            — <kbd class="px-1 py-0.5 bg-slate-800 rounded border border-slate-700 font-mono text-[10px]">Ctrl+D</kbd> تکرار ردیف
            — <kbd class="px-1 py-0.5 bg-slate-800 rounded border border-slate-700 font-mono text-[10px]">Delete</kbd> حذف ردیف خالی
        </p>
    </div>

</div>

{{-- ═══════════════════════════════════════════════════════
     Edit Modal (ویرایش جامع محصول)
════════════════════════════════════════════════════════ --}}
<div id="edit-modal-backdrop"
     class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center hidden-fade p-4">
    <div id="edit-modal"
         class="bg-slate-900 border border-slate-800/80 rounded-2xl w-full max-w-5xl shadow-2xl
                transform scale-95 transition-transform duration-200 flex flex-col"
         style="max-height:90dvh">

        {{-- Modal header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-800/80 shrink-0">
            <h3 class="text-base font-bold text-white flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2
                             2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                ویرایش جامع:
                <span id="modal-product-name" class="text-slate-400 font-normal">محصول جدید</span>
            </h3>
            <button onclick="closeEditModal()"
                    class="text-slate-500 hover:text-white bg-slate-800/60 hover:bg-slate-700 p-1.5 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Modal body: sidebar tabs + content --}}
        <div class="flex flex-1 overflow-hidden">

            {{-- Tab list --}}
            <div class="w-44 bg-slate-950/40 border-l border-slate-800/60 flex flex-col p-2.5 gap-0.5 shrink-0 overflow-y-auto">
                <button onclick="switchModalTab('general')" id="tab-general"
                        class="modal-tab-btn w-full text-right px-3 py-2.5 rounded-lg text-sm font-bold text-indigo-400 bg-indigo-600/10 transition-colors">
                    محتوا
                </button>
                <button onclick="switchModalTab('pricing')" id="tab-pricing"
                        class="modal-tab-btn w-full text-right px-3 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:text-slate-200 hover:bg-slate-800 transition-colors">
                    قیمت‌گذاری
                </button>
                <button onclick="switchModalTab('media')" id="tab-media"
                        class="modal-tab-btn w-full text-right px-3 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:text-slate-200 hover:bg-slate-800 transition-colors">
                    رسانه و گالری
                </button>
                <button onclick="switchModalTab('inventory')" id="tab-inventory"
                        class="modal-tab-btn w-full text-right px-3 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:text-slate-200 hover:bg-slate-800 transition-colors">
                    انبار
                </button>
                <div class="h-px bg-slate-800/80 my-1.5"></div>
                <button onclick="switchModalTab('seo')" id="tab-seo"
                        class="modal-tab-btn w-full text-right px-3 py-2.5 rounded-lg text-sm font-medium text-amber-500 hover:bg-slate-800 transition-colors">
                    سئو
                </button>
                <button onclick="switchModalTab('history')" id="tab-history"
                        class="modal-tab-btn w-full text-right px-3 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:text-slate-200 hover:bg-slate-800 transition-colors">
                    تاریخچه محصول
                </button>
            </div>

            {{-- Tab content area --}}
            <div class="flex-1 overflow-y-auto p-6 bg-slate-900">

                {{-- ── Tab: محتوا ──────────────────────────────────────── --}}
                <div id="content-general" class="modal-tab-content block space-y-5">
                    <div>
                        <label class="flex items-center gap-2 text-sm font-bold text-slate-200 mb-2">
                            توضیح کوتاه
                            <button onclick="openTaskModal('فیلد','توضیح کوتاه محصول')"
                                    class="text-slate-500 hover:text-amber-400 transition-colors" title="ایجاد تسک">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                            </button>
                        </label>
                        <textarea rows="2"
                                  class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-3 text-sm text-slate-200 outline-none resize-none focus:border-indigo-500 transition-colors placeholder-slate-600"
                                  placeholder="خلاصه‌ای از محصول برای نمایش زیر قیمت..."></textarea>
                    </div>
                    <div>
                        <label class="flex items-center gap-2 text-sm font-bold text-slate-200 mb-2">
                            توضیح کامل
                            <button onclick="openTaskModal('فیلد','توضیح کامل محصول')"
                                    class="text-slate-500 hover:text-amber-400 transition-colors" title="ایجاد تسک">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                            </button>
                        </label>
                        <textarea rows="6"
                                  class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-3 text-sm text-slate-200 outline-none resize-none focus:border-indigo-500 transition-colors placeholder-slate-600"
                                  placeholder="معرفی و نقد و بررسی جامع محصول..."></textarea>
                    </div>
                    <div>
                        <label class="flex items-center gap-2 text-sm font-bold text-slate-200 mb-2">
                            ویژگی‌ها (بولت‌پوینت)
                            <button onclick="openTaskModal('فیلد','ویژگی‌های محصول')"
                                    class="text-slate-500 hover:text-amber-400 transition-colors" title="ایجاد تسک">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                            </button>
                        </label>
                        <textarea rows="3"
                                  class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-3 text-sm text-slate-200 outline-none resize-none focus:border-indigo-500 transition-colors placeholder-slate-600"
                                  placeholder="ویژگی ۱&#10;ویژگی ۲&#10;ویژگی ۳"></textarea>
                    </div>
                </div>

                {{-- ── Tab: قیمت‌گذاری ──────────────────────────────── --}}
                <div id="content-pricing" class="modal-tab-content hidden space-y-6">
                    <div class="grid grid-cols-3 gap-5">
                        <div>
                            <label class="flex items-center gap-1.5 text-sm text-slate-400 mb-2">
                                قیمت خرید (تومان)
                                <button onclick="openTaskModal('فیلد','قیمت خرید')" class="text-slate-500 hover:text-amber-400 transition-colors" title="تسک">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                </button>
                            </label>
                            <input type="number" dir="ltr" placeholder="جهت محاسبه سود"
                                   class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-slate-200 outline-none font-mono focus:border-indigo-500 transition-colors">
                        </div>
                        <div>
                            <label class="flex items-center gap-1.5 text-sm text-slate-400 mb-2">
                                قیمت خط‌خورده
                                <button onclick="openTaskModal('فیلد','قیمت عادی')" class="text-slate-500 hover:text-amber-400 transition-colors" title="تسک">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                </button>
                            </label>
                            <input type="number" dir="ltr"
                                   class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-slate-400 outline-none font-mono line-through decoration-slate-600 focus:border-indigo-500 transition-colors">
                        </div>
                        <div>
                            <label class="flex items-center gap-1.5 text-sm text-emerald-400 font-bold mb-2">
                                قیمت فروش سایت
                                <button onclick="openTaskModal('فیلد','قیمت فروش')" class="text-slate-500 hover:text-amber-400 transition-colors" title="تسک">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                </button>
                            </label>
                            <input type="number" dir="ltr"
                                   class="w-full bg-slate-950 border border-emerald-500/30 rounded-lg px-4 py-2.5 text-sm text-emerald-400 font-bold outline-none font-mono focus:border-emerald-500 transition-colors">
                        </div>
                    </div>
                    <div class="p-4 bg-amber-500/10 border border-amber-500/20 rounded-xl">
                        <label class="flex items-center gap-3 cursor-pointer text-sm text-amber-400 font-bold">
                            <input type="checkbox" class="w-4 h-4 rounded border-slate-700 bg-slate-900 text-amber-500">
                            ثبت به عنوان «محصول ویژه» (Special Campaign)
                        </label>
                        <p class="text-[11px] text-slate-500 mt-1.5 pr-7">محصولات ویژه در بخش پیشنهادات صفحه اصلی سایت نمایش داده می‌شوند.</p>
                    </div>
                </div>

                {{-- ── Tab: رسانه و گالری ───────────────────────────── --}}
                <div id="content-media" class="modal-tab-content hidden space-y-5">
                    <div>
                        <label class="flex items-center gap-2 text-sm font-bold text-slate-200 mb-2">
                            تصویر اصلی محصول
                            <span class="text-rose-500">*</span>
                            <button onclick="openTaskModal('فیلد','تصویر اصلی')" class="text-slate-500 hover:text-amber-400 transition-colors" title="تسک">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            </button>
                        </label>
                        <div class="w-full border-2 border-dashed border-slate-700 hover:border-indigo-500 rounded-xl p-10
                                    flex flex-col items-center justify-center text-slate-500 cursor-pointer
                                    bg-slate-950/40 hover:bg-slate-950 transition-colors gap-3">
                            <svg class="w-10 h-10 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                            </svg>
                            <span class="text-sm font-medium text-slate-400">برای آپلود کلیک کنید یا فایل را اینجا رها کنید</span>
                            <span class="text-[11px] text-slate-600">PNG, JPG, WEBP تا ۵ مگابایت</span>
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-bold text-slate-200 mb-2 block">گالری تصاویر</label>
                        <div class="grid grid-cols-6 gap-2">
                            <div class="aspect-square border-2 border-dashed border-slate-700 hover:border-indigo-500 rounded-lg flex items-center justify-center cursor-pointer text-slate-600 hover:text-indigo-400 transition-colors bg-slate-950/40 hover:bg-slate-950">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Tab: انبار ────────────────────────────────────── --}}
                <div id="content-inventory" class="modal-tab-content hidden space-y-5">
                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="flex items-center gap-1.5 text-sm text-slate-400 mb-2">
                                کد محصول (SKU)
                                <button onclick="openTaskModal('فیلد','SKU')" class="text-slate-500 hover:text-amber-400 transition-colors"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg></button>
                            </label>
                            <input type="text" dir="ltr"
                                   class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-slate-200 font-mono outline-none focus:border-indigo-500 transition-colors">
                        </div>
                        <div>
                            <label class="flex items-center gap-1.5 text-sm text-slate-400 mb-2">
                                موجودی انبار
                                <button onclick="openTaskModal('فیلد','موجودی انبار')" class="text-slate-500 hover:text-amber-400 transition-colors"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg></button>
                            </label>
                            <input type="number" dir="ltr"
                                   class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-slate-200 outline-none font-mono focus:border-indigo-500 transition-colors">
                        </div>
                    </div>
                    <div class="p-4 bg-slate-950/60 border border-slate-800 rounded-xl">
                        <label class="flex items-center gap-3 cursor-pointer text-sm text-slate-300">
                            <input type="checkbox" class="w-4 h-4 rounded border-slate-700 bg-slate-900 text-indigo-500">
                            مدیریت موجودی فعال باشد
                        </label>
                        <p class="text-[11px] text-slate-600 mt-1.5 pr-7">با فعال بودن این گزینه، موجودی پس از هر سفارش کاهش می‌یابد.</p>
                    </div>
                </div>

                {{-- ── Tab: سئو ──────────────────────────────────────── --}}
                <div id="content-seo" class="modal-tab-content hidden space-y-5">
                    {{-- Google SERP preview --}}
                    <div class="bg-[#202124] border border-[#3c4043] rounded-xl p-5 shadow-md" dir="ltr">
                        <div class="text-[12px] text-[#9aa0a6] mb-1 flex items-center gap-1.5">
                            <span class="text-[#dadce0]">https://dashtzad.com</span>
                            <span>› product ›</span>
                            <span>product-url</span>
                        </div>
                        <h3 class="text-[#8ab4f8] text-[18px] font-normal hover:underline cursor-pointer mb-1">
                            Product SEO Title Preview
                        </h3>
                        <p class="text-[#bdc1c6] text-[13px] leading-relaxed">
                            This is an auto-generated description for the product meta tag shown in Google search results.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="flex items-center gap-1.5 text-sm text-slate-400 mb-2">
                                عنوان سئو
                                <button onclick="openTaskModal('فیلد','عنوان سئو')" class="text-slate-500 hover:text-amber-400 transition-colors"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg></button>
                            </label>
                            <input type="text"
                                   class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-slate-200 outline-none focus:border-indigo-500 transition-colors">
                        </div>
                        <div>
                            <label class="flex items-center gap-1.5 text-sm text-slate-400 mb-2">
                                اسلاگ (URL) <span class="text-rose-500">*</span>
                                <button onclick="openTaskModal('فیلد','اسلاگ URL')" class="text-slate-500 hover:text-amber-400 transition-colors"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg></button>
                            </label>
                            <input type="text" dir="ltr" placeholder="فقط انگلیسی و خط‌تیره"
                                   class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-slate-200 outline-none font-mono focus:border-indigo-500 transition-colors"
                                   oninput="this.classList.toggle('border-rose-500', /[^a-zA-Z0-9\-]/.test(this.value) && this.value.length > 0)">
                        </div>
                    </div>

                    <div>
                        <label class="flex items-center gap-1.5 text-sm text-slate-400 mb-2">
                            متا دیسکریپشن
                            <button onclick="openTaskModal('فیلد','متا دیسکریپشن')" class="text-slate-500 hover:text-amber-400 transition-colors"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg></button>
                        </label>
                        <textarea rows="2"
                                  class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-3 text-sm text-slate-200 outline-none resize-none focus:border-indigo-500 transition-colors"></textarea>
                    </div>

                    <div class="grid grid-cols-3 gap-5">
                        <div>
                            <label class="text-sm text-slate-400 mb-2 block">کلمه کلیدی اصلی</label>
                            <input type="text" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-slate-200 outline-none focus:border-indigo-500 transition-colors">
                        </div>
                        <div>
                            <label class="text-sm text-slate-400 mb-2 block">کلمات مرتبط</label>
                            <input type="text" placeholder="با کاما جدا کنید" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-slate-200 outline-none focus:border-indigo-500 transition-colors">
                        </div>
                        <div>
                            <label class="text-sm text-slate-400 mb-2 block">Alt تصاویر گالری</label>
                            <input type="text" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-slate-200 outline-none focus:border-indigo-500 transition-colors">
                        </div>
                    </div>

                    <div class="flex items-center gap-6 bg-slate-950/60 p-4 border border-slate-800 rounded-xl">
                        <label class="flex items-center gap-2 text-sm text-slate-300 cursor-pointer">
                            <input type="checkbox" checked class="w-4 h-4 rounded border-slate-700 bg-slate-900 text-indigo-500">
                            اسکیما Product
                        </label>
                        <label class="flex items-center gap-2 text-sm text-slate-300 cursor-pointer">
                            <input type="checkbox" class="w-4 h-4 rounded border-slate-700 bg-slate-900 text-indigo-500">
                            اسکیما FAQ
                        </label>
                        <div class="mr-auto flex items-center gap-2 text-sm text-slate-400">
                            امتیاز سئو:
                            <div class="w-9 h-9 rounded-full border-[3px] border-emerald-500 flex items-center justify-center text-emerald-400 font-bold text-xs">85</div>
                        </div>
                    </div>
                </div>

                {{-- ── Tab: تاریخچه محصول ──────────────────────────── --}}
                <div id="content-history" class="modal-tab-content hidden space-y-4">
                    <div class="flex gap-4 border-r-2 border-slate-800 pr-4 relative">
                        <div class="absolute w-2.5 h-2.5 bg-indigo-500 rounded-full -right-[6px] top-1 ring-4 ring-slate-900"></div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-1">
                                <span class="text-sm font-bold text-slate-200">علی رضایی</span>
                                <span class="text-[10px] text-slate-500 font-mono">۱۰:۴۵</span>
                            </div>
                            <p class="text-xs text-slate-400 leading-relaxed">
                                تغییر وضعیت به <span class="text-indigo-400">نیاز به بررسی</span>.
                            </p>
                            <button class="mt-1.5 text-[10px] text-slate-500 hover:text-white border border-slate-700 px-2 py-0.5 rounded transition-colors">
                                بازگردانی (Undo)
                            </button>
                        </div>
                    </div>
                    <div class="flex gap-4 border-r-2 border-slate-800 pr-4 relative">
                        <div class="absolute w-2.5 h-2.5 bg-emerald-500 rounded-full -right-[6px] top-1 ring-4 ring-slate-900"></div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-1">
                                <span class="text-sm font-bold text-slate-200">سیستم (Auto-Save)</span>
                                <span class="text-[10px] text-slate-500 font-mono">۰۹:۱۲</span>
                            </div>
                            <p class="text-xs text-slate-400">ذخیره خودکار پیش‌نویس.</p>
                        </div>
                    </div>
                    <p class="text-[11px] text-slate-600 text-center py-4">تاریخچه کامل پس از اتصال به دیتابیس نمایش داده می‌شود.</p>
                </div>

            </div>{{-- end tab content --}}
        </div>{{-- end modal body --}}

        {{-- Modal footer --}}
        <div class="px-6 py-4 border-t border-slate-800/80 flex justify-end gap-3 bg-slate-900/60 rounded-b-2xl shrink-0">
            <button onclick="closeEditModal()"
                    class="px-5 py-2 text-sm font-bold text-slate-300 bg-slate-800 hover:bg-slate-700 rounded-xl transition-colors">
                بستن
            </button>
            <button onclick="closeEditModal()"
                    class="px-7 py-2 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl transition-colors shadow-lg shadow-indigo-900/20">
                ذخیره جامع محصول
            </button>
        </div>

    </div>{{-- end edit-modal --}}
</div>{{-- end edit-modal-backdrop --}}

{{-- ═══════════════════════════════════════════════════════
     Task Modal (ایجاد تسک)
════════════════════════════════════════════════════════ --}}
<div id="task-modal-backdrop"
     class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] flex items-center justify-center hidden-fade p-4">
    <div id="task-modal"
         class="bg-slate-900 border border-slate-800/80 rounded-2xl w-full max-w-md shadow-2xl
                transform scale-95 transition-transform duration-200 flex flex-col">

        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-800/80 shrink-0">
            <h3 class="text-base font-bold text-white flex items-center gap-2">
                <svg class="w-4 h-4 text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                ایجاد تسک جدید
            </h3>
            <button onclick="closeTaskModal()"
                    class="text-slate-500 hover:text-white bg-slate-800/60 hover:bg-slate-700 p-1.5 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="p-6 space-y-4">
            <div class="text-xs text-slate-300 bg-slate-800/60 p-3 rounded-lg border border-slate-700/80">
                <span class="text-slate-500">ارجاع کار برای:</span>
                <span id="task-context-info" class="font-bold text-indigo-400 mr-1">نامشخص</span>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-200 mb-2">مسئول انجام</label>
                <div class="relative">
                    <select class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-slate-200 outline-none appearance-none cursor-pointer focus:border-indigo-500 transition-colors">
                        <option>علی رضایی (ادمین) — mock</option>
                        <option>سارا محمدی (تولید محتوا) — mock</option>
                        <option>تیم سئو — mock</option>
                    </select>
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-slate-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-200 mb-2">شرح کار</label>
                <textarea rows="3"
                          class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-3 text-sm text-slate-200 outline-none resize-none placeholder-slate-600 focus:border-indigo-500 transition-colors"
                          placeholder="مثال: لطفاً تصاویر گالری این محصول را تا فردا اضافه کن..."></textarea>
            </div>
        </div>

        <div class="px-6 py-4 border-t border-slate-800/80 flex justify-end gap-3 bg-slate-900/60 rounded-b-2xl">
            <button onclick="closeTaskModal()"
                    class="px-5 py-2 text-sm font-bold text-slate-300 bg-slate-800 hover:bg-slate-700 rounded-xl transition-colors">
                انصراف
            </button>
            <button onclick="closeTaskModal()"
                    class="px-6 py-2 text-sm font-bold text-slate-900 bg-amber-400 hover:bg-amber-300 rounded-xl transition-colors shadow-lg shadow-amber-500/20">
                ثبت و ارجاع تسک
            </button>
        </div>

    </div>
</div>

</x-layouts.app>
