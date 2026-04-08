<section style="padding: 56px 0 64px; background: var(--color-dark-50); border-top: 1px solid var(--color-dark-200); border-bottom: 1px solid var(--color-dark-200);">
    <div class="max-w-[1280px] 2xl:max-w-[1440px] mx-auto px-6 md:px-10">
        <x-front.shared.section-header
            :eyebrow="$content['eyebrow'] ?? null"
            :title="$content['titre'] ?? ''"
            :intro="$content['sous_titre'] ?? null"
        />

        @php
            $methodIcons = [
                'search' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"/></svg>',
                'bars'   => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h4v12H3zM10 3h4v15h-4zM17 9h4v9h-4z" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                'check'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                'bolt'   => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            ];
        @endphp
        <div class="method-flow reveal" x-data x-intersect.once="$el.classList.add('visible')"
             style="background: white; border-radius: 12px; border: 1px solid var(--color-dark-200); overflow: hidden; display: flex; position: relative;">
            <div class="method-flow-connector" style="position: absolute; top: 44px; left: 12.5%; right: 12.5%;"></div>
            @foreach($content['etapes'] ?? [] as $i => $etape)
                @php $isActive = ($etape['active'] ?? false); @endphp
                <div class="method-flow-step {{ $isActive ? 'active-step' : '' }}"
                     style="flex: 1; padding: 28px 16px; {{ !$loop->last ? 'border-right: 1px solid var(--color-dark-200);' : '' }} {{ $isActive ? 'background: var(--color-accent-50);' : '' }}">
                    <div class="method-flow-node">
                        @if(!empty($etape['icone']) && isset($methodIcons[$etape['icone']]))
                            {!! $methodIcons[$etape['icone']] !!}
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
