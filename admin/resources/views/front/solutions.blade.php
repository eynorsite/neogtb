@extends('front.layouts.app')

@section('title', 'Solutions GTB : protocoles BACnet, KNX, Modbus')
@section('description', 'Comparatif independant des protocoles GTB (BACnet, KNX, Modbus, LON), capteurs et automates. Guide sans lien commercial.')

@section('content')

<!-- HERO IMAGE -->
<section class="relative min-h-[480px] flex items-center overflow-hidden">
    <img src="/images/hero-solutions.webp" alt="Technologies GTB — capteurs IoT, protocoles et supervision connectee" width="1200" height="630" loading="eager" fetchpriority="high" class="absolute inset-0 w-full h-full object-cover object-center" />
    <div class="absolute inset-0" style="background: linear-gradient(to right, rgba(0,0,0,0.78) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.1) 100%);"></div>
    <div class="max-w-7xl mx-auto px-6 md:px-10 relative z-10 w-full">
        <div class="max-w-[540px]">
            <p class="inline-flex items-center gap-2 text-[11px] font-medium text-white/85 bg-white/10 backdrop-blur-sm px-3.5 py-1.5 rounded-full border border-white/15 mb-6">Technologies</p>
            <h1 class="font-heading text-[32px] md:text-[42px] font-medium text-white leading-tight tracking-tight mb-5">
                Solutions & technologies <span class="text-green-400">GTB</span>
            </h1>
            <p class="text-[17px] text-white/70 leading-relaxed max-w-[480px]">
                Les protocoles de communication, capteurs, controleurs et superviseurs qui composent un systeme de gestion technique du batiment. Architecture ouverte et interoperable.
            </p>
        </div>
    </div>
</section>

