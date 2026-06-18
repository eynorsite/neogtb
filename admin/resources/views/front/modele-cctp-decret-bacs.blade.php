@extends('front.layouts.app')

{{-- Fil d'Ariane --}}
@section('breadcrumbs')
    <li><a href="/" class="hover:text-accent-600 transition-colors">Accueil</a></li>
    <li aria-hidden="true" class="text-dark-300">/</li>
    <li><a href="/decret-bacs" class="hover:text-accent-600 transition-colors">Décret BACS</a></li>
    <li aria-hidden="true" class="text-dark-300">/</li>
    <li aria-current="page" class="text-dark-600">Modèle de CCTP</li>
@endsection

{{-- JSON-LD FAQPage — canal schema.org contextuel (app.blade.php:99). Exempté CSP. --}}
@push('schema')
<script type="application/ld+json" @cspNonce>
@verbatim
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        {"@type":"Question","name":"Qu'est-ce qu'un CCTP décret BACS ?","acceptedAnswer":{"@type":"Answer","text":"Le CCTP (Cahier des Clauses Techniques Particulières) est la pièce d'un marché qui décrit les exigences techniques attendues. Un CCTP décret BACS précise les fonctions, l'architecture et les performances que doit atteindre la GTB pour être conforme au décret BACS, soit a minima la classe B de la norme NF EN ISO 52120-1."}},
        {"@type":"Question","name":"Ce modèle de CCTP est-il directement conforme au décret BACS ?","acceptedAnswer":{"@type":"Answer","text":"Ce modèle est une trame neutre, sans lien fabricant, qui reprend les exigences du décret BACS et de la norme NF EN ISO 52120-1. Il doit être adapté à chaque bâtiment (périmètre, puissances, existant, lots concernés) avant d'être intégré à un dossier de consultation. Il ne se substitue pas à un avis technique ou juridique."}},
        {"@type":"Question","name":"Puis-je réutiliser ce modèle gratuitement ?","acceptedAnswer":{"@type":"Answer","text":"Oui. Vous pouvez consulter, imprimer et adapter ce modèle de CCTP pour vos propres consultations. Pour une version personnalisée à votre bâtiment ou un accompagnement à la rédaction, NeoGTB propose une assistance à maîtrise d'ouvrage (AMO) indépendante."}}
    ]
}
@endverbatim
</script>
@endpush

@section('content')

{{-- =========================================================================
     HERO — LIGHT MODE (aligné decret-bacs.blade.php)
     ========================================================================= --}}
<section class="relative overflow-hidden bg-white border-b border-dark-100">
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
                Ressource gratuite
            </p>
            <h1 class="text-[32px] lg:text-[52px] font-semibold text-dark-900 tracking-tight leading-[1.1] mb-6">
                Modèle type de CCTP décret BACS
            </h1>
            <p class="text-lg lg:text-xl text-dark-500 leading-relaxed mb-8">
                Une trame de cahier des charges technique pour votre consultation GTB : neutre fabricant,
                multi-protocoles, calée sur la <strong class="text-dark-700 font-medium">classe B</strong> de
                la norme NF EN ISO 52120-1, comme l'exige le décret BACS. À lire, copier et adapter à votre bâtiment.
            </p>
            <div class="flex flex-wrap items-center gap-4">
                <a href="#telecharger" class="btn-primary">
                    Télécharger le modèle (Word)
                    <x-front.shared.icon name="document" class="w-4 h-4" />
                </a>
                <button type="button" x-data @click="window.print()" class="inline-flex items-center gap-1.5 px-6 py-3 text-sm font-medium text-dark-700 border border-dark-300 rounded-lg hover:bg-dark-50 transition-colors">
                    Imprimer / enregistrer en PDF
                </button>
            </div>
            <p class="text-[13px] text-dark-500 mt-4">Document Word (.docx) modifiable, à adapter à votre bâtiment. Lecture libre ci-dessous, version éditable gratuite par email.</p>
            @include('front.partials.reassurance-badges', ['class' => 'mt-8 justify-start'])
        </div>
    </div>
