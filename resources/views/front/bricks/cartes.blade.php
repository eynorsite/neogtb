@php $cols = $settings['colonnes'] ?? 3; @endphp

<section class="py-20 bg-dark-50 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-pattern opacity-[0.03]"></div>
    <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @if(!empty($content['titre_section']))
            <div class="text-center mb-12 section-divider pt-6">
                <h2 class="text-3xl font-heading font-extrabold text-dark-900 sm:text-4xl">{{ $content['titre_section'] }}</h2>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-{{ $cols }}">
            @foreach($content['cartes'] ?? [] as $carte)
                <a href="{{ $carte['lien'] ?? '#' }}" class="group rounded-2xl border border-dark-200 bg-white p-6 shadow-sm card-hover-glow block">
                    @if(!empty($carte['icone']))
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-50 text-2xl mb-4">{{ $carte['icone'] }}</div>
                    @endif
                    <h3 class="text-lg font-heading font-bold text-dark-900 group-hover:text-primary-600 transition-colors">{{ $carte['titre'] ?? '' }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-dark-500">{{ $carte['description'] ?? '' }}</p>
                    @if(!empty($carte['lien']))
                        <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-primary-600 group-hover:gap-2 transition-all">
                            En savoir plus
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</section>
