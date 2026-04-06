@extends('front.layouts.app')

@section('title', 'FAQ — Questions fréquentes sur la GTB et NeoGTB')
@section('description', 'Réponses aux questions les plus fréquentes sur la GTB, le décret BACS, les outils NeoGTB et notre modèle d\'indépendance.')

@push('head')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "FAQPage",
    "mainEntity": [
        {"@@type":"Question","name":"Qu'est-ce que NeoGTB ?","acceptedAnswer":{"@@type":"Answer","text":"NeoGTB est un service de conseil indépendant spécialisé dans la Gestion Technique du Bâtiment (GTB). Créé par Ulrich Calmo via la société EYNOR, NeoGTB propose des outils gratuits et des prestations de conseil payantes. NeoGTB ne vend aucun équipement."}},
        {"@@type":"Question","name":"Comment NeoGTB gagne-t-il de l'argent ?","acceptedAnswer":{"@@type":"Answer","text":"NeoGTB vend du conseil, pas du matériel. Les revenus proviennent exclusivement de prestations de conseil technique : audits approfondis sur site, rédaction de cahiers des charges neutres, et assistance à maîtrise d'ouvrage GTB."}},
        {"@@type":"Question","name":"Pourquoi les outils sont-ils gratuits ?","acceptedAnswer":{"@@type":"Answer","text":"Les outils gratuits servent à éduquer le marché et à démontrer l'approche NeoGTB. Pas de piège : pas d'inscription obligatoire, pas de relance commerciale, pas de revente de données."}},
        {"@@type":"Question","name":"Êtes-vous vraiment indépendant ?","acceptedAnswer":{"@@type":"Answer","text":"Oui. EYNOR, la société derrière NeoGTB, n'a aucun actionnaire fabricant, aucun partenariat commercial rémunéré, aucun lien d'affiliation."}},
        {"@@type":"Question","name":"Qu'est-ce que la GTB ?","acceptedAnswer":{"@@type":"Answer","text":"La Gestion Technique du Bâtiment (GTB) est un système centralisé qui pilote et supervise les équipements techniques d'un bâtiment : chauffage, ventilation, climatisation, éclairage, stores, contrôle d'accès, comptage énergie."}},
        {"@@type":"Question","name":"Mon bâtiment est-il concerné par le décret BACS ?","acceptedAnswer":{"@@type":"Answer","text":"Si votre bâtiment est tertiaire et que sa puissance CVC dépasse 290 kW, vous devez avoir un système BACS de classe B minimum depuis le 1er janvier 2025. Pour les bâtiments entre 70 et 290 kW, l'échéance est fixée à 2030."}},
        {"@@type":"Question","name":"Que signifient les classes A, B, C, D de la norme ISO 52120-1 (ex-EN 15232) ?","acceptedAnswer":{"@@type":"Answer","text":"Classe D : aucune automatisation. Classe C : automatisation standard. Classe B : automatisation avancée avec supervision centralisée — niveau requis par le décret BACS. Classe A : haute performance avec optimisation énergétique et gestion prédictive."}},
        {"@@type":"Question","name":"Quel protocole choisir : BACnet, KNX ou Modbus ?","acceptedAnswer":{"@@type":"Answer","text":"BACnet est le standard international de la GTB pour les grands bâtiments tertiaires. KNX excelle pour l'éclairage et les stores. Modbus est simple et dominant pour le comptage énergie."}},
        {"@@type":"Question","name":"Combien coûte un audit GTB avec NeoGTB ?","acceptedAnswer":{"@@type":"Answer","text":"Le diagnostic en ligne est gratuit. Pour un audit approfondi sur site, les tarifs dépendent de la surface, du nombre de sites et de la complexité de l'installation."}},
        {"@@type":"Question","name":"Le diagnostic en ligne est-il fiable ?","acceptedAnswer":{"@@type":"Answer","text":"Le diagnostic en ligne est un outil d'orientation basé sur la norme ISO 52120-1. Il donne une estimation de votre niveau de maturité GTB. Pour un diagnostic certifié avec mesures sur site, un audit approfondi est nécessaire."}},
        {"@@type":"Question","name":"Dans quelle zone géographique intervenez-vous ?","acceptedAnswer":{"@@type":"Answer","text":"Les outils en ligne sont accessibles partout. Pour les prestations sur site, j'interviens principalement en Nouvelle-Aquitaine et sur l'ensemble du territoire français selon la mission."}}
    ]
}
</script>
@endpush

