<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // ============================================
            // CONTACT
            // ============================================
            ['group' => 'contact', 'key' => 'contact_telephone', 'value' => '', 'type' => 'phone', 'label' => 'Téléphone principal', 'is_public' => true, 'order' => 1],
            ['group' => 'contact', 'key' => 'contact_telephone_2', 'value' => '', 'type' => 'phone', 'label' => 'Téléphone secondaire', 'is_public' => true, 'order' => 2],
            ['group' => 'contact', 'key' => 'contact_email', 'value' => 'contact@neogtb.fr', 'type' => 'email', 'label' => 'Email principal', 'is_public' => true, 'is_required' => true, 'order' => 3],
            ['group' => 'contact', 'key' => 'contact_email_devis', 'value' => '', 'type' => 'email', 'label' => 'Email devis', 'is_public' => true, 'order' => 4],
            ['group' => 'contact', 'key' => 'contact_whatsapp', 'value' => '', 'type' => 'phone', 'label' => 'WhatsApp', 'is_public' => true, 'order' => 5],
            ['group' => 'contact', 'key' => 'contact_adresse', 'value' => '', 'type' => 'textarea', 'label' => 'Adresse complète', 'is_public' => true, 'order' => 6],
            ['group' => 'contact', 'key' => 'contact_ville', 'value' => '', 'type' => 'text', 'label' => 'Ville', 'is_public' => true, 'order' => 7],
            ['group' => 'contact', 'key' => 'contact_code_postal', 'value' => '', 'type' => 'text', 'label' => 'Code postal', 'is_public' => true, 'order' => 8],
            ['group' => 'contact', 'key' => 'contact_pays', 'value' => 'France', 'type' => 'text', 'label' => 'Pays', 'is_public' => true, 'order' => 9],
            ['group' => 'contact', 'key' => 'contact_horaires', 'value' => '{"lun_ven":"09:00 - 18:00","sam":"Fermé","dim":"Fermé"}', 'type' => 'json', 'label' => 'Horaires d\'ouverture', 'is_public' => true, 'order' => 10],
            ['group' => 'contact', 'key' => 'contact_google_maps_url', 'value' => '', 'type' => 'url', 'label' => 'URL Google Maps', 'is_public' => true, 'order' => 11],
            ['group' => 'contact', 'key' => 'contact_google_maps_embed', 'value' => '', 'type' => 'textarea', 'label' => 'Code embed Google Maps', 'description' => 'Code iframe pour intégrer la carte', 'order' => 12],

            // ============================================
            // RÉSEAUX SOCIAUX
            // ============================================
            ['group' => 'reseaux_sociaux', 'key' => 'social_linkedin', 'value' => '', 'type' => 'url', 'label' => 'LinkedIn', 'is_public' => true, 'order' => 1],
            ['group' => 'reseaux_sociaux', 'key' => 'social_facebook', 'value' => '', 'type' => 'url', 'label' => 'Facebook', 'is_public' => true, 'order' => 2],
            ['group' => 'reseaux_sociaux', 'key' => 'social_instagram', 'value' => '', 'type' => 'url', 'label' => 'Instagram', 'is_public' => true, 'order' => 3],
            ['group' => 'reseaux_sociaux', 'key' => 'social_youtube', 'value' => '', 'type' => 'url', 'label' => 'YouTube', 'is_public' => true, 'order' => 4],
            ['group' => 'reseaux_sociaux', 'key' => 'social_twitter_x', 'value' => '', 'type' => 'url', 'label' => 'Twitter / X', 'is_public' => true, 'order' => 5],
            ['group' => 'reseaux_sociaux', 'key' => 'social_tiktok', 'value' => '', 'type' => 'url', 'label' => 'TikTok', 'is_public' => true, 'order' => 6],
            ['group' => 'reseaux_sociaux', 'key' => 'social_google_reviews', 'value' => '', 'type' => 'url', 'label' => 'Google Reviews URL', 'is_public' => true, 'order' => 7],
            ['group' => 'reseaux_sociaux', 'key' => 'social_google_reviews_count', 'value' => '0', 'type' => 'number', 'label' => 'Nombre d\'avis Google', 'is_public' => true, 'order' => 8],
            ['group' => 'reseaux_sociaux', 'key' => 'social_google_reviews_score', 'value' => '', 'type' => 'number', 'label' => 'Note Google (ex: 4.8)', 'is_public' => true, 'order' => 9],

            // ============================================
            // ENTREPRISE
            // ============================================
            ['group' => 'entreprise', 'key' => 'entreprise_nom', 'value' => 'NeoGTB', 'type' => 'text', 'label' => 'Nom de l\'entreprise', 'is_public' => true, 'is_required' => true, 'order' => 1],
            ['group' => 'entreprise', 'key' => 'entreprise_slogan', 'value' => 'Maîtrisez la Gestion Technique de vos Bâtiments', 'type' => 'text', 'label' => 'Slogan', 'is_public' => true, 'order' => 2],
            ['group' => 'entreprise', 'key' => 'entreprise_description', 'value' => 'NeoGTB - Tout savoir sur la Gestion Technique du Bâtiment (GTB) et la Gestion Technique Centralisée (GTC)', 'type' => 'textarea', 'label' => 'Description courte', 'description' => 'Max 160 caractères', 'is_public' => true, 'order' => 3],
            ['group' => 'entreprise', 'key' => 'entreprise_siret', 'value' => '', 'type' => 'text', 'label' => 'SIRET', 'is_encrypted' => true, 'order' => 4],
            ['group' => 'entreprise', 'key' => 'entreprise_logo', 'value' => '', 'type' => 'image', 'label' => 'Logo principal', 'is_public' => true, 'order' => 5],
            ['group' => 'entreprise', 'key' => 'entreprise_logo_blanc', 'value' => '', 'type' => 'image', 'label' => 'Logo blanc (fond sombre)', 'is_public' => true, 'order' => 6],
            ['group' => 'entreprise', 'key' => 'entreprise_favicon', 'value' => '', 'type' => 'image', 'label' => 'Favicon', 'description' => '32x32px recommandé', 'is_public' => true, 'order' => 7],
            ['group' => 'entreprise', 'key' => 'entreprise_annee_creation', 'value' => '2026', 'type' => 'number', 'label' => 'Année de création', 'is_public' => true, 'order' => 8],
            ['group' => 'entreprise', 'key' => 'entreprise_couleur_primaire', 'value' => '#2563eb', 'type' => 'color', 'label' => 'Couleur primaire', 'is_public' => true, 'order' => 9],
            ['group' => 'entreprise', 'key' => 'entreprise_couleur_secondaire', 'value' => '#22c55e', 'type' => 'color', 'label' => 'Couleur secondaire', 'is_public' => true, 'order' => 10],

            // ============================================
            // SEO
            // ============================================
            ['group' => 'seo', 'key' => 'seo_meta_title_defaut', 'value' => 'NeoGTB - Gestion Technique du Bâtiment', 'type' => 'text', 'label' => 'Meta title par défaut', 'description' => 'Max 55 caractères', 'is_public' => true, 'order' => 1],
            ['group' => 'seo', 'key' => 'seo_meta_description_defaut', 'value' => 'NeoGTB - Tout savoir sur la Gestion Technique du Bâtiment (GTB) et la Gestion Technique Centralisée (GTC). Guides, audits gratuits et comparateurs.', 'type' => 'textarea', 'label' => 'Meta description par défaut', 'description' => 'Max 160 caractères', 'is_public' => true, 'order' => 2],
            ['group' => 'seo', 'key' => 'seo_og_image_defaut', 'value' => '', 'type' => 'image', 'label' => 'OG Image par défaut', 'description' => 'Format recommandé : 1200x630px', 'is_public' => true, 'order' => 3],
            ['group' => 'seo', 'key' => 'seo_robots_txt', 'value' => "User-agent: *\nAllow: /\nDisallow: /admin\nSitemap: https://neogtb.fr/sitemap.xml", 'type' => 'textarea', 'label' => 'Contenu robots.txt', 'order' => 4],
            ['group' => 'seo', 'key' => 'seo_google_search_console', 'value' => '', 'type' => 'text', 'label' => 'Google Search Console', 'description' => 'Balise de vérification', 'order' => 5],
            ['group' => 'seo', 'key' => 'seo_bing_webmaster', 'value' => '', 'type' => 'text', 'label' => 'Bing Webmaster', 'order' => 6],
            ['group' => 'seo', 'key' => 'seo_schema_type', 'value' => 'Organization', 'type' => 'select', 'label' => 'Type Schema.org', 'description' => 'Organization ou LocalBusiness', 'order' => 7],
            ['group' => 'seo', 'key' => 'seo_canonical_url', 'value' => 'https://neogtb.fr', 'type' => 'url', 'label' => 'URL canonique', 'is_public' => true, 'order' => 8],

            // ============================================
            // ANALYTICS
            // ============================================
            ['group' => 'analytics', 'key' => 'analytics_ga4_id', 'value' => '', 'type' => 'text', 'label' => 'Google Analytics 4 ID', 'description' => 'Format : G-XXXXXXXXXX', 'is_encrypted' => true, 'order' => 1],
            ['group' => 'analytics', 'key' => 'analytics_gtm_id', 'value' => '', 'type' => 'text', 'label' => 'Google Tag Manager ID', 'description' => 'Format : GTM-XXXXXXX', 'is_encrypted' => true, 'order' => 2],
            ['group' => 'analytics', 'key' => 'analytics_pixel_meta', 'value' => '', 'type' => 'text', 'label' => 'Meta Pixel ID', 'is_encrypted' => true, 'order' => 3],
            ['group' => 'analytics', 'key' => 'analytics_hotjar_id', 'value' => '', 'type' => 'text', 'label' => 'Hotjar ID', 'is_encrypted' => true, 'order' => 4],
            ['group' => 'analytics', 'key' => 'analytics_cookie_banner', 'value' => '1', 'type' => 'boolean', 'label' => 'Afficher bandeau cookies RGPD', 'is_public' => true, 'order' => 5],
            ['group' => 'analytics', 'key' => 'analytics_cookie_texte', 'value' => 'Ce site utilise des cookies pour améliorer votre expérience. En continuant, vous acceptez notre politique de cookies.', 'type' => 'textarea', 'label' => 'Texte du bandeau cookies', 'is_public' => true, 'order' => 6],

            // ============================================
            // APPARENCE
            // ============================================
            ['group' => 'apparence', 'key' => 'apparence_maintenance_mode', 'value' => '0', 'type' => 'boolean', 'label' => 'Mode maintenance', 'order' => 1],
            ['group' => 'apparence', 'key' => 'apparence_maintenance_message', 'value' => 'Le site est actuellement en maintenance. Nous serons bientôt de retour.', 'type' => 'textarea', 'label' => 'Message de maintenance', 'order' => 2],
            ['group' => 'apparence', 'key' => 'apparence_maintenance_image', 'value' => '', 'type' => 'image', 'label' => 'Image de maintenance', 'order' => 3],
            ['group' => 'apparence', 'key' => 'apparence_bandeau_info', 'value' => '0', 'type' => 'boolean', 'label' => 'Bandeau d\'information actif', 'is_public' => true, 'order' => 4],
            ['group' => 'apparence', 'key' => 'apparence_bandeau_texte', 'value' => '', 'type' => 'text', 'label' => 'Texte du bandeau', 'is_public' => true, 'order' => 5],
            ['group' => 'apparence', 'key' => 'apparence_bandeau_couleur', 'value' => '#2563eb', 'type' => 'color', 'label' => 'Couleur du bandeau', 'is_public' => true, 'order' => 6],
            ['group' => 'apparence', 'key' => 'apparence_bandeau_lien', 'value' => '', 'type' => 'url', 'label' => 'Lien du bandeau', 'is_public' => true, 'order' => 7],

            // ============================================
            // BLOG
            // ============================================
            ['group' => 'blog', 'key' => 'blog_default_cover', 'value' => '/images/blog-default-cover.png', 'type' => 'image', 'label' => 'Image par défaut articles', 'description' => 'Affichée sur les cards et hero des articles qui n\'ont pas d\'image cover spécifique. Format recommandé : 1536x1024 ou 1200x630.', 'is_public' => true, 'order' => 1],

            // ============================================
            // THÈME
            // ============================================
            ['group' => 'theme', 'key' => 'theme_primary_color', 'value' => '#1E3A5F', 'type' => 'color', 'label' => 'Couleur primaire', 'is_public' => true, 'order' => 1],
            ['group' => 'theme', 'key' => 'theme_secondary_color', 'value' => '#2D5F8A', 'type' => 'color', 'label' => 'Couleur secondaire', 'is_public' => true, 'order' => 2],
            ['group' => 'theme', 'key' => 'theme_accent_color', 'value' => '#F59E0B', 'type' => 'color', 'label' => 'Couleur accent', 'is_public' => true, 'order' => 3],
            ['group' => 'theme', 'key' => 'theme_header_bg', 'value' => '#0F172A', 'type' => 'color', 'label' => 'Fond header', 'is_public' => true, 'order' => 4],
            ['group' => 'theme', 'key' => 'theme_header_text', 'value' => '#F8FAFC', 'type' => 'color', 'label' => 'Texte header', 'is_public' => true, 'order' => 5],
            ['group' => 'theme', 'key' => 'theme_footer_bg', 'value' => '#1E293B', 'type' => 'color', 'label' => 'Fond footer', 'is_public' => true, 'order' => 6],
            ['group' => 'theme', 'key' => 'theme_footer_text', 'value' => '#CBD5E1', 'type' => 'color', 'label' => 'Texte footer', 'is_public' => true, 'order' => 7],
            ['group' => 'theme', 'key' => 'theme_body_bg', 'value' => '#FFFFFF', 'type' => 'color', 'label' => 'Fond corps de page', 'is_public' => true, 'order' => 8],
            ['group' => 'theme', 'key' => 'theme_hero_overlay', 'value' => '#0F172A', 'type' => 'color', 'label' => 'Overlay hero', 'is_public' => true, 'order' => 9],
            ['group' => 'theme', 'key' => 'theme_hero_opacity', 'value' => '60', 'type' => 'number', 'label' => 'Opacité overlay hero (0-100)', 'is_public' => true, 'order' => 10],
            ['group' => 'theme', 'key' => 'theme_cta_bg', 'value' => '#F59E0B', 'type' => 'color', 'label' => 'Fond boutons CTA', 'is_public' => true, 'order' => 11],
            ['group' => 'theme', 'key' => 'theme_cta_text', 'value' => '#0F172A', 'type' => 'color', 'label' => 'Texte boutons CTA', 'is_public' => true, 'order' => 12],
            ['group' => 'theme', 'key' => 'theme_font_pair', 'value' => 'inter_dm_sans', 'type' => 'select', 'label' => 'Paire de polices', 'is_public' => true, 'order' => 13],
            ['group' => 'theme', 'key' => 'theme_font_size', 'value' => 'md', 'type' => 'select', 'label' => 'Taille de base', 'is_public' => true, 'order' => 14],
            ['group' => 'theme', 'key' => 'theme_border_radius', 'value' => 'medium', 'type' => 'select', 'label' => 'Arrondi des coins', 'is_public' => true, 'order' => 15],
            ['group' => 'theme', 'key' => 'theme_shadow', 'value' => 'subtle', 'type' => 'select', 'label' => 'Style ombres', 'is_public' => true, 'order' => 16],

            // ============================================
            // LÉGAL
            // ============================================
            ['group' => 'legal', 'key' => 'legal_mentions_legales', 'value' => '', 'type' => 'html', 'label' => 'Mentions légales', 'is_public' => true, 'order' => 1],
            ['group' => 'legal', 'key' => 'legal_politique_confidentialite', 'value' => '', 'type' => 'html', 'label' => 'Politique de confidentialité', 'is_public' => true, 'order' => 2],
            ['group' => 'legal', 'key' => 'legal_cgu', 'value' => '', 'type' => 'html', 'label' => 'Conditions générales d\'utilisation', 'is_public' => true, 'order' => 3],
            ['group' => 'legal', 'key' => 'legal_politique_cookies', 'value' => '', 'type' => 'html', 'label' => 'Politique de cookies', 'is_public' => true, 'order' => 4],

            // ============================================
            // NAVIGATION
            // ============================================
            ['group' => 'navigation', 'key' => 'navigation_style', 'value' => 'sticky', 'type' => 'select', 'label' => 'Style navigation', 'is_public' => true, 'order' => 1],
            ['group' => 'navigation', 'key' => 'navigation_sticky', 'value' => '1', 'type' => 'boolean', 'label' => 'Navigation sticky', 'is_public' => true, 'order' => 2],
            ['group' => 'navigation', 'key' => 'navigation_cta_visible', 'value' => '1', 'type' => 'boolean', 'label' => 'Afficher CTA navigation', 'is_public' => true, 'order' => 3],
            ['group' => 'navigation', 'key' => 'navigation_cta_text', 'value' => 'Demander un audit', 'type' => 'text', 'label' => 'Texte bouton CTA', 'is_public' => true, 'order' => 4],
            ['group' => 'navigation', 'key' => 'navigation_cta_url', 'value' => '/audit', 'type' => 'text', 'label' => 'URL bouton CTA', 'is_public' => true, 'order' => 5],
            ['group' => 'navigation', 'key' => 'navigation_show_phone', 'value' => '0', 'type' => 'boolean', 'label' => 'Afficher téléphone dans le header', 'is_public' => true, 'order' => 6],

            // ============================================
            // EMAIL
            // ============================================
            ['group' => 'email', 'key' => 'email_from_name', 'value' => 'NeoGTB', 'type' => 'text', 'label' => 'Nom expéditeur', 'is_public' => false, 'order' => 1],
            ['group' => 'email', 'key' => 'email_from_address', 'value' => 'contact@neogtb.fr', 'type' => 'email', 'label' => 'Email expéditeur', 'is_public' => false, 'order' => 2],
            ['group' => 'email', 'key' => 'email_notification_to', 'value' => '', 'type' => 'email', 'label' => 'Email notifications admin', 'is_public' => false, 'order' => 3],
            ['group' => 'email', 'key' => 'email_notification_cc', 'value' => '', 'type' => 'email', 'label' => 'CC notifications (optionnel)', 'is_public' => false, 'order' => 4],

            // ============================================
            // RGPD
            // ============================================
            ['group' => 'rgpd', 'key' => 'rgpd_retention_contacts_days', 'value' => '730', 'type' => 'number', 'label' => 'Rétention messages contact (jours)', 'description' => '2 ans par défaut', 'is_public' => false, 'order' => 1],
            ['group' => 'rgpd', 'key' => 'rgpd_retention_leads_days', 'value' => '1095', 'type' => 'number', 'label' => 'Rétention leads audit (jours)', 'description' => '3 ans par défaut', 'is_public' => false, 'order' => 2],
            ['group' => 'rgpd', 'key' => 'rgpd_retention_cookies_days', 'value' => '395', 'type' => 'number', 'label' => 'Rétention consentements cookies (jours)', 'description' => '13 mois (recommandation CNIL)', 'is_public' => false, 'order' => 3],
            ['group' => 'rgpd', 'key' => 'rgpd_retention_newsletter_days', 'value' => '1095', 'type' => 'number', 'label' => 'Rétention newsletter inactifs (jours)', 'description' => '3 ans sans interaction', 'is_public' => false, 'order' => 4],

            // ============================================
            // SÉCURITÉ
            // ============================================
            ['group' => 'securite', 'key' => 'securite_recaptcha_site_key', 'value' => '', 'type' => 'text', 'label' => 'reCAPTCHA Site Key', 'is_encrypted' => true, 'order' => 1],
            ['group' => 'securite', 'key' => 'securite_recaptcha_secret_key', 'value' => '', 'type' => 'text', 'label' => 'reCAPTCHA Secret Key', 'is_encrypted' => true, 'order' => 2],
            ['group' => 'securite', 'key' => 'securite_smtp_host', 'value' => '', 'type' => 'text', 'label' => 'SMTP Host', 'is_encrypted' => true, 'order' => 3],
            ['group' => 'securite', 'key' => 'securite_smtp_port', 'value' => '587', 'type' => 'number', 'label' => 'SMTP Port', 'order' => 4],
            ['group' => 'securite', 'key' => 'securite_smtp_user', 'value' => '', 'type' => 'email', 'label' => 'SMTP Utilisateur', 'is_encrypted' => true, 'order' => 5],
            ['group' => 'securite', 'key' => 'securite_smtp_password', 'value' => '', 'type' => 'password', 'label' => 'SMTP Mot de passe', 'is_encrypted' => true, 'order' => 6],
            ['group' => 'securite', 'key' => 'securite_smtp_encryption', 'value' => 'tls', 'type' => 'select', 'label' => 'SMTP Chiffrement', 'description' => 'tls, ssl ou none', 'order' => 7],
            ['group' => 'securite', 'key' => 'securite_email_test_destination', 'value' => '', 'type' => 'email', 'label' => 'Email test destination', 'order' => 8],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                array_merge([
                    'is_public' => false,
                    'is_encrypted' => false,
                    'is_required' => false,
                ], $setting)
            );
        }

        // Clean up old keys that are no longer needed
        $validKeys = collect($settings)->pluck('key')->toArray();
        SiteSetting::whereNotIn('key', $validKeys)->delete();

        $this->command->info(count($settings) . ' paramètres du site injectés/mis à jour.');
    }
}
