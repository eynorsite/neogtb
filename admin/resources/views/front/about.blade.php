@extends('front.layouts.app')

@section('title', 'A propos — Ulrich Calmo, consultant GTB')
@section('description', 'NeoGTB est fonde par Ulrich Calmo, consultant GTB independant base a Bordeaux. Zero lien fabricant, zero commission.')

@section('content')

<!-- HERO -->
<section class="relative overflow-hidden bg-gradient-to-br from-dark-50 to-dark-100" style="padding: 80px 0 64px;">
    <div class="absolute inset-0 bg-grid-pattern opacity-30"></div>
    <div class="max-w-7xl mx-auto px-6 md:px-10 relative z-10">
        <div class="max-w-2xl">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">A propos</p>
            <h1 class="font-heading text-4xl md:text-5xl font-medium text-dark-900 leading-tight tracking-tight mb-5">
                Je suis Ulrich Calmo, et j'ai cree <span class="text-gradient">NeoGTB</span> pour une raison simple
            </h1>
            <p class="text-lg text-dark-500 leading-relaxed max-w-xl">
                Le marche de la GTB en France manque d'un interlocuteur neutre. Quelqu'un qui ne vend rien, qui connait le terrain, et qui vous aide a prendre la bonne decision. C'est ce que je fais.
            </p>
        </div>
    </div>
</section>

