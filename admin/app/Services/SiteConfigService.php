<?php

namespace App\Services;

use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Arr;

class SiteConfigService
{
    private const CACHE_TTL = 3600;

    private const FONT_PAIRS = [
        'inter_dm_sans' => [
            'url'     => 'Inter:wght@400;500;600;700&family=DM+Sans:wght@400;500;700',
            'heading' => "'Inter', sans-serif",
            'body'    => "'DM Sans', sans-serif",
        ],
        'plus_jakarta_inter' => [
            'url'     => 'Plus+Jakarta+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600',
            'heading' => "'Plus Jakarta Sans', sans-serif",
            'body'    => "'Inter', sans-serif",
        ],
        'outfit_inter' => [
            'url'     => 'Outfit:wght@400;500;600;700&family=Inter:wght@400;500;600',
            'heading' => "'Outfit', sans-serif",
            'body'    => "'Inter', sans-serif",
        ],
        'space_grotesk_inter' => [
            'url'     => 'Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600',
            'heading' => "'Space Grotesk', sans-serif",
            'body'    => "'Inter', sans-serif",
        ],
        'inter_merriweather' => [
            'url'     => 'Inter:wght@400;500;600;700&family=Merriweather:wght@400;700',
            'heading' => "'Inter', sans-serif",
            'body'    => "'Merriweather', serif",
        ],
        'poppins_lora' => [
            'url'     => 'Poppins:wght@400;500;600;700&family=Lora:wght@400;700',
            'heading' => "'Poppins', sans-serif",
            'body'    => "'Lora', serif",
        ],
        'montserrat_roboto' => [
            'url'     => 'Montserrat:wght@500;600;700&family=Roboto:wght@400;500',
            'heading' => "'Montserrat', sans-serif",
            'body'    => "'Roboto', sans-serif",
        ],
        'dm_sans_dm_serif' => [
            'url'     => 'DM+Sans:wght@400;500;700&family=DM+Serif+Display:wght@400',
            'heading' => "'DM Sans', sans-serif",
            'body'    => "'DM Serif Display', serif",
        ],
    ];

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
                '--color-primary'    => $s->primary_color ?? '#0F766E',
                '--color-secondary'  => $s->secondary_color ?? '#1E293B',
                '--color-accent'     => $s->accent_color ?? '#F59E0B',
                '--header-bg'        => $s->header_bg ?? '#FFFFFF',
                '--header-text'      => $s->header_text ?? '#1E293B',
                '--footer-bg'        => $s->footer_bg ?? '#1E293B',
                '--footer-text'      => $s->footer_text ?? '#F8FAFC',
                '--body-bg'          => $s->body_bg ?? '#FFFFFF',
                '--hero-overlay'     => $s->hero_overlay_color ?? '#0F766E',
                '--hero-opacity'     => $s->hero_overlay_opacity ?? '80',
                '--cta-bg'           => $s->cta_bg ?? '#0F766E',
                '--cta-text'         => $s->cta_text_color ?? '#FFFFFF',
                '--font-heading'     => $fonts['heading'],
                '--font-body'        => $fonts['body'],
                '--font-size'        => $s->font_size_base ?? '16px',
                '--border-radius'    => $s->border_radius ?? '8px',
                '--shadow'           => $s->shadow ?? '0 1px 3px rgba(0,0,0,0.1)',
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
        $families = self::FONT_PAIRS[$pair]['url'] ?? self::FONT_PAIRS['inter_dm_sans']['url'];

        return "https://fonts.googleapis.com/css2?family={$families}&display=swap";
    }

    public function fontPair(): array
    {
        $pair = $this->settings()->font_pair ?? 'inter_dm_sans';
        $config = self::FONT_PAIRS[$pair] ?? self::FONT_PAIRS['inter_dm_sans'];

        return [
            'heading' => $config['heading'],
            'body'    => $config['body'],
        ];
    }

    // ──────────────────────────────────────────────
    // Navigation
    // ──────────────────────────────────────────────

    public function navigation(): array
    {
        $s = $this->settings();

        return [
            'style'       => $s->nav_style,
            'sticky'      => $s->nav_sticky,
            'cta_text'    => $s->nav_cta_text,
            'cta_url'     => $s->nav_cta_url,
            'cta_visible' => $s->nav_cta_visible,
            'show_phone'  => $s->nav_show_phone,
            'phone'       => $s->company_phone,
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
            'text'       => $s->announcement_text,
            'url'        => $s->announcement_url,
            'bg_color'   => $s->announcement_bg_color ?? '#0F766E',
            'text_color' => $s->announcement_text_color ?? '#FFFFFF',
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

    public function clearCache(): void
    {
        Cache::forget('site_css_variables');
        Cache::forget('site_json_ld');
        GeneralSetting::clearCache();
    }
}
