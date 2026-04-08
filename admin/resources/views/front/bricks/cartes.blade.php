@php $cols = $settings['colonnes'] ?? 3; @endphp

<section class="py-14 md:py-24 bg-dark-50/50 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-pattern opacity-[0.02]"></div>
    <div class="relative z-10 mx-auto max-w-7xl px-6 md:px-10">
        @if(!empty($content['titre_section']))
            <div class="text-center mb-16 animate-fade-in-up">
                <h2 class="text-3xl font-heading font-extrabold text-dark-900 sm:text-4xl lg:text-5xl">{{ $content['titre_section'] }}</h2>
                <div class="mt-4 mx-auto h-1 w-16 rounded-full bg-gradient-to-r from-primary-500 to-accent-500"></div>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-{{ $cols }}">
            @foreach($content['cartes'] ?? [] as $i => $carte)
                <a href="{{ $carte['lien'] ?? '#' }}"
                   class="group relative rounded-2xl border border-dark-100 bg-white p-8 shadow-sm card-hover-glow block transition-all duration-300 animate-fade-in-up"
                   style="animation-delay: {{ $i * 100 }}ms">

                    {{-- Accent bar top --}}
                    <div class="absolute top-0 left-8 right-8 h-0.5 bg-gradient-to-r from-primary-500 to-accent-500 rounded-b opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    @if(!empty($carte['icone']))
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-50 to-primary-100 text-3xl mb-6 group-hover:scale-110 transition-transform duration-300">{{ $carte['icone'] }}</div>
                    @endif

                    <h3 class="text-lg font-heading font-bold text-dark-900 group-hover:text-primary-600 transition-colors duration-300">{{ $carte['titre'] ?? '' }}</h3>

                    <p class="mt-3 text-sm leading-relaxed text-dark-500">{{ $carte['description'] ?? '' }}</p>

                    @if(!empty($carte['lien']))
                        <span class="mt-6 inline-flex items-center gap-1.5 text-sm font-semibold text-primary-600 group-hover:gap-3 transition-all duration-300">
                            En savoir plus
                            <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</section>
