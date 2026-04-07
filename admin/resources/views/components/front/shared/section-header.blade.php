@props([
    'eyebrow' => null,
    'eyebrowColor' => 'accent',
    'title' => '',
    'intro' => null,
    'align' => 'left', // left|center
    'maxWidth' => 'xl', // xl|2xl|3xl
])

@php
    $alignClass = $align === 'center' ? 'text-center mx-auto' : '';
    $maxWidthClass = match($maxWidth) {
        '2xl' => 'max-w-2xl',
        '3xl' => 'max-w-3xl',
        default => 'max-w-xl',
    };
@endphp

<div {{ $attributes->merge(['class' => "$maxWidthClass mb-10 reveal $alignClass"]) }}
     x-data x-intersect.once="$el.classList.add('visible')">
    @if($eyebrow)
        <x-front.shared.eyebrow :color="$eyebrowColor">{{ $eyebrow }}</x-front.shared.eyebrow>
    @endif

    <h2 style="font-size: clamp(28px, 3vw, 36px); font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.02em; line-height: 1.2; margin-bottom: 12px;">
        {!! $title !!}
    </h2>

    @if($intro)
        <p style="font-size: 16px; color: var(--color-dark-500); line-height: 1.7;">{!! $intro !!}</p>
    @endif
</div>
