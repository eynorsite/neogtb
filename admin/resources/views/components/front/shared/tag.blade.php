@props([
    'variant' => 'gtb', // reglementation|technique|protocoles|gtb
])

<span {{ $attributes->merge(['class' => "tag tag-{$variant}"]) }}>{{ $slot }}</span>
