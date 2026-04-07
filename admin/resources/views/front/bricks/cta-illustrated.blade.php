@php
    $bg = $settings['fond'] ?? '#F0F2F5';
    $img = $content['image_fond'] ?? null;
    $imgUrl = $img ? (str_starts_with($img, '/') || str_starts_with($img, 'http') ? $img : asset('storage/' . $img)) : null;
@endphp

<section class="relative overflow-hidden" style="padding: 56px 0 64px; background: {{ $bg }}; min-height: 420px; border-top: 1px solid var(--color-dark-200);">
    @if($imgUrl)
        <img src="{{ $imgUrl }}" alt="" width="1200" height="630" class="hero-bg-illustration" loading="lazy" />
        <div style="position: absolute; inset: 0; background: linear-gradient(to right, {{ $bg }} 30%, rgba(240,242,245,0.3) 70%); pointer-events: none;"></div>
    @endif

    <div class="max-w-[1200px] mx-auto px-6 md:px-10 relative z-10" style="display: flex; align-items: center; min-height: 230px;">
        <div style="max-width: 520px;">
            @if(!empty($content['titre']))
                <h2 style="font-size: clamp(28px, 3vw, 36px); font-weight: 500; color: var(--color-dark-900); letter-spacing: -0.02em; line-height: 1.2; margin-bottom: 16px;">
                    {{ $content['titre'] }}
                </h2>
            @endif

            @if(!empty($content['sous_titre']))
                <p style="font-size: 16px; color: var(--color-dark-500); line-height: 1.7; margin-bottom: 32px;">{{ $content['sous_titre'] }}</p>
            @endif

            @if(!empty($content['bouton_texte']))
                <x-front.shared.btn-primary :href="$content['bouton_lien'] ?? '#'">
                    {{ $content['bouton_texte'] }}
                </x-front.shared.btn-primary>
            @endif
        </div>
    </div>
</section>
