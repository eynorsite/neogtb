<section class="py-16 lg:py-28 relative overflow-hidden" style="background: linear-gradient(180deg, #fff 0%, #f8fafc 100%);">
    <div class="absolute inset-0 bg-dot-pattern opacity-[0.03]"></div>
    <div class="relative z-10 mx-auto max-w-7xl px-5 lg:px-10">
        @if(!empty($content['titre']))
            <div class="text-center mb-16 lg:mb-20 animate-fade-in-up">
                <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-accent-600 mb-3">Ils nous font confiance</p>
                <h2 class="text-[28px] lg:text-[48px] font-heading font-extrabold text-dark-900 tracking-tight" style="letter-spacing: -0.03em;">{{ $content['titre'] }}</h2>
                <div class="mt-5 mx-auto h-[3px] w-12 rounded-full" style="background: linear-gradient(90deg, var(--color-accent-500), var(--color-primary-500));"></div>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-5 lg:gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($content['avis'] ?? [] as $i => $avis)
                <div class="relative rounded-2xl bg-white p-6 lg:p-8 card-hover animate-fade-in-up"
                     style="animation-delay: {{ $i * 120 }}ms; border: 1px solid rgba(226,232,240,0.8); box-shadow: 0 1px 3px rgba(0,0,0,0.04);">

                    {{-- Guillemet decoratif --}}
                    <div class="absolute -top-5 left-8">
                        <div class="quote-mark">
                            <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151C7.546 6.068 5.983 8.789 5.983 11h4v10H0z"/></svg>
                        </div>
                    </div>

                    @if(!empty($avis['note']))
                        <div class="mb-4 flex gap-1 mt-2">
                            @for($j = 0; $j < 5; $j++)
                                <svg class="h-5 w-5 {{ $j < (int)$avis['note'] ? 'text-amber-400' : 'text-dark-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    @endif

                    <p class="text-[14px] leading-relaxed text-dark-600 mb-8" style="line-height: 1.7; font-style: italic;">"{{ $avis['texte'] ?? '' }}"</p>

                    <div class="flex items-center gap-3 pt-5" style="border-top: 1px solid rgba(226,232,240,0.6);">
                        {{-- Avatar initiales --}}
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl text-white text-[13px] font-bold" style="background: linear-gradient(135deg, var(--color-primary-500), var(--color-primary-800)); box-shadow: 0 2px 8px -2px rgba(27,58,92,0.25);">
                            {{ strtoupper(substr($avis['nom'] ?? 'A', 0, 1)) }}{{ strtoupper(substr(explode(' ', $avis['nom'] ?? '')[1] ?? '', 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-heading font-bold text-dark-900 text-[14px]">{{ $avis['nom'] ?? '' }}</div>
                            @if(!empty($avis['poste']))
                                <div class="text-[12px] text-dark-400">{{ $avis['poste'] }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
