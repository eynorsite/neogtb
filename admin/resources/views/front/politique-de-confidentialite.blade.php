@extends('front.layouts.app')

@section('title', 'Politique de confidentialité')
@section('description', 'Comment NeoGTB collecte, utilise et protège vos données personnelles conformément au RGPD.')

@section('content')

<section class="py-16 md:py-20">
    <div class="max-w-[680px] mx-auto px-4 sm:px-6">

        <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Protection des données</p>
        <h1 class="font-heading font-medium text-dark-900 mb-2 text-[26px] tracking-tight">Politique de confidentialité</h1>
        <div class="flex items-center gap-4 mb-12">
            <span class="text-sm text-dark-400">Dernière mise à jour : 7 avril 2026</span>
            <span class="text-xs font-medium px-2.5 py-1 rounded-md bg-primary-50 text-primary-700 border border-primary-100">Version 1.1</span>
        </div>

        <!-- Table des matières -->
        <nav class="bg-dark-50 rounded-xl p-6 mb-12 border border-dark-100">
            <h2 class="text-xs font-medium text-dark-400 uppercase tracking-wide mb-3">Sommaire</h2>
            <ol class="space-y-1 text-sm columns-1 md:columns-2 leading-relaxed">
                <li><a href="#qui" class="text-accent-600 hover:text-accent-700">1. Qui sommes-nous</a></li>
                <li><a href="#donnees-collectees" class="text-accent-600 hover:text-accent-700">2. Données collectées et finalités</a></li>
                <li><a href="#base-legale" class="text-accent-600 hover:text-accent-700">3. Base légale des traitements</a></li>
                <li><a href="#duree" class="text-accent-600 hover:text-accent-700">4. Durée de conservation</a></li>
                <li><a href="#destinataires" class="text-accent-600 hover:text-accent-700">5. Destinataires des données</a></li>
                <li><a href="#droits" class="text-accent-600 hover:text-accent-700">6. Vos droits</a></li>
                <li><a href="#exercer" class="text-accent-600 hover:text-accent-700">7. Comment exercer vos droits</a></li>
                <li><a href="#cookies" class="text-accent-600 hover:text-accent-700">8. Cookies</a></li>
                <li><a href="#transferts" class="text-accent-600 hover:text-accent-700">9. Transferts hors UE</a></li>
                <li><a href="#cnil" class="text-accent-600 hover:text-accent-700">10. Réclamation CNIL</a></li>
                <li><a href="#modifications" class="text-accent-600 hover:text-accent-700">11. Modifications</a></li>
            </ol>
        </nav>

        <div class="space-y-10 text-sm text-dark-500 leading-relaxed">

            <section id="qui">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">1. Qui sommes-nous</h2>
                <p class="mb-3">Le responsable du traitement des données collectées sur le site <span class="font-medium text-dark-700">neogtb.fr</span> est :</p>
                <div class="bg-dark-50 rounded-lg p-4 text-sm space-y-1 border border-dark-100">
                    <p><span class="font-medium text-dark-700">NeoGTB</span> — marque exploitée par EYNOR</p>
                    <p>Adresse : Rue Aimé Césaire, 33320 Eysines, France</p>
                    <p>SIREN : 989 322 144</p>
                    <p>Email : <a href="mailto:hello@neogtb.fr" class="text-accent-600 hover:text-accent-700">hello@neogtb.fr</a></p>
                    <p>Responsable du traitement : Ulrich CALMO, gérant</p>
                    <p>Contact RGPD : <a href="mailto:rgpd@neogtb.fr" class="text-accent-600 hover:text-accent-700">rgpd@neogtb.fr</a></p>
                </div>
            </section>

            <section id="donnees-collectees">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">2. Données collectées et finalités</h2>
                <div class="space-y-4 mt-4">
                    @foreach([
                        ['title' => 'Formulaire de contact', 'data' => 'Nom, email, entreprise (optionnel), sujet, message', 'purpose' => 'Répondre à votre demande d\'information', 'basis' => 'Intérêt légitime (répondre à une demande)', 'note' => null],
                        ['title' => 'Diagnostic GTB (audit)', 'data' => 'Type de bâtiment, surface, réponses au questionnaire — calcul effectué localement. Si vous demandez à recevoir le rapport par email : email, nom (optionnel), entreprise (optionnel)', 'purpose' => 'Générer un diagnostic personnalisé et vous transmettre le rapport par email si demandé', 'basis' => 'Consentement (saisie volontaire de votre email pour recevoir le rapport)', 'note' => 'Le calcul du diagnostic se fait dans votre navigateur. Vos coordonnées ne sont enregistrées que si vous demandez explicitement le rapport par email. Stockage chiffré côté serveur.'],
                        ['title' => 'Générateur CEE', 'data' => 'Type de bâtiment, surface, zone climatique, équipements — calcul effectué localement. Si vous demandez à recevoir l\'estimation par email : email', 'purpose' => 'Estimer les Certificats d\'Économies d\'Énergie et vous transmettre le résultat par email si demandé', 'basis' => 'Consentement (saisie volontaire de votre email pour recevoir l\'estimation)', 'note' => 'Le calcul se fait dans votre navigateur. Votre email n\'est enregistré que si vous demandez explicitement l\'estimation par email. Stockage chiffré côté serveur.'],
                        ['title' => 'Mesure d\'audience (Plausible Analytics)', 'data' => 'Pages visitées, durée de visite, appareil, navigateur (anonymisées, sans données personnelles)', 'purpose' => 'Améliorer le contenu et l\'expérience utilisateur', 'basis' => 'Intérêt légitime — exempt de consentement conformément aux recommandations CNIL (pas de cookies, pas de données personnelles, hébergé en UE)', 'note' => null],
                        ['title' => 'Demande d\'exercice de droits RGPD', 'data' => 'Nom, email, type de demande, précisions', 'purpose' => 'Traiter votre demande conformément au RGPD', 'basis' => 'Obligation légale (RGPD art. 15 à 21)', 'note' => null],
                    ] as $block)
                    <div class="rounded-xl overflow-hidden border border-dark-100">
                        <div class="bg-dark-50 px-4 py-3 border-b border-dark-100">
                            <h3 class="font-medium text-dark-800 text-sm">{{ $block['title'] }}</h3>
                        </div>
                        <div class="p-4 text-sm space-y-2">
                            <p><span class="font-medium text-dark-700">Données :</span> {{ $block['data'] }}</p>
                            <p><span class="font-medium text-dark-700">Finalité :</span> {{ $block['purpose'] }}</p>
                            <p><span class="font-medium text-dark-700">Base légale :</span> {{ $block['basis'] }}</p>
                            @if($block['note'])
                            <p><span class="font-medium text-dark-700">Note :</span> {{ $block['note'] }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

            <section id="base-legale">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">3. Base légale des traitements</h2>
                <p class="mb-3">Chaque traitement de données repose sur l'une des bases légales suivantes, conformément à l'article 6 du RGPD :</p>
                <ul class="list-disc pl-5 space-y-1">
                    <li><span class="font-medium text-dark-700">Consentement</span> (art. 6.1.a) : utilisation des outils interactifs</li>
                    <li><span class="font-medium text-dark-700">Intérêt légitime</span> (art. 6.1.f) : réponse aux demandes de contact, mesure d'audience (Plausible, exempt CNIL), sécurité du site</li>
                    <li><span class="font-medium text-dark-700">Obligation légale</span> (art. 6.1.c) : traitement des demandes d'exercice de droits</li>
                </ul>
            </section>

            <section id="duree">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">4. Durée de conservation</h2>
                <div class="overflow-x-auto rounded-lg border border-dark-100">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-dark-50">
                                <th class="text-left p-3 font-medium text-dark-700 border-b border-dark-100">Donnée</th>
                                <th class="text-left p-3 font-medium text-dark-700 border-b border-dark-100">Durée</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td class="p-3 border-b border-dark-100">Messages de contact</td><td class="p-3 border-b border-dark-100">3 ans après le dernier contact</td></tr>
                            <tr><td class="p-3 border-b border-dark-100">Leads diagnostic GTB / générateur CEE</td><td class="p-3 border-b border-dark-100">3 ans à compter de la soumission</td></tr>
                            <tr><td class="p-3 border-b border-dark-100">Consentements cookies</td><td class="p-3 border-b border-dark-100">13 mois</td></tr>
                            <tr><td class="p-3 border-b border-dark-100">Demandes RGPD</td><td class="p-3 border-b border-dark-100">3 ans après traitement</td></tr>
                            <tr><td class="p-3">Données de navigation (analytics)</td><td class="p-3">25 mois</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="destinataires">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">5. Destinataires des données</h2>
                <p class="mb-3">Vos données personnelles sont destinées exclusivement à l'équipe NeoGTB.</p>
                <p class="mb-3 font-medium text-dark-700">Aucune donnée n'est vendue, louée ou transmise à des tiers à des fins commerciales.</p>
                <p class="mb-3">Les sous-traitants techniques suivants peuvent avoir accès aux données dans le cadre strict de leurs prestations :</p>
                <ul class="list-disc pl-5 space-y-1">
                    <li><span class="font-medium text-dark-700">OVHcloud</span> (hébergement) — France — Données hébergées en UE</li>
                    <li><span class="font-medium text-dark-700">Brevo (Sendinblue SAS)</span> (envoi des emails transactionnels) — France (UE)</li>
                    <li><span class="font-medium text-dark-700">Plausible Analytics</span> (mesure d'audience) — Allemagne (UE) — Sans cookies, sans données personnelles</li>
                </ul>
            </section>

            <section id="droits">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">6. Vos droits</h2>
                <p class="mb-4">Conformément au RGPD (articles 15 à 21), vous disposez des droits suivants :</p>
                <div class="grid sm:grid-cols-2 gap-3">
                    @foreach([
                        ['title' => "Droit d'accès", 'desc' => 'Obtenir une copie de vos données'],
                        ['title' => 'Droit de rectification', 'desc' => 'Corriger des données inexactes'],
                        ['title' => "Droit à l'effacement", 'desc' => 'Supprimer vos données'],
                        ['title' => 'Droit à la portabilité', 'desc' => 'Récupérer vos données en format structuré'],
                        ['title' => "Droit d'opposition", 'desc' => 'Vous opposer au traitement'],
                        ['title' => 'Droit à la limitation', 'desc' => 'Limiter le traitement de vos données'],
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
                <p class="mb-3">Vous pouvez exercer vos droits de deux manières :</p>
                <ul class="list-disc pl-5 space-y-1 mb-3">
                    <li>Via notre <a href="/mes-droits-rgpd" class="text-accent-600 hover:text-accent-700 font-medium">formulaire dédié</a> (recommandé)</li>
                    <li>Par email à <a href="mailto:rgpd@neogtb.fr" class="text-accent-600 hover:text-accent-700">rgpd@neogtb.fr</a></li>
                </ul>
                <p>Nous nous engageons à répondre à toute demande dans un délai de <span class="font-medium text-dark-700">30 jours</span>, conformément au RGPD.</p>
            </section>

            <section id="cookies">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">8. Cookies</h2>
                <h3 class="font-medium text-dark-700 mt-4 mb-2 text-[15px]">Cookies essentiels (toujours actifs)</h3>
                <p class="mb-2">Nécessaires au fonctionnement du site. Ne peuvent être désactivés.</p>
                <ul class="list-disc pl-5 space-y-1 mb-4">
                    <li><code class="text-xs bg-dark-50 px-1.5 py-0.5 rounded">neogtb_consent</code> — Stocke vos préférences cookies — Durée : 13 mois</li>
                </ul>
                <h3 class="font-medium text-dark-700 mt-4 mb-2 text-[15px]">Mesure d'audience</h3>
                <p class="mb-2">Nous utilisons <span class="font-medium text-dark-700">Plausible Analytics</span>, un outil de mesure d'audience respectueux de la vie privée, hébergé en Allemagne (UE). Plausible ne dépose aucun cookie, ne collecte aucune donnée personnelle et ne nécessite pas de consentement préalable conformément aux recommandations de la CNIL.</p>
                <h3 class="font-medium text-dark-700 mt-4 mb-2 text-[15px]">Cookies marketing</h3>
                <p class="mb-4"><span class="font-medium text-dark-700">Actuellement non utilisés.</span> Si nous devions en ajouter à l'avenir, votre consentement serait requis au préalable.</p>
                <h3 class="font-medium text-dark-700 mt-4 mb-2 text-[15px]">Gérer vos préférences</h3>
                <p>Vous pouvez modifier vos préférences à tout moment via le bouton "Gérer mes cookies" présent en bas de chaque page.</p>
            </section>

            <section id="transferts">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">9. Transferts hors UE</h2>
                <p>Le site est hébergé par OVHcloud en France (données au sein de l'UE). Notre outil de mesure d'audience Plausible est hébergé en Allemagne (UE). <span class="font-medium text-dark-700">Aucun transfert de données hors de l'Union européenne n'est effectué.</span></p>
            </section>

            <section id="cnil">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">10. Droit de réclamation auprès de la CNIL</h2>
                <p class="mb-3">Si vous estimez que le traitement de vos données ne respecte pas la réglementation, vous pouvez adresser une réclamation à la Commission Nationale de l'Informatique et des Libertés (CNIL) :</p>
                <div class="bg-dark-50 rounded-lg p-4 text-sm space-y-1 border border-dark-100">
                    <p><span class="font-medium text-dark-700">CNIL</span></p>
                    <p>3 Place de Fontenoy, TSA 80715</p>
                    <p>75334 Paris Cedex 07</p>
                    <p>Site : <a href="https://www.cnil.fr" class="text-accent-600 hover:text-accent-700" target="_blank" rel="noopener noreferrer">www.cnil.fr</a></p>
                </div>
            </section>

            <section id="modifications">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">11. Modifications de cette politique</h2>
                <p>Cette politique peut être mise à jour. En cas de modification substantielle, nous vous en informerons via un bandeau sur le site. La date de dernière mise à jour est indiquée en haut de cette page.</p>
            </section>

        </div>
    </div>
</section>

@endsection
