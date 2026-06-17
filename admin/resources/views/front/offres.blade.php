@extends('front.layouts.app')

{{--
    Page /offres — HUB des offres réelles NeoGTB (tiers de confiance indépendant).
    Source de contenu (vérifiée, AUCUNE invention) :
      - docs/refonte-contenu-credibilite.md §4 (3 formules + prix tranchés 2026-06-15)
      - offre-conformite-continue.blade.php (offre packagée "conformité continue")
    Prix réels : Audit sur site = 700 € HT ; CCTP, AMO, conformité continue = sur devis.
    Light mode imposé (règle dure) : hero clair, titre sombre, pas de dark:, pas de x-front.shared.hero.
--}}

@section('title', 'Nos offres GTB/GTC : audit, cahier des charges, AMO | NeoGTB')
@section('description', 'Les offres NeoGTB, 100 % indépendantes : audit GTB sur site (700 € HT), cahier des charges neutre, AMO complète et conformité continue (suivi + OPERAT). 0 € de commission fabricant.')

@section('content')

{{-- JSON-LD OfferCatalog : prestations réelles (cohérence entité <-> contenu visible). ld+json exempté CSP, nonce par cohérence. --}}
@push('schema')
<script type="application/ld+json" @cspNonce>
@verbatim
{"@context":"https://schema.org","@type":"OfferCatalog","name":"Offres NeoGTB — conseil GTB/GTC indépendant","provider":{"@type":"Organization","name":"NeoGTB","url":"https://neogtb.fr"},"itemListElement":[{"@type":"Offer","itemOffered":{"@type":"Service","name":"Audit GTB sur site","serviceType":"Audit de conformité GTB / décret BACS"},"priceSpecification":{"@type":"PriceSpecification","price":"700","priceCurrency":"EUR","valueAddedTaxIncluded":false},"areaServed":"FR"},{"@type":"Offer","itemOffered":{"@type":"Service","name":"Cahier des charges GTB neutre","serviceType":"Rédaction de CCTP GTB multi-protocoles"},"areaServed":"FR"},{"@type":"Offer","itemOffered":{"@type":"Service","name":"AMO GTB/GTC","serviceType":"Assistance à maîtrise d'ouvrage GTB"},"areaServed":"FR"},{"@type":"Offer","itemOffered":{"@type":"Service","name":"Conformité continue","serviceType":"Suivi de conformité décret BACS et déclaration OPERAT"},"areaServed":"FR"}]}
@endverbatim
</script>
@endpush

{{-- ============================================================
     HERO — LIGHT MODE custom (titre sombre, fond clair, orbs décoratifs)
     ============================================================ --}}
<section class="relative overflow-hidden bg-white border-b border-dark-100">
    <div aria-hidden="true" class="glow-halo glow-halo--accent -top-24 -left-16 h-72 w-72"></div>
    <div aria-hidden="true" class="glow-halo glow-halo--primary top-10 right-0 h-80 w-80"></div>
    <div aria-hidden="true" class="orb orb--filled orb--slow top-24 right-24 h-24 w-24" style="--halo-color: rgba(45, 139, 78, 0.12);"></div>
    <div aria-hidden="true" class="orb orb--outline orb--reverse orb--delay bottom-16 left-1/3 h-16 w-16"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-5 lg:px-10 py-16 lg:py-24">
        <div class="max-w-3xl animate-fade-in-up">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Nos offres</p>
            <h1 class="text-[30px] lg:text-[44px] font-medium text-dark-900 tracking-tight leading-[1.1] mb-5">
                Du conseil GTB, jamais une commission
            </h1>
            <p class="text-base lg:text-lg text-dark-500 leading-relaxed mb-8">
                À la carte ou dans la durée : choisissez le niveau d'accompagnement qui correspond à votre projet.
                Sur chaque mission, le principe est le même — aucun matériel vendu, aucune commission fabricant.
                Vous payez un avis indépendant, pas une marque déguisée.
            </p>
            <div class="flex flex-wrap gap-4">
                <x-front.shared.btn-primary href="#offres">Voir les offres</x-front.shared.btn-primary>
                <a href="/audit" class="inline-flex items-center gap-1.5 px-6 py-3 text-sm font-medium text-dark-600 border border-dark-300 rounded-lg hover:bg-dark-50 transition-colors">
                    Pré-diagnostic gratuit
                </a>
            </div>
        </div>
        @include('front.partials.reassurance-badges', ['class' => 'mt-10 justify-start'])
    </div>
</section>

{{-- ============================================================
     PRESTATIONS À LA CARTE — 3 formules (doc crédibilité §4)
     ============================================================ --}}
