<?php

namespace App\Services;

use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Arr;

class SiteConfigService
{
    private const CACHE_TTL = 3600;

    // ──────────────────────────────────────────────
    // Accès aux settings
    // ──────────────────────────────────────────────

    public function settings(): GeneralSetting
    {
        return GeneralSetting::get();
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->settings()->{$key} ?? $default;
    }

    // ──────────────────────────────────────────────
    // Thème & CSS Variables
    // ──────────────────────────────────────────────

    public function cssVariables(): HtmlString
    {
        $css = Cache::remember('site_css_variables', self::CACHE_TTL, function () {
            $s = $this->settings();
            $fonts = $this->fontPair();

            $vars = [
                '--color-primary'      => $s->primary_color ?? '#1E3A5F',
                '--color-secondary'    => $s->secondary_color ?? '#2D5F8A',
                '--color-accent'       => $s->accent_color ?? '#F59E0B',
                '--color-header-bg'    => $s->header_bg_color ?? '#0F172A',
                '--color-header-text'  => $s->header_text_color ?? '#F8FAFC',
                '--color-footer-bg'    => $s->footer_bg_color ?? '#1E293B',
                '--color-footer-text'  => $s->footer_text_color ?? '#CBD5E1',
                '--color-body-bg'      => $s->body_bg_color ?? '#FFFFFF',
                '--color-hero-overlay' => $s->hero_overlay_color ?? '#0F172A',
                '--hero-overlay-opacity' => ($s->hero_overlay_opacity ?? 60) / 100,
                '--color-cta-bg'       => $s->cta_bg_color ?? '#F59E0B',
                '--color-cta-text'     => $s->cta_text_color ?? '#0F172A',
                '--font-heading'       => $fonts['heading'],
                '--font-body'          => $fonts['body'],
                '--font-size-base'     => match($s->font_size_base ?? 'md') { 'sm' => '14px', 'lg' => '18px', default => '16px' },
                '--radius'             => match($s->border_radius_style ?? 'medium') {
                    'none' => '0', 'small' => '4px', 'large' => '12px', 'full' => '9999px', default => '8px'
                },
                '--shadow'             => match($s->shadow_style ?? 'subtle') {
                    'none' => 'none', 'medium' => '0 4px 6px rgba(0,0,0,0.1)', 'strong' => '0 10px 25px rgba(0,0,0,0.15)', default => '0 1px 3px rgba(0,0,0,0.08)'
                },
            ];

            $lines = [];
            foreach ($vars as $prop => $value) {
                $value = e($value);
                $lines[] = "    {$prop}: {$value};";
            }

            return "<style>:root {\n" . implode("\n", $lines) . "\n}</style>";
        });

        return new HtmlString($css);
    }

    // ──────────────────────────────────────────────
    // Google Fonts
    // ──────────────────────────────────────────────

    public function googleFontsUrl(): string
    {
        $pair = $this->settings()->font_pair ?? 'inter_dm_sans';
        $pairs = $this->settings()->font_pairs_config ?? [];
        $found = collect($pairs)->firstWhere('key', $pair);
        $families = $found['google_families'] ?? 'Inter:wght@400;500;600;700&family=DM+Sans:wght@400;500;700';

        return "https://fonts.googleapis.com/css2?family={$families}&display=swap";
    }

    public function fontPair(): array
    {
        $pair = $this->settings()->font_pair ?? 'inter_dm_sans';
        $pairs = $this->settings()->font_pairs_config ?? [];
        $found = collect($pairs)->firstWhere('key', $pair);

        return [
            'heading' => "'" . ($found['heading'] ?? 'Inter') . "', sans-serif",
            'body'    => "'" . ($found['body'] ?? 'DM Sans') . "', sans-serif",
        ];
    }

    // ──────────────────────────────────────────────
    // Navigation
    // ──────────────────────────────────────────────

    public function navigation(): array
    {
        $s = $this->settings();

        return [
            'style'       => $s->nav_style ?? 'sticky',
            'cta_text'    => $s->nav_cta_text ?? 'Demander un audit',
            'cta_url'     => $s->nav_cta_url ?? '/audit',
            'cta_visible' => (bool) ($s->nav_cta_visible ?? true),
            'show_phone'  => (bool) ($s->nav_show_phone ?? false),
            'phone'       => $s->company_phone ?? '',
            'items'       => collect($s->nav_items ?? [])->where('visible', true)->values()->toArray(),
        ];
    }

