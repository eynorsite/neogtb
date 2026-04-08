{{-- cartes-articles : 3 cards d'articles blog (Insights) --}}
@php $fondClass = ($settings['fond'] ?? '') === 'dark-50' ? 'background: var(--color-dark-50); border-top: 1px solid var(--color-dark-200); border-bottom: 1px solid var(--color-dark-200);' : ''; @endphp

<section style="padding: 56px 0 64px; {{ $fondClass }}">
    <div class="max-w-[1280px] 2xl:max-w-[1440px] mx-auto px-6 md:px-10">
        <div class="flex items-end justify-between mb-12 reveal" x-data x-intersect.once="$el.classList.add('visible')">
            <div>
                @if(!empty($content['eyebrow']))
                    <x-front.shared.eyebrow>{{ $content['eyebrow'] }}</x-front.shared.eyebrow>
                @endif
                @if(!empty($content['titre_section']))
                    <h2 style="font-size: clamp(28px, 3vw, 36px); font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.02em; line-height: 1.2;">
                        {{ $content['titre_section'] }}
                    </h2>
                @endif
            </div>
            @if(!empty($content['cta_haut_texte']))
                <a href="{{ $content['cta_haut_lien'] ?? '#' }}" class="hidden md:inline-flex btn-ghost">{{ $content['cta_haut_texte'] }}</a>
            @endif
        </div>

        <div class="grid md:grid-cols-{{ $settings['colonnes'] ?? 3 }} gap-6">
            @foreach($content['cartes'] ?? [] as $i => $carte)
                <x-front.shared.card :href="$carte['lien'] ?? '#'" padding="p-6" :delay="$i % 3">
                    @if(!empty($carte['tag']))
                        <x-front.shared.tag :variant="$carte['tag_variant'] ?? 'gtb'">{{ $carte['tag'] }}</x-front.shared.tag>
                    @endif
                    @if(!empty($carte['titre']))
                        <h3 style="font-size: 16px; font-weight: 500; color: var(--color-dark-900); line-height: 1.4; margin-top: 16px;">
                            {{ $carte['titre'] }}
                        </h3>
                    @endif
                    @if(!empty($carte['duree']))
                        <p style="font-size: 13px; color: var(--color-dark-400); margin-top: 12px;">{{ $carte['duree'] }}</p>
                    @endif
                </x-front.shared.card>
            @endforeach
        </div>

        @if(!empty($content['cta_haut_texte']))
            <a href="{{ $content['cta_haut_lien'] ?? '#' }}" class="md:hidden btn-ghost mt-8">{{ $content['cta_haut_texte'] }}</a>
        @endif
    </div>
</section>
