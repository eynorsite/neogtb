<section style="padding: 64px 0; border-top: 1px solid var(--color-dark-200); border-bottom: 1px solid var(--color-dark-200);">
    <div class="max-w-[900px] mx-auto px-6 md:px-10">
        <x-front.shared.reveal class="text-center mb-8">
            @if(!empty($content['eyebrow']))
                <x-front.shared.eyebrow :color="$content['eyebrow_color'] ?? 'accent'">{{ $content['eyebrow'] }}</x-front.shared.eyebrow>
            @endif
            @if(!empty($content['titre']))
                <h2 style="font-size: clamp(22px, 2.5vw, 28px); font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.02em; line-height: 1.2;">
                    {{ $content['titre'] }}
                </h2>
            @endif
        </x-front.shared.reveal>

        <div class="timeline-regl reveal" x-data x-intersect.once="$el.classList.add('visible')">
            @foreach($content['points'] ?? [] as $point)
                @php
                    $etat = $point['etat'] ?? 'futur';
                    $pointClass = match($etat) {
                        'past' => 'past active',
                        'present' => 'active',
                        default => 'future',
                    };
                    $dotClass = match($etat) {
                        'past' => 'past',
                        'present' => 'current',
                        default => 'future',
                    };
                @endphp
                <div class="timeline-regl-point {{ $pointClass }}">
                    <p class="timeline-regl-year">{{ $point['annee'] ?? '' }}</p>
                    <div class="timeline-regl-dot {{ $dotClass }}"></div>
                    <p class="timeline-regl-label">
                        {{ $point['label'] ?? '' }}
                        @if(!empty($point['detail']))<br/><strong>{{ $point['detail'] }}</strong>@endif
                    </p>
                </div>
            @endforeach
        </div>

        @if(!empty($content['legende']))
            <p style="text-align: center; font-size: 13px; color: var(--color-dark-400); margin-top: 24px;">
                @foreach($content['legende'] as $i => $leg)
                    @php $col = ($leg['couleur'] ?? 'accent') === 'energy' ? 'accent' : ($leg['couleur'] ?? 'accent'); @endphp
                    <span style="{{ $i > 0 ? 'margin-left: 16px;' : '' }} display: inline-flex; align-items: center; gap: 6px;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: var(--color-{{ $col }}-500);"></span>
                        {{ $leg['texte'] }}
                    </span>
                @endforeach
            </p>
        @endif
    </div>
</section>