    // ──────────────────────────────────────────────
    // Réseaux sociaux
    // ──────────────────────────────────────────────

    public function socialLinks(): array
    {
        return $this->settings()->social_links;
    }

    // ──────────────────────────────────────────────
    // SEO — JSON-LD
    // ──────────────────────────────────────────────

    public function jsonLd(string $type = 'Organization'): HtmlString
    {
        $jsonLd = Cache::remember('site_json_ld', self::CACHE_TTL, function () use ($type) {
            $s = $this->settings();

            $data = [
                '@context' => 'https://schema.org',
                '@type'    => $type,
                'name'     => $s->company_name ?? 'NeoGTB',
                'url'      => config('app.url', 'https://neogtb.fr'),
            ];

            if (filled($s->company_description)) {
                $data['description'] = $s->company_description;
            }

            if (filled($s->company_email)) {
                $data['email'] = $s->company_email;
            }

            if (filled($s->company_phone)) {
                $data['telephone'] = $s->company_phone;
            }

            // Logo
            if (filled($s->company_logo)) {
                $data['logo'] = asset('storage/' . $s->company_logo);
            }

            // Address
            if (filled($s->company_address) || filled($s->company_city)) {
                $data['address'] = [
                    '@type'           => 'PostalAddress',
                    'streetAddress'   => $s->company_address,
                    'addressLocality' => $s->company_city,
                    'postalCode'      => $s->company_postal_code,
                    'addressCountry'  => 'FR',
                ];
            }

            // Founding year
            if (filled($s->company_founding_year)) {
                $data['foundingDate'] = (string) $s->company_founding_year;
            }

            // Social links
            $socials = $this->socialLinks();
            if (! empty($socials)) {
                $data['sameAs'] = array_values($socials);
            }

            return '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>';
        });

        return new HtmlString($jsonLd);
    }

    // ──────────────────────────────────────────────
    // Tracking Scripts
    // ──────────────────────────────────────────────

    public function trackingScripts(array $consent = []): array
    {
        $head = '';
        $body = '';
        $s = $this->settings();

        // Google Tag Manager (head + body)
        if (! empty($consent['analytics'])) {
            $gtmId = $s->google_tag_manager_id;
            if (filled($gtmId)) {
                $gtmId = e($gtmId);
                $head .= <<<HTML
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','{$gtmId}');</script>
<!-- End Google Tag Manager -->
HTML;
                $body .= <<<HTML
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={$gtmId}"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
HTML;
            }

            // GA4 (only if no GTM)
            if (blank($gtmId ?? null)) {
                $ga4Id = $s->google_analytics_id;
                if (filled($ga4Id)) {
                    $ga4Id = e($ga4Id);
                    $head .= <<<HTML
<!-- Google Analytics 4 -->
<script async src="https://www.googletagmanager.com/gtag/js?id={$ga4Id}"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}
gtag('js',new Date());gtag('config','{$ga4Id}');</script>
<!-- End GA4 -->
HTML;
                }
            }
        }

        // Meta Pixel
        if (! empty($consent['marketing'])) {
            $pixelId = $s->facebook_pixel_id;
            if (filled($pixelId)) {
                $pixelId = e($pixelId);
                $head .= <<<HTML
<!-- Meta Pixel -->
<script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init','{$pixelId}');fbq('track','PageView');</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id={$pixelId}&ev=PageView&noscript=1"/></noscript>
<!-- End Meta Pixel -->
HTML;
            }
        }

        // Hotjar
        if (! empty($consent['analytics'])) {
            $hotjarId = $s->hotjar_id;
            if (filled($hotjarId)) {
                $hotjarId = e($hotjarId);
                $head .= <<<HTML
<!-- Hotjar -->
<script>(function(h,o,t,j,a,r){h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
h._hjSettings={hjid:{$hotjarId},hjsv:6};a=o.getElementsByTagName('head')[0];
r=o.createElement('script');r.async=1;r.src=t+h._hjSettings.hjid+j;
a.appendChild(r);})(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=6');</script>
<!-- End Hotjar -->
HTML;
            }
        }

        return [
            'head' => new HtmlString($head),
            'body' => new HtmlString($body),
        ];
    }

