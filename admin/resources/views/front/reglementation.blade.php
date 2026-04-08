@extends('front.layouts.app')


@section('content')

<!-- HERO IMAGE -->
<x-front.shared.hero
    image="/images/hero-reglementation.webp"
    imageAlt="Réglementation GTB — balance juridique, normes énergétiques et bâtiment tertiaire"
    eyebrow="Cadre juridique"
    title="Réglementation GTB en France"
    highlight="GTB"
    subtitle="Décret BACS, décret tertiaire, RE2020, directive EPBD, norme EN ISO 52120-1 : obligations, échéances et aides. Mis à jour mars 2026."
    :tags="['Décret BACS', 'Décret tertiaire', 'RE2020', 'ISO 52120-1']"
    minHeight="480px"
    overlay="gradient"
/>

<!-- ALERTE ACTUALITÉ -->
<section class="px-5 lg:px-10">
    <div class="max-w-7xl mx-auto">
        <div class="bg-accent-50 border border-accent-200 rounded-xl p-5 -mt-8 relative z-10">
            <div class="flex items-start gap-3">
                <div class="w-2 h-2 rounded-full bg-accent-500 mt-1.5 flex-shrink-0"></div>
                <div>
                    <p class="text-sm font-medium text-dark-900 mb-1">Mise à jour — Décret n° 2025-1343 du 26 décembre 2025</p>
                    <p class="text-sm text-dark-600 leading-relaxed">L'obligation GTB/BACS pour les bâtiments tertiaires existants de <strong>70 à 290 kW</strong> est <strong>reportée au 1er janvier 2030</strong> (initialement 2027). L'échéance >290 kW reste en vigueur depuis le 1er janvier 2025.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CALENDRIER -->
