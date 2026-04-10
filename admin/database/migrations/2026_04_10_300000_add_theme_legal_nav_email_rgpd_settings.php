<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    public function up(): void
    {
        Artisan::call('db:seed', ['--class' => 'SiteSettingsSeeder']);
    }

    public function down(): void
    {
        $keysToRemove = [
            // theme
            'theme_primary_color', 'theme_secondary_color', 'theme_accent_color',
            'theme_header_bg', 'theme_header_text', 'theme_footer_bg', 'theme_footer_text',
            'theme_body_bg', 'theme_hero_overlay', 'theme_hero_opacity',
            'theme_cta_bg', 'theme_cta_text', 'theme_font_pair', 'theme_font_size',
            'theme_border_radius', 'theme_shadow',
            // legal
            'legal_mentions_legales', 'legal_politique_confidentialite',
            'legal_cgu', 'legal_politique_cookies',
            // navigation
            'navigation_style', 'navigation_sticky', 'navigation_cta_visible',
            'navigation_cta_text', 'navigation_cta_url', 'navigation_show_phone',
            // email
            'email_from_name', 'email_from_address',
            'email_notification_to', 'email_notification_cc',
            // rgpd
            'rgpd_retention_contacts_days', 'rgpd_retention_leads_days',
            'rgpd_retention_cookies_days', 'rgpd_retention_newsletter_days',
        ];

        \App\Models\SiteSetting::whereIn('key', $keysToRemove)->delete();
    }
};
