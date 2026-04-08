<section style="padding: 56px 0 64px;">
    <div class="max-w-[1280px] 2xl:max-w-[1440px] mx-auto px-5 lg:px-10">
        <x-front.shared.section-header
            :eyebrow="$content['eyebrow'] ?? null"
            :title="$content['titre'] ?? ''"
        />

        <div class="grid md:grid-cols-{{ $settings['colonnes'] ?? 2 }} gap-4 lg:gap-6">
            @foreach($content['cas'] ?? [] as $i => $cas)
                <x-front.shared.card :delay="$i">
                    <div class="flex items-center gap-3 mb-6">
                        @if(!empty($cas['tag']))
                            <x-front.shared.tag :variant="$cas['tag_variant'] ?? 'gtb'">{{ $cas['tag'] }}</x-front.shared.tag>
                        @endif
                        @if(!empty($cas['meta']))
                            <span style="font-size: 13px; color: var(--color-dark-400);">{{ $cas['meta'] }}</span>
                        @endif
                    </div>

                    <h3 style="font-size: 20px; font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.02em; margin-bottom: 12px; line-height: 1.3;">
                        {{ $cas['titre'] ?? '' }}
                    </h3>

                    @if(!empty($cas['contexte']))
                        <p style="font-size: 15px; color: var(--color-dark-500); line-height: 1.7; margin-bottom: 20px;">{{ $cas['contexte'] }}</p>
                    @endif

                    @if(!empty($cas['approche']))
                        <div style="border-left: 2px solid var(--color-accent-500); padding-left: 16px; margin-bottom: 24px;">
                            <p style="font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.08em; color: var(--color-dark-400); margin-bottom: 6px;">Approche</p>
                            <p style="font-size: 14px; color: var(--color-dark-500); line-height: 1.6;">{{ $cas['approche'] }}</p>
                        </div>
                    @endif

                    @if(!empty($cas['gauge']))
                        <div style="margin-bottom: 16px;">
                            @if(!empty($cas['gauge']['label']))
                                <p style="font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-dark-400); margin-bottom: 8px;">{{ $cas['gauge']['label'] }}</p>
                            @endif
                            <x-front.shared.gauge-en15232
                                :active="$cas['gauge']['active'] ?? 'B'"
                                :progressFrom="$cas['gauge']['progress_from'] ?? null"
                            />
                        </div>
                    @endif

                    @if(!empty($cas['metriques']))
                        <div class="grid grid-cols-2 gap-4">
                            @foreach($cas['metriques'] as $m)
                                @php
                                    $col = match($m['couleur'] ?? 'dark') {
                                        'energy' => 'var(--color-accent-600)',
                                        'accent' => 'var(--color-accent-600)',
                                        default => 'var(--color-dark-900)',
                                    };
                                @endphp
                                <div style="padding: 14px; border-radius: 8px; background: var(--color-dark-50);">
                                    <p style="font-size: 22px; font-weight: 500; color: {{ $col }}; letter-spacing: -0.02em;">{{ $m['valeur'] ?? '' }}</p>
                                    <p style="font-size: 11px; color: var(--color-dark-400); margin-top: 4px;">{{ $m['label'] ?? '' }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </x-front.shared.card>
            @endforeach
        </div>

        @if(!empty($content['cta_texte']))
            <x-front.shared.reveal class="text-center" style="margin-top: 32px;">
                <a href="{{ $content['cta_lien'] ?? '#' }}"
                   style="font-size: 14px; font-weight: 500; color: var(--color-accent-600); text-decoration: none; border-bottom: 1px solid var(--color-accent-200);">
                    {{ $content['cta_texte'] }}
                </a>
            </x-front.shared.reveal>
        @endif
    </div>
</section>