<section id="offres" class="py-12 lg:py-24">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-2xl mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">À la carte</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Trois prestations, selon votre besoin</h2>
            <p class="text-base text-dark-500 leading-relaxed">De l'objectivation de l'existant jusqu'à l'accompagnement complet du projet.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-5 lg:gap-6 items-stretch">
            {{-- 1 · Audit GTB sur site (700 € HT) --}}
            <div class="flex flex-col bg-white rounded-2xl p-6 lg:p-8 border border-dark-100 lg:shadow-sm">
                <span class="inline-block self-start text-[13px] font-medium text-white bg-accent-600 px-3 py-1 rounded-md mb-4">Audit GTB sur site</span>
                <p class="text-[15px] text-dark-500 leading-relaxed mb-5">Pour objectiver l'état réel de votre bâtiment avant d'investir.</p>
                <ul class="space-y-2.5 text-[14px] text-dark-700 leading-relaxed mb-6">
                    @foreach([
                        'Visite et relevé des lots techniques',
                        'Classification ISO 52120-1 vérifiée sur site',
                        'Plan d\'actions chiffré et priorisé',
                        'Estimation CEE (BAT-TH-116 / 112)',
                        'Point de conformité décret BACS',
                    ] as $item)
                    <li class="flex gap-2.5"><svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-accent-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg><span>{{ $item }}</span></li>
                    @endforeach
                </ul>
                <p class="text-[13px] text-dark-500 mb-1">Rapport 20+ pages + restitution commentée · délai 3-4 semaines (indicatif)</p>
                <div class="mt-auto pt-5">
                    <p class="text-[22px] font-medium text-dark-900 mb-4">700 € HT</p>
                    <x-front.shared.btn-primary href="/contact">Demander un audit</x-front.shared.btn-primary>
                </div>
            </div>

            {{-- 2 · Cahier des charges GTB neutre (sur devis) --}}
            <div class="flex flex-col bg-white rounded-2xl p-6 lg:p-8 border border-dark-100 lg:shadow-sm">
                <span class="inline-block self-start text-[13px] font-medium text-white bg-accent-600 px-3 py-1 rounded-md mb-4">Cahier des charges neutre</span>
                <p class="text-[15px] text-dark-500 leading-relaxed mb-5">Pour un CCTP qui n'avantage aucune marque ni protocole.</p>
                <ul class="space-y-2.5 text-[14px] text-dark-700 leading-relaxed mb-6">
                    @foreach([
                        'Expression de besoin fonctionnelle',
                        'Specs ouvertes multi-protocoles (BACnet / KNX / Modbus / DALI)',
                        'Critères d\'évaluation objectifs',
                        'Exigences d\'interopérabilité (anti-verrouillage)',
                    ] as $item)
                    <li class="flex gap-2.5"><svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-accent-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg><span>{{ $item }}</span></li>
                    @endforeach
                </ul>
                <p class="text-[13px] text-dark-500 mb-1">CCTP prêt à diffuser + grille de dépouillement · délai 3-5 semaines (indicatif)</p>
                <div class="mt-auto pt-5">
                    <p class="text-[22px] font-medium text-dark-900 mb-4">Sur devis</p>
                    <x-front.shared.btn-primary href="/contact">Demander un devis</x-front.shared.btn-primary>
                </div>
            </div>

            {{-- 3 · AMO GTB (sur devis) → page dédiée --}}
            <div class="flex flex-col bg-white rounded-2xl p-6 lg:p-8 border border-dark-100 lg:shadow-sm">
                <span class="inline-block self-start text-[13px] font-medium text-white bg-accent-600 px-3 py-1 rounded-md mb-4">AMO GTB / GTC</span>
                <p class="text-[15px] text-dark-500 leading-relaxed mb-5">Pour un projet d'envergure accompagné de bout en bout.</p>
                <ul class="space-y-2.5 text-[14px] text-dark-700 leading-relaxed mb-6">
                    @foreach([
                        'Méthode NeoGTB en 4 phases',
                        'Assistance choix intégrateur + dépouillement',
                        'Suivi de chantier + recette technique',
                        'Transfert de compétences aux exploitants',
                    ] as $item)
                    <li class="flex gap-2.5"><svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-accent-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg><span>{{ $item }}</span></li>
                    @endforeach
                </ul>
                <p class="text-[13px] text-dark-500 mb-1">Mission par lots, comptes rendus d'étape, recette documentée</p>
                <div class="mt-auto pt-5">
                    <p class="text-[22px] font-medium text-dark-900 mb-4">Sur devis</p>
                    <x-front.shared.btn-primary href="/amo-gtb-gtc">Découvrir l'AMO</x-front.shared.btn-primary>
                </div>
            </div>
        </div>

        {{-- Garantie transversale (doc crédibilité §4) --}}
        <div class="bg-dark-50 border border-dark-200 rounded-2xl p-5 lg:p-6 mt-6">
            <p class="text-sm text-dark-600 leading-relaxed text-center">Sur chaque mission : <strong class="text-dark-900">0 € de commission fabricant</strong> · méthode <strong class="text-dark-900">NF EN ISO 52120-1</strong> · livrable et délai écrits dans le devis.</p>
        </div>
    </div>
