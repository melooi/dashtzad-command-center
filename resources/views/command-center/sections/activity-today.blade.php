{{-- PAGE: فعالیت امروز (id=page-activity-today) --}}
<div id="page-activity-today" class="max-w-7xl mx-auto hidden pb-10">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <x-ui.empty-state
            title="هنوز فعالیتی امروز ثبت نشده"
            description="تمام رویدادها و فعالیت‌های انجام‌شده در طول روز اینجا نمایش داده می‌شوند.">
            <x-slot:icon>
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
            </x-slot:icon>
        </x-ui.empty-state>
    </div>
</div>
