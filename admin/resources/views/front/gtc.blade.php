@extends('front.layouts.app')

@section('title', "Qu'est-ce que la GTC ? Différences avec la GTB")
@section('description', 'Guide GTC : définition, différences avec la GTB, architecture type, protocoles OPC-UA/BACnet/Modbus et supervision multi-sites.')

@section('content')

<!-- HERO IMAGE -->
<x-front.shared.hero
    image="/images/hero-gtc.webp"
    imageAlt="Bâtiment tertiaire intelligent — supervision GTC centralisée"
    eyebrow="Comprendre"
    title="Qu'est-ce que la GTC ?"
    highlight="GTC"
    subtitle="La Gestion Technique Centralisée (GTC) désigne le système de supervision qui regroupe la surveillance et le pilotage de tous les équipements techniques d'un ou plusieurs bâtiments sur une interface unique."
    :tags="['Supervision', 'Multi-sites', 'SCADA']"
    minHeight="480px"
    overlay="gradient"
/>

<!-- DEFINITION -->
<section class="py-20">
    <div class="max-w-[760px] mx-auto px-6 md:px-10">
        <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-5">Définition et rôle de la GTC</h2>
        <p class="text-base text-dark-500 leading-relaxed mb-4">
            La <strong class="text-dark-900 font-medium">Gestion Technique Centralisée (GTC)</strong> désigne un système informatique dédié à la supervision des lots techniques d'un patrimoine immobilier. Elle collecte en temps réel les données remontées par les capteurs et automates et les restitue sur des synoptiques graphiques accessibles depuis un poste central ou un navigateur web.
        </p>
        <p class="text-base text-dark-500 leading-relaxed mb-4">
            Contrairement à un simple tableau de bord, la GTC offre une <strong class="text-dark-900 font-medium">couche de supervision active</strong> : déclenchement d'alarmes en cas de dérive, historisation des mesures pour analyse de tendance, et possibilité d'envoyer des commandes simples aux équipements distants.
        </p>
        <p class="text-base text-dark-500 leading-relaxed mb-6">
            Dans le monde anglo-saxon, elle est souvent assimilée à un système de type <strong class="text-dark-900 font-medium">SCADA</strong> (Supervisory Control And Data Acquisition) appliqué au bâtiment.
        </p>
        <div class="bg-accent-50 border border-accent-200 rounded-xl p-6">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-700 mb-2">Point clé</p>
            <p class="text-sm text-dark-600 leading-relaxed">La GTC centralise la supervision de plusieurs sites ou de plusieurs lots techniques sur une plateforme unique. Elle remonte l'information, détecte les anomalies et permet un pilotage à distance, mais ne porte pas la régulation fine des équipements — c'est le rôle de la GTB ou des automates de terrain.</p>
        </div>
    </div>
</section>