<section class="py-10 lg:py-20">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Vue d'ensemble</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Calendrier des obligations</h2>
            <p class="text-base text-dark-500 leading-relaxed">Toutes les échéances réglementaires liées à la GTB, actualisées après le décret de décembre 2025.</p>
        </div>
        {{-- MOBILE : cards stack --}}
        <div class="lg:hidden space-y-3">
            @foreach([
                ['type' => 'Existant', 'puissance' => '> 290 kW', 'echeance' => '1er janvier 2025', 'statut' => 'En vigueur', 'color' => 'accent'],
                ['type' => 'Existant', 'puissance' => '70 à 290 kW', 'echeance' => '1er janvier 2030', 'statut' => 'Reporté (était 2027)', 'color' => 'orange'],
                ['type' => 'Neuf (permis > 21/07/2021)', 'puissance' => '> 290 kW', 'echeance' => 'À la construction', 'statut' => 'Obligatoire', 'color' => 'accent'],
                ['type' => 'Neuf (permis > 08/04/2024)', 'puissance' => '> 70 kW', 'echeance' => 'À la construction', 'statut' => 'Obligatoire', 'color' => 'accent'],
            ] as $row)
            <div class="bg-white border border-dark-100 rounded-2xl p-5">
                <div class="flex items-start justify-between gap-3 mb-4">
                    <p class="text-[15px] font-medium text-dark-900">{{ $row['type'] }}</p>
                    <span class="text-[11px] font-medium px-2.5 py-1 rounded-md border flex-shrink-0 {{ $row['color'] === 'orange' ? 'bg-orange-50 text-orange-800 border-orange-200' : 'bg-accent-50 text-accent-800 border-accent-200' }}">{{ $row['statut'] }}</span>
                </div>
                <dl class="space-y-2 text-[13px]">
                    <div class="flex justify-between gap-3">
                        <dt class="text-dark-400">Puissance CVC</dt>
                        <dd class="text-dark-700 font-medium text-right">{{ $row['puissance'] }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-dark-400">Échéance</dt>
                        <dd class="text-dark-700 font-medium text-right">{{ $row['echeance'] }}</dd>
                    </div>
                </dl>
            </div>
            @endforeach
        </div>
        <div class="hidden lg:block border border-dark-100 rounded-2xl overflow-x-auto">
            <table class="w-full min-w-[640px] border-collapse text-sm">
                <thead>
                    <tr class="bg-dark-50">
                        <th class="text-left text-[11px] font-medium uppercase tracking-widest text-dark-400 p-3 border-b border-dark-200">Type</th>
                        <th class="text-left text-[11px] font-medium uppercase tracking-widest text-dark-400 p-3 border-b border-dark-200">Puissance CVC</th>
                        <th class="text-left text-[11px] font-medium uppercase tracking-widest text-dark-400 p-3 border-b border-dark-200">Échéance</th>
                        <th class="text-left text-[11px] font-medium uppercase tracking-widest text-dark-400 p-3 border-b border-dark-200">Statut mars 2026</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-dark-100">
                        <td class="p-3.5 font-medium text-dark-900">Existant</td>
                        <td class="p-3.5 text-dark-600">> 290 kW</td>
                        <td class="p-3.5 text-dark-600">1er janvier 2025</td>
                        <td class="p-3.5"><span class="text-xs font-medium text-accent-800 bg-accent-50 px-2.5 py-1 rounded-md">En vigueur</span></td>
                    </tr>
                    <tr class="border-b border-dark-100">
                        <td class="p-3.5 font-medium text-dark-900">Existant</td>
                        <td class="p-3.5 text-dark-600">70 à 290 kW</td>
                        <td class="p-3.5 text-dark-600">1er janvier 2030</td>
                        <td class="p-3.5"><span class="text-xs font-medium text-orange-800 bg-orange-50 px-2.5 py-1 rounded-md">Reporté (était 2027)</span></td>
                    </tr>
                    <tr class="border-b border-dark-100">
                        <td class="p-3.5 font-medium text-dark-900">Neuf (permis > 21/07/2021)</td>
                        <td class="p-3.5 text-dark-600">> 290 kW</td>
                        <td class="p-3.5 text-dark-600">À la construction</td>
                        <td class="p-3.5"><span class="text-xs font-medium text-accent-800 bg-accent-50 px-2.5 py-1 rounded-md">Obligatoire</span></td>
                    </tr>
                    <tr>
                        <td class="p-3.5 font-medium text-dark-900">Neuf (permis > 08/04/2024)</td>
                        <td class="p-3.5 text-dark-600">> 70 kW</td>
                        <td class="p-3.5 text-dark-600">À la construction</td>
                        <td class="p-3.5"><span class="text-xs font-medium text-accent-800 bg-accent-50 px-2.5 py-1 rounded-md">Obligatoire</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        @include('front.bricks.cta-mini.cta-inline-mini-card', ['href' => '/audit', 'eyebrow' => 'Auto-évaluation', 'text' => 'Savoir quelle ligne s\'applique à votre bâtiment — 3 minutes, sans inscription.', 'linkText' => 'Pré-diagnostic'])
    </div>
</section>

<!-- DÉCRET BACS -->
<section class="py-10 lg:py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-12">
            <div class="lg:col-span-3">
                <span class="inline-block text-[13px] font-medium text-white bg-accent-600 px-3 py-1 rounded-md mb-4">Obligation principale</span>
                <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-4">Décret BACS</h2>
                <p class="text-sm text-dark-400 mb-5">Décret n° 2020-887 du 20 juillet 2020 / Modifié par le décret n° 2025-1343 du 26 décembre 2025</p>
                <p class="text-base text-dark-500 leading-relaxed mb-4">Le décret BACS transpose l'article 14 de la <strong class="text-dark-900 font-medium">directive européenne EPBD 2018/844</strong> sur la performance énergétique des bâtiments. Il impose l'installation de systèmes d'automatisation et de contrôle dans les bâtiments tertiaires non résidentiels.</p>
                <p class="text-base text-dark-500 leading-relaxed mb-4">Le système installé doit atteindre <strong class="text-dark-900 font-medium">a minima la classe B</strong> de la norme EN 15232 (NF EN ISO 52120-1). Il doit être capable de :</p>
                <ul class="text-[15px] text-dark-500 leading-relaxed pl-5 list-disc mb-5 space-y-2">
                    <li>Suivre, enregistrer et analyser la consommation énergétique par usage</li>
                    <li>Ajuster les régulations en fonction de l'occupation et des besoins</li>
                    <li>Détecter les défauts et les dérives de performance</li>
                    <li>Communiquer avec les systèmes techniques interconnectés</li>
                    <li>Permettre le pilotage manuel et automatique des installations CVC</li>
                </ul>
                <div class="bg-accent-50 border border-accent-200 rounded-2xl p-5 lg:p-7">
                    <p class="text-xs font-semibold uppercase tracking-widest text-accent-700 mb-2">Inspection obligatoire</p>
                    <p class="text-sm text-dark-600 leading-relaxed">Les systèmes BACS doivent faire l'objet d'une <strong>inspection régulière</strong> vérifiant le bon fonctionnement du système d'automatisation et sa conformité à la classe de performance déclarée.</p>
                </div>
            </div>
            <div class="lg:col-span-2 space-y-4">
                @foreach([
                    ['label' => 'Bâtiments concernés', 'text' => 'Tous les bâtiments tertiaires non résidentiels : bureaux, commerces, enseignement, santé, hôtellerie, logistique, sport.'],
                    ['label' => 'Seuil de puissance', 'text' => 'Puissance nominale utile cumulée des systèmes CVC (chauffage + climatisation). Somme de tous les générateurs du bâtiment.'],
                ] as $card)
                <div class="bg-white rounded-2xl p-5 lg:p-7 border border-dark-100 lg:shadow-sm">
                    <p class="text-[11px] font-medium uppercase tracking-widest text-dark-400 mb-2">{{ $card['label'] }}</p>
                    <p class="text-[15px] text-dark-600 leading-relaxed">{{ $card['text'] }}</p>
                </div>
                @endforeach
                <div class="bg-white rounded-2xl p-5 lg:p-7 border border-dark-100 lg:shadow-sm">
                    <p class="text-[11px] font-medium uppercase tracking-widest text-dark-400 mb-2">Niveau requis</p>
                    <p class="text-[28px] font-medium text-accent-600 tracking-tight">Classe B</p>
                    <p class="text-[13px] text-dark-400 mt-1">minimum / norme ISO 52120-1</p>
                </div>
                <div class="bg-white rounded-2xl p-5 lg:p-7 border border-dark-100 lg:shadow-sm">
                    <p class="text-[11px] font-medium uppercase tracking-widest text-dark-400 mb-2">Exemption</p>
                    <p class="text-[15px] text-dark-600 leading-relaxed">Possibilité de dérogation si un audit énergétique démontre un temps de retour sur investissement supérieur à 6 ans.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- DÉCRET TERTIAIRE -->
<section class="py-10 lg:py-20">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="grid md:grid-cols-2 gap-12">
            <div>
                <span class="inline-block text-[13px] font-medium text-white bg-dark-600 px-3 py-1 rounded-md mb-4">Objectifs de réduction</span>
                <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-4">Décret tertiaire — Éco Énergie Tertiaire</h2>
                <p class="text-sm text-dark-400 mb-5">Décret n° 2019-771 du 23 juillet 2019 / Issu de la loi ELAN</p>
                <p class="text-base text-dark-500 leading-relaxed mb-4">Le décret tertiaire impose aux bâtiments tertiaires de <strong class="text-dark-900 font-medium">plus de 1 000 m²</strong> une réduction progressive de leur consommation d'énergie finale par rapport à une année de référence (postérieure à 2010).</p>
                <p class="text-base text-dark-500 leading-relaxed mb-4">Les données doivent être déclarées annuellement sur la plateforme <strong class="text-dark-900 font-medium">OPERAT</strong> gérée par l'ADEME. La GTB constitue le levier principal pour atteindre ces objectifs de réduction.</p>
                <div class="bg-accent-50 border border-accent-200 rounded-2xl p-5 lg:p-7 mt-6">
                    <p class="text-xs font-semibold uppercase tracking-widest text-accent-700 mb-2">Sanctions</p>
                    <p class="text-sm text-dark-600 leading-relaxed">En cas de non-respect : mise en demeure, publication du nom du contrevenant sur un site public ("name and shame"), et amende jusqu'à <strong>7 500 &euro; par bâtiment</strong> pour les personnes morales.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-3 lg:gap-5">
                @foreach([
                    ['-40 %', 'Objectif 2030', 'Déclaration OPERAT avant le 30 sept. 2026'],
                    ['-50 %', 'Objectif 2040', null],
                    ['-60 %', 'Objectif 2050', null],
                ] as $i => $obj)
                <div class="bg-white rounded-2xl p-5 lg:p-7 text-center border border-dark-100 lg:shadow-sm">
                    <p class="text-5xl font-medium {{ $i === 0 ? 'text-accent-600' : 'text-dark-700' }} tracking-tight leading-none">{{ $obj[0] }}</p>
                    <p class="text-sm text-dark-500 mt-2">{{ $obj[1] }}</p>
                    @if($obj[2])
                    <p class="text-xs text-dark-400 mt-1">{{ $obj[2] }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- RE2020 + EPBD -->
<section class="py-10 lg:py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Bâtiments neufs et Europe</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight">Autres réglementations clés</h2>
        </div>
        <div class="grid md:grid-cols-2 gap-4 lg:gap-6">
            @foreach([
                ['badge' => 'Neuf / Depuis 2022', 'bg' => 'bg-dark-700', 'title' => 'RE2020', 'subtitle' => 'Réglementation Environnementale 2020', 'desc' => 'Applicable aux bâtiments neufs depuis le 1er janvier 2022. Renforce les exigences de performance par rapport à la RT2012 et introduit le calcul de l\'empreinte carbone sur le cycle de vie. Deux indicateurs rendent la GTB quasi indispensable en tertiaire :', 'extra' => '<div class="grid grid-cols-2 gap-4 mt-4"><div class="p-3.5 rounded-lg bg-dark-50 border border-dark-200"><p class="text-xl font-medium text-dark-900">Cep</p><p class="text-xs text-dark-400 mt-1">Consommation d\'énergie primaire</p></div><div class="p-3.5 rounded-lg bg-dark-50 border border-dark-200"><p class="text-xl font-medium text-dark-900">DH</p><p class="text-xs text-dark-400 mt-1">Degrés-heures d\'inconfort</p></div></div>'],
                ['badge' => 'Europe / Refonte 2024', 'bg' => 'bg-accent-700', 'title' => 'Directive EPBD', 'subtitle' => 'Energy Performance of Buildings Directive / 2018/844 → refonte 2024', 'desc' => 'La directive EPBD est le texte européen fondateur qui impose la GTB. L\'article 14 est l\'origine du décret BACS français. La <strong class="text-dark-900">refonte 2024</strong> renforce les exigences :', 'extra' => '<ul class="text-sm text-dark-500 leading-relaxed pl-5 list-disc mt-4 space-y-2"><li>Objectif bâtiments à émission zéro d\'ici 2050</li><li>Passeport de rénovation pour chaque bâtiment</li><li>Abaissement progressif des seuils BACS</li><li>Obligation de suivi énergétique continu</li></ul>'],
                ['badge' => 'Loi / 2018', 'bg' => 'bg-dark-600', 'title' => 'Loi ELAN', 'subtitle' => 'Loi n° 2018-1021 du 23 novembre 2018', 'desc' => 'Loi portant évolution du logement, de l\'aménagement et du numérique. L\'article 175 est à l\'origine du <strong class="text-dark-900">décret tertiaire</strong> : obligation de réduction de consommation pour les bâtiments tertiaires de plus de 1 000 m².', 'extra' => null],
                ['badge' => 'Loi / 2021', 'bg' => 'bg-accent-800', 'title' => 'Loi Climat et Résilience', 'subtitle' => 'Loi n° 2021-1104 du 22 août 2021', 'desc' => 'Renforce les obligations énergétiques : interdiction de location des passoires thermiques (DPE F et G), obligation d\'audit énergétique avant vente, accélération de la rénovation du parc tertiaire. La GTB est un levier de conformité.', 'extra' => null],
            ] as $item)
            <div class="bg-white rounded-2xl p-5 lg:p-7 border border-dark-100 lg:shadow-sm">
                <span class="inline-block text-[13px] font-medium text-white {{ $item['bg'] }} px-3 py-1 rounded-md mb-4">{{ $item['badge'] }}</span>
                <h3 class="text-[22px] font-medium text-dark-900 tracking-tight mb-3">{{ $item['title'] }}</h3>
                <p class="text-sm text-dark-400 mb-4">{{ $item['subtitle'] }}</p>
                <p class="text-[15px] text-dark-500 leading-relaxed">{!! $item['desc'] !!}</p>
                @if($item['extra'])
                {!! $item['extra'] !!}
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- NORME EN ISO 52120-1 -->
<section class="py-10 lg:py-20">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Référentiel technique</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Norme EN ISO 52120-1 (ex-EN 15232)</h2>
            <p class="text-base text-dark-500 leading-relaxed">La norme de référence pour évaluer le niveau de performance des systèmes GTB. Le décret BACS impose la classe B minimum.</p>
        </div>
        <div class="grid md:grid-cols-4 gap-3 lg:gap-5 mb-12">
            @foreach([
                ['badge' => 'Classe D', 'bg' => 'bg-dark-400', 'title' => 'Non performant', 'desc' => 'Aucun système d\'automatisation. Pilotage manuel.', 'sub' => 'Référence basse', 'highlight' => false],
                ['badge' => 'Classe C', 'bg' => 'bg-dark-500', 'title' => 'Standard', 'desc' => 'Régulation de base, programmation horaire, sans supervision.', 'sub' => 'Minimum neuf', 'highlight' => false],
                ['badge' => 'Classe B', 'bg' => 'bg-accent-600', 'title' => 'Avancé', 'desc' => 'GTB centralisée, suivi énergétique, détection de dérives.', 'sub' => 'Exigence décret BACS', 'highlight' => true],
                ['badge' => 'Classe A', 'bg' => 'bg-dark-800', 'title' => 'Haute performance', 'desc' => 'Régulation pièce par pièce, optimisation multi-lots, IA.', 'sub' => 'Performance maximale', 'highlight' => false],
            ] as $cl)
            <div class="{{ $cl['highlight'] ? 'bg-white rounded-2xl border border-accent-200 shadow-[0_0_0_3px] shadow-accent-50' : 'bg-white rounded-2xl border border-dark-100 lg:shadow-sm' }} p-5 lg:p-7">
                <span class="inline-block text-[13px] font-medium text-white {{ $cl['bg'] }} px-2.5 py-1 rounded-md mb-3.5">{{ $cl['badge'] }}</span>
                <h3 class="text-[17px] font-medium text-dark-900 mb-2">{{ $cl['title'] }}</h3>
                <p class="text-[13px] text-dark-500 leading-relaxed mb-3">{{ $cl['desc'] }}</p>
                <p class="text-xs {{ $cl['highlight'] ? 'font-medium text-accent-600' : 'text-dark-400' }}">{{ $cl['sub'] }}</p>
            </div>
            @endforeach
        </div>

        <!-- Gains par classe -->
        <h3 class="text-lg font-medium text-dark-900 mb-4">Gains énergétiques estimés par la norme</h3>
        {{-- MOBILE : cards stack --}}
        <div class="lg:hidden space-y-3">
            @foreach([
                ['passage' => 'D → C', 'cvc' => '5 à 15 %', 'ecl' => '5 à 10 %', 'global' => '~10 %', 'highlight' => false],
                ['passage' => 'D → B', 'cvc' => '15 à 30 %', 'ecl' => '10 à 25 %', 'global' => '~25 %', 'highlight' => true],
                ['passage' => 'D → A', 'cvc' => '25 à 45 %', 'ecl' => '20 à 40 %', 'global' => '~35 %', 'highlight' => false],
            ] as $g)
            <div class="bg-white border border-dark-100 rounded-2xl p-5">
                <div class="flex items-start justify-between gap-3 mb-4">
                    <p class="text-[15px] font-medium {{ $g['highlight'] ? 'text-accent-600' : 'text-dark-900' }}">{{ $g['passage'] }}</p>
                    <span class="text-[11px] font-medium px-2.5 py-1 rounded-md border bg-accent-50 text-accent-800 border-accent-200 flex-shrink-0">Global {{ $g['global'] }}</span>
                </div>
                <dl class="space-y-2 text-[13px]">
                    <div class="flex justify-between gap-3">
                        <dt class="text-dark-400">CVC (bureaux)</dt>
                        <dd class="text-dark-700 font-medium text-right">{{ $g['cvc'] }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-dark-400">Éclairage</dt>
                        <dd class="text-dark-700 font-medium text-right">{{ $g['ecl'] }}</dd>
                    </div>
                </dl>
            </div>
            @endforeach
        </div>
        <div class="hidden lg:block border border-dark-100 rounded-2xl overflow-x-auto">
            <table class="w-full min-w-[640px] border-collapse text-sm">
                <thead>
                    <tr class="bg-dark-50">
                        <th class="text-left text-[11px] font-medium uppercase tracking-widest text-dark-400 p-3 border-b border-dark-200">Passage</th>
                        <th class="text-left text-[11px] font-medium uppercase tracking-widest text-dark-400 p-3 border-b border-dark-200">CVC (bureaux)</th>
                        <th class="text-left text-[11px] font-medium uppercase tracking-widest text-dark-400 p-3 border-b border-dark-200">Éclairage</th>
                        <th class="text-left text-[11px] font-medium uppercase tracking-widest text-dark-400 p-3 border-b border-dark-200">Global</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-dark-100">
                        <td class="p-3.5 font-medium text-dark-900">D &rarr; C</td>
                        <td class="p-3.5 text-dark-600">5 à 15 %</td>
                        <td class="p-3.5 text-dark-600">5 à 10 %</td>
                        <td class="p-3.5 text-dark-600">~10 %</td>
                    </tr>
                    <tr class="border-b border-dark-100">
                        <td class="p-3.5 font-medium text-accent-600">D &rarr; B</td>
                        <td class="p-3.5 text-dark-600">15 à 30 %</td>
                        <td class="p-3.5 text-dark-600">10 à 25 %</td>
                        <td class="p-3.5 font-medium text-accent-600">~25 %</td>
                    </tr>
                    <tr>
                        <td class="p-3.5 font-medium text-dark-900">D &rarr; A</td>
                        <td class="p-3.5 text-dark-600">25 à 45 %</td>
                        <td class="p-3.5 text-dark-600">20 à 40 %</td>
                        <td class="p-3.5 font-medium text-dark-900">~35 %</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- CEE -->
<section class="py-10 lg:py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Aides financières</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Certificats d'Économies d'Énergie (CEE)</h2>
            <p class="text-base text-dark-500 leading-relaxed">Les CEE financent une partie significative de l'installation GTB. Deux fiches standardisées couvrent les travaux de GTB.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-4 lg:gap-6">
            @foreach([
                ['ref' => 'BAT-TH-116', 'subtitle' => 'Système de gestion technique du bâtiment pour le chauffage et le refroidissement', 'desc' => 'Couvre l\'installation d\'un système GTB de classe A ou B (ISO 52120-1) pour le pilotage du CVC. Le montant de la prime dépend de la surface, de la zone climatique et de la classe atteinte.', 'cond' => 'Bâtiment tertiaire existant, installation par un professionnel, passage en classe A ou B vérifié.'],
                ['ref' => 'BAT-TH-112', 'subtitle' => 'Système de variation électronique de vitesse sur moteur asynchrone', 'desc' => 'Couvre l\'installation de variateurs de vitesse sur les moteurs CVC (pompes, ventilateurs, compresseurs). Complémentaire à la GTB qui envoie les consignes de vitesse.', 'cond' => 'Puissance moteur >= 0,55 kW, variateur certifié, installation sur moteur existant ou neuf.'],
            ] as $cee)
            <div class="bg-white rounded-2xl p-5 lg:p-7 border border-dark-100 lg:shadow-sm">
                <span class="inline-block text-[13px] font-medium text-orange-800 bg-orange-50 px-3 py-1 rounded-md mb-4">Fiche standardisée</span>
                <h3 class="text-[22px] font-medium text-dark-900 tracking-tight mb-3">{{ $cee['ref'] }}</h3>
                <p class="text-sm text-dark-400 mb-4">{{ $cee['subtitle'] }}</p>
                <p class="text-[15px] text-dark-500 leading-relaxed mb-4">{{ $cee['desc'] }}</p>
                <div class="p-3.5 rounded-lg bg-dark-50 border border-dark-200">
                    <p class="text-[13px] text-dark-500 leading-relaxed"><strong class="text-dark-900">Conditions :</strong> {{ $cee['cond'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="bg-accent-50 border border-accent-200 rounded-2xl p-5 lg:p-7 mt-6">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-700 mb-2">Estimation gratuite</p>
            <p class="text-sm text-dark-600 leading-relaxed">Utilisez notre <a href="/generateur-cee" class="text-accent-600 font-medium hover:text-accent-700">générateur CEE</a> pour estimer le montant de vos certificats d'économies d'énergie en 3 minutes, sans intermédiaire.</p>
        </div>
    </div>
</section>

<!-- SYNTHÈSE -->
<section class="py-10 lg:py-20">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Synthèse</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Comment la GTB répond à toutes ces obligations</h2>
            <p class="text-base text-dark-500 leading-relaxed">La GTB est le point de convergence de l'ensemble du cadre réglementaire du bâtiment tertiaire.</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach([
                ['title' => 'Décret BACS', 'desc' => 'La GTB <strong class="text-accent-600">est</strong> l\'obligation. Classe A ou B requise.'],
                ['title' => 'Décret tertiaire', 'desc' => 'Levier principal pour atteindre les -40/-50/-60 %.'],
                ['title' => 'RE2020', 'desc' => 'Optimise le Cep et maîtrise le DH sur le cycle de vie.'],
                ['title' => 'EPBD', 'desc' => 'Exigence européenne transposée en droit national.'],
                ['title' => 'CEE', 'desc' => 'Financement via la fiche BAT-TH-116. Durée de vie 15 ans.'],
                ['title' => 'EN ISO 52120-1', 'desc' => 'Performances quantifiées : jusqu\'à 30 % d\'économies.'],
                ['title' => 'DPE / Audit', 'desc' => 'Améliore la classe DPE et fournit les données pour l\'audit.'],
                ['title' => 'SRI', 'desc' => 'Au cœur de l\'indicateur d\'intelligence du bâtiment.'],
                ['title' => 'Taxonomie verte', 'desc' => 'Contribue à l\'alignement des investissements immobiliers.'],
            ] as $item)
            <div class="bg-white rounded-2xl p-5 lg:p-7 border border-dark-100 lg:shadow-sm">
                <p class="text-[15px] font-medium text-dark-900 mb-1.5">{{ $item['title'] }}</p>
                <p class="text-[13px] text-dark-500 leading-relaxed">{!! $item['desc'] !!}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="relative overflow-hidden py-10 lg:py-20 bg-dark-100 border-t border-dark-200">
    <img src="/images/hero-gtb-illustration.webp" alt="" aria-hidden="true" width="1200" height="630" loading="lazy" class="absolute right-0 top-0 h-full w-auto object-cover opacity-20" />
    <div class="absolute inset-0 bg-gradient-to-r from-dark-100 via-dark-100/80 to-transparent pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-5 lg:px-10 relative z-10 flex items-center min-h-[200px]">
        <div class="max-w-lg">
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Vérifiez votre conformité</h2>
            <p class="text-base text-dark-500 leading-relaxed mb-7">Identifiez votre classe ISO 52120-1, évaluez vos obligations BACS et estimez vos aides CEE.</p>
            <div class="flex flex-wrap gap-4">
                <a href="/audit" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition-colors btn-glow">
                    Lancer le diagnostic
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="/generateur-cee" class="inline-flex items-center gap-1.5 px-6 py-3 text-sm font-medium text-dark-600 border border-dark-300 rounded-lg hover:bg-dark-50 transition-colors">
                    Estimer mes CEE
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Related pages -->
<section class="py-12 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="grid md:grid-cols-3 gap-4 lg:gap-6">
            @foreach([
                ['href' => '/gtb', 'title' => "Qu'est-ce que la GTB ?", 'desc' => 'Comprendre la GTB avant de s\'attaquer à la réglementation.'],
                ['href' => '/audit', 'title' => 'Audit GTB gratuit', 'desc' => 'Évaluez votre niveau de conformité ISO 52120-1 en 5 minutes.'],
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
