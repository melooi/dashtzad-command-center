@props([
    'variant' => 'primary',
    'size'    => 'md',
    'type'    => 'button',
])

@php
$base  = 'inline-flex items-center justify-center gap-2 font-medium transition-all focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed';
$base .= ' rounded-[var(--radius-btn)]';

$sizes = [
    'sm' => 'px-3 py-1.5 text-xs',
    'md' => 'px-4 py-2.5 text-sm',
    'lg' => 'px-6 py-3 text-base',
];

$variants = [
    'primary'   => 'bg-primary hover:bg-primary/80 text-white shadow-sm',
    'secondary' => 'bg-surface hover:bg-border text-text-main border border-border',
    'ghost'     => 'text-text-muted hover:text-text-main hover:bg-surface',
    'danger'    => 'bg-danger/10 hover:bg-danger/20 text-danger border border-danger/30',
    'success'   => 'bg-success/10 hover:bg-success/20 text-success border border-success/30',
];
@endphp

<button type="{{ $type }}"
    {{ $attributes->class([$base, $sizes[$size] ?? $sizes['md'], $variants[$variant] ?? $variants['primary']]) }}>
    {{ $slot }}
</button>
