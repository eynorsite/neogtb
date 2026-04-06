@extends('front.layouts.app')

@section('title', "Qu'est-ce que la GTC ? Differences avec la GTB")
@section('description', 'Guide GTC : definition, differences avec la GTB, architecture type, protocoles OPC-UA/BACnet/Modbus et supervision multi-sites.')

@section('content')

<!-- HERO IMAGE -->
<section class="relative min-h-[480px] flex items-center overflow-hidden">
    <img src="/images/hero-gtc.webp" alt="Batiment tertiaire intelligent — supervision GTC centralisee" width="1200" height="630" loading="eager" fetchpriority="high" class="absolute inset-0 w-full h-full object-cover object-center" />
    <div class="absolute inset-0" style="background: linear-gradient(to right, rgba(0,0,0,0.78) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.1) 100%);"></div>
    <div class="max-w-7xl mx-auto px-6 md:px-10 relative z-10 w-full">
        <div class="max-w-[540px]">
            <p class="inline-flex items-center gap-2 text-[11px] font-medium text-white/85 bg-white/10 backdrop-blur-sm px-3.5 py-1.5 rounded-full border border-white/15 mb-6">Comprendre</p>
            <h1 class="font-heading text-4xl md:text-5xl font-medium text-white leading-tight tracking-tight mb-5">
                Qu'est-ce que la <span class="text-green-400">GTC</span> ?
            </h1>
            <p class="text-[17px] text-white/70 leading-relaxed max-w-[480px]">
                La Gestion Technique Centralisee (GTC) designe le systeme de supervision qui regroupe la surveillance et le pilotage de tous les equipements techniques d'un ou plusieurs batiments sur une interface unique.
            </p>
            <div class="mt-6 flex gap-2">
                <span class="text-xs font-medium px-3 py-1 rounded bg-white/10 text-white/80 border border-white/15">Supervision</span>
                <span class="text-xs font-medium px-3 py-1 rounded bg-white/10 text-white/80 border border-white/15">Multi-sites</span>
                <span class="text-xs font-medium px-3 py-1 rounded bg-white/10 text-white/80 border border-white/15">SCADA</span>
            </div>
        </div>
    </div>
</section>

<!-- DEFINITION -->
<section class="py-20">
    <div class="max-w-[760px] mx-auto px-6 md:px-10">
        <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-5">Definition et role de la GTC</h2>
        <p class="text-base text-dark-500 leading-relaxed mb-4">
            La <strong class="text-dark-900 font-medium">Gestion Technique Centralisee (GTC)</strong> designe un systeme informatique dedie a la supervision des lots techniques d'un patrimoine immobilier. Elle collecte en temps reel les donnees remontees par les capteurs et automates et les restitue sur des synoptiques graphiques accessibles depuis un poste central ou un navigateur web.
        </p>
        <p class="text-base text-dark-500 leading-relaxed mb-4">
            Contrairement a un simple tableau de bord, la GTC offre une <strong class="text-dark-900 font-medium">couche de supervision active</strong> : declenchement d'alarmes en cas de derive, historisation des mesures pour analyse de tendance, et possibilite d'envoyer des commandes simples aux equipements distants.
        </p>
        <p class="text-base text-dark-500 leading-relaxed mb-6">
            Dans le monde anglo-saxon, elle est souvent assimilee a un systeme de type <strong class="text-dark-900 font-medium">SCADA</strong> (Supervisory Control And Data Acquisition) applique au batiment.
        </p>
        <div class="bg-accent-50 border border-accent-200 rounded-xl p-6">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-700 mb-2">Point cle</p>
            <p class="text-sm text-dark-600 leading-relaxed">La GTC centralise la supervision de plusieurs sites ou de plusieurs lots techniques sur une plateforme unique. Elle remonte l'information, detecte les anomalies et permet un pilotage a distance, mais ne porte pas la regulation fine des equipements — c'est le role de la GTB ou des automates de terrain.</p>
        </div>
    </div>
</section>