@section('content')

<!-- HERO -->
<section class="relative overflow-hidden" style="padding: 64px 0 48px; background: #edf5f7;">
    <img src="/images/hero-blog.png" alt="FAQ GTB — bâtiment intelligent" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: center;" loading="eager" fetchpriority="high" />
    <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(237,245,247,0.3) 0%, rgba(237,245,247,0.92) 100%);"></div>
    <div class="max-w-7xl mx-auto px-6 md:px-10 relative z-10">
        <div class="max-w-2xl">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">FAQ</p>
            <h1 class="font-heading text-3xl md:text-[40px] font-medium text-dark-900 leading-tight tracking-tight mb-4">
                Questions fréquentes
            </h1>
            <p class="text-[17px] text-dark-500 leading-relaxed max-w-lg">
                Tout ce que vous devez savoir sur NeoGTB, la GTB, le décret BACS et nos outils.
            </p>
        </div>
    </div>
</section>

<!-- FAQ SECTIONS -->
<section class="py-16">
    <div class="max-w-[720px] mx-auto px-6 md:px-10">

        @php
        $sections = [
            [
                'label' => 'À propos de NeoGTB',
                'items' => [
                    ['q' => "Qu'est-ce que NeoGTB ?", 'a' => "NeoGTB est un service de conseil indépendant spécialisé dans la Gestion Technique du Bâtiment (GTB). Créé par Ulrich Calmo via la société EYNOR, NeoGTB propose des outils gratuits (diagnostic, comparateur, générateur CEE) et des prestations de conseil payantes (audits sur site, cahiers des charges, AMO GTB). NeoGTB ne vend aucun équipement et n'a aucun lien commercial avec les fabricants."],
                    ['q' => "Comment NeoGTB gagne-t-il de l'argent ?", 'a' => "NeoGTB vend du conseil, pas du matériel. Les revenus proviennent exclusivement de prestations de conseil technique : audits approfondis sur site, rédaction de cahiers des charges neutres, et assistance à maîtrise d'ouvrage GTB. Les outils en ligne (diagnostic, comparateur, générateur CEE) sont gratuits et le resteront. Aucune commission n'est perçue sur les ventes de matériel ou les prescriptions."],
                    ['q' => "Pourquoi les outils sont-ils gratuits ?", 'a' => "Les outils gratuits servent à éduquer le marché et à démontrer l'approche NeoGTB. Pas de piège : pas d'inscription obligatoire, pas de relance commerciale, pas de revente de données. Si après avoir utilisé les outils vous souhaitez aller plus loin avec un audit sur site, vous pouvez me contacter — mais il n'y a aucune obligation."],
                    ['q' => "Êtes-vous vraiment indépendant ?", 'a' => "Oui. EYNOR, la société derrière NeoGTB, n'a aucun actionnaire fabricant, aucun partenariat commercial rémunéré, aucun lien d'affiliation. Les critères de comparaison sont publics et vérifiables sur le site. Si je recommande BACnet plutôt que LON pour votre projet, c'est une décision technique, pas commerciale. Vous pouvez consulter ma <a href='/positionnement' class='text-accent-600 hover:text-accent-700'>charte d'indépendance</a>."],
                ],
            ],
            [
                'label' => 'GTB & Réglementation',
                'items' => [
                    ['q' => "Qu'est-ce que la GTB ?", 'a' => "La Gestion Technique du Bâtiment (GTB) est un système centralisé qui pilote et supervise les équipements techniques d'un bâtiment : chauffage, ventilation, climatisation (CVC), éclairage, stores, contrôle d'accès, comptage énergie. L'objectif : optimiser la consommation énergétique, améliorer le confort et faciliter la maintenance. Pour un guide complet, consultez notre page <a href='/gtb' class='text-accent-600 hover:text-accent-700'>Qu'est-ce que la GTB ?</a>"],
                    ['q' => "Mon bâtiment est-il concerné par le décret BACS ?", 'a' => "Si votre bâtiment est tertiaire (bureaux, commerces, enseignement, santé...) et que sa puissance CVC dépasse 290 kW, vous devez avoir un système BACS de classe B minimum depuis le 1er janvier 2025. Pour les bâtiments entre 70 et 290 kW, l'échéance est fixée à 2030. Pour les bâtiments neufs avec permis postérieur au 21/07/2021, c'est obligatoire dès la construction. <a href='/audit' class='text-accent-600 hover:text-accent-700'>Faites le diagnostic gratuit</a> pour savoir où vous en êtes."],
                    ['q' => "Que signifient les classes A, B, C, D de la norme ISO 52120-1 (ex-EN 15232) ?", 'a' => "La norme ISO 52120-1 (ex-EN 15232) classe les systèmes de gestion technique en 4 niveaux. <strong>Classe D</strong> : aucune automatisation, pas performant. <strong>Classe C</strong> : automatisation standard, le minimum. <strong>Classe B</strong> : automatisation avancée avec supervision centralisée — c'est le niveau requis par le décret BACS. <strong>Classe A</strong> : haute performance, avec optimisation énergétique et gestion prédictive. Notre <a href='/audit' class='text-accent-600 hover:text-accent-700'>diagnostic gratuit</a> vous situe sur cette échelle."],
                    ['q' => "Quel protocole choisir : BACnet, KNX ou Modbus ?", 'a' => "Il n'y a pas de réponse universelle — ça dépend de votre contexte. <strong>BACnet</strong> est le standard international de la GTB, privilégié pour les grands bâtiments tertiaires et l'interopérabilité multi-marques. <strong>KNX</strong> excelle pour l'éclairage et les stores, avec 500+ fabricants certifiés. <strong>Modbus</strong> est simple et dominant pour le comptage énergie. Notre <a href='/comparateur' class='text-accent-600 hover:text-accent-700'>comparateur</a> vous aide à y voir clair sans biais commercial."],
                ],
            ],
            [
                'label' => 'Outils & Prestations',
                'items' => [
                    ['q' => "Combien coûte un audit GTB avec NeoGTB ?", 'a' => "Le diagnostic en ligne est gratuit, sans inscription. Pour un audit approfondi sur site avec rapport détaillé, les tarifs dépendent de la surface, du nombre de sites et de la complexité de l'installation. <a href='/contact' class='text-accent-600 hover:text-accent-700'>Contactez-moi</a> avec votre contexte pour obtenir un devis. Comptez un premier échange gratuit de 15 minutes pour cadrer votre besoin."],
                    ['q' => "Le diagnostic en ligne est-il fiable ?", 'a' => "Le diagnostic en ligne est un outil d'orientation basé sur la norme ISO 52120-1. Il donne une estimation de votre niveau de maturité GTB (classe A à D) et des recommandations générales. Pour un diagnostic certifié avec mesures sur site, un audit approfondi est nécessaire. L'outil en ligne est un excellent point de départ pour savoir si vous avez besoin d'aller plus loin."],
                    ['q' => "Dans quelle zone géographique intervenez-vous ?", 'a' => "Les outils en ligne sont accessibles partout. Pour les prestations sur site (audits, AMO), j'interviens principalement en Nouvelle-Aquitaine et sur l'ensemble du territoire français selon la mission. Les échanges préliminaires et le conseil à distance se font sans contrainte géographique."],
                ],
            ],
        ];
        @endphp

        @foreach($sections as $section)
        <div class="mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-6">{{ $section['label'] }}</p>

            @foreach($section['items'] as $index => $item)
            <div x-data="{ open: false }" class="border-t border-dark-200 @if($loop->last) border-b @endif">
                <button @click="open = !open" class="w-full flex items-center justify-between py-5 text-left bg-transparent border-none cursor-pointer">
                    <span class="text-[15px] font-medium text-dark-900 pr-4">{{ $item['q'] }}</span>
                    <svg :class="open && 'rotate-180'" class="w-4 h-4 text-dark-400 transition-transform duration-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse>
                    <p class="text-sm text-dark-500 leading-relaxed pb-5">{!! $item['a'] !!}</p>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach

        <!-- CTA -->
        <div class="text-center pt-10">
            <p class="text-base text-dark-500 mb-4">Vous avez une autre question ?</p>
            <a href="/contact" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition-colors btn-glow">
                Poser ma question
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
                ['href' => '/audit', 'title' => 'Audit GTB gratuit', 'desc' => 'Diagnostiquez votre bâtiment en 5 minutes.'],
                ['href' => '/contact', 'title' => 'Contactez-nous', 'desc' => 'Une question ? Réponse sous 48h, sans démarche commerciale.'],
                ['href' => '/gtb', 'title' => "Qu'est-ce que la GTB ?", 'desc' => 'Le guide complet pour tout comprendre.'],
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
