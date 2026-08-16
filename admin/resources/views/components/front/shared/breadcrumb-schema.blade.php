@props([
    // Nom de la page courante (dernier maillon du fil).
    'current' => '',
    // URL canonique de la page courante.
    'url' => '',
    // Maillon intermédiaire optionnel : ['name' => 'Perspectives', 'url' => '…'].
    // Absent → fil à 2 niveaux (Accueil > page), comme avant.
    'parent' => null,
])

@php
    // Un fil d'Ariane plat (Accueil > page) sur /blog/…, /guide/… et /comparatif/…
    // prive Google et les moteurs de réponse de la hiérarchie réelle du site.
    // Ce composant reconstruit le chemin complet quand la vue fournit un parent.
    // Sur l'accueil, le fil se réduisait à « Accueil > Accueil - Gestion Technique… » :
    // un fil d'Ariane n'a pas de sens sur la racine, on n'émet alors aucun schema.
    $isHome = rtrim($url ?: url()->current(), '/') === rtrim(url('/'), '/');

    $crumbs = [['name' => 'Accueil', 'item' => url('/')]];

    if (filled($parent['name'] ?? null)) {
        $crumbs[] = ['name' => $parent['name'], 'item' => $parent['url'] ?? url('/')];
    }

    // Le fil reprenait le <title> SEO tel quel, suffixe de marque compris
    // (« Qu'est-ce que la GTB ? … | NeoGTB »). Un maillon de fil d'Ariane doit porter
    // le nom court de la page : on retire le suffixe « | NeoGTB » / « - NeoGTB ».
    $currentName = preg_replace('/\s*[|\-–]\s*N[ée]oGTB\s*$/ui', '', (string) $current);

    if (filled($currentName)) {
        $crumbs[] = ['name' => $currentName, 'item' => $url ?: url()->current()];
    }

    // Encodage dans @php (et non en Blade) : les clés « @context »/« @type » ne sont
    // ainsi jamais lues comme les directives @context/@type par le compilateur.
    // JSON_HEX_TAG neutralise tout « </script> » injecté via un titre de page.
    $breadcrumbJsonLd = json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => array_map(fn ($c, $i) => [
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => $c['name'],
            'item' => $c['item'],
        ], $crumbs, array_keys($crumbs)),
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP);
@endphp

@unless ($isHome)
<script type="application/ld+json" @cspNonce>{!! $breadcrumbJsonLd !!}</script>
@endunless