<!-- PROTOCOLES DE COMMUNICATION -->
<section class="py-12 md:py-16">
    <div class="max-w-7xl mx-auto px-5 md:px-10">
        <div class="mb-10">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Fondations</p>
            <h2 class="text-[26px] md:text-[32px] font-medium text-dark-900 leading-tight tracking-tight">Protocoles de communication</h2>
            <p class="mt-3 text-sm text-dark-500 max-w-xl leading-relaxed">Le protocole est le langage commun entre equipements. Le choix du protocole conditionne l'interoperabilite, la maintenabilite et la perennite de l'installation.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-5">
            @php
            $protocols = [
                ['tag' => 'ISO 16484-5', 'name' => 'BACnet', 'desc' => 'Standard international de la GTB, maintenu par l\'ASHRAE. Deux declinaisons principales : <strong class="font-medium text-dark-700">BACnet IP</strong> pour les reseaux Ethernet et <strong class="font-medium text-dark-700">BACnet MS/TP</strong> pour les bus RS-485 en terrain. Le protocole definit un modele objet unifie qui permet l\'interoperabilite entre equipements de marques differentes sans passerelle proprietaire.', 'tags' => ['Interoperabilite multi-marques', 'IP / MS/TP', 'ASHRAE 135']],
                ['tag' => 'EN 50090 / ISO/IEC 14543', 'name' => 'KNX', 'desc' => 'Standard europeen pour l\'automatisation du batiment. Le medium principal est le <strong class="font-medium text-dark-700">bus filaire TP</strong> (twisted pair). Plus de 500 fabricants certifies par l\'Association KNX. Particulierement adapte a l\'eclairage, la gestion des stores et le CVC en residentiel et petit tertiaire.', 'tags' => ['500+ fabricants', 'Bus TP', 'Eclairage / Stores / CVC']],
                ['tag' => 'RTU / TCP', 'name' => 'Modbus', 'desc' => 'Protocole industriel cree par Modicon en 1979, devenu un standard de fait. Simple et robuste, existe en <strong class="font-medium text-dark-700">Modbus RTU</strong> sur RS-485 et <strong class="font-medium text-dark-700">Modbus TCP</strong> sur Ethernet. Architecture maitre-esclave. Dominant pour le comptage energie.', 'tags' => ['Industriel / 1979', 'RS-485 / Ethernet', 'Comptage energie']],
                ['tag' => 'EN 14908', 'name' => 'LON', 'desc' => 'Local Operating Network, concu par Echelon. Architecture <strong class="font-medium text-dark-700">peer-to-peer</strong> : chaque noeud embarque sa propre intelligence. Historiquement tres utilise en GTB tertiaire. En declin face a BACnet IP, mais encore present dans le parc existant.', 'tags' => ['Peer-to-peer', 'Parc existant', 'Migration BACnet']],
                ['tag' => 'IEC 62386', 'name' => 'DALI / DALI-2', 'desc' => 'Standard international dedie au <strong class="font-medium text-dark-700">pilotage de l\'eclairage</strong>. DALI-2 apporte l\'interoperabilite certifiee entre ballasts, capteurs de presence et luxmetres. Jusqu\'a 64 appareils par ligne, adressage individuel, gradation fine.', 'tags' => ['Eclairage dedie', '64 appareils/ligne', 'Gradation fine']],
                ['tag' => 'IoT / Cloud', 'name' => 'MQTT & API REST', 'desc' => 'Protocoles issus du monde IT, de plus en plus presents en GTB pour <strong class="font-medium text-dark-700">l\'interoperabilite cloud</strong>, les jumeaux numeriques et l\'hypervision multi-sites. MQTT est leger et adapte aux capteurs IoT. Les API REST permettent l\'integration avec les plateformes de GMAO, ERP et analytics.', 'tags' => ['Publish/Subscribe', 'Cloud natif', 'Jumeaux numeriques']],
                ['tag' => 'ISO/IEC 14543-3-10', 'name' => 'EnOcean', 'desc' => 'Technologie <strong class="font-medium text-dark-700">sans fil et sans pile</strong> basee sur la recuperation d\'energie (piezoelectrique, solaire, thermique). Ideale pour la <strong class="font-medium text-dark-700">renovation</strong> ou le cablage est impossible ou couteux.', 'tags' => ['Sans fil / Sans pile', 'Renovation', 'Energy harvesting']],
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
    </div>
</section>

<!-- EQUIPEMENTS PILOTES -->
<section class="py-12 md:py-16 bg-dark-50">
    <div class="max-w-7xl mx-auto px-5 md:px-10">
        <div class="mb-10">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Perimetre</p>
            <h2 class="text-[26px] md:text-[32px] font-medium text-dark-900 leading-tight tracking-tight">Equipements pilotes</h2>
            <p class="mt-3 text-sm text-dark-500 max-w-xl leading-relaxed">La GTB supervise et regule l'ensemble des lots techniques d'un batiment.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach([
                ['num' => 'Lot 01', 'title' => 'CVC — Chauffage, ventilation, climatisation', 'desc' => 'Regulation des centrales de traitement d\'air, chaudieres, groupes froids, ventilo-convecteurs. Le lot CVC represente en moyenne 50 a 60 % de la consommation energetique d\'un batiment tertiaire.'],
                ['num' => 'Lot 02', 'title' => 'Eclairage', 'desc' => 'Gestion des circuits d\'eclairage par zones, horloges, detection de presence et mesure de luminosite. Pilotage DALI ou 0-10V. Gradation automatique selon l\'apport de lumiere naturelle.'],
                ['num' => 'Lot 03', 'title' => 'Stores et BSO', 'desc' => 'Brise-soleil orientables, stores interieurs et exterieurs. Pilotage selon l\'ensoleillement, la temperature interieure et les scenarios d\'occupation.'],
                ['num' => 'Lot 04', 'title' => 'Controle d\'acces', 'desc' => 'Gestion des lecteurs de badges, interphones, portiques et issues de secours. Integration avec la GTB pour adapter la regulation CVC et eclairage en fonction de l\'occupation reelle.'],
                ['num' => 'Lot 05', 'title' => 'Comptage energie', 'desc' => 'Sous-comptage electrique, thermique, gaz et eau. Remontee des index en temps reel vers le superviseur. Base du suivi energetique exige par le decret tertiaire (OPERAT).'],
                ['num' => 'Lot 06', 'title' => 'Securite incendie', 'desc' => 'Report des alarmes SSI vers le superviseur GTB. Commandes de desenfumage, coupures CVC sur detection. Le SSI conserve sa propre autonomie conformement aux normes NF S 61-932.'],
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
    <div class="max-w-7xl mx-auto px-5 md:px-10">
        <div class="mb-10">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Structure</p>
            <h2 class="text-[26px] md:text-[32px] font-medium text-dark-900 leading-tight tracking-tight">Architecture type d'un systeme GTB</h2>
            <p class="mt-3 text-sm text-dark-500 max-w-xl leading-relaxed">Un systeme GTB s'organise en couches successives, du terrain jusqu'a l'interface utilisateur.</p>
        </div>
        <div class="grid md:grid-cols-5 gap-4">
            @foreach([
                ['num' => 'Couche 1', 'title' => 'Capteurs & actionneurs', 'desc' => 'Sondes de temperature, detecteurs, vannes, registres, variateurs. Points physiques du terrain.'],
                ['num' => 'Couche 2', 'title' => 'Automates & controleurs', 'desc' => 'Controleurs DDC (Direct Digital Control). Executent la regulation en autonomie locale.'],
                ['num' => 'Couche 3', 'title' => 'Reseau', 'desc' => 'IP (Ethernet, fibre) pour le backbone. Bus terrain (RS-485, TP) pour les boucles locales.'],
                ['num' => 'Couche 4', 'title' => 'Superviseur GTB', 'desc' => 'Serveur central qui agrege les donnees, historise, genere les alarmes et fournit les synoptiques.'],
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
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-700 mb-2">Principe cle</p>
            <p class="text-sm text-dark-600 leading-relaxed">Chaque couche doit pouvoir fonctionner de maniere autonome en cas de defaillance de la couche superieure. Les automates continuent de reguler meme si le superviseur est hors service.</p>
        </div>
    </div>
</section>

<!-- CADRE REGLEMENTAIRE -->
<section class="py-12 md:py-16 bg-dark-50">
    <div class="max-w-7xl mx-auto px-5 md:px-10">
        <div class="mb-10">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Reglementation</p>
            <h2 class="text-[26px] md:text-[32px] font-medium text-dark-900 leading-tight tracking-tight">Cadre reglementaire</h2>
            <p class="mt-3 text-sm text-dark-500 max-w-xl leading-relaxed">Plusieurs textes reglementaires francais et europeens encadrent le deploiement de systemes GTB dans les batiments tertiaires.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-5">
            @foreach([
                ['tag' => 'Obligatoire', 'title' => 'Decret BACS', 'desc' => 'Transposition de la directive europeenne EPBD. Impose l\'installation d\'un systeme BACS dans les batiments tertiaires dont la puissance CVC depasse 290 kW (2025) puis 70 kW (2030). Niveau minimum : classe B ISO 52120-1.'],
                ['tag' => 'Obligatoire', 'title' => 'Decret tertiaire (Eco Energie Tertiaire)', 'desc' => 'Objectifs de reduction des consommations d\'energie finale des batiments tertiaires de plus de 1 000 m2 : -40 % en 2030, -50 % en 2040, -60 % en 2050. Declaration annuelle sur la plateforme OPERAT de l\'ADEME.'],
                ['tag' => 'Construction neuve', 'title' => 'RE2020', 'desc' => 'Applicable aux constructions neuves depuis le 1er janvier 2022. Renforce les exigences sur le Bbio, le Cep et introduit l\'indicateur carbone. Une GTB performante contribue a respecter les seuils Cep.'],
                ['tag' => 'Norme europeenne', 'title' => 'EN 15232 (ISO 52120)', 'desc' => 'Norme de reference qui definit quatre classes d\'efficacite energetique pour les systemes d\'automatisation du batiment : classe D (non performant), C (standard), B (avance) et A (haute performance). Le decret BACS impose la classe B minimum.'],
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
<section class="relative overflow-hidden py-20 bg-dark-100 border-t border-dark-200">
    <img src="/images/hero-gtb-illustration.webp" alt="" aria-hidden="true" width="1200" height="630" loading="lazy" class="absolute right-0 top-0 h-full w-auto object-cover opacity-20" />
    <div class="absolute inset-0 bg-gradient-to-r from-dark-100 via-dark-100/80 to-transparent pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-6 md:px-10 relative z-10 flex items-center min-h-[200px]">
        <div class="max-w-lg">
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Comparer les solutions du marche</h2>
            <p class="text-base text-dark-500 leading-relaxed mb-7">Notre comparateur independant analyse les superviseurs GTB, protocoles et integrateurs selon des criteres objectifs.</p>
            <a href="/comparateur" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition-colors btn-glow">
                Acceder au comparateur
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
                ['href' => '/gtb', 'title' => "Qu'est-ce que la GTB ?", 'desc' => 'Definition complete, niveaux ISO 52120-1 et obligations reglementaires.'],
                ['href' => '/comparateur', 'title' => 'Comparateur GTB independant', 'desc' => 'Comparez objectivement les marques du marche sans biais commercial.'],
                ['href' => '/reglementation', 'title' => 'Reglementation GTB', 'desc' => 'Decret BACS, decret tertiaire, RE2020 — tout le cadre legal.'],
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
