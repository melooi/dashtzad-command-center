{{-- PAGE: فعالیت امروز (id=page-activity-today) --}}
<div id="page-activity-today" class="max-w-7xl mx-auto hidden pb-10">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <x-ui.empty-state
            title="هنوز فعالیتی امروز ثبت نشده"
            description="تمام رویدادها و فعالیت‌های انجام‌شده در طول روز اینجا نمایش داده می‌شوند.">
            <x-slot:icon>
                <i class="fa-solid fa-calendar-day text-2xl"></i>
            </x-slot:icon>
        </x-ui.empty-state>
    </div>
</div>
