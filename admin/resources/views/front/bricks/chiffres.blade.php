{{-- chiffres : compteurs animés style Lovable (gère texte et nombres) --}}
{{-- variante: 'grid' (défaut, fond clair) ou 'bandeau' (pleine largeur, fond primary-900) --}}
@php
    $variante = $settings['variante'] ?? ($content['variante'] ?? 'grid');
    $isBandeau = $variante === 'bandeau';

    // On filtre en amont les stats sans valeur (vide ou 0) pour ne jamais les afficher.
    $stats = collect($content['stats'] ?? [])
        ->filter(function ($stat) {
            $raw = trim((string) ($stat['valeur'] ?? ''));
            if ($raw === '') {
                return false;
            }
            // Une valeur strictement numérique égale à 0 est considérée comme vide.
            $digits = preg_replace('/[^0-9]/', '', $raw);
            $hasNonDigit = preg_replace('/[0-9]/', '', $raw) !== '';
            return $hasNonDigit || ($digits !== '' && (int) $digits !== 0);
        })
        ->values();
@endphp

@if($stats->isNotEmpty())
@if($isBandeau)
    {{-- Variante bandeau pleine largeur : fond primary-900, chiffres blancs, légendes primary-200 --}}
    <section class="relative py-14 lg:py-20 overflow-hidden bg-primary-900">
        <div class="absolute inset-0 bg-grid-pattern opacity-[0.04]"></div>
        {{-- halo accent diffus, discret, derrière les chiffres (dimensions fixes pour ne pas régresser le CLS) --}}
        <div class="glow-halo glow-halo--accent absolute -top-32 left-1/2 -translate-x-1/2 w-[480px] h-[480px]" aria-hidden="true"></div>
        <div class="relative z-10 max-w-[1280px] 2xl:max-w-[1440px] mx-auto px-5 lg:px-10">
            @if(!empty($content['eyebrow']) || !empty($content['titre']))
                <div class="text-center mb-10 lg:mb-12 animate-fade-in-up">
                    @if(!empty($content['eyebrow']))
                        <p class="text-sm font-semibold uppercase tracking-wider text-accent-400">{{ $content['eyebrow'] }}</p>
                    @endif
                    @if(!empty($content['titre']))
                        <h2 class="font-display mt-2 text-[28px] lg:text-[40px] font-bold text-white">{{ $content['titre'] }}</h2>
                    @endif
                </div>
            @endif

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-10">
                @foreach($stats as $i => $stat)
                    @php
                        $raw = $stat['valeur'] ?? '';
                        $numericPart = preg_replace('/[^0-9]/', '', $raw);
                        $isNumeric = strlen($numericPart) > 0 && $numericPart !== '0';
                        $suffix = $isNumeric ? preg_replace('/[0-9]/', '', $raw) : '';
                        $target = $isNumeric ? (int) $numericPart : 0;
                    @endphp
                    <div class="text-center animate-fade-in-up" style="animation-delay: {{ $i * 100 }}ms"
                         @if($isNumeric)
                         x-data="statCounter"
                         data-target="{{ $target }}"
                         data-suffix="{{ $suffix }}"
                         x-intersect.once="start()"
                         @endif
                    >
                        @if($isNumeric)
                            <div class="font-display text-4xl md:text-5xl font-bold text-white" x-text="count + suffix"></div>
                        @else
                            <div class="font-display text-4xl md:text-5xl font-bold text-white">{{ $raw }}</div>
                        @endif
                        <p class="mt-2 text-sm text-primary-200">{{ $stat['label'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@else
    {{-- Variante grille (défaut) : fond clair. Chiffres en navy institutionnel (primary-500) :
         cohérent avec le rail du hero + conforme DESIGN.md (accent-500 = 4,27:1 interdit pour du texte ;
         data = navy identité, jamais le vert réservé aux actions). Aucun fond quadrillé décoratif. --}}
    <section class="relative py-12 lg:py-24 overflow-hidden bg-dark-50/50">
        <div class="relative z-10 max-w-[1280px] 2xl:max-w-[1440px] mx-auto px-5 lg:px-10">
            @if(!empty($content['eyebrow']) || !empty($content['titre']))
                <div class="text-center mb-12 animate-fade-in-up">
                    @if(!empty($content['eyebrow']))
                        <p class="text-sm font-semibold uppercase tracking-wider text-accent-600">{{ $content['eyebrow'] }}</p>
                    @endif
                    @if(!empty($content['titre']))
                        <h2 class="font-display mt-2 text-[28px] lg:text-[40px] font-bold text-dark-900">{{ $content['titre'] }}</h2>
                    @endif
                </div>
            @endif

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                @foreach($stats as $i => $stat)
                    @php
                        $raw = $stat['valeur'] ?? '';
                        $numericPart = preg_replace('/[^0-9]/', '', $raw);
                        $isNumeric = strlen($numericPart) > 0 && $numericPart !== '0';
                        $suffix = $isNumeric ? preg_replace('/[0-9]/', '', $raw) : '';
                        $target = $isNumeric ? (int) $numericPart : 0;
                    @endphp
                    <div class="text-center animate-fade-in-up" style="animation-delay: {{ $i * 100 }}ms"
                         @if($isNumeric)
                         x-data="statCounter"
                         data-target="{{ $target }}"
                         data-suffix="{{ $suffix }}"
                         x-intersect.once="start()"
                         @endif
                    >
                        @if($isNumeric)
                            <div class="font-display text-3xl md:text-5xl lg:text-6xl font-bold" style="color: var(--color-primary-500);" x-text="count + suffix"></div>
                        @else
                            <div class="font-display text-3xl md:text-5xl lg:text-6xl font-bold" style="color: var(--color-primary-500);">{{ $raw }}</div>
                        @endif
                        <p class="mt-2 text-sm text-dark-600">{{ $stat['label'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
@endif
