@props([
    'href' => null,
    'padding' => 'p-8',
    'delay' => 0, // 0|1|2
])

@php
    $delayClass = $delay > 0 ? "reveal-d{$delay}" : '';
    $tag = $href ? 'a' : 'div';
@endphp

<{{ $tag }}
    @if($href) href="{{ $href }}" style="text-decoration: none;" @endif
    {{ $attributes->merge(['class' => "glass-card block $padding reveal $delayClass"]) }}
    x-data
    x-intersect.once="$el.classList.add('visible')"
>
    {{ $slot }}
</{{ $tag }}>
