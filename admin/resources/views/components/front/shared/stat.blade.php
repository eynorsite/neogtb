@props([
    'value' => '',
    'label' => '',
    'color' => 'dark', // dark|accent|energy
    'size' => 'lg',    // sm|md|lg
])

@php
    $colorVar = match($color) {
        'accent' => 'var(--color-accent-600)',
        'energy' => 'var(--color-accent-600)',
        default => 'var(--color-dark-900)',
    };
    $valueSize = match($size) {
        'sm' => '20px',
        'md' => '22px',
        default => '36px',
    };
@endphp

<div {{ $attributes }}>
    <p style="font-size: {{ $valueSize }}; font-weight: {{ $size === 'lg' ? '500' : '600' }}; color: {{ $colorVar }}; letter-spacing: -0.03em; line-height: 1;">{{ $value }}</p>
    <p style="font-size: {{ $size === 'lg' ? '13px' : '12px' }}; color: var(--color-dark-400); margin-top: 4px; line-height: 1.4;">{!! $label !!}</p>
</div>
