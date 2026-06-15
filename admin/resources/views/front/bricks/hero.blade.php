@php
    // ------------------------------------------------------------------
    // HERO SIGNATURE — LIGHT MODE
    // Fond clair, titre sombre #111827, AUCUN overlay sombre, AUCUNE classe dark:.
    // Décor : 3-4 orbs (images hero-*.webp recadrées rondes) + halos floutés pulsés.
    // Toutes les animations sont coupées par prefers-reduced-motion (app.css:110-117).
    // Dimensions w/h FIXES sur chaque orbe/image => CLS 0 (cf. app.css:246).
    // ------------------------------------------------------------------
    $hauteur = match($settings['hauteur'] ?? 'medium') {
        'full'    => 'min-h-screen',
        'medium'  => 'min-h-[70vh]',
        'compact' => 'min-h-[45vh]',
        default   => 'min-h-[70vh]',
    };
    $align = match($settings['alignement'] ?? 'center') {
        'left'  => 'text-left items-start',
        'right' => 'text-right items-end',
        default => 'text-center items-center',
    };
    $isCenter = ($settings['alignement'] ?? 'center') === 'center';

    // Orbs décoratifs : images existantes recadrées rondes (object-cover).
    // Chaque orbe a une taille fixe (w/h) + l'<img> porte width/height => pas de CLS.
    $orbs = [
        ['img' => 'hero-gtb.webp',           'size' => 200, 'pos' => 'top-[8%] left-[6%]',        'mods' => 'orb--slow'],
        ['img' => 'hero-solutions.webp',     'size' => 128, 'pos' => 'top-[18%] right-[10%]',     'mods' => 'orb--delay orb--reverse'],
        ['img' => 'hero-reglementation.webp','size' => 160, 'pos' => 'bottom-[10%] left-[14%]',    'mods' => 'orb--reverse'],
        ['img' => 'hero-gtc.webp',           'size' => 96,  'pos' => 'bottom-[16%] right-[16%]',   'mods' => 'orb--slow orb--delay'],
    ];
@endphp

<section data-hero
    class="{{ $hauteur }} min-h-[460px] max-h-[72vh] lg:min-h-[520px] lg:max-h-none pt-[72px] pb-10 lg:pt-[136px] lg:pb-20 relative flex items-center justify-center overflow-hidden bg-gradient-to-b from-white via-primary-50/40 to-white">

    {{-- Halos floutés pulsés (décoratifs, pointer-events:none via .glow-halo) --}}
    <div aria-hidden="true" class="glow-halo glow-halo--accent  -top-24 -left-24 w-[420px] h-[420px]"></div>
    <div aria-hidden="true" class="glow-halo glow-halo--primary top-1/3 -right-32 w-[480px] h-[480px]"></div>
    <div aria-hidden="true" class="glow-halo glow-halo--warm    -bottom-32 left-1/3 w-[360px] h-[360px]"></div>

    {{-- Grille subtile (light) --}}
    <div aria-hidden="true" class="absolute inset-0 bg-grid-pattern opacity-[0.05]"></div>

    {{-- Orbs flottants : images hero recadrées rondes, dimensions fixes (CLS 0) --}}
    @foreach ($orbs as $orb)
        <div aria-hidden="true"
             class="orb {{ $orb['mods'] }} {{ $orb['pos'] }} overflow-hidden ring-1 ring-primary-100/60 shadow-sm hidden sm:block"
             style="width: {{ $orb['size'] }}px; height: {{ $orb['size'] }}px;">
            <img src="{{ asset('images/' . $orb['img']) }}" alt=""
                 width="{{ $orb['size'] }}" height="{{ $orb['size'] }}"
                 loading="lazy" decoding="async"
                 class="w-full h-full object-cover">
        </div>
    @endforeach

    {{-- Image hero optionnelle pilotée par le contenu (légère, sans overlay sombre) --}}
    @if(!empty($content['image']))
        @php
            $heroImg = $content['image'];
            $heroImgUrl = str_starts_with($heroImg, '/') || str_starts_with($heroImg, 'http')
                ? $heroImg
                : asset('storage/' . $heroImg);
        @endphp
        <div aria-hidden="true" class="absolute inset-0">
            <img src="{{ $heroImgUrl }}" alt="{{ $content['image_alt'] ?? '' }}"
                 width="1200" height="630" loading="lazy" decoding="async"
                 class="h-full w-full object-cover opacity-[0.06]">
        </div>
    @endif

    {{-- Contenu --}}
    <div class="relative z-10 mx-auto max-w-4xl px-5 lg:px-10 {{ $align }}">
        @if(!empty($content['badge']))
            <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-accent-600/25 bg-accent-50 px-4 py-1.5 text-sm font-medium text-accent-700 animate-fade-in-up">
                {{ $content['badge'] }}
            </div>
        @endif

        @if(!empty($content['titre']))
            {{-- H1 : ~60px desktop / weight 700 / line-height 1.1 ; mobile text-4xl leading-tight --}}
            <h1 class="font-display text-4xl leading-tight md:text-5xl lg:text-[60px] lg:leading-[1.1] font-bold tracking-tight text-[#111827] animate-fade-in-up" style="animation-delay: 0.1s;">
                {!! preg_replace('/\b(GTB|GTC|NeoGTB)\b/', '<span class="text-gradient">$1</span>', e($content['titre'])) !!}
            </h1>
        @endif

        @if(!empty($content['sous_titre']))
            <p class="mt-6 {{ $isCenter ? 'mx-auto' : '' }} max-w-2xl text-lg leading-relaxed text-dark-600 md:text-xl animate-fade-in-up" style="animation-delay: 0.2s;">
                {{ $content['sous_titre'] }}
            </p>
        @endif

        @if(!empty($content['description']))
            <p class="mt-4 {{ $isCenter ? 'mx-auto' : '' }} max-w-2xl text-base leading-relaxed text-dark-500 animate-fade-in-up" style="animation-delay: 0.3s;">
                {{ $content['description'] }}
            </p>
        @endif

        {{-- Bandeau de réassurance (light, sans JS) --}}
        <div class="animate-fade-in-up" style="animation-delay: 0.35s;">
            @include('front.partials.reassurance-badges', ['class' => 'mt-8'])
        </div>

        @if(!empty($content['cta_texte']) || !empty($content['cta2_texte']))
            <div class="mt-10 flex flex-wrap gap-4 {{ $isCenter ? 'justify-center' : '' }} animate-fade-in-up" style="animation-delay: 0.4s;">
                @if(!empty($content['cta_texte']))
                    <a href="{{ $content['cta_lien'] ?? '/contact' }}" class="btn-primary px-8 py-4 text-base">
                        {{ $content['cta_texte'] }}
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                @endif
                @if(!empty($content['cta2_texte']))
                    <a href="{{ $content['cta2_lien'] ?? '#' }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-primary-200 bg-white px-8 py-4 text-base font-semibold text-primary-700 transition-colors duration-200 hover:bg-primary-50">
                        {{ $content['cta2_texte'] }}
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>
