{{--
    Collapsible sidebar nav group (details/summary).
    Props:
      $title — group label
      $open  — whether open by default
    Slots:
      $icon  — named slot for the leading icon SVG
      $slot  — sub-items
--}}
@props(['title', 'open' => false])

<details class="group [&_summary::-webkit-details-marker]:hidden" @if($open) open @endif>
    <summary class="sb-group-summary flex items-center px-3 py-2.5 rounded-xl text-text-muted
                    hover:text-text-main hover:bg-border transition-colors cursor-pointer select-none"
             title="{{ $title }}">

        {{-- Icon --}}
        <span class="w-5 h-5 shrink-0 flex items-center justify-center">
            {{ $icon }}
        </span>

        {{-- Label --}}
        <span class="mr-3 font-medium text-sm flex-1 group-open:text-text-main transition-colors sb-text">
            {{ $title }}
        </span>

        {{-- Chevron --}}
        <i class="fa-solid fa-chevron-down text-xs transform group-open:-rotate-180 transition-transform duration-200 shrink-0 sb-chevron"></i>
    </summary>

    {{-- Sub-items --}}
    <div class="mt-1 sb-subitems pr-9 space-y-0.5 border-r border-border/60 mr-5 mb-2">
        {{ $slot }}
    </div>
</details>
