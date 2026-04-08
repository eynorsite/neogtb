{{-- chiffres : premium impact bar --}}
<section class="relative" style="background: #fff; border-bottom: 1px solid rgba(226,232,240,0.6);">
    <div class="max-w-[1280px] 2xl:max-w-[1440px] mx-auto px-5 lg:px-10">
        <div class="grid grid-cols-2 md:grid-cols-4">
            @foreach($content['stats'] ?? [] as $i => $stat)
                <div class="stat-premium animate-fade-in-up" style="animation-delay: {{ $i * 100 }}ms;">
                    <p class="font-heading font-extrabold tracking-tight" style="font-size: 28px; color: var(--color-accent-600); letter-spacing: -0.03em; line-height: 1;">{{ $stat['valeur'] ?? '' }}</p>
                    <p style="font-size: 12px; color: var(--color-dark-400); line-height: 1.5; margin-top: 6px; font-weight: 500;">{{ $stat['label'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
