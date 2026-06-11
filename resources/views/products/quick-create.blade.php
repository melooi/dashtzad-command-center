<x-layouts.app>

{{-- ═══════════════════════════════════════════════════════
     Page Header
════════════════════════════════════════════════════════ --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-4">
    <div class="flex items-center gap-3">
        <div class="w-9 h-9 bg-indigo-600/20 border border-indigo-500/20 rounded-xl flex items-center justify-center shrink-0">
            <i class="fa-solid fa-table-list text-indigo-400 text-sm"></i>
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
            <i class="fa-solid fa-file-import text-emerald-400 text-sm shrink-0"></i>
            <span class="hidden sm:inline">درون‌ریزی</span>
        </button>
        <button class="flex items-center gap-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-medium py-1.5 px-3 rounded-lg transition-colors border border-slate-700/80"
                title="برون‌بری به فایل اکسل">
            <i class="fa-solid fa-file-export text-sky-400 text-sm shrink-0"></i>
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
                            <i class="fa-solid fa-plus text-sm"></i>
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
                <i class="fa-solid fa-pen text-indigo-400 text-sm shrink-0"></i>
                ویرایش جامع:
                <span id="modal-product-name" class="text-slate-400 font-normal">محصول جدید</span>
            </h3>
            <button onclick="closeEditModal()"
                    class="text-slate-500 hover:text-white bg-slate-800/60 hover:bg-slate-700 p-1.5 rounded-lg transition-colors">
                <i class="fa-solid fa-xmark text-sm"></i>
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
                                <i class="fa-solid fa-clipboard-check text-xs"></i>
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
                                <i class="fa-solid fa-clipboard-check text-xs"></i>
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
                                <i class="fa-solid fa-clipboard-check text-xs"></i>
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
                                    <i class="fa-solid fa-clipboard-check text-xs"></i>
                                </button>
                            </label>
                            <input type="number" dir="ltr" placeholder="جهت محاسبه سود"
                                   class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-slate-200 outline-none font-mono focus:border-indigo-500 transition-colors">
                        </div>
                        <div>
                            <label class="flex items-center gap-1.5 text-sm text-slate-400 mb-2">
                                قیمت خط‌خورده
                                <button onclick="openTaskModal('فیلد','قیمت عادی')" class="text-slate-500 hover:text-amber-400 transition-colors" title="تسک">
                                    <i class="fa-solid fa-clipboard-check text-xs"></i>
                                </button>
                            </label>
                            <input type="number" dir="ltr"
                                   class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-slate-400 outline-none font-mono line-through decoration-slate-600 focus:border-indigo-500 transition-colors">
                        </div>
                        <div>
                            <label class="flex items-center gap-1.5 text-sm text-emerald-400 font-bold mb-2">
                                قیمت فروش سایت
                                <button onclick="openTaskModal('فیلد','قیمت فروش')" class="text-slate-500 hover:text-amber-400 transition-colors" title="تسک">
                                    <i class="fa-solid fa-clipboard-check text-xs"></i>
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
                                <i class="fa-solid fa-clipboard-check text-xs"></i>
                            </button>
                        </label>
                        <div class="w-full border-2 border-dashed border-slate-700 hover:border-indigo-500 rounded-xl p-10
                                    flex flex-col items-center justify-center text-slate-500 cursor-pointer
                                    bg-slate-950/40 hover:bg-slate-950 transition-colors gap-3">
                            <i class="fa-solid fa-image text-slate-700 text-4xl"></i>
                            <span class="text-sm font-medium text-slate-400">برای آپلود کلیک کنید یا فایل را اینجا رها کنید</span>
                            <span class="text-[11px] text-slate-600">PNG, JPG, WEBP تا ۵ مگابایت</span>
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-bold text-slate-200 mb-2 block">گالری تصاویر</label>
                        <div class="grid grid-cols-6 gap-2">
                            <div class="aspect-square border-2 border-dashed border-slate-700 hover:border-indigo-500 rounded-lg flex items-center justify-center cursor-pointer text-slate-600 hover:text-indigo-400 transition-colors bg-slate-950/40 hover:bg-slate-950">
                                <i class="fa-solid fa-plus text-lg"></i>
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
                                <button onclick="openTaskModal('فیلد','SKU')" class="text-slate-500 hover:text-amber-400 transition-colors"><i class="fa-solid fa-clipboard-check text-xs"></i></button>
                            </label>
                            <input type="text" dir="ltr"
                                   class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-slate-200 font-mono outline-none focus:border-indigo-500 transition-colors">
                        </div>
                        <div>
                            <label class="flex items-center gap-1.5 text-sm text-slate-400 mb-2">
                                موجودی انبار
                                <button onclick="openTaskModal('فیلد','موجودی انبار')" class="text-slate-500 hover:text-amber-400 transition-colors"><i class="fa-solid fa-clipboard-check text-xs"></i></button>
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
                                <button onclick="openTaskModal('فیلد','عنوان سئو')" class="text-slate-500 hover:text-amber-400 transition-colors"><i class="fa-solid fa-clipboard-check text-xs"></i></button>
                            </label>
                            <input type="text"
                                   class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-slate-200 outline-none focus:border-indigo-500 transition-colors">
                        </div>
                        <div>
                            <label class="flex items-center gap-1.5 text-sm text-slate-400 mb-2">
                                اسلاگ (URL) <span class="text-rose-500">*</span>
                                <button onclick="openTaskModal('فیلد','اسلاگ URL')" class="text-slate-500 hover:text-amber-400 transition-colors"><i class="fa-solid fa-clipboard-check text-xs"></i></button>
                            </label>
                            <input type="text" dir="ltr" placeholder="فقط انگلیسی و خط‌تیره"
                                   class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-slate-200 outline-none font-mono focus:border-indigo-500 transition-colors"
                                   oninput="this.classList.toggle('border-rose-500', /[^a-zA-Z0-9\-]/.test(this.value) && this.value.length > 0)">
                        </div>
                    </div>

                    <div>
                        <label class="flex items-center gap-1.5 text-sm text-slate-400 mb-2">
                            متا دیسکریپشن
                            <button onclick="openTaskModal('فیلد','متا دیسکریپشن')" class="text-slate-500 hover:text-amber-400 transition-colors"><i class="fa-solid fa-clipboard-check text-xs"></i></button>
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
                <i class="fa-solid fa-triangle-exclamation text-amber-400 text-sm shrink-0"></i>
                ایجاد تسک جدید
            </h3>
            <button onclick="closeTaskModal()"
                    class="text-slate-500 hover:text-white bg-slate-800/60 hover:bg-slate-700 p-1.5 rounded-lg transition-colors">
                <i class="fa-solid fa-xmark text-sm"></i>
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
                        <i class="fa-solid fa-chevron-down text-sm"></i>
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
