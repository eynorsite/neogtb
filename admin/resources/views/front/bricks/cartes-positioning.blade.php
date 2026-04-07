{{-- cartes-positioning : 3 cards "outils" avec previews (style accueil) --}}
<section style="padding: 56px 0 64px;">
    <div class="max-w-[1200px] mx-auto px-6 md:px-10">
        <x-front.shared.section-header
            :eyebrow="$content['eyebrow'] ?? null"
            :title="$content['titre_section'] ?? ''"
            :intro="$content['sous_titre'] ?? null"
        />

        <div class="grid md:grid-cols-{{ $settings['colonnes'] ?? 3 }} gap-6">
            @foreach($content['cartes'] ?? [] as $i => $carte)
                <x-front.shared.card :href="$carte['lien'] ?? '#'" :delay="$i % 3">
                    @if(!empty($carte['icone']))
                        <div style="width: 48px; height: 48px; border-radius: 10px; background: var(--color-accent-50); display: flex; align-items: center; justify-content: center; margin-bottom: 20px; font-size: 22px;">
                            {{ $carte['icone'] }}
                        </div>
                    @endif

                    <h3 style="font-size: 18px; font-weight: 500; color: var(--color-dark-900); margin-bottom: 10px; letter-spacing: -0.01em;">
                        {{ $carte['titre'] ?? '' }}
                    </h3>

                    <p style="font-size: 14px; color: var(--color-dark-500); line-height: 1.6;">{{ $carte['description'] ?? '' }}</p>

                    @if(($carte['preview'] ?? null) === 'gauge-en15232')
                        <div style="margin-top: 16px;">
                            <x-front.shared.gauge-en15232 active="B" />
                        </div>
                    @elseif(($carte['preview'] ?? null) === 'estimation-cee' && !empty($carte['preview_data']))
                        <div style="margin-top: 16px; padding: 12px; border-radius: 8px; background: #FFFBEB; border: 1px solid #FDE68A;">
                            <p style="font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; color: #D97706; margin-bottom: 4px;">Estimation type</p>
                            <p style="font-size: 22px; font-weight: 600; color: #B45309; letter-spacing: -0.02em;">{{ $carte['preview_data']['valeur'] ?? '' }}</p>
                            <p style="font-size: 11px; color: var(--color-dark-400); margin-top: 2px;">{{ $carte['preview_data']['contexte'] ?? '' }}</p>
                            @if(!empty($carte['preview_data']['maj']))
                                <p style="font-size: 10px; color: var(--color-dark-400); margin-top: 4px; font-style: italic;">{{ $carte['preview_data']['maj'] }}</p>
                            @endif
                        </div>
                    @endif

                    @if(!empty($carte['cta_texte']))
                        <p style="margin-top: 16px; font-size: 14px; font-weight: 500; color: var(--color-accent-600);">{{ $carte['cta_texte'] }}</p>
                    @endif
                </x-front.shared.card>
            @endforeach
        </div>

        @if(!empty($content['cta_inline_texte']))
            <x-front.shared.reveal class="text-center" style="margin-top: 48px;">
                <p style="font-size: 15px; color: var(--color-dark-500); margin-bottom: 16px;">{{ $content['cta_inline_texte'] }}</p>
                @if(!empty($content['cta_inline_lien_texte']))
                    <a href="{{ $content['cta_inline_lien'] ?? '#' }}"
                       style="font-size: 14px; font-weight: 500; color: var(--color-accent-600); text-decoration: none; border-bottom: 1px solid var(--color-accent-200);">
                        {{ $content['cta_inline_lien_texte'] }}
                    </a>
                @endif
            </x-front.shared.reveal>
        @endif
    </div>
</section>
