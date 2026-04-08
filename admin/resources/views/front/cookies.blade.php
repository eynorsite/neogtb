@extends('front.layouts.app')


@section('content')

<section class="py-12 lg:py-24">
    <div class="max-w-[680px] mx-auto px-4 sm:px-6">

        <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Transparence &amp; vie privée</p>
        <h1 class="font-heading font-medium text-dark-900 mb-2 text-[26px] tracking-tight">Politique cookies</h1>
        <p class="text-sm text-dark-400 mb-10 leading-relaxed">Dernière mise à jour : 8 avril 2026</p>

        {{-- Encart de promesse --}}
        <div class="relative overflow-hidden rounded-xl border border-accent-100 bg-accent-50/60 p-5 mb-12">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 mt-0.5">
                    <svg class="w-5 h-5 text-accent-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[13px] font-semibold text-dark-900 mb-1">Aucun cookie traceur. Aucune publicité. Aucune revente de données.</p>
                    <p class="text-[13px] text-dark-600 leading-relaxed">NeoGTB n'utilise <span class="font-medium text-dark-800">aucun cookie marketing, publicitaire ou de profilage</span>. Seuls deux cookies techniques strictement nécessaires au fonctionnement du site sont posés par Laravel. Ils ne nécessitent pas votre consentement au titre de l'article 82 de la loi Informatique et Libertés.</p>
                </div>
            </div>
        </div>

        {{-- Sommaire --}}
        <nav class="bg-dark-50 rounded-xl p-6 mb-12 border border-dark-100">
            <h2 class="text-xs font-medium text-dark-400 uppercase tracking-wide mb-3">Sommaire</h2>
            <ol class="space-y-1 text-sm leading-relaxed">
                <li><a href="#definition" class="text-accent-600 hover:text-accent-700">1. Qu'est-ce qu'un cookie ?</a></li>
                <li><a href="#cookies-neogtb" class="text-accent-600 hover:text-accent-700">2. Les cookies utilisés sur NeoGTB</a></li>
                <li><a href="#liste" class="text-accent-600 hover:text-accent-700">3. Liste détaillée des cookies techniques</a></li>
                <li><a href="#analytics" class="text-accent-600 hover:text-accent-700">4. Mesure d'audience sans cookie (Plausible)</a></li>
                <li><a href="#preferences" class="text-accent-600 hover:text-accent-700">5. Gérer vos préférences</a></li>
                <li><a href="#liens" class="text-accent-600 hover:text-accent-700">6. Pour aller plus loin</a></li>
            </ol>
        </nav>

        <div class="space-y-10 text-sm text-dark-500 leading-relaxed">

            <section id="definition">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">1. Qu'est-ce qu'un cookie ?</h2>
                <p class="mb-3">Un <span class="font-medium text-dark-700">cookie</span> est un petit fichier texte déposé sur votre terminal (ordinateur, tablette, smartphone) lors de la visite d'un site web. Il permet au site de reconnaître votre navigateur, de mémoriser certaines informations (connexion, panier, langue…) et, dans certains cas, de suivre votre navigation à des fins statistiques ou publicitaires.</p>
                <p>La réglementation distingue deux familles de cookies :</p>
                <ul class="list-disc pl-5 space-y-1 mt-2">
                    <li><span class="font-medium text-dark-700">Les cookies strictement nécessaires</span> au fonctionnement du service : ils sont exemptés de consentement.</li>
                    <li><span class="font-medium text-dark-700">Les cookies non essentiels</span> (mesure d'audience non anonymisée, publicité, réseaux sociaux, profilage) : ils nécessitent un consentement préalable, libre et éclairé.</li>
                </ul>
            </section>

            <section id="cookies-neogtb">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">2. Les cookies utilisés sur NeoGTB</h2>
                <p class="mb-3">NeoGTB a été conçu selon une approche <span class="font-medium text-dark-700">privacy-by-design</span>. Concrètement :</p>
                <ul class="list-disc pl-5 space-y-2 mb-3">
                    <li>Le site <span class="font-medium text-dark-700">n'utilise aucun cookie traceur</span> (ni Google Analytics, ni Google Tag Manager, ni Meta Pixel, ni LinkedIn Insight, ni régie publicitaire).</li>
                    <li>Il <span class="font-medium text-dark-700">n'utilise aucun cookie tiers</span>. Seul le domaine neogtb.fr dépose des cookies.</li>
                    <li>Il pose uniquement <span class="font-medium text-dark-700">deux cookies techniques de session</span>, strictement nécessaires à la sécurité et au bon fonctionnement du framework Laravel qui fait tourner le site.</li>
                    <li>La mesure d'audience est assurée par <span class="font-medium text-dark-700">Plausible Analytics</span>, un outil européen qui fonctionne <span class="font-medium text-dark-700">sans cookie</span> (voir §4).</li>
                </ul>
                <p>Aucune bannière de consentement n'est donc affichée pour des cookies non essentiels… puisqu'il n'y en a pas.</p>
            </section>

            <section id="liste">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">3. Liste détaillée des cookies techniques</h2>
                <p class="mb-4">Ces deux cookies sont posés par Laravel, le framework technique du site. Ils sont indispensables à la navigation sécurisée et à la protection contre les attaques CSRF (Cross-Site Request Forgery).</p>

                <div class="overflow-x-auto rounded-xl border border-dark-100">
                    <table class="min-w-full text-[13px]">
                        <thead class="bg-dark-50 text-dark-600">
                            <tr>
                                <th class="text-left font-medium px-4 py-3">Nom</th>
                                <th class="text-left font-medium px-4 py-3">Finalité</th>
                                <th class="text-left font-medium px-4 py-3">Durée</th>
                                <th class="text-left font-medium px-4 py-3">Type</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-dark-100 bg-white">
                            <tr>
                                <td class="px-4 py-3 align-top"><code class="font-mono text-[12px] text-dark-900">laravel_session</code></td>
                                <td class="px-4 py-3 align-top text-dark-600">Identifie votre session de navigation pour permettre le bon fonctionnement des formulaires (contact, pré-diagnostic, CEE) et conserver votre état entre deux pages.</td>
                                <td class="px-4 py-3 align-top text-dark-600 whitespace-nowrap">2 heures</td>
                                <td class="px-4 py-3 align-top"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-accent-50 text-accent-700 border border-accent-100">Essentiel</span></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 align-top"><code class="font-mono text-[12px] text-dark-900">XSRF-TOKEN</code></td>
                                <td class="px-4 py-3 align-top text-dark-600">Protège contre les attaques CSRF en validant l'origine des requêtes lors de la soumission des formulaires. Indispensable à la sécurité du site.</td>
                                <td class="px-4 py-3 align-top text-dark-600 whitespace-nowrap">2 heures</td>
                                <td class="px-4 py-3 align-top"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-accent-50 text-accent-700 border border-accent-100">Essentiel</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <p class="mt-4 text-[13px] text-dark-400">Ces cookies sont classés comme <span class="font-medium text-dark-600">strictement nécessaires</span> au sens de l'article 82 de la loi Informatique et Libertés et des lignes directrices CNIL du 17 septembre 2020. Ils ne requièrent pas votre consentement préalable.</p>
            </section>

            <section id="analytics">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">4. Mesure d'audience sans cookie (Plausible)</h2>
                <p class="mb-3">Pour comprendre quelles pages sont consultées et améliorer le site, NeoGTB utilise <span class="font-medium text-dark-700">Plausible Analytics</span>, une solution européenne (hébergée en Allemagne) conçue pour respecter la vie privée.</p>
                <ul class="list-disc pl-5 space-y-1 mb-3">
                    <li>Plausible <span class="font-medium text-dark-700">ne dépose aucun cookie</span> sur votre terminal.</li>
                    <li>Aucune donnée personnelle n'est collectée : pas d'adresse IP stockée, pas d'identifiant unique, pas d'empreinte navigateur (fingerprinting).</li>
                    <li>Les statistiques sont agrégées et anonymes (pays, page visitée, source de trafic, type d'appareil).</li>
                    <li>Aucune donnée n'est transférée hors Union Européenne, ni revendue à des tiers.</li>
                </ul>
                <p>Cette approche est <span class="font-medium text-dark-700">exemptée de consentement par la CNIL</span> au titre de la mesure d'audience anonyme (recommandation CNIL, configuration « analytics exemptés »).</p>
            </section>

            <section id="preferences">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">5. Gérer vos préférences</h2>
                <p class="mb-3">Puisque NeoGTB n'utilise pas de cookies non essentiels, vous n'avez rien à configurer pour protéger votre vie privée lors de votre visite. Vous pouvez néanmoins, à tout moment :</p>
                <ul class="list-disc pl-5 space-y-2 mb-3">
                    <li>Utiliser le bouton <span class="font-medium text-dark-700">« Gérer mes cookies »</span> présent en bas de chaque page pour consulter votre état de consentement.</li>
                    <li>Configurer votre navigateur pour bloquer ou supprimer les cookies de votre choix. À noter : bloquer les cookies techniques <code class="font-mono text-[12px] text-dark-700">laravel_session</code> ou <code class="font-mono text-[12px] text-dark-700">XSRF-TOKEN</code> empêcherait le fonctionnement des formulaires du site.</li>
                </ul>
                <p class="mb-2">Liens utiles vers la documentation des principaux navigateurs :</p>
                <ul class="list-disc pl-5 space-y-1">
                    <li><a href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener noreferrer" class="text-accent-600 hover:text-accent-700">Google Chrome</a></li>
                    <li><a href="https://support.mozilla.org/fr/kb/protection-renforcee-contre-pistage-firefox-ordinateur" target="_blank" rel="noopener noreferrer" class="text-accent-600 hover:text-accent-700">Mozilla Firefox</a></li>
                    <li><a href="https://support.apple.com/fr-fr/guide/safari/sfri11471/mac" target="_blank" rel="noopener noreferrer" class="text-accent-600 hover:text-accent-700">Safari</a></li>
                    <li><a href="https://support.microsoft.com/fr-fr/microsoft-edge/supprimer-les-cookies-dans-microsoft-edge-63947406-40ac-c3b8-57b9-2a946a29ae09" target="_blank" rel="noopener noreferrer" class="text-accent-600 hover:text-accent-700">Microsoft Edge</a></li>
                </ul>
            </section>

            <section id="liens">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">6. Pour aller plus loin</h2>
                <p class="mb-3">Cette politique cookies s'inscrit dans une démarche globale de transparence et de respect de vos données :</p>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Consultez notre <a href="/politique-de-confidentialite" class="text-accent-600 hover:text-accent-700">politique de confidentialité</a> pour comprendre comment nous traitons les données personnelles que vous nous confiez via les formulaires.</li>
                    <li>Retrouvez la procédure pour <a href="/mes-droits-rgpd" class="text-accent-600 hover:text-accent-700">exercer vos droits RGPD</a> (accès, rectification, suppression, portabilité, opposition).</li>
                    <li>Consultez nos <a href="/mentions-legales" class="text-accent-600 hover:text-accent-700">mentions légales</a> pour toute information sur l'éditeur et l'hébergeur du site.</li>
                </ul>
                <p class="mt-4 text-[13px] text-dark-400">Pour toute question concernant cette politique cookies, contactez-nous à <a href="mailto:hello@neogtb.fr" class="text-accent-600 hover:text-accent-700">hello@neogtb.fr</a>.</p>
            </section>

        </div>
    </div>
</section>

@endsection