</section>

{{-- ============================================================
     DANS LA DURÉE — Conformité continue (offre packagée) → page dédiée
     ============================================================ --}}
<section class="py-12 lg:py-24 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-2xl mb-10">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Dans la durée</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Conformité continue : un seul interlocuteur, chaque année</h2>
            <p class="text-base text-dark-500 leading-relaxed">Le décret BACS impose un suivi en continu et des inspections périodiques. Cette offre packagée couvre tout le cycle, année après année.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-4 lg:gap-6 mb-6">
            @foreach([
                ['n' => '1', 'titre' => 'Auditer', 'desc' => 'Audit de conformité BACS : assujettissement, échéance, classe ISO 52120-1, écart et plan d\'actions.'],
                ['n' => '2', 'titre' => 'Équiper', 'desc' => 'Mise en place du suivi énergétique via un cahier des charges neutre, en AMO côté maître d\'ouvrage.'],
                ['n' => '3', 'titre' => 'Déclarer', 'desc' => 'Accompagnement OPERAT annuel : fiabilisation des données, avancement décret tertiaire, déclaration.'],
            ] as $temps)
            <div class="bg-white rounded-2xl p-5 lg:p-7 border border-dark-100 lg:shadow-sm">
                <span class="inline-block text-[13px] font-medium text-white bg-accent-600 px-3 py-1 rounded-md mb-4">{{ $temps['n'] }} · {{ $temps['titre'] }}</span>
                <p class="text-[15px] text-dark-500 leading-relaxed">{{ $temps['desc'] }}</p>
            </div>
            @endforeach
        </div>
        <div class="flex flex-wrap items-center gap-4">
            <x-front.shared.btn-primary href="/offre-conformite-continue">Voir l'offre conformité continue</x-front.shared.btn-primary>
            <span class="text-[13px] text-dark-500">Abonnement annuel par bâtiment · sur devis</span>
        </div>
    </div>
</section>

{{-- ============================================================
     OUTIL GRATUIT — point d'entrée
     ============================================================ --}}
<section class="py-12 lg:py-20">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="bg-accent-50 border border-accent-200 rounded-2xl p-6 lg:p-8 flex flex-col lg:flex-row lg:items-center gap-5 lg:gap-8">
            <div class="flex-1">
                <h2 class="text-[18px] lg:text-[22px] font-medium text-dark-900 tracking-tight mb-2">Pas encore prêt à investir ?</h2>
                <p class="text-[15px] text-dark-600 leading-relaxed">Le pré-diagnostic GTB en ligne est gratuit : votre classe ISO 52120-1, votre benchmark et vos pistes CEE en 3 minutes, sans inscription ni relance.</p>
            </div>
            <div class="flex-shrink-0">
                <x-front.shared.btn-primary href="/audit">Lancer le pré-diagnostic gratuit</x-front.shared.btn-primary>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     CTA FINAL
     ============================================================ --}}
<section class="py-12 lg:py-24 bg-dark-50 border-t border-dark-200">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="bg-white border border-dark-200 rounded-3xl p-8 lg:p-12">
            <div class="max-w-2xl">
                <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Parlons de votre bâtiment</h2>
                <p class="text-base text-dark-500 leading-relaxed mb-7">Décrivez-nous votre projet et votre échéance : nous vous orientons vers la bonne prestation. Réponse sous 48 h, sans engagement.</p>
                <div class="flex flex-wrap gap-4">
                    <x-front.shared.btn-primary href="/contact">Parler à un expert</x-front.shared.btn-primary>
                    <a href="/audit" class="inline-flex items-center gap-1.5 px-6 py-3 text-sm font-medium text-dark-600 border border-dark-300 rounded-lg hover:bg-dark-50 transition-colors">
                        Lancer le pré-diagnostic gratuit
                    </a>
                </div>
                <p class="text-[13px] text-dark-500 mt-5">Une question directe ? <a href="mailto:hello@neogtb.fr" class="text-accent-600 font-medium hover:text-accent-700">hello@neogtb.fr</a></p>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     PAGES LIÉES
     ============================================================ --}}
<section class="py-12 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="grid md:grid-cols-3 gap-4 lg:gap-6">
            @foreach([
                ['href' => '/decret-bacs', 'title' => 'Décret BACS', 'desc' => 'Qui est concerné, quelle classe, quelle échéance.'],
                ['href' => '/amo-gtb-gtc', 'title' => 'AMO GTB / GTC', 'desc' => 'Le détail de notre mission d\'assistance à maîtrise d\'ouvrage.'],
                ['href' => '/audit', 'title' => 'Pré-diagnostic gratuit', 'desc' => 'Évaluez votre conformité ISO 52120-1 en quelques minutes.'],
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
