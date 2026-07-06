@extends('front.layouts.app')

{{-- SEO : repli ici en attendant une entrée DEFAULT_SEO['amo-gtb-gtc'] côté controller (hors périmètre). --}}
@section('title', 'AMO GTB/GTC indépendante, sécurisez votre projet | NeoGTB')
@section('description', "Assistance à maîtrise d'ouvrage GTB/GTC 100 % indépendante : analyse de l'existant, cahier des charges neutre, pilotage. Zéro matériel vendu, zéro commission.")

{{-- JSON-LD FAQPage (exempté CSP — poussé via @push('schema'), rendu dans le <head> par le layout).
     Réponses alignées sur les faits NeoGTB. R1 : registre factuel, jamais "jusqu'à 35 %". --}}
@push('schema')
<script type="application/ld+json" @cspNonce>
@verbatim
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        {"@type":"Question","name":"Qu'est-ce qu'une mission AMO GTB / GTC ?","acceptedAnswer":{"@type":"Answer","text":"Une Assistance à Maîtrise d'Ouvrage qui accompagne le maître d'ouvrage dans la conception, le déploiement et l'exploitation de son système de gestion technique, pour garantir une installation performante, interopérable et conforme."}},
        {"@type":"Question","name":"Pourquoi un AMO indépendant pour un projet GTB ?","acceptedAnswer":{"@type":"Answer","text":"Parce qu'un AMO indépendant sécurise les choix techniques sans aucun intérêt à vous vendre une marque plutôt qu'une autre. Chez NeoGTB, le revenu vient exclusivement du conseil — jamais du matériel ni de commissions."}},
        {"@type":"Question","name":"Quelle différence entre GTB et GTC ?","acceptedAnswer":{"@type":"Answer","text":"La GTB (Gestion Technique du Bâtiment) supervise l'ensemble des équipements techniques. La GTC (Gestion Technique Centralisée) désigne un périmètre plus restreint ou spécifique. Les deux sont aujourd'hui souvent utilisées conjointement."}},
        {"@type":"Question","name":"Quels équipements une GTB peut-elle piloter ?","acceptedAnswer":{"@type":"Answer","text":"Chauffage, ventilation, climatisation (CVC), éclairage, comptage énergétique, sécurité, contrôle d'accès et autres installations techniques."}},
        {"@type":"Question","name":"Quels bénéfices d'une GTB performante ?","acceptedAnswer":{"@type":"Answer","text":"Selon la norme NF EN ISO 52120-1, les économies d'énergie estimées sont d'environ 10 % en passant d'une classe D à une classe C, environ 25 % de D à B, et environ 35 % de D à A. S'y ajoutent plus de confort, une maintenance anticipée et des dérives détectées plus tôt."}},
        {"@type":"Question","name":"L'AMO NeoGTB est-elle vraiment indépendante ?","acceptedAnswer":{"@type":"Answer","text":"Oui. Aucune vente de matériel, aucun partenariat commercial avec un fabricant, aucune commission. C'est notre différence avec un bureau d'études classique."}},
        {"@type":"Question","name":"Quelles obligations réglementaires liées à la GTB ?","acceptedAnswer":{"@type":"Answer","text":"Le décret BACS impose des fonctions d'automatisation (art. R. 175-3 du CCH), pas une classe ; la classe B (NF EN ISO 52120-1) est le niveau couramment visé et la condition de la prime CEE. Échéances : depuis le 1er janvier 2025 pour les bâtiments de plus de 290 kW, au 1er janvier 2030 pour ceux entre 70 et 290 kW. Le décret tertiaire impose -40 % en 2030, -50 % en 2040 et -60 % en 2050."}},
        {"@type":"Question","name":"À quel moment faire intervenir un AMO ?","acceptedAnswer":{"@type":"Answer","text":"Idéalement dès les premières phases du projet — mais aussi en cours de route pour corriger, optimiser ou valider la conformité d'une installation existante."}}
    ]
}
@endverbatim
</script>
@endpush

@section('content')

