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

<section data-hero class="{{ $hauteur }} min-h-[460px] max-h-[72vh] lg:min-h-[520px] lg:max-h-none pt-[72px] pb-10 lg:pt-[136px] lg:pb-20 relative flex items-center justify-center overflow-hidden bg-gradient-to-br from-dark-950 via-primary-900 to-dark-900">
    <div class="absolute inset-0 bg-gradient-to-r from-[#0a1628]/95 via-[#0a1628]/85 to-[#0a1628]/60"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#0a1628]/80 via-[#0a1628]/30 to-[#0a1628]/50"></div>
    <div class="absolute bottom-0 left-1/4 h-64 w-96 rounded-full bg-accent-500/20 blur-[120px] animate-glow-pulse"></div>
    <div class="absolute top-20 right-10 w-72 h-72 bg-primary-500/15 rounded-full blur-3xl animate-glow-pulse" style="animation-delay: -1.5s;"></div>
    <div class="absolute inset-0 bg-grid-pattern opacity-[0.03]"></div>

    @if(!empty($content['image']))
        <div class="absolute inset-0">
            @php $heroImg = $content['image']; $heroImgUrl = str_starts_with($heroImg, '/') || str_starts_with($heroImg, 'http') ? $heroImg : asset('storage/' . $heroImg); @endphp
            <img src="{{ $heroImgUrl }}" alt="{{ $content['image_alt'] ?? '' }}" class="h-full w-full object-cover opacity-20">
        </div>
    @endif

    <div class="relative z-10 mx-auto max-w-4xl px-5 lg:px-10 {{ $align }}">
        @if(!empty($content['badge']))
            <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-accent-500/30 bg-accent-500/10 px-4 py-1.5 text-sm font-medium text-accent-400 backdrop-blur-sm animate-fade-in-up">
                {{ $content['badge'] }}
            </div>
        @endif

        @if(!empty($content['titre']))
            <h1 class="font-display text-3xl md:text-5xl lg:text-7xl font-bold leading-[1.1] tracking-tight text-white animate-fade-in-up" style="animation-delay: 0.1s;">
                {!! preg_replace('/\b(GTB|GTC|NeoGTB)\b/', '<span class="text-gradient">$1</span>', e($content['titre'])) !!}
            </h1>
        @endif

        @if(!empty($content['sous_titre']))
            <p class="mt-6 max-w-2xl text-lg leading-relaxed text-white/70 md:text-xl animate-fade-in-up" style="animation-delay: 0.2s;">
                {{ $content['sous_titre'] }}
            </p>
        @endif

        @if(!empty($content['description']))
            <p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed text-white/50 animate-fade-in-up" style="animation-delay: 0.3s;">
                {{ $content['description'] }}
            </p>
        @endif

        @if(!empty($content['cta_texte']) || !empty($content['cta2_texte']))
            <div class="mt-10 flex flex-wrap gap-4 {{ ($settings['alignement'] ?? 'center') === 'center' ? 'justify-center' : '' }} animate-fade-in-up" style="animation-delay: 0.4s;">
                @if(!empty($content['cta_texte']))
                    <a href="{{ $content['cta_lien'] ?? '#' }}"
                       class="inline-flex items-center gap-2 rounded-lg bg-accent-500 px-8 py-4 text-base font-semibold text-dark-950 shadow-lg shadow-accent-500/25 transition-all duration-300 hover:bg-accent-600 hover:scale-105 hover:shadow-xl hover:shadow-accent-500/40">
                        {{ $content['cta_texte'] }}
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                @endif
                @if(!empty($content['cta2_texte']))
                    <a href="{{ $content['cta2_lien'] ?? '#' }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-white/30 px-8 py-4 text-base font-semibold text-white transition-all duration-300 hover:bg-white/10">
                        {{ $content['cta2_texte'] }}
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>