</section>

{{-- =========================================================================
     MODE D'EMPLOI + AVERTISSEMENT
     ========================================================================= --}}
<section class="py-12 lg:py-20">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-10 lg:gap-12">
            <div class="lg:col-span-3">
                <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Comment l'utiliser</p>
                <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-4">Une trame à adapter, pas un copier-coller</h2>
                <p class="text-base text-dark-500 leading-relaxed mb-4">
                    Le CCTP (Cahier des Clauses Techniques Particulières) est la pièce d'un marché qui décrit
                    précisément ce que doit faire la GTB. Ce modèle reprend la structure et les exigences que l'on
                    retrouve dans les vraies consultations conformes au décret BACS.
                </p>
                <p class="text-base text-dark-500 leading-relaxed mb-6">
                    Les passages signalés <mark class="bg-orange-50 text-orange-900 px-1.5 py-0.5 rounded font-medium border border-orange-200">[À compléter]</mark>
                    doivent être renseignés selon votre bâtiment : périmètre, puissances, lots concernés, existant.
                    Supprimez ce qui ne s'applique pas, conservez la logique d'ensemble.
                </p>
                <ul class="text-[15px] text-dark-500 leading-relaxed space-y-2.5">
                    <li class="flex gap-3"><x-front.shared.icon name="conformite" class="w-5 h-5 text-accent-600 flex-shrink-0 mt-0.5" /><span><strong class="text-dark-900 font-medium">Neutre fabricant</strong> : exigences fonctionnelles, jamais une marque imposée.</span></li>
                    <li class="flex gap-3"><x-front.shared.icon name="reseau" class="w-5 h-5 text-accent-600 flex-shrink-0 mt-0.5" /><span><strong class="text-dark-900 font-medium">Multi-protocoles ouverts</strong> : BACnet, Modbus, KNX, LON, M-Bus.</span></li>
                    <li class="flex gap-3"><x-front.shared.icon name="energie" class="w-5 h-5 text-accent-600 flex-shrink-0 mt-0.5" /><span><strong class="text-dark-900 font-medium">Classe B visée</strong> : le niveau minimum imposé par le décret BACS.</span></li>
                </ul>
            </div>

            <aside class="lg:col-span-2">
                <div class="bg-orange-50 border border-orange-200 rounded-2xl p-5 lg:p-7">
                    <p class="text-xs font-semibold uppercase tracking-widest text-orange-800 mb-2">À savoir</p>
                    <p class="text-[15px] text-dark-700 leading-relaxed mb-3">
                        Ce modèle est fourni à titre indicatif. Il ne constitue ni un avis juridique, ni une
                        garantie de conformité : chaque projet doit être vérifié au regard de son contexte
                        technique et réglementaire réel.
                    </p>
                    <p class="text-[15px] text-dark-700 leading-relaxed">
                        Besoin d'une version calée sur votre bâtiment ? Notre
                        <a href="/amo-gtb-gtc" class="text-accent-700 font-medium hover:text-accent-800 underline underline-offset-2">AMO GTB/GTC</a>
                        rédige le CCTP avec vous, sans lien fabricant ni commission.
                    </p>
                </div>
            </aside>
        </div>
    </div>
</section>

{{-- =========================================================================
     SOMMAIRE DU CCTP (ancres)
     ========================================================================= --}}
