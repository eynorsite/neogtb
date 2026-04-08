@props([
    'image' => null,
    'imageAlt' => '',
    'eyebrow' => null,
    'eyebrowColor' => 'accent',
    'title' => '',
    'highlight' => null,
    'subtitle' => null,
    'tags' => [],
    'cta' => null,
    'cta2' => null,
    'minHeight' => '420px',
    'overlay' => 'gradient',
])

@php
    // Auto-wrap highlight word with accent span if provided
    $renderedTitle = $title;
    if ($highlight && is_string($title) && str_contains($title, $highlight)) {
        $renderedTitle = str_replace(
            $highlight,
            '<span class="text-accent-400">' . e($highlight) . '</span>',
            $title
        );
    }

    $overlayClass = match($overlay) {
        'dark'    => 'bg-black/60',
        'none'    => '',
        default   => '', // gradient via inline style below
    };

    $eyebrowClasses = $eyebrowColor === 'dark'
        ? 'text-white/90 bg-black/30 border-white/10'
        : 'text-white/85 bg-white/10 border-white/15';
@endphp

<section
    @class([
        'relative flex items-end lg:items-center overflow-hidden',
        'pt-[72px] pb-10 lg:pt-[136px] lg:pb-20',
        'min-h-[460px] max-h-[72vh] lg:min-h-[520px] lg:max-h-none',
        $image ? 'bg-dark-900' : 'bg-gradient-to-br from-primary-900 to-primary-700',
    ])
    data-hero
>
    @if($image)
        <img src="{{ $image }}" alt="{{ $imageAlt ?? '' }}" width="1600" height="900"
             loading="eager" fetchpriority="high"
             class="absolute inset-0 w-full h-full object-cover object-center" />
        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/55 to-black/20 lg:bg-gradient-to-r lg:from-black/75 lg:via-black/40 lg:to-transparent"></div>
    @endif

    <div class="relative z-10 w-full max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-[640px]">
            @if(!empty($eyebrow))
                <p class="text-[10px] lg:text-[11px] font-semibold uppercase tracking-[0.14em] text-accent-300 mb-4">{{ $eyebrow }}</p>
            @endif

            <h1 class="font-heading font-medium text-white text-[30px] lg:text-[44px] leading-[1.15] tracking-tight mb-4 lg:mb-5">
                {!! $renderedTitle !!}
            </h1>

            @if(!empty($subtitle))
                <p class="text-[15px] lg:text-base text-white/80 leading-relaxed max-w-[540px] mb-6 lg:mb-8">
                    {!! $subtitle !!}
                </p>
            @endif

            @if(!empty($tags))
                <div class="mb-6 flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                        <span class="text-xs font-medium px-3 py-1 rounded border border-white/20 bg-white/10 text-white/85 backdrop-blur-sm">
                            {{ $tag }}
                        </span>
                    @endforeach
                </div>
            @endif

            <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-5">
                <a href="{{ $cta['url'] ?? '/audit' }}"
                   class="inline-flex items-center justify-center gap-2 bg-accent-500 hover:bg-accent-400 text-dark-900 font-semibold text-[14px] px-5 py-3.5 rounded-xl min-h-[48px] w-full sm:w-auto transition-colors">
                    {{ $cta['text'] ?? 'Pré-diagnostic gratuit' }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                @if(!empty($cta2))
                <a href="{{ $cta2['url'] }}" class="inline-flex items-center gap-1.5 text-[14px] font-medium text-white/85 hover:text-white min-h-[44px] px-1">
                    {{ $cta2['text'] }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                @endif
            </div>
        </div>
    </div>
</section>
