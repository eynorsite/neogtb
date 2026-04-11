@extends('front.layouts.app')


@push('head')
@verbatim
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        {"@type":"Question","name":"Qu'est-ce que NeoGTB ?","acceptedAnswer":{"@type":"Answer","text":"NeoGTB est un service de conseil indépendant spécialisé dans la Gestion Technique du Bâtiment (GTB). Créé par Ulrich Calmo via la société EYNOR, NeoGTB propose des outils gratuits et des prestations de conseil payantes. NeoGTB ne vend aucun équipement."}},
        {"@type":"Question","name":"Comment NeoGTB gagne-t-il de l'argent ?","acceptedAnswer":{"@type":"Answer","text":"NeoGTB vend du conseil, pas du matériel. Les revenus proviennent exclusivement de prestations de conseil technique : audits approfondis sur site, rédaction de cahiers des charges neutres, et assistance à maîtrise d'ouvrage GTB."}},
        {"@type":"Question","name":"Pourquoi les outils sont-ils gratuits ?","acceptedAnswer":{"@type":"Answer","text":"Les outils gratuits servent à éduquer le marché et à démontrer l'approche NeoGTB. Pas de piège : pas d'inscription obligatoire, pas de relance commerciale, pas de revente de données."}},
        {"@type":"Question","name":"Êtes-vous vraiment indépendant ?","acceptedAnswer":{"@type":"Answer","text":"Oui. EYNOR, la société derrière NeoGTB, n'a aucun actionnaire fabricant, aucun partenariat commercial rémunéré, aucun lien d'affiliation."}},
        {"@type":"Question","name":"Qu'est-ce que la GTB ?","acceptedAnswer":{"@type":"Answer","text":"La Gestion Technique du Bâtiment (GTB) est un système centralisé qui pilote et supervise les équipements techniques d'un bâtiment : chauffage, ventilation, climatisation, éclairage, stores, contrôle d'accès, comptage énergie."}},
        {"@type":"Question","name":"Mon bâtiment est-il concerné par le décret BACS ?","acceptedAnswer":{"@type":"Answer","text":"Si votre bâtiment est tertiaire et que sa puissance CVC dépasse 290 kW, vous devez avoir un système BACS de classe B minimum depuis le 1er janvier 2025. Pour les bâtiments entre 70 et 290 kW, l'échéance est fixée à 2030."}},
        {"@type":"Question","name":"Que signifient les classes A, B, C, D de la norme ISO 52120-1 (ex-EN 15232) ?","acceptedAnswer":{"@type":"Answer","text":"Classe D : aucune automatisation. Classe C : automatisation standard. Classe B : automatisation avancée avec supervision centralisée — niveau requis par le décret BACS. Classe A : haute performance avec optimisation énergétique et gestion prédictive."}},
        {"@type":"Question","name":"Quel protocole choisir : BACnet, KNX ou Modbus ?","acceptedAnswer":{"@type":"Answer","text":"BACnet est le standard international de la GTB pour les grands bâtiments tertiaires. KNX excelle pour l'éclairage et les stores. Modbus est simple et dominant pour le comptage énergie."}},
        {"@type":"Question","name":"Combien coûte un audit GTB avec NeoGTB ?","acceptedAnswer":{"@type":"Answer","text":"Le diagnostic en ligne est gratuit. Pour un audit approfondi sur site, les tarifs dépendent de la surface, du nombre de sites et de la complexité de l'installation."}},
        {"@type":"Question","name":"Le diagnostic en ligne est-il fiable ?","acceptedAnswer":{"@type":"Answer","text":"Le diagnostic en ligne est un outil d'orientation basé sur la norme ISO 52120-1. Il donne une estimation de votre niveau de maturité GTB. Pour un diagnostic certifié avec mesures sur site, un audit approfondi est nécessaire."}},
        {"@type":"Question","name":"Dans quelle zone géographique intervenez-vous ?","acceptedAnswer":{"@type":"Answer","text":"Les outils en ligne sont accessibles partout. Pour les prestations sur site, j'interviens principalement en Nouvelle-Aquitaine et sur l'ensemble du territoire français selon la mission."}}
    ]
}
</script>
@endverbatim
@endpush

