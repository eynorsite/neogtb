<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;

class GeneralSettingsSeeder extends Seeder
{
    public function run(): void
    {
        GeneralSetting::updateOrCreate(['id' => 1], [
            // IDENTIT\u00c9
            'company_name' => 'NeoGTB',
            'company_tagline' => 'Ma\u00eetrisez la Gestion Technique de vos B\u00e2timents',
            'company_email' => 'contact@neogtb.fr',
            'company_website' => 'https://neogtb.fr',
            'company_country' => 'France',
            'company_founding_year' => 2026,
            'company_description' => 'NeoGTB - Tout savoir sur la Gestion Technique du B\u00e2timent (GTB) et la Gestion Technique Centralis\u00e9e (GTC). Guides, audits gratuits et comparateurs.',
            'company_opening_hours' => ['lun_ven' => '09:00 - 18:00', 'sam' => 'Ferm\u00e9', 'dim' => 'Ferm\u00e9'],

            // TH\u00c8ME
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

            // SEO
            'seo_title_suffix' => ' \u2014 NeoGTB',
            'seo_default_description' => 'NeoGTB - Tout savoir sur la Gestion Technique du B\u00e2timent (GTB) et la Gestion Technique Centralis\u00e9e (GTC). Guides, audits gratuits et comparateurs.',
            'seo_robots' => 'index, follow',
            'seo_schema_type' => 'Organization',
            'seo_canonical_url' => 'https://neogtb.fr',

            // TRACKING
            'cookie_banner_enabled' => true,
            'cookie_banner_text' => 'Ce site utilise des cookies pour am\u00e9liorer votre exp\u00e9rience. En continuant, vous acceptez notre politique de cookies.',

            // ANNONCE
            'announcement_enabled' => false,
            'announcement_bg_color' => '#2563eb',
            'announcement_text_color' => '#ffffff',

            // MAINTENANCE
            'maintenance_enabled' => false,
            'maintenance_message' => 'Le site est actuellement en maintenance. Nous serons bient\u00f4t de retour.',

            // EMAIL
            'email_from_name' => 'NeoGTB',
            'email_from_address' => 'contact@neogtb.fr',

            // RGPD
            'rgpd_retention_contacts_days' => 730,
            'rgpd_retention_leads_days' => 1095,
            'rgpd_retention_cookies_days' => 395,
            'rgpd_retention_newsletter_days' => 1095,

            // S\u00c9CURIT\u00c9
            'smtp_port' => 587,
            'smtp_encryption' => 'tls',

            // BLOG
            'blog_default_cover' => '/images/blog-default-cover.png',

            // STATISTIQUES
            'stat_buildings_audited' => 150,
            'stat_avg_savings_percent' => 35,
            'stat_years_experience' => 12,
            'stat_clients_count' => 80,

            // UI LABELS
            'ui_labels' => [
                'forms' => [
                    'name' => 'Nom',
                    'first_name' => 'Pr\u00e9nom',
                    'email' => 'Email',
                    'phone' => 'T\u00e9l\u00e9phone',
                    'company' => 'Entreprise',
                    'message' => 'Message',
                    'subject' => 'Sujet',
                    'submit' => 'Envoyer',
                    'cancel' => 'Annuler',
                    'required_fields' => 'Les champs marqu\u00e9s d\'un * sont obligatoires',
                    'success_message' => 'Votre message a bien \u00e9t\u00e9 envoy\u00e9',
                    'error_message' => 'Une erreur est survenue, veuillez r\u00e9essayer',
                    'building_type' => 'Type de b\u00e2timent',
                    'surface' => 'Surface (m\u00b2)',
                    'building_year' => 'Ann\u00e9e de construction',
                    'energy_bill' => 'Facture \u00e9nerg\u00e9tique annuelle (\u20ac)',
                    'gtb_level' => 'Niveau GTB actuel',
                ],
                'header' => [
                    'home' => 'Accueil',
                    'gtb' => 'GTB',
                    'gtc' => 'GTC',
                    'solutions' => 'Solutions',
                    'reglementation' => 'R\u00e9glementation',
                    'blog' => 'Blog',
                    'contact' => 'Contact',
                    'audit_cta' => 'Audit gratuit',
                    'breadcrumb_label' => 'Fil d\'Ariane',
                ],
                'footer' => [
                    'col1_title' => 'Comprendre',
                    'col2_title' => 'Outils',
                    'col3_title' => 'L\u00e9gal',
                    'col4_title' => 'Newsletter',
                    'newsletter_placeholder' => 'Votre email',
                    'newsletter_button' => 'S\'abonner',
                    'newsletter_subtitle' => 'Veille GTB mensuelle',
                    'copyright_prefix' => '\u00a9',
                    'no_tracking' => 'Ce site n\'utilise aucun cookie de tracking.',
                ],
                'cta' => [
                    'audit_title' => 'Pr\u00eat \u00e0 optimiser votre b\u00e2timent ?',
                    'audit_subtitle' => 'Obtenez un diagnostic GTB personnalis\u00e9 en moins de 5 minutes.',
                    'audit_button' => 'Lancer l\'audit gratuit',
                    'contact_us' => 'Contactez-nous',
                    'learn_more' => 'En savoir plus',
                    'download' => 'T\u00e9l\u00e9charger',
                    'compare' => 'Comparer',
                    'back_to_blog' => 'Retour au blog',
                ],
                'search' => [
                    'placeholder' => 'Rechercher un article...',
                    'no_results' => 'Aucun r\u00e9sultat trouv\u00e9',
                    'loading' => 'Chargement...',
                ],
                'cookie' => [
                    'title' => 'Gestion des cookies',
                    'description' => 'Nous utilisons des cookies pour am\u00e9liorer votre exp\u00e9rience de navigation et analyser notre trafic.',
                    'accept' => 'Tout accepter',
                    'reject' => 'Tout refuser',
                    'customize' => 'Personnaliser',
                    'save_preferences' => 'Enregistrer mes pr\u00e9f\u00e9rences',
                    'necessary_title' => 'Cookies n\u00e9cessaires',
                    'necessary_desc' => 'Indispensables au fonctionnement du site.',
                    'analytics_title' => 'Cookies analytiques',
                    'analytics_desc' => 'Nous permettent de mesurer l\'audience du site.',
                ],
                'validation' => [
                    'required' => 'Ce champ est obligatoire',
                    'email_invalid' => 'L\'adresse email n\'est pas valide',
                    'phone_invalid' => 'Le num\u00e9ro de t\u00e9l\u00e9phone n\'est pas valide',
                    'min_length' => 'Ce champ doit contenir au moins :min caract\u00e8res',
                    'max_length' => 'Ce champ ne doit pas d\u00e9passer :max caract\u00e8res',
                ],
                'pagination' => [
                    'previous' => 'Pr\u00e9c\u00e9dent',
                    'next' => 'Suivant',
                    'showing' => 'Affichage de',
                    'to' => '\u00e0',
                    'of' => 'sur',
                    'results' => 'r\u00e9sultats',
                ],
                'misc' => [
                    'loading' => 'Chargement...',
                    'no_data' => 'Aucune donn\u00e9e disponible',
                    'back' => 'Retour',
                    'close' => 'Fermer',
                    'share' => 'Partager',
                    'print' => 'Imprimer',
                    'reading_time' => 'min de lecture',
                    'published_on' => 'Publi\u00e9 le',
                    'updated_on' => 'Mis \u00e0 jour le',
                ],
            ],

            // STATUS CONFIGS
            'status_configs' => [
                'post' => [
                    ['key' => 'draft', 'label' => 'Brouillon', 'color' => 'gray', 'icon' => 'heroicon-o-pencil'],
                    ['key' => 'published', 'label' => 'Publi\u00e9', 'color' => 'success', 'icon' => 'heroicon-o-check-circle'],
                    ['key' => 'archived', 'label' => 'Archiv\u00e9', 'color' => 'warning', 'icon' => 'heroicon-o-archive-box'],
                ],
                'audit_lead' => [
                    ['key' => 'new', 'label' => 'Nouveau', 'color' => 'info', 'icon' => 'heroicon-o-sparkles'],
                    ['key' => 'contacted', 'label' => 'Contact\u00e9', 'color' => 'primary', 'icon' => 'heroicon-o-phone'],
                    ['key' => 'qualified', 'label' => 'Qualifi\u00e9', 'color' => 'warning', 'icon' => 'heroicon-o-star'],
                    ['key' => 'converted', 'label' => 'Converti', 'color' => 'success', 'icon' => 'heroicon-o-check-badge'],
                    ['key' => 'lost', 'label' => 'Perdu', 'color' => 'danger', 'icon' => 'heroicon-o-x-circle'],
                ],
                'cee_lead' => [
                    ['key' => 'new', 'label' => 'Nouveau', 'color' => 'info', 'icon' => 'heroicon-o-sparkles'],
                    ['key' => 'processing', 'label' => 'En traitement', 'color' => 'warning', 'icon' => 'heroicon-o-clock'],
                    ['key' => 'sent', 'label' => 'Dossier envoy\u00e9', 'color' => 'primary', 'icon' => 'heroicon-o-paper-airplane'],
                    ['key' => 'signed', 'label' => 'Sign\u00e9', 'color' => 'success', 'icon' => 'heroicon-o-check-circle'],
                ],
                'contact_message' => [
                    ['key' => 'new', 'label' => 'Nouveau', 'color' => 'info', 'icon' => 'heroicon-o-envelope'],
                    ['key' => 'read', 'label' => 'Lu', 'color' => 'gray', 'icon' => 'heroicon-o-envelope-open'],
                    ['key' => 'replied', 'label' => 'R\u00e9pondu', 'color' => 'success', 'icon' => 'heroicon-o-check-circle'],
                    ['key' => 'archived', 'label' => 'Archiv\u00e9', 'color' => 'warning', 'icon' => 'heroicon-o-archive-box'],
                ],
                'gdpr_request' => [
                    ['key' => 'pending', 'label' => 'En attente', 'color' => 'warning', 'icon' => 'heroicon-o-clock'],
                    ['key' => 'processing', 'label' => 'En traitement', 'color' => 'info', 'icon' => 'heroicon-o-cog-6-tooth'],
                    ['key' => 'completed', 'label' => 'Trait\u00e9e', 'color' => 'success', 'icon' => 'heroicon-o-check-circle'],
                    ['key' => 'rejected', 'label' => 'Refus\u00e9e', 'color' => 'danger', 'icon' => 'heroicon-o-x-circle'],
                ],
            ],

            // TEXTES L\u00c9GAUX
            'legal_texts' => [
                'cookie_consent' => [
                    'title' => 'Gestion des cookies',
                    'description' => 'Nous utilisons des cookies pour am\u00e9liorer votre exp\u00e9rience.',
                    'accept' => 'Tout accepter',
                    'reject' => 'Tout refuser',
                    'customize' => 'Personnaliser',
                    'categories' => [
                        ['key' => 'necessary', 'label' => 'Cookies n\u00e9cessaires', 'description' => 'Indispensables au fonctionnement du site.', 'required' => true],
                        ['key' => 'analytics', 'label' => 'Cookies analytiques', 'description' => 'Mesure d\'audience anonymis\u00e9e.'],
                    ],
                ],
                'mentions_legales' => '',
                'politique_confidentialite' => '',
                'cgu' => '',
            ],

            // HOMEPAGE SECTIONS
            'homepage_sections' => [
                'hero', 'expertises', 'chiffres', 'comparatif', 'solutions',
                'temoignages', 'faq', 'cta_audit', 'blog_recent',
            ],
        ]);

        $this->command?->info('GeneralSettings NeoGTB peupl\u00e9.');
    }
}
