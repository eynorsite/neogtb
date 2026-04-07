@php
    $titre = $content['titre'] ?? null;
    $html = $content['html'] ?? '';
@endphp
<section class="py-12">
    <div class="max-w-3xl mx-auto px-4">
        @if($titre)
            <h2 class="text-3xl font-bold mb-6">{{ $titre }}</h2>
        @endif
        <div class="prose prose-lg max-w-none">
            {!! $html !!}
        </div>
    </div>
</section>
