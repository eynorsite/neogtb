@php
    // Style de rendu du CTA :
    //   'primary'          => bandeau accent pleine largeur (variante historique, conservée)
    //   'mince'            => bandeau fin inter-sections, 1 phrase + 1 bouton
    //   'sombre-checklist' => bloc primary-900 avec checklist "Ce que vous obtenez" + bouton + microcopy
    $style = $settings['style'] ?? 'primary';

    // Fond du bandeau mince : accent (défaut) ou primary, sans montant ni rhétorique de vendeur.
    $minceFond = ($settings['fond'] ?? 'accent') === 'primary' ? 'bg-primary-600' : 'bg-accent-600';

    // Items de la checklist (variante sombre). Accepte un tableau de chaînes
    // ou un tableau d'objets ['texte' => '...']. Aucun item inventé : tout vient du contenu.
    $checklist = collect($content['checklist'] ?? [])
        ->map(fn ($i) => is_array($i) ? ($i['texte'] ?? $i['text'] ?? '') : $i)
        ->filter()
        ->all();
@endphp

@switch($style)

    {{-- ============================================================
         (a) MINCE — bandeau fin inter-sections (py-4)
         1 phrase + 1 bouton .btn-primary. Fond accent ou primary.
         ============================================================ --}}
    @case('mince')
        <section class="{{ $minceFond }} py-4">
            <div class="mx-auto flex max-w-7xl flex-col items-center justify-center gap-3 px-5 text-center sm:flex-row sm:gap-6 sm:text-left lg:px-10">
                @if(!empty($content['titre']))
                    <p class="text-base font-medium text-white sm:text-lg">{{ $content['titre'] }}</p>
                @endif
                @if(!empty($content['bouton_texte']))
                    <x-front.shared.btn-primary
                        :href="$content['bouton_lien'] ?? '/contact'"
                        class="shrink-0 bg-white !text-dark-900 hover:bg-dark-50">
                        {{ $content['bouton_texte'] }}
                    </x-front.shared.btn-primary>
                @endif
            </div>
        </section>
        @break

    {{-- ============================================================
         (b) SOMBRE-CHECKLIST — bloc primary-900
         Titre + checklist "Ce que vous obtenez" + bouton + microcopy.
         Orbs/halo décoratifs (dimensions fixes => pas de régression CLS).
         ============================================================ --}}
    @case('sombre-checklist')
        <section class="py-12 lg:py-20">
            <div class="mx-auto max-w-7xl px-5 lg:px-10">
                <x-front.shared.reveal>
                    <div class="relative overflow-hidden rounded-2xl bg-primary-900 px-6 py-12 sm:px-10 lg:px-16 lg:py-16">
                        {{-- Décor : halo + orbs (aria-hidden, dimensions fixes pour le CLS) --}}
                        <div aria-hidden="true" class="glow-halo glow-halo--accent" style="width: 320px; height: 320px; top: -120px; right: -80px;"></div>
                        <div aria-hidden="true" class="orb orb--outline orb--slow" style="width: 180px; height: 180px; bottom: -60px; left: -40px;"></div>

                        <div class="relative z-10 mx-auto max-w-3xl text-center">
                            @if(!empty($content['eyebrow']))
                                <p class="mb-3 text-sm font-medium uppercase tracking-wide text-accent-300">{{ $content['eyebrow'] }}</p>
                            @endif

                            @if(!empty($content['titre']))
                                <h2 class="font-display text-3xl font-bold text-white md:text-4xl">{{ $content['titre'] }}</h2>
                            @endif

                            @if(!empty($content['sous_titre']))
                                <p class="mt-4 text-lg text-white/80">{{ $content['sous_titre'] }}</p>
                            @endif

                            @if(!empty($checklist))
                                <p class="mt-8 text-sm font-semibold uppercase tracking-wide text-white/60">Ce que vous obtenez</p>
                                <ul role="list" class="mx-auto mt-4 grid max-w-xl gap-3 text-left sm:grid-cols-2">
                                    @foreach($checklist as $item)
                                        <li class="flex items-start gap-3">
                                            <svg aria-hidden="true" class="mt-0.5 h-5 w-5 shrink-0 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span class="text-base text-white/90">{{ $item }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            @if(!empty($content['bouton_texte']))
                                <div class="mt-10 flex justify-center">
                                    <x-front.shared.btn-primary :href="$content['bouton_lien'] ?? '/contact'">
                                        {{ $content['bouton_texte'] }}
                                    </x-front.shared.btn-primary>
                                </div>
                            @endif

                            {{-- Microcopy de réassurance. Libellé prescrit par défaut ;
                                 l'admin peut le surcharger (clé 'microcopy') ou le masquer
                                 (clé présente mais vide) pour ne rien engager. --}}
                            @php $microcopy = array_key_exists('microcopy', $content) ? $content['microcopy'] : 'Réponse sous 48h · Sans engagement'; @endphp
                            @if(!empty($microcopy))
                                <p class="mt-4 text-sm text-white/60">{{ $microcopy }}</p>
                            @endif
                        </div>
                    </div>
                </x-front.shared.reveal>
            </div>
        </section>
        @break

    {{-- ============================================================
         (défaut) PRIMARY — bandeau accent pleine largeur (variante historique)
         Boutons unifiés sur .btn-primary via <x-front.shared.btn-primary>.
         ============================================================ --}}
    @default
        <section class="relative overflow-hidden bg-accent-500 py-12 lg:py-24">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,_rgba(255,255,255,0.15),_transparent_60%)]"></div>
            <div class="relative z-10 mx-auto max-w-3xl px-4 text-center sm:px-6">
                @if(!empty($content['titre']))
                    <h2 class="font-display text-3xl font-bold text-white md:text-4xl">
                        {!! preg_replace('/\b(GTB|GTC|NeoGTB)\b/', '<span style="opacity: 0.9;">$1</span>', e($content['titre'])) !!}
                    </h2>
                @endif
                @if(!empty($content['sous_titre']))
                    <p class="mt-4 text-lg text-white/80">{{ $content['sous_titre'] }}</p>
                @endif
                @if(!empty($content['bouton_texte']) || !empty($content['bouton2_texte']))
                    <div class="mt-8 flex flex-wrap gap-4 justify-center">
                        @if(!empty($content['bouton_texte']))
                            <x-front.shared.btn-primary
                                :href="$content['bouton_lien'] ?? '#'"
                                class="bg-white !text-dark-900 hover:bg-dark-50">
                                {{ $content['bouton_texte'] }}
                            </x-front.shared.btn-primary>
                        @endif
                        @if(!empty($content['bouton2_texte']))
                            <a href="{{ $content['bouton2_lien'] ?? '#' }}"
                               class="inline-flex items-center gap-2 rounded-lg border-2 border-white/30 px-8 py-4 text-base font-semibold text-white transition-all duration-300 hover:bg-white/10">
                                {{ $content['bouton2_texte'] }}
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </section>
@endswitch
