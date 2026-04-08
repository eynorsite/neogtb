{{-- Premium Section Header Component --}}
@props([
    'eyebrow' => null,
    'eyebrowColor' => 'accent',
    'title' => '',
    'intro' => null,
    'align' => 'left', // left|center
    'maxWidth' => 'xl', // xl|2xl|3xl
    'dark' => false,
])

@php
    $alignClass = $align === 'center' ? 'text-center mx-auto' : '';
    $maxWidthClass = match($maxWidth) {
        '2xl' => 'max-w-2xl',
        '3xl' => 'max-w-3xl',
        '4xl' => 'max-w-4xl',
        default => 'max-w-xl',
    };
    $textColor = $dark ? 'text-white' : 'text-dark-900';
    $introColor = $dark ? 'text-white/60' : 'text-dark-500';
@endphp

<div {{ $attributes->merge(['class' => "$maxWidthClass mb-14 lg:mb-16 reveal $alignClass"]) }}
     x-data x-intersect.once="$el.classList.add('visible')">
    
    @if($eyebrow)
        <div class="badge-premium mb-6 animate-fade-in-up {{ $dark ? 'bg-white/5 border-white/10 text-white/80' : '' }}">
            <span class="w-2 h-2 rounded-full {{ $dark ? 'bg-accent-400' : 'bg-accent-500' }} animate-pulse-soft"></span>
            {{ $eyebrow }}
        </div>
    @endif

    <h2 class="heading-premium text-3xl sm:text-4xl lg:text-5xl {{ $textColor }} animate-fade-in-up" style="animation-delay: 0.1s;">
        {!! preg_replace('/\b(GTB|GTC|NeoGTB)\b/', '<span class="text-gradient">$1</span>', $title) !!}
    </h2>

    @if($intro)
        <p class="subheading-premium mt-6 text-lg {{ $introColor }} animate-fade-in-up" style="animation-delay: 0.2s;">
            {!! $intro !!}
        </p>
    @endif
</div>
