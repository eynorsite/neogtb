@props(['delay' => 0, 'as' => 'div'])

@php
    $delayClass = $delay > 0 ? "reveal-d{$delay}" : '';
@endphp

<{{ $as }}
    {{ $attributes->merge(['class' => "reveal $delayClass"]) }}
    x-data
    x-intersect.once="$el.classList.add('visible')"
>
    {{ $slot }}
</{{ $as }}>
