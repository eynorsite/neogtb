@extends('front.layouts.app')

@section('title', 'Solutions GTB : protocoles BACnet, KNX, Modbus')
@section('description', 'Comparatif indépendant des protocoles GTB (BACnet, KNX, Modbus, LON), capteurs et automates. Guide sans lien commercial.')

@section('content')

<!-- HERO IMAGE -->
<x-front.shared.hero
    image="/images/hero-solutions.webp"
    imageAlt="Technologies GTB — capteurs IoT, protocoles et supervision connectée"
    eyebrow="Technologies"
    title="Solutions & technologies GTB"
    highlight="GTB"
    subtitle="Les protocoles de communication, capteurs, contrôleurs et superviseurs qui composent un système de gestion technique du bâtiment. Architecture ouverte et interopérable."
    :tags="['BACnet', 'KNX', 'Modbus']"
    minHeight="480px"
    overlay="gradient"
/>

<!-- PROTOCOLES DE COMMUNICATION -->
<section class="py-12 md:py-16">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="mb-10">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Fondations</p>
            <h2 class="text-[28px] font-medium text-dark-900 leading-tight tracking-tight">Protocoles de communication</h2>
            <p class="mt-3 text-sm text-dark-500 max-w-xl leading-relaxed">Le protocole est le langage commun entre équipements. Le choix du protocole conditionne l'interopérabilité, la maintenabilité et la pérennité de l'installation.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-5">
            @php
            $protocols = [
                ['tag' => 'ISO 16484-5', 'name' => 'BACnet', 'desc' => 'Standard international de la GTB, maintenu par l\'ASHRAE. Deux déclinaisons principales : <strong class="font-medium text-dark-700">BACnet IP</strong> pour les réseaux Ethernet et <strong class="font-medium text-dark-700">BACnet MS/TP</strong> pour les bus RS-485 en terrain. Le protocole définit un modèle objet unifié qui permet l\'interopérabilité entre équipements de marques différentes sans passerelle propriétaire.', 'tags' => ['Interopérabilité multi-marques', 'IP / MS/TP', 'ASHRAE 135']],
                ['tag' => 'EN 50090 / ISO/IEC 14543', 'name' => 'KNX', 'desc' => 'Standard européen pour l\'automatisation du bâtiment. Le médium principal est le <strong class="font-medium text-dark-700">bus filaire TP</strong> (twisted pair). Plus de 500 fabricants certifiés par l\'Association KNX. Particulièrement adapté à l\'éclairage, la gestion des stores et le CVC en résidentiel et petit tertiaire.', 'tags' => ['500+ fabricants', 'Bus TP', 'Éclairage / Stores / CVC']],
                ['tag' => 'RTU / TCP', 'name' => 'Modbus', 'desc' => 'Protocole industriel créé par Modicon en 1979, devenu un standard de fait. Simple et robuste, existe en <strong class="font-medium text-dark-700">Modbus RTU</strong> sur RS-485 et <strong class="font-medium text-dark-700">Modbus TCP</strong> sur Ethernet. Architecture maître-esclave. Dominant pour le comptage énergie.', 'tags' => ['Industriel / 1979', 'RS-485 / Ethernet', 'Comptage énergie']],
                ['tag' => 'EN 14908', 'name' => 'LON', 'desc' => 'Local Operating Network, conçu par Echelon. Architecture <strong class="font-medium text-dark-700">peer-to-peer</strong> : chaque noeud embarque sa propre intelligence. Historiquement très utilisé en GTB tertiaire. En déclin face à BACnet IP, mais encore présent dans le parc existant.', 'tags' => ['Peer-to-peer', 'Parc existant', 'Migration BACnet']],
                ['tag' => 'IEC 62386', 'name' => 'DALI / DALI-2', 'desc' => 'Standard international dédié au <strong class="font-medium text-dark-700">pilotage de l\'éclairage</strong>. DALI-2 apporte l\'interopérabilité certifiée entre ballasts, capteurs de présence et luxmètres. Jusqu\'à 64 appareils par ligne, adressage individuel, gradation fine.', 'tags' => ['Éclairage dédié', '64 appareils/ligne', 'Gradation fine']],
                ['tag' => 'IoT / Cloud', 'name' => 'MQTT & API REST', 'desc' => 'Protocoles issus du monde IT, de plus en plus présents en GTB pour <strong class="font-medium text-dark-700">l\'interopérabilité cloud</strong>, les jumeaux numériques et l\'hypervision multi-sites. MQTT est léger et adapté aux capteurs IoT. Les API REST permettent l\'intégration avec les plateformes de GMAO, ERP et analytics.', 'tags' => ['Publish/Subscribe', 'Cloud natif', 'Jumeaux numériques']],
                ['tag' => 'ISO/IEC 14543-3-10', 'name' => 'EnOcean', 'desc' => 'Technologie <strong class="font-medium text-dark-700">sans fil et sans pile</strong> basée sur la récupération d\'énergie (piézoélectrique, solaire, thermique). Idéale pour la <strong class="font-medium text-dark-700">rénovation</strong> où le câblage est impossible ou coûteux.', 'tags' => ['Sans fil / Sans pile', 'Rénovation', 'Energy harvesting']],
            ];
            @endphp
            @foreach($protocols as $proto)
            <div class="rounded-xl p-6 border border-dark-100 card-hover bg-white">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-xs font-medium px-2 py-0.5 rounded bg-primary-50 text-primary-700 border border-primary-100">{{ $proto['tag'] }}</span>
                </div>
                <h3 class="text-lg font-medium text-dark-900 tracking-tight">{{ $proto['name'] }}</h3>
                <p class="mt-2 text-sm text-dark-500 leading-relaxed">{!! $proto['desc'] !!}</p>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach($proto['tags'] as $t)
                    <span class="text-xs font-medium px-2 py-0.5 rounded bg-dark-50 text-dark-600 border border-dark-100">{{ $t }}</span>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        @include('front.bricks.cta-mini.cta-inline-mini-card', ['href' => '/tables-modbus', 'eyebrow' => 'Référence technique', 'text' => 'Adresses, registres, fonctions : notre catalogue Modbus couvre 19 équipements types.', 'linkText' => 'Voir les tables'])
    </div>
