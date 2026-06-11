{{--
    Reusable empty-state placeholder.
    Props:
      $title       — main heading
      $description — supporting text
    Slots:
      $icon   — named slot for a custom icon SVG (optional)
      $action — named slot for a CTA button (optional)
      $slot   — extra content below
--}}
@props([
    'title'       => 'موردی یافت نشد',
    'description' => '',
])

<div class="flex flex-col items-center justify-center text-center py-16 px-8 select-none">

    {{-- Icon container --}}
    <div class="w-16 h-16 bg-slate-800 rounded-2xl flex items-center justify-center
                mb-4 text-slate-600 border border-slate-700/50 border-dashed">
        @isset($icon)
            {{ $icon }}
        @else
            {{-- default: inbox icon --}}
            <i class="fa-solid fa-inbox text-2xl"></i>
        @endisset
    </div>

    <h3 class="text-sm font-bold text-slate-400 mb-1">{{ $title }}</h3>

    @if($description)
        <p class="text-xs text-slate-500 max-w-xs leading-relaxed">{{ $description }}</p>
    @endif

    @isset($action)
        <div class="mt-5">{{ $action }}</div>
    @endisset

    {{ $slot }}
</div>