<section class="py-12 lg:py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-xl mb-10">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Sommaire</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Les 12 articles du CCTP</h2>
            <p class="text-base text-dark-500 leading-relaxed">La structure type d'un cahier des charges GTB conforme au décret BACS.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3 lg:gap-4">
            @foreach([
                ['n' => '01', 'id' => 'art-1', 'titre' => 'Objet du marché'],
                ['n' => '02', 'id' => 'art-2', 'titre' => 'Cadre réglementaire et normatif'],
                ['n' => '03', 'id' => 'art-3', 'titre' => "Description de l'existant et périmètre"],
                ['n' => '04', 'id' => 'art-4', 'titre' => 'Exigences fonctionnelles (classe B)'],
                ['n' => '05', 'id' => 'art-5', 'titre' => 'Architecture du système GTB'],
                ['n' => '06', 'id' => 'art-6', 'titre' => 'Protocoles et interopérabilité'],
                ['n' => '07', 'id' => 'art-7', 'titre' => "Comptage et mesurage de l'énergie"],
                ['n' => '08', 'id' => 'art-8', 'titre' => 'Cybersécurité (recommandations ANSSI)'],
                ['n' => '09', 'id' => 'art-9', 'titre' => 'Protection des données (RGPD)'],
                ['n' => '10', 'id' => 'art-10', 'titre' => 'Mise en service, commissioning, réception'],
                ['n' => '11', 'id' => 'art-11', 'titre' => 'Maintenance, garanties et formation'],
                ['n' => '12', 'id' => 'art-12', 'titre' => 'Documents à remettre et jugement des offres'],
            ] as $item)
            <a href="#{{ $item['id'] }}" class="flex items-center gap-3 bg-white rounded-xl px-4 py-3.5 border border-dark-100 hover:border-accent-200 hover:shadow-sm transition-all">
                <span class="text-[13px] font-medium text-accent-600 tabular-nums">{{ $item['n'] }}</span>
                <span class="text-[14px] text-dark-700 leading-snug">{{ $item['titre'] }}</span>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- =========================================================================
     LE MODÈLE DE CCTP — articles
     ========================================================================= --}}
