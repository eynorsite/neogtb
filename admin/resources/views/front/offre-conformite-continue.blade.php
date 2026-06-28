@extends('front.layouts.app')

@section('content')

<!-- HERO — LIGHT MODE custom (titre sombre, fond clair, orbs décoratifs ; aligné sur /offres) -->
<section class="relative overflow-hidden bg-white border-b border-dark-100">
    <div aria-hidden="true" class="glow-halo glow-halo--accent -top-24 -left-16 h-72 w-72"></div>
    <div aria-hidden="true" class="glow-halo glow-halo--primary top-10 right-0 h-80 w-80"></div>
    <div aria-hidden="true" class="orb orb--filled orb--slow top-24 right-24 h-24 w-24" style="--halo-color: rgba(45, 139, 78, 0.12);"></div>
    <div aria-hidden="true" class="orb orb--outline orb--reverse orb--delay bottom-16 left-1/3 h-16 w-16"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-5 lg:px-10 py-16 lg:py-24">
        <div class="max-w-3xl animate-fade-in-up">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Offre conformité tertiaire</p>
            <h1 class="text-[30px] lg:text-[44px] font-medium text-dark-900 tracking-tight leading-[1.1] mb-5">
                Conformité décret <span class="text-accent-600">BACS</span>, suivie dans la durée
            </h1>
            <p class="text-base lg:text-lg text-dark-500 leading-relaxed mb-8">
                Audit de conformité, mise en place du suivi énergétique et accompagnement OPERAT chaque année.
                Un seul interlocuteur, indépendant, pour vos obligations BACS et décret tertiaire — sans rien
                vous vendre d'autre que du conseil.
            </p>
            <div class="flex flex-wrap gap-4">
                <x-front.shared.btn-primary href="/contact">Parler à un expert</x-front.shared.btn-primary>
                <a href="/audit" class="inline-flex items-center gap-1.5 px-6 py-3 text-sm font-medium text-dark-600 border border-dark-300 rounded-lg hover:bg-dark-50 transition-colors">
                    Pré-diagnostic gratuit
                </a>
            </div>
        </div>
        @include('front.partials.reassurance-badges', ['class' => 'mt-10 justify-start'])
    </div>
</section>

<!-- PROBLÈME / RÉGLEMENTATION -->
<section class="py-10 lg:py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-2xl mb-10">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Pourquoi maintenant</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Deux décrets, une seule réalité : votre bâtiment doit prouver qu'il consomme moins</h2>
            <p class="text-base text-dark-500 leading-relaxed">La réglementation tertiaire ne se contente plus de recommander. Elle impose, mesure et contrôle.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-4 lg:gap-6">
            <div class="bg-white rounded-2xl p-5 lg:p-7 border border-dark-100 lg:shadow-sm">
                <span class="inline-block text-[13px] font-medium text-white bg-accent-600 px-3 py-1 rounded-md mb-4">Décret BACS</span>
                <p class="text-[15px] text-dark-500 leading-relaxed mb-4">Impose une GTB de <strong class="text-dark-900 font-medium">classe A ou B</strong> (NF EN ISO 52120-1:2022), capable de suivre, analyser et alerter en continu — et de faire l'objet d'inspections périodiques.</p>
                <ul class="text-[14px] text-dark-600 leading-relaxed space-y-2">
                    <li><strong class="text-dark-900">&gt; 290 kW</strong> : conforme depuis le 1er janvier 2025</li>
                    <li><strong class="text-dark-900">70 à 290 kW</strong> : échéance reportée au 1er janvier 2030</li>
                </ul>
            </div>
            <div class="bg-white rounded-2xl p-5 lg:p-7 border border-dark-100 lg:shadow-sm">
                <span class="inline-block text-[13px] font-medium text-white bg-dark-600 px-3 py-1 rounded-md mb-4">Décret tertiaire</span>
                <p class="text-[15px] text-dark-500 leading-relaxed mb-4">Pour les bâtiments de <strong class="text-dark-900 font-medium">plus de 1 000 m²</strong> : réduction de consommation et <strong class="text-dark-900 font-medium">déclaration annuelle sur OPERAT</strong> (ADEME).</p>
                <ul class="text-[14px] text-dark-600 leading-relaxed space-y-2">
                    <li><strong class="text-dark-900">-40 %</strong> en 2030 · <strong class="text-dark-900">-50 %</strong> en 2040 · <strong class="text-dark-900">-60 %</strong> en 2050</li>
                </ul>
            </div>
        </div>
        <div class="bg-accent-50 border border-accent-200 rounded-2xl p-5 lg:p-6 mt-4">
            <p class="text-sm text-dark-600 leading-relaxed"><strong class="text-dark-900">Le point commun ? La GTB.</strong> C'est elle qui produit les données du suivi BACS et celles que vous déclarez sur OPERAT. La traiter à moitié, c'est s'exposer deux fois.</p>
        </div>
        @include('front.bricks.cta-mini.cta-inline-mini-card', ['href' => '/audit', 'eyebrow' => 'Auto-évaluation', 'text' => 'Savoir si votre bâtiment est concerné, 3 minutes, sans inscription.', 'linkText' => 'Pré-diagnostic gratuit'])
    </div>
