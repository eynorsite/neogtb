@extends('front.layouts.app')

@section('title', "Qu'est-ce que la GTB ? Définition et niveaux ISO 52120-1")
@section('description', 'Guide GTB : définition, 4 niveaux ISO 52120-1 (ex-EN 15232), protocoles BACnet/KNX/Modbus, décret BACS et obligations. Mis à jour 2026.')

@section('content')

<!-- HERO IMAGE -->
<x-front.shared.hero
    image="/images/hero-gtb.webp"
    imageAlt="Poste de supervision GTB — écrans de contrôle et alertes bâtiment"
    eyebrow="Comprendre"
    title="Qu'est-ce que la GTB ?"
    highlight="GTB"
    subtitle="La Gestion Technique du Bâtiment (GTB) désigne le système centralisé qui supervise, pilote et optimise l'ensemble des équipements techniques d'un bâtiment — du chauffage à l'éclairage, en passant par la ventilation et le contrôle d'accès."
    :tags="['ISO 52120-1', 'Pilotage CVC', 'Bâtiment intelligent']"
    minHeight="480px"
    overlay="gradient"
/>

<!-- DEFINITION -->
<section class="py-12 md:py-20">
    <div class="max-w-[760px] mx-auto px-6 md:px-10">
        <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-5">Définition et rôle de la GTB</h2>
            <p class="text-base text-dark-500 leading-relaxed mb-4">
                La <strong class="text-dark-900 font-medium">Gestion Technique du Bâtiment</strong>, couramment abrégée GTB et connue en anglais sous le terme <em>Building Management System (BMS)</em>, est un système informatique qui centralise la supervision et le pilotage de tous les lots techniques d'un bâtiment.
            </p>
            <p class="text-base text-dark-500 leading-relaxed mb-4">
                Elle collecte en temps réel les données issues de capteurs (température, hygrométrie, luminosité, présence, qualité de l'air, comptage énergétique) et transmet des commandes aux actionneurs pour maintenir les conditions de confort tout en réduisant la consommation d'énergie.
            </p>
            <p class="text-base text-dark-500 leading-relaxed mb-6">
                Contrairement à une simple régulation locale, la GTB offre une <strong class="text-dark-900 font-medium">vision globale du bâtiment</strong>. C'est cette capacité d'interopérabilité entre systèmes qui distingue une GTB d'un simple automate de régulation.
            </p>
            <div class="bg-accent-50 border border-accent-200 rounded-xl p-6">
                <p class="text-xs font-semibold uppercase tracking-widest text-accent-700 mb-2">Point clé</p>
                <p class="text-sm text-dark-600 leading-relaxed">Depuis le décret BACS (2020), la mise en place d'un système d'automatisation est <strong>obligatoire</strong> pour les bâtiments tertiaires dont la puissance CVC dépasse 290 kW (2025), puis 70 kW (2030).</p>
            </div>
        </div>
    </div>
</section>

<!-- NIVEAUX ISO 52120-1 -->
<section class="py-12 md:py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Classification</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Les 4 niveaux ISO 52120-1</h2>
            <p class="text-base text-dark-500 leading-relaxed">La norme EN ISO 52120-1 (ex-EN 15232) définit quatre classes de performance pour les systèmes de gestion technique du bâtiment.</p>
        </div>
        <div class="grid md:grid-cols-4 gap-5">
            @php
            $classes = [
                ['badge' => 'Classe D', 'bg' => 'bg-dark-400', 'title' => 'Non performant', 'desc' => 'Aucun système d\'automatisation. Pilotage manuel, sans régulation ni programmation. Référence basse à dépasser.', 'highlight' => false],
                ['badge' => 'Classe C', 'bg' => 'bg-dark-500', 'title' => 'Standard', 'desc' => 'Régulation de base et programmation horaire. Régulateurs individuels sans supervision centralisée. Niveau minimal pour les bâtiments neufs.', 'highlight' => false],
                ['badge' => 'Classe B', 'bg' => 'bg-accent-600', 'title' => 'Avancé', 'desc' => 'GTB centralisée, suivi énergétique, détection de dérives. Communication BACnet/KNX/Modbus. <strong class="text-accent-600">Exigence du décret BACS.</strong>', 'highlight' => true],
                ['badge' => 'Classe A', 'bg' => 'bg-dark-800', 'title' => 'Haute performance', 'desc' => 'Régulation pièce par pièce, optimisation multi-lots, analyse avancée, détection automatique des défauts, ajustement prédictif.', 'highlight' => false],
            ];
            @endphp
            @foreach($classes as $class)
            <div class="{{ $class['highlight'] ? 'bg-white rounded-xl border border-accent-200 shadow-[0_0_0_3px] shadow-accent-50' : 'bg-white rounded-xl border border-dark-200 shadow-sm' }} p-6 card-hover">
                <span class="inline-block text-[13px] font-medium text-white {{ $class['bg'] }} px-2.5 py-1 rounded-md mb-3.5">{{ $class['badge'] }}</span>
                <h3 class="text-[17px] font-medium text-dark-900 mb-2">{{ $class['title'] }}</h3>
                <p class="text-[13px] text-dark-500 leading-relaxed">{!! $class['desc'] !!}</p>
            </div>
            @endforeach
        </div>
        <div class="max-w-[760px] mx-auto mt-6">
            @include('front.bricks.cta-mini.cta-arrow-link', ['href' => '/audit', 'text' => 'Situer votre bâtiment sur cette échelle'])
        </div>
    </div>
</section>

<!-- LOTS TECHNIQUES -->
<section class="py-12 md:py-20">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Périmètre</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Lots techniques pilotés</h2>
            <p class="text-base text-dark-500 leading-relaxed">Une GTB supervise et coordonne l'ensemble des systèmes du bâtiment.</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach([
                ['cat' => 'CVC', 'title' => 'Chauffage, Ventilation, Climatisation', 'desc' => 'Régulation des chaudières, PAC, groupes froids, CTA, ventilo-convecteurs. Gestion des consignes par zone, programmation horaire, réduit de nuit, suivi des rendements.'],
                ['cat' => 'Éclairage', 'title' => 'Pilotage et gradation', 'desc' => 'Pilotage par zone selon présence et luminosité naturelle. Gradation (dimming) via DALI ou KNX. Gestion des circuits de sécurité et d\'éclairage extérieur.'],
                ['cat' => 'Protection solaire', 'title' => 'Stores et BSO', 'desc' => 'Gestion automatisée selon ensoleillement, position du soleil, vent. Interaction CVC essentielle : réduction des apports solaires en été, exploitation en hiver.'],
                ['cat' => 'Sécurité', 'title' => 'Contrôle d\'accès et sûreté', 'desc' => 'Supervision des lecteurs de badges, détection d\'intrusion, SSI. Couplage présence/confort : zone inoccupée = chauffage réduit, éclairage éteint.'],
                ['cat' => 'Énergie', 'title' => 'Comptage et suivi énergétique', 'desc' => 'Centralisation des compteurs (élec, gaz, eau, calories). Suivi des IPE, détection de dérives, reporting OPERAT pour le décret tertiaire.'],
            ] as $lot)
            <div class="bg-white rounded-xl p-7 border border-dark-200 shadow-sm card-hover">
                <div class="text-[11px] font-medium uppercase tracking-widest text-accent-600 mb-3">{{ $lot['cat'] }}</div>
                <h3 class="text-[17px] font-medium text-dark-900 mb-2">{{ $lot['title'] }}</h3>
                <p class="text-sm text-dark-500 leading-relaxed">{{ $lot['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- PROTOCOLES -->
<section class="py-12 md:py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Interopérabilité</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Protocoles de communication</h2>
            <p class="text-base text-dark-500 leading-relaxed">Le choix du protocole conditionne l'interopérabilité, la maintenabilité et la pérennité de l'installation.</p>
        </div>

        <!-- Terrain -->
        <div class="mb-10">
            <h3 class="text-xs font-medium uppercase tracking-widest text-dark-400 mb-4">Protocoles terrain (capteurs / actionneurs)</h3>
            <div class="grid md:grid-cols-2 gap-4">
                @foreach([
                    ['name' => 'BACnet MS/TP', 'tag' => 'ISO 16484-5', 'desc' => 'BACnet sur bus RS-485 série. Protocole terrain de référence pour connecter automates, boîtes VAV et capteurs.'],
                    ['name' => 'Modbus RTU', 'tag' => 'RS-485', 'desc' => 'Protocole industriel (1979, Modicon). Architecture maître-esclave sur liaison série. Dominant pour le comptage énergie.'],
                    ['name' => 'KNX TP', 'tag' => 'ISO/IEC 14543-3', 'desc' => 'Bus filaire paire torsadée. Architecture décentralisée, 500+ fabricants. Standard européen pour éclairage, stores, CVC.'],
                    ['name' => 'DALI / DALI-2', 'tag' => 'IEC 62386', 'desc' => 'Digital Addressable Lighting Interface. Bus 2 fils, 64 appareils par ligne. Standard ouvert pour ballasts et dimmers.'],
                ] as $proto)
                <div class="bg-white rounded-xl p-6 border border-dark-200 shadow-sm">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-base font-medium text-dark-900">{{ $proto['name'] }}</p>
                        <span class="text-xs font-medium px-2 py-0.5 rounded bg-primary-50 text-primary-700 border border-primary-100">{{ $proto['tag'] }}</span>
                    </div>
                    <p class="text-sm text-dark-500 leading-relaxed">{{ $proto['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Reseau / IP -->
        <div class="mb-10">
            <h3 class="text-xs font-medium uppercase tracking-widest text-dark-400 mb-4">Protocoles réseau et IP</h3>
            <div class="grid md:grid-cols-2 gap-4">
                @foreach([
                    ['name' => 'BACnet/IP', 'tag' => 'ISO 16484-5', 'desc' => 'BACnet sur UDP/IP. Protocole backbone de référence pour la supervision GTB moderne.'],
                    ['name' => 'BACnet/SC', 'tag' => 'ASHRAE 135', 'desc' => 'Secure Connect. TLS + WebSocket pour la communication sécurisée à travers les firewalls IT.'],
                    ['name' => 'Modbus TCP', 'tag' => 'Ethernet', 'desc' => 'Modbus encapsulé en TCP/IP. Simplicité du Modbus avec la vitesse et la portée de l\'Ethernet.'],
                    ['name' => 'OPC UA', 'tag' => 'IEC 62541', 'desc' => 'Standard d\'interopérabilité cross-système. Communication sécurisée, pont entre OT et IT.'],
                    ['name' => 'MQTT', 'tag' => 'ISO/IEC 20922', 'desc' => 'Messaging publish/subscribe léger pour IoT. Idéal pour la télémétrie capteurs vers cloud.'],
                ] as $proto)
                <div class="bg-white rounded-xl p-6 border border-dark-200 shadow-sm">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-base font-medium text-dark-900">{{ $proto['name'] }}</p>
                        <span class="text-xs font-medium px-2 py-0.5 rounded bg-primary-50 text-primary-700 border border-primary-100">{{ $proto['tag'] }}</span>
                    </div>
                    <p class="text-sm text-dark-500 leading-relaxed">{{ $proto['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Sans fil -->
        <div>
            <h3 class="text-xs font-medium uppercase tracking-widest text-dark-400 mb-4">Protocoles sans fil</h3>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach([
                    ['name' => 'EnOcean', 'tag' => 'ISO/IEC 14543-3-10', 'desc' => 'Sans batterie — alimenté par l\'énergie ambiante. Idéal pour la rénovation sans câblage.'],
                    ['name' => 'ZigBee 3.0', 'tag' => 'IEEE 802.15.4', 'desc' => 'Réseau mesh basse consommation, auto-réparant. Très utilisé pour l\'éclairage commercial.'],
                    ['name' => 'Thread / Matter', 'tag' => 'CSA', 'desc' => 'Mesh IPv6 basse consommation. Standard d\'interopérabilité Apple, Google, Amazon, Samsung.'],
                    ['name' => 'LoRaWAN', 'tag' => 'LoRa Alliance', 'desc' => 'Longue portée (km), très basse consommation. Capteurs distribués, campus, bâtiments distants.'],
                    ['name' => 'BLE Mesh', 'tag' => 'IEEE 802.15.1', 'desc' => 'BLE pour capteurs de proximité et beacons. Bluetooth Mesh pour réseaux d\'éclairage grande échelle.'],
                    ['name' => 'NB-IoT / LTE-M', 'tag' => '3GPP', 'desc' => 'IoT cellulaire pour monitoring distant. Parcs géographiquement distribués.'],
                ] as $proto)
                <div class="bg-white rounded-xl p-6 border border-dark-200 shadow-sm">
                    <p class="text-base font-medium text-dark-900 mb-1">{{ $proto['name'] }}</p>
                    <p class="text-xs text-accent-600 mb-1.5">{{ $proto['tag'] }}</p>
                    <p class="text-[13px] text-dark-500 leading-relaxed">{{ $proto['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- REGLEMENTATION -->
<section class="py-12 md:py-20">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Conformité</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Cadre réglementaire</h2>
            <p class="text-base text-dark-500 leading-relaxed">Plusieurs textes encadrent la mise en place de systèmes GTB dans les bâtiments tertiaires en France.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-5">
            @foreach([
                ['badge' => 'Obligatoire', 'bg' => 'bg-accent-600', 'title' => 'Décret BACS', 'desc' => 'Impose un système d\'automatisation (classe B min.) pour les bâtiments tertiaires. Échéance 2025 (>290 kW CVC), 2030 (>70 kW).'],
                ['badge' => 'Objectifs', 'bg' => 'bg-dark-600', 'title' => 'Décret tertiaire', 'desc' => 'Réduction progressive de la consommation : -40 % (2030), -50 % (2040), -60 % (2050). Déclaration annuelle sur OPERAT.'],
                ['badge' => 'Neuf', 'bg' => 'bg-dark-600', 'title' => 'RE2020', 'desc' => 'Applicable aux bâtiments neufs. Seuils de consommation (Cep) et confort d\'été (DH) rendant la GTB quasi indispensable.'],
            ] as $reg)
            <div class="bg-white rounded-xl p-7 border border-dark-200 shadow-sm card-hover">
                <span class="inline-block text-[13px] font-medium text-white {{ $reg['bg'] }} px-2.5 py-1 rounded-md mb-3.5">{{ $reg['badge'] }}</span>
                <h3 class="text-lg font-medium text-dark-900 mb-2.5">{{ $reg['title'] }}</h3>
                <p class="text-sm text-dark-500 leading-relaxed">{{ $reg['desc'] }}</p>
            </div>
            @endforeach
        </div>
        <div class="max-w-[760px] mx-auto">
            @include('front.bricks.cta-mini.cta-info-callout', ['eyebrow' => 'Point d\'action', 'text' => 'Échéance BACS à vérifier selon votre puissance CVC. Repérez-vous avec le pré-diagnostic.', 'href' => '/audit', 'linkText' => 'Lancer le pré-diagnostic'])
        </div>
    </div>
</section>

<!-- CTA -->
<section class="relative overflow-hidden py-12 md:py-20 bg-dark-100 border-t border-dark-200">
    <img src="/images/hero-gtb-illustration.webp" alt="" aria-hidden="true" width="1200" height="630" loading="lazy" class="absolute right-0 top-0 h-full w-auto object-cover opacity-20" />
    <div class="absolute inset-0 bg-gradient-to-r from-dark-100 via-dark-100/80 to-transparent pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-6 md:px-10 relative z-10 flex items-center min-h-[200px]">
        <div class="max-w-lg">
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Évaluez le niveau GTB de votre bâtiment</h2>
            <p class="text-base text-dark-500 leading-relaxed mb-7">Identifiez votre classe ISO 52120-1, vérifiez votre conformité BACS et repérez les axes d'amélioration.</p>
            <a href="/audit" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition-colors btn-glow">
                Lancer le diagnostic
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
                ['href' => '/gtc', 'title' => 'GTC : quelle différence avec la GTB ?', 'desc' => 'Supervision centralisée vs automatisation — comprendre les nuances.'],
                ['href' => '/solutions', 'title' => 'Solutions & Technologies GTB', 'desc' => 'Protocoles BACnet, KNX, Modbus, capteurs et automates.'],
                ['href' => '/reglementation', 'title' => 'Réglementation GTB en France', 'desc' => 'Décret BACS, décret tertiaire, RE2020 — calendrier et obligations.'],
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
