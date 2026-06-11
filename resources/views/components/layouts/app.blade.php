<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'دشت‌زاد') }} — پنل فرماندهی</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-300 antialiased h-screen flex overflow-hidden selection:bg-indigo-500/30">

    {{-- Sidebar --}}
    <x-sidebar />

    {{-- Content Wrapper --}}
    <div class="flex-1 flex flex-col relative w-full overflow-hidden">
        <x-header />
        <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8 relative">
            {{ $slot }}
        </main>
    </div>

    {{-- Activity Drawer --}}
    <x-activity-drawer />

    {{-- Mobile sidebar overlay --}}
    <div id="sidebar-overlay"
         class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden-fade md:hidden"
         onclick="closeMobileSidebar()">
    </div>

</body>
</html>
