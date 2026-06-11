@props([
    'value' => '۰',
    'label' => '',
    'color' => 'default',
])

@php
$border = match($color) {
    'danger'  => 'border-danger/30',
    'warning' => 'border-warning/30',
    'info'    => 'border-info/30',
    'success' => 'border-success/30',
    default   => 'border-border',
};
$valueColor = match($color) {
    'danger'  => 'text-danger',
    'warning' => 'text-warning',
    'info'    => 'text-info',
    'success' => 'text-success',
    'muted'   => 'text-text-muted',
    default   => 'text-text-main',
};
$labelColor = match($color) {
    'danger'  => 'text-danger/80',
    default   => 'text-text-muted',
};
@endphp

<div class="bg-surface border {{ $border }} rounded-[var(--radius-card)] p-4 flex flex-col
            justify-center items-center text-center relative overflow-hidden">
    @if($color === 'danger')
        <div class="absolute inset-0 bg-danger/5 pointer-events-none"></div>
    @endif
    <span class="text-2xl font-bold {{ $valueColor }} relative tabular-nums">{{ $value }}</span>
    <span class="text-xs {{ $labelColor }} mt-1 relative leading-snug">{{ $label }}</span>
</div>
