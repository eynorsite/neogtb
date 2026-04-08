@php
    $hauteur = match($settings['hauteur'] ?? 'medium') {
        'full' => 'min-h-screen',
        'medium' => 'min-h-[70vh]',
        'compact' => 'min-h-[45vh]',
        default => 'min-h-[70vh]',
    };
    $align = match($settings['alignement'] ?? 'center') {
        'left' => 'text-left items-start',
        'right' => 'text-right items-end',
        default => 'text-center items-center',
    };
@endphp

<section data-hero class="{{ $hauteur }} min-h-[460px] max-h-[72vh] lg:min-h-[520px] lg:max-h-none pt-[72px] pb-10 lg:pt-[136px] lg:pb-20 relative flex items-center justify-center overflow-hidden" style="background: linear-gradient(160deg, #060e1a 0%, #0c1b2f 30%, #142b47 60%, #10233b 100%);">
    {{-- Premium orbs --}}
    <div class="hero-orb hero-orb-1"></div>
    <div class="hero-orb hero-orb-2"></div>
    <div class="hero-orb hero-orb-3"></div>
    {{-- Grid overlay --}}
    <div class="absolute inset-0 bg-grid-pattern opacity-[0.04]"></div>
    {{-- Top edge gradient --}}
    <div class="absolute top-0 inset-x-0 h-px" style="background: linear-gradient(90deg, transparent, rgba(45,139,78,0.3), transparent);"></div>

    @if(!empty($content['image']))
        <div class="absolute inset-0">
            @php $heroImg = $content['image']; $heroImgUrl = str_starts_with($heroImg, '/') || str_starts_with($heroImg, 'http') ? $heroImg : asset('storage/' . $heroImg); @endphp
            <img src="{{ $heroImgUrl }}" alt="{{ $content['image_alt'] ?? '' }}" class="h-full w-full object-cover opacity-20">
        </div>
    @endif

    <div class="relative z-10 mx-auto max-w-4xl px-5 lg:px-10 {{ $align }}">
        @if(!empty($content['badge']))
            <div class="mb-8 badge-premium animate-fade-in-up" style="color: var(--color-accent-300); background: rgba(45,139,78,0.12); border-color: rgba(45,139,78,0.2);">
                {{ $content['badge'] }}
            </div>
        @endif

        @if(!empty($content['titre']))
            <h1 class="text-[32px] lg:text-[52px] font-heading font-extrabold leading-[1.1] text-white animate-fade-in-up tracking-tight" style="animation-delay: 0.1s; letter-spacing: -0.03em;">
                {!! preg_replace('/\b(GTB|GTC|NeoGTB)\b/', '<span class="text-gradient-hero">$1</span>', e($content['titre'])) !!}
            </h1>
        @endif

        @if(!empty($content['sous_titre']))
            <p class="mt-6 text-lg sm:text-xl animate-fade-in-up" style="animation-delay: 0.2s; color: rgba(203,213,225,0.9); line-height: 1.6;">
                {{ $content['sous_titre'] }}
            </p>
        @endif

        @if(!empty($content['description']))
            <p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed animate-fade-in-up" style="animation-delay: 0.3s; color: rgba(148,163,184,0.8);">
                {{ $content['description'] }}
            </p>
        @endif

        @if(!empty($content['cta_texte']) || !empty($content['cta2_texte']))
            <div class="mt-10 flex flex-wrap gap-4 {{ ($settings['alignement'] ?? 'center') === 'center' ? 'justify-center' : '' }} animate-fade-in-up" style="animation-delay: 0.4s;">
                @if(!empty($content['cta_texte']))
                    <a href="{{ $content['cta_lien'] ?? '#' }}"
                       class="inline-flex items-center gap-2.5 rounded-xl px-8 py-4 text-[15px] font-bold text-white shadow-lg btn-glow transition-all duration-300"
                       style="background: linear-gradient(135deg, var(--color-accent-500), var(--color-accent-700)); box-shadow: 0 4px 20px -4px rgba(45,139,78,0.4), inset 0 1px 0 rgba(255,255,255,0.12);">
                        {{ $content['cta_texte'] }}
                        <svg class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                @endif
                @if(!empty($content['cta2_texte']))
                    <a href="{{ $content['cta2_lien'] ?? '#' }}"
                       class="inline-flex items-center gap-2.5 rounded-xl px-8 py-4 text-[15px] font-bold text-white backdrop-blur-md transition-all duration-300 hover:bg-white/15"
                       style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        {{ $content['cta2_texte'] }}
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>
