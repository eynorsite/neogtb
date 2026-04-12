@php $cols = $settings['colonnes'] ?? 3; @endphp

<section class="py-12 lg:py-24 bg-dark-50/50 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-pattern opacity-[0.02]"></div>
    <div class="relative z-10 mx-auto max-w-7xl px-5 lg:px-10">
        @if(!empty($content['eyebrow']) || !empty($content['titre_section']) || !empty($content['sous_titre']))
            <div class="mx-auto max-w-2xl text-center mb-12 animate-fade-in-up">
                @if(!empty($content['eyebrow']))
                    <p class="text-sm font-semibold uppercase tracking-wider text-accent-600">{{ $content['eyebrow'] }}</p>
                @endif
                @if(!empty($content['titre_section']))
                    <h2 class="font-display mt-2 text-3xl font-bold md:text-4xl text-dark-900">{{ $content['titre_section'] }}</h2>
                @endif
                @if(!empty($content['sous_titre']))
                    <p class="mt-4 text-dark-500">{{ $content['sous_titre'] }}</p>
                @endif
            </div>
        @endif

        <div class="grid grid-cols-1 gap-4 lg:gap-6 sm:grid-cols-2 lg:grid-cols-{{ $cols }}">
            @foreach($content['cartes'] ?? [] as $i => $carte)
                <a href="{{ $carte['lien'] ?? '#' }}"
                   class="group glass-card rounded-2xl p-6 block transition-all duration-300 hover:shadow-xl hover:shadow-accent-500/5 hover:border-accent-500/20 animate-fade-in-up"
                   style="animation-delay: {{ $i * 100 }}ms">

                    @if(!empty($carte['icone']))
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-accent-500/10 text-accent-600 text-2xl transition-all duration-300 group-hover:bg-accent-500 group-hover:text-white group-hover:shadow-lg group-hover:shadow-accent-500/30">{{ $carte['icone'] }}</div>
                    @endif

                    <h3 class="font-display font-semibold text-dark-900">{{ $carte['titre'] ?? '' }}</h3>

                    <p class="mt-2 text-sm leading-relaxed text-dark-500">{{ $carte['description'] ?? '' }}</p>

                    @if(!empty($carte['lien']))
                        <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-accent-600 group-hover:gap-3 transition-all duration-300">
                            En savoir plus
                            <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</section>
