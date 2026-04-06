@extends('front.layouts.app')

@section('title', "Qu'est-ce que la GTB ? Definition et niveaux ISO 52120-1")
@section('description', 'Guide GTB : definition, 4 niveaux ISO 52120-1 (ex-EN 15232), protocoles BACnet/KNX/Modbus, decret BACS et obligations. Mis a jour 2026.')

@section('content')

<!-- HERO IMAGE -->
<section class="relative min-h-[480px] flex items-center overflow-hidden">
    <img src="/images/hero-gtb.webp" alt="Poste de supervision GTB — ecrans de controle et alertes batiment" width="1200" height="630" loading="eager" fetchpriority="high" class="absolute inset-0 w-full h-full object-cover object-center" />
    <div class="absolute inset-0" style="background: linear-gradient(to right, rgba(0,0,0,0.78) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.1) 100%);"></div>
    <div class="max-w-7xl mx-auto px-6 md:px-10 relative z-10 w-full">
        <div class="max-w-[540px]">
            <p class="inline-flex items-center gap-2 text-[11px] font-medium text-white/85 bg-white/10 backdrop-blur-sm px-3.5 py-1.5 rounded-full border border-white/15 mb-6">Comprendre</p>
            <h1 class="font-heading text-4xl md:text-5xl font-medium text-white leading-tight tracking-tight mb-5">
                Qu'est-ce que la <span class="text-green-400">GTB</span> ?
            </h1>
            <p class="text-[17px] text-white/70 leading-relaxed max-w-[480px]">
                La Gestion Technique du Batiment (GTB) designe le systeme centralise qui supervise, pilote et optimise l'ensemble des equipements techniques d'un batiment — du chauffage a l'eclairage, en passant par la ventilation et le controle d'acces.
            </p>
            <div class="mt-6 flex gap-2">
                <span class="text-xs font-medium px-3 py-1 rounded bg-white/10 text-white/80 border border-white/15">Batiment intelligent</span>
                <span class="text-xs font-medium px-3 py-1 rounded bg-white/10 text-white/80 border border-white/15">ISO 52120-1</span>
            </div>
        </div>
    </div>
</section>

