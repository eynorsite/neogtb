@php
    $titre = $content['titre'] ?? '';
    $sousTitre = $content['sous_titre'] ?? null;
    $ctaLabel = $content['cta_label'] ?? null;
    $ctaUrl = $content['cta_url'] ?? '#';
@endphp
<section class="py-12 md:py-20 bg-gradient-to-b from-dark-50 to-white">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-dark-900 mb-6">{{ $titre }}</h1>
        @if($sousTitre)
            <p class="text-xl text-dark-600 mb-8">{{ $sousTitre }}</p>
        @endif
        @if($ctaLabel)
            <a href="{{ $ctaUrl }}" class="inline-block px-8 py-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                {{ $ctaLabel }}
            </a>
        @endif
    </div>
</section>
