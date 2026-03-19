<section class="py-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-pattern opacity-[0.03]"></div>
    <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @if(!empty($content['titre']))
            <div class="text-center mb-16">
                <h2 class="text-3xl font-heading font-extrabold text-dark-900 sm:text-4xl">
                    {!! preg_replace('/\b(NeoGTB)\b/', '<span class="text-gradient">$1</span>', e($content['titre'])) !!}
                </h2>
                @if(!empty($content['sous_titre']))
                    <p class="mt-4 text-lg text-dark-500 max-w-2xl mx-auto">{{ $content['sous_titre'] }}</p>
                @endif
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            {{-- Colonne gauche --}}
            <div class="rounded-2xl border border-dark-200 bg-white p-8 shadow-sm">
                <h3 class="text-lg font-heading font-bold text-dark-500 mb-6">{{ $content['colonne_gauche_titre'] ?? 'Avant' }}</h3>
                <ul class="space-y-4">
                    @foreach($content['lignes_gauche'] ?? [] as $ligne)
                        <li class="flex items-start gap-3">
                            <span class="mt-0.5 flex-shrink-0 text-dark-400">✕</span>
                            <span class="text-dark-600 text-sm">{{ $ligne['texte'] ?? '' }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Colonne droite (mise en avant) --}}
            <div class="rounded-2xl border-2 border-primary-200 bg-primary-50/50 p-8 shadow-md relative">
                <div class="absolute -top-3 left-6 bg-accent-500 text-dark-900 text-xs font-bold px-3 py-1 rounded-full">Recommandé</div>
                <h3 class="text-lg font-heading font-bold text-primary-700 mb-6">{{ $content['colonne_droite_titre'] ?? 'Après' }}</h3>
                <ul class="space-y-4">
                    @foreach($content['lignes_droite'] ?? [] as $ligne)
                        <li class="flex items-start gap-3">
                            <span class="mt-0.5 flex-shrink-0 text-accent-500">✓</span>
                            <span class="text-dark-700 text-sm font-medium">{{ $ligne['texte'] ?? '' }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
