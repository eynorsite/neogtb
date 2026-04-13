{{-- cartes-positioning : 3 cards "outils" avec previews redesign --}}
<section class="py-12 lg:py-24">
    <div class="max-w-[1280px] 2xl:max-w-[1440px] mx-auto px-5 lg:px-10">
        <x-front.shared.section-header
            :eyebrow="$content['eyebrow'] ?? null"
            :title="$content['titre_section'] ?? ''"
            :intro="$content['sous_titre'] ?? null"
        />

        <div class="grid sm:grid-cols-2 lg:grid-cols-{{ $settings['colonnes'] ?? 3 }} gap-5 lg:gap-7 items-stretch">
            @foreach($content['cartes'] ?? [] as $i => $carte)
                <x-front.shared.card :href="$carte['lien'] ?? '#'" :delay="$i % 3" class="flex flex-col h-full">

                    {{-- Icone grande avec fond accent --}}
                    @if(!empty($carte['icone']))
                        @php $iconKey = $carte['icone']; @endphp
                        <div style="width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 24px;
                            background: linear-gradient(135deg, var(--color-accent-50), var(--color-accent-100));">
                            @switch($iconKey)
                                @case('gauge')
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent-600)" stroke-width="1.5">
                                        <path d="M12 21a9 9 0 1 1 0-18 9 9 0 0 1 0 18Z" stroke-linecap="round"/>
                                        <path d="M12 12l3.5-3.5" stroke-linecap="round" stroke-width="2"/>
                                        <circle cx="12" cy="12" r="1.5" fill="var(--color-accent-600)" stroke="none"/>
                                        <path d="M5.5 16.5h2M16.5 16.5h2M12 5.5v2" stroke-linecap="round" opacity="0.4"/>
                                    </svg>
                                    @break
                                @case('bars')
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent-600)" stroke-width="1.5">
                                        <rect x="3" y="14" width="4" height="7" rx="1" fill="var(--color-accent-200)" stroke="var(--color-accent-600)"/>
                                        <rect x="10" y="8" width="4" height="13" rx="1" fill="var(--color-accent-100)" stroke="var(--color-accent-600)"/>
                                        <rect x="17" y="3" width="4" height="18" rx="1" fill="var(--color-accent-50)" stroke="var(--color-accent-600)"/>
                                    </svg>
                                    @break
                                @case('document')
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent-600)" stroke-width="1.5">
                                        <rect x="4" y="2" width="16" height="20" rx="2" fill="var(--color-accent-100)" stroke="var(--color-accent-600)"/>
                                        <path d="M8 7h8M8 11h5" stroke-linecap="round" opacity="0.5"/>
                                        <circle cx="15" cy="16" r="3.5" fill="var(--color-accent-50)" stroke="var(--color-accent-600)" stroke-width="1.5"/>
                                        <path d="M15 14.5v1.5h1.5" stroke="var(--color-accent-600)" stroke-linecap="round" stroke-width="1.5"/>
                                    </svg>
                                    @break
                            @endswitch
                        </div>
                    @endif

                    {{-- Titre --}}
                    <h3 style="font-family: 'DM Sans', sans-serif; font-size: 18px; font-weight: 600; color: var(--color-dark-900); margin-bottom: 10px; letter-spacing: -0.01em; line-height: 1.35;">
                        {{ $carte['titre'] ?? '' }}
                    </h3>

                    {{-- Description --}}
                    <p style="font-size: 14px; color: var(--color-dark-500); line-height: 1.65; margin-bottom: 0;">{{ $carte['description'] ?? '' }}</p>

                    {{-- Preview stylisee --}}
                    <div style="margin-top: auto; padding-top: 20px;">
                        @if(($carte['preview'] ?? null) === 'gauge-en15232')
                            <div style="padding: 16px; border-radius: 12px; background: linear-gradient(135deg, var(--color-accent-50), rgba(45, 139, 78, 0.04)); border: 1px solid var(--color-accent-100);">
                                <x-front.shared.gauge-en15232 active="B" />
                            </div>
                        @elseif(($carte['preview'] ?? null) === 'comparateur-bars')
                            <div style="padding: 16px; border-radius: 12px; background: linear-gradient(135deg, var(--color-accent-50), rgba(45, 139, 78, 0.04)); border: 1px solid var(--color-accent-100);">
                                <div class="comparateur-preview">
                                    @php
                                        $brands = [
                                            ['nom' => 'Siemens', 'pct' => 85, 'note' => '8.5'],
                                            ['nom' => 'Schneider', 'pct' => 78, 'note' => '7.8'],
                                            ['nom' => 'Honeywell', 'pct' => 72, 'note' => '7.2'],
                                        ];
                                    @endphp
                                    @foreach($brands as $brand)
                                        <div class="comparateur-row" style="font-size: 12px; margin-bottom: 8px;">
                                            <span style="color: var(--color-dark-600); font-weight: 500; min-width: 72px;">{{ $brand['nom'] }}</span>
                                            <div class="comparateur-bar"><div class="comparateur-bar-fill" style="width: {{ $brand['pct'] }}%;"></div></div>
                                            <span style="color: var(--color-dark-400); font-size: 11px; font-weight: 500; min-width: 24px; text-align: right;">{{ $brand['note'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @elseif(($carte['preview'] ?? null) === 'estimation-cee' && !empty($carte['preview_data']))
                            <div style="padding: 16px; border-radius: 12px; background: linear-gradient(135deg, var(--color-accent-50), rgba(45, 139, 78, 0.04)); border: 1px solid var(--color-accent-100);">
                                <p style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: var(--color-accent-600); margin-bottom: 6px;">Estimation type</p>
                                <p style="font-size: 26px; font-weight: 700; color: var(--color-dark-900); letter-spacing: -0.02em; line-height: 1;">{{ $carte['preview_data']['valeur'] ?? '' }}</p>
                                <p style="font-size: 12px; color: var(--color-dark-500); margin-top: 6px; line-height: 1.4;">{{ $carte['preview_data']['contexte'] ?? '' }}</p>
                                @if(!empty($carte['preview_data']['maj']))
                                    <p style="font-size: 10px; color: var(--color-dark-400); margin-top: 6px; font-style: italic;">{{ $carte['preview_data']['maj'] }}</p>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- CTA bouton --}}
                    @if(!empty($carte['cta_texte']))
                        <div style="margin-top: 20px;">
                            <span class="card-cta-btn" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 10px; font-size: 14px; font-weight: 600; color: white; background: var(--color-accent-600); transition: all 0.25s ease; letter-spacing: -0.005em;">
                                {{ $carte['cta_texte'] }}
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 8h10M9 4l4 4-4 4"/>
                                </svg>
                            </span>
                        </div>
                    @endif

                </x-front.shared.card>
            @endforeach
        </div>

        @if(!empty($content['cta_inline_texte']))
            <x-front.shared.reveal class="text-center" style="margin-top: 48px;">
                <p style="font-size: 15px; color: var(--color-dark-500); margin-bottom: 16px;">{{ $content['cta_inline_texte'] }}</p>
                @if(!empty($content['cta_inline_lien_texte']))
                    <a href="{{ $content['cta_inline_lien'] ?? '#' }}"
                       style="display: inline-flex; align-items: center; gap: 6px; font-size: 14px; font-weight: 600; color: var(--color-accent-600); text-decoration: none; padding: 8px 0; border-bottom: 2px solid var(--color-accent-200); transition: border-color 0.25s ease;"
                       onmouseover="this.style.borderColor='var(--color-accent-500)'"
                       onmouseout="this.style.borderColor='var(--color-accent-200)'">
                        {{ $content['cta_inline_lien_texte'] }}
                        <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
                    </a>
                @endif
            </x-front.shared.reveal>
        @endif
    </div>
</section>
