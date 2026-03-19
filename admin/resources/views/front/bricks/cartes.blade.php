@php $cols = $settings['colonnes'] ?? 3; @endphp

<section class="py-16 lg:py-24 section-alt">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @if(!empty($content['titre_section']))
            <h2 class="mb-12 text-center text-3xl font-bold text-gray-900 sm:text-4xl">{{ $content['titre_section'] }}</h2>
        @endif

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-{{ $cols }}">
            @foreach($content['cartes'] ?? [] as $carte)
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition hover:shadow-md">
                    @if(!empty($carte['icone']))
                        <span class="text-3xl">{{ $carte['icone'] }}</span>
                    @endif
                    <h3 class="mt-4 text-lg font-bold text-gray-900">{{ $carte['titre'] ?? '' }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-gray-600">{{ $carte['description'] ?? '' }}</p>
                    @if(!empty($carte['lien']))
                        <a href="{{ $carte['lien'] }}" class="mt-4 inline-flex items-center text-sm font-semibold text-primary-600 hover:text-primary-700">
                            En savoir plus →
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
