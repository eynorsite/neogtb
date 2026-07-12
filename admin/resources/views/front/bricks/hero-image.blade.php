{{-- hero-image : HERO LIGHT MODE "bolder" — aligné DESIGN.md § signature (fond clair, titre sombre, AUCUN voile sombre).
     Composition split asymétrique : contenu à gauche, photo hero CONTENUE à droite (image préservée, jamais en plein
     cadre sombre). L'audace vient de la hiérarchie (H1 dominant + rail de preuves data), pas de l'ombre.
     Header compatible : nav en texte sombre sur fond clair. Décor limité aux halos doux (bénis par DESIGN.md). --}}
@php
    $img = $content['image'] ?? null;
    $imgUrl = $img ? (str_starts_with($img, '/') || str_starts_with($img, 'http') ? $img : asset('storage/' . $img)) : null;
    $statCount = max(1, count($content['stats'] ?? []));
@endphp

<section data-hero class="relative overflow-hidden bg-gradient-to-b from-white via-primary-50/40 to-white pt-[92px] pb-16 lg:pt-[128px] lg:pb-24" style="min-height: 520px;">

    {{-- Halos flous très doux (décor béni par DESIGN.md : « halos pulsés très doux »). aria-hidden ; reduced-motion coupé en app.css. --}}
    <div aria-hidden="true" class="glow-halo glow-halo--accent -top-24 right-1/3 w-[380px] h-[380px]"></div>
    <div aria-hidden="true" class="glow-halo glow-halo--primary bottom-0 -left-32 w-[420px] h-[420px]"></div>

    <div class="max-w-[1280px] 2xl:max-w-[1440px] mx-auto px-5 lg:px-10 relative z-10">
        <div class="grid items-center gap-10 lg:grid-cols-2 lg:gap-16">

            {{-- ---------- Colonne contenu (en premier dans le DOM => en haut sur mobile : le H1 frappe avant l'image) ---------- --}}
            <div>
                @if(!empty($content['badge']))
                    <p class="mb-6 inline-flex items-center gap-2 rounded-full border border-accent-600/25 bg-accent-50 px-4 py-1.5 text-sm font-medium text-accent-700">
                        {{ $content['badge'] }}
                    </p>
                @endif

                @if(!empty($content['pre_titre']))
                    {{-- Marque emphasée en vert (convention DESIGN.md : nom de marque = accent-600 plein). --}}
                    <p style="font-family: var(--font-display), system-ui, sans-serif; font-size: 13px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--color-accent-600); margin-bottom: 16px;">
                        {!! $content['pre_titre'] !!}
                    </p>
                @endif

                @if(!empty($content['titre']))
                    {{-- H1 focal point : DM Sans 700, ~60px desktop, line-height 1.1 (référence DESIGN.md). Marque auto-emphasée en vert. --}}
                    <h1 style="font-family: var(--font-display), system-ui, sans-serif; font-size: clamp(2.125rem, 4.8vw, 3.75rem); font-weight: 700; line-height: 1.1; letter-spacing: -0.03em; color: #111827; text-wrap: balance; margin-bottom: 20px;">
                        {{-- Lookarounds Unicode (pas de \b, fragile avec « é ») + libellés longs d'abord : match propre de NéoGTB/NeoGTB/GTC/GTB. --}}
                        {!! preg_replace('/(?<![\p{L}\p{N}])(NéoGTB|NeoGTB|GTC|GTB)(?![\p{L}\p{N}])/u', '<span style="color: var(--color-accent-600);">$1</span>', e($content['titre'])) !!}
                    </h1>
                @endif

                @if(!empty($content['description']))
                    {{-- Chapô : text-lg (20px, échelle officielle DESIGN.md), dark-600 (AA fort). --}}
                    <p class="max-w-xl text-lg" style="color: var(--color-dark-600); line-height: 1.6; margin-bottom: 32px;">
                        {{ $content['description'] }}
                    </p>
                @endif

                @if(!empty($content['stats']))
                    {{-- Rail de preuves sur fond clair : filet haut neutre (bord complet, jamais de side-stripe coloré),
                         chiffres navy institutionnels, séparateurs 1px. Grid à N colonnes => une rangée, jamais de wrap orphelin. --}}
                    <div style="display: grid; grid-template-columns: repeat({{ $statCount }}, minmax(0, 1fr)); border-top: 1px solid var(--color-dark-200); padding-top: 20px; margin-bottom: 32px; max-width: 560px;">
                        @foreach($content['stats'] as $i => $stat)
                            @php $divider = $i > 0 ? 'border-left: 1px solid var(--color-dark-200); padding-left: clamp(14px, 2.4vw, 24px);' : ''; @endphp
                            <div style="{{ $divider }} padding-right: 12px; min-width: 0;">
                                <p style="font-family: var(--font-display), system-ui, sans-serif; font-size: clamp(22px, 3.2vw, 30px); font-weight: 700; color: var(--color-primary-500); letter-spacing: -0.02em; line-height: 1;">{{ $stat['valeur'] ?? '' }}</p>
                                <p style="font-size: 12.5px; color: var(--color-dark-600); margin-top: 8px; line-height: 1.4;">{{ $stat['label'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="flex flex-wrap items-center gap-4">
                    @if(!empty($content['cta_texte']))
                        <x-front.shared.btn-primary :href="$content['cta_lien'] ?? '#'" class="px-8 py-4 text-base">
                            {{ $content['cta_texte'] }}
                        </x-front.shared.btn-primary>
                    @endif
                    @if(!empty($content['cta2_texte']))
                        <a href="{{ $content['cta2_lien'] ?? '#' }}"
                           class="inline-flex items-center gap-2 rounded-lg border border-primary-200 bg-white px-8 py-4 text-base font-semibold text-primary-700 transition-colors duration-200 hover:bg-primary-50">
                            {{ $content['cta2_texte'] }}
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    @endif
                </div>
            </div>

            {{-- ---------- Colonne image : photo hero CONTENUE (préservée), cadre clair arrondi, AUCUN voile sombre ---------- --}}
            @if($imgUrl)
                <div class="relative">
                    <div class="relative overflow-hidden rounded-2xl ring-1 ring-dark-200"
                         style="aspect-ratio: 16 / 9; box-shadow: 0 24px 60px -24px rgba(16,35,59,0.28);">
                        <img src="{{ $imgUrl }}" alt="{{ $content['image_alt'] ?? '' }}"
                             width="800" height="450" loading="eager" fetchpriority="high"
                             class="h-full w-full object-cover">
                    </div>
                </div>
            @endif

        </div>
    </div>
</section>
