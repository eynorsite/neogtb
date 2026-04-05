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
