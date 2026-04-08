@php $cols = $settings['colonnes'] ?? 3; @endphp

<section class="py-16 lg:py-28 relative overflow-hidden" style="background: linear-gradient(180deg, #f8fafc 0%, #fff 100%);">
    <div class="absolute inset-0 bg-dot-pattern opacity-[0.03]"></div>
    <div class="relative z-10 mx-auto max-w-7xl px-5 lg:px-10">
        @if(!empty($content['titre_section']))
            <div class="text-center mb-16 lg:mb-20 animate-fade-in-up">
                <h2 class="font-heading font-extrabold text-dark-900 text-[28px] lg:text-[48px] tracking-tight" style="letter-spacing: -0.03em;">{{ $content['titre_section'] }}</h2>
                <div class="mt-5 mx-auto h-[3px] w-12 rounded-full" style="background: linear-gradient(90deg, var(--color-accent-500), var(--color-primary-500));"></div>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-4 lg:gap-6 sm:grid-cols-2 lg:grid-cols-{{ $cols }}">
            @foreach($content['cartes'] ?? [] as $i => $carte)
                <a href="{{ $carte['lien'] ?? '#' }}"
                   class="group relative rounded-2xl bg-white p-6 lg:p-8 card-hover-glow block transition-all duration-400 animate-fade-in-up"
                   style="animation-delay: {{ $i * 120 }}ms; border: 1px solid rgba(226,232,240,0.8); box-shadow: 0 1px 3px rgba(0,0,0,0.04);">

                    @if(!empty($carte['icone']))
                        <div class="flex h-14 w-14 items-center justify-center rounded-xl text-2xl mb-5 transition-all duration-300 group-hover:scale-105 group-hover:shadow-lg" style="background: linear-gradient(135deg, var(--color-primary-50), var(--color-accent-50)); border: 1px solid rgba(45,139,78,0.08);">{{ $carte['icone'] }}</div>
                    @endif

                    <h3 class="text-[17px] font-heading font-bold text-dark-900 group-hover:text-accent-700 transition-colors duration-300">{{ $carte['titre'] ?? '' }}</h3>

                    <p class="mt-3 text-[14px] leading-relaxed text-dark-500" style="line-height: 1.65;">{{ $carte['description'] ?? '' }}</p>

                    @if(!empty($carte['lien']))
                        <span class="mt-6 inline-flex items-center gap-2 text-[13px] font-semibold text-accent-600 group-hover:gap-3 transition-all duration-300">
                            En savoir plus
                            <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</section>
