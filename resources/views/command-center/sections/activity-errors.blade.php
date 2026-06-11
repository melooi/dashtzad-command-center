{{-- PAGE: خطاهای سیستم (id=page-activity-errors) --}}
<div id="page-activity-errors" class="max-w-7xl mx-auto hidden pb-10">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <x-ui.empty-state
            title="هیچ خطایی ثبت نشده"
            description="خطاها، استثناها و رویدادهای بحرانی سیستم اینجا لاگ می‌شوند.">
            <x-slot:icon>
                <i class="fa-solid fa-bug text-2xl"></i>
            </x-slot:icon>
        </x-ui.empty-state>
    </div>
</div>
