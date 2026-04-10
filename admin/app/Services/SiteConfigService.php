<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;

class SiteConfigService
{
    private const CACHE_PREFIX = 'site_config:';
    private const CACHE_TTL = 300;

    private const FONT_PAIRS = [
        'inter_dm_sans' => 'Inter:wght@400;500;600;700&family=DM+Sans:wght@400;500;700',
        'plus_jakarta_inter' => 'Plus+Jakarta+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600',
        'outfit_inter' => 'Outfit:wght@400;500;600;700&family=Inter:wght@400;500;600',
        'space_grotesk_inter' => 'Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600',
        'inter_merriweather' => 'Inter:wght@400;500;600;700&family=Merriweather:wght@400;700',
        'poppins_lora' => 'Poppins:wght@400;500;600;700&family=Lora:wght@400;700',
        'montserrat_roboto' => 'Montserrat:wght@500;600;700&family=Roboto:wght@400;500',
        'dm_sans_dm_serif' => 'DM+Sans:wght@400;500;700&family=DM+Serif+Display:wght@400',
    ];

    // ──────────────────────────────────────────────
    // Delegates
    // ──────────────────────────────────────────────

    public function get(string $key, mixed $default = null): mixed
    {
        return SiteSetting::get($key, $default);
    }

    public function getGroup(string $group): array
    {
        return SiteSetting::getGroup($group);
    }

    // ──────────────────────────────────────────────
    // CSS Variables
    // ──────────────────────────────────────────────

    public function cssVariables(): HtmlString
    {
        $css = Cache::remember(self::CACHE_PREFIX . 'css_variables', self::CACHE_TTL, function () {
            $vars = [
                '--color-primary'    => SiteSetting::get('theme_primary_color', '#0F766E'),
                '--color-secondary'  => SiteSetting::get('theme_secondary_color', '#1E293B'),
                '--color-accent'     => SiteSetting::get('theme_accent_color', '#F59E0B'),
                '--header-bg'        => SiteSetting::get('theme_header_bg', '#FFFFFF'),
                '--header-text'      => SiteSetting::get('theme_header_text', '#1E293B'),
                '--footer-bg'        => SiteSetting::get('theme_footer_bg', '#1E293B'),
                '--footer-text'      => SiteSetting::get('theme_footer_text', '#F8FAFC'),
                '--body-bg'          => SiteSetting::get('theme_body_bg', '#FFFFFF'),
                '--hero-overlay'     => SiteSetting::get('theme_hero_overlay', '#0F766E'),
                '--hero-opacity'     => SiteSetting::get('theme_hero_opacity', '0.8'),
                '--cta-bg'           => SiteSetting::get('theme_cta_bg', '#0F766E'),
                '--cta-text'         => SiteSetting::get('theme_cta_text', '#FFFFFF'),
                '--font-pair'        => SiteSetting::get('theme_font_pair', 'inter_dm_sans'),
                '--font-size'        => SiteSetting::get('theme_font_size', '16px'),
                '--border-radius'    => SiteSetting::get('theme_border_radius', '8px'),
                '--shadow'           => SiteSetting::get('theme_shadow', '0 1px 3px rgba(0,0,0,0.1)'),
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

    public function googleFontsUrl(): ?string
    {
        $pair = SiteSetting::get('theme_font_pair', 'inter_dm_sans');

        $families = self::FONT_PAIRS[$pair] ?? self::FONT_PAIRS['inter_dm_sans'];

        return "https://fonts.googleapis.com/css2?family={$families}&display=swap";
    }

    // ──────────────────────────────────────────────
    // Navigation
    // ──────────────────────────────────────────────

    public function navigation(): array
    {
        return [
            'style'       => SiteSetting::get('navigation_style', 'transparent'),
            'sticky'      => (bool) SiteSetting::get('navigation_sticky', true),
            'cta_text'    => SiteSetting::get('navigation_cta_text', 'Demander un audit'),
            'cta_url'     => SiteSetting::get('navigation_cta_url', '/audit'),
            'cta_visible' => (bool) SiteSetting::get('navigation_cta_visible', true),
            'show_phone'  => (bool) SiteSetting::get('navigation_show_phone', false),
            'phone'       => SiteSetting::get('contact_telephone'),
        ];
    }

    // ──────────────────────────────────────────────
    // Social Links
    // ──────────────────────────────────────────────

    public function socialLinks(): array
    {
        $keys = [
            'social_linkedin',
            'social_facebook',
            'social_instagram',
            'social_youtube',
            'social_twitter_x',
            'social_tiktok',
        ];

        $links = [];
        foreach ($keys as $key) {
            $value = SiteSetting::get($key);
            if (filled($value)) {
                $name = str_replace('social_', '', $key);
                $links[$name] = $value;
            }
        }

        return $links;
    }

    // ──────────────────────────────────────────────
    // Tracking Scripts
    // ──────────────────────────────────────────────

    public function trackingScripts(array $consent = []): array
    {
        $head = '';
        $body = '';

        // Google Tag Manager (head + body)
        if (! empty($consent['analytics'])) {
            $gtmId = SiteSetting::get('analytics_gtm_id');
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
            if (blank($gtmId)) {
                $ga4Id = SiteSetting::get('analytics_ga4_id');
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
            $pixelId = SiteSetting::get('analytics_pixel_meta');
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
            $hotjarId = SiteSetting::get('analytics_hotjar_id');
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
    // JSON-LD (Organization)
    // ──────────────────────────────────────────────

    public function jsonLd(): HtmlString
    {
        $jsonLd = Cache::remember(self::CACHE_PREFIX . 'json_ld', self::CACHE_TTL, function () {
            $data = [
                '@context' => 'https://schema.org',
                '@type'    => 'Organization',
                'name'     => SiteSetting::get('entreprise_nom', 'NeoGTB'),
                'url'      => config('app.url', 'https://neogtb.fr'),
            ];

            $description = SiteSetting::get('entreprise_description');
            if (filled($description)) {
                $data['description'] = $description;
            }

            $email = SiteSetting::get('contact_email');
            if (filled($email)) {
                $data['email'] = $email;
            }

            $telephone = SiteSetting::get('contact_telephone');
            if (filled($telephone)) {
                $data['telephone'] = $telephone;
            }

            // Address
            $adresse = SiteSetting::get('contact_adresse');
            $ville = SiteSetting::get('contact_ville');
            $codePostal = SiteSetting::get('contact_code_postal');

            if (filled($adresse) || filled($ville)) {
                $data['address'] = [
                    '@type'           => 'PostalAddress',
                    'streetAddress'   => $adresse,
                    'addressLocality' => $ville,
                    'postalCode'      => $codePostal,
                    'addressCountry'  => 'FR',
                ];
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
    // Announcement Bar
    // ──────────────────────────────────────────────

    public function announcementBar(): ?array
    {
        $active = SiteSetting::get('apparence_bandeau_info', false);

        if (! $active || $active === '0' || $active === 'false') {
            return null;
        }

        $texte = SiteSetting::get('apparence_bandeau_texte');

        if (blank($texte)) {
            return null;
        }

        return [
            'text'  => $texte,
            'color' => SiteSetting::get('apparence_bandeau_couleur', '#0F766E'),
            'link'  => SiteSetting::get('apparence_bandeau_lien'),
        ];
    }

    // ──────────────────────────────────────────────
    // Cache management
    // ──────────────────────────────────────────────

    public function clearCache(): void
    {
        Cache::forget(self::CACHE_PREFIX . 'css_variables');
        Cache::forget(self::CACHE_PREFIX . 'json_ld');
    }
}
