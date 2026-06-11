<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'دشت‌زاد') }} — پنل فرماندهی</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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

    {{-- PJAX loading bar --}}
    <div id="pjax-bar"></div>

</body>
</html>
