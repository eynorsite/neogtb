<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;

/**
 * Seeder des textes légaux (mentions légales, politique de confidentialité,
 * cookies, CGU) pour le site NeoGTB exploité par la SARL EYNOR.
 *
 * Idempotent : peut être rejoué à volonté, il écrase systématiquement
 * general_settings.legal_texts avec la version canonique ci-dessous.
 *
 * Usage :
 *   php artisan db:seed --class=LegalTextsSeeder --force
 */
class LegalTextsSeeder extends Seeder
{
    public function run(): void
    {
        $setting = GeneralSetting::get();
        $legalTexts = $setting->legal_texts ?? [];

        $legalTexts['mentions_legales']         = $this->mentionsLegales();
        $legalTexts['politique_confidentialite'] = $this->politiqueConfidentialite();
        $legalTexts['cookies']                  = $this->cookies();
        $legalTexts['cgu']                      = $this->cgu();

        $setting->legal_texts = $legalTexts;
        $setting->save();

        $this->command->info('Legal texts mis à jour :');
        $this->command->line('  - mentions_legales : ' . strlen($legalTexts['mentions_legales']) . ' chars');
        $this->command->line('  - politique_confidentialite : ' . strlen($legalTexts['politique_confidentialite']) . ' chars');
        $this->command->line('  - cookies : ' . strlen($legalTexts['cookies']) . ' chars');
        $this->command->line('  - cgu : ' . strlen($legalTexts['cgu']) . ' chars');
    }

    private function mentionsLegales(): string
    {
        return <<<'HTML'
<h2>1. Éditeur du site</h2>
<p>Le site <strong>neogtb.fr</strong> (ci-après « le Site ») est édité par :</p>
<ul>
  <li><strong>Raison sociale :</strong> EYNOR (exploitant la marque commerciale « NeoGTB »)</li>
  <li><strong>Forme juridique :</strong> Société à responsabilité limitée (SARL)</li>
  <li><strong>Capital social :</strong> 500 €</li>
  <li><strong>Siège social :</strong> 11 Rue Aimé Césaire, 33320 Eysines, France</li>
  <li><strong>SIRET :</strong> 989 322 144 00019</li>
  <li><strong>SIREN :</strong> 989 322 144</li>
  <li><strong>RCS :</strong> Bordeaux 989 322 144</li>
  <li><strong>Directeur de la publication :</strong> Ulrich Calmo</li>
  <li><strong>Email commercial :</strong> <a href="mailto:hello@neogtb.fr">hello@neogtb.fr</a></li>
  <li><strong>Contact EYNOR :</strong> <a href="mailto:hello@eynor.fr">hello@eynor.fr</a></li>
</ul>

<h2>2. Hébergement</h2>
<p>Le Site est hébergé par :</p>
<ul>
  <li><strong>OVH SAS</strong></li>
  <li>2 rue Kellermann, 59100 Roubaix, France</li>
  <li>RCS Lille Métropole 424 761 419</li>
  <li>Site : <a href="https://www.ovhcloud.com" target="_blank" rel="noopener">ovhcloud.com</a></li>
</ul>

<h2>3. Propriété intellectuelle</h2>
<p>L'ensemble des contenus présents sur le Site (textes, images, graphismes, logos, icônes, données structurées, outils de pré-diagnostic, comparateur de solutions, générateur CEE, tables de protocoles, etc.) est la propriété exclusive d'EYNOR ou de ses partenaires, et est protégé par les lois françaises et internationales relatives à la propriété intellectuelle.</p>
<p>Toute reproduction, représentation, modification, publication ou adaptation, partielle ou totale, des éléments du Site, quel que soit le moyen ou le procédé utilisé, est interdite sans l'autorisation écrite préalable d'EYNOR, sauf exceptions légales (courte citation avec mention de la source).</p>
<p>Les marques et logos tiers éventuellement cités (BACnet, KNX, Modbus, LON, DALI, EnOcean, fabricants de solutions GTB, etc.) demeurent la propriété de leurs titulaires respectifs.</p>

<h2>4. Responsabilité</h2>
<p>Les informations publiées sur le Site ont un caractère informatif et pédagogique. Bien qu'EYNOR veille à la fiabilité et à l'actualité des contenus — notamment en matière réglementaire (décret tertiaire, décret BACS, normes ISO 52120-1, EN 15232) — il ne saurait être tenu responsable des erreurs ou omissions, ni des conséquences qui pourraient résulter de l'utilisation de ces informations.</p>
<p>Les outils proposés (pré-diagnostic GTB, comparateur de solutions, générateur CEE, tables Modbus) fournissent des estimations et orientations indicatives. Ils ne remplacent en aucun cas un audit technique sur site, ni une étude réglementaire formelle. Toute décision d'investissement ou d'équipement doit être validée par un professionnel qualifié.</p>
<p>EYNOR décline toute responsabilité en cas d'interruption temporaire du Site pour maintenance, mise à jour ou tout autre motif technique.</p>

<h2>5. Liens hypertextes</h2>
<p>Le Site peut contenir des liens vers d'autres sites web (sources officielles, documentation technique, articles de référence). EYNOR ne saurait être tenu responsable du contenu de ces sites tiers, ni de l'usage que l'utilisateur pourrait en faire.</p>

<h2>6. Droit applicable</h2>
<p>Les présentes mentions légales sont régies par le droit français. Tout litige relatif à l'utilisation du Site relève de la compétence exclusive des tribunaux français.</p>

<p><em>Dernière mise à jour : 15 avril 2026.</em></p>
HTML;
    }

