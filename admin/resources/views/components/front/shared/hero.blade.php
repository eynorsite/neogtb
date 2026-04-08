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
    class="relative flex items-center overflow-hidden {{ !$image ? 'bg-gradient-to-br from-primary-700 via-primary-600 to-primary-500' : '' }}"
    style="min-height: {{ $minHeight }};"
>
    @if($image)
        <img
            src="{{ $image }}"
            alt="{{ $imageAlt }}"
            width="1200"
            height="630"
            loading="eager"
            fetchpriority="high"
            class="absolute inset-0 w-full h-full object-cover object-center"
        />
    @endif

    @if($image && $overlay === 'gradient')
        <div class="absolute inset-0" style="background: linear-gradient(to right, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.45) 50%, rgba(0,0,0,0.1) 100%);"></div>
    @elseif($overlayClass)
        <div class="absolute inset-0 {{ $overlayClass }}"></div>
    @endif

    <div class="max-w-[1200px] w-full mx-auto px-6 md:px-10 relative z-10">
        <div class="max-w-[640px]">
            @if($eyebrow)
                <p class="inline-flex items-center gap-2 text-[11px] font-medium {{ $eyebrowClasses }} backdrop-blur-sm px-3.5 py-1.5 rounded-full border mb-6 uppercase tracking-wider">
                    {{ $eyebrow }}
                </p>
            @endif

            <h1 class="font-heading font-medium text-white leading-tight tracking-tight mb-5"
                style="font-size: clamp(28px, 4.5vw, 48px);">
                {!! $renderedTitle !!}
            </h1>

            @if($subtitle)
                <p class="text-[15px] md:text-base text-white/65 leading-relaxed max-w-[540px]">
                    {!! $subtitle !!}
                </p>
            @endif

            @if(!empty($tags))
                <div class="mt-6 flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                        <span class="text-xs font-medium px-3 py-1 rounded border border-white/20 bg-white/10 text-white/85 backdrop-blur-sm">
                            {{ $tag }}
                        </span>
                    @endforeach
                </div>
            @endif

            @if($cta || $cta2)
                <div class="mt-8 flex flex-wrap items-center gap-4">
                    @if($cta)
                        <a href="{{ $cta['url'] ?? '#' }}" class="btn-primary px-6 py-3 text-[15px]">
                            {{ $cta['text'] ?? 'En savoir plus' }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endif

                    @if($cta2)
                        <a href="{{ $cta2['url'] ?? '#' }}" class="inline-flex items-center gap-2 text-[14px] font-medium text-white/90 hover:text-white transition-colors">
                            {{ $cta2['text'] ?? 'Découvrir' }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</section>
