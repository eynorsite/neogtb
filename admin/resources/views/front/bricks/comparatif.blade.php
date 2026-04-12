<section class="py-12 lg:py-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-pattern opacity-[0.02]"></div>
    <div class="relative z-10 mx-auto max-w-7xl px-5 lg:px-10">
        @if(!empty($content['titre']))
            <div class="mx-auto max-w-2xl text-center mb-12 animate-fade-in-up">
                @if(!empty($content['eyebrow']))
                    <p class="text-sm font-semibold uppercase tracking-wider text-accent-600">{{ $content['eyebrow'] }}</p>
                @endif
                <h2 class="font-display mt-2 text-3xl font-bold md:text-4xl text-dark-900">
                    {!! preg_replace('/\b(NeoGTB)\b/', '<span class="text-gradient">$1</span>', e($content['titre'])) !!}
                </h2>
                @if(!empty($content['sous_titre']))
                    <p class="mt-4 text-dark-500 max-w-2xl mx-auto">{{ $content['sous_titre'] }}</p>
                @endif
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 lg:gap-10 max-w-5xl mx-auto">
            {{-- Colonne gauche --}}
            <div class="glass-card rounded-2xl p-5 lg:p-10 animate-fade-in-up" style="animation-delay: 100ms">
                <div class="flex items-center gap-3 mb-8">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-dark-100">
                        <svg class="h-5 w-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-dark-500">{{ $content['colonne_gauche_titre'] ?? 'Avant' }}</h3>
                </div>
                <ul class="space-y-5">
                    @foreach($content['lignes_gauche'] ?? [] as $ligne)
                        <li class="flex items-start gap-3">
                            <span class="mt-1 flex-shrink-0 flex h-5 w-5 items-center justify-center rounded-full bg-dark-100 text-dark-400 text-xs">&#10005;</span>
                            <span class="text-dark-600 text-sm leading-relaxed">{{ $ligne['texte'] ?? '' }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Colonne droite (mise en avant) --}}
            <div class="glass-card rounded-2xl p-5 lg:p-10 relative ring-2 ring-accent-500/30 shadow-lg shadow-accent-500/10 animate-fade-in-up" style="animation-delay: 200ms">
                <div class="absolute -top-3.5 left-8 bg-gradient-to-r from-accent-500 to-accent-600 text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-sm">Recommande</div>

                <div class="flex items-center gap-3 mb-8">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-accent-100">
                        <svg class="h-5 w-5 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-primary-700">{{ $content['colonne_droite_titre'] ?? 'Apres' }}</h3>
                </div>

                <ul class="space-y-5">
                    @foreach($content['lignes_droite'] ?? [] as $ligne)
                        <li class="flex items-start gap-3">
                            <span class="mt-1 flex-shrink-0 flex h-5 w-5 items-center justify-center rounded-full bg-accent-100 text-accent-600 text-xs">&#10003;</span>
                            <span class="text-dark-700 text-sm font-medium leading-relaxed">{{ $ligne['texte'] ?? '' }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