</section>

<!-- L'OFFRE : 3 TEMPS -->
<section class="py-10 lg:py-20">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-2xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Notre réponse</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Une offre qui couvre tout le cycle : auditer, équiper, déclarer</h2>
            <p class="text-base text-dark-500 leading-relaxed">Trois temps complémentaires, un seul interlocuteur indépendant. Vous payez du conseil, jamais une commission.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-4 lg:gap-6">
            <div class="bg-white rounded-2xl p-5 lg:p-7 border border-dark-100 lg:shadow-sm">
                <span class="inline-block text-[13px] font-medium text-white bg-accent-600 px-3 py-1 rounded-md mb-4">1 · Auditer</span>
                <h3 class="text-[18px] font-medium text-dark-900 mb-2">Audit de conformité BACS</h3>
                <p class="text-[15px] text-dark-500 leading-relaxed mb-4">On objective l'état réel de votre bâtiment : assujettissement, échéance applicable, classe ISO 52120-1, écart de conformité et plan d'actions chiffré et priorisé pour viser la classe B. Estimation des aides CEE incluse.</p>
                <p class="text-[13px] text-dark-500">Mission one-shot · livrable + restitution commentée</p>
            </div>
            <div class="bg-white rounded-2xl p-5 lg:p-7 border border-dark-100 lg:shadow-sm">
                <span class="inline-block text-[13px] font-medium text-white bg-accent-600 px-3 py-1 rounded-md mb-4">2 · Équiper</span>
                <h3 class="text-[18px] font-medium text-dark-900 mb-2">Mise en place du suivi énergétique</h3>
                <p class="text-[15px] text-dark-500 leading-relaxed mb-4">On définit le suivi qu'il vous faut — sous-comptage par usage, historisation, tableau de bord, alertes de dérive — via un cahier des charges neutre, multi-protocoles, sans verrouillage fabricant. En AMO côté maître d'ouvrage : aucun matériel vendu.</p>
                <p class="text-[13px] text-dark-500">Projet sur devis · AMO indépendante</p>
            </div>
            <div class="bg-white rounded-2xl p-5 lg:p-7 border border-dark-100 lg:shadow-sm">
                <span class="inline-block text-[13px] font-medium text-white bg-accent-600 px-3 py-1 rounded-md mb-4">3 · Déclarer</span>
                <h3 class="text-[18px] font-medium text-dark-900 mb-2">Accompagnement OPERAT annuel</h3>
                <p class="text-[15px] text-dark-500 leading-relaxed mb-4">Chaque année, on fiabilise vos données, on calcule votre avancement vers les objectifs du décret tertiaire et on prépare votre déclaration OPERAT. Plus une revue de performance et une veille des échéances de conformité.</p>
                <p class="text-[13px] text-dark-500">Abonnement annuel par bâtiment</p>
            </div>
        </div>
        <div class="bg-dark-50 border border-dark-200 rounded-2xl p-5 lg:p-6 mt-4">
            <p class="text-sm text-dark-600 leading-relaxed text-center">Sur chaque mission : <strong class="text-dark-900">0 € de commission fabricant</strong> · méthode <strong class="text-dark-900">NF EN ISO 52120-1</strong> · livrable et délai écrits dans le devis.</p>
        </div>
    </div>
</section>