<!-- GTB vs GTC -->
<section class="py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Comparaison</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">GTB vs GTC : differences factuelles</h2>
            <p class="text-base text-dark-500 leading-relaxed">Les deux acronymes sont frequemment utilises de maniere interchangeable. Pourtant, ils recouvrent des perimetres distincts.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-5 mb-10">
            <div class="bg-white rounded-xl p-7 border border-dark-200">
                <span class="inline-block text-[13px] font-medium text-white bg-dark-600 px-2.5 py-1 rounded-md mb-3.5">GTB</span>
                <h3 class="text-lg font-medium text-dark-900 mb-2.5">Gestion Technique du Batiment</h3>
                <ul class="text-sm text-dark-500 leading-relaxed space-y-1.5">
                    <li>&rarr; Perimetre : <strong class="text-dark-900 font-medium">un batiment</strong>, tous lots confondus</li>
                    <li>&rarr; Fonction : piloter, reguler et optimiser</li>
                    <li>&rarr; Regulation integree (boucles PID, lois d'eau)</li>
                    <li>&rarr; Utilisateur : technicien, energy manager</li>
                    <li>&rarr; Protocoles : BACnet, LON, KNX</li>
                    <li>&rarr; Equivalent : <em>BMS (Building Management System)</em></li>
                </ul>
            </div>
            <div class="bg-white rounded-xl p-7 border border-accent-200 shadow-[0_0_0_3px] shadow-accent-50">
                <span class="inline-block text-[13px] font-medium text-white bg-accent-600 px-2.5 py-1 rounded-md mb-3.5">GTC</span>
                <h3 class="text-lg font-medium text-dark-900 mb-2.5">Gestion Technique Centralisee</h3>
                <ul class="text-sm text-dark-500 leading-relaxed space-y-1.5">
                    <li>&rarr; Perimetre : <strong class="text-dark-900 font-medium">plusieurs batiments</strong> ou un parc</li>
                    <li>&rarr; Fonction : superviser, centraliser, alerter</li>
                    <li>&rarr; Regulation limitee (marche/arret)</li>
                    <li>&rarr; Utilisateur : gestionnaire de patrimoine</li>
                    <li>&rarr; Protocoles : BACnet/IP, Modbus TCP, OPC-UA</li>
                    <li>&rarr; Equivalent : <em>SCADA / BCS</em></li>
                </ul>
            </div>
        </div>
        <div class="bg-accent-50 border border-accent-200 rounded-xl p-6">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-700 mb-2">En resume</p>
            <p class="text-sm text-dark-600 leading-relaxed">La GTB pilote et optimise un batiment de l'interieur. La GTC supervise un parc depuis un point central. Dans les projets complexes, les deux cohabitent : la GTB assure la regulation locale, la GTC fournit la vision consolidee au gestionnaire.</p>
        </div>
    </div>
</section>

<!-- FONCTIONS PRINCIPALES -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Fonctionnalites</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Fonctions principales d'une GTC</h2>
            <p class="text-base text-dark-500 leading-relaxed">De la supervision en temps reel au reporting reglementaire, la GTC couvre l'ensemble du cycle de vie operationnel d'un patrimoine.</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach([
                ['cat' => 'Temps reel', 'title' => 'Supervision en temps reel', 'desc' => 'Affichage continu de l\'etat des equipements sur des synoptiques graphiques : temperatures, etats CTA, consommations, positions de vannes.'],
                ['cat' => 'Alertes', 'title' => 'Gestion des alarmes', 'desc' => 'Generation d\'alarmes classees par priorite, horodatees et transmises par notification (email, SMS). Journal complet pour analyse de recurrence.'],
                ['cat' => 'Donnees', 'title' => 'Historisation et reporting', 'desc' => 'Archivage en base de toutes les donnees collectees. Rapports periodiques pour le suivi des consommations et la maintenance preventive.'],
                ['cat' => 'Commande', 'title' => 'Pilotage a distance', 'desc' => 'Envoi de commandes aux equipements distants : modification de consigne, passage en mode reduit, arret force. Reduction des deplacements sur site.'],
                ['cat' => 'Conformite', 'title' => 'Reporting reglementaire', 'desc' => 'Collecte des donnees pour le decret BACS et le decret tertiaire (-40 % en 2030, -50 % en 2040, -60 % en 2050).'],
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
            <p class="text-base text-dark-500 leading-relaxed">Une GTC repose sur une architecture a quatre niveaux, du terrain jusqu'a l'interface de supervision.</p>
        </div>
        <div class="grid md:grid-cols-4 gap-5">
            @php
            $levels = [
                ['num' => 'Niveau 1', 'bg' => 'bg-dark-400', 'title' => 'Terrain', 'desc' => 'Capteurs et actionneurs : sondes de temperature, compteurs d\'energie, detecteurs de presence, vannes motorisees.', 'highlight' => false],
                ['num' => 'Niveau 2', 'bg' => 'bg-dark-500', 'title' => 'Automates', 'desc' => 'Controleurs DDC qui collectent les informations, executent la logique de regulation locale et transmettent les donnees.', 'highlight' => false],
                ['num' => 'Niveau 3', 'bg' => 'bg-accent-600', 'title' => 'Reseau IP', 'desc' => 'Federe les automates de tous les sites vers le serveur central. BACnet/IP, Modbus TCP ou OPC-UA sur Ethernet.', 'highlight' => true],
                ['num' => 'Niveau 4', 'bg' => 'bg-dark-800', 'title' => 'Supervision', 'desc' => 'Serveur GTC : base de donnees historique, moteur d\'alarmes, synoptiques graphiques, reporting.', 'highlight' => false],
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
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-700 mb-2">Interoperabilite</p>
            <p class="text-sm text-dark-600 leading-relaxed">Le choix de protocoles ouverts (BACnet, Modbus, OPC-UA) est determinant pour eviter l'enfermement proprietaire et garantir l'evolutivite du systeme dans le temps.</p>
        </div>
    </div>
</section>

<!-- PROTOCOLES GTC -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="max-w-xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Communication</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Protocoles courants en GTC</h2>
            <p class="text-base text-dark-500 leading-relaxed">La GTC s'appuie principalement sur des protocoles reseau/IP pour federer des sites distants.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-4 mb-10">
            @foreach([
                ['name' => 'BACnet/IP', 'tag' => 'ISO 16484-5', 'desc' => 'Protocole backbone de reference pour la supervision multi-batiments. Communication inter-sites sur UDP/IP.'],
                ['name' => 'Modbus TCP', 'tag' => 'Ethernet', 'desc' => 'Modbus encapsule en TCP/IP. Simplicite du Modbus avec la portee de l\'Ethernet.'],
                ['name' => 'OPC UA', 'tag' => 'IEC 62541', 'desc' => 'Standard d\'interoperabilite cross-systeme. Communication securisee, pont entre systemes OT et IT.'],
                ['name' => 'BACnet/SC', 'tag' => 'ASHRAE 135', 'desc' => 'Secure Connect. TLS + WebSocket pour la communication securisee a travers les firewalls IT.'],
                ['name' => 'MQTT', 'tag' => 'ISO/IEC 20922', 'desc' => 'Messaging publish/subscribe leger pour IoT. Ideal pour la telemetrie capteurs vers cloud.'],
                ['name' => 'oBIX', 'tag' => 'OASIS', 'desc' => 'Open Building Information Exchange. API REST/XML/JSON pour l\'echange de donnees entre GTC et applications metier.'],
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
            <p class="text-base text-dark-500 leading-relaxed">La GTC prend tout son sens des lors qu'il s'agit de superviser un patrimoine reparti sur plusieurs sites.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-5">
            @foreach([
                ['tag' => 'Multi-sites', 'title' => 'Parcs immobiliers tertiaires', 'desc' => 'Un gestionnaire de patrimoine disposant de plusieurs immeubles de bureaux utilise la GTC pour consolider les donnees energetiques et detecter les derives en temps reel.'],
                ['tag' => 'Campus', 'title' => 'Enseignement et sante', 'desc' => 'Les campus universitaires ou hospitaliers comprennent de nombreux batiments d\'ages differents. La GTC offre une vision unifiee et aide au respect du decret tertiaire.'],
                ['tag' => 'Collectivites', 'title' => 'Communes et intercommunalites', 'desc' => 'Les collectivites gerent un parc diversifie : ecoles, gymnases, mediatheques. La GTC permet de piloter l\'ensemble depuis un poste central.'],
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
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Conformite</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Cadre reglementaire</h2>
            <p class="text-base text-dark-500 leading-relaxed">La GTC joue un role central dans la conformite aux obligations energetiques des batiments tertiaires.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-5">
            @foreach([
                ['badge' => 'Obligatoire', 'bg' => 'bg-accent-600', 'title' => 'Decret BACS', 'desc' => 'Impose un systeme d\'automatisation (classe B min.) pour les batiments tertiaires. Echeance 2025 (>290 kW CVC), 2030 (>70 kW).'],
                ['badge' => 'Objectifs', 'bg' => 'bg-dark-600', 'title' => 'Decret tertiaire', 'desc' => 'Reduction progressive de la consommation : -40 % (2030), -50 % (2040), -60 % (2050). Declaration annuelle OPERAT.'],
                ['badge' => 'Neuf', 'bg' => 'bg-dark-600', 'title' => 'RE2020', 'desc' => 'Applicable aux batiments neufs. Seuils de consommation (Cep) et confort d\'ete (DH) rendant la supervision centralisee quasi indispensable.'],
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
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Evaluez votre systeme de supervision</h2>
            <p class="text-base text-dark-500 leading-relaxed mb-7">Identifiez les points d'amelioration de votre installation GTC et verifiez sa conformite avec les exigences reglementaires.</p>
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
                ['href' => '/gtb', 'title' => "Qu'est-ce que la GTB ?", 'desc' => 'Definition, niveaux ISO 52120-1 et cadre reglementaire complet.'],
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
