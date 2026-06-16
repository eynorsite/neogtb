@extends('front.layouts.app')

{{-- Fil d'Ariane --}}
@section('breadcrumbs')
    <li><a href="/" class="hover:text-accent-600 transition-colors">Accueil</a></li>
    <li aria-hidden="true" class="text-dark-300">/</li>
    <li><a href="/reglementation" class="hover:text-accent-600 transition-colors">Réglementation</a></li>
    <li aria-hidden="true" class="text-dark-300">/</li>
    <li aria-current="page" class="text-dark-600">Décret BACS</li>
@endsection

{{-- JSON-LD FAQPage — canal schema.org contextuel (app.blade.php:99). Exempté CSP. --}}
@push('schema')
<script type="application/ld+json" @cspNonce>
@verbatim
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        {"@type":"Question","name":"Mon bâtiment est-il concerné par le décret BACS ?","acceptedAnswer":{"@type":"Answer","text":"Le décret BACS s'applique aux bâtiments tertiaires non résidentiels selon la puissance nominale cumulée de leurs systèmes CVC (chauffage et climatisation). Existant supérieur à 290 kW : obligation en vigueur depuis le 1er janvier 2025. Existant de 70 à 290 kW : obligation au 1er janvier 2030 (report acté par le décret n° 2025-1343 du 26 décembre 2025). Neuf supérieur à 70 kW (permis déposé après le 8 avril 2024) : obligation dès la construction."}},
        {"@type":"Question","name":"Quelle classe de GTB faut-il atteindre ?","acceptedAnswer":{"@type":"Answer","text":"Le décret BACS impose une GTB de classe B minimum au sens de la norme NF EN ISO 52120-1 (ex EN 15232). La classe C correspond seulement au minimum exigé pour le neuf au titre d'autres réglementations, et la classe A représente le niveau de performance le plus élevé."}},
        {"@type":"Question","name":"Combien coûte la mise en conformité et quels CEE sont mobilisables ?","acceptedAnswer":{"@type":"Answer","text":"Le coût dépend de la surface, de l'architecture technique et de la classe visée. La fiche standardisée CEE BAT-TH-116 finance l'installation d'une GTB de classe A ou B sur un bâtiment tertiaire existant. Elle se combine avec la fiche BAT-TH-112 (variation électronique de vitesse sur moteur). Le montant exact se chiffre au cas par cas après audit."}},
        {"@type":"Question","name":"Que risque-t-on en cas de non-conformité ?","acceptedAnswer":{"@type":"Answer","text":"Une dérogation au décret BACS est possible si un audit énergétique démontre un temps de retour sur investissement supérieur à 6 ans. À noter : l'amende administrative pouvant atteindre 7 500 euros par bâtiment pour une personne morale, ainsi que la publication du nom du contrevenant, relèvent du décret tertiaire (Éco Énergie Tertiaire), pas du décret BACS lui-même."}}
    ]
}
@endverbatim
</script>
@endpush

@section('content')

