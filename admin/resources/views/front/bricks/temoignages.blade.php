<section class="py-12 lg:py-24 bg-dark-50/50 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-pattern opacity-[0.02]"></div>
    <div class="relative z-10 mx-auto max-w-7xl px-5 lg:px-10">
        @if(!empty($content['eyebrow']) || !empty($content['titre']))
            <div class="mx-auto max-w-2xl text-center mb-12 animate-fade-in-up">
                @if(!empty($content['eyebrow']))
                    <p class="text-sm font-semibold uppercase tracking-wider text-accent-600">{{ $content['eyebrow'] }}</p>
                @endif
                @if(!empty($content['titre']))
                    <h2 class="font-display mt-2 text-3xl font-bold md:text-4xl text-dark-900">{{ $content['titre'] }}</h2>
                @endif
            </div>
        @endif

        <div class="grid grid-cols-1 gap-5 lg:gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach($content['avis'] ?? [] as $i => $avis)
                <div class="glass-card rounded-2xl p-6 lg:p-8 animate-fade-in-up"
                     style="animation-delay: {{ $i * 100 }}ms">

                    {{-- Guillemet decoratif --}}
                    <svg class="mb-4 h-8 w-8 text-accent-500/30" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151C7.546 6.068 5.983 8.789 5.983 11h4v10H0z"/></svg>

                    @if(!empty($avis['note']))
                        <div class="mb-4 flex gap-1 mt-2">
                            @for($j = 0; $j < 5; $j++)
                                <svg class="h-5 w-5 {{ $j < (int)$avis['note'] ? 'text-amber-400' : 'text-dark-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    @endif

                    <blockquote class="text-base leading-relaxed text-dark-700/80 mb-6">"{{ $avis['texte'] ?? '' }}"</blockquote>

                    <div class="flex items-center gap-3 mt-6">
                        {{-- Avatar initiales --}}
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-primary-500 to-primary-700 text-white text-sm font-bold shadow-sm">
                            {{ strtoupper(substr($avis['nom'] ?? 'A', 0, 1)) }}{{ strtoupper(substr(explode(' ', $avis['nom'] ?? '')[1] ?? '', 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-heading font-bold text-dark-900 text-sm">{{ $avis['nom'] ?? '' }}</div>
                            @if(!empty($avis['poste']))
                                <div class="text-xs text-dark-400">{{ $avis['poste'] }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
