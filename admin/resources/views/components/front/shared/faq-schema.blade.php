@props([
    // Liste de questions/réponses. Chaque item accepte :
    //   'question' (obligatoire) + l'une des clés réponse : 'reponse' | 'answer' | 'text'
    // La MÊME donnée alimente l'affichage ET ce schema → source unique, aucune divergence.
    'items' => [],
])

@php
    // Normalisation + filtrage des paires incomplètes (Google exige name + réponse non vides).
    // Pas de strip_tags : le domaine manipule des « < 70 kW » / « > 290 kW » qu'un strip_tags
    // tronquerait. La sécurité anti-« </script> » est assurée par JSON_HEX_TAG ci-dessous.
    $faqEntities = collect($items)
        ->map(fn ($q) => [
            'question' => trim((string) ($q['question'] ?? '')),
            'answer' => trim((string) ($q['reponse'] ?? $q['answer'] ?? $q['text'] ?? '')),
        ])
        ->filter(fn ($q) => $q['question'] !== '' && $q['answer'] !== '')
        ->map(fn ($q) => [
            '@type' => 'Question',
            'name' => $q['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $q['answer'],
            ],
        ])
        ->values()
        ->all();

    // Encodage effectué ici (dans @php) : les clés « @context »/« @type » ne sont donc pas
    // exposées au compilateur Blade, qui sinon les prendrait pour les directives @context/@type.
    // JSON_HEX_TAG neutralise tout « </script> », JSON_UNESCAPED_UNICODE garde les accents lisibles.
    $faqJsonLd = empty($faqEntities) ? null : json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $faqEntities,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP);
@endphp

{{-- Émis EN LIGNE (dans le <body>, là où le brick se rend). Le JSON-LD est valide partout dans
     le document (doc officielle Google/Schema.org) : inutile — et impossible ici — de viser le
     <head>, car un @push depuis un brick rendu dans @section arrive après le @stack du head. --}}
@if ($faqJsonLd)
<script type="application/ld+json" @cspNonce>{!! $faqJsonLd !!}</script>
@endif
