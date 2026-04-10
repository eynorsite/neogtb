<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class GeneralSetting extends Model
{
    protected $guarded = ['id'];

    // Singleton pattern — pas de cache d'objet Eloquent (évite __PHP_Incomplete_Class)
    protected static ?self $instance = null;

    public static function get(): self
    {
        if (static::$instance === null) {
            static::$instance = self::first() ?? self::create(['company_name' => 'NeoGTB']);
        }
        return static::$instance;
    }

    // Accès rapide à un champ
    public static function value(string $key, mixed $default = null): mixed
    {
        return self::get()->{$key} ?? $default;
    }

    // Invalidation cache
    public static function clearCache(): void
    {
        static::$instance = null;
        Cache::forget('site_css_variables');
        Cache::forget('site_json_ld');
    }

    protected static function booted(): void
    {
        static::saved(fn() => static::clearCache());
    }

    protected function casts(): array
    {
        return [
            // JSON
            'company_opening_hours' => 'array',
            'homepage_sections' => 'array',
            'homepage_sections_config' => 'array',
            'gtb_page_config' => 'array',
            'gtc_page_config' => 'array',
            'solutions_page_config' => 'array',
            'reglementation_page_config' => 'array',
            'audit_page_config' => 'array',
            'contact_page_config' => 'array',
            'about_page_config' => 'array',
            'faq_page_config' => 'array',
            'comparateur_page_config' => 'array',
            'ui_labels' => 'array',
            'status_configs' => 'array',
            'legal_texts' => 'array',

            // Booleans
            'nav_cta_visible' => 'boolean',
            'nav_show_phone' => 'boolean',
            'nav_sticky' => 'boolean',
            'announcement_enabled' => 'boolean',
            'cookie_banner_enabled' => 'boolean',
            'maintenance_enabled' => 'boolean',

            // Integers
            'hero_overlay_opacity' => 'integer',
            'stat_buildings_audited' => 'integer',
            'stat_avg_savings_percent' => 'integer',
            'stat_years_experience' => 'integer',
            'stat_clients_count' => 'integer',
            'company_founding_year' => 'integer',
            'rgpd_retention_contacts_days' => 'integer',
            'rgpd_retention_leads_days' => 'integer',
            'rgpd_retention_cookies_days' => 'integer',
            'rgpd_retention_newsletter_days' => 'integer',
            'smtp_port' => 'integer',
        ];
    }

    // ─── Accesseurs utiles ───

    public function getFullAddressAttribute(): string
    {
        return implode(', ', array_filter([
            $this->company_address,
            $this->company_postal_code,
            $this->company_city,
        ]));
    }

    public function getSocialLinksAttribute(): array
    {
        $links = [];
        foreach (['linkedin', 'facebook', 'youtube', 'instagram', 'twitter_x', 'tiktok'] as $network) {
            $key = "social_{$network}";
            if (!empty($this->{$key})) {
                $links[$network] = $this->{$key};
            }
        }
        return $links;
    }

    public function getCopyrightAttribute(): string
    {
        return '© ' . date('Y') . ' ' . $this->company_name;
    }
}