    // ──────────────────────────────────────────────
    // Annonce
    // ──────────────────────────────────────────────

    public function announcementBar(): ?array
    {
        $s = $this->settings();

        if (! $s->announcement_enabled) {
            return null;
        }

        if (blank($s->announcement_text)) {
            return null;
        }

        return [
            'text'        => $s->announcement_text,
            'url'         => $s->announcement_url,
            'bg_color'    => $s->announcement_bg_color ?? '#0F766E',
            'text_color'  => $s->announcement_text_color ?? '#FFFFFF',
            'dismissable' => (bool) ($s->announcement_dismissable ?? true),
        ];
    }

    // ──────────────────────────────────────────────
    // Labels d'interface (pattern BIMACAD)
    // ──────────────────────────────────────────────

    public function label(string $path, string $default = ''): string
    {
        return Arr::get($this->settings()->ui_labels ?? [], $path, $default);
    }

    // ──────────────────────────────────────────────
    // Statuts (pattern BIMACAD)
    // ──────────────────────────────────────────────

    public function statusLabel(string $entity, string $key): string
    {
        $statuses = $this->settings()->status_configs[$entity] ?? [];
        $status = collect($statuses)->firstWhere('key', $key);

        return $status['label'] ?? $key;
    }

    public function statusColor(string $entity, string $key): string
    {
        $statuses = $this->settings()->status_configs[$entity] ?? [];
        $status = collect($statuses)->firstWhere('key', $key);

        return $status['color'] ?? 'gray';
    }

    public function statusIcon(string $entity, string $key): string
    {
        $statuses = $this->settings()->status_configs[$entity] ?? [];
        $status = collect($statuses)->firstWhere('key', $key);

        return $status['icon'] ?? 'heroicon-o-question-mark-circle';
    }

    public function statusOptions(string $entity): array
    {
        $statuses = $this->settings()->status_configs[$entity] ?? [];

        return collect($statuses)->pluck('label', 'key')->toArray();
    }

    // ──────────────────────────────────────────────
    // Textes légaux
    // ──────────────────────────────────────────────

    public function legalText(string $key): string
    {
        return Arr::get($this->settings()->legal_texts ?? [], $key, '');
    }

    // ──────────────────────────────────────────────
    // Statistiques
    // ──────────────────────────────────────────────

    public function stats(): array
    {
        $s = $this->settings();

        return [
            'buildings_audited' => $s->stat_buildings_audited,
            'avg_savings'       => $s->stat_avg_savings_percent,
            'years_experience'  => $s->stat_years_experience,
            'clients_count'     => $s->stat_clients_count,
        ];
    }

    // ──────────────────────────────────────────────
    // Divers
    // ──────────────────────────────────────────────

    public function openingHours(): array
    {
        return $this->settings()->company_opening_hours ?? [];
    }

    public function companyAge(): ?int
    {
        $year = $this->settings()->company_founding_year;

        return $year ? (int) date('Y') - $year : null;
    }

    // ──────────────────────────────────────────────
    // Cache management
    // ──────────────────────────────────────────────

    // ──────────────────────────────────────────────
    // Registres (blog, protocoles, EN 15232, homepage)
    // ──────────────────────────────────────────────

    public function blogCategories(): array
    {
        return Cache::remember('blog_categories', self::CACHE_TTL, fn() => $this->settings()->blog_categories_config ?? []);
    }

    public function gtbProtocols(): array
    {
        return Cache::remember('gtb_protocols', self::CACHE_TTL, fn() => $this->settings()->gtb_protocols_config ?? []);
    }

    public function en15232Levels(): array
    {
        return Cache::remember('en15232_levels', self::CACHE_TTL, fn() => $this->settings()->en15232_levels_config ?? []);
    }

    public function homepageSections(): array
    {
        return $this->settings()->homepage_sections ?? [];
    }

    public function homepageSectionConfig(string $section): array
    {
        return $this->settings()->homepage_sections_config[$section] ?? [];
    }

    // ──────────────────────────────────────────────
    // Cache management
    // ──────────────────────────────────────────────

    public function clearCache(): void
    {
        Cache::forget('site_css_variables');
        Cache::forget('site_json_ld');
        Cache::forget('blog_categories');
        Cache::forget('gtb_protocols');
        Cache::forget('en15232_levels');
        GeneralSetting::clearCache();
    }
}
