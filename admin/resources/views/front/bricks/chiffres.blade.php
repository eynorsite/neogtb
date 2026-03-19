<section class="py-16 lg:py-20" style="background-color: {{ $settings['couleur_fond'] ?? '#F8FAFC' }}">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 gap-8 sm:grid-cols-3 lg:grid-cols-{{ count($content['stats'] ?? []) > 4 ? 6 : count($content['stats'] ?? []) }}">
            @foreach($content['stats'] ?? [] as $stat)
                <div class="text-center">
                    @if(!empty($stat['icone']))
                        <span class="text-3xl">{{ $stat['icone'] }}</span>
                    @endif
                    <div class="mt-2 text-4xl font-black text-primary-600">
                        {{ $stat['valeur'] ?? '' }}{{ $stat['suffixe'] ?? '' }}
                    </div>
                    <div class="mt-1 text-sm font-medium text-gray-600">{{ $stat['label'] ?? '' }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