{{-- =========================================================================
     HERO — LIGHT MODE. Titre sombre (text-dark-900 = #111827), fond clair,
     PAS d'overlay sombre, PAS de classe dark:. Orbs décoratifs avec dimensions
     fixes (pas de régression CLS), prefers-reduced-motion géré globalement.
     ========================================================================= --}}
<section class="relative overflow-hidden bg-white border-b border-dark-100">
    {{-- Décor : halo + orbs (purement décoratif, aria-hidden) --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 select-none">
        <span class="glow-halo glow-halo--accent w-[420px] h-[420px] -top-24 -right-24"></span>
        <span class="glow-halo glow-halo--primary w-[360px] h-[360px] top-1/2 -left-32"></span>
        <span class="orb orb--filled orb--slow glow-halo--accent w-24 h-24 top-16 left-[12%]"></span>
        <span class="orb orb--outline orb--reverse orb--delay w-16 h-16 bottom-20 right-[18%]"></span>
        <span class="orb orb--filled orb--delay glow-halo--warm w-12 h-12 top-1/3 right-[8%]"></span>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-5 lg:px-10 py-16 lg:py-28">
        <div class="max-w-3xl">
            <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-accent-700 bg-accent-50 border border-accent-200 px-3 py-1 rounded-full mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-accent-500"></span>
                Conformité réglementaire
            </p>
            <h1 class="text-[32px] lg:text-[52px] font-semibold text-dark-900 tracking-tight leading-[1.1] mb-6">
                Décret BACS : rendez votre bâtiment conforme, sereinement
            </h1>
            <p class="text-lg lg:text-xl text-dark-500 leading-relaxed mb-8">
                Le décret BACS impose une GTB pour automatiser et piloter les consommations des bâtiments tertiaires.
                On vous explique qui est concerné, à quelle échéance, et comment vous mettre en règle, sans pression commerciale.
            </p>
            <div class="flex flex-wrap items-center gap-4">
                <a href="/audit" class="btn-primary">
                    Vérifier ma conformité
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="/contact" class="inline-flex items-center gap-1.5 px-6 py-3 text-sm font-medium text-dark-700 border border-dark-300 rounded-lg hover:bg-dark-50 transition-colors">
                    Parler à un expert
                </a>
            </div>
            @include('front.partials.reassurance-badges', ['class' => 'mt-10 justify-start'])
        </div>
    </div>
</section>

{{-- =========================================================================
     COMPRENDRE LE DÉCRET BACS
     ========================================================================= --}}
<section class="py-12 lg:py-24">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">L'essentiel</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Comprendre le décret BACS</h2>
            <p class="text-base text-dark-500 leading-relaxed">Ce qu'impose le texte, ses objectifs et qui doit s'y conformer.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-12">
            <div class="lg:col-span-3">
                <h3 class="text-lg font-medium text-dark-900 mb-3">Qu'est-ce que le décret BACS ?</h3>
                <p class="text-base text-dark-500 leading-relaxed mb-4">
                    Décret n° 2020-887 du 20 juillet 2020, transposant l'article 14 de la
                    <strong class="text-dark-900 font-medium">directive européenne EPBD 2018/844</strong> sur la performance
                    énergétique des bâtiments. Il a été renforcé par le
                    <strong class="text-dark-900 font-medium">décret n° 2023-259 du 7 avril 2023</strong> (abaissement du seuil
                    de puissance à 70 kW), puis modifié par le
                    <strong class="text-dark-900 font-medium">décret n° 2025-1343 du 26 décembre 2025</strong>
                    (report de la tranche 70-290 kW à 2030).
                </p>
                <p class="text-base text-dark-500 leading-relaxed mb-6">
                    Il impose, dans les bâtiments tertiaires non résidentiels, l'installation d'un système d'automatisation
                    et de contrôle (BACS, pour <em>Building Automation &amp; Control Systems</em>) — autrement dit une GTB —
                    atteignant <strong class="text-dark-900 font-medium">a minima la classe B</strong> de la norme
                    NF EN ISO 52120-1 (ex EN 15232).
                </p>

                <h3 class="text-lg font-medium text-dark-900 mb-3">Les objectifs</h3>
                <ul class="text-[15px] text-dark-500 leading-relaxed pl-5 list-disc mb-2 space-y-2">
                    <li>Suivre, enregistrer et analyser les consommations énergétiques par usage.</li>
                    <li>Piloter en temps réel les installations CVC selon l'occupation et les besoins.</li>
                    <li>Détecter les dérives de performance et alerter avant la panne.</li>
                    <li>Communiquer avec les systèmes techniques interconnectés du bâtiment.</li>
                </ul>
            </div>

            <div class="lg:col-span-2 space-y-4">
                <div class="bg-white rounded-2xl p-5 lg:p-7 border border-dark-100 lg:shadow-sm">
                    <p class="text-[11px] font-medium uppercase tracking-widest text-dark-500 mb-2">Niveau requis</p>
                    <p class="text-[28px] font-medium text-accent-600 tracking-tight">Classe B</p>
                    <p class="text-[13px] text-dark-500 mt-1">minimum / norme NF EN ISO 52120-1</p>
                </div>
                <div class="bg-white rounded-2xl p-5 lg:p-7 border border-dark-100 lg:shadow-sm">
                    <p class="text-[11px] font-medium uppercase tracking-widest text-dark-500 mb-2">Seuil de puissance</p>
                    <p class="text-[15px] text-dark-600 leading-relaxed">Puissance nominale utile cumulée des systèmes CVC (chauffage + climatisation), somme de tous les générateurs du bâtiment.</p>
                </div>
                <div class="bg-accent-50 border border-accent-200 rounded-2xl p-5 lg:p-7">
                    <p class="text-xs font-semibold uppercase tracking-widest text-accent-700 mb-2">Dérogation possible</p>
                    <p class="text-[15px] text-dark-600 leading-relaxed">Une dérogation est admise si un audit énergétique démontre un temps de retour sur investissement <strong>supérieur à 6 ans</strong>.</p>
                </div>
            </div>
        </div>

        {{-- Bâtiments concernés / échéances : MOBILE cards + DESKTOP table --}}
        <div class="mt-14">
            <h3 class="text-lg font-medium text-dark-900 mb-4">Bâtiments concernés et échéances</h3>

            {{-- MOBILE : cards stack --}}
            <div class="lg:hidden space-y-3">
                @foreach([
                    ['type' => 'Existant', 'puissance' => '> 290 kW', 'echeance' => 'Depuis le 1er janvier 2025', 'statut' => 'En vigueur', 'color' => 'accent'],
                    ['type' => 'Existant', 'puissance' => '70 à 290 kW', 'echeance' => '1er janvier 2030', 'statut' => 'Reporté (était 2027)', 'color' => 'orange'],
                    ['type' => 'Neuf (permis > 21/07/2021)', 'puissance' => '> 290 kW', 'echeance' => 'À la construction', 'statut' => 'Obligatoire', 'color' => 'accent'],
                    ['type' => 'Neuf (permis > 08/04/2024)', 'puissance' => '> 70 kW', 'echeance' => 'Depuis le 8 avril 2024', 'statut' => 'Obligatoire', 'color' => 'accent'],
                ] as $row)
                <div class="bg-white border border-dark-100 rounded-2xl p-5">
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <p class="text-[15px] font-medium text-dark-900">{{ $row['type'] }}</p>
                        <span class="text-[11px] font-medium px-2.5 py-1 rounded-md border flex-shrink-0 {{ $row['color'] === 'orange' ? 'bg-orange-50 text-orange-800 border-orange-200' : 'bg-accent-50 text-accent-800 border-accent-200' }}">{{ $row['statut'] }}</span>
                    </div>
                    <dl class="space-y-2 text-[13px]">
                        <div class="flex justify-between gap-3">
                            <dt class="text-dark-500">Puissance CVC</dt>
                            <dd class="text-dark-700 font-medium text-right">{{ $row['puissance'] }}</dd>
                        </div>
                        <div class="flex justify-between gap-3">
                            <dt class="text-dark-500">Échéance</dt>
                            <dd class="text-dark-700 font-medium text-right">{{ $row['echeance'] }}</dd>
                        </div>
                    </dl>
                </div>
                @endforeach
            </div>

            {{-- DESKTOP : table --}}
            <div class="hidden lg:block border border-dark-100 rounded-2xl overflow-x-auto">
                <table class="w-full min-w-[640px] border-collapse text-sm">
                    <thead>
                        <tr class="bg-dark-50">
                            <th class="text-left text-[11px] font-medium uppercase tracking-widest text-dark-500 p-3 border-b border-dark-200">Type</th>
                            <th class="text-left text-[11px] font-medium uppercase tracking-widest text-dark-500 p-3 border-b border-dark-200">Puissance CVC</th>
                            <th class="text-left text-[11px] font-medium uppercase tracking-widest text-dark-500 p-3 border-b border-dark-200">Échéance</th>
                            <th class="text-left text-[11px] font-medium uppercase tracking-widest text-dark-500 p-3 border-b border-dark-200">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-dark-100">
                            <td class="p-3.5 font-medium text-dark-900">Existant</td>
                            <td class="p-3.5 text-dark-600">> 290 kW</td>
                            <td class="p-3.5 text-dark-600">Depuis le 1er janvier 2025</td>
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
                            <td class="p-3.5 text-dark-600">Depuis le 8 avril 2024</td>
                            <td class="p-3.5"><span class="text-xs font-medium text-accent-800 bg-accent-50 px-2.5 py-1 rounded-md">Obligatoire</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p class="text-[13px] text-dark-500 mt-4">Échéance 70–290 kW reportée de 2027 à 2030 par le décret n° 2025-1343 du 26 décembre 2025.</p>
        </div>
    </div>
</section>

{{-- =========================================================================
     CTA contextuel mid-page — brique CTA "mince" (cta-slim-banner)
     ========================================================================= --}}
<section class="px-5 lg:px-10">
    <div class="max-w-7xl mx-auto">
        @include('front.bricks.cta-mini.cta-slim-banner', [
            'href' => '/audit',
            'text' => 'Vous ne savez pas quelle ligne s\'applique à votre bâtiment ? Notre pré-diagnostic le détermine en quelques minutes, sans inscription.',
            'linkText' => 'Lancer le pré-diagnostic',
            'storageKey' => 'decret_bacs_mid',
        ])
    </div>
</section>

{{-- =========================================================================
     LES CLASSES GTB (NF EN ISO 52120-1) + ÉCONOMIES (factuel)
     ========================================================================= --}}
<section class="py-12 lg:py-24 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Référentiel technique</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Les classes GTB (NF EN ISO 52120-1)</h2>
            <p class="text-base text-dark-500 leading-relaxed">La norme classe les systèmes de A (la plus performante) à D (aucune automatisation). Le décret BACS impose la classe B minimum.</p>
        </div>

        <div class="grid md:grid-cols-4 gap-3 lg:gap-5 mb-12">
            @foreach([
                ['badge' => 'Classe A', 'bg' => 'bg-dark-800', 'title' => 'Haute performance', 'desc' => 'Régulation pièce par pièce, optimisation multi-lots.', 'sub' => 'Performance maximale', 'eco' => '~35 % vs D', 'highlight' => false],
                ['badge' => 'Classe B', 'bg' => 'bg-accent-600', 'title' => 'Avancé', 'desc' => 'GTB centralisée, suivi énergétique, détection de dérives.', 'sub' => 'Exigence décret BACS', 'eco' => '~25 % vs D', 'highlight' => true],
                ['badge' => 'Classe C', 'bg' => 'bg-dark-500', 'title' => 'Standard', 'desc' => 'Régulation de base et programmation horaire, sans supervision.', 'sub' => 'Minimum neuf', 'eco' => '~10 % vs D', 'highlight' => false],
                ['badge' => 'Classe D', 'bg' => 'bg-dark-600', 'title' => 'Non performant', 'desc' => 'Aucune automatisation, pilotage manuel.', 'sub' => 'Référence basse', 'eco' => '—', 'highlight' => false],
            ] as $cl)
            <div class="{{ $cl['highlight'] ? 'bg-white rounded-2xl border border-accent-200 shadow-[0_0_0_3px] shadow-accent-50' : 'bg-white rounded-2xl border border-dark-100 lg:shadow-sm' }} p-5 lg:p-7 flex flex-col">
                <span class="inline-block self-start text-[13px] font-medium text-white {{ $cl['bg'] }} px-2.5 py-1 rounded-md mb-3.5">{{ $cl['badge'] }}</span>
                <h3 class="text-[17px] font-medium text-dark-900 mb-2">{{ $cl['title'] }}</h3>
                <p class="text-[13px] text-dark-500 leading-relaxed mb-4 flex-1">{{ $cl['desc'] }}</p>
                <p class="text-[13px] {{ $cl['highlight'] ? 'font-medium text-accent-600' : 'text-dark-500' }} mb-1">{{ $cl['sub'] }}</p>
                <p class="text-[20px] font-medium text-dark-900 tracking-tight">{{ $cl['eco'] }}</p>
            </div>
            @endforeach
        </div>

        <p class="text-[13px] text-dark-500">Économies d'énergie estimées par la norme par rapport à un bâtiment de classe D : environ 10 % pour un passage en classe C, environ 25 % en classe B, environ 35 % en classe A. Ordres de grandeur indicatifs, variables selon le bâtiment et ses usages.</p>
    </div>
</section>

{{-- =========================================================================
     NOTRE ACCOMPAGNEMENT (Audit décret BACS) — étapes
     ========================================================================= --}}
<section class="py-12 lg:py-24">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Notre accompagnement</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">L'audit décret BACS, étape par étape</h2>
            <p class="text-base text-dark-500 leading-relaxed">Une démarche neutre, du recueil des données jusqu'au livrable d'audit avec préconisations chiffrées. Aucun matériel vendu, aucune commission.</p>
        </div>

        <ol class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
            @foreach([
                ['n' => '01', 'title' => 'Collecte des données', 'desc' => 'Recueil des consommations, plans, équipements CVC et documentation technique du bâtiment.'],
                ['n' => '02', 'title' => 'Entretien avec l\'exploitant', 'desc' => 'Compréhension des usages, des contraintes d\'exploitation et des dérives constatées au quotidien.'],
                ['n' => '03', 'title' => 'Visite des installations', 'desc' => 'État des lieux sur site : régulation existante, protocoles, architecture et points de comptage.'],
                ['n' => '04', 'title' => 'Analyse et classement', 'desc' => 'Positionnement de l\'installation sur la grille NF EN ISO 52120-1 et identification de l\'écart avec la classe B.'],
                ['n' => '05', 'title' => 'Livrable d\'audit', 'desc' => 'Préconisations techniques et budgétaires hiérarchisées, scénarios de mise en conformité.'],
                ['n' => '06', 'title' => 'Estimation des CEE', 'desc' => 'Chiffrage du potentiel de Certificats d\'Économies d\'Énergie (fiche BAT-TH-116) pour financer le projet.'],
            ] as $step)
            <li class="bg-white rounded-2xl p-5 lg:p-7 border border-dark-100 lg:shadow-sm">
                <p class="text-[28px] font-medium text-accent-600 tracking-tight leading-none mb-3">{{ $step['n'] }}</p>
                <h3 class="text-[15px] font-medium text-dark-900 mb-1.5">{{ $step['title'] }}</h3>
                <p class="text-[13px] text-dark-500 leading-relaxed">{{ $step['desc'] }}</p>
            </li>
            @endforeach
        </ol>
    </div>
</section>

{{-- =========================================================================
     CEE — fiche BAT-TH-116
     ========================================================================= --}}
<section class="py-12 lg:py-24 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Aides financières</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Financer la mise en conformité avec les CEE</h2>
            <p class="text-base text-dark-500 leading-relaxed">Les Certificats d'Économies d'Énergie financent une partie de l'installation GTB. Une fiche standardisée cible directement la GTB.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-4 lg:gap-6">
            <div class="bg-white rounded-2xl p-5 lg:p-7 border border-dark-100 lg:shadow-sm">
                <span class="inline-block text-[13px] font-medium text-orange-800 bg-orange-50 px-3 py-1 rounded-md mb-4">Fiche standardisée</span>
                <h3 class="text-[22px] font-medium text-dark-900 tracking-tight mb-3">BAT-TH-116</h3>
                <p class="text-sm text-dark-500 mb-4">Système de gestion technique du bâtiment pour le chauffage et le refroidissement</p>
                <p class="text-[15px] text-dark-500 leading-relaxed mb-4">Finance l'installation d'une GTB de <strong class="text-dark-900 font-medium">classe A ou B</strong> (NF EN ISO 52120-1) pour le pilotage du CVC. Le montant de la prime dépend de la surface, de la zone climatique et de la classe atteinte.</p>
                <div class="p-3.5 rounded-lg bg-dark-50 border border-dark-200">
                    <p class="text-[13px] text-dark-500 leading-relaxed"><strong class="text-dark-900">Conditions :</strong> bâtiment tertiaire existant, installation par un professionnel, passage en classe A ou B vérifié.</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 lg:p-7 border border-dark-100 lg:shadow-sm">
                <span class="inline-block text-[13px] font-medium text-orange-800 bg-orange-50 px-3 py-1 rounded-md mb-4">Fiche complémentaire</span>
                <h3 class="text-[22px] font-medium text-dark-900 tracking-tight mb-3">BAT-TH-112</h3>
                <p class="text-sm text-dark-500 mb-4">Variation électronique de vitesse sur moteur asynchrone</p>
                <p class="text-[15px] text-dark-500 leading-relaxed mb-4">Couvre l'installation de variateurs de vitesse sur les moteurs CVC (pompes, ventilateurs, compresseurs). Complémentaire à la GTB, qui envoie les consignes de vitesse.</p>
                <div class="p-3.5 rounded-lg bg-dark-50 border border-dark-200">
                    <p class="text-[13px] text-dark-500 leading-relaxed"><strong class="text-dark-900">Conditions :</strong> puissance moteur ≥ 0,55 kW, variateur certifié, installation sur moteur existant ou neuf.</p>
                </div>
            </div>
        </div>

        <div class="bg-accent-50 border border-accent-200 rounded-2xl p-5 lg:p-7 mt-6">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-700 mb-2">Estimation gratuite</p>
            <p class="text-sm text-dark-600 leading-relaxed">Utilisez notre <a href="/generateur-cee" class="text-accent-600 font-medium hover:text-accent-700">générateur CEE</a> pour estimer le montant de vos certificats en 3 minutes, sans intermédiaire.</p>
        </div>
    </div>
</section>

{{-- =========================================================================
     FAQ — questions d'acheteur (alignée sur le JSON-LD ci-dessus)
     ========================================================================= --}}
<section class="py-12 lg:py-24">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Questions fréquentes</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight">Décret BACS : vos questions</h2>
        </div>

        <div class="space-y-4">
            @foreach([
                [
                    'q' => 'Mon bâtiment est-il concerné par le décret BACS ?',
                    'a' => 'Le décret s\'applique aux bâtiments tertiaires non résidentiels selon la puissance nominale cumulée de leurs systèmes CVC. Existant supérieur à 290 kW : obligation depuis le 1er janvier 2025. Existant de 70 à 290 kW : obligation au 1er janvier 2030. Neuf supérieur à 70 kW (permis déposé après le 8 avril 2024) : obligation dès la construction.',
                ],
                [
                    'q' => 'Quelle classe de GTB faut-il atteindre ?',
                    'a' => 'La classe B minimum au sens de la norme NF EN ISO 52120-1 (ex EN 15232). La classe C correspond seulement au minimum exigé pour le neuf au titre d\'autres réglementations ; la classe A représente le niveau de performance le plus élevé.',
                ],
                [
                    'q' => 'Combien ça coûte et quels CEE sont mobilisables ?',
                    'a' => 'Le coût dépend de la surface, de l\'architecture technique et de la classe visée. La fiche CEE BAT-TH-116 finance une GTB de classe A ou B sur un bâtiment tertiaire existant, en complément de la fiche BAT-TH-112. Le montant exact se chiffre au cas par cas après audit.',
                ],
                [
                    'q' => 'Que risque-t-on en cas de non-conformité ?',
                    'a' => 'Une dérogation au décret BACS est possible si un audit énergétique démontre un temps de retour sur investissement supérieur à 6 ans. À noter : l\'amende pouvant atteindre 7 500 € par bâtiment pour une personne morale, ainsi que la publication du nom du contrevenant, relèvent du décret tertiaire (Éco Énergie Tertiaire), pas du décret BACS lui-même.',
                ],
            ] as $faq)
            <details class="group bg-white rounded-2xl border border-dark-100 lg:shadow-sm overflow-hidden">
                <summary class="flex items-center justify-between gap-4 p-5 lg:p-7 cursor-pointer list-none">
                    <h3 class="text-[15px] lg:text-base font-medium text-dark-900">{{ $faq['q'] }}</h3>
                    <svg class="w-5 h-5 text-dark-400 flex-shrink-0 transition-transform duration-200 group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                </summary>
                <div class="px-5 lg:px-7 pb-5 lg:pb-7 -mt-1">
                    <p class="text-[15px] text-dark-500 leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            </details>
            @endforeach
        </div>
    </div>
</section>

{{-- =========================================================================
     CTA FINAL — "Vérifier ma conformité" → /audit
     ========================================================================= --}}
<section class="relative overflow-hidden py-14 lg:py-24 bg-dark-50 border-t border-dark-200">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 select-none">
        <span class="glow-halo glow-halo--accent w-[360px] h-[360px] -bottom-24 -right-16"></span>
        <span class="orb orb--outline orb--slow w-20 h-20 top-10 left-[10%]"></span>
    </div>
    <div class="relative z-10 max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-2xl">
            <h2 class="text-[24px] lg:text-[32px] font-semibold text-dark-900 tracking-tight leading-tight mb-3">Vérifiez votre conformité au décret BACS</h2>
            <p class="text-base lg:text-lg text-dark-500 leading-relaxed mb-8">Identifiez votre classe NF EN ISO 52120-1, situez votre échéance et estimez vos aides CEE. Pré-diagnostic gratuit, sans inscription.</p>
            <div class="flex flex-wrap items-center gap-4">
                <a href="/audit" class="btn-primary">
                    Vérifier ma conformité
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="/contact" class="inline-flex items-center gap-1.5 px-6 py-3 text-sm font-medium text-dark-700 border border-dark-300 rounded-lg hover:bg-dark-50 transition-colors">
                    Parler à un expert
                </a>
            </div>
        </div>
    </div>
</section>

{{-- =========================================================================
     PAGES LIÉES
     ========================================================================= --}}
<section class="py-12 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="grid md:grid-cols-3 gap-4 lg:gap-6">
            @foreach([
                ['href' => '/reglementation', 'title' => 'Toute la réglementation GTB', 'desc' => 'Décret BACS, décret tertiaire, RE2020, EPBD : le cadre complet et le calendrier.'],
                ['href' => '/audit', 'title' => 'Pré-diagnostic GTB gratuit', 'desc' => 'Évaluez votre conformité NF EN ISO 52120-1 en quelques minutes.'],
                ['href' => '/generateur-cee', 'title' => 'Simulateur CEE', 'desc' => 'Estimez vos primes Certificats d\'Économies d\'Énergie (BAT-TH-116).'],
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
