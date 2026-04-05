<section class="py-20" style="background-color: {{ $settings['couleur_fond'] ?? '#F8FAFC' }}">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @if(!empty($content['titre']))
            <div class="text-center mb-12">
                <h2 class="text-3xl font-heading font-extrabold text-dark-900 sm:text-4xl">{{ $content['titre'] }}</h2>
                @if(!empty($content['sous_titre']))
                    <p class="mt-4 text-lg text-dark-500 max-w-2xl mx-auto">{{ $content['sous_titre'] }}</p>
                @endif
            </div>
        @endif

        <div class="grid grid-cols-2 gap-8 sm:grid-cols-3 lg:grid-cols-{{ min(count($content['stats'] ?? []), 4) }}">
            @foreach($content['stats'] ?? [] as $stat)
                <div class="text-center p-6 rounded-2xl bg-white shadow-sm border border-dark-100 card-hover">
                    @if(!empty($stat['icone']))
                        <span class="text-3xl">{{ $stat['icone'] }}</span>
                    @endif
                    <div class="mt-3 text-4xl font-heading font-extrabold text-primary-600">
                        {{ $stat['valeur'] ?? '' }}{{ $stat['suffixe'] ?? '' }}
                    </div>
                    <div class="mt-2 text-sm font-medium text-dark-500">{{ $stat['label'] ?? '' }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