<!-- FONDATEUR -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 lg:gap-16 items-start">

            <!-- Left: createur -->
            <div class="lg:col-span-2" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
                <div class="bg-white rounded-xl p-8 border border-dark-200 shadow-sm">
                    <img src="/images/ulrich-calmo.webp" alt="Ulrich Calmo, createur de la marque NeoGTB" width="120" height="120" loading="lazy" decoding="async" class="w-[120px] h-[120px] rounded-full object-cover mx-auto mb-5 border-[3px] border-accent-300" />
                    <p class="text-[22px] font-medium text-dark-900 text-center mb-1">Ulrich Calmo</p>
                    <p class="text-sm font-medium text-accent-600 text-center mb-1">Fondateur de NeoGTB</p>
                    <p class="text-xs text-dark-400 text-center mb-5">EYNOR — Eysines, Bordeaux</p>
                    <div class="w-full h-px bg-dark-200 mb-5"></div>

                    <p class="text-xs font-semibold uppercase tracking-widest text-dark-400 mb-3">Domaines d'expertise</p>
                    <ul class="space-y-2.5">
                        <li class="flex items-center gap-3">
                            <div class="w-1.5 h-1.5 rounded-full bg-accent-500 flex-shrink-0"></div>
                            <span class="text-sm text-dark-500">GTB / GTC / Supervision batiment</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-1.5 h-1.5 rounded-full bg-accent-500 flex-shrink-0"></div>
                            <span class="text-sm text-dark-500">Protocoles : BACnet, KNX, Modbus, LON</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-1.5 h-1.5 rounded-full bg-accent-500 flex-shrink-0"></div>
                            <span class="text-sm text-dark-500">Reglementation : decret BACS, tertiaire</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-1.5 h-1.5 rounded-full bg-accent-500 flex-shrink-0"></div>
                            <span class="text-sm text-dark-500">Audit energetique & AMO GTB</span>
                        </li>
                    </ul>

                    <a href="https://www.linkedin.com/in/ulrich-calmo/" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 mt-6 text-sm text-accent-600 font-medium hover:text-accent-700 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        Voir mon profil LinkedIn
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div class="bg-white rounded-xl p-5 text-center border border-dark-200 shadow-sm">
                        <p class="text-[28px] font-medium text-dark-900 tracking-tight">10+</p>
                        <p class="text-xs text-dark-400 mt-1">technologies analysees</p>
                    </div>
                    <div class="bg-white rounded-xl p-5 text-center border border-dark-200 shadow-sm">
                        <p class="text-[28px] font-medium text-dark-900 tracking-tight">41</p>
                        <p class="text-xs text-dark-400 mt-1">protocoles references</p>
                    </div>
                    <div class="bg-white rounded-xl p-5 text-center border border-dark-200 shadow-sm">
                        <p class="text-[28px] font-medium text-accent-600 tracking-tight">0 &euro;</p>
                        <p class="text-xs text-dark-400 mt-1">commission fabricant</p>
                    </div>
                    <div class="bg-white rounded-xl p-5 text-center border border-dark-200 shadow-sm">
                        <p class="text-[28px] font-medium text-dark-900 tracking-tight">100 %</p>
                        <p class="text-xs text-dark-400 mt-1">independant</p>
                    </div>
                </div>
            </div>

            <!-- Right: parcours + conviction -->
            <div class="lg:col-span-3" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
                <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-6">Pourquoi j'ai cree NeoGTB</h2>

                <p class="text-base text-dark-500 leading-relaxed mb-4">
                    En travaillant sur des projets de gestion technique du batiment, j'ai constate un probleme recurrent : <strong class="text-dark-900 font-medium">les decideurs n'ont personne vers qui se tourner pour un avis neutre.</strong> Chaque interlocuteur vend sa solution. Les bureaux d'etudes prescrivent ce qu'ils connaissent. Les installateurs poussent leurs partenariats.
                </p>
                <p class="text-base text-dark-500 leading-relaxed mb-4">
                    J'ai cree NeoGTB pour combler ce vide. Ma mission : <strong class="text-dark-900 font-medium">eduquer le marche francais sur la GTB</strong>, fournir des outils d'analyse independants, et permettre a chaque professionnel de comprendre, comparer et decider en connaissance de cause.
                </p>
                <p class="text-base text-dark-500 leading-relaxed mb-4">
                    NeoGTB est une marque de ma societe <strong class="text-dark-900 font-medium">EYNOR</strong>, basee a Eysines pres de Bordeaux. Je travaille seul, et c'est un choix assume : pas d'actionnaires fabricants, pas de pression commerciale, pas de compromis sur les recommandations.
                </p>
                <p class="text-base text-dark-500 leading-relaxed mb-8">
                    Mon seul engagement, c'est envers vous : vous donner les cles pour decider en toute connaissance de cause, sans qu'un interet commercial vienne fausser l'analyse.
                </p>

                <!-- Ce que je fais concretement -->
                <div class="space-y-3.5 mb-8">
                    <div class="flex items-start gap-3">
                        <div class="w-1.5 h-1.5 rounded-full bg-accent-500 flex-shrink-0 mt-2.5"></div>
                        <p class="text-[15px] text-dark-600 leading-relaxed"><strong class="font-medium text-dark-900">Je fais du conseil payant, les outils sont gratuits.</strong> Mon revenu vient exclusivement de prestations de conseil — audits sur site, cahiers des charges neutres, AMO GTB.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-1.5 h-1.5 rounded-full bg-accent-500 flex-shrink-0 mt-2.5"></div>
                        <p class="text-[15px] text-dark-600 leading-relaxed"><strong class="font-medium text-dark-900">Zero lien commercial avec les fabricants.</strong> Pas de commission, pas d'affiliation, pas de partenariat remunere. Jamais.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-1.5 h-1.5 rounded-full bg-accent-500 flex-shrink-0 mt-2.5"></div>
                        <p class="text-[15px] text-dark-600 leading-relaxed"><strong class="font-medium text-dark-900">Mes criteres de comparaison sont publics.</strong> Chaque analyse est verifiable. Si je recommande BACnet plutot que LON, c'est technique, pas commercial.</p>
                    </div>
                </div>

                <!-- Charte d'independance -->
                <div class="bg-accent-50 border border-accent-200 rounded-xl p-6">
                    <p class="text-xs font-semibold uppercase tracking-widest text-accent-700 mb-4">Ma charte d'independance</p>
                    <ul class="space-y-3">
                        @foreach([
                            'Aucun lien commercial avec les fabricants GTB',
                            'Aucune commission sur les ventes ou prescriptions',
                            'Methodologie d\'evaluation transparente et verifiable',
                            'Vos donnees ne sont jamais transmises a des tiers',
                            'Correction ouverte en cas d\'erreur factuelle',
                        ] as $item)
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-accent-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span class="text-sm text-dark-600 leading-relaxed">{{ $item }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- METHODE -->
<section class="py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="max-w-xl mb-12" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Mon approche</p>
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Ma methode — 4 phases</h2>
            <p class="text-base text-dark-500 leading-relaxed">Une approche structuree pour accompagner chaque projet GTB, du diagnostic a la mise en oeuvre.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @php
            $steps = [
                ['num' => '01', 'title' => 'Etat des lieux', 'desc' => "J'audite l'existant : equipements en place, protocoles utilises, niveau d'integration, points de friction.", 'highlight' => false],
                ['num' => '02', 'title' => 'Analyse comparative', 'desc' => "J'evalue les solutions disponibles. Comparaison par criteres objectifs : interoperabilite, cout, evolutivite.", 'highlight' => false],
                ['num' => '03', 'title' => 'Recommandations', 'desc' => "Je vous livre une synthese argumentee. Chaque recommandation est justifiee, tracable et libre de conflit d'interets.", 'highlight' => true],
                ['num' => '04', 'title' => 'Accompagnement', 'desc' => "Je suis la mise en oeuvre, verifie la conformite et transfere les competences a vos equipes internes.", 'highlight' => false],
            ];
            @endphp
            @foreach($steps as $step)
            <div class="{{ $step['highlight'] ? 'bg-white rounded-xl border border-accent-200 shadow-[0_0_0_3px] shadow-accent-50' : 'bg-white rounded-xl border border-dark-200 shadow-sm' }} p-6 card-hover" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
                <p class="text-[40px] font-medium {{ $step['highlight'] ? 'text-accent-400' : 'text-dark-200' }} leading-none mb-4 tracking-tight">{{ $step['num'] }}</p>
                <h3 class="text-[15px] font-medium text-dark-900 mb-2">{{ $step['title'] }}</h3>
                <p class="text-[13px] text-dark-500 leading-relaxed">{{ $step['desc'] }}</p>
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
            <h2 class="text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">Un projet GTB a clarifier ?</h2>
            <p class="text-base text-dark-500 leading-relaxed mb-7">Echangeons sur votre situation. Sans engagement, sans pression commerciale.</p>
            <a href="/contact" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition-colors btn-glow">
                Me contacter directement
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
                ['href' => '/positionnement', 'title' => 'Pourquoi NeoGTB ?', 'desc' => 'Les preuves de notre independance totale.'],
                ['href' => '/contact', 'title' => 'Contactez Ulrich', 'desc' => 'Discutons de votre projet GTB sans engagement.'],
                ['href' => '/audit', 'title' => 'Audit GTB gratuit', 'desc' => 'Diagnostiquez votre batiment en 5 minutes.'],
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
