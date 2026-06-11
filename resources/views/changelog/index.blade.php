<x-layouts.app>

    <div class="max-w-3xl space-y-5">

        {{-- Page header --}}
        <div class="flex items-center gap-4 mb-6">
            <div class="w-11 h-11 bg-indigo-600/20 border border-indigo-500/20 rounded-xl
                        flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                          d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987
                             8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1
                             6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967
                             8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-white">گزارش آپدیت‌ها</h2>
                <p class="text-sm text-slate-400 mt-0.5">تاریخچه تغییرات و بهبودهای پنل دشت‌زاد</p>
            </div>
        </div>

        {{-- Empty state --}}
        @if(empty($releases))
            <div class="bg-slate-900/50 border border-slate-800/80 rounded-2xl p-14 text-center">
                <svg class="w-10 h-10 text-slate-700 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1
                             13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6.75 12H9m1.5-12H5.625c-.621
                             0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0
                             1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                </svg>
                <p class="text-slate-400 text-sm">هنوز گزارشی برای آپدیت‌ها ثبت نشده است.</p>
            </div>

        @else
            {{-- Release cards --}}
            @foreach($releases as $release)
                <div class="bg-slate-900/50 border border-slate-800/80 rounded-2xl overflow-hidden">

                    {{-- Release header --}}
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-800/60 bg-slate-900/30">
                        @if($release['version'])
                            <span class="bg-indigo-600 text-white text-xs font-bold px-2.5 py-1 rounded-lg tracking-wide">
                                {{ $release['version'] }}
                            </span>
                        @endif
                        <span class="text-slate-300 font-medium text-sm">{{ $release['date'] }}</span>
                    </div>

                    {{-- Categories --}}
                    <div class="p-6 space-y-6">
                        @foreach($release['categories'] as $cat)
                            <div>
                                {{-- Badge --}}
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold
                                             px-2.5 py-1 rounded-lg border {{ $cat['class'] }}">
                                    {{ $cat['label'] }}
                                </span>

                                {{-- Items --}}
                                <ul class="mt-3 space-y-2">
                                    @foreach($cat['items'] as $item)
                                        <li class="flex items-start gap-2.5 text-slate-300 text-sm leading-relaxed">
                                            <span class="mt-2 w-1 h-1 bg-slate-600 rounded-full shrink-0"></span>
                                            <span>{!! $item !!}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>

                </div>
            @endforeach
        @endif

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var el = document.getElementById('header-title');
            if (el) el.textContent = 'گزارش آپدیت‌ها';
        });
    </script>

</x-layouts.app>
