<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;

class GeneralSettingsSeeder extends Seeder
{
    public function run(): void
    {
        GeneralSetting::updateOrCreate(['id' => 1], [
            // IDENTITÉ
            'company_name' => 'NeoGTB',
            'company_tagline' => 'Maîtrisez la Gestion Technique de vos Bâtiments',
            'company_email' => 'contact@neogtb.fr',
            'company_website' => 'https://neogtb.fr',
            'company_country' => 'France',
            'company_founding_year' => 2026,
            'company_description' => 'NeoGTB - Tout savoir sur la Gestion Technique du Bâtiment (GTB) et la Gestion Technique Centralisée (GTC). Guides, audits gratuits et comparateurs.',
            'company_opening_hours' => ['lun_ven' => '09:00 - 18:00', 'sam' => 'Fermé', 'dim' => 'Fermé'],

            // THÈME
            'primary_color' => '#1E3A5F',
            'secondary_color' => '#2D5F8A',
            'accent_color' => '#F59E0B',
            'header_bg_color' => '#0F172A',
            'header_text_color' => '#F8FAFC',
            'footer_bg_color' => '#1E293B',
            'footer_text_color' => '#CBD5E1',
            'body_bg_color' => '#FFFFFF',
            'hero_overlay_color' => '#0F172A',
            'hero_overlay_opacity' => 60,
            'hero_style' => 'static',
            'hero_title_line1' => 'La GTB au service',
            'hero_title_line2' => 'de la performance énergétique',
            'cta_bg_color' => '#F59E0B',
            'cta_text_color' => '#0F172A',
            'font_pair' => 'inter_dm_sans',
            'font_size_base' => 'md',
            'border_radius_style' => 'medium',
            'shadow_style' => 'subtle',

            // NAVIGATION
            'nav_cta_text' => 'Demander un audit',
            'nav_cta_url' => '/audit',
            'nav_cta_visible' => true,
            'nav_show_phone' => false,
            'nav_style' => 'sticky',
            'nav_sticky' => true,
            'nav_items' => [
                ['label' => 'Accueil', 'url' => '/', 'type' => 'link', 'visible' => true],
                ['label' => 'GTB', 'url' => '/gtb', 'type' => 'link', 'visible' => true],
                ['label' => 'GTC', 'url' => '/gtc', 'type' => 'link', 'visible' => true],
                ['label' => 'Solutions', 'url' => '/solutions', 'type' => 'link', 'visible' => true],
                ['label' => 'Réglementation', 'url' => '/reglementation', 'type' => 'link', 'visible' => true],
                ['label' => 'Blog', 'url' => '/blog', 'type' => 'link', 'visible' => true],
                ['label' => 'Contact', 'url' => '/contact', 'type' => 'link', 'visible' => true],
            ],

            // SEO
            'seo_title_suffix' => ' — NeoGTB',
            'seo_default_description' => 'NeoGTB - Tout savoir sur la Gestion Technique du Bâtiment (GTB) et la Gestion Technique Centralisée (GTC). Guides, audits gratuits et comparateurs.',
            'seo_robots' => 'index, follow',
            'seo_schema_type' => 'Organization',
            'seo_canonical_url' => 'https://neogtb.fr',

            // TRACKING
            'cookie_banner_enabled' => true,
            'cookie_banner_text' => 'Ce site utilise des cookies pour améliorer votre expérience. En continuant, vous acceptez notre politique de cookies.',

            // ANNONCE
            'announcement_enabled' => false,
            'announcement_bg_color' => '#2563eb',
            'announcement_text_color' => '#ffffff',
            'announcement_dismissable' => true,

            // MAINTENANCE
            'maintenance_enabled' => false,
            'maintenance_message' => 'Le site est actuellement en maintenance. Nous serons bientôt de retour.',

            // EMAIL
            'email_from_name' => 'NeoGTB',
            'email_from_address' => 'contact@neogtb.fr',

            // RGPD
            'rgpd_retention_contacts_days' => 730,
            'rgpd_retention_leads_days' => 1095,
            'rgpd_retention_cookies_days' => 395,
            'rgpd_retention_newsletter_days' => 1095,

            // SÉCURITÉ
            'smtp_port' => 587,
            'smtp_encryption' => 'tls',

            // BLOG
            'blog_default_cover' => '/images/blog-default-cover.png',

            // STATISTIQUES
            'stat_buildings_audited' => 150,
            'stat_buildings_auto' => false,
            'stat_avg_savings_percent' => 35,
            'stat_years_experience' => 12,
            'stat_clients_count' => 80,
            'stat_clients_auto' => false,

            // UI LABELS
            'ui_labels' => [
                'forms' => [
                    'name' => 'Nom',
                    'first_name' => 'Prénom',
                    'email' => 'Email',
                    'phone' => 'Téléphone',
                    'company' => 'Entreprise',
                    'message' => 'Message',
                    'subject' => 'Sujet',
                    'submit' => 'Envoyer',
                    'cancel' => 'Annuler',
                    'required_fields' => 'Les champs marqués d\'un * sont obligatoires',
                    'success_message' => 'Votre message a bien été envoyé',
                    'error_message' => 'Une erreur est survenue, veuillez réessayer',
                    'building_type' => 'Type de bâtiment',
                    'surface' => 'Surface (m²)',
                    'building_year' => 'Année de construction',
                    'energy_bill' => 'Facture énergétique annuelle (€)',
                    'gtb_level' => 'Niveau GTB actuel',
                ],
                'header' => [
                    'home' => 'Accueil',
                    'gtb' => 'GTB',
                    'gtc' => 'GTC',
                    'solutions' => 'Solutions',
                    'reglementation' => 'Réglementation',
                    'blog' => 'Blog',
                    'contact' => 'Contact',
                    'audit_cta' => 'Audit gratuit',
                    'breadcrumb_label' => 'Fil d\'Ariane',
                ],
                'footer' => [
                    'col1_title' => 'Comprendre',
                    'col2_title' => 'Outils',
                    'col3_title' => 'Légal',
                    'col4_title' => 'Newsletter',
                    'newsletter_placeholder' => 'Votre email',
                    'newsletter_button' => 'S\'abonner',
                    'newsletter_subtitle' => 'Veille GTB mensuelle',
                    'copyright_prefix' => '©',
                    'no_tracking' => 'Ce site n\'utilise aucun cookie de tracking.',
                ],
                'cta' => [
                    'audit_title' => 'Prêt à optimiser votre bâtiment ?',
                    'audit_subtitle' => 'Obtenez un diagnostic GTB personnalisé en moins de 5 minutes.',
                    'audit_button' => 'Lancer l\'audit gratuit',
                    'contact_us' => 'Contactez-nous',
                    'learn_more' => 'En savoir plus',
                    'download' => 'Télécharger',
                    'compare' => 'Comparer',
                    'back_to_blog' => 'Retour au blog',
                ],
                'search' => [
                    'placeholder' => 'Rechercher un article...',
                    'no_results' => 'Aucun résultat trouvé',
                    'loading' => 'Chargement...',
                ],
                'cookie' => [
                    'title' => 'Gestion des cookies',
                    'description' => 'Nous utilisons des cookies pour améliorer votre expérience de navigation et analyser notre trafic.',
                    'accept' => 'Tout accepter',
                    'reject' => 'Tout refuser',
                    'customize' => 'Personnaliser',
                    'save_preferences' => 'Enregistrer mes préférences',
                    'necessary_title' => 'Cookies nécessaires',
                    'necessary_desc' => 'Indispensables au fonctionnement du site.',
                    'analytics_title' => 'Cookies analytiques',
                    'analytics_desc' => 'Nous permettent de mesurer l\'audience du site.',
                ],
                'validation' => [
                    'required' => 'Ce champ est obligatoire',
                    'email_invalid' => 'L\'adresse email n\'est pas valide',
                    'phone_invalid' => 'Le numéro de téléphone n\'est pas valide',
                    'min_length' => 'Ce champ doit contenir au moins :min caractères',
                    'max_length' => 'Ce champ ne doit pas dépasser :max caractères',
                ],
                'pagination' => [
                    'previous' => 'Précédent',
                    'next' => 'Suivant',
                    'showing' => 'Affichage de',
                    'to' => 'à',
                    'of' => 'sur',
                    'results' => 'résultats',
                ],
                'misc' => [
                    'loading' => 'Chargement...',
                    'no_data' => 'Aucune donnée disponible',
                    'back' => 'Retour',
                    'close' => 'Fermer',
                    'share' => 'Partager',
                    'print' => 'Imprimer',
                    'reading_time' => 'min de lecture',
                    'published_on' => 'Publié le',
                    'updated_on' => 'Mis à jour le',
                ],
                'faq' => [
                    'eyebrow' => 'Questions fréquentes',
                    'title' => 'Vos questions sur la GTB/GTC',
                    'subtitle' => 'Tout ce que vous devez savoir sur la Gestion Technique du Bâtiment et la conformité réglementaire',
                    'cta_text' => 'Vous ne trouvez pas votre réponse ?',
                    'cta_button' => 'Contactez un expert',
                ],
            ],

            // FAQ PAGE CONFIG — contenu administrable de la page /faq
            'faq_page_config' => [
                'hero_title' => 'Questions fréquentes',
                'hero_subtitle' => 'Tout ce que vous devez savoir sur NeoGTB, la GTB, le décret BACS et nos outils.',
                'meta_title' => 'FAQ NeoGTB — Questions fréquentes sur la GTB',
                'meta_description' => 'Réponses aux questions sur NeoGTB, la GTB, le décret BACS, la norme ISO 52120-1 et nos outils et prestations.',
                'sections' => [
                    [
                        'label' => 'À propos de NeoGTB',
                        'items' => [
                            [
                                'question' => "Qu'est-ce que NeoGTB ?",
                                'answer' => "NeoGTB est un service de conseil indépendant spécialisé dans la Gestion Technique du Bâtiment (GTB). Créé par Ulrich Calmo via la société EYNOR, NeoGTB propose des outils gratuits (diagnostic, comparateur, générateur CEE) et des prestations de conseil payantes (audits sur site, cahiers des charges, AMO GTB). NeoGTB ne vend aucun équipement et n'a aucun lien commercial avec les fabricants.",
                            ],
                            [
                                'question' => "Comment NeoGTB gagne-t-il de l'argent ?",
                                'answer' => "NeoGTB vend du conseil, pas du matériel. Les revenus proviennent exclusivement de prestations de conseil technique : audits approfondis sur site, rédaction de cahiers des charges neutres, et assistance à maîtrise d'ouvrage GTB. Les outils en ligne (diagnostic, comparateur, générateur CEE) sont gratuits et le resteront. Aucune commission n'est perçue sur les ventes de matériel ou les prescriptions.",
                            ],
                            [
                                'question' => "Pourquoi les outils sont-ils gratuits ?",
                                'answer' => "Les outils gratuits servent à éduquer le marché et à démontrer l'approche NeoGTB. Pas de piège : pas d'inscription obligatoire, pas de relance commerciale, pas de revente de données. Si après avoir utilisé les outils vous souhaitez aller plus loin avec un audit sur site, vous pouvez me contacter — mais il n'y a aucune obligation.",
                            ],
                            [
                                'question' => "Êtes-vous vraiment indépendant ?",
                                'answer' => "Oui. EYNOR, la société derrière NeoGTB, n'a aucun actionnaire fabricant, aucun partenariat commercial rémunéré, aucun lien d'affiliation. Les critères de comparaison sont publics et vérifiables sur le site. Si je recommande BACnet plutôt que LON pour votre projet, c'est une décision technique, pas commerciale. Vous pouvez consulter ma <a href='/positionnement' class='text-accent-600 hover:text-accent-700'>charte d'indépendance</a>.",
                            ],
                        ],
                    ],
                    [
                        'label' => 'GTB & Réglementation',
                        'items' => [
                            [
                                'question' => "Qu'est-ce que la GTB ?",
                                'answer' => "La Gestion Technique du Bâtiment (GTB) est un système centralisé qui pilote et supervise les équipements techniques d'un bâtiment : chauffage, ventilation, climatisation (CVC), éclairage, stores, contrôle d'accès, comptage énergie. L'objectif : optimiser la consommation énergétique, améliorer le confort et faciliter la maintenance. Pour un guide complet, consultez notre page <a href='/gtb' class='text-accent-600 hover:text-accent-700'>Qu'est-ce que la GTB ?</a>",
                            ],
                            [
                                'question' => "Mon bâtiment est-il concerné par le décret BACS ?",
                                'answer' => "Si votre bâtiment est tertiaire (bureaux, commerces, enseignement, santé...) et que sa puissance CVC dépasse 290 kW, vous devez avoir un système BACS de classe B minimum depuis le 1er janvier 2025. Pour les bâtiments entre 70 et 290 kW, l'échéance est fixée à 2030. Pour les bâtiments neufs avec permis postérieur au 21/07/2021, c'est obligatoire dès la construction. <a href='/audit' class='text-accent-600 hover:text-accent-700'>Faites le diagnostic gratuit</a> pour savoir où vous en êtes.",
                            ],
                            [
                                'question' => "Que signifient les classes A, B, C, D de la norme ISO 52120-1 (ex-EN 15232) ?",
                                'answer' => "La norme ISO 52120-1 (ex-EN 15232) classe les systèmes de gestion technique en 4 niveaux. <strong>Classe D</strong> : aucune automatisation, pas performant. <strong>Classe C</strong> : automatisation standard, le minimum. <strong>Classe B</strong> : automatisation avancée avec supervision centralisée — c'est le niveau requis par le décret BACS. <strong>Classe A</strong> : haute performance, avec optimisation énergétique et gestion prédictive. Notre <a href='/audit' class='text-accent-600 hover:text-accent-700'>diagnostic gratuit</a> vous situe sur cette échelle.",
                            ],
                            [
                                'question' => "Quel protocole choisir : BACnet, KNX ou Modbus ?",
                                'answer' => "Il n'y a pas de réponse universelle — ça dépend de votre contexte. <strong>BACnet</strong> est le standard international de la GTB, privilégié pour les grands bâtiments tertiaires et l'interopérabilité multi-marques. <strong>KNX</strong> excelle pour l'éclairage et les stores, avec 500+ fabricants certifiés. <strong>Modbus</strong> est simple et dominant pour le comptage énergie. Notre <a href='/comparateur' class='text-accent-600 hover:text-accent-700'>comparateur</a> vous aide à y voir clair sans biais commercial.",
                            ],
                        ],
                    ],
                    [
                        'label' => 'Outils & Prestations',
                        'items' => [
                            [
                                'question' => "Combien coûte un audit GTB avec NeoGTB ?",
                                'answer' => "Le diagnostic en ligne est gratuit, sans inscription. Pour un audit approfondi sur site avec rapport détaillé, les tarifs dépendent de la surface, du nombre de sites et de la complexité de l'installation. <a href='/contact' class='text-accent-600 hover:text-accent-700'>Contactez-moi</a> avec votre contexte pour obtenir un devis. Comptez un premier échange gratuit de 15 minutes pour cadrer votre besoin.",
                            ],
                            [
                                'question' => "Le diagnostic en ligne est-il fiable ?",
                                'answer' => "Le diagnostic en ligne est un outil d'orientation basé sur la norme ISO 52120-1. Il donne une estimation de votre niveau de maturité GTB (classe A à D) et des recommandations générales. Pour un diagnostic certifié avec mesures sur site, un audit approfondi est nécessaire. L'outil en ligne est un excellent point de départ pour savoir si vous avez besoin d'aller plus loin.",
                            ],
                            [
                                'question' => "Dans quelle zone géographique intervenez-vous ?",
                                'answer' => "Les outils en ligne sont accessibles partout. Pour les prestations sur site (audits, AMO), j'interviens principalement en Nouvelle-Aquitaine et sur l'ensemble du territoire français selon la mission. Les échanges préliminaires et le conseil à distance se font sans contrainte géographique.",
                            ],
                        ],
                    ],
                ],
            ],

            // STATUS CONFIGS
            'status_configs' => [
                'post' => [
                    ['key' => 'draft', 'label' => 'Brouillon', 'color' => 'gray', 'icon' => 'heroicon-o-pencil'],
                    ['key' => 'published', 'label' => 'Publié', 'color' => 'success', 'icon' => 'heroicon-o-check-circle'],
                    ['key' => 'archived', 'label' => 'Archivé', 'color' => 'warning', 'icon' => 'heroicon-o-archive-box'],
                ],
                'audit_lead' => [
                    ['key' => 'new', 'label' => 'Nouveau', 'color' => 'info', 'icon' => 'heroicon-o-sparkles'],
                    ['key' => 'contacted', 'label' => 'Contacté', 'color' => 'primary', 'icon' => 'heroicon-o-phone'],
                    ['key' => 'qualified', 'label' => 'Qualifié', 'color' => 'warning', 'icon' => 'heroicon-o-star'],
                    ['key' => 'converted', 'label' => 'Converti', 'color' => 'success', 'icon' => 'heroicon-o-check-badge'],
                    ['key' => 'lost', 'label' => 'Perdu', 'color' => 'danger', 'icon' => 'heroicon-o-x-circle'],
                ],
                'cee_lead' => [
                    ['key' => 'new', 'label' => 'Nouveau', 'color' => 'info', 'icon' => 'heroicon-o-sparkles'],
                    ['key' => 'processing', 'label' => 'En traitement', 'color' => 'warning', 'icon' => 'heroicon-o-clock'],
                    ['key' => 'sent', 'label' => 'Dossier envoyé', 'color' => 'primary', 'icon' => 'heroicon-o-paper-airplane'],
                    ['key' => 'signed', 'label' => 'Signé', 'color' => 'success', 'icon' => 'heroicon-o-check-circle'],
                ],
                'contact_message' => [
                    ['key' => 'new', 'label' => 'Nouveau', 'color' => 'info', 'icon' => 'heroicon-o-envelope'],
                    ['key' => 'read', 'label' => 'Lu', 'color' => 'gray', 'icon' => 'heroicon-o-envelope-open'],
                    ['key' => 'replied', 'label' => 'Répondu', 'color' => 'success', 'icon' => 'heroicon-o-check-circle'],
                    ['key' => 'archived', 'label' => 'Archivé', 'color' => 'warning', 'icon' => 'heroicon-o-archive-box'],
                ],
                'gdpr_request' => [
                    ['key' => 'pending', 'label' => 'En attente', 'color' => 'warning', 'icon' => 'heroicon-o-clock'],
                    ['key' => 'processing', 'label' => 'En traitement', 'color' => 'info', 'icon' => 'heroicon-o-cog-6-tooth'],
                    ['key' => 'completed', 'label' => 'Traitée', 'color' => 'success', 'icon' => 'heroicon-o-check-circle'],
                    ['key' => 'rejected', 'label' => 'Refusée', 'color' => 'danger', 'icon' => 'heroicon-o-x-circle'],
                ],
            ],

            // TEXTES LÉGAUX
            'legal_texts' => [
                'cookie_consent' => [
                    'title' => 'Gestion des cookies',
                    'description' => 'Nous utilisons des cookies pour améliorer votre expérience.',
                    'accept' => 'Tout accepter',
                    'reject' => 'Tout refuser',
                    'customize' => 'Personnaliser',
                    'categories' => [
                        ['key' => 'necessary', 'label' => 'Cookies nécessaires', 'description' => 'Indispensables au fonctionnement du site.', 'required' => true],
                        ['key' => 'analytics', 'label' => 'Cookies analytiques', 'description' => 'Mesure d\'audience anonymisée.'],
                    ],
                ],
                'mentions_legales' => '<h2>1. Éditeur du site</h2>
<p>Le site <strong>neogtb.fr</strong> (ci-après « le Site ») est édité par :</p>
<ul>
<li><strong>Raison sociale :</strong> NeoGTB</li>
<li><strong>Forme juridique :</strong> [FORME JURIDIQUE]</li>
<li><strong>Adresse du siège social :</strong> [ADRESSE COMPLÈTE]</li>
<li><strong>SIRET :</strong> [NUMÉRO SIRET]</li>
<li><strong>RCS :</strong> [VILLE ET NUMÉRO RCS]</li>
<li><strong>Capital social :</strong> [MONTANT] €</li>
<li><strong>Directeur de la publication :</strong> [NOM DU DIRECTEUR DE PUBLICATION]</li>
<li><strong>Email :</strong> contact@neogtb.fr</li>
<li><strong>Téléphone :</strong> [NUMÉRO DE TÉLÉPHONE]</li>
</ul>

<h2>2. Hébergeur</h2>
<p>Le Site est hébergé par :</p>
<ul>
<li><strong>Nom :</strong> [NOM DE L\'HÉBERGEUR]</li>
<li><strong>Adresse :</strong> [ADRESSE DE L\'HÉBERGEUR]</li>
<li><strong>Téléphone :</strong> [TÉLÉPHONE DE L\'HÉBERGEUR]</li>
<li><strong>Site web :</strong> [URL DE L\'HÉBERGEUR]</li>
</ul>

<h2>3. Objet du site</h2>
<p>Le site NeoGTB est un site éducatif et informatif dédié à la Gestion Technique du Bâtiment (GTB) et à la Gestion Technique Centralisée (GTC). Il propose des contenus pédagogiques, des guides pratiques, un outil d\'audit en ligne et des ressources sur la réglementation applicable (décret tertiaire, RE2020, norme EN 15232).</p>

<h2>4. Propriété intellectuelle</h2>
<p>L\'ensemble du contenu du Site (textes, images, graphismes, logo, icônes, vidéos, logiciels, bases de données, structure) est protégé par les lois françaises et internationales relatives à la propriété intellectuelle.</p>
<p>Toute reproduction, représentation, modification, publication, adaptation, totale ou partielle, des éléments du Site, quel que soit le moyen ou le procédé utilisé, est interdite sans l\'autorisation écrite préalable de NeoGTB.</p>
<p>Les marques, logos et dénominations sociales présents sur le Site sont la propriété de NeoGTB ou de leurs détenteurs respectifs. Toute utilisation non autorisée constitue une contrefaçon sanctionnée par le Code de la propriété intellectuelle.</p>

<h2>5. Limitation de responsabilité</h2>
<p>Les informations publiées sur le Site sont fournies à titre indicatif et éducatif. NeoGTB s\'efforce de les maintenir à jour et exactes, mais ne saurait garantir leur exhaustivité ni leur adéquation à une situation particulière.</p>
<p>NeoGTB ne pourra être tenu responsable des dommages directs ou indirects résultant de l\'utilisation du Site, notamment en cas d\'erreur, d\'omission, d\'indisponibilité des informations ou de la présence de virus.</p>
<p>Les résultats de l\'outil d\'audit GTB en ligne sont fournis à titre indicatif et ne se substituent pas à un diagnostic professionnel réalisé par un bureau d\'études spécialisé.</p>

<h2>6. Liens hypertextes</h2>
<p>Le Site peut contenir des liens vers des sites tiers. NeoGTB n\'exerce aucun contrôle sur le contenu de ces sites et décline toute responsabilité quant à leur contenu ou aux éventuels dommages résultant de leur consultation.</p>
<p>La création de liens hypertextes vers le Site est autorisée sous réserve de ne pas utiliser la technique du framing ou toute autre technique portant atteinte à l\'image de NeoGTB.</p>

<h2>7. Données personnelles</h2>
<p>Le traitement des données personnelles est décrit dans notre <a href="/politique-de-confidentialite">Politique de confidentialité</a>. Conformément au Règlement Général sur la Protection des Données (RGPD), vous disposez de droits détaillés sur la page <a href="/mes-droits-rgpd">Mes droits RGPD</a>.</p>

<h2>8. Cookies</h2>
<p>L\'utilisation des cookies sur le Site est décrite dans notre <a href="/cookies">Politique de cookies</a>.</p>

<h2>9. Droit applicable et juridiction compétente</h2>
<p>Les présentes mentions légales sont régies par le droit français. En cas de litige, les tribunaux français seront seuls compétents, après tentative de résolution amiable.</p>

<h2>10. Crédits</h2>
<p>Conception et développement : NeoGTB.</p>
<p>Dernière mise à jour : avril 2026.</p>',
                'politique_confidentialite' => '<h2>1. Responsable de traitement</h2>
<p>Le responsable du traitement des données personnelles collectées sur le site <strong>neogtb.fr</strong> est :</p>
<ul>
<li><strong>NeoGTB</strong></li>
<li>Adresse : [ADRESSE COMPLÈTE]</li>
<li>Email : contact@neogtb.fr</li>
<li>Téléphone : [NUMÉRO DE TÉLÉPHONE]</li>
</ul>

<h2>2. Données collectées et finalités</h2>
<p>Nous collectons les données personnelles suivantes dans le cadre des finalités décrites ci-dessous :</p>

<h3>a) Formulaire de contact</h3>
<ul>
<li><strong>Données :</strong> nom, prénom, adresse email, numéro de téléphone (facultatif), entreprise (facultatif), message</li>
<li><strong>Finalité :</strong> répondre à vos demandes d\'information sur la GTB/GTC</li>
<li><strong>Base légale :</strong> consentement (article 6.1.a du RGPD)</li>
</ul>

<h3>b) Outil d\'audit GTB en ligne</h3>
<ul>
<li><strong>Données :</strong> nom, prénom, email, téléphone, nom de l\'entreprise, type de bâtiment, surface, année de construction, données énergétiques, niveau GTB actuel</li>
<li><strong>Finalité :</strong> générer un diagnostic GTB personnalisé et vous transmettre les résultats</li>
<li><strong>Base légale :</strong> consentement (article 6.1.a du RGPD)</li>
</ul>

<h3>c) Newsletter</h3>
<ul>
<li><strong>Données :</strong> adresse email</li>
<li><strong>Finalité :</strong> envoi de la veille GTB mensuelle (actualités, guides, réglementation)</li>
<li><strong>Base légale :</strong> consentement (article 6.1.a du RGPD)</li>
</ul>

<h3>d) Navigation sur le site</h3>
<ul>
<li><strong>Données :</strong> données de navigation anonymisées (pages visitées, durée de visite)</li>
<li><strong>Finalité :</strong> mesure d\'audience et amélioration du site</li>
<li><strong>Base légale :</strong> intérêt légitime (article 6.1.f du RGPD)</li>
</ul>

<h2>3. Durées de conservation</h2>
<ul>
<li><strong>Données de contact :</strong> 2 ans à compter du dernier échange</li>
<li><strong>Données d\'audit (leads) :</strong> 3 ans à compter de la collecte</li>
<li><strong>Données de newsletter :</strong> 3 ans à compter de la dernière interaction (ouverture, clic)</li>
<li><strong>Cookies :</strong> 13 mois maximum (voir notre <a href="/cookies">Politique de cookies</a>)</li>
</ul>
<p>À l\'expiration de ces délais, vos données sont supprimées ou anonymisées de manière irréversible.</p>

<h2>4. Destinataires des données</h2>
<p>Vos données personnelles sont traitées uniquement par NeoGTB et ne sont jamais vendues ni cédées à des tiers à des fins commerciales.</p>
<p>Elles peuvent être transmises aux sous-traitants suivants, dans le strict cadre des finalités décrites :</p>
<ul>
<li><strong>Hébergeur :</strong> [NOM DE L\'HÉBERGEUR] — hébergement du site et des données</li>
<li><strong>Service email :</strong> [NOM DU SERVICE EMAIL] — envoi des emails transactionnels et de la newsletter</li>
<li><strong>Plausible Analytics :</strong> mesure d\'audience respectueuse de la vie privée, sans cookies, conforme RGPD</li>
</ul>

<h2>5. Transferts hors UE</h2>
<p>Nous privilégions des prestataires hébergeant les données au sein de l\'Union Européenne. En cas de transfert hors UE, celui-ci est encadré par des clauses contractuelles types approuvées par la Commission européenne ou par une décision d\'adéquation.</p>

<h2>6. Droits des personnes</h2>
<p>Conformément au RGPD et à la loi Informatique et Libertés, vous disposez des droits suivants :</p>
<ul>
<li><strong>Droit d\'accès :</strong> obtenir la confirmation que des données vous concernant sont traitées et en obtenir une copie</li>
<li><strong>Droit de rectification :</strong> corriger des données inexactes ou incomplètes</li>
<li><strong>Droit à l\'effacement :</strong> demander la suppression de vos données (« droit à l\'oubli »)</li>
<li><strong>Droit à la limitation :</strong> demander la suspension du traitement de vos données</li>
<li><strong>Droit à la portabilité :</strong> recevoir vos données dans un format structuré et lisible par machine</li>
<li><strong>Droit d\'opposition :</strong> vous opposer au traitement de vos données pour motif légitime</li>
<li><strong>Droit de retirer votre consentement :</strong> à tout moment, sans affecter la licéité du traitement antérieur</li>
</ul>
<p>Pour exercer vos droits, consultez notre page dédiée <a href="/mes-droits-rgpd">Mes droits RGPD</a> ou contactez-nous à <strong>contact@neogtb.fr</strong>. Nous nous engageons à répondre dans un délai d\'un mois.</p>
<p>Vous pouvez également introduire une réclamation auprès de la <a href="https://www.cnil.fr" target="_blank" rel="noopener">CNIL</a> (Commission Nationale de l\'Informatique et des Libertés).</p>

<h2>7. Cookies</h2>
<p>Pour en savoir plus sur les cookies utilisés par le Site, veuillez consulter notre <a href="/cookies">Politique de cookies</a>.</p>

<h2>8. Sécurité</h2>
<p>NeoGTB met en œuvre des mesures techniques et organisationnelles appropriées pour protéger vos données personnelles contre tout accès non autorisé, perte, altération ou divulgation : chiffrement HTTPS, accès restreints, sauvegardes régulières.</p>

<h2>9. Modification de la politique</h2>
<p>Nous nous réservons le droit de modifier la présente politique de confidentialité à tout moment. La date de dernière mise à jour est indiquée ci-dessous. Nous vous invitons à la consulter régulièrement.</p>
<p>Dernière mise à jour : avril 2026.</p>',
                'cgu' => '<h2>1. Objet</h2>
<p>Les présentes Conditions Générales d\'Utilisation (ci-après « CGU ») définissent les modalités d\'accès et d\'utilisation du site <strong>neogtb.fr</strong> (ci-après « le Site »), édité par NeoGTB. En accédant au Site, vous acceptez sans réserve les présentes CGU.</p>

<h2>2. Accès au site</h2>
<p>Le Site est accessible gratuitement à tout utilisateur disposant d\'un accès à Internet. NeoGTB met tout en œuvre pour assurer la disponibilité du Site, mais ne saurait garantir un accès ininterrompu. Le Site peut être temporairement indisponible pour des raisons de maintenance, de mise à jour ou de force majeure.</p>

<h2>3. Services proposés</h2>
<p>Le Site propose les services suivants :</p>
<ul>
<li><strong>Contenus éducatifs :</strong> articles, guides et ressources sur la Gestion Technique du Bâtiment (GTB) et la Gestion Technique Centralisée (GTC)</li>
<li><strong>Outil d\'audit GTB :</strong> formulaire interactif permettant d\'obtenir un diagnostic indicatif du niveau GTB d\'un bâtiment</li>
<li><strong>Blog :</strong> articles techniques, actualités réglementaires (décret tertiaire, RE2020, norme EN 15232), retours d\'expérience</li>
<li><strong>Newsletter :</strong> veille GTB mensuelle par email</li>
<li><strong>Formulaire de contact :</strong> prise de contact avec l\'équipe NeoGTB</li>
</ul>

<h2>4. Utilisation du site</h2>
<p>L\'utilisateur s\'engage à :</p>
<ul>
<li>Utiliser le Site conformément à sa destination et aux présentes CGU</li>
<li>Ne pas tenter de porter atteinte au bon fonctionnement du Site</li>
<li>Ne pas utiliser de dispositifs automatisés (robots, scripts) pour accéder massivement au contenu</li>
<li>Fournir des informations exactes lors de l\'utilisation des formulaires</li>
<li>Ne pas reproduire le contenu du Site sans autorisation préalable</li>
</ul>

<h2>5. Outil d\'audit GTB</h2>
<p>L\'outil d\'audit GTB en ligne fournit un <strong>diagnostic indicatif</strong> basé sur les informations déclarées par l\'utilisateur. Les résultats ne constituent en aucun cas un audit professionnel certifié et ne se substituent pas à l\'intervention d\'un bureau d\'études spécialisé en GTB/GTC.</p>
<p>NeoGTB ne saurait être tenu responsable des décisions prises sur la base des résultats de cet outil.</p>

<h2>6. Propriété intellectuelle</h2>
<p>L\'ensemble du contenu du Site est protégé par le droit de la propriété intellectuelle. Toute reproduction, même partielle, est soumise à autorisation préalable. Pour toute demande, contactez-nous à <strong>contact@neogtb.fr</strong>.</p>

<h2>7. Données personnelles</h2>
<p>Le traitement des données personnelles est régi par notre <a href="/politique-de-confidentialite">Politique de confidentialité</a>, conforme au Règlement Général sur la Protection des Données (RGPD).</p>

<h2>8. Newsletter</h2>
<p>L\'inscription à la newsletter est libre et volontaire. Vous pouvez vous désinscrire à tout moment via le lien de désinscription présent dans chaque email ou en nous contactant à contact@neogtb.fr.</p>

<h2>9. Limitation de responsabilité</h2>
<p>NeoGTB s\'efforce de fournir des informations fiables et à jour sur la GTB/GTC, la réglementation et les technologies associées. Toutefois, ces informations sont fournies à titre indicatif et NeoGTB ne garantit pas leur exhaustivité ni leur exactitude.</p>
<p>NeoGTB ne pourra être tenu responsable des dommages directs ou indirects résultant de l\'utilisation du Site ou de l\'impossibilité d\'y accéder.</p>

<h2>10. Liens externes</h2>
<p>Le Site peut contenir des liens vers des sites tiers (CNIL, ADEME, organismes de normalisation, etc.). NeoGTB n\'est pas responsable du contenu de ces sites et leur inclusion ne vaut pas approbation.</p>

<h2>11. Modification des CGU</h2>
<p>NeoGTB se réserve le droit de modifier les présentes CGU à tout moment. Les modifications prennent effet dès leur publication sur le Site. L\'utilisation continue du Site après modification vaut acceptation des nouvelles CGU.</p>

<h2>12. Droit applicable</h2>
<p>Les présentes CGU sont régies par le droit français. Tout litige sera soumis aux tribunaux compétents, après tentative de résolution amiable.</p>

<p>Dernière mise à jour : avril 2026.</p>',
                'cookies' => '<h2>1. Qu\'est-ce qu\'un cookie ?</h2>
<p>Un cookie est un petit fichier texte déposé sur votre terminal (ordinateur, tablette, smartphone) lors de la visite d\'un site web. Il permet au site de mémoriser des informations relatives à votre navigation (préférences, session, etc.).</p>

<h2>2. Cookies utilisés sur NeoGTB</h2>
<p>Le site neogtb.fr utilise un nombre très limité de cookies, dans le respect de votre vie privée.</p>

<h3>a) Cookies strictement nécessaires</h3>
<p>Ces cookies sont indispensables au fonctionnement du site. Ils ne peuvent pas être désactivés.</p>
<ul>
<li><strong>Session Laravel</strong> (<code>neogtb_session</code>) : gestion de votre session de navigation. Durée : session (supprimé à la fermeture du navigateur).</li>
<li><strong>Jeton CSRF</strong> (<code>XSRF-TOKEN</code>) : protection contre les attaques de type Cross-Site Request Forgery. Durée : session.</li>
<li><strong>Préférence cookies</strong> (<code>cookie_consent</code>) : mémorisation de votre choix concernant les cookies. Durée : 13 mois.</li>
</ul>

<h3>b) Mesure d\'audience — Plausible Analytics</h3>
<p>NeoGTB utilise <strong>Plausible Analytics</strong>, une solution de mesure d\'audience respectueuse de la vie privée. Plausible :</p>
<ul>
<li><strong>Ne dépose aucun cookie</strong> sur votre terminal</li>
<li>Ne collecte aucune donnée personnelle identifiante</li>
<li>Ne réalise aucun suivi inter-sites (cross-site tracking)</li>
<li>Est hébergé dans l\'Union Européenne</li>
<li>Est conforme au RGPD sans nécessiter de consentement</li>
</ul>
<p>Pour en savoir plus : <a href="https://plausible.io/data-policy" target="_blank" rel="noopener">Politique de données Plausible</a>.</p>

<h3>c) Cookies tiers</h3>
<p>NeoGTB <strong>n\'utilise aucun cookie de tracking publicitaire</strong> ni de cookie de réseau social. Aucun cookie Google Analytics, Facebook Pixel ou équivalent n\'est déposé sur votre terminal.</p>

<h2>3. Gestion de vos préférences</h2>
<p>Lors de votre première visite, un bandeau vous permet d\'accepter ou de refuser les cookies non essentiels. Vous pouvez modifier vos préférences à tout moment en cliquant sur le lien « Gérer les cookies » disponible en pied de page du site.</p>
<p>Vous pouvez également configurer votre navigateur pour bloquer tout ou partie des cookies :</p>
<ul>
<li><a href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener">Google Chrome</a></li>
<li><a href="https://support.mozilla.org/fr/kb/activer-desactiver-cookies" target="_blank" rel="noopener">Mozilla Firefox</a></li>
<li><a href="https://support.apple.com/fr-fr/guide/safari/sfri11471/mac" target="_blank" rel="noopener">Safari</a></li>
<li><a href="https://support.microsoft.com/fr-fr/microsoft-edge/supprimer-les-cookies-dans-microsoft-edge-63947406-40ac-c3b8-57b9-2a946a29ae09" target="_blank" rel="noopener">Microsoft Edge</a></li>
</ul>
<p><strong>Attention :</strong> la désactivation des cookies strictement nécessaires peut altérer le fonctionnement du site.</p>

<h2>4. Durée de conservation</h2>
<p>Conformément aux recommandations de la CNIL, les cookies ont une durée de vie maximale de 13 mois. Votre consentement est redemandé à l\'expiration de cette période.</p>

<h2>5. En savoir plus</h2>
<p>Pour toute question relative aux cookies, vous pouvez nous contacter à <strong>contact@neogtb.fr</strong> ou consulter le site de la <a href="https://www.cnil.fr/fr/cookies-et-autres-traceurs" target="_blank" rel="noopener">CNIL</a>.</p>
<p>Dernière mise à jour : avril 2026.</p>',
            ],

            // CATALOGUES
            'blog_categories_config' => [
                ['slug' => 'guide', 'label' => 'Guides', 'color' => '#3B82F6', 'icon' => 'book-open', 'description' => 'Guides pratiques GTB/GTC'],
                ['slug' => 'reglementation', 'label' => 'Réglementation', 'color' => '#8B5CF6', 'icon' => 'scale', 'description' => 'Décrets, normes, obligations'],
                ['slug' => 'technologie', 'label' => 'Technologies', 'color' => '#10B981', 'icon' => 'cpu-chip', 'description' => 'Protocoles, capteurs, automates'],
                ['slug' => 'retour-experience', 'label' => 'Retours d\'expérience', 'color' => '#F59E0B', 'icon' => 'light-bulb', 'description' => 'Cas concrets et ROI'],
                ['slug' => 'actualite', 'label' => 'Actualités', 'color' => '#EF4444', 'icon' => 'newspaper', 'description' => 'Nouveautés du secteur'],
            ],

            'gtb_protocols_config' => [
                [
                    'slug' => 'bacnet',
                    'label' => 'BACnet',
                    'standard' => 'ISO 16484-5',
                    'category' => 'IP',
                    'icon' => '🌐',
                    'description' => 'Standard international de la GTB, maintenu par l\'ASHRAE. Deux déclinaisons principales : <strong class="font-medium text-dark-700">BACnet IP</strong> pour les réseaux Ethernet et <strong class="font-medium text-dark-700">BACnet MS/TP</strong> pour les bus RS-485 en terrain. Le protocole définit un modèle objet unifié qui permet l\'interopérabilité entre équipements de marques différentes sans passerelle propriétaire.',
                    'tags' => ['Interopérabilité multi-marques', 'IP / MS/TP', 'ASHRAE 135'],
                ],
                [
                    'slug' => 'knx',
                    'label' => 'KNX',
                    'standard' => 'EN 50090 / ISO/IEC 14543',
                    'category' => 'terrain',
                    'icon' => '🔌',
                    'description' => 'Standard européen pour l\'automatisation du bâtiment. Le médium principal est le <strong class="font-medium text-dark-700">bus filaire TP</strong> (twisted pair). Plus de 500 fabricants certifiés par l\'Association KNX. Particulièrement adapté à l\'éclairage, la gestion des stores et le CVC en résidentiel et petit tertiaire.',
                    'tags' => ['500+ fabricants', 'Bus TP', 'Éclairage / Stores / CVC'],
                ],
                [
                    'slug' => 'modbus',
                    'label' => 'Modbus',
                    'standard' => 'RTU / TCP',
                    'category' => 'terrain',
                    'icon' => '⚙️',
                    'description' => 'Protocole industriel créé par Modicon en 1979, devenu un standard de fait. Simple et robuste, existe en <strong class="font-medium text-dark-700">Modbus RTU</strong> sur RS-485 et <strong class="font-medium text-dark-700">Modbus TCP</strong> sur Ethernet. Architecture maître-esclave. Dominant pour le comptage énergie.',
                    'tags' => ['Industriel / 1979', 'RS-485 / Ethernet', 'Comptage énergie'],
                ],
                [
                    'slug' => 'lon',
                    'label' => 'LON',
                    'standard' => 'EN 14908',
                    'category' => 'terrain',
                    'icon' => '🔗',
                    'description' => 'Local Operating Network, conçu par Echelon. Architecture <strong class="font-medium text-dark-700">peer-to-peer</strong> : chaque noeud embarque sa propre intelligence. Historiquement très utilisé en GTB tertiaire. En déclin face à BACnet IP, mais encore présent dans le parc existant.',
                    'tags' => ['Peer-to-peer', 'Parc existant', 'Migration BACnet'],
                ],
                [
                    'slug' => 'dali',
                    'label' => 'DALI / DALI-2',
                    'standard' => 'IEC 62386',
                    'category' => 'terrain',
                    'icon' => '💡',
                    'description' => 'Standard international dédié au <strong class="font-medium text-dark-700">pilotage de l\'éclairage</strong>. DALI-2 apporte l\'interopérabilité certifiée entre ballasts, capteurs de présence et luxmètres. Jusqu\'à 64 appareils par ligne, adressage individuel, gradation fine.',
                    'tags' => ['Éclairage dédié', '64 appareils/ligne', 'Gradation fine'],
                ],
                [
                    'slug' => 'mqtt',
                    'label' => 'MQTT & API REST',
                    'standard' => 'IoT / Cloud',
                    'category' => 'IP',
                    'icon' => '☁️',
                    'description' => 'Protocoles issus du monde IT, de plus en plus présents en GTB pour <strong class="font-medium text-dark-700">l\'interopérabilité cloud</strong>, les jumeaux numériques et l\'hypervision multi-sites. MQTT est léger et adapté aux capteurs IoT. Les API REST permettent l\'intégration avec les plateformes de GMAO, ERP et analytics.',
                    'tags' => ['Publish/Subscribe', 'Cloud natif', 'Jumeaux numériques'],
                ],
                [
                    'slug' => 'enocean',
                    'label' => 'EnOcean',
                    'standard' => 'ISO/IEC 14543-3-10',
                    'category' => 'sans-fil',
                    'icon' => '📡',
                    'description' => 'Technologie <strong class="font-medium text-dark-700">sans fil et sans pile</strong> basée sur la récupération d\'énergie (piézoélectrique, solaire, thermique). Idéale pour la <strong class="font-medium text-dark-700">rénovation</strong> où le câblage est impossible ou coûteux.',
                    'tags' => ['Sans fil / Sans pile', 'Rénovation', 'Energy harvesting'],
                ],
            ],

            'en15232_levels_config' => [
                ['key' => 'A', 'label' => 'Classe A — Haute performance énergétique', 'description' => 'GTB avec régulation individuelle, optimisation automatique, détection de défauts', 'savings' => '30-40%'],
                ['key' => 'B', 'label' => 'Classe B — Avancé', 'description' => 'GTB avec régulation automatique par zone, programmation horaire', 'savings' => '20-30%'],
                ['key' => 'C', 'label' => 'Classe C — Standard', 'description' => 'Régulation basique, pas d\'automatisation avancée', 'savings' => '10-15%'],
                ['key' => 'D', 'label' => 'Classe D — Non énergie-efficace', 'description' => 'Pas de GTB, régulation manuelle uniquement', 'savings' => '0%'],
            ],

            'font_pairs_config' => [
                ['key' => 'inter_dm_sans', 'label' => 'Inter + DM Sans', 'heading' => 'Inter', 'body' => 'DM Sans', 'google_families' => 'Inter:wght@400;500;600;700&family=DM+Sans:wght@400;500;700'],
                ['key' => 'inter_merriweather', 'label' => 'Inter + Merriweather', 'heading' => 'Inter', 'body' => 'Merriweather', 'google_families' => 'Inter:wght@400;500;600;700&family=Merriweather:wght@400;700'],
                ['key' => 'poppins_lora', 'label' => 'Poppins + Lora', 'heading' => 'Poppins', 'body' => 'Lora', 'google_families' => 'Poppins:wght@400;500;600;700&family=Lora:wght@400;700'],
                ['key' => 'montserrat_roboto', 'label' => 'Montserrat + Roboto', 'heading' => 'Montserrat', 'body' => 'Roboto', 'google_families' => 'Montserrat:wght@500;600;700&family=Roboto:wght@400;500'],
                ['key' => 'dm_sans_dm_serif', 'label' => 'DM Sans + DM Serif', 'heading' => 'DM Serif Display', 'body' => 'DM Sans', 'google_families' => 'DM+Sans:wght@400;500;700&family=DM+Serif+Display:wght@400'],
            ],

            // HOMEPAGE SECTIONS
            'homepage_sections' => [
                'hero', 'expertises', 'chiffres', 'comparatif', 'solutions',
                'temoignages', 'faq', 'cta_audit', 'blog_recent',
            ],

            // HOMEPAGE SECTIONS CONFIG — contenu par défaut de chaque section
            'homepage_sections_config' => [

                // ─── HERO ───
                'hero' => [
                    'badge' => '🏢 Gestion Technique du Bâtiment',
                    'titre' => 'Optimisez la performance énergétique de vos bâtiments avec la GTB',
                    'sous_titre' => 'Découvrez comment la Gestion Technique du Bâtiment réduit vos consommations de 20 à 40 % tout en améliorant le confort des occupants.',
                    'description' => 'Guides complets, audit gratuit en ligne et comparateurs : NeoGTB vous accompagne dans votre mise en conformité RE2020 et décret tertiaire.',
                    'cta_texte' => 'Lancer mon audit gratuit',
                    'cta_lien' => '/audit',
                    'cta2_texte' => 'Comprendre la GTB',
                    'cta2_lien' => '/gtb',
                    'image' => '',
                    'image_alt' => 'Bâtiment intelligent équipé GTB',
                ],

                // ─── EXPERTISES (cas d'usage) ───
                'expertises' => [
                    'eyebrow' => 'Cas concrets',
                    'titre' => 'La GTB en action dans vos bâtiments',
                    'cas' => [
                        [
                            'tag' => 'Tertiaire',
                            'tag_variant' => 'gtb',
                            'meta' => 'Bureau — 5 000 m²',
                            'titre' => 'Rénovation GTB d\'un immeuble de bureaux',
                            'contexte' => 'Un immeuble tertiaire des années 2000 soumis au décret tertiaire, avec une consommation excessive en chauffage et climatisation.',
                            'approche' => 'Déploiement BACnet avec régulation terminale par zone, programmation horaire et détection d\'occupation.',
                            'gauge' => [
                                'label' => 'Niveau EN 15232 atteint',
                                'active' => 'B',
                                'progress_from' => 'D',
                            ],
                            'metriques' => [
                                ['valeur' => '-35 %', 'label' => 'Consommation énergétique', 'couleur' => 'energy'],
                                ['valeur' => '3 ans', 'label' => 'Retour sur investissement', 'couleur' => 'dark'],
                            ],
                        ],
                        [
                            'tag' => 'Enseignement',
                            'tag_variant' => 'gtb',
                            'meta' => 'Lycée — 12 000 m²',
                            'titre' => 'Pilotage centralisé d\'un établissement scolaire',
                            'contexte' => 'Un lycée avec des usages intermittents (vacances, week-ends) et une facture énergétique en hausse constante.',
                            'approche' => 'Supervision GTC centralisée, gestion des intermittences, délestage automatique et suivi temps réel des consommations.',
                            'gauge' => [
                                'label' => 'Niveau EN 15232 atteint',
                                'active' => 'A',
                                'progress_from' => 'C',
                            ],
                            'metriques' => [
                                ['valeur' => '-42 %', 'label' => 'Économie sur la facture', 'couleur' => 'energy'],
                                ['valeur' => '18 mois', 'label' => 'Temps de déploiement', 'couleur' => 'dark'],
                            ],
                        ],
                    ],
                    'cta_texte' => 'Voir tous les cas d\'usage →',
                    'cta_lien' => '/solutions',
                ],

                // ─── CHIFFRES CLÉS ───
                'chiffres' => [
                    'stats' => [
                        ['valeur' => '150+', 'label' => 'Bâtiments audités'],
                        ['valeur' => '35 %', 'label' => 'Économies moyennes constatées'],
                        ['valeur' => '12 ans', 'label' => 'D\'expertise GTB/GTC'],
                        ['valeur' => '80+', 'label' => 'Clients accompagnés'],
                    ],
                ],

                // ─── COMPARATIF GTB vs GTC ───
                'comparatif' => [
                    'titre' => 'Sans GTB vs avec NeoGTB',
                    'sous_titre' => 'Découvrez l\'impact concret d\'une installation GTB sur la gestion de votre bâtiment.',
                    'colonne_gauche_titre' => 'Sans GTB',
                    'lignes_gauche' => [
                        ['texte' => 'Régulation manuelle des équipements CVC'],
                        ['texte' => 'Aucune visibilité sur les consommations réelles'],
                        ['texte' => 'Surconsommation hors heures d\'occupation'],
                        ['texte' => 'Maintenance curative coûteuse et réactive'],
                        ['texte' => 'Non-conformité au décret tertiaire'],
                    ],
                    'colonne_droite_titre' => 'Avec GTB',
                    'lignes_droite' => [
                        ['texte' => 'Régulation automatique par zone et par usage'],
                        ['texte' => 'Tableaux de bord temps réel des consommations'],
                        ['texte' => 'Programmation horaire et détection d\'occupation'],
                        ['texte' => 'Maintenance prédictive et alertes automatiques'],
                        ['texte' => 'Conformité EN 15232 classe B ou A'],
                    ],
                ],

                // ─── SOLUTIONS / PROTOCOLES ───
                'solutions' => [
                    'titre_section' => 'Les technologies GTB à votre service',
                    'cartes' => [
                        [
                            'icone' => '🔗',
                            'titre' => 'BACnet',
                            'description' => 'Protocole standard ISO pour l\'interopérabilité des systèmes de gestion technique du bâtiment.',
                            'lien' => '/solutions#bacnet',
                        ],
                        [
                            'icone' => '🏠',
                            'titre' => 'KNX',
                            'description' => 'Standard mondial pour l\'automatisation résidentielle et tertiaire — éclairage, stores, CVC.',
                            'lien' => '/solutions#knx',
                        ],
                        [
                            'icone' => '⚡',
                            'titre' => 'Modbus',
                            'description' => 'Protocole série éprouvé pour la communication avec les automates programmables et compteurs.',
                            'lien' => '/solutions#modbus',
                        ],
                        [
                            'icone' => '💡',
                            'titre' => 'DALI',
                            'description' => 'Interface numérique pour le pilotage adressable de l\'éclairage — gradation et scénarios.',
                            'lien' => '/solutions#dali',
                        ],
                        [
                            'icone' => '📡',
                            'titre' => 'MQTT / IoT',
                            'description' => 'Protocole léger pour connecter capteurs et actionneurs IoT à votre supervision GTB.',
                            'lien' => '/solutions#mqtt',
                        ],
                        [
                            'icone' => '🌐',
                            'titre' => 'LON',
                            'description' => 'Réseau de contrôle distribué pour les installations multi-sites et les réseaux de terrain.',
                            'lien' => '/solutions#lon',
                        ],
                    ],
                ],

                // ─── TÉMOIGNAGES ───
                'temoignages' => [
                    'titre' => 'Ils ont optimisé leurs bâtiments',
                    'avis' => [
                        [
                            'nom' => 'Marie Durand',
                            'poste' => 'Directrice Technique — Groupe Immobilier Nexity',
                            'texte' => 'Grâce à l\'audit NeoGTB, nous avons identifié 30 % d\'économies potentielles sur notre parc tertiaire. La mise en conformité décret tertiaire est désormais planifiée.',
                            'note' => 5,
                        ],
                        [
                            'nom' => 'Philippe Martin',
                            'poste' => 'Responsable Énergie — Conseil Départemental',
                            'texte' => 'Les guides NeoGTB sur les niveaux EN 15232 nous ont permis de rédiger un cahier des charges précis pour la GTB de nos 45 collèges.',
                            'note' => 5,
                        ],
                        [
                            'nom' => 'Sophie Leclerc',
                            'poste' => 'Energy Manager — Centre Hospitalier',
                            'texte' => 'Le comparateur GTB/GTC de NeoGTB a convaincu notre direction d\'investir dans une supervision centralisée. Résultat : -28 % sur la facture en 18 mois.',
                            'note' => 5,
                        ],
                    ],
                ],

                // ─── FAQ ───
                'faq' => [
                    'titre' => 'Questions fréquentes sur la GTB',
                    'questions' => [
                        [
                            'question' => 'Qu\'est-ce que la GTB (Gestion Technique du Bâtiment) ?',
                            'reponse' => 'La GTB est un système centralisé qui pilote et optimise automatiquement les équipements techniques d\'un bâtiment : chauffage, ventilation, climatisation, éclairage, contrôle d\'accès. Elle permet de réduire les consommations énergétiques de 20 à 40 %.',
                        ],
                        [
                            'question' => 'Quelle est la différence entre GTB et GTC ?',
                            'reponse' => 'La GTC (Gestion Technique Centralisée) supervise et surveille les équipements à distance. La GTB va plus loin en ajoutant la régulation automatique, l\'optimisation énergétique et la maintenance prédictive. La GTB inclut la GTC.',
                        ],
                        [
                            'question' => 'Le décret tertiaire impose-t-il une GTB ?',
                            'reponse' => 'Le décret tertiaire (décret n°2019-771) impose des réductions de consommation de -40 % d\'ici 2030 pour les bâtiments de plus de 1 000 m². La GTB est le levier le plus efficace pour atteindre ces objectifs sans travaux lourds.',
                        ],
                        [
                            'question' => 'Combien coûte une installation GTB ?',
                            'reponse' => 'Le coût varie selon la taille du bâtiment et le niveau visé (classe A, B ou C selon EN 15232). Comptez entre 15 et 40 €/m² pour une installation neuve. Le retour sur investissement se situe généralement entre 2 et 5 ans grâce aux économies d\'énergie.',
                        ],
                        [
                            'question' => 'Qu\'est-ce que la norme EN 15232 ?',
                            'reponse' => 'La norme EN 15232 classe les systèmes GTB en 4 niveaux (A à D) selon leur impact sur la performance énergétique. La classe A (haute performance) offre jusqu\'à 40 % d\'économies, tandis que la classe D (pas de GTB) correspond à une gestion manuelle.',
                        ],
                        [
                            'question' => 'L\'audit GTB de NeoGTB est-il vraiment gratuit ?',
                            'reponse' => 'Oui, notre pré-diagnostic en ligne est 100 % gratuit et sans engagement. En 5 minutes, vous obtenez une estimation de votre niveau GTB actuel, du potentiel d\'économies et des actions prioritaires à mener.',
                        ],
                    ],
                ],

                // ─── CTA AUDIT ───
                'cta_audit' => [
                    'titre' => 'Prêt à optimiser votre bâtiment ?',
                    'sous_titre' => 'Obtenez un diagnostic GTB personnalisé en moins de 5 minutes. Gratuit, sans engagement.',
                    'bouton_texte' => 'Lancer l\'audit gratuit',
                    'bouton_lien' => '/audit',
                    'bouton2_texte' => 'Nous contacter',
                    'bouton2_lien' => '/contact',
                ],

                // ─── BLOG RÉCENT ───
                'blog_recent' => [
                    'eyebrow' => 'Ressources',
                    'titre_section' => 'Derniers articles GTB/GTC',
                    'cta_haut_texte' => 'Voir tous les articles →',
                    'cta_haut_lien' => '/blog',
                    'cartes' => [
                        [
                            'tag' => 'Guide',
                            'tag_variant' => 'gtb',
                            'titre' => 'Qu\'est-ce que la GTB ? Le guide complet 2026',
                            'duree' => '12 min de lecture',
                            'lien' => '/blog/guide-complet-gtb-2026',
                        ],
                        [
                            'tag' => 'Réglementation',
                            'tag_variant' => 'gtb',
                            'titre' => 'Décret tertiaire : comment la GTB vous met en conformité',
                            'duree' => '8 min de lecture',
                            'lien' => '/blog/decret-tertiaire-gtb-conformite',
                        ],
                        [
                            'tag' => 'Technologie',
                            'tag_variant' => 'gtb',
                            'titre' => 'BACnet vs KNX vs Modbus : quel protocole choisir ?',
                            'duree' => '10 min de lecture',
                            'lien' => '/blog/bacnet-knx-modbus-comparatif',
                        ],
                    ],
                ],
            ],
        ]);

        $this->command?->info('GeneralSettings NeoGTB peuplé.');
    }
}
