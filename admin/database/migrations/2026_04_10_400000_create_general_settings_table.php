<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();

            // ─── IDENTITÉ ENTREPRISE ───
            $table->string('company_name', 100)->default('NeoGTB');
            $table->string('company_tagline')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('company_logo_white')->nullable();
            $table->string('company_logo_icon')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_phone_2')->nullable();
            $table->string('company_whatsapp')->nullable();
            $table->text('company_address')->nullable();
            $table->string('company_city')->nullable();
            $table->string('company_postal_code', 10)->nullable();
            $table->string('company_country')->default('France');
            $table->string('company_siret', 20)->nullable();
            $table->string('company_siren', 20)->nullable();
            $table->string('company_legal_form')->nullable();
            $table->string('company_tva_number')->nullable();
            $table->string('company_rcs')->nullable();
            $table->string('company_capital')->nullable();
            $table->string('company_website')->default('https://neogtb.fr');
            $table->string('legal_representative_name')->nullable();
            $table->string('legal_representative_title')->nullable();
            $table->text('company_description')->nullable();
            $table->integer('company_founding_year')->nullable();
            $table->json('company_opening_hours')->nullable();
            $table->string('company_google_maps_url')->nullable();
            $table->text('company_google_maps_embed')->nullable();

            // ─── RÉSEAUX SOCIAUX ───
            $table->string('social_linkedin')->nullable();
            $table->string('social_facebook')->nullable();
            $table->string('social_youtube')->nullable();
            $table->string('social_instagram')->nullable();
            $table->string('social_twitter_x')->nullable();
            $table->string('social_tiktok')->nullable();
            $table->string('social_google_reviews_url')->nullable();
            $table->string('social_google_reviews_count')->nullable();
            $table->string('social_google_reviews_score')->nullable();

            // ─── THÈME & APPARENCE ───
            $table->string('primary_color', 7)->default('#1E3A5F');
            $table->string('secondary_color', 7)->default('#2D5F8A');
            $table->string('accent_color', 7)->default('#F59E0B');
            $table->string('header_bg_color', 7)->default('#0F172A');
            $table->string('header_text_color', 7)->default('#F8FAFC');
            $table->string('footer_bg_color', 7)->default('#1E293B');
            $table->string('footer_text_color', 7)->default('#CBD5E1');
            $table->string('body_bg_color', 7)->default('#FFFFFF');
            $table->string('hero_overlay_color', 7)->default('#0F172A');
            $table->integer('hero_overlay_opacity')->default(60);
            $table->string('cta_bg_color', 7)->default('#F59E0B');
            $table->string('cta_text_color', 7)->default('#0F172A');
            $table->string('font_pair')->default('inter_dm_sans');
            $table->string('font_size_base')->default('md');
            $table->string('border_radius_style')->default('medium');
            $table->string('shadow_style')->default('subtle');

            // ─── IMAGES ───
            $table->string('favicon')->nullable();
            $table->string('og_default_image')->nullable();

            // ─── NAVIGATION ───
            $table->string('nav_cta_text')->default('Demander un audit');
            $table->string('nav_cta_url')->default('/audit');
            $table->boolean('nav_cta_visible')->default(true);
            $table->boolean('nav_show_phone')->default(false);
            $table->string('nav_style')->default('sticky');
            $table->boolean('nav_sticky')->default(true);

            // ─── HOMEPAGE SECTIONS ───
            $table->json('homepage_sections')->nullable();
            $table->json('homepage_sections_config')->nullable();

            // ─── PAGES CONFIG ───
            $table->json('gtb_page_config')->nullable();
            $table->json('gtc_page_config')->nullable();
            $table->json('solutions_page_config')->nullable();
            $table->json('reglementation_page_config')->nullable();
            $table->json('audit_page_config')->nullable();
            $table->json('contact_page_config')->nullable();
            $table->json('about_page_config')->nullable();
            $table->json('faq_page_config')->nullable();
            $table->json('comparateur_page_config')->nullable();

            // ─── UI LABELS ───
            $table->json('ui_labels')->nullable();

            // ─── STATUS CONFIGS ───
            $table->json('status_configs')->nullable();

            // ─── TEXTES LÉGAUX ───
            $table->json('legal_texts')->nullable();

            // ─── STATISTIQUES ───
            $table->integer('stat_buildings_audited')->nullable();
            $table->integer('stat_avg_savings_percent')->nullable();
            $table->integer('stat_years_experience')->nullable();
            $table->integer('stat_clients_count')->nullable();

            // ─── ANNONCE BANDEAU ───
            $table->boolean('announcement_enabled')->default(false);
            $table->text('announcement_text')->nullable();
            $table->string('announcement_url')->nullable();
            $table->string('announcement_bg_color', 7)->default('#2563eb');
            $table->string('announcement_text_color', 7)->default('#ffffff');

            // ─── SEO ───
            $table->string('seo_title_suffix')->default(' — NeoGTB');
            $table->text('seo_default_description')->nullable();
            $table->string('seo_robots')->default('index, follow');
            $table->string('seo_google_verification')->nullable();
            $table->string('seo_bing_verification')->nullable();
            $table->string('seo_schema_type')->default('Organization');
            $table->string('seo_canonical_url')->default('https://neogtb.fr');

            // ─── TRACKING ───
            $table->string('google_analytics_id')->nullable();
            $table->string('google_tag_manager_id')->nullable();
            $table->string('facebook_pixel_id')->nullable();
            $table->string('hotjar_id')->nullable();
            $table->boolean('cookie_banner_enabled')->default(true);
            $table->text('cookie_banner_text')->nullable();

            // ─── MAINTENANCE ───
            $table->boolean('maintenance_enabled')->default(false);
            $table->text('maintenance_message')->nullable();
            $table->string('maintenance_image')->nullable();
            $table->text('custom_head_code')->nullable();
            $table->text('custom_body_code')->nullable();

            // ─── EMAIL ───
            $table->string('email_from_name')->default('NeoGTB');
            $table->string('email_from_address')->default('hello@neogtb.fr');
            $table->string('email_notification_to')->nullable();
            $table->string('email_notification_cc')->nullable();

            // ─── RGPD ───
            $table->integer('rgpd_retention_contacts_days')->default(730);
            $table->integer('rgpd_retention_leads_days')->default(1095);
            $table->integer('rgpd_retention_cookies_days')->default(395);
            $table->integer('rgpd_retention_newsletter_days')->default(1095);

            // ─── SÉCURITÉ ───
            $table->string('recaptcha_site_key')->nullable();
            $table->string('recaptcha_secret_key')->nullable();
            $table->string('smtp_host')->nullable();
            $table->integer('smtp_port')->default(587);
            $table->string('smtp_user')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('smtp_encryption')->default('tls');

            // ─── BLOG ───
            $table->string('blog_default_cover')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