</section>

<!-- EQUIPEMENTS PILOTES -->
<section class="py-12 md:py-16 bg-dark-50">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="mb-10">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Périmètre</p>
            <h2 class="text-[28px] font-medium text-dark-900 leading-tight tracking-tight">Équipements pilotés</h2>
            <p class="mt-3 text-sm text-dark-500 max-w-xl leading-relaxed">La GTB supervise et régule l'ensemble des lots techniques d'un bâtiment.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach([
                ['num' => 'Lot 01', 'title' => 'CVC — Chauffage, ventilation, climatisation', 'desc' => 'Régulation des centrales de traitement d\'air, chaudières, groupes froids, ventilo-convecteurs. Le lot CVC représente en moyenne 50 à 60 % de la consommation énergétique d\'un bâtiment tertiaire.'],
                ['num' => 'Lot 02', 'title' => 'Éclairage', 'desc' => 'Gestion des circuits d\'éclairage par zones, horloges, détection de présence et mesure de luminosité. Pilotage DALI ou 0-10V. Gradation automatique selon l\'apport de lumière naturelle.'],
                ['num' => 'Lot 03', 'title' => 'Stores et BSO', 'desc' => 'Brise-soleil orientables, stores intérieurs et extérieurs. Pilotage selon l\'ensoleillement, la température intérieure et les scénarios d\'occupation.'],
                ['num' => 'Lot 04', 'title' => 'Contrôle d\'accès', 'desc' => 'Gestion des lecteurs de badges, interphones, portiques et issues de secours. Intégration avec la GTB pour adapter la régulation CVC et éclairage en fonction de l\'occupation réelle.'],
                ['num' => 'Lot 05', 'title' => 'Comptage énergie', 'desc' => 'Sous-comptage électrique, thermique, gaz et eau. Remontée des index en temps réel vers le superviseur. Base du suivi énergétique exigé par le décret tertiaire (OPERAT).'],
                ['num' => 'Lot 06', 'title' => 'Sécurité incendie', 'desc' => 'Report des alarmes SSI vers le superviseur GTB. Commandes de désenfumage, coupures CVC sur détection. Le SSI conserve sa propre autonomie conformément aux normes NF S 61-932.'],
            ] as $lot)
            <div class="rounded-xl bg-white p-5 border border-dark-100 card-hover">
                <p class="text-[11px] font-medium text-dark-400 uppercase tracking-wider mb-2">{{ $lot['num'] }}</p>
                <h3 class="text-base font-medium text-dark-900 tracking-tight">{{ $lot['title'] }}</h3>
                <p class="mt-2 text-sm text-dark-500 leading-relaxed">{{ $lot['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ARCHITECTURE TYPE -->
<section class="py-12 md:py-16">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="mb-10">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Structure</p>
            <h2 class="text-[28px] font-medium text-dark-900 leading-tight tracking-tight">Architecture type d'un système GTB</h2>
            <p class="mt-3 text-sm text-dark-500 max-w-xl leading-relaxed">Un système GTB s'organise en couches successives, du terrain jusqu'à l'interface utilisateur.</p>
        </div>
        <div class="grid md:grid-cols-5 gap-4">
            @foreach([
                ['num' => 'Couche 1', 'title' => 'Capteurs & actionneurs', 'desc' => 'Sondes de température, détecteurs, vannes, registres, variateurs. Points physiques du terrain.'],
                ['num' => 'Couche 2', 'title' => 'Automates & contrôleurs', 'desc' => 'Contrôleurs DDC (Direct Digital Control). Exécutent la régulation en autonomie locale.'],
                ['num' => 'Couche 3', 'title' => 'Réseau', 'desc' => 'IP (Ethernet, fibre) pour le backbone. Bus terrain (RS-485, TP) pour les boucles locales.'],
                ['num' => 'Couche 4', 'title' => 'Superviseur GTB', 'desc' => 'Serveur central qui agrège les données, historise, génère les alarmes et fournit les synoptiques.'],
                ['num' => 'Couche 5', 'title' => 'Interface utilisateur', 'desc' => 'Tableaux de bord, rapports, alertes. Accessible depuis un navigateur ou une application mobile.'],
            ] as $layer)
            <div class="rounded-xl p-5 text-center border border-dark-100 card-hover bg-white">
                <p class="text-[11px] font-medium text-accent-700 uppercase tracking-wider mb-3">{{ $layer['num'] }}</p>
                <h3 class="text-[15px] font-medium text-dark-900 tracking-tight">{{ $layer['title'] }}</h3>
                <p class="mt-2 text-[13px] text-dark-500 leading-relaxed">{{ $layer['desc'] }}</p>
            </div>
            @endforeach
        </div>
        <div class="bg-accent-50 border border-accent-200 rounded-xl p-6 mt-8">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-700 mb-2">Principe clé</p>
            <p class="text-sm text-dark-600 leading-relaxed">Chaque couche doit pouvoir fonctionner de manière autonome en cas de défaillance de la couche supérieure. Les automates continuent de réguler même si le superviseur est hors service.</p>
        </div>
    </div>
</section>

<!-- CADRE REGLEMENTAIRE -->
<section class="py-12 md:py-16 bg-dark-50">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="mb-10">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Réglementation</p>
            <h2 class="text-[28px] font-medium text-dark-900 leading-tight tracking-tight">Cadre réglementaire</h2>
            <p class="mt-3 text-sm text-dark-500 max-w-xl leading-relaxed">Plusieurs textes réglementaires français et européens encadrent le déploiement de systèmes GTB dans les bâtiments tertiaires.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-5">
            @foreach([
                ['tag' => 'Obligatoire', 'title' => 'Décret BACS', 'desc' => 'Transposition de la directive européenne EPBD. Impose l\'installation d\'un système BACS dans les bâtiments tertiaires dont la puissance CVC dépasse 290 kW (2025) puis 70 kW (2030). Niveau minimum : classe B ISO 52120-1.'],
                ['tag' => 'Obligatoire', 'title' => 'Décret tertiaire (Éco Énergie Tertiaire)', 'desc' => 'Objectifs de réduction des consommations d\'énergie finale des bâtiments tertiaires de plus de 1 000 m2 : -40 % en 2030, -50 % en 2040, -60 % en 2050. Déclaration annuelle sur la plateforme OPERAT de l\'ADEME.'],
                ['tag' => 'Construction neuve', 'title' => 'RE2020', 'desc' => 'Applicable aux constructions neuves depuis le 1er janvier 2022. Renforce les exigences sur le Bbio, le Cep et introduit l\'indicateur carbone. Une GTB performante contribue à respecter les seuils Cep.'],
                ['tag' => 'Norme européenne', 'title' => 'EN 15232 (ISO 52120)', 'desc' => 'Norme de référence qui définit quatre classes d\'efficacité énergétique pour les systèmes d\'automatisation du bâtiment : classe D (non performant), C (standard), B (avancé) et A (haute performance). Le décret BACS impose la classe B minimum.'],
            ] as $reg)
            <div class="rounded-xl bg-white p-5 border border-dark-100 card-hover">
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-xs font-medium px-2 py-0.5 rounded bg-accent-50 text-accent-700 border border-accent-200">{{ $reg['tag'] }}</span>
                </div>
                <h3 class="text-base font-medium text-dark-900 tracking-tight">{{ $reg['title'] }}</h3>
                <p class="mt-2 text-sm text-dark-500 leading-relaxed">{{ $reg['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="relative overflow-hidden py-12 md:py-20 bg-dark-100 border-t border-dark-200">
    <img src="/images/hero-gtb-illustration.webp" alt="" aria-hidden="true" width="1200" height="630" loading="lazy" class="absolute right-0 top-0 h-full w-auto object-cover opacity-20" />
    <div class="absolute inset-0 bg-gradient-to-r from-dark-100 via-dark-100/80 to-transparent pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-6 md:px-10 relative z-10 flex items-center min-h-[200px]">
        <div class="max-w-lg">
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Comparer les solutions du marché</h2>
            <p class="text-base text-dark-500 leading-relaxed mb-7">Notre comparateur indépendant analyse les superviseurs GTB, protocoles et intégrateurs selon des critères objectifs.</p>
            <a href="/comparateur" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition-colors btn-glow">
                Accéder au comparateur
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</section>

<!-- Related pages -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="grid md:grid-cols-3 gap-6">
            @foreach([
                ['href' => '/gtb', 'title' => "Qu'est-ce que la GTB ?", 'desc' => 'Définition complète, niveaux ISO 52120-1 et obligations réglementaires.'],
                ['href' => '/comparateur', 'title' => 'Comparateur GTB indépendant', 'desc' => 'Comparez objectivement les marques du marché sans biais commercial.'],
                ['href' => '/reglementation', 'title' => 'Réglementation GTB', 'desc' => 'Décret BACS, décret tertiaire, RE2020 — tout le cadre légal.'],
            ] as $link)
            <a href="{{ $link['href'] }}" class="block bg-dark-50 rounded-xl p-6 border border-dark-200 card-hover-glow">
                <h3 class="text-[15px] font-medium text-dark-900 mb-1">{{ $link['title'] }}</h3>
                <p class="text-sm text-dark-500">{{ $link['desc'] }}</p>
            </a>
            @endforeach
        </div>
    </div>
</section>

@endsection
