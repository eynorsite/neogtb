{{-- cartes-articles : blog récent style Lovable --}}
<section class="py-12 lg:py-24">
    <div class="max-w-[1280px] 2xl:max-w-[1440px] mx-auto px-5 lg:px-10">
        <div class="flex items-end justify-between mb-10 animate-fade-in-up">
            <div>
                @if(!empty($content['eyebrow']))
                    <p class="text-sm font-semibold uppercase tracking-wider text-accent-600">{{ $content['eyebrow'] }}</p>
                @endif
                @if(!empty($content['titre_section']))
                    <h2 class="font-display mt-2 text-3xl font-bold md:text-4xl text-dark-900">{{ $content['titre_section'] }}</h2>
                @endif
            </div>
            @if(!empty($content['cta_haut_texte']))
                <a href="{{ $content['cta_haut_lien'] ?? '#' }}" class="hidden md:inline-flex items-center gap-2 text-sm text-dark-500 hover:text-accent-600 transition-colors">
                    {{ $content['cta_haut_texte'] }}
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            @endif
        </div>

        <div class="grid md:grid-cols-{{ $settings['colonnes'] ?? 3 }} gap-6">
            @foreach($content['cartes'] ?? [] as $i => $carte)
                <a href="{{ $carte['lien'] ?? '#' }}" class="group glass-card overflow-hidden rounded-2xl transition-all duration-300 hover:shadow-xl hover:shadow-accent-500/5 block animate-fade-in-up" style="animation-delay: {{ $i * 100 }}ms">
                    <div class="aspect-video bg-gradient-to-br from-accent-500/10 to-accent-500/5"></div>
                    <div class="p-5">
                        @if(!empty($carte['tag']))
                            <span class="inline-flex mb-3 text-xs font-semibold uppercase tracking-wide rounded-full px-3 py-1 bg-accent-500/10 text-accent-600 border-0">{{ $carte['tag'] }}</span>
                        @endif
                        @if(!empty($carte['titre']))
                            <h3 class="font-display font-semibold leading-snug text-dark-900 group-hover:text-accent-600 transition-colors">{{ $carte['titre'] }}</h3>
                        @endif
                        @if(!empty($carte['excerpt']))
                            <p class="mt-2 text-sm text-dark-500 line-clamp-2">{{ $carte['excerpt'] }}</p>
                        @endif
                        <div class="mt-4 flex items-center gap-4 text-xs text-dark-400">
                            @if(!empty($carte['date']))
                                <span class="flex items-center gap-1">
                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2"/><line x1="16" y1="2" x2="16" y2="6" stroke-width="2"/><line x1="8" y1="2" x2="8" y2="6" stroke-width="2"/><line x1="3" y1="10" x2="21" y2="10" stroke-width="2"/></svg>
                                    {{ $carte['date'] }}
                                </span>
                            @endif
                            @if(!empty($carte['duree']))
                                <span class="flex items-center gap-1">
                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="2"/><polyline points="12 6 12 12 16 14" stroke-width="2"/></svg>
                                    {{ $carte['duree'] }}
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        @if(!empty($content['cta_haut_texte']))
            <div class="mt-8 text-center md:hidden">
                <a href="{{ $content['cta_haut_lien'] ?? '#' }}" class="inline-flex items-center gap-2 rounded-lg border border-dark-200 px-6 py-2.5 text-sm font-semibold text-dark-700 hover:border-accent-500/30 transition-colors">
                    {{ $content['cta_haut_texte'] }}
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        @endif
    </div>
</section>
