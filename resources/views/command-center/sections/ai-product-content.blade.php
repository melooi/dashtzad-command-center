{{-- PAGE: تولید محتوای محصول (id=page-ai-product-content) --}}
<div id="page-ai-product-content" class="max-w-screen-xl mx-auto space-y-6 hidden pb-10">

    {{-- Page header --}}
    <div class="border-b border-slate-800/80 pb-5">
        <h1 class="text-xl font-bold text-white mb-1">تولید محتوای محصول</h1>
        <p class="text-sm text-slate-400">
            ساخت خودکار توضیحات، ویژگی‌ها و محتوای سئو با کمک هوش مصنوعی
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        {{-- Input form --}}
        <div class="lg:col-span-5 bg-slate-900 border border-slate-800/80 rounded-2xl p-5 shadow-sm
                    order-2 lg:order-1 lg:sticky lg:top-4">
            <form onsubmit="generateContent(event)" class="space-y-5">

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">
                        عنوان محصول <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           placeholder="مثال: گوشی موبایل سامسونگ S24 Ultra"
                           class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5
                                  text-slate-200 text-sm focus:border-indigo-500 focus:ring-1
                                  focus:ring-indigo-500 outline-none transition-all placeholder:text-slate-600">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">
                        توضیحات خام / نکات کلیدی
                    </label>
                    <textarea rows="3"
                              placeholder="ویژگی‌های اصلی را اینجا بنویسید..."
                              class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3
                                     text-slate-200 text-sm focus:border-indigo-500 focus:ring-1
                                     focus:ring-indigo-500 outline-none transition-all
                                     placeholder:text-slate-600 resize-none"></textarea>
                </div>

                <button id="gen-btn" type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-medium
                               py-3 rounded-xl transition-all shadow-lg shadow-indigo-900/20
                               flex justify-center items-center gap-2 disabled:opacity-60
                               disabled:cursor-not-allowed">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25
                                 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5
                                 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z"/>
                    </svg>
                    تولید محتوا
                </button>

            </form>
        </div>

        {{-- Output area --}}
        <div class="lg:col-span-7 bg-slate-900 border border-slate-800/80 rounded-2xl p-5 shadow-sm
                    min-h-[360px] flex flex-col order-1 lg:order-2 relative">

            {{-- Empty state --}}
            <div id="ai-empty-state" class="flex-1 flex items-center justify-center">
                <x-ui.empty-state
                    title="خروجی هنوز ساخته نشده"
                    description="اطلاعات محصول را وارد کنید تا هوش مصنوعی محتوای اختصاصی بسازد."
                />
            </div>

            {{-- Result (hidden until form submitted) --}}
            <div id="ai-result-state" class="hidden space-y-4">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <h3 class="font-bold text-emerald-400 text-sm">محتوا با موفقیت تولید شد</h3>
                </div>
                <div class="bg-slate-950 border border-slate-800 rounded-xl overflow-hidden">
                    <div class="bg-slate-800/50 px-4 py-2.5 border-b border-slate-800 flex justify-between items-center">
                        <span class="font-semibold text-slate-200 text-sm">توضیحات محصول</span>
                    </div>
                    <div class="p-4 text-sm text-slate-300 leading-relaxed">
                        محتوای تولید‌شده توسط هوش مصنوعی اینجا نمایش داده می‌شود...
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
