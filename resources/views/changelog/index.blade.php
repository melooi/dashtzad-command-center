<x-layouts.app>

    <div class="max-w-3xl space-y-5">

        {{-- Page header --}}
        <div class="flex items-center gap-4 mb-6">
            <div class="w-11 h-11 bg-primary/20 border border-primary/20 rounded-xl
                        flex items-center justify-center shrink-0">
                <i class="fa-solid fa-book-open text-primary text-lg"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-text-main">گزارش آپدیت‌ها</h2>
                <p class="text-sm text-text-muted mt-0.5">تاریخچه تغییرات و بهبودهای پنل دشت‌زاد</p>
            </div>
        </div>

        {{-- Empty state --}}
        @if(empty($releases))
            <div class="bg-surface/50 border border-border/80 rounded-card p-14 text-center">
                <i class="fa-solid fa-file-lines text-border text-4xl mx-auto mb-3 block"></i>
                <p class="text-text-muted text-sm">هنوز گزارشی برای آپدیت‌ها ثبت نشده است.</p>
            </div>

        @else
            {{-- Release cards --}}
            @foreach($releases as $release)
                <div class="bg-surface/50 border border-border/80 rounded-card overflow-hidden">

                    {{-- Release header --}}
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-border/60 bg-surface/30">
                        @if($release['version'])
                            <span class="bg-primary text-white text-xs font-bold px-2.5 py-1 rounded-lg tracking-wide">
                                {{ $release['version'] }}
                            </span>
                        @endif
                        <span class="text-text-main font-medium text-sm">{{ $release['date'] }}</span>
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
                                        <li class="flex items-start gap-2.5 text-text-main text-sm leading-relaxed">
                                            <span class="mt-2 w-1 h-1 bg-border rounded-full shrink-0"></span>
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
