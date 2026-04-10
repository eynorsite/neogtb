@extends('front.layouts.app')


@section('content')

<!-- HERO -->
<section class="relative overflow-hidden" style="padding: 100px 0 80px; min-height: 420px; background: #edf5f7;">
    <img src="/images/hero-about.png" alt="Consultant indépendant GTB au centre des bâtiments" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: center;" loading="eager" fetchpriority="high" />
    <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(237,245,247,0.15) 0%, rgba(237,245,247,0.88) 60%, rgba(237,245,247,1) 100%);"></div>
    <div class="max-w-7xl mx-auto px-5 lg:px-10 relative z-10">
        <div class="max-w-2xl">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">{{ $site->label('about.hero.eyebrow', 'À propos') }}</p>
            <h1 class="font-heading text-[30px] lg:text-[44px] font-medium text-dark-900 leading-tight tracking-tight mb-5">
                {!! $site->label('about.hero.title', 'Je suis Ulrich Calmo, et j\'ai créé <span class="text-gradient">NeoGTB</span> pour une raison simple') !!}
            </h1>
            <p class="text-lg text-dark-500 leading-relaxed max-w-xl">
                {{ $site->label('about.hero.subtitle', 'Le marché de la GTB en France manque d\'un interlocuteur neutre. Quelqu\'un qui ne vend rien, qui connaît le terrain, et qui vous aide à prendre la bonne décision. C\'est ce que je fais.') }}
            </p>
        </div>
    </div>
</section>

