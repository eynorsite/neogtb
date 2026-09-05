{{-- hero-image : variante full-bleed image avec overlay et stats (style accueil.blade.php) --}}
@php
    $img = $content['image'] ?? null;
    $imgUrl = $img ? (str_starts_with($img, '/') || str_starts_with($img, 'http') ? $img : asset('storage/' . $img)) : null;
@endphp

<section class="hero-img" data-hero style="position: relative; min-height: 460px; max-height: 72vh; display: flex; align-items: center; overflow: hidden; padding: 72px 0 40px;">
    @if($imgUrl)
        <img src="{{ $imgUrl }}"
             alt="{{ $content['image_alt'] ?? '' }}"
             width="1200" height="630" loading="eager" fetchpriority="high"
             style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: center;" />
    @endif
    <div style="position: absolute; inset: 0; background: linear-gradient(to left, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.45) 50%, rgba(0,0,0,0.1) 100%);"></div>

    <div class="max-w-[1280px] 2xl:max-w-[1440px] mx-auto px-5 lg:px-10 relative z-10" style="width: 100%;">
        <div style="max-width: 560px; margin-left: auto;">
            @if(!empty($content['badge']))
                <p style="display: inline-flex; align-items: center; gap: 8px; font-size: 11px; font-weight: 500; color: rgba(255,255,255,0.85); background: rgba(255,255,255,0.1); backdrop-filter: blur(8px); padding: 5px 14px; border-radius: 20px; border: 0.5px solid rgba(255,255,255,0.15); margin-bottom: 24px;">
                    {{ $content['badge'] }}
                </p>
            @endif

            @if(!empty($content['pre_titre']))
                <p style="font-size: 22px; font-weight: 500; color: rgba(255,255,255,0.7); letter-spacing: -0.02em; margin-bottom: 12px;">
                    {!! \Stevebauman\Purify\Facades\Purify::clean($content['pre_titre']) !!}
                </p>
            @endif

            @if(!empty($content['titre']))
                <h1 class="text-[32px] lg:text-[48px]" style="font-weight: 700; line-height: 1.08; letter-spacing: -0.03em; color: #fff; margin-bottom: 20px; text-shadow: 0 2px 20px rgba(0,0,0,0.40);">
                    {{ $content['titre'] }}
                </h1>
            @endif

            @if(!empty($content['description']))
                <p style="font-size: 16px; color: rgba(255,255,255,0.92); line-height: 1.65; max-width: 470px; margin-bottom: 32px; text-shadow: 0 1px 10px rgba(0,0,0,0.35);">
                    {{ $content['description'] }}
                </p>
            @endif

            @if(!empty($content['stats']))
                <div class="flex flex-wrap gap-6" style="margin-bottom: 32px;">
                    @foreach($content['stats'] as $stat)
                        <div style="min-width: 120px;">
                            <p style="font-size: 24px; font-weight: 700; color: #fff; letter-spacing: -0.02em; line-height: 1; text-shadow: 0 1px 10px rgba(0,0,0,0.35);">{{ $stat['valeur'] ?? '' }}</p>
                            <p style="font-size: 13px; color: rgba(255,255,255,0.78); margin-top: 4px; line-height: 1.4;">{{ $stat['label'] ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="flex flex-wrap items-center gap-4">
                @if(!empty($content['cta_texte']))
                    <x-front.shared.btn-primary :href="$content['cta_lien'] ?? '#'">
                        {{ $content['cta_texte'] }}
                    </x-front.shared.btn-primary>
                @endif
                @if(!empty($content['cta2_texte']))
                    <a href="{{ $content['cta2_lien'] ?? '#' }}"
                       style="font-size: 13px; font-weight: 500; color: rgba(255,255,255,0.85); text-decoration: none; transition: color 0.15s; border-bottom: 1px solid rgba(255,255,255,0.3);">
                        {{ $content['cta2_texte'] }} →
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