<section class="py-12 lg:py-24">
    <div class="max-w-3xl mx-auto px-5 lg:px-0">

        {{-- ART. 1 --}}
        <article id="art-1" class="scroll-mt-28 mb-12 lg:mb-16">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 1</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Objet du marché</h2>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-3">
                Le présent Cahier des Clauses Techniques Particulières (CCTP) définit les exigences relatives à la
                fourniture, l'installation, le paramétrage, la mise en service et la réception d'un système de
                gestion technique du bâtiment (GTB), au sens du décret BACS, pour
                <mark class="bg-orange-50 text-orange-900 px-1.5 py-0.5 rounded font-medium border border-orange-200">[à compléter : désignation et adresse du bâtiment, maître d'ouvrage]</mark>.
            </p>
            <p class="text-[15px] text-dark-600 leading-relaxed">
                Le système installé devra atteindre <strong class="text-dark-900 font-medium">a minima la classe B</strong>
                de la norme NF EN ISO 52120-1 (ex EN 15232), sur le périmètre défini à l'article 3. Le titulaire
                a une obligation de résultat sur l'atteinte de cette classe, qu'il devra démontrer à la réception.
            </p>
        </article>

        {{-- ART. 2 --}}
        <article id="art-2" class="scroll-mt-28 mb-12 lg:mb-16">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 2</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Cadre réglementaire et normatif</h2>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-4">Les prestations sont réalisées dans le respect, notamment, des textes et normes suivants :</p>
            <ul class="text-[15px] text-dark-600 leading-relaxed space-y-2 pl-5 list-disc mb-4">
                <li>Décret n° 2020-887 du 20 juillet 2020 (« décret BACS »), transposant l'article 14 de la directive européenne EPBD 2018/844 ;</li>
                <li>Décret n° 2023-259 du 7 avril 2023 (abaissement du seuil de puissance CVC à 70 kW) ;</li>
                <li>Décret n° 2025-1343 du 26 décembre 2025 (report de la tranche 70–290 kW au 1ᵉʳ janvier 2030) ;</li>
                <li>Articles R. 175-1 à R. 175-6 du Code de la construction et de l'habitation ;</li>
                <li>Articles R. 241-26, R. 241-27 et R. 241-30 du Code de l'énergie (seuils et conditions de régulation) ;</li>
                <li>Norme NF EN ISO 52120-1 (mars 2022), qui remplace la norme EN 15232 ;</li>
                <li>Norme EN ISO 16484 pour le protocole BACnet ; normes EN 50090 et EN 13321 pour le protocole KNX.</li>
            </ul>
            <div class="bg-accent-50 border border-accent-200 rounded-xl p-4">
                <p class="text-[14px] text-dark-700 leading-relaxed"><strong class="text-accent-800">Classe visée : B.</strong> La classe C ne correspond qu'au minimum exigé pour certaines constructions neuves au titre d'autres réglementations ; elle est insuffisante pour le décret BACS.</p>
            </div>
        </article>

        {{-- ART. 3 --}}
        <article id="art-3" class="scroll-mt-28 mb-12 lg:mb-16">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 3</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Description de l'existant et périmètre</h2>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-3">
                <mark class="bg-orange-50 text-orange-900 px-1.5 py-0.5 rounded font-medium border border-orange-200">[à compléter]</mark>
                Décrire le bâtiment et son patrimoine technique : surface, usage, nombre de niveaux, plages d'occupation.
            </p>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-3">Préciser la puissance nominale utile cumulée des systèmes CVC (chauffage + climatisation), qui détermine l'assujettissement au décret BACS, ainsi que les lots concernés :</p>
            <ul class="text-[15px] text-dark-600 leading-relaxed space-y-2 pl-5 list-disc mb-3">
                <li>Production et distribution de chaleur (chaudières, PAC, sous-stations) ;</li>
                <li>Production et distribution de froid (groupes froid, PAC réversibles) ;</li>
                <li>Ventilation et traitement d'air (CTA, VMC, récupération) ;</li>
                <li>Eau chaude sanitaire (ECS) ;</li>
                <li>Éclairage des zones concernées ;</li>
                <li>Comptage et sous-comptage de l'énergie.</li>
            </ul>
            <p class="text-[15px] text-dark-600 leading-relaxed">Décrire la régulation existante, les automates et protocoles déjà en place, et préciser si la prestation est une création, une extension ou une reprise d'installation.</p>
        </article>

        {{-- ART. 4 --}}
        <article id="art-4" class="scroll-mt-28 mb-12 lg:mb-16">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 4</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Exigences fonctionnelles (classe B)</h2>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-5">La GTB devra assurer les trois finalités du décret BACS, déclinées en fonctions de classe B au sens de la norme NF EN ISO 52120-1 :</p>

            <div class="space-y-4 mb-6">
                <div class="bg-white rounded-xl p-5 border border-dark-100">
                    <h3 class="text-[15px] font-medium text-dark-900 mb-2">A. Suivre, enregistrer, analyser et ajuster en continu</h3>
                    <p class="text-[14px] text-dark-500 leading-relaxed">Mesure et historisation continue des consommations par usage et par zone ; affichage des données d'exploitation ; ajustement automatique des consignes selon l'occupation réelle et les conditions extérieures.</p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-dark-100">
                    <h3 class="text-[15px] font-medium text-dark-900 mb-2">B. Détecter les dérives et informer de l'efficacité énergétique</h3>
                    <p class="text-[14px] text-dark-500 leading-relaxed">Détection automatique des défauts et des écarts de performance des équipements ; génération d'alarmes hiérarchisées ; tableaux de bord et indicateurs permettant d'évaluer l'efficacité énergétique du bâtiment.</p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-dark-100">
                    <h3 class="text-[15px] font-medium text-dark-900 mb-2">C. Garantir une GTB interopérable</h3>
                    <p class="text-[14px] text-dark-500 leading-relaxed">Communication avec les systèmes techniques du bâtiment via des protocoles ouverts et standardisés (article 6), sans dépendance à une solution propriétaire fermée.</p>
                </div>
            </div>

            <p class="text-[15px] text-dark-600 leading-relaxed mb-3">Fonctions d'automatisation attendues (classe B), par lot :</p>
            <ul class="text-[15px] text-dark-600 leading-relaxed space-y-2 pl-5 list-disc">
                <li>Régulation des émetteurs et générateurs CVC avec communication sur bus de terrain ;</li>
                <li>Programmation horaire centralisée et optimisation des relances selon l'occupation ;</li>
                <li>Régulation de la température ambiante par zone, avec consigne réduite en inoccupation ;</li>
                <li>Optimisation de la température de départ d'eau (loi d'eau) en fonction de l'extérieur ;</li>
                <li>Pilotage du débit d'air et de la vitesse des pompes et ventilateurs (variation de vitesse) ;</li>
                <li>Gestion centralisée de l'éclairage des zones concernées (présence et apport de lumière du jour) ;</li>
                <li>Comptage par usage et restitution d'indicateurs de consommation ;</li>
                <li>Fonctions de diagnostic et de détection automatique des défauts (FDD).</li>
            </ul>
        </article>

        {{-- ART. 5 --}}
        <article id="art-5" class="scroll-mt-28 mb-12 lg:mb-16">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 5</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Architecture du système GTB</h2>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-4">Le système sera organisé en trois niveaux, suivant l'architecture classique d'une GTB :</p>
            <ol class="text-[15px] text-dark-600 leading-relaxed space-y-3 pl-5 list-decimal mb-4">
                <li><strong class="text-dark-900 font-medium">Niveau terrain</strong> : capteurs (température, CO₂, présence, comptage) et actionneurs (vannes, registres, variateurs), raccordés sur bus de terrain.</li>
                <li><strong class="text-dark-900 font-medium">Niveau automation</strong> : automates programmables et contrôleurs assurant la régulation locale, le traitement des alarmes et l'historisation. Le fonctionnement de la régulation devra rester autonome en cas de perte de la supervision.</li>
                <li><strong class="text-dark-900 font-medium">Niveau gestion</strong> : poste de supervision (hyperviseur) centralisant la visualisation, les courbes de tendance, les alarmes, les rapports et le paramétrage, accessible localement et à distance de façon sécurisée.</li>
            </ol>
            <p class="text-[15px] text-dark-600 leading-relaxed">Les matériels seront standards, documentés et disponibles sur le marché. Aucune fonction essentielle ne devra dépendre d'un composant dont la maintenance serait réservée à un acteur unique.</p>
        </article>

        {{-- ART. 6 --}}
        <article id="art-6" class="scroll-mt-28 mb-12 lg:mb-16">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 6</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Protocoles et interopérabilité</h2>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-4">Pour répondre à l'exigence d'interopérabilité du décret BACS, le système devra reposer sur des protocoles de communication ouverts et standardisés. Sont notamment acceptés :</p>
            <ul class="text-[15px] text-dark-600 leading-relaxed space-y-2 pl-5 list-disc mb-4">
                <li><strong class="text-dark-900 font-medium">BACnet</strong> (IP et MS/TP) — équipements et contrôleurs certifiés BTL ;</li>
                <li><strong class="text-dark-900 font-medium">Modbus</strong> (RTU et TCP) ;</li>
                <li><strong class="text-dark-900 font-medium">KNX</strong> ;</li>
                <li><strong class="text-dark-900 font-medium">LonWorks</strong> ;</li>
                <li><strong class="text-dark-900 font-medium">M-Bus</strong> (filaire ou radio) pour le comptage.</li>
            </ul>
            <p class="text-[15px] text-dark-600 leading-relaxed">Les solutions entièrement propriétaires et fermées sont proscrites. Les passerelles éventuelles vers des équipements tiers seront documentées. Le maître d'ouvrage restera pleinement propriétaire de son installation, des codes sources de paramétrage et des accès, sans dépendance à un mainteneur unique.</p>
        </article>

        {{-- ART. 7 --}}
        <article id="art-7" class="scroll-mt-28 mb-12 lg:mb-16">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 7</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Comptage et mesurage de l'énergie</h2>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-4">Le système assurera le comptage et le sous-comptage des consommations afin de permettre le suivi par usage exigé par le décret BACS :</p>
            <ul class="text-[15px] text-dark-600 leading-relaxed space-y-2 pl-5 list-disc">
                <li>Comptage par énergie (électricité, gaz, réseau de chaleur/froid, eau) ;</li>
                <li>Sous-comptage par usage significatif (chauffage, froid, ventilation, ECS, éclairage) ;</li>
                <li>Remontée des index et historisation des courbes de charge ;</li>
                <li>Compatibilité avec un report des données vers la plateforme OPERAT au titre du décret tertiaire, le cas échéant.</li>
            </ul>
        </article>

        {{-- ART. 8 --}}
        <article id="art-8" class="scroll-mt-28 mb-12 lg:mb-16">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 8</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Cybersécurité (recommandations ANSSI)</h2>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-4">L'installation s'appuiera sur les bonnes pratiques de sécurité des systèmes d'information, en s'inspirant des recommandations de l'ANSSI applicables aux systèmes industriels et à la GTB :</p>
            <ul class="text-[15px] text-dark-600 leading-relaxed space-y-2 pl-5 list-disc">
                <li>Segmentation du réseau GTB et cloisonnement vis-à-vis du réseau bureautique ;</li>
                <li>Gestion des comptes et des droits par profils (consultation, modification, acquittement des alarmes, administration) ;</li>
                <li>Authentification forte et chiffrement des accès distants ;</li>
                <li>Politique de mises à jour de sécurité et de sauvegarde des configurations ;</li>
                <li>Journalisation des accès et des actions sur le système.</li>
            </ul>
        </article>

        {{-- ART. 9 --}}
        <article id="art-9" class="scroll-mt-28 mb-12 lg:mb-16">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 9</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Protection des données (RGPD)</h2>
            <p class="text-[15px] text-dark-600 leading-relaxed">
                Si le système traite des données à caractère personnel (par exemple via la détection de présence ou
                des comptages individualisés), le titulaire devra respecter le RGPD : minimisation des données,
                finalité limitée à la gestion technique et énergétique, durée de conservation maîtrisée et
                information des personnes concernées. Aucune donnée ne sera exploitée à des fins étrangères à
                l'exploitation du bâtiment.
            </p>
        </article>

        {{-- ART. 10 --}}
        <article id="art-10" class="scroll-mt-28 mb-12 lg:mb-16">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 10</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Mise en service, commissioning et réception</h2>
            <ul class="text-[15px] text-dark-600 leading-relaxed space-y-2 pl-5 list-disc">
                <li>Programme de mise en service détaillant les tests par lot et par point ;</li>
                <li>Commissioning fonctionnel : vérification du fonctionnement réel des séquences de régulation et d'optimisation ;</li>
                <li><strong class="text-dark-900 font-medium">Démonstration de l'atteinte de la classe B</strong> au sens de la norme NF EN ISO 52120-1, fonction par fonction ;</li>
                <li>Vérification des alarmes, des historiques et des indicateurs énergétiques ;</li>
                <li>Levée des réserves avant prononcé de la réception.</li>
            </ul>
        </article>

        {{-- ART. 11 --}}
        <article id="art-11" class="scroll-mt-28 mb-12 lg:mb-16">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 11</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Maintenance, garanties et formation</h2>
            <ul class="text-[15px] text-dark-600 leading-relaxed space-y-2 pl-5 list-disc">
                <li>Garantie de parfait achèvement et garantie des matériels ;</li>
                <li>Contrat de maintenance préventive et curative (à préciser : durée, délais d'intervention) ;</li>
                <li>Formation des exploitants à la supervision et au paramétrage de premier niveau ;</li>
                <li>Remise des accès, mots de passe et codes de paramétrage au maître d'ouvrage, garantissant son autonomie et la possibilité de changer de mainteneur.</li>
            </ul>
        </article>

        {{-- ART. 12 --}}
        <article id="art-12" class="scroll-mt-28">
            <p class="text-[13px] font-medium text-accent-600 tracking-widest mb-2">ARTICLE 12</p>
            <h2 class="text-[22px] lg:text-[26px] font-semibold text-dark-900 tracking-tight mb-4">Documents à remettre et jugement des offres</h2>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-3">Le titulaire remettra notamment : la liste des points (entrées/sorties), les analyses fonctionnelles, les schémas d'architecture et de réseau, les synoptiques de supervision et le dossier des ouvrages exécutés (DOE).</p>
            <p class="text-[15px] text-dark-600 leading-relaxed mb-3"><mark class="bg-orange-50 text-orange-900 px-1.5 py-0.5 rounded font-medium border border-orange-200">[à compléter]</mark> Critères de jugement suggérés :</p>
            <ul class="text-[15px] text-dark-600 leading-relaxed space-y-2 pl-5 list-disc">
                <li>Valeur technique (architecture, ouverture des protocoles, démonstration de l'atteinte de la classe B) ;</li>
                <li>Prix des prestations ;</li>
                <li>Qualité du mémoire technique et des références équivalentes ;</li>
                <li>Délais et conditions de maintenance.</li>
            </ul>
        </article>

    </div>
</section>

{{-- =========================================================================
     TÉLÉCHARGER — formulaire gaté (lead magnet) → PageController@downloadCctpModele
     ========================================================================= --}}
<section id="telecharger" class="scroll-mt-24 py-12 lg:py-24 bg-dark-50 border-t border-dark-200">
    <div class="max-w-2xl mx-auto px-5 lg:px-0">
        <div class="bg-white rounded-2xl border border-dark-100 lg:shadow-sm p-6 lg:p-10">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-3">Téléchargement gratuit</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Recevez le modèle au format Word</h2>
            <p class="text-base text-dark-500 leading-relaxed mb-6">Indiquez votre email pour télécharger la version <strong class="text-dark-700 font-medium">.docx modifiable</strong> (les 12 articles, prêts à adapter à votre bâtiment).</p>

            @if ($errors->any())
            <div class="mb-5 p-4 rounded-lg bg-orange-50 border border-orange-200" role="alert">
                <ul class="text-[14px] text-orange-900 space-y-1 pl-5 list-disc">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('front.cctp.download') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="cctp-email" class="block text-[13px] font-medium text-dark-700 mb-1.5">Email professionnel <span class="text-accent-600">*</span></label>
                    <input type="email" id="cctp-email" name="email" required value="{{ old('email') }}" autocomplete="email" placeholder="prenom@organisation.fr"
                        class="w-full px-4 py-3 text-[15px] bg-white border border-dark-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500" />
                </div>
                <div>
                    <label for="cctp-company" class="block text-[13px] font-medium text-dark-700 mb-1.5">Organisation <span class="text-dark-400 font-normal">(facultatif)</span></label>
                    <input type="text" id="cctp-company" name="company" value="{{ old('company') }}" autocomplete="organization" maxlength="100" placeholder="Nom de votre structure"
                        class="w-full px-4 py-3 text-[15px] bg-white border border-dark-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500" />
                </div>
                <label class="flex items-start gap-3 text-[13px] text-dark-600 leading-relaxed">
                    <input type="checkbox" name="consentement_rgpd" value="1" required class="mt-0.5 w-4 h-4 rounded border-dark-300 text-accent-600 focus:ring-accent-500" />
                    <span>J'accepte que mon email soit utilisé par NeoGTB pour me recontacter au sujet de ma demande. Aucune revente de données. <a href="/politique-de-confidentialite" class="text-accent-600 font-medium hover:text-accent-700 underline underline-offset-2">Politique de confidentialité</a>.</span>
                </label>
                <button type="submit" class="btn-primary w-full sm:w-auto">
                    Télécharger le modèle (Word)
                    <x-front.shared.icon name="document" class="w-4 h-4" />
                </button>
            </form>

            <p class="text-[12px] text-dark-400 mt-5">Document Word (.docx), ~40 Ko. Vous pouvez aussi lire le modèle complet ci-dessus ou l'imprimer en PDF.</p>
        </div>
    </div>
</section>

{{-- =========================================================================
     SOURCES (transparence — vrais CCTP de référence)
     ========================================================================= --}}
<section class="py-12 lg:py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-3xl mx-auto px-5 lg:px-0">
        <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Sources</p>
        <h2 class="text-[20px] lg:text-[24px] font-medium text-dark-900 tracking-tight mb-4">D'où vient cette trame</h2>
        <p class="text-[15px] text-dark-500 leading-relaxed mb-4">
            Ce modèle s'appuie sur la lecture de vrais CCTP de consultations publiques traitant du décret BACS,
            ainsi que sur le décret et la norme NF EN ISO 52120-1. Il consolide leur structure commune sous une
            forme neutre et réutilisable. Les références réglementaires sont reprises à l'identique de notre
            page <a href="/decret-bacs" class="text-accent-600 font-medium hover:text-accent-700">Décret BACS</a>.
        </p>
        <p class="text-[13px] text-dark-500 leading-relaxed">
            Exemples de CCTP réels traitant du décret BACS : marché de la Fédération Française de Judo (2025),
            marchés de la Métropole Aix-Marseille-Provence et de la Ville de Marseille (2025). Ces documents
            servent de référence de structure ; ils ne sont pas reproduits ici.
        </p>
    </div>
</section>

{{-- =========================================================================
     CTA FINAL
     ========================================================================= --}}
<section class="relative overflow-hidden py-14 lg:py-24 bg-white border-t border-dark-100">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 select-none">
        <span class="glow-halo glow-halo--accent w-[360px] h-[360px] -bottom-24 -right-16"></span>
        <span class="orb orb--outline orb--slow w-20 h-20 top-10 left-[10%]"></span>
    </div>
    <div class="relative z-10 max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-2xl">
            <h2 class="text-[24px] lg:text-[32px] font-semibold text-dark-900 tracking-tight leading-tight mb-3">Besoin d'un CCTP calé sur votre bâtiment ?</h2>
            <p class="text-base lg:text-lg text-dark-500 leading-relaxed mb-8">Notre AMO GTB/GTC rédige et adapte votre cahier des charges, pilote la consultation et vous accompagne jusqu'à la réception. Conseil indépendant, sans lien fabricant ni commission.</p>
            <div class="flex flex-wrap items-center gap-4">
                <a href="/amo-gtb-gtc" class="btn-primary">
                    Découvrir l'AMO GTB/GTC
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
<section class="py-12 lg:py-24 bg-white border-t border-dark-100">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="grid md:grid-cols-3 gap-4 lg:gap-6">
            @foreach([
                ['href' => '/decret-bacs', 'title' => 'Tout sur le décret BACS', 'desc' => 'Qui est concerné, échéances, classes et mise en conformité.'],
                ['href' => '/amo-gtb-gtc', 'title' => 'AMO GTB/GTC', 'desc' => 'Du cahier des charges à la réception, en passant par l\'appel d\'offres.'],
                ['href' => '/audit', 'title' => 'Pré-diagnostic GTB gratuit', 'desc' => 'Situez votre classe NF EN ISO 52120-1 en quelques minutes.'],
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
