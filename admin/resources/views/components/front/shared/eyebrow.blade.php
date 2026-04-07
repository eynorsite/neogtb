@props(['color' => 'accent'])

@php
    $colorClass = match($color) {
        'energy' => 'text-[var(--color-accent-600)]',
        default => 'text-[#267a43]',
    };
@endphp

<p {{ $attributes->merge(['class' => "eyebrow $colorClass"]) }}>{{ $slot }}</p>