<!-- FONDATEUR -->
<section class="py-10 lg:py-20">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 lg:gap-16 items-start">

            <!-- Left: createur -->
            <div class="lg:col-span-2" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
                <div class="bg-white rounded-2xl p-5 lg:p-7 border border-dark-100 lg:shadow-sm">
                    <img src="/images/ulrich-calmo.webp" alt="Ulrich Calmo, créateur de la marque NeoGTB" width="120" height="120" loading="lazy" decoding="async" class="w-[120px] h-[120px] rounded-full object-cover mx-auto mb-5 border-[3px] border-accent-300" />
                    <p class="text-[22px] font-medium text-dark-900 text-center mb-1">{{ $site->label('about.founder.name', 'Ulrich Calmo') }}</p>
                    <p class="text-sm font-medium text-accent-600 text-center mb-1">{{ $site->label('about.founder.role', 'Fondateur de NeoGTB') }}</p>
                    <p class="text-xs text-dark-400 text-center mb-5">{{ $site->label('about.founder.company', 'EYNOR — Eysines, Bordeaux') }}</p>
                    <div class="w-full h-px bg-dark-200 mb-5"></div>

                    <p class="text-xs font-semibold uppercase tracking-widest text-dark-400 mb-3">Domaines d'expertise</p>
                    <ul class="space-y-2.5">
                        <li class="flex items-center gap-3">
                            <div class="w-1.5 h-1.5 rounded-full bg-accent-500 flex-shrink-0"></div>
                            <span class="text-sm text-dark-500">GTB / GTC / Supervision bâtiment</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-1.5 h-1.5 rounded-full bg-accent-500 flex-shrink-0"></div>
                            <span class="text-sm text-dark-500">Protocoles : BACnet, KNX, Modbus, LON</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-1.5 h-1.5 rounded-full bg-accent-500 flex-shrink-0"></div>
                            <span class="text-sm text-dark-500">Réglementation : décret BACS, tertiaire</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-1.5 h-1.5 rounded-full bg-accent-500 flex-shrink-0"></div>
                            <span class="text-sm text-dark-500">Audit énergétique & AMO GTB</span>
                        </li>
                    </ul>

                    <a href="https://www.linkedin.com/in/ulrich-calmo/" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 mt-6 text-sm text-accent-600 font-medium hover:text-accent-700 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        Voir mon profil LinkedIn
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div class="bg-white rounded-2xl p-5 lg:p-7 text-center border border-dark-100 lg:shadow-sm">
                        <p class="text-[28px] font-medium text-dark-900 tracking-tight">10+</p>
                        <p class="text-xs text-dark-400 mt-1">technologies analysées</p>
                    </div>
                    <div class="bg-white rounded-2xl p-5 lg:p-7 text-center border border-dark-100 lg:shadow-sm">
                        <p class="text-[28px] font-medium text-dark-900 tracking-tight">41</p>
                        <p class="text-xs text-dark-400 mt-1">protocoles référencés</p>
                    </div>
                    <div class="bg-white rounded-2xl p-5 lg:p-7 text-center border border-dark-100 lg:shadow-sm">
                        <p class="text-[28px] font-medium text-accent-600 tracking-tight">0 &euro;</p>
                        <p class="text-xs text-dark-400 mt-1">commission fabricant</p>
                    </div>
                    <div class="bg-white rounded-2xl p-5 lg:p-7 text-center border border-dark-100 lg:shadow-sm">
                        <p class="text-[28px] font-medium text-dark-900 tracking-tight">100 %</p>
                        <p class="text-xs text-dark-400 mt-1">indépendant</p>
                    </div>
                </div>
            </div>

            <!-- Right: parcours + conviction -->
            <div class="lg:col-span-3" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
                <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-6">{{ $site->label('about.story.title', 'Pourquoi j\'ai créé NeoGTB') }}</h2>

                <div class="text-base text-dark-500 leading-relaxed mb-8 space-y-4">
                    {!! $site->label('about.story.content', '<p>En travaillant sur des projets de gestion technique du bâtiment, j\'ai constaté un problème récurrent : <strong class="text-dark-900 font-medium">les décideurs n\'ont personne vers qui se tourner pour un avis neutre.</strong> Chaque interlocuteur vend sa solution. Les bureaux d\'études prescrivent ce qu\'ils connaissent. Les installateurs poussent leurs partenariats.</p><p>J\'ai créé NeoGTB pour combler ce vide. Ma mission : <strong class="text-dark-900 font-medium">éduquer le marché français sur la GTB</strong>, fournir des outils d\'analyse indépendants, et permettre à chaque professionnel de comprendre, comparer et décider en connaissance de cause.</p><p>NeoGTB est une marque de ma société <strong class="text-dark-900 font-medium">EYNOR</strong>, basée à Eysines près de Bordeaux. Je travaille seul, et c\'est un choix assumé : pas d\'actionnaires fabricants, pas de pression commerciale, pas de compromis sur les recommandations.</p><p>Mon seul engagement, c\'est envers vous : vous donner les clés pour décider en toute connaissance de cause, sans qu\'un intérêt commercial vienne fausser l\'analyse.</p>') !!}
                </div>

                <!-- Ce que je fais concretement -->
                <div class="space-y-3.5 mb-8">
                    <div class="flex items-start gap-3">
                        <div class="w-1.5 h-1.5 rounded-full bg-accent-500 flex-shrink-0 mt-2.5"></div>
                        <p class="text-[15px] text-dark-600 leading-relaxed"><strong class="font-medium text-dark-900">Je fais du conseil payant, les outils sont gratuits.</strong> Mon revenu vient exclusivement de prestations de conseil — audits sur site, cahiers des charges neutres, AMO GTB.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-1.5 h-1.5 rounded-full bg-accent-500 flex-shrink-0 mt-2.5"></div>
                        <p class="text-[15px] text-dark-600 leading-relaxed"><strong class="font-medium text-dark-900">Zéro lien commercial avec les fabricants.</strong> Pas de commission, pas d'affiliation, pas de partenariat rémunéré. Jamais.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-1.5 h-1.5 rounded-full bg-accent-500 flex-shrink-0 mt-2.5"></div>
                        <p class="text-[15px] text-dark-600 leading-relaxed"><strong class="font-medium text-dark-900">Mes critères de comparaison sont publics.</strong> Chaque analyse est vérifiable. Si je recommande BACnet plutôt que LON, c'est technique, pas commercial.</p>
                    </div>
                </div>

                <!-- Charte d'independance -->
                <div class="bg-accent-50 border border-accent-200 rounded-xl p-6">
                    <p class="text-xs font-semibold uppercase tracking-widest text-accent-700 mb-4">Ma charte d'indépendance</p>
                    <ul class="space-y-3">
                        @foreach([
                            'Aucun lien commercial avec les fabricants GTB',
                            'Aucune commission sur les ventes ou prescriptions',
                            'Méthodologie d\'évaluation transparente et vérifiable',
                            'Vos données ne sont jamais transmises à des tiers',
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

<!-- MÉTHODE -->
<section class="py-10 lg:py-20 bg-dark-50 border-t border-b border-dark-200">
    <div class="max-w-7xl mx-auto px-5 lg:px-10">
        <div class="max-w-xl mb-12" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Mon approche</p>
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">{{ $site->label('about.method.title', 'Ma méthode — 4 phases') }}</h2>
            <p class="text-base text-dark-500 leading-relaxed">{{ $site->label('about.method.subtitle', 'Une approche structurée pour accompagner chaque projet GTB, du diagnostic à la mise en œuvre.') }}</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 lg:gap-6">
            @php
            $steps = [
                ['num' => '01', 'title' => 'État des lieux', 'desc' => "J'audite l'existant : équipements en place, protocoles utilisés, niveau d'intégration, points de friction.", 'highlight' => false],
                ['num' => '02', 'title' => 'Analyse comparative', 'desc' => "J'évalue les solutions disponibles. Comparaison par critères objectifs : interopérabilité, coût, évolutivité.", 'highlight' => false],
                ['num' => '03', 'title' => 'Recommandations', 'desc' => "Je vous livre une synthèse argumentée. Chaque recommandation est justifiée, traçable et libre de conflit d'intérêts.", 'highlight' => true],
                ['num' => '04', 'title' => 'Accompagnement', 'desc' => "Je suis la mise en œuvre, vérifie la conformité et transfère les compétences à vos équipes internes.", 'highlight' => false],
            ];
            @endphp
            @foreach($steps as $step)
            <div class="{{ $step['highlight'] ? 'bg-white rounded-2xl border border-accent-200 shadow-[0_0_0_3px] shadow-accent-50' : 'bg-white rounded-2xl border border-dark-100 lg:shadow-sm' }} p-5 lg:p-7 card-hover" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
                <p class="text-[40px] font-medium {{ $step['highlight'] ? 'text-accent-400' : 'text-dark-200' }} leading-none mb-4 tracking-tight">{{ $step['num'] }}</p>
                <h3 class="text-[15px] font-medium text-dark-900 mb-2">{{ $step['title'] }}</h3>
                <p class="text-[13px] text-dark-500 leading-relaxed">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
        <div class="max-w-xl mt-6">
            @include('front.bricks.cta-mini.cta-text-link-underline', ['beforeText' => 'Cette méthode commence par un état des lieux —', 'linkText' => 'que vous pouvez initier avec le pré-diagnostic en ligne', 'href' => '/audit', 'afterText' => '.'])
        </div>
    </div>
</section>

<!-- CTA -->
<section class="relative overflow-hidden py-10 lg:py-20 bg-dark-100 border-t border-dark-200">
    <img src="/images/hero-gtb-illustration.webp" alt="" aria-hidden="true" width="1200" height="630" loading="lazy" class="absolute right-0 top-0 h-full w-auto object-cover opacity-20" />
    <div class="absolute inset-0 bg-gradient-to-r from-dark-100 via-dark-100/80 to-transparent pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-5 lg:px-10 relative z-10 flex items-center min-h-[200px]">
        <div class="max-w-lg">
            <h2 class="text-[22px] lg:text-[28px] font-medium text-dark-900 tracking-tight leading-tight mb-3">{{ $site->label('about.cta.title', 'Un projet GTB à clarifier ?') }}</h2>
            <p class="text-base text-dark-500 leading-relaxed mb-7">{{ $site->label('about.cta.subtitle', 'Échangeons sur votre situation. Sans engagement, sans pression commerciale.') }}</p>
            <a href="/contact" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition-colors btn-glow">
                {{ $site->label('about.cta.button', 'Me contacter directement') }}
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
                ['href' => '/positionnement', 'title' => 'Pourquoi NeoGTB ?', 'desc' => 'Les preuves de notre indépendance totale.'],
                ['href' => '/contact', 'title' => 'Contactez Ulrich', 'desc' => 'Discutons de votre projet GTB sans engagement.'],
                ['href' => '/audit', 'title' => 'Audit GTB gratuit', 'desc' => 'Diagnostiquez votre bâtiment en 5 minutes.'],
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
