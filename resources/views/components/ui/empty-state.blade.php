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
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H6.911a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661Z"/>
            </svg>
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
