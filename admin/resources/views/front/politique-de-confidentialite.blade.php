@extends('front.layouts.app')

@section('title', 'Politique de confidentialite')
@section('description', 'Comment NeoGTB collecte, utilise et protege vos donnees personnelles conformement au RGPD.')

@section('content')

<section class="py-16 md:py-20">
    <div class="max-w-[680px] mx-auto px-4 sm:px-6">

        <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Protection des donnees</p>
        <h1 class="font-heading font-medium text-dark-900 mb-2 text-[26px] tracking-tight">Politique de confidentialite</h1>
        <div class="flex items-center gap-4 mb-12">
            <span class="text-sm text-dark-400">Derniere mise a jour : 18 mars 2026</span>
            <span class="text-xs font-medium px-2.5 py-1 rounded-md bg-primary-50 text-primary-700 border border-primary-100">Version 1.0</span>
        </div>

        <!-- Table des matieres -->
        <nav class="bg-dark-50 rounded-xl p-6 mb-12 border border-dark-100">
            <h2 class="text-xs font-medium text-dark-400 uppercase tracking-wide mb-3">Sommaire</h2>
            <ol class="space-y-1 text-sm columns-1 md:columns-2 leading-relaxed">
                <li><a href="#qui" class="text-accent-600 hover:text-accent-700">1. Qui sommes-nous</a></li>
                <li><a href="#donnees-collectees" class="text-accent-600 hover:text-accent-700">2. Donnees collectees et finalites</a></li>
                <li><a href="#base-legale" class="text-accent-600 hover:text-accent-700">3. Base legale des traitements</a></li>
                <li><a href="#duree" class="text-accent-600 hover:text-accent-700">4. Duree de conservation</a></li>
                <li><a href="#destinataires" class="text-accent-600 hover:text-accent-700">5. Destinataires des donnees</a></li>
                <li><a href="#droits" class="text-accent-600 hover:text-accent-700">6. Vos droits</a></li>
                <li><a href="#exercer" class="text-accent-600 hover:text-accent-700">7. Comment exercer vos droits</a></li>
                <li><a href="#cookies" class="text-accent-600 hover:text-accent-700">8. Cookies</a></li>
                <li><a href="#transferts" class="text-accent-600 hover:text-accent-700">9. Transferts hors UE</a></li>
                <li><a href="#cnil" class="text-accent-600 hover:text-accent-700">10. Reclamation CNIL</a></li>
                <li><a href="#modifications" class="text-accent-600 hover:text-accent-700">11. Modifications</a></li>
            </ol>
        </nav>

        <div class="space-y-10 text-sm text-dark-500 leading-relaxed">

            <section id="qui">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">1. Qui sommes-nous</h2>
                <p class="mb-3">Le responsable du traitement des donnees collectees sur le site <span class="font-medium text-dark-700">neogtb.fr</span> est :</p>
                <div class="bg-dark-50 rounded-lg p-4 text-sm space-y-1 border border-dark-100">
                    <p><span class="font-medium text-dark-700">NeoGTB</span> — marque exploitee par EYNOR</p>
                    <p>Adresse : Rue Aime Cesaire, 33320 Eysines, France</p>
                    <p>SIREN : 989 322 144</p>
                    <p>Email : <a href="mailto:hello@neogtb.fr" class="text-accent-600 hover:text-accent-700">hello@neogtb.fr</a></p>
                    <p>Responsable du traitement : Ulrich CALMO, gerant</p>
                    <p>Contact RGPD : <a href="mailto:rgpd@neogtb.fr" class="text-accent-600 hover:text-accent-700">rgpd@neogtb.fr</a></p>
                </div>
            </section>

            <section id="donnees-collectees">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">2. Donnees collectees et finalites</h2>
                <div class="space-y-4 mt-4">
                    @foreach([
                        ['title' => 'Formulaire de contact', 'data' => 'Nom, email, entreprise (optionnel), sujet, message', 'purpose' => 'Repondre a votre demande d\'information', 'basis' => 'Interet legitime (repondre a une demande)', 'note' => null],
                        ['title' => 'Diagnostic GTB (audit)', 'data' => 'Type de batiment, surface, reponses au questionnaire', 'purpose' => 'Generer un diagnostic personnalise', 'basis' => 'Consentement (utilisation volontaire de l\'outil)', 'note' => 'Aucune donnee personnelle identifiante n\'est collectee par l\'outil de diagnostic. Les donnees sont traitees localement dans votre navigateur.'],
                        ['title' => 'Generateur CEE', 'data' => 'Type de batiment, surface, zone climatique, equipements', 'purpose' => 'Estimer les Certificats d\'Economies d\'Energie', 'basis' => 'Consentement (utilisation volontaire de l\'outil)', 'note' => 'Toutes les donnees sont traitees localement dans votre navigateur. Aucune donnee n\'est transmise a nos serveurs ni a des tiers.'],
                        ['title' => 'Mesure d\'audience (Plausible Analytics)', 'data' => 'Pages visitees, duree de visite, appareil, navigateur (anonymisees, sans donnees personnelles)', 'purpose' => 'Ameliorer le contenu et l\'experience utilisateur', 'basis' => 'Interet legitime — exempt de consentement conformement aux recommandations CNIL (pas de cookies, pas de donnees personnelles, heberge en UE)', 'note' => null],
                        ['title' => 'Demande d\'exercice de droits RGPD', 'data' => 'Nom, email, type de demande, precisions', 'purpose' => 'Traiter votre demande conformement au RGPD', 'basis' => 'Obligation legale (RGPD art. 15 a 21)', 'note' => null],
                    ] as $block)
                    <div class="rounded-xl overflow-hidden border border-dark-100">
                        <div class="bg-dark-50 px-4 py-3 border-b border-dark-100">
                            <h3 class="font-medium text-dark-800 text-sm">{{ $block['title'] }}</h3>
                        </div>
                        <div class="p-4 text-sm space-y-2">
                            <p><span class="font-medium text-dark-700">Donnees :</span> {{ $block['data'] }}</p>
                            <p><span class="font-medium text-dark-700">Finalite :</span> {{ $block['purpose'] }}</p>
                            <p><span class="font-medium text-dark-700">Base legale :</span> {{ $block['basis'] }}</p>
                            @if($block['note'])
                            <p><span class="font-medium text-dark-700">Note :</span> {{ $block['note'] }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

            <section id="base-legale">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">3. Base legale des traitements</h2>
                <p class="mb-3">Chaque traitement de donnees repose sur l'une des bases legales suivantes, conformement a l'article 6 du RGPD :</p>
                <ul class="list-disc pl-5 space-y-1">
                    <li><span class="font-medium text-dark-700">Consentement</span> (art. 6.1.a) : utilisation des outils interactifs</li>
                    <li><span class="font-medium text-dark-700">Interet legitime</span> (art. 6.1.f) : reponse aux demandes de contact, mesure d'audience (Plausible, exempt CNIL), securite du site</li>
                    <li><span class="font-medium text-dark-700">Obligation legale</span> (art. 6.1.c) : traitement des demandes d'exercice de droits</li>
                </ul>
            </section>

            <section id="duree">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">4. Duree de conservation</h2>
                <div class="overflow-hidden rounded-lg border border-dark-100">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-dark-50">
                                <th class="text-left p-3 font-medium text-dark-700 border-b border-dark-100">Donnee</th>
                                <th class="text-left p-3 font-medium text-dark-700 border-b border-dark-100">Duree</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td class="p-3 border-b border-dark-100">Messages de contact</td><td class="p-3 border-b border-dark-100">3 ans apres le dernier contact</td></tr>
                            <tr><td class="p-3 border-b border-dark-100">Consentements cookies</td><td class="p-3 border-b border-dark-100">13 mois</td></tr>
                            <tr><td class="p-3 border-b border-dark-100">Demandes RGPD</td><td class="p-3 border-b border-dark-100">3 ans apres traitement</td></tr>
                            <tr><td class="p-3">Donnees de navigation (analytics)</td><td class="p-3">25 mois</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="destinataires">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">5. Destinataires des donnees</h2>
                <p class="mb-3">Vos donnees personnelles sont destinees exclusivement a l'equipe NeoGTB.</p>
                <p class="mb-3 font-medium text-dark-700">Aucune donnee n'est vendue, louee ou transmise a des tiers a des fins commerciales.</p>
                <p class="mb-3">Les sous-traitants techniques suivants peuvent avoir acces aux donnees dans le cadre strict de leurs prestations :</p>
                <ul class="list-disc pl-5 space-y-1">
                    <li><span class="font-medium text-dark-700">OVHcloud</span> (hebergement) — France — Donnees hebergees en UE</li>
                    <li><span class="font-medium text-dark-700">Plausible Analytics</span> (mesure d'audience) — Allemagne (UE) — Sans cookies, sans donnees personnelles</li>
                </ul>
            </section>

            <section id="droits">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">6. Vos droits</h2>
                <p class="mb-4">Conformement au RGPD (articles 15 a 21), vous disposez des droits suivants :</p>
                <div class="grid sm:grid-cols-2 gap-3">
                    @foreach([
                        ['title' => "Droit d'acces", 'desc' => 'Obtenir une copie de vos donnees'],
                        ['title' => 'Droit de rectification', 'desc' => 'Corriger des donnees inexactes'],
                        ['title' => "Droit a l'effacement", 'desc' => 'Supprimer vos donnees'],
                        ['title' => 'Droit a la portabilite', 'desc' => 'Recuperer vos donnees en format structure'],
                        ['title' => "Droit d'opposition", 'desc' => 'Vous opposer au traitement'],
                        ['title' => 'Droit a la limitation', 'desc' => 'Limiter le traitement de vos donnees'],
                    ] as $right)
                    <div class="flex items-start gap-3 p-3 bg-dark-50 rounded-lg border border-dark-100">
                        <div>
                            <p class="font-medium text-dark-700 text-sm">{{ $right['title'] }}</p>
                            <p class="text-xs text-dark-400">{{ $right['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

            <section id="exercer">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">7. Comment exercer vos droits</h2>
                <p class="mb-3">Vous pouvez exercer vos droits de deux manieres :</p>
                <ul class="list-disc pl-5 space-y-1 mb-3">
                    <li>Via notre <a href="/mes-droits-rgpd" class="text-accent-600 hover:text-accent-700 font-medium">formulaire dedie</a> (recommande)</li>
                    <li>Par email a <a href="mailto:rgpd@neogtb.fr" class="text-accent-600 hover:text-accent-700">rgpd@neogtb.fr</a></li>
                </ul>
                <p>Nous nous engageons a repondre a toute demande dans un delai de <span class="font-medium text-dark-700">30 jours</span>, conformement au RGPD.</p>
            </section>

            <section id="cookies">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">8. Cookies</h2>
                <h3 class="font-medium text-dark-700 mt-4 mb-2 text-[15px]">Cookies essentiels (toujours actifs)</h3>
                <p class="mb-2">Necessaires au fonctionnement du site. Ne peuvent etre desactives.</p>
                <ul class="list-disc pl-5 space-y-1 mb-4">
                    <li><code class="text-xs bg-dark-50 px-1.5 py-0.5 rounded">neogtb_consent</code> — Stocke vos preferences cookies — Duree : 13 mois</li>
                </ul>
                <h3 class="font-medium text-dark-700 mt-4 mb-2 text-[15px]">Mesure d'audience</h3>
                <p class="mb-2">Nous utilisons <span class="font-medium text-dark-700">Plausible Analytics</span>, un outil de mesure d'audience respectueux de la vie privee, heberge en Allemagne (UE). Plausible ne depose aucun cookie, ne collecte aucune donnee personnelle et ne necessite pas de consentement prealable conformement aux recommandations de la CNIL.</p>
                <h3 class="font-medium text-dark-700 mt-4 mb-2 text-[15px]">Cookies marketing</h3>
                <p class="mb-4"><span class="font-medium text-dark-700">Actuellement non utilises.</span> Si nous devions en ajouter a l'avenir, votre consentement serait requis au prealable.</p>
                <h3 class="font-medium text-dark-700 mt-4 mb-2 text-[15px]">Gerer vos preferences</h3>
                <p>Vous pouvez modifier vos preferences a tout moment via le bouton "Gerer mes cookies" present en bas de chaque page.</p>
            </section>

            <section id="transferts">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">9. Transferts hors UE</h2>
                <p>Le site est heberge par OVHcloud en France (donnees au sein de l'UE). Notre outil de mesure d'audience Plausible est heberge en Allemagne (UE). <span class="font-medium text-dark-700">Aucun transfert de donnees hors de l'Union europeenne n'est effectue.</span></p>
            </section>

            <section id="cnil">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">10. Droit de reclamation aupres de la CNIL</h2>
                <p class="mb-3">Si vous estimez que le traitement de vos donnees ne respecte pas la reglementation, vous pouvez adresser une reclamation a la Commission Nationale de l'Informatique et des Libertes (CNIL) :</p>
                <div class="bg-dark-50 rounded-lg p-4 text-sm space-y-1 border border-dark-100">
                    <p><span class="font-medium text-dark-700">CNIL</span></p>
                    <p>3 Place de Fontenoy, TSA 80715</p>
                    <p>75334 Paris Cedex 07</p>
                    <p>Site : <a href="https://www.cnil.fr" class="text-accent-600 hover:text-accent-700" target="_blank" rel="noopener noreferrer">www.cnil.fr</a></p>
                </div>
            </section>

            <section id="modifications">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">11. Modifications de cette politique</h2>
                <p>Cette politique peut etre mise a jour. En cas de modification substantielle, nous vous en informerons via un bandeau sur le site. La date de derniere mise a jour est indiquee en haut de cette page.</p>
            </section>

        </div>
    </div>
</section>

@endsection
