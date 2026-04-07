<section style="padding: 56px 0 64px; background: var(--color-dark-50); border-top: 1px solid var(--color-dark-200); border-bottom: 1px solid var(--color-dark-200);">
    <div class="max-w-[1200px] mx-auto px-6 md:px-10">
        <x-front.shared.section-header
            :eyebrow="$content['eyebrow'] ?? null"
            :title="$content['titre'] ?? ''"
            :intro="$content['sous_titre'] ?? null"
        />

        <div class="method-flow reveal" x-data x-intersect.once="$el.classList.add('visible')"
             style="background: white; border-radius: 12px; border: 1px solid var(--color-dark-200); overflow: hidden; display: flex;">
            @foreach($content['etapes'] ?? [] as $i => $etape)
                @php $isActive = ($etape['active'] ?? false); @endphp
                <div class="method-flow-step {{ $isActive ? 'active-step' : '' }}"
                     style="flex: 1; padding: 28px 16px; {{ !$loop->last ? 'border-right: 1px solid var(--color-dark-200);' : '' }} {{ $isActive ? 'background: var(--color-accent-50);' : '' }}">
                    <div class="method-flow-node">
                        @if(!empty($etape['icone']))
                            <span style="font-size: 16px;">{{ $etape['icone'] === 'search' ? '🔍' : ($etape['icone'] === 'bars' ? '📊' : ($etape['icone'] === 'check' ? '✓' : ($etape['icone'] === 'bolt' ? '⚡' : $etape['numero'] ?? ($i + 1)))) }}</span>
                        @else
                            {{ $etape['numero'] ?? ($i + 1) }}
                        @endif
                    </div>
                    <h3 style="font-size: 14px; font-weight: 500; color: var(--color-dark-900); margin-bottom: 6px;">{{ $etape['titre'] ?? '' }}</h3>
                    <p style="font-size: 12px; color: var(--color-dark-500); line-height: 1.5;">{{ $etape['description'] ?? '' }}</p>
                </div>
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
