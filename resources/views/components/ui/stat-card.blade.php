{{--
    Metric stat card for the dashboard stats row.
    Props:
      $value  — displayed number/value
      $label  — description below the number
      $color  — default | danger | warning | info | muted
--}}
@props([
    'value' => '۰',
    'label' => '',
    'color' => 'default',
])

@php
$border = match($color) {
    'danger'  => 'border-rose-500/30',
    'warning' => 'border-amber-500/30',
    'info'    => 'border-indigo-500/30',
    default   => 'border-slate-800',
};
$valueColor = match($color) {
    'danger'  => 'text-rose-500',
    'warning' => 'text-amber-500',
    'info'    => 'text-indigo-400',
    'muted'   => 'text-slate-500',
    default   => 'text-white',
};
$labelColor = match($color) {
    'danger'  => 'text-rose-400/80',
    default   => 'text-slate-400',
};
@endphp

<div class="bg-slate-900 border {{ $border }} rounded-2xl p-4 flex flex-col
            justify-center items-center text-center relative overflow-hidden">
    @if($color === 'danger')
        <div class="absolute inset-0 bg-rose-500/5 pointer-events-none"></div>
    @endif
    <span class="text-2xl font-bold {{ $valueColor }} relative tabular-nums">{{ $value }}</span>
    <span class="text-xs {{ $labelColor }} mt-1 relative leading-snug">{{ $label }}</span>
</div>
