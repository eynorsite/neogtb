{{-- cartes-positioning : 3 cards "outils" avec previews (style accueil) --}}
<section style="padding: 56px 0 64px;">
    <div class="max-w-[1280px] 2xl:max-w-[1440px] mx-auto px-5 lg:px-10">
        <x-front.shared.section-header
            :eyebrow="$content['eyebrow'] ?? null"
            :title="$content['titre_section'] ?? ''"
            :intro="$content['sous_titre'] ?? null"
        />

        <div class="grid md:grid-cols-{{ $settings['colonnes'] ?? 3 }} gap-4 lg:gap-6">
            @foreach($content['cartes'] ?? [] as $i => $carte)
                <x-front.shared.card :href="$carte['lien'] ?? '#'" :delay="$i % 3">
                    @if(!empty($carte['icone']))
                        @php $iconKey = $carte['icone']; $isDoc = $iconKey === 'document'; @endphp
                        <div style="width: 48px; height: 48px; border-radius: 10px; background: {{ $isDoc ? '#FFFBEB' : 'var(--color-accent-50)' }}; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                            @switch($iconKey)
                                @case('gauge')
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent-600)" stroke-width="1.5">
                                        <path d="M12 21a9 9 0 1 1 0-18 9 9 0 0 1 0 18Z" stroke-linecap="round"/>
                                        <path d="M12 12l3.5-3.5" stroke-linecap="round" stroke-width="2"/>
                                        <circle cx="12" cy="12" r="1.5" fill="var(--color-accent-600)" stroke="none"/>
                                        <path d="M5.5 16.5h2M16.5 16.5h2M12 5.5v2" stroke-linecap="round" opacity="0.4"/>
                                    </svg>
                                    @break
                                @case('bars')
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent-600)" stroke-width="1.5">
                                        <rect x="3" y="14" width="4" height="7" rx="1" fill="var(--color-accent-200)" stroke="var(--color-accent-600)"/>
                                        <rect x="10" y="8" width="4" height="13" rx="1" fill="var(--color-accent-100)" stroke="var(--color-accent-600)"/>
                                        <rect x="17" y="3" width="4" height="18" rx="1" fill="var(--color-accent-50)" stroke="var(--color-accent-600)"/>
                                    </svg>
                                    @break
                                @case('document')
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="1.5">
                                        <rect x="4" y="2" width="16" height="20" rx="2" fill="#FEF3C7" stroke="#D97706"/>
                                        <path d="M8 7h8M8 11h5" stroke-linecap="round" opacity="0.5"/>
                                        <circle cx="15" cy="16" r="3.5" fill="#FFFBEB" stroke="#D97706" stroke-width="1.5"/>
                                        <path d="M15 14.5v1.5h1.5" stroke="#D97706" stroke-linecap="round" stroke-width="1.5"/>
                                    </svg>
                                    @break
                            @endswitch
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
                    @elseif(($carte['preview'] ?? null) === 'comparateur-bars')
                        <div class="comparateur-preview" style="margin-top: 16px;">
                            <div class="comparateur-row" style="font-size: 12px;">
                                <span style="color: var(--color-dark-500); font-weight: 500;">Siemens</span>
                                <div class="comparateur-bar"><div class="comparateur-bar-fill" style="width: 85%;"></div></div>
                                <span style="color: var(--color-dark-400); font-size: 11px;">8.5</span>
                            </div>
                            <div class="comparateur-row" style="font-size: 12px;">
                                <span style="color: var(--color-dark-500); font-weight: 500;">Schneider</span>
                                <div class="comparateur-bar"><div class="comparateur-bar-fill" style="width: 78%;"></div></div>
                                <span style="color: var(--color-dark-400); font-size: 11px;">7.8</span>
                            </div>
                            <div class="comparateur-row" style="font-size: 12px;">
                                <span style="color: var(--color-dark-500); font-weight: 500;">Honeywell</span>
                                <div class="comparateur-bar"><div class="comparateur-bar-fill" style="width: 72%;"></div></div>
                                <span style="color: var(--color-dark-400); font-size: 11px;">7.2</span>
                            </div>
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