    private function politiqueConfidentialite(): string
    {
        return <<<'HTML'
<h2>1. Responsable du traitement</h2>
<p>Le responsable du traitement des données à caractère personnel collectées sur <strong>neogtb.fr</strong> est :</p>
<ul>
  <li><strong>EYNOR</strong>, SARL au capital de 500 €</li>
  <li>Siège social : 11 Rue Aimé Césaire, 33320 Eysines, France</li>
  <li>SIRET : 989 322 144 00019 — RCS Bordeaux 989 322 144</li>
  <li>Contact RGPD : <a href="mailto:hello@eynor.fr">hello@eynor.fr</a></li>
</ul>

<h2>2. Données collectées</h2>
<p>Seules les données que vous nous fournissez volontairement sont traitées :</p>
<ul>
  <li><strong>Formulaire de contact :</strong> nom, email professionnel, entreprise (facultatif), sujet, message.</li>
  <li><strong>Pré-diagnostic GTB :</strong> type de bâtiment, surface, puissance CVC, email pour recevoir le rapport.</li>
  <li><strong>Générateur CEE :</strong> paramètres du projet (surface, équipements), email facultatif.</li>
  <li><strong>Veille mensuelle (newsletter) :</strong> email.</li>
  <li><strong>Demande RGPD :</strong> nom, email, type de demande, message.</li>
</ul>
<p>Aucune donnée sensible au sens de l'article 9 du RGPD (santé, opinions politiques, religion, etc.) n'est collectée.</p>

<h2>3. Finalités et bases légales</h2>
<ul>
  <li><strong>Répondre à vos demandes de contact</strong> — Intérêt légitime (art. 6.1.f RGPD) — Conservation : 3 ans après dernier contact.</li>
  <li><strong>Produire votre rapport de pré-diagnostic GTB</strong> — Consentement (art. 6.1.a RGPD) — Conservation : 3 ans.</li>
  <li><strong>Envoyer la veille mensuelle</strong> — Consentement (désinscription possible à tout moment) — Conservation : jusqu'à désinscription.</li>
  <li><strong>Traiter une demande RGPD</strong> — Obligation légale (art. 6.1.c RGPD) — Conservation : 5 ans (traçabilité CNIL).</li>
  <li><strong>Mesurer l'audience de façon anonyme</strong> — Intérêt légitime — Conservation : 13 mois maximum.</li>
</ul>

<h2>4. Destinataires des données</h2>
<p>Vos données ne sont communiquées qu'aux seules personnes ayant besoin d'en connaître dans le cadre de leurs missions au sein d'EYNOR. <strong>EYNOR ne vend, ne loue et ne cède vos données à aucun tiers commercial.</strong></p>
<p>Des sous-traitants techniques peuvent intervenir — tous liés par un accord de sous-traitance conforme à l'article 28 RGPD :</p>
<ul>
  <li><strong>OVH SAS</strong> — hébergement du Site (France).</li>
  <li><strong>Brevo</strong> (ex-Sendinblue) — envoi d'emails transactionnels et de la veille (France).</li>
</ul>

<h2>5. Transferts hors UE</h2>
<p>Aucune donnée personnelle n'est transférée hors de l'Union européenne. L'hébergement et les services tiers utilisés sont localisés en France.</p>

<h2>6. Vos droits</h2>
<p>Conformément aux articles 15 à 22 du RGPD et à la loi Informatique et Libertés, vous disposez des droits suivants :</p>
<ul>
  <li><strong>Droit d'accès</strong> — obtenir une copie des données vous concernant.</li>
  <li><strong>Droit de rectification</strong> — corriger des données inexactes ou incomplètes.</li>
  <li><strong>Droit à l'effacement</strong> (« droit à l'oubli ») — demander la suppression de vos données.</li>
  <li><strong>Droit à la limitation</strong> — restreindre le traitement dans certains cas.</li>
  <li><strong>Droit à la portabilité</strong> — récupérer vos données dans un format structuré et réutilisable.</li>
  <li><strong>Droit d'opposition</strong> — vous opposer à un traitement fondé sur l'intérêt légitime.</li>
  <li><strong>Droit de retirer votre consentement</strong> à tout moment, sans remettre en cause la licéité du traitement antérieur.</li>
</ul>
<p>Pour exercer ces droits, utilisez le formulaire dédié sur <a href="/mes-droits-rgpd">neogtb.fr/mes-droits-rgpd</a>, ou écrivez à <a href="mailto:hello@eynor.fr">hello@eynor.fr</a>. Une réponse vous sera apportée sous 30 jours maximum.</p>
<p>En cas de désaccord sur le traitement de vos données, vous pouvez saisir la CNIL : <a href="https://www.cnil.fr/fr/plaintes" target="_blank" rel="noopener">www.cnil.fr/fr/plaintes</a>.</p>

<h2>7. Sécurité des données</h2>
<p>EYNOR met en œuvre des mesures techniques et organisationnelles appropriées pour protéger vos données :</p>
<ul>
  <li>Connexion HTTPS/TLS systématique (certificat Let's Encrypt).</li>
  <li>Chiffrement des données sensibles en base (formulaires contact, demandes RGPD).</li>
  <li>Accès administratif limité et tracé (journal d'audit).</li>
  <li>Sauvegardes quotidiennes chiffrées.</li>
  <li>Mots de passe hachés (bcrypt).</li>
</ul>

<h2>8. Cookies</h2>
<p>Le Site utilise uniquement des cookies strictement nécessaires à son fonctionnement. Pour plus de détails, consultez notre <a href="/cookies">Politique cookies</a>.</p>

<h2>9. Référent RGPD</h2>
<p>Conformément à sa taille, EYNOR n'est pas soumise à l'obligation de désigner un Délégué à la Protection des Données (DPO) au sens du RGPD. Pour toute question relative à vos données, vous pouvez néanmoins contacter notre référent RGPD à l'adresse <a href="mailto:hello@eynor.fr">hello@eynor.fr</a>.</p>

<p><em>Dernière mise à jour : 15 avril 2026 — Version 1.0.</em></p>
HTML;
    }

    private function cookies(): string
    {
        return <<<'HTML'
<h2>1. Qu'est-ce qu'un cookie ?</h2>
<p>Un cookie est un petit fichier texte déposé sur votre appareil (ordinateur, smartphone, tablette) lors de votre visite sur un site web. Il permet au site de mémoriser des informations (préférences, session de connexion, mesure d'audience, etc.).</p>

<h2>2. Les cookies utilisés sur neogtb.fr</h2>

<h3>2.1 Cookies strictement nécessaires (sans consentement)</h3>
<p>Ces cookies sont indispensables au fonctionnement du Site et ne peuvent pas être désactivés. Ils ne collectent aucune donnée personnelle identifiable.</p>
<ul>
  <li><strong>XSRF-TOKEN</strong> — Protection contre les attaques CSRF — Session.</li>
  <li><strong>neogtb_session</strong> — Gestion de la session utilisateur — Session.</li>
  <li><strong>cookie_consent</strong> — Mémorisation de votre choix de consentement — 13 mois.</li>
</ul>

<h3>2.2 Cookies de mesure d'audience (avec consentement)</h3>
<p>Ces cookies permettent de comprendre comment les visiteurs utilisent le Site et d'en améliorer l'ergonomie. Ils ne sont déposés qu'avec votre consentement explicite.</p>
<p><em>Aucun cookie de mesure d'audience n'est actuellement actif sur neogtb.fr. En cas d'activation future (ex. Plausible, Matomo), cette politique sera mise à jour.</em></p>

<h3>2.3 Cookies publicitaires</h3>
<p><strong>Nous n'utilisons aucun cookie publicitaire.</strong> EYNOR est un cabinet de conseil indépendant et ne monétise aucun espace publicitaire sur le Site.</p>

<h2>3. Gérer vos préférences</h2>
<p>Vous pouvez à tout moment :</p>
<ul>
  <li><strong>Modifier vos choix</strong> via le bouton « Gérer les cookies » en bas de page.</li>
  <li><strong>Configurer votre navigateur</strong> pour refuser tous les cookies (ce qui peut limiter certaines fonctionnalités du Site).</li>
  <li><strong>Supprimer les cookies existants</strong> depuis les paramètres de votre navigateur.</li>
</ul>

<h2>4. Liens utiles</h2>
<ul>
  <li><a href="https://www.cnil.fr/fr/cookies-et-autres-traceurs/regles/cookies-solutions-pour-les-maitriser" target="_blank" rel="noopener">Guide CNIL — gérer les cookies</a></li>
  <li><a href="/politique-de-confidentialite">Notre politique de confidentialité</a></li>
  <li><a href="/mes-droits-rgpd">Exercer vos droits RGPD</a></li>
</ul>

<p><em>Dernière mise à jour : 15 avril 2026.</em></p>
HTML;
    }

    private function cgu(): string
    {
        return <<<'HTML'
<h2>1. Objet</h2>
<p>Les présentes Conditions Générales d'Utilisation (ci-après « CGU ») définissent les modalités d'accès et d'utilisation du site <strong>neogtb.fr</strong> (ci-après « le Site »), édité par EYNOR (SARL) sous la marque « NeoGTB ». En accédant au Site, vous acceptez sans réserve les présentes CGU.</p>

<h2>2. Accès au site</h2>
<p>Le Site est accessible gratuitement à tout utilisateur disposant d'un accès Internet. Les frais liés à l'accès (matériel, connexion) sont à la charge de l'utilisateur.</p>
<p>EYNOR s'efforce de maintenir le Site accessible 24 h / 24 et 7 j / 7, mais se réserve le droit d'interrompre temporairement l'accès pour maintenance, mises à jour ou tout autre motif technique, sans préavis.</p>

<h2>3. Services proposés</h2>
<p>Le Site met à disposition :</p>
<ul>
  <li>Des contenus informatifs et pédagogiques sur la Gestion Technique du Bâtiment (GTB/GTC).</li>
  <li>Des outils gratuits : pré-diagnostic GTB (norme ISO 52120-1), comparateur de solutions, générateur d'estimation CEE (BAT-TH-116), tables de protocoles Modbus.</li>
  <li>Un blog d'analyses et de veille réglementaire.</li>
  <li>Des formulaires de contact pour toute demande d'information ou d'audit personnalisé.</li>
</ul>
<p>Les prestations payantes (audits sur site, rédaction de cahiers des charges, assistance à maîtrise d'ouvrage) font l'objet de devis individuels et de contrats séparés, en dehors du champ des présentes CGU.</p>

<h2>4. Obligations de l'utilisateur</h2>
<p>L'utilisateur s'engage à :</p>
<ul>
  <li>Utiliser le Site conformément à sa destination et dans le respect du droit applicable.</li>
  <li>Ne pas tenter d'accéder à des espaces réservés (administration, comptes utilisateurs).</li>
  <li>Ne pas porter atteinte à l'intégrité ou à la sécurité du Site (tentatives d'intrusion, scraping massif, injections, dénis de service).</li>
  <li>Fournir des informations exactes lors de l'utilisation des formulaires et outils.</li>
  <li>Ne pas exploiter commercialement les contenus ou outils du Site sans autorisation écrite préalable.</li>
</ul>

<h2>5. Propriété intellectuelle</h2>
<p>L'ensemble des contenus du Site est protégé par les lois relatives à la propriété intellectuelle. Voir les <a href="/mentions-legales">mentions légales</a> pour plus de détails.</p>

<h2>6. Limitation de responsabilité</h2>
<p>Les informations, outils et estimations fournis sur le Site ont un caractère informatif. Ils ne constituent pas un conseil d'ingénierie formel ni un document réglementaire. EYNOR décline toute responsabilité concernant les décisions prises par l'utilisateur sur la base de ces éléments. Toute décision d'investissement ou de conformité réglementaire doit être validée par une étude dédiée et un professionnel qualifié.</p>

<h2>7. Données personnelles</h2>
<p>Le traitement des données personnelles collectées via le Site est détaillé dans notre <a href="/politique-de-confidentialite">Politique de confidentialité</a>. Vous pouvez exercer vos droits RGPD via <a href="/mes-droits-rgpd">neogtb.fr/mes-droits-rgpd</a>.</p>

<h2>8. Modification des CGU</h2>
<p>EYNOR se réserve le droit de modifier les présentes CGU à tout moment. La version en vigueur est celle publiée sur le Site à la date de votre accès. Il est recommandé de les consulter régulièrement.</p>

<h2>9. Droit applicable et juridiction</h2>
<p>Les présentes CGU sont soumises au droit français. En cas de litige, et à défaut de résolution amiable, les tribunaux français seront seuls compétents.</p>

<h2>10. Contact</h2>
<p>Pour toute question relative aux présentes CGU : <a href="mailto:hello@neogtb.fr">hello@neogtb.fr</a> ou <a href="mailto:hello@eynor.fr">hello@eynor.fr</a>.</p>

<p><em>Dernière mise à jour : 15 avril 2026.</em></p>
HTML;
    }
}
