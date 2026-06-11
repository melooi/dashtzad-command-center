@props([
    'title'       => 'موردی یافت نشد',
    'description' => '',
])

<div class="flex flex-col items-center justify-center text-center py-16 px-8 select-none">

    <div class="w-16 h-16 bg-border rounded-[var(--radius-card)] flex items-center justify-center
                mb-4 text-text-muted border border-border/50 border-dashed">
        @isset($icon)
            {{ $icon }}
        @else
            <i class="fa-solid fa-inbox text-2xl"></i>
        @endisset
    </div>

    <h3 class="text-sm font-bold text-text-muted mb-1">{{ $title }}</h3>

    @if($description)
        <p class="text-xs text-text-muted/70 max-w-xs leading-relaxed">{{ $description }}</p>
    @endif

    @isset($action)
        <div class="mt-5">{{ $action }}</div>
    @endisset

    {{ $slot }}
</div>