<!-- DEFINITION -->
<section class="py-20">
    <div class="max-w-[760px] mx-auto px-6 md:px-10">
        <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-5">Definition et role de la GTB</h2>
            <p class="text-base text-dark-500 leading-relaxed mb-4">
                La <strong class="text-dark-900 font-medium">Gestion Technique du Batiment</strong>, couramment abregee GTB et connue en anglais sous le terme <em>Building Management System (BMS)</em>, est un systeme informatique qui centralise la supervision et le pilotage de tous les lots techniques d'un batiment.
            </p>
            <p class="text-base text-dark-500 leading-relaxed mb-4">
                Elle collecte en temps reel les donnees issues de capteurs (temperature, hygrometrie, luminosite, presence, qualite de l'air, comptage energetique) et transmet des commandes aux actionneurs pour maintenir les conditions de confort tout en reduisant la consommation d'energie.
            </p>
            <p class="text-base text-dark-500 leading-relaxed mb-6">
                Contrairement a une simple regulation locale, la GTB offre une <strong class="text-dark-900 font-medium">vision globale du batiment</strong>. C'est cette capacite d'interoperabilite entre systemes qui distingue une GTB d'un simple automate de regulation.
            </p>
            <div class="bg-accent-50 border border-accent-200 rounded-xl p-6">
                <p class="text-xs font-semibold uppercase tracking-widest text-accent-700 mb-2">Point cle</p>
                <p class="text-sm text-dark-600 leading-relaxed">Depuis le decret BACS (2020), la mise en place d'un systeme d'automatisation est <strong>obligatoire</strong> pour les batiments tertiaires dont la puissance CVC depasse 290 kW (2025), puis 70 kW (2030).</p>
            </div>
        </div>
    </div>
</section>

<!-- NIVEAUX ISO 52120-1 -->
<section class="py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Classification</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Les 4 niveaux ISO 52120-1</h2>
            <p class="text-base text-dark-500 leading-relaxed">La norme EN ISO 52120-1 (ex-EN 15232) definit quatre classes de performance pour les systemes de gestion technique du batiment.</p>
        </div>
        <div class="grid md:grid-cols-4 gap-5">
            @php
            $classes = [
                ['badge' => 'Classe D', 'bg' => 'bg-dark-400', 'title' => 'Non performant', 'desc' => 'Aucun systeme d\'automatisation. Pilotage manuel, sans regulation ni programmation. Reference basse a depasser.', 'highlight' => false],
                ['badge' => 'Classe C', 'bg' => 'bg-dark-500', 'title' => 'Standard', 'desc' => 'Regulation de base et programmation horaire. Regulateurs individuels sans supervision centralisee. Niveau minimal pour les batiments neufs.', 'highlight' => false],
                ['badge' => 'Classe B', 'bg' => 'bg-accent-600', 'title' => 'Avance', 'desc' => 'GTB centralisee, suivi energetique, detection de derives. Communication BACnet/KNX/Modbus. <strong class="text-accent-600">Exigence du decret BACS.</strong>', 'highlight' => true],
                ['badge' => 'Classe A', 'bg' => 'bg-dark-800', 'title' => 'Haute performance', 'desc' => 'Regulation piece par piece, optimisation multi-lots, analyse avancee, detection automatique des defauts, ajustement predictif.', 'highlight' => false],
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
    </div>
</section>

<!-- LOTS TECHNIQUES -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Perimetre</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Lots techniques pilotes</h2>
            <p class="text-base text-dark-500 leading-relaxed">Une GTB supervise et coordonne l'ensemble des systemes du batiment.</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach([
                ['cat' => 'CVC', 'title' => 'Chauffage, Ventilation, Climatisation', 'desc' => 'Regulation des chaudieres, PAC, groupes froids, CTA, ventilo-convecteurs. Gestion des consignes par zone, programmation horaire, reduit de nuit, suivi des rendements.'],
                ['cat' => 'Eclairage', 'title' => 'Pilotage et gradation', 'desc' => 'Pilotage par zone selon presence et luminosite naturelle. Gradation (dimming) via DALI ou KNX. Gestion des circuits de securite et d\'eclairage exterieur.'],
                ['cat' => 'Protection solaire', 'title' => 'Stores et BSO', 'desc' => 'Gestion automatisee selon ensoleillement, position du soleil, vent. Interaction CVC essentielle : reduction des apports solaires en ete, exploitation en hiver.'],
                ['cat' => 'Securite', 'title' => 'Controle d\'acces et surete', 'desc' => 'Supervision des lecteurs de badges, detection d\'intrusion, SSI. Couplage presence/confort : zone inoccupee = chauffage reduit, eclairage eteint.'],
                ['cat' => 'Energie', 'title' => 'Comptage et suivi energetique', 'desc' => 'Centralisation des compteurs (elec, gaz, eau, calories). Suivi des IPE, detection de derives, reporting OPERAT pour le decret tertiaire.'],
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
<section class="py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Interoperabilite</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Protocoles de communication</h2>
            <p class="text-base text-dark-500 leading-relaxed">Le choix du protocole conditionne l'interoperabilite, la maintenabilite et la perennite de l'installation.</p>
        </div>

        <!-- Terrain -->
        <div class="mb-10">
            <h3 class="text-xs font-medium uppercase tracking-widest text-dark-400 mb-4">Protocoles terrain (capteurs / actionneurs)</h3>
            <div class="grid md:grid-cols-2 gap-4">
                @foreach([
                    ['name' => 'BACnet MS/TP', 'tag' => 'ISO 16484-5', 'desc' => 'BACnet sur bus RS-485 serie. Protocole terrain de reference pour connecter automates, boites VAV et capteurs.'],
                    ['name' => 'Modbus RTU', 'tag' => 'RS-485', 'desc' => 'Protocole industriel (1979, Modicon). Architecture maitre-esclave sur liaison serie. Dominant pour le comptage energie.'],
                    ['name' => 'KNX TP', 'tag' => 'ISO/IEC 14543-3', 'desc' => 'Bus filaire paire torsadee. Architecture decentralisee, 500+ fabricants. Standard europeen pour eclairage, stores, CVC.'],
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
            <h3 class="text-xs font-medium uppercase tracking-widest text-dark-400 mb-4">Protocoles reseau et IP</h3>
            <div class="grid md:grid-cols-2 gap-4">
                @foreach([
                    ['name' => 'BACnet/IP', 'tag' => 'ISO 16484-5', 'desc' => 'BACnet sur UDP/IP. Protocole backbone de reference pour la supervision GTB moderne.'],
                    ['name' => 'BACnet/SC', 'tag' => 'ASHRAE 135', 'desc' => 'Secure Connect. TLS + WebSocket pour la communication securisee a travers les firewalls IT.'],
                    ['name' => 'Modbus TCP', 'tag' => 'Ethernet', 'desc' => 'Modbus encapsule en TCP/IP. Simplicite du Modbus avec la vitesse et la portee de l\'Ethernet.'],
                    ['name' => 'OPC UA', 'tag' => 'IEC 62541', 'desc' => 'Standard d\'interoperabilite cross-systeme. Communication securisee, pont entre OT et IT.'],
                    ['name' => 'MQTT', 'tag' => 'ISO/IEC 20922', 'desc' => 'Messaging publish/subscribe leger pour IoT. Ideal pour la telemetrie capteurs vers cloud.'],
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
                    ['name' => 'EnOcean', 'tag' => 'ISO/IEC 14543-3-10', 'desc' => 'Sans batterie — alimente par l\'energie ambiante. Ideal pour la renovation sans cablage.'],
                    ['name' => 'ZigBee 3.0', 'tag' => 'IEEE 802.15.4', 'desc' => 'Reseau mesh basse consommation, auto-reparant. Tres utilise pour l\'eclairage commercial.'],
                    ['name' => 'Thread / Matter', 'tag' => 'CSA', 'desc' => 'Mesh IPv6 basse consommation. Standard d\'interoperabilite Apple, Google, Amazon, Samsung.'],
                    ['name' => 'LoRaWAN', 'tag' => 'LoRa Alliance', 'desc' => 'Longue portee (km), tres basse consommation. Capteurs distribues, campus, batiments distants.'],
                    ['name' => 'BLE Mesh', 'tag' => 'IEEE 802.15.1', 'desc' => 'BLE pour capteurs de proximite et beacons. Bluetooth Mesh pour reseaux d\'eclairage grande echelle.'],
                    ['name' => 'NB-IoT / LTE-M', 'tag' => '3GPP', 'desc' => 'IoT cellulaire pour monitoring distant. Parcs geographiquement distribues.'],
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
<section class="py-20">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Conformite</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Cadre reglementaire</h2>
            <p class="text-base text-dark-500 leading-relaxed">Plusieurs textes encadrent la mise en place de systemes GTB dans les batiments tertiaires en France.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-5">
            @foreach([
                ['badge' => 'Obligatoire', 'bg' => 'bg-accent-600', 'title' => 'Decret BACS', 'desc' => 'Impose un systeme d\'automatisation (classe B min.) pour les batiments tertiaires. Echeance 2025 (>290 kW CVC), 2030 (>70 kW).'],
                ['badge' => 'Objectifs', 'bg' => 'bg-dark-600', 'title' => 'Decret tertiaire', 'desc' => 'Reduction progressive de la consommation : -40 % (2030), -50 % (2040), -60 % (2050). Declaration annuelle sur OPERAT.'],
                ['badge' => 'Neuf', 'bg' => 'bg-dark-600', 'title' => 'RE2020', 'desc' => 'Applicable aux batiments neufs. Seuils de consommation (Cep) et confort d\'ete (DH) rendant la GTB quasi indispensable.'],
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
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Evaluez le niveau GTB de votre batiment</h2>
            <p class="text-base text-dark-500 leading-relaxed mb-7">Identifiez votre classe ISO 52120-1, verifiez votre conformite BACS et reperez les axes d'amelioration.</p>
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
                ['href' => '/gtc', 'title' => 'GTC : quelle difference avec la GTB ?', 'desc' => 'Supervision centralisee vs automatisation — comprendre les nuances.'],
                ['href' => '/solutions', 'title' => 'Solutions & Technologies GTB', 'desc' => 'Protocoles BACnet, KNX, Modbus, capteurs et automates.'],
                ['href' => '/reglementation', 'title' => 'Reglementation GTB en France', 'desc' => 'Decret BACS, decret tertiaire, RE2020 — calendrier et obligations.'],
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