<!-- DÉROULÉ EN ÉTAPES -->
<section class="py-10 lg:py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-2xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Comment ça se passe</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight">De l'audit à la déclaration annuelle, étape par étape</h2>
        </div>
        <div class="max-w-3xl">
            @foreach([
                ['titre' => 'Test d\'assujettissement', 'desc' => 'On vérifie si le bâtiment est concerné (cumul des puissances CVC) et à quelle échéance BACS il est tenu.'],
                ['titre' => 'Audit sur site et classification', 'desc' => 'Relevé des lots techniques, état des lieux du système existant, classement NF EN ISO 52120-1 et grille de conformité (art. R. 175-3).'],
                ['titre' => 'Plan d\'actions chiffré', 'desc' => 'Actions priorisées P1/P2/P3 pour viser la classe B, avec estimation des aides CEE et du retour sur investissement.'],
                ['titre' => 'Mise en place du suivi', 'desc' => 'Cahier des charges neutre, aide au choix de l\'intégrateur, recette technique du tableau de bord et des points de mesure.'],
                ['titre' => 'Suivi et accompagnement OPERAT', 'desc' => 'Fiabilisation des données, calcul de l\'avancement décret tertiaire, déclaration annuelle OPERAT, revue de performance et veille des inspections périodiques.'],
            ] as $i => $step)
            <div class="flex gap-5 lg:gap-6">
                <div class="flex flex-col items-center">
                    <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-full bg-accent-600 text-white text-[15px] font-medium">{{ $i + 1 }}</div>
                    @if($i < 4)
                    <div class="mt-1 w-px flex-1 bg-accent-200"></div>
                    @endif
                </div>
                <div class="pb-8">
                    <h3 class="text-[17px] font-medium text-dark-900 mb-1">{{ $step['titre'] }}</h3>
                    <p class="text-[15px] text-dark-500 leading-relaxed">{{ $step['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- RÉASSURANCE -->
<section class="py-10 lg:py-20">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-2xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Pourquoi nous faire confiance</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Une posture qui vous protège, pas qui vous vend</h2>
            <p class="text-base text-dark-500 leading-relaxed">Pas de logos clients empruntés, pas d'avis inventés. Quatre choses vérifiables, tout de suite.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-4 lg:gap-6">
            @foreach([
                ['title' => 'Indépendance prouvée, pas promise', 'desc' => '0 € de commission, aucun partenariat fabricant, aucune affiliation. Notre seul revenu vient du conseil que vous payez — donc notre seul intérêt, c\'est que vous preniez la bonne décision.'],
                ['title' => 'Une méthode normée', 'desc' => 'Chaque évaluation s\'appuie sur la norme NF EN ISO 52120-1:2022 et les données publiques ADEME / OPERAT. Critères affichés, vérifiables, identiques pour tous les bâtiments.'],
                ['title' => 'La conformité dans la durée', 'desc' => 'Le décret BACS impose un suivi en continu et des inspections périodiques. Notre accompagnement annuel est fait pour tenir cette obligation, pas seulement la déclencher.'],
                ['title' => 'Anti-verrouillage', 'desc' => 'Cahier des charges multi-protocoles (BACnet / KNX / Modbus / DALI). Vous restez maître de votre installation, jamais prisonnier d\'une marque.'],
            ] as $pilier)
            <div class="bg-white rounded-2xl p-5 lg:p-7 border border-dark-100 lg:shadow-sm">
                <h3 class="text-[17px] font-medium text-dark-900 mb-2">{{ $pilier['title'] }}</h3>
                <p class="text-[15px] text-dark-500 leading-relaxed">{{ $pilier['desc'] }}</p>
            </div>
            @endforeach
        </div>
        <div class="bg-dark-50 border border-dark-200 rounded-2xl p-5 lg:p-6 mt-4">
            <p class="text-sm text-dark-600 leading-relaxed">Les premiers retours clients seront publiés ici dès qu'ils seront réels et vérifiables. En attendant, on préfère le vide à l'invention.</p>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="py-10 lg:py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-2xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Questions fréquentes</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight">Conformité BACS, OPERAT, ISO 52120 : ce qu'on nous demande le plus</h2>
        </div>
        <div x-data="{ open: 1 }" class="max-w-3xl space-y-3">
            @foreach([
                ['q' => 'Mon bâtiment est-il concerné par le décret BACS ?', 'a' => 'Le décret BACS s\'applique aux bâtiments tertiaires équipés de systèmes de chauffage et/ou de climatisation (combinés ou non avec la ventilation), dès lors que leur puissance nominale utile cumulée dépasse un seuil. Au-dessus de 290 kW, la conformité est exigée depuis le 1er janvier 2025. Pour la tranche 70 à 290 kW, l\'échéance a été reportée au 1er janvier 2030. Le test d\'assujettissement consiste à additionner la puissance de tous les générateurs concernés du bâtiment — c\'est la première chose que notre audit vérifie.'],
                ['q' => 'Quelle est la différence entre le décret BACS et la déclaration OPERAT ?', 'a' => 'Ce sont deux obligations distinctes mais liées. Le décret BACS porte sur le système : il impose une GTB de classe A ou B capable de suivre, analyser et alerter en continu. La déclaration OPERAT relève du décret tertiaire : les bâtiments de plus de 1 000 m² doivent déclarer chaque année leurs consommations sur la plateforme OPERAT de l\'ADEME, pour démontrer leur trajectoire de réduction (-40 % en 2030, -50 % en 2040, -60 % en 2050). Le lien entre les deux, c\'est la GTB : elle produit les données du suivi BACS et celles que vous déclarez sur OPERAT.'],
                ['q' => 'Qu\'est-ce que la norme NF EN ISO 52120-1 et quelle classe viser ?', 'a' => 'La norme NF EN ISO 52120-1:2022 (qui remplace l\'ancienne EN 15232) classe les systèmes d\'automatisation du bâtiment en quatre classes : A, B, C et D. La classe D correspond à l\'absence d\'automatisation, la classe C au socle standard, la classe B à une GTB centralisée avec suivi énergétique et détection de dérives, et la classe A au plus haut niveau de performance. Le décret BACS impose des fonctions (art. R. 175-3), pas une classe ; la classe B est le niveau couramment visé et la condition de la prime CEE. Viser la classe A est possible, mais c\'est un arbitrage de retour sur investissement que notre audit pose clairement, plutôt qu\'un sur-investissement par défaut.'],
            ] as $i => $faq)
            <div class="bg-white border border-dark-100 rounded-2xl overflow-hidden">
                <button type="button" @click="open === {{ $i + 1 }} ? open = null : open = {{ $i + 1 }}" :aria-expanded="(open === {{ $i + 1 }}).toString()" class="w-full flex items-center justify-between gap-4 text-left p-5 lg:p-6 min-h-[44px] focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-accent-500">
                    <span class="text-[15px] lg:text-base font-medium text-dark-900">{{ $faq['q'] }}</span>
                    <svg class="w-4 h-4 flex-shrink-0 text-dark-500 transition-transform duration-200" :class="open === {{ $i + 1 }} && 'rotate-180'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                </button>
                <div x-show="open === {{ $i + 1 }}" x-collapse>
                    <p class="px-5 lg:px-6 pb-5 lg:pb-6 text-[15px] text-dark-500 leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="py-10 lg:py-20">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="bg-dark-100 border border-dark-200 rounded-3xl p-8 lg:p-12">
            <div class="max-w-2xl">
                <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Faites le point sur votre conformité</h2>
                <p class="text-base text-dark-500 leading-relaxed mb-7">Audit BACS, suivi énergétique, déclaration OPERAT : un seul interlocuteur indépendant pour vos obligations tertiaires. Parlons de votre bâtiment.</p>
                <div class="flex flex-wrap gap-4">
                    <x-front.shared.btn-primary href="/contact">Parler à un expert</x-front.shared.btn-primary>
                    <a href="/audit" class="inline-flex items-center gap-1.5 px-6 py-3 text-sm font-medium text-dark-600 border border-dark-300 rounded-lg hover:bg-dark-50 transition-colors">
                        Lancer le pré-diagnostic gratuit
                    </a>
                </div>
                <p class="text-[13px] text-dark-500 mt-5">Une question directe ? <a href="mailto:hello@neogtb.fr" class="text-accent-600 font-medium hover:text-accent-700">hello@neogtb.fr</a></p>
            </div>
        </div>
    </div>
</section>

<!-- PAGES LIÉES -->
<section class="py-12 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="grid md:grid-cols-3 gap-4 lg:gap-6">
            @foreach([
                ['href' => '/reglementation', 'title' => 'Réglementation GTB', 'desc' => 'Calendrier BACS, décret tertiaire et obligations en détail.'],
                ['href' => '/audit', 'title' => 'Pré-diagnostic gratuit', 'desc' => 'Évaluez votre conformité ISO 52120-1 en quelques minutes.'],
                ['href' => '/generateur-cee', 'title' => 'Simulateur CEE', 'desc' => 'Estimez vos primes Certificats d\'Économies d\'Énergie.'],
            ] as $link)
            <a href="{{ $link['href'] }}" class="block bg-dark-50 rounded-2xl p-5 lg:p-7 border border-dark-100 card-hover-glow">
                <h3 class="text-[15px] font-medium text-dark-900 mb-1">{{ $link['title'] }}</h3>
                <p class="text-sm text-dark-500">{{ $link['desc'] }}</p>
            </a>
            @endforeach
        </div>
    </div>
</section>

@endsection
