<section class="py-16 lg:py-24 section-alt">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @if(!empty($content['titre']))
            <h2 class="mb-12 text-center text-3xl font-bold text-gray-900 sm:text-4xl">{{ $content['titre'] }}</h2>
        @endif

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($content['avis'] ?? [] as $avis)
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    @if(!empty($avis['note']))
                        <div class="mb-3 flex gap-0.5 text-yellow-400">
                            @for($i = 0; $i < (int)$avis['note']; $i++) ★ @endfor
                        </div>
                    @endif
                    <p class="text-sm leading-relaxed text-gray-600 italic">"{{ $avis['texte'] ?? '' }}"</p>
                    <div class="mt-4 border-t pt-3">
                        <div class="font-semibold text-gray-900">{{ $avis['nom'] ?? '' }}</div>
                        @if(!empty($avis['poste']))
                            <div class="text-xs text-gray-500">{{ $avis['poste'] }}</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
