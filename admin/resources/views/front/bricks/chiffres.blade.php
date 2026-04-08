{{-- chiffres : impact bar minimal (style accueil) --}}
<section style="padding: 20px 0; border-bottom: 1px solid var(--color-dark-200);">
    <div class="max-w-[1280px] 2xl:max-w-[1440px] mx-auto px-5 lg:px-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8 text-center">
            @foreach($content['stats'] ?? [] as $stat)
                <div style="padding: 8px 0;">
                    <p style="font-size: 20px; font-weight: 600; color: var(--color-accent-600); letter-spacing: -0.02em;">{{ $stat['valeur'] ?? '' }}</p>
                    <p style="font-size: 12px; color: var(--color-dark-400); line-height: 1.4; margin-top: 2px;">{{ $stat['label'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
