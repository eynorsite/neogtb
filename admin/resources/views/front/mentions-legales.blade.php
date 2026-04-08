@extends('front.layouts.app')


@section('content')

<section class="py-16 md:py-20">
    <div class="max-w-[680px] mx-auto px-4 sm:px-6">

        <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Informations légales</p>
        <h1 class="font-heading font-medium text-dark-900 mb-2 text-[26px] tracking-tight">Mentions légales</h1>
        <p class="text-sm text-dark-400 mb-12 leading-relaxed">Dernière mise à jour : 18 mars 2026</p>

        <!-- Table des matières -->
        <nav class="bg-dark-50 rounded-xl p-6 mb-12 sticky top-20 z-10 border border-dark-100">
            <h2 class="text-xs font-medium text-dark-400 uppercase tracking-wide mb-3">Sommaire</h2>
            <ol class="space-y-1 text-sm leading-relaxed">
                <li><a href="#editeur" class="text-accent-600 hover:text-accent-700">1. Éditeur du site</a></li>
                <li><a href="#directeur" class="text-accent-600 hover:text-accent-700">2. Directeur de la publication</a></li>
                <li><a href="#hebergeur" class="text-accent-600 hover:text-accent-700">3. Hébergeur</a></li>
                <li><a href="#propriete" class="text-accent-600 hover:text-accent-700">4. Propriété intellectuelle</a></li>
                <li><a href="#responsabilite" class="text-accent-600 hover:text-accent-700">5. Limitation de responsabilité</a></li>
                <li><a href="#donnees" class="text-accent-600 hover:text-accent-700">6. Protection des données personnelles</a></li>
                <li><a href="#cookies" class="text-accent-600 hover:text-accent-700">7. Cookies</a></li>
                <li><a href="#droit" class="text-accent-600 hover:text-accent-700">8. Droit applicable</a></li>
            </ol>
        </nav>

        <div class="space-y-10 text-sm text-dark-500 leading-relaxed">

            <section id="editeur">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">1. Éditeur du site</h2>
                <p class="mb-3">Le site <span class="font-medium text-dark-700">neogtb.fr</span> (ci-après "le Site") est édité par :</p>
                <div class="bg-dark-50 rounded-lg p-4 text-sm space-y-1 border border-dark-100">
                    <p><span class="font-medium text-dark-700">NeoGTB</span> — marque exploitée par EYNOR</p>
                    <p>Forme juridique : EURL (Entreprise Unipersonnelle à Responsabilité Limitée)</p>
                    <p>Siège social : Rue Aimé Césaire, 33320 Eysines, France</p>
                    <p>SIREN : 989 322 144</p>
                    <p>SIRET : 989 322 144 00017</p>
                    <p>RCS : Bordeaux</p>
                    <p>Email : <a href="mailto:hello@neogtb.fr" class="text-accent-600 hover:text-accent-700">hello@neogtb.fr</a></p>
                </div>
            </section>

            <section id="directeur">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">2. Directeur de la publication</h2>
                <p class="mb-2">Le directeur de la publication est : <span class="font-medium text-dark-700">Ulrich CALMO</span>, en qualité de gérant d'EYNOR.</p>
                <p>Contact : <a href="mailto:hello@neogtb.fr" class="text-accent-600 hover:text-accent-700">hello@neogtb.fr</a></p>
            </section>

            <section id="hebergeur">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">3. Hébergeur</h2>
                <div class="bg-dark-50 rounded-lg p-4 text-sm space-y-1 border border-dark-100">
                    <p><span class="font-medium text-dark-700">OVHcloud</span></p>
                    <p>2 rue Kellermann, 59100 Roubaix, France</p>
                    <p>Téléphone : 1007</p>
                    <p>Site : <a href="https://www.ovhcloud.com" class="text-accent-600 hover:text-accent-700" target="_blank" rel="noopener noreferrer">ovhcloud.com</a></p>
                </div>
            </section>

            <section id="propriete">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">4. Propriété intellectuelle</h2>
                <p class="mb-3">L'ensemble du contenu du Site (textes, images, graphismes, logos, icônes, sons, logiciels, etc.) est la propriété exclusive de NeoGTB ou de ses partenaires et est protégé par les lois françaises et internationales relatives à la propriété intellectuelle.</p>
                <p class="mb-3">Toute reproduction, représentation, modification, publication, distribution ou retransmission, totale ou partielle, du contenu du Site, par quelque procédé que ce soit, est strictement interdite sans autorisation écrite préalable.</p>
                <p>Les marques de fabricants GTB mentionnées sur le Site (Siemens, Schneider Electric, Honeywell, Sauter, KNX, TheWatchdog, etc.) sont la propriété de leurs détenteurs respectifs. Leur mention sur le Site est effectuée à titre informatif et ne constitue en aucun cas un partenariat commercial ou une affiliation.</p>
            </section>

            <section id="responsabilite">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">5. Limitation de responsabilité</h2>
                <p class="mb-3">NeoGTB s'efforce d'assurer l'exactitude et la mise à jour des informations diffusées sur le Site. Toutefois, NeoGTB ne peut garantir l'exactitude, la précision ou l'exhaustivité des informations mises à disposition.</p>
                <p class="mb-3">En particulier :</p>
                <ul class="list-disc pl-5 space-y-1 mb-3">
                    <li>Les estimations CEE fournies par le générateur sont <span class="font-medium text-dark-700">indicatives</span> et ne constituent pas un engagement contractuel.</li>
                    <li>Les résultats du diagnostic GTB sont fournis à titre informatif et ne remplacent pas un audit certifié.</li>
                    <li>Les comparaisons de technologies sont réalisées de manière indépendante et objective, mais peuvent contenir des inexactitudes.</li>
                </ul>
                <p>NeoGTB décline toute responsabilité en cas de dommage direct ou indirect résultant de l'utilisation du Site ou de l'impossibilité d'y accéder.</p>
            </section>

            <section id="donnees">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">6. Protection des données personnelles</h2>
                <p class="mb-3">NeoGTB s'engage à protéger vos données personnelles conformément au Règlement Général sur la Protection des Données (RGPD) et à la loi Informatique et Libertés.</p>
                <p class="mb-3">Pour en savoir plus sur la collecte et le traitement de vos données, consultez notre <a href="/politique-de-confidentialite" class="text-accent-600 hover:text-accent-700">Politique de confidentialité</a>.</p>
                <p>Pour exercer vos droits (accès, rectification, suppression, portabilité, opposition), rendez-vous sur notre <a href="/mes-droits-rgpd" class="text-accent-600 hover:text-accent-700">page dédiée</a>.</p>
            </section>

            <section id="cookies">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">7. Cookies</h2>
                <p class="mb-3">Le Site utilise des cookies pour améliorer votre expérience de navigation et analyser le trafic. Vous pouvez à tout moment gérer vos préférences en cliquant sur le bouton "Gérer mes cookies" présent en bas de chaque page.</p>
                <p>Pour plus de détails, consultez la section dédiée dans notre <a href="/politique-de-confidentialite#cookies" class="text-accent-600 hover:text-accent-700">Politique de confidentialité</a>.</p>
            </section>

            <section id="droit">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">8. Droit applicable</h2>
                <p>Les présentes mentions légales sont régies par le droit français. En cas de litige, et après tentative de résolution amiable, les tribunaux français seront seuls compétents.</p>
            </section>

        </div>
    </div>
</section>

@endsection
