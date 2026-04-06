@extends('front.layouts.app')

@section('title', 'Mentions legales')
@section('description', 'Mentions legales de NeoGTB.fr : editeur, hebergeur, propriete intellectuelle et conditions d\'utilisation.')

@section('content')

<section class="py-16 md:py-20">
    <div class="max-w-[680px] mx-auto px-4 sm:px-6">

        <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">Informations legales</p>
        <h1 class="font-heading font-medium text-dark-900 mb-2 text-[26px] tracking-tight">Mentions legales</h1>
        <p class="text-sm text-dark-400 mb-12 leading-relaxed">Derniere mise a jour : 18 mars 2026</p>

        <!-- Table des matieres -->
        <nav class="bg-dark-50 rounded-xl p-6 mb-12 sticky top-20 z-10 border border-dark-100">
            <h2 class="text-xs font-medium text-dark-400 uppercase tracking-wide mb-3">Sommaire</h2>
            <ol class="space-y-1 text-sm leading-relaxed">
                <li><a href="#editeur" class="text-accent-600 hover:text-accent-700">1. Editeur du site</a></li>
                <li><a href="#directeur" class="text-accent-600 hover:text-accent-700">2. Directeur de la publication</a></li>
                <li><a href="#hebergeur" class="text-accent-600 hover:text-accent-700">3. Hebergeur</a></li>
                <li><a href="#propriete" class="text-accent-600 hover:text-accent-700">4. Propriete intellectuelle</a></li>
                <li><a href="#responsabilite" class="text-accent-600 hover:text-accent-700">5. Limitation de responsabilite</a></li>
                <li><a href="#donnees" class="text-accent-600 hover:text-accent-700">6. Protection des donnees personnelles</a></li>
                <li><a href="#cookies" class="text-accent-600 hover:text-accent-700">7. Cookies</a></li>
                <li><a href="#droit" class="text-accent-600 hover:text-accent-700">8. Droit applicable</a></li>
            </ol>
        </nav>

        <div class="space-y-10 text-sm text-dark-500 leading-relaxed">

            <section id="editeur">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">1. Editeur du site</h2>
                <p class="mb-3">Le site <span class="font-medium text-dark-700">neogtb.fr</span> (ci-apres "le Site") est edite par :</p>
                <div class="bg-dark-50 rounded-lg p-4 text-sm space-y-1 border border-dark-100">
                    <p><span class="font-medium text-dark-700">NeoGTB</span> — marque exploitee par EYNOR</p>
                    <p>Forme juridique : EURL (Entreprise Unipersonnelle a Responsabilite Limitee)</p>
                    <p>Siege social : Rue Aime Cesaire, 33320 Eysines, France</p>
                    <p>SIREN : 989 322 144</p>
                    <p>SIRET : 989 322 144 00017</p>
                    <p>RCS : Bordeaux</p>
                    <p>Email : <a href="mailto:hello@neogtb.fr" class="text-accent-600 hover:text-accent-700">hello@neogtb.fr</a></p>
                </div>
            </section>

            <section id="directeur">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">2. Directeur de la publication</h2>
                <p class="mb-2">Le directeur de la publication est : <span class="font-medium text-dark-700">Ulrich CALMO</span>, en qualite de gerant d'EYNOR.</p>
                <p>Contact : <a href="mailto:hello@neogtb.fr" class="text-accent-600 hover:text-accent-700">hello@neogtb.fr</a></p>
            </section>

            <section id="hebergeur">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">3. Hebergeur</h2>
                <div class="bg-dark-50 rounded-lg p-4 text-sm space-y-1 border border-dark-100">
                    <p><span class="font-medium text-dark-700">OVHcloud</span></p>
                    <p>2 rue Kellermann, 59100 Roubaix, France</p>
                    <p>Telephone : 1007</p>
                    <p>Site : <a href="https://www.ovhcloud.com" class="text-accent-600 hover:text-accent-700" target="_blank" rel="noopener noreferrer">ovhcloud.com</a></p>
                </div>
            </section>

            <section id="propriete">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">4. Propriete intellectuelle</h2>
                <p class="mb-3">L'ensemble du contenu du Site (textes, images, graphismes, logos, icones, sons, logiciels, etc.) est la propriete exclusive de NeoGTB ou de ses partenaires et est protege par les lois francaises et internationales relatives a la propriete intellectuelle.</p>
                <p class="mb-3">Toute reproduction, representation, modification, publication, distribution ou retransmission, totale ou partielle, du contenu du Site, par quelque procede que ce soit, est strictement interdite sans autorisation ecrite prealable.</p>
                <p>Les marques de fabricants GTB mentionnees sur le Site (Siemens, Schneider Electric, Honeywell, Sauter, KNX, TheWatchdog, etc.) sont la propriete de leurs detenteurs respectifs. Leur mention sur le Site est effectuee a titre informatif et ne constitue en aucun cas un partenariat commercial ou une affiliation.</p>
            </section>

            <section id="responsabilite">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">5. Limitation de responsabilite</h2>
                <p class="mb-3">NeoGTB s'efforce d'assurer l'exactitude et la mise a jour des informations diffusees sur le Site. Toutefois, NeoGTB ne peut garantir l'exactitude, la precision ou l'exhaustivite des informations mises a disposition.</p>
                <p class="mb-3">En particulier :</p>
                <ul class="list-disc pl-5 space-y-1 mb-3">
                    <li>Les estimations CEE fournies par le generateur sont <span class="font-medium text-dark-700">indicatives</span> et ne constituent pas un engagement contractuel.</li>
                    <li>Les resultats du diagnostic GTB sont fournis a titre informatif et ne remplacent pas un audit certifie.</li>
                    <li>Les comparaisons de technologies sont realisees de maniere independante et objective, mais peuvent contenir des inexactitudes.</li>
                </ul>
                <p>NeoGTB decline toute responsabilite en cas de dommage direct ou indirect resultant de l'utilisation du Site ou de l'impossibilite d'y acceder.</p>
            </section>

            <section id="donnees">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">6. Protection des donnees personnelles</h2>
                <p class="mb-3">NeoGTB s'engage a proteger vos donnees personnelles conformement au Reglement General sur la Protection des Donnees (RGPD) et a la loi Informatique et Libertes.</p>
                <p class="mb-3">Pour en savoir plus sur la collecte et le traitement de vos donnees, consultez notre <a href="/politique-de-confidentialite" class="text-accent-600 hover:text-accent-700">Politique de confidentialite</a>.</p>
                <p>Pour exercer vos droits (acces, rectification, suppression, portabilite, opposition), rendez-vous sur notre <a href="/mes-droits-rgpd" class="text-accent-600 hover:text-accent-700">page dediee</a>.</p>
            </section>

            <section id="cookies">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">7. Cookies</h2>
                <p class="mb-3">Le Site utilise des cookies pour ameliorer votre experience de navigation et analyser le trafic. Vous pouvez a tout moment gerer vos preferences en cliquant sur le bouton "Gerer mes cookies" present en bas de chaque page.</p>
                <p>Pour plus de details, consultez la section dediee dans notre <a href="/politique-de-confidentialite#cookies" class="text-accent-600 hover:text-accent-700">Politique de confidentialite</a>.</p>
            </section>

            <section id="droit">
                <h2 class="font-heading font-medium text-dark-900 mb-3 text-lg">8. Droit applicable</h2>
                <p>Les presentes mentions legales sont regies par le droit francais. En cas de litige, et apres tentative de resolution amiable, les tribunaux francais seront seuls competents.</p>
            </section>

        </div>
    </div>
</section>

@endsection
