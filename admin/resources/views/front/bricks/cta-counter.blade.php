{{-- cta-counter : compteur d'usage + CTA "honnête" --}}
<section style="padding: 56px 0 64px;">
    <div class="max-w-[1280px] 2xl:max-w-[1440px] mx-auto px-5 lg:px-10">

        @if(!empty($content['compteurs']))
            <x-front.shared.reveal class="text-center" style="margin-bottom: 64px;">
                @if(!empty($content['eyebrow']))
                    <x-front.shared.eyebrow>{{ $content['eyebrow'] }}</x-front.shared.eyebrow>
                @endif
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 lg:gap-6" style="max-width: 800px; margin: 24px auto 0;">
                    @foreach($content['compteurs'] as $c)
                        @php
                            $col = match($c['couleur'] ?? 'dark') {
                                'energy' => 'var(--color-accent-600)',
                                'accent' => 'var(--color-accent-600)',
                                default => 'var(--color-dark-900)',
                            };
                        @endphp
                        <div>
                            <p style="font-size: 36px; font-weight: 500; color: {{ $col }}; letter-spacing: -0.03em;">{{ $c['valeur'] ?? '' }}</p>
                            <p style="font-size: 13px; color: var(--color-dark-400); margin-top: 4px;">{{ $c['label'] ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
            </x-front.shared.reveal>
        @endif

        <x-front.shared.reveal>
            <div style="background: var(--color-dark-50); border: 1px solid var(--color-dark-200); border-radius: 16px; padding: 48px; text-align: center;">
                @if(!empty($content['titre']))
                    <h2 style="font-size: clamp(24px, 3vw, 32px); font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.02em; line-height: 1.2; margin-bottom: 12px;">
                        {{ $content['titre'] }}
                    </h2>
                @endif

                @if(!empty($content['sous_titre']))
                    <p style="font-size: 16px; color: var(--color-dark-500); line-height: 1.7; max-width: 560px; margin: 0 auto 12px;">
                        {{ $content['sous_titre'] }}
                    </p>
                @endif

                @if(!empty($content['note']))
                    <p style="font-size: 13px; color: var(--color-dark-400); margin-bottom: 32px;">{{ $content['note'] }}</p>
                @endif

                <div style="display: flex; flex-wrap: wrap; gap: 12px; justify-content: center;">
                    @if(!empty($content['bouton_texte']))
                        <x-front.shared.btn-primary :href="$content['bouton_lien'] ?? '#'">
                            {{ $content['bouton_texte'] }}
                        </x-front.shared.btn-primary>
                    @endif
                    @if(!empty($content['bouton2_texte']))
                        <x-front.shared.btn-secondary :href="$content['bouton2_lien'] ?? '#'">
                            {{ $content['bouton2_texte'] }}
                        </x-front.shared.btn-secondary>
                    @endif
                </div>
            </div>
        </x-front.shared.reveal>
    </div>
</section>
