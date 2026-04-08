<section style="padding: 56px 0 64px;">
    <div class="max-w-[1280px] 2xl:max-w-[1440px] mx-auto px-5 lg:px-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-12 items-start">

            {{-- Photo + identité --}}
            <x-front.shared.reveal class="lg:col-span-4">
                <div class="card p-5 lg:p-7" style="text-align: center;">
                    @if(!empty($content['photo']))
                        <img src="{{ $content['photo'] }}"
                             alt="{{ $content['photo_alt'] ?? '' }}"
                             width="120" height="120" loading="lazy" decoding="async"
                             style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin: 0 auto 20px; display: block; border: 3px solid var(--color-accent-300);" />
                    @endif

                    @if(!empty($content['nom']))
                        <p style="font-size: 20px; font-weight: 500; color: var(--color-dark-900); margin-bottom: 4px;">{{ $content['nom'] }}</p>
                    @endif

                    @if(!empty($content['role']))
                        <p style="font-size: 14px; color: var(--color-accent-600); font-weight: 500; margin-bottom: 16px;">{{ $content['role'] }}</p>
                    @endif

                    @if(!empty($content['identite']))
                        <div class="sep" style="margin-bottom: 16px;"></div>
                        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px; text-align: left;">
                            @foreach($content['identite'] as $item)
                                <li class="flex items-center gap-3">
                                    <div style="width: 5px; height: 5px; border-radius: 50%; background: var(--color-accent-500); flex-shrink: 0;"></div>
                                    <span style="font-size: 13px; color: var(--color-dark-500);">{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </x-front.shared.reveal>

            {{-- Texte créateur + modèle économique --}}
            <x-front.shared.reveal :delay="1" class="lg:col-span-8">
                @if(!empty($content['eyebrow']))
                    <x-front.shared.eyebrow>{{ $content['eyebrow'] }}</x-front.shared.eyebrow>
                @endif

                @if(!empty($content['titre']))
                    <h2 style="font-size: clamp(28px, 3vw, 36px); font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.02em; line-height: 1.2; margin-bottom: 20px;">
                        {!! $content['titre'] !!}
                    </h2>
                @endif

                @if(!empty($content['texte']))
                    <p style="font-size: 16px; color: var(--color-dark-500); line-height: 1.7; margin-bottom: 20px;">{{ $content['texte'] }}</p>
                @endif

                @if(!empty($content['modele_economique']))
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
                        @foreach($content['modele_economique'] as $bloc)
                            <div style="padding: 16px; border-radius: 10px; border: 1px solid var(--color-dark-200);">
                                <p style="font-size: 14px; font-weight: 500; color: var(--color-dark-900); margin-bottom: 4px;">{{ $bloc['titre'] ?? '' }}</p>
                                <p style="font-size: 12px; color: var(--color-dark-500); line-height: 1.5;">{{ $bloc['description'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if(!empty($content['cta_texte']))
                    <a href="{{ $content['cta_lien'] ?? '#' }}"
                       style="font-size: 14px; font-weight: 500; color: var(--color-accent-600); text-decoration: none;">
                        {{ $content['cta_texte'] }}
                    </a>
                @endif
            </x-front.shared.reveal>
        </div>
    </div>
</section>
