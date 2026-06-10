{{-- PAGE: اتصالات و یکپارچگی‌ها (id=page-connections) --}}
<div id="page-connections" class="max-w-7xl mx-auto space-y-10 hidden pb-10">

    @foreach([
        ['label' => 'هوش مصنوعی',     'color' => 'indigo'],
        ['label' => 'سایت و فروشگاه', 'color' => 'pink'],
        ['label' => 'پیامک',          'color' => 'amber'],
        ['label' => 'گوگل',           'color' => 'blue'],
        ['label' => 'پیام‌رسان‌ها',    'color' => 'emerald'],
    ] as $group)
    <section>
        <h2 class="text-base font-bold text-slate-200 mb-4 flex items-center gap-2.5">
            <span class="w-1.5 h-5 bg-{{ $group['color'] }}-500 rounded-full inline-block"></span>
            {{ $group['label'] }}
        </h2>
        <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
            <x-ui.empty-state
                title="هنوز اتصالی تنظیم نشده"
                description="سرویس‌های {{ $group['label'] }} اینجا پیکربندی می‌شوند."
            />
        </div>
    </section>
    @endforeach

</div>