{{-- ============================================================
     HERO — LIGHT MODE. Titre en PROMESSE (#111827 / text-dark-900),
     fond clair, AUCUN overlay sombre, AUCUNE classe dark:.
     Décor : glow-halo + orbs (dimensions fixes w/h => pas de CLS ;
     prefers-reduced-motion géré globalement dans app.css).
     ============================================================ --}}
<section class="relative overflow-hidden bg-white pt-12 lg:pt-20 pb-12 lg:pb-16">
    {{-- Décor purement esthétique, hors flux, masqué aux lecteurs d'écran --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden">
        <span class="glow-halo glow-halo--accent" style="width:480px;height:480px;top:-160px;right:-120px;"></span>
        <span class="glow-halo glow-halo--primary" style="width:360px;height:360px;bottom:-180px;left:-100px;"></span>
        <span class="orb orb--outline orb--slow" style="width:140px;height:140px;top:48px;right:18%;"></span>
        <span class="orb orb--filled orb--reverse orb--delay" style="width:90px;height:90px;bottom:64px;left:14%;"></span>
    </div>

    <div class="max-w-7xl mx-auto px-5 lg:px-10 relative z-10">
        <div class="max-w-3xl">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">AMO GTB / GTC</p>
            <h1 class="font-heading text-[32px] lg:text-[48px] font-medium text-dark-900 leading-[1.1] tracking-tight mb-5">
                Sécurisez votre projet de gestion technique du bâtiment, de A à Z
            </h1>
            <p class="text-[17px] lg:text-[19px] text-dark-500 leading-relaxed max-w-2xl mb-8">
                Une assistance à maîtrise d'ouvrage 100 % indépendante pour cadrer, piloter et
                réceptionner votre GTB/GTC. <strong class="text-dark-700 font-medium">Aucun matériel vendu,
                aucune commission</strong> : nous défendons vos intérêts, pas ceux d'un fabricant.
            </p>
            <div class="flex flex-wrap items-center gap-4">
                <a href="/contact" class="btn-primary btn-glow">
                    Parler à un expert
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="/audit" class="inline-flex items-center gap-1.5 px-6 py-3 text-sm font-medium text-dark-600 border border-dark-300 rounded-lg hover:bg-dark-50 transition-colors">
                    Lancer un pré-diagnostic
                </a>
            </div>
        </div>

        {{-- Ligne de réassurance partagée (Indépendant · 0 commission · 0 matériel · ISO 52120-1 · 0 cookie) --}}
        @include('front.partials.reassurance-badges', ['class' => 'mt-10 justify-start'])
    </div>
</section>

{{-- ============================================================
     LES ENJEUX — pourquoi cadrer un projet GTB
     ============================================================ --}}
<section class="py-10 lg:py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="grid md:grid-cols-2 gap-10 lg:gap-16 items-start">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Les enjeux</p>
                <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-4">
                    Un projet GTB mal cadré coûte cher, longtemps
                </h2>
                <p class="text-base text-dark-500 leading-relaxed">
                    Surcoûts, dérives de planning, choix techniques imposés par un fournisseur, système
                    final sous-exploité ou impossible à faire évoluer : les écueils d'un projet de gestion
                    technique sont connus. Notre rôle d'AMO est précisément de les éviter, en gardant la
                    décision technique du côté du maître d'ouvrage.
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 lg:gap-4">
                @foreach([
                    ['title' => 'Sans cadrage', 'desc' => 'Cahier des charges flou, périmètre qui dérive, budget qui dérape.'],
                    ['title' => 'Sans neutralité', 'desc' => 'Solution dictée par un fabricant, verrouillage technologique.'],
                    ['title' => 'Sans pilotage', 'desc' => 'Offres incomparables, mise en œuvre non vérifiée, performances non tenues.'],
                    ['title' => 'Avec NeoGTB', 'desc' => 'Besoins clairs, exigences neutres, performances vérifiées à la réception.', 'highlight' => true],
                ] as $enjeu)
                <div class="{{ ($enjeu['highlight'] ?? false) ? 'bg-white border border-accent-200 shadow-[0_0_0_3px] shadow-accent-50' : 'bg-white border border-dark-100 lg:shadow-sm' }} rounded-2xl p-5">
                    <p class="text-[15px] font-medium {{ ($enjeu['highlight'] ?? false) ? 'text-accent-600' : 'text-dark-900' }} mb-1.5">{{ $enjeu['title'] }}</p>
                    <p class="text-[13px] text-dark-500 leading-relaxed">{{ $enjeu['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     NOTRE MISSION AMO — 4 PILIERS
     ============================================================ --}}
<section class="py-10 lg:py-20">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Notre mission</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">
                Quatre piliers pour une GTB maîtrisée
            </h2>
            <p class="text-base text-dark-500 leading-relaxed">
                De l'état des lieux jusqu'à la vérification des performances, nous couvrons tout le
                cycle du projet, sans jamais vous engager auprès d'une marque.
            </p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            @foreach([
                ['n' => '01', 'title' => "Analyse de l'existant", 'desc' => 'Audit des installations CVC, des protocoles (BACnet, Modbus, KNX) et de l\'architecture en place.'],
                ['n' => '02', 'title' => 'Définition des besoins', 'desc' => 'Équipements à superviser, fonctions de pilotage, suivi énergétique et interfaces attendues.'],
                ['n' => '03', 'title' => 'Cahier des charges neutre', 'desc' => 'Exigences de performance, d\'interopérabilité, de cybersécurité et d\'exploitation, sans orientation fabricant.'],
                ['n' => '04', 'title' => 'Pilotage du projet', 'desc' => 'Consultation des entreprises, analyse des offres, suivi de mise en œuvre et vérification des performances.'],
            ] as $pilier)
            <div class="bg-white rounded-2xl p-5 lg:p-7 border border-dark-100 lg:shadow-sm card-hover-glow">
                <span class="text-[28px] font-medium text-accent-600 tracking-tight leading-none">{{ $pilier['n'] }}</span>
                <h3 class="text-[17px] font-medium text-dark-900 mt-3 mb-2">{{ $pilier['title'] }}</h3>
                <p class="text-[13px] text-dark-500 leading-relaxed">{{ $pilier['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     LES 4 ÉTAPES CLÉS — méthodologie numérotée
     ============================================================ --}}
<section class="py-10 lg:py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Méthodologie</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">
                Les 4 étapes clés de la mission
            </h2>
            <p class="text-base text-dark-500 leading-relaxed">
                Une démarche structurée, du besoin jusqu'au contrat d'exploitation, livrables à l'appui.
            </p>
        </div>
        <ol class="grid md:grid-cols-2 gap-4 lg:gap-6">
            @foreach([
                ['n' => '1', 'title' => 'Définition des besoins et objectifs', 'desc' => 'Périmètre de supervision, reporting attendu, interfaces avec les systèmes existants.'],
                ['n' => '2', 'title' => 'État des lieux et diagnostic', 'desc' => 'Inventaire des équipements, de la régulation, des protocoles et des limites de l\'installation.'],
                ['n' => '3', 'title' => 'Planification technique & budgétaire', 'desc' => 'Architecture cible, phasage, estimation CAPEX/OPEX et identification des CEE (BAT-TH-116).'],
                ['n' => '4', 'title' => 'Cadrage des contrats d\'exploitation', 'desc' => 'Répartition des responsabilités, KPI de suivi et objectifs énergétiques contractualisés.'],
            ] as $etape)
            <li class="flex gap-5 bg-white rounded-2xl p-5 lg:p-7 border border-dark-100 lg:shadow-sm">
                <span class="flex-shrink-0 w-11 h-11 rounded-full bg-accent-600 text-white text-[17px] font-medium flex items-center justify-center" aria-hidden="true">{{ $etape['n'] }}</span>
                <div>
                    <h3 class="text-[17px] font-medium text-dark-900 mb-1.5">{{ $etape['title'] }}</h3>
                    <p class="text-[13px] text-dark-500 leading-relaxed">{{ $etape['desc'] }}</p>
                </div>
            </li>
            @endforeach
        </ol>
    </div>
</section>

{{-- ============================================================
     POURQUOI NEOGTB — indépendance matérialisée (0 matériel, 0 commission)
     ============================================================ --}}
<section class="py-10 lg:py-20">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="grid md:grid-cols-2 gap-10 lg:gap-16 items-center">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Pourquoi NeoGTB</p>
                <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-4">
                    Un AMO du côté du maître d'ouvrage, point
                </h2>
                <p class="text-base text-dark-500 leading-relaxed mb-4">
                    Un bureau d'études classique peut être rémunéré par un fabricant, revendre du matériel
                    ou toucher une commission sur l'installation. Pas nous. Notre revenu vient
                    <strong class="text-dark-900 font-medium">exclusivement du conseil</strong> : la solution
                    que nous recommandons est celle qui sert votre bâtiment, pas notre marge.
                </p>
                <p class="text-base text-dark-500 leading-relaxed">
                    C'est la différence concrète entre une AMO indépendante et un intégrateur déguisé en conseil.
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 lg:gap-4">
                @foreach([
                    ['stat' => '0', 'label' => 'matériel vendu', 'desc' => 'Aucune revente d\'équipement, aucun stock à écouler.'],
                    ['stat' => '0', 'label' => 'commission', 'desc' => 'Aucun pourcentage sur l\'installation ou la maintenance.'],
                    ['stat' => '0', 'label' => 'lien fabricant', 'desc' => 'Aucun partenariat commercial rémunéré avec une marque.'],
                    ['stat' => '100 %', 'label' => 'côté maître d\'ouvrage', 'desc' => 'Vos intérêts sont les seuls que nous défendons.'],
                ] as $proof)
                <div class="bg-dark-50 rounded-2xl p-5 lg:p-7 border border-dark-100">
                    <p class="text-[32px] font-medium text-accent-600 tracking-tight leading-none">{{ $proof['stat'] }}</p>
                    <p class="text-[13px] font-medium text-dark-900 mt-1.5">{{ $proof['label'] }}</p>
                    <p class="text-[13px] text-dark-500 leading-relaxed mt-1.5">{{ $proof['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     FAQ — 8 Q/R, accordéon Alpine CSP (méthode déclarée, pas d'expression inline)
     Le JSON-LD FAQPage correspondant est poussé via @push('schema') en tête de fichier.
     ============================================================ --}}
<section class="py-10 lg:py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-[720px] mx-auto px-5 lg:px-10">
        <div class="mb-10">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Questions fréquentes</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight">
                Tout savoir sur l'AMO GTB/GTC
            </h2>
        </div>

        @foreach([
            ['q' => "Qu'est-ce qu'une mission AMO GTB / GTC ?", 'a' => "Une Assistance à Maîtrise d'Ouvrage qui accompagne le maître d'ouvrage dans la conception, le déploiement et l'exploitation de son système de gestion technique, pour garantir une installation performante, interopérable et conforme."],
            ['q' => "Pourquoi un AMO <em>indépendant</em> pour un projet GTB ?", 'a' => "Parce qu'un AMO indépendant sécurise les choix techniques sans aucun intérêt à vous vendre une marque plutôt qu'une autre. Chez NeoGTB, le revenu vient exclusivement du conseil — jamais du matériel ni de commissions."],
            ['q' => "Quelle différence entre GTB et GTC ?", 'a' => "La GTB (Gestion Technique du Bâtiment) supervise l'ensemble des équipements techniques. La GTC (Gestion Technique Centralisée) désigne un périmètre plus restreint ou spécifique. Les deux sont aujourd'hui souvent utilisées conjointement. Voir nos pages <a href=\"/gtb\" class=\"text-accent-600 font-medium hover:text-accent-700\">GTB</a> et <a href=\"/gtc\" class=\"text-accent-600 font-medium hover:text-accent-700\">GTC</a>."],
            ['q' => "Quels équipements une GTB peut-elle piloter ?", 'a' => "Chauffage, ventilation, climatisation (CVC), éclairage, comptage énergétique, sécurité, contrôle d'accès et autres installations techniques."],
            ['q' => "Quels bénéfices d'une GTB performante ?", 'a' => "Selon la norme NF EN ISO 52120-1, les économies d'énergie estimées sont d'environ 10 % en passant d'une classe D à une classe C, environ 25 % de D à B, et environ 35 % de D à A. S'y ajoutent plus de confort, une maintenance anticipée et des dérives détectées plus tôt."],
            ['q' => "L'AMO NeoGTB est-elle vraiment indépendante ?", 'a' => "Oui. Aucune vente de matériel, aucun partenariat commercial avec un fabricant, aucune commission. C'est notre différence avec un bureau d'études classique."],
            ['q' => "Quelles obligations réglementaires liées à la GTB ?", 'a' => "Le décret BACS impose des <strong>fonctions d'automatisation</strong> (art. R. 175-3 du CCH), pas une classe ; la <strong>classe B</strong> (NF EN ISO 52120-1) est le niveau couramment visé et la condition de la prime CEE. Échéances : depuis le <strong>1er janvier 2025</strong> pour les bâtiments de plus de 290 kW, au <strong>1er janvier 2030</strong> pour ceux entre 70 et 290 kW. Le décret tertiaire impose -40 % en 2030, -50 % en 2040 et -60 % en 2050. Détails sur notre page <a href=\"/reglementation\" class=\"text-accent-600 font-medium hover:text-accent-700\">réglementation</a>."],
            ['q' => "À quel moment faire intervenir un AMO ?", 'a' => "Idéalement dès les premières phases du projet — mais aussi en cours de route pour corriger, optimiser ou valider la conformité d'une installation existante."],
        ] as $faq)
        <div x-data="{ open: false }" class="border-t border-dark-200 @if($loop->last) border-b @endif">
            <button type="button" @click="open = !open" :aria-expanded="open ? 'true' : 'false'" class="w-full flex items-center justify-between py-5 min-h-[56px] text-left bg-transparent border-none cursor-pointer">
                <span class="text-[15px] font-medium text-dark-900 pr-4">{!! $faq['q'] !!}</span>
                <svg :class="open && 'rotate-180'" class="w-4 h-4 text-dark-500 transition-transform duration-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="open" x-collapse>
                <p class="text-sm text-dark-500 leading-relaxed pb-5">@php $safe_a = ($faq['a'] !== strip_tags($faq['a'])) ? \Stevebauman\Purify\Facades\Purify::clean($faq['a']) : e($faq['a']); @endphp{!! $safe_a !!}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- ============================================================
     CTA FINAL — "Parler à un expert" → /contact (aucun Calendly, aucun cookie tiers)
     ============================================================ --}}
<section class="relative overflow-hidden py-12 lg:py-24 bg-white">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden">
        <span class="glow-halo glow-halo--accent" style="width:420px;height:420px;top:-140px;left:50%;transform:translateX(-50%);"></span>
    </div>
    <div class="max-w-3xl mx-auto px-5 lg:px-10 relative z-10 text-center">
        <h2 class="text-[24px] lg:text-[32px] font-medium text-dark-900 tracking-tight leading-tight mb-4">
            Un projet GTB/GTC à sécuriser ?
        </h2>
        <p class="text-base lg:text-[17px] text-dark-600 leading-relaxed mb-8 max-w-xl mx-auto">
            Échangez avec un expert indépendant sur votre projet. Sans démarche commerciale,
            réponse sous 48&nbsp;h ouvrées.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="/contact" class="btn-primary btn-glow">
                Parler à un expert
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
            <a href="/audit" class="inline-flex items-center gap-1.5 px-6 py-3 text-sm font-medium text-dark-600 border border-dark-300 rounded-lg hover:bg-dark-50 transition-colors">
                Lancer un pré-diagnostic
            </a>
        </div>
        @include('front.partials.reassurance-badges', ['class' => 'mt-10'])
    </div>
</section>

{{-- Pages liées --}}
<section class="py-12 lg:py-24 bg-dark-50 border-t border-dark-200">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="grid md:grid-cols-3 gap-4 lg:gap-6">
            @foreach([
                ['href' => '/reglementation', 'title' => 'Réglementation GTB', 'desc' => 'Décret BACS, décret tertiaire, ISO 52120-1 : échéances et obligations.'],
                ['href' => '/audit', 'title' => 'Pré-diagnostic GTB', 'desc' => 'Évaluez votre niveau de conformité ISO 52120-1 en quelques minutes.'],
                ['href' => '/positionnement', 'title' => 'Notre indépendance', 'desc' => 'Les preuves concrètes : 0 commission, 0 affiliation, 0 revente de données.'],
            ] as $link)
            <a href="{{ $link['href'] }}" class="block bg-white rounded-2xl p-5 lg:p-7 border border-dark-100 card-hover-glow">
                <h3 class="text-[15px] font-medium text-dark-900 mb-1">{{ $link['title'] }}</h3>
                <p class="text-sm text-dark-500">{{ $link['desc'] }}</p>
            </a>
            @endforeach
        </div>
    </div>
</section>

@endsection