<!-- GTB vs GTC -->
<section class="py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Comparaison</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">GTB vs GTC : differences factuelles</h2>
            <p class="text-base text-dark-500 leading-relaxed">Les deux acronymes sont fréquemment utilisés de manière interchangeable. Pourtant, ils recouvrent des périmètres distincts.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-5 mb-10">
            <div class="bg-white rounded-xl p-7 border border-dark-200">
                <span class="inline-block text-[13px] font-medium text-white bg-dark-600 px-2.5 py-1 rounded-md mb-3.5">GTB</span>
                <h3 class="text-lg font-medium text-dark-900 mb-2.5">Gestion Technique du Batiment</h3>
                <ul class="text-sm text-dark-500 leading-relaxed space-y-1.5">
                    <li>&rarr; Périmètre : <strong class="text-dark-900 font-medium">un bâtiment</strong>, tous lots confondus</li>
                    <li>&rarr; Fonction : piloter, réguler et optimiser</li>
                    <li>&rarr; Régulation intégrée (boucles PID, lois d'eau)</li>
                    <li>&rarr; Utilisateur : technicien, energy manager</li>
                    <li>&rarr; Protocoles : BACnet, LON, KNX</li>
                    <li>&rarr; Equivalent : <em>BMS (Building Management System)</em></li>
                </ul>
            </div>
            <div class="bg-white rounded-xl p-7 border border-accent-200 shadow-[0_0_0_3px] shadow-accent-50">
                <span class="inline-block text-[13px] font-medium text-white bg-accent-600 px-2.5 py-1 rounded-md mb-3.5">GTC</span>
                <h3 class="text-lg font-medium text-dark-900 mb-2.5">Gestion Technique Centralisee</h3>
                <ul class="text-sm text-dark-500 leading-relaxed space-y-1.5">
                    <li>&rarr; Périmètre : <strong class="text-dark-900 font-medium">plusieurs bâtiments</strong> ou un parc</li>
                    <li>&rarr; Fonction : superviser, centraliser, alerter</li>
                    <li>&rarr; Régulation limitée (marche/arrêt)</li>
                    <li>&rarr; Utilisateur : gestionnaire de patrimoine</li>
                    <li>&rarr; Protocoles : BACnet/IP, Modbus TCP, OPC-UA</li>
                    <li>&rarr; Equivalent : <em>SCADA / BCS</em></li>
                </ul>
            </div>
        </div>
        <div class="bg-accent-50 border border-accent-200 rounded-xl p-6">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-700 mb-2">En résumé</p>
            <p class="text-sm text-dark-600 leading-relaxed">La GTB pilote et optimise un bâtiment de l'intérieur. La GTC supervise un parc depuis un point central. Dans les projets complexes, les deux cohabitent : la GTB assure la régulation locale, la GTC fournit la vision consolidée au gestionnaire.</p>
            @include('front.bricks.cta-mini.cta-text-link-underline', ['beforeText' => 'Besoin de trancher pour votre parc ?', 'linkText' => 'Voyez notre comparateur indépendant', 'href' => '/comparateur', 'afterText' => '.'])
        </div>
    </div>
</section>

<!-- FONCTIONS PRINCIPALES -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Fonctionnalités</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Fonctions principales d'une GTC</h2>
            <p class="text-base text-dark-500 leading-relaxed">De la supervision en temps réel au reporting réglementaire, la GTC couvre l'ensemble du cycle de vie opérationnel d'un patrimoine.</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach([
                ['cat' => 'Temps réel', 'title' => 'Supervision en temps réel', 'desc' => 'Affichage continu de l\'état des équipements sur des synoptiques graphiques : températures, états CTA, consommations, positions de vannes.'],
                ['cat' => 'Alertes', 'title' => 'Gestion des alarmes', 'desc' => 'Génération d\'alarmes classées par priorité, horodatées et transmises par notification (email, SMS). Journal complet pour analyse de récurrence.'],
                ['cat' => 'Données', 'title' => 'Historisation et reporting', 'desc' => 'Archivage en base de toutes les données collectées. Rapports périodiques pour le suivi des consommations et la maintenance préventive.'],
                ['cat' => 'Commande', 'title' => 'Pilotage à distance', 'desc' => 'Envoi de commandes aux équipements distants : modification de consigne, passage en mode réduit, arrêt forcé. Réduction des déplacements sur site.'],
                ['cat' => 'Conformité', 'title' => 'Reporting réglementaire', 'desc' => 'Collecte des données pour le décret BACS et le décret tertiaire (-40 % en 2030, -50 % en 2040, -60 % en 2050).'],
            ] as $func)
            <div class="bg-white rounded-xl p-7 border border-dark-200 shadow-sm card-hover">
                <div class="text-[11px] font-medium uppercase tracking-widest text-accent-600 mb-3">{{ $func['cat'] }}</div>
                <h3 class="text-[17px] font-medium text-dark-900 mb-2">{{ $func['title'] }}</h3>
                <p class="text-sm text-dark-500 leading-relaxed">{{ $func['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ARCHITECTURE -->
<section class="py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Infrastructure</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Architecture type d'une GTC</h2>
            <p class="text-base text-dark-500 leading-relaxed">Une GTC repose sur une architecture à quatre niveaux, du terrain jusqu'à l'interface de supervision.</p>
        </div>
        <div class="grid md:grid-cols-4 gap-5">
            @php
            $levels = [
                ['num' => 'Niveau 1', 'bg' => 'bg-dark-400', 'title' => 'Terrain', 'desc' => 'Capteurs et actionneurs : sondes de température, compteurs d\'énergie, détecteurs de présence, vannes motorisées.', 'highlight' => false],
                ['num' => 'Niveau 2', 'bg' => 'bg-dark-500', 'title' => 'Automates', 'desc' => 'Contrôleurs DDC qui collectent les informations, exécutent la logique de régulation locale et transmettent les données.', 'highlight' => false],
                ['num' => 'Niveau 3', 'bg' => 'bg-accent-600', 'title' => 'Réseau IP', 'desc' => 'Fédère les automates de tous les sites vers le serveur central. BACnet/IP, Modbus TCP ou OPC-UA sur Ethernet.', 'highlight' => true],
                ['num' => 'Niveau 4', 'bg' => 'bg-dark-800', 'title' => 'Supervision', 'desc' => 'Serveur GTC : base de données historique, moteur d\'alarmes, synoptiques graphiques, reporting.', 'highlight' => false],
            ];
            @endphp
            @foreach($levels as $level)
            <div class="{{ $level['highlight'] ? 'bg-white rounded-xl border border-accent-200 shadow-[0_0_0_3px] shadow-accent-50' : 'bg-white rounded-xl border border-dark-200 shadow-sm' }} p-6 card-hover">
                <span class="inline-block text-[13px] font-medium text-white {{ $level['bg'] }} px-2.5 py-1 rounded-md mb-3.5">{{ $level['num'] }}</span>
                <h3 class="text-[17px] font-medium text-dark-900 mb-2">{{ $level['title'] }}</h3>
                <p class="text-[13px] text-dark-500 leading-relaxed">{{ $level['desc'] }}</p>
            </div>
            @endforeach
        </div>
        <div class="bg-accent-50 border border-accent-200 rounded-xl p-6 mt-8">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-700 mb-2">Interopérabilité</p>
            <p class="text-sm text-dark-600 leading-relaxed">Le choix de protocoles ouverts (BACnet, Modbus, OPC-UA) est déterminant pour éviter l'enfermement propriétaire et garantir l'évolutivité du système dans le temps.</p>
            @include('front.bricks.cta-mini.cta-text-link-underline', ['beforeText' => '', 'linkText' => 'Les 19 équipements Modbus de notre catalogue technique', 'href' => '/tables-modbus', 'afterText' => 'illustrent ces protocoles ouverts.'])
        </div>
    </div>
</section>

<!-- PROTOCOLES GTC -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Communication</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Protocoles courants en GTC</h2>
            <p class="text-base text-dark-500 leading-relaxed">La GTC s'appuie principalement sur des protocoles réseau/IP pour fédérer des sites distants.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-4 mb-10">
            @foreach([
                ['name' => 'BACnet/IP', 'tag' => 'ISO 16484-5', 'desc' => 'Protocole backbone de référence pour la supervision multi-bâtiments. Communication inter-sites sur UDP/IP.'],
                ['name' => 'Modbus TCP', 'tag' => 'Ethernet', 'desc' => 'Modbus encapsulé en TCP/IP. Simplicité du Modbus avec la portée de l\'Ethernet.'],
                ['name' => 'OPC UA', 'tag' => 'IEC 62541', 'desc' => 'Standard d\'interopérabilité cross-système. Communication sécurisée, pont entre systèmes OT et IT.'],
                ['name' => 'BACnet/SC', 'tag' => 'ASHRAE 135', 'desc' => 'Secure Connect. TLS + WebSocket pour la communication sécurisée à travers les firewalls IT.'],
                ['name' => 'MQTT', 'tag' => 'ISO/IEC 20922', 'desc' => 'Messaging publish/subscribe léger pour IoT. Idéal pour la télémétrie capteurs vers cloud.'],
                ['name' => 'oBIX', 'tag' => 'OASIS', 'desc' => 'Open Building Information Exchange. API REST/XML/JSON pour l\'échange de données entre GTC et applications métier.'],
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
</section>

<!-- CAS D'USAGE -->
<section class="py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Applications</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Cas d'usage</h2>
            <p class="text-base text-dark-500 leading-relaxed">La GTC prend tout son sens dès lors qu'il s'agit de superviser un patrimoine réparti sur plusieurs sites.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-5">
            @foreach([
                ['tag' => 'Multi-sites', 'title' => 'Parcs immobiliers tertiaires', 'desc' => 'Un gestionnaire de patrimoine disposant de plusieurs immeubles de bureaux utilise la GTC pour consolider les données énergétiques et détecter les dérives en temps réel.'],
                ['tag' => 'Campus', 'title' => 'Enseignement et santé', 'desc' => 'Les campus universitaires ou hospitaliers comprennent de nombreux bâtiments d\'âges différents. La GTC offre une vision unifiée et aide au respect du décret tertiaire.'],
                ['tag' => 'Collectivités', 'title' => 'Communes et intercommunalités', 'desc' => 'Les collectivités gèrent un parc diversifié : écoles, gymnases, médiathèques. La GTC permet de piloter l\'ensemble depuis un poste central.'],
            ] as $usecase)
            <div class="bg-white rounded-xl p-7 border border-dark-200 shadow-sm card-hover">
                <span class="inline-block text-xs font-medium px-2.5 py-1 rounded-md bg-primary-50 text-primary-700 border border-primary-100 mb-3.5">{{ $usecase['tag'] }}</span>
                <h3 class="text-lg font-medium text-dark-900 mb-2.5">{{ $usecase['title'] }}</h3>
                <p class="text-sm text-dark-500 leading-relaxed">{{ $usecase['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- REGLEMENTATION -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Conformité</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Cadre réglementaire</h2>
            <p class="text-base text-dark-500 leading-relaxed">La GTC joue un rôle central dans la conformité aux obligations énergétiques des bâtiments tertiaires.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-5">
            @foreach([
                ['badge' => 'Obligatoire', 'bg' => 'bg-accent-600', 'title' => 'Décret BACS', 'desc' => 'Impose un système d\'automatisation (classe B min.) pour les bâtiments tertiaires. Échéance 2025 (>290 kW CVC), 2030 (>70 kW).'],
                ['badge' => 'Objectifs', 'bg' => 'bg-dark-600', 'title' => 'Décret tertiaire', 'desc' => 'Réduction progressive de la consommation : -40 % (2030), -50 % (2040), -60 % (2050). Déclaration annuelle OPERAT.'],
                ['badge' => 'Neuf', 'bg' => 'bg-dark-600', 'title' => 'RE2020', 'desc' => 'Applicable aux bâtiments neufs. Seuils de consommation (Cep) et confort d\'été (DH) rendant la supervision centralisée quasi indispensable.'],
            ] as $reg)
            <div class="bg-white rounded-xl p-7 border border-dark-200 shadow-sm card-hover">
                <span class="inline-block text-[13px] font-medium text-white {{ $reg['bg'] }} px-2.5 py-1 rounded-md mb-3.5">{{ $reg['badge'] }}</span>
                <h3 class="text-lg font-medium text-dark-900 mb-2.5">{{ $reg['title'] }}</h3>
                <p class="text-sm text-dark-500 leading-relaxed">{{ $reg['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="relative overflow-hidden py-20 bg-dark-100 border-t border-dark-200">
    <img src="/images/hero-gtb-illustration.webp" alt="" aria-hidden="true" width="1200" height="630" loading="lazy" class="absolute right-0 top-0 h-full w-auto object-cover opacity-20" />
    <div class="absolute inset-0 bg-gradient-to-r from-dark-100 via-dark-100/80 to-transparent pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-6 md:px-10 relative z-10 flex items-center min-h-[200px]">
        <div class="max-w-lg">
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Évaluez votre système de supervision</h2>
            <p class="text-base text-dark-500 leading-relaxed mb-7">Identifiez les points d'amélioration de votre installation GTC et vérifiez sa conformité avec les exigences réglementaires.</p>
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
                ['href' => '/gtb', 'title' => "Qu'est-ce que la GTB ?", 'desc' => 'Définition, niveaux ISO 52120-1 et cadre réglementaire complet.'],
                ['href' => '/solutions', 'title' => 'Solutions & Technologies', 'desc' => 'Protocoles de communication et architecture technique.'],
                ['href' => '/comparateur', 'title' => 'Comparateur de solutions GTB', 'desc' => 'Comparez Schneider, Siemens, Honeywell et 10 autres marques.'],
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
