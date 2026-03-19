<section class="py-16 lg:py-24" style="background-color: {{ $settings['couleur_fond'] ?? '#ffffff' }}">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @if(!empty($content['titre']))
            <h2 class="mb-8 text-3xl font-bold text-gray-900 sm:text-4xl">{{ $content['titre'] }}</h2>
        @endif

        @php $pos = $settings['position_image'] ?? 'none'; @endphp

        @if($pos !== 'none' && !empty($content['image']))
            <div class="flex flex-col gap-12 {{ $pos === 'right' ? 'lg:flex-row' : 'lg:flex-row-reverse' }}">
                <div class="flex-1 prose prose-lg max-w-none text-gray-600">
                    {!! $content['contenu'] ?? '' !!}
                </div>
                <div class="flex-1">
                    <img src="{{ asset('storage/' . $content['image']) }}" alt="" class="rounded-2xl shadow-lg">
                </div>
            </div>
        @else
            <div class="prose prose-lg mx-auto max-w-4xl text-gray-600">
                {!! $content['contenu'] ?? '' !!}
            </div>
        @endif
    </div>
</section>