@section('content')

<!-- HERO -->
<section class="relative overflow-hidden" style="padding: 64px 0 48px; background: #edf5f7;">
    <!-- TODO: créer hero-faq.webp dédié, image partagée temporairement avec /blog -->
    <img src="/images/hero-blog.png" alt="FAQ GTB — bâtiment intelligent" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: center;" loading="eager" fetchpriority="high" />
    <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(237,245,247,0.3) 0%, rgba(237,245,247,0.92) 100%);"></div>
    <div class="max-w-7xl mx-auto px-5 lg:px-10 relative z-10">
        <div class="max-w-2xl">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">{{ $site->label('faq.eyebrow', 'Questions fréquentes') }}</p>
            <h1 class="font-heading text-[30px] lg:text-[44px] font-medium text-dark-900 leading-tight tracking-tight mb-4">
                {{ $site->label('faq.title', 'Vos questions sur la GTB/GTC') }}
            </h1>
            <p class="text-[17px] text-dark-500 leading-relaxed max-w-lg">
                {{ $site->label('faq.subtitle', 'Tout ce que vous devez savoir sur la Gestion Technique du Bâtiment et la conformité réglementaire') }}
            </p>
        </div>
    </div>
</section>

<!-- FAQ SECTIONS -->
<section class="py-12 lg:py-24">
    <div class="max-w-[720px] mx-auto px-5 lg:px-10">

        @php
        // Les catégories Q/R sont administrables depuis Filament (onglet Pages → Page FAQ)
        $faqPageConfig = $site->get('faq_page_config', []);
        $faqSections = data_get($faqPageConfig, 'sections', []);
        @endphp

        @foreach($faqSections as $section)
        @php $items = $section['items'] ?? []; @endphp
        @if(!empty($items))
        <div class="mb-12">
            @if(!empty($section['label']))
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-6">{{ $section['label'] }}</p>
            @endif

            @foreach($items as $index => $item)
            <div x-data="{ open: false }" class="border-t border-dark-200 @if($loop->last) border-b @endif">
                <button @click="open = !open" class="w-full flex items-center justify-between py-5 min-h-[56px] text-left bg-transparent border-none cursor-pointer">
                    <span class="text-[15px] font-medium text-dark-900 pr-4">{{ $item['question'] ?? '' }}</span>
                    <svg :class="open && 'rotate-180'" class="w-4 h-4 text-dark-400 transition-transform duration-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse>
                    <p class="text-sm text-dark-500 leading-relaxed pb-5">{!! $item['answer'] ?? '' !!}</p>
                </div>
            </div>
            @endforeach
        </div>
        @endif
        @endforeach

        <!-- CTA -->
        <div class="text-center pt-10">
            <p class="text-base text-dark-500 mb-4">{{ $site->label('faq.cta_text', 'Vous ne trouvez pas votre réponse ?') }}</p>
            <a href="/contact" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition-colors btn-glow">
                {{ $site->label('faq.cta_button', 'Contactez un expert') }}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

    </div>
</section>

<!-- Related pages -->
<section class="py-12 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="grid md:grid-cols-3 gap-4 lg:gap-6">
            @foreach([
                ['href' => '/audit', 'title' => 'Audit GTB gratuit', 'desc' => 'Diagnostiquez votre bâtiment en 5 minutes.'],
                ['href' => '/contact', 'title' => 'Contactez-nous', 'desc' => 'Une question ? Réponse sous 48h, sans démarche commerciale.'],
                ['href' => '/gtb', 'title' => "Qu'est-ce que la GTB ?", 'desc' => 'Le guide complet pour tout comprendre.'],
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
