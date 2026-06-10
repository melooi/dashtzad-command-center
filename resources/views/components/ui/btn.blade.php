{{--
    Reusable button component.
    Props:
      $variant — primary | secondary | ghost | danger
      $size    — sm | md | lg
      $type    — button | submit | reset
--}}
@props([
    'variant' => 'primary',
    'size'    => 'md',
    'type'    => 'button',
])

@php
$base  = 'inline-flex items-center justify-center gap-2 font-medium rounded-xl transition-all focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed';

$sizes = [
    'sm' => 'px-3 py-1.5 text-xs',
    'md' => 'px-4 py-2.5 text-sm',
    'lg' => 'px-6 py-3 text-base',
];

$variants = [
    'primary'   => 'bg-indigo-600 hover:bg-indigo-500 text-white shadow-lg shadow-indigo-900/20',
    'secondary' => 'bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700',
    'ghost'     => 'text-slate-400 hover:text-white hover:bg-slate-800',
    'danger'    => 'bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/20',
];
@endphp

<button type="{{ $type }}"
    {{ $attributes->class([$base, $sizes[$size] ?? $sizes['md'], $variants[$variant] ?? $variants['primary']]) }}>
    {{ $slot }}
</button>
