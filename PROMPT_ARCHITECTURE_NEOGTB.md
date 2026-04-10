# Prompt — Architecture NeoGTB 100% Administrable

> Prompt adapté au projet NeoGTB (site éducatif GTB/GTC).
> Basé sur le pattern "zéro hardcode" de BIMACAD, **recalibré pour le périmètre et le code existant**.
> Stack : **Laravel 12 + Filament 3 + Livewire + Tailwind CSS + SQLite**

---

## 0. CONTEXTE & ÉTAT EXISTANT

### Ce qui existe déjà (NE PAS recréer)

| Élément | Détail |
|---------|--------|
| **Table `site_settings`** | Key/value avec `group`, `key`, `value`, `type`, `label`, `is_public`, `is_encrypted`, `order`. Model `SiteSetting` avec `::get()`, `::set()`, `::getGroup()`, cache 300s, auto-clear on save. |
| **Groupes settings** | `contact` (12), `reseaux_sociaux` (9), `entreprise` (10), `seo` (8), `analytics` (6), `apparence` (7), `blog` (1), `securite` (8) = 61 clés |
| **Bricks** | 23 types dans `app/Filament/Bricks/`. Table `page_bricks` (type, content JSON, settings JSON, order). `BrickEditorPage` Livewire drag-and-drop. |
| **Blog** | `Post`, `PostCategory`, `PostTag`. Complet avec SEO par article. |
| **Leads** | `AuditLead`, `CeeLead` avec PII chiffrées. |
| **RGPD** | `CookieConsent`, `GdprRequest` (5 types), `PrivacyPolicyVersion`, `RgpdDashboardPage`. Chiffrement PII sur 6 modèles. |
| **Admin** | 4 rôles (superadmin, admin, editeur, lecteur), `AdminActivityLog`, 9 resources Filament, 8 pages Filament. |
| **Navigation** | `NavigationMenu` + `NavigationItem` avec parent/child, drag-and-drop. |
| **Pages** | `SitePage` + `PageSection` + `PageBrick`. 14 pages front. |
| **Helpers** | `site_setting()`, `site_contact()`, `site_seo()`, `site_appearance()` dans `app/Helpers/site_helpers.php` |

### Règle fondamentale

> **Tout contenu visible par l'utilisateur final doit être administrable depuis Filament.**
> Les structures techniques (schémas, cache TTL, layout admin) restent dans le code.

**Ce qui DOIT être dynamique** : contenu des pages (bricks), infos entreprise, couleurs thème, textes légaux, SEO, tracking, navigation CTA.

**Ce qui PEUT rester en dur** : labels d'UI ("Envoyer", "Retour"), messages de validation Laravel (`lang/fr/`), textes admin Filament, placeholders de formulaire.

### Convention de nommage des clés `site_settings`

**Format unique : `groupe_nom` en snake_case** (aligné sur l'existant).

```
contact_telephone       ✅  (existant)
theme_primary_color     ✅  (nouveau)
theme.header_bg         ❌  (dot notation — interdit)
theme_header-bg         ❌  (kebab dans la clé — interdit)
```

### Ordre d'implémentation recommandé

```
1. Migration + Seeder (nouveaux groupes settings)
2. SiteConfigService + ViewComposer
3. Onglets admin Filament (theme, legal, navigation, email)
4. Adaptation des vues Blade existantes
5. SEO enrichi (Schema.org, breadcrumbs, canonical)
6. Tracking conditionnel (consentement cookie)
7. Purge RGPD automatisée
```

---

## 1. ARCHITECTURE BDD & SERVICES

### 1.1 Nouveaux groupes `site_settings`

#### Groupe `theme` (16 clés)

| Clé | Type | Label | Défaut | is_public |
|-----|------|-------|--------|-----------|
| `theme_primary_color` | color | Couleur primaire | `#1E3A5F` | true |
| `theme_secondary_color` | color | Couleur secondaire | `#2D5F8A` | true |
| `theme_accent_color` | color | Couleur accent | `#F59E0B` | true |
| `theme_header_bg` | color | Fond header | `#0F172A` | true |
| `theme_header_text` | color | Texte header | `#F8FAFC` | true |
| `theme_footer_bg` | color | Fond footer | `#1E293B` | true |
| `theme_footer_text` | color | Texte footer | `#CBD5E1` | true |
| `theme_body_bg` | color | Fond corps de page | `#FFFFFF` | true |
| `theme_hero_overlay` | color | Overlay hero | `#0F172A` | true |
| `theme_hero_opacity` | number | Opacité overlay (0-100) | `60` | true |
| `theme_cta_bg` | color | Fond boutons CTA | `#F59E0B` | true |
| `theme_cta_text` | color | Texte boutons CTA | `#0F172A` | true |
| `theme_font_pair` | select | Paire de polices | `inter_dm_sans` | true |
| `theme_font_size` | select | Taille de base (sm/md/lg) | `md` | true |
| `theme_border_radius` | select | Arrondi des coins | `medium` | true |
| `theme_shadow` | select | Style ombres | `subtle` | true |

Options `theme_font_pair` : `inter_dm_sans`, `plus_jakarta_inter`, `outfit_inter`, `space_grotesk_inter`, `inter_merriweather`, `poppins_lora`, `montserrat_roboto`, `dm_sans_dm_serif`

Options `theme_border_radius` : `none` (0), `small` (4px), `medium` (8px), `large` (12px), `full` (9999px)

Options `theme_shadow` : `none`, `subtle`, `medium`, `strong`

#### Groupe `legal` (4 clés)

| Clé | Type | Label |
|-----|------|-------|
| `legal_mentions_legales` | html | Mentions légales |
| `legal_politique_confidentialite` | html | Politique de confidentialité |
| `legal_cgu` | html | CGU |
| `legal_politique_cookies` | html | Politique de cookies |

#### Groupe `navigation` (6 clés)

| Clé | Type | Label | Défaut |
|-----|------|-------|--------|
| `navigation_style` | select | Style navigation | `sticky` |
| `navigation_sticky` | boolean | Navigation sticky | `true` |
| `navigation_cta_visible` | boolean | Afficher CTA | `true` |
| `navigation_cta_text` | text | Texte bouton CTA | `Demander un audit` |
| `navigation_cta_url` | text | URL bouton CTA | `/audit` |
| `navigation_show_phone` | boolean | Afficher téléphone | `false` |

Options `navigation_style` : `sticky`, `transparent`, `solid`

#### Groupe `email` (4 clés)

| Clé | Type | Label | Défaut |
|-----|------|-------|--------|
| `email_from_name` | text | Nom expéditeur | `NeoGTB` |
| `email_from_address` | email | Email expéditeur | `contact@neogtb.fr` |
| `email_notification_to` | email | Email notifications admin | — |
| `email_notification_cc` | email | CC notifications (optionnel) | `null` |

#### Groupe `rgpd` (4 clés)

| Clé | Type | Label | Défaut |
|-----|------|-------|--------|
| `rgpd_retention_contacts_days` | number | Rétention messages contact (jours) | `730` |
| `rgpd_retention_leads_days` | number | Rétention leads audit (jours) | `1095` |
| `rgpd_retention_cookies_days` | number | Rétention consentements cookies (jours) | `395` |
| `rgpd_retention_newsletter_days` | number | Rétention newsletter inactifs (jours) | `1095` |

**Total ajouté : 34 clés → total site_settings : 95 clés**

### 1.2 Service `SiteConfigService`

Couche d'abstraction entre `SiteSetting` et les vues Blade. **Un seul layer de cache** — le service lit depuis `SiteSetting::get()` qui gère déjà le cache, et ne cache que les valeurs calculées (CSS, JSON-LD).

```php
<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;

class SiteConfigService
{
    protected const CACHE_PREFIX = 'site_config:';
    protected const CACHE_TTL = 300; // Même TTL que SiteSetting

    // ── Accès générique ──────────────────────

    public function get(string $key, mixed $default = null): mixed
    {
        return SiteSetting::get($key, $default);
    }

    public function getGroup(string $group): array
    {
        return SiteSetting::getGroup($group);
    }

    // ── CSS Variables dynamiques ─────────────

    public function cssVariables(): HtmlString
    {
        $css = Cache::remember(self::CACHE_PREFIX . 'css_variables', self::CACHE_TTL, function () {
            $radiusMap = ['none' => '0', 'small' => '4px', 'medium' => '8px', 'large' => '12px', 'full' => '9999px'];
            $shadowMap = [
                'none'   => 'none',
                'subtle' => '0 1px 3px rgba(0,0,0,0.08)',
                'medium' => '0 4px 6px rgba(0,0,0,0.1)',
                'strong' => '0 10px 25px rgba(0,0,0,0.15)',
            ];

            $vars = [
                '--color-primary'       => SiteSetting::get('theme_primary_color', '#1E3A5F'),
                '--color-secondary'     => SiteSetting::get('theme_secondary_color', '#2D5F8A'),
                '--color-accent'        => SiteSetting::get('theme_accent_color', '#F59E0B'),
                '--color-header-bg'     => SiteSetting::get('theme_header_bg', '#0F172A'),
                '--color-header-text'   => SiteSetting::get('theme_header_text', '#F8FAFC'),
                '--color-footer-bg'     => SiteSetting::get('theme_footer_bg', '#1E293B'),
                '--color-footer-text'   => SiteSetting::get('theme_footer_text', '#CBD5E1'),
                '--color-body-bg'       => SiteSetting::get('theme_body_bg', '#FFFFFF'),
                '--color-hero-overlay'  => SiteSetting::get('theme_hero_overlay', '#0F172A'),
                '--hero-overlay-opacity'=> (int) SiteSetting::get('theme_hero_opacity', 60) / 100,
                '--color-cta-bg'        => SiteSetting::get('theme_cta_bg', '#F59E0B'),
                '--color-cta-text'      => SiteSetting::get('theme_cta_text', '#0F172A'),
                '--font-size-base'      => match(SiteSetting::get('theme_font_size', 'md')) {
                    'sm' => '14px', 'lg' => '18px', default => '16px'
                },
                '--radius'              => $radiusMap[SiteSetting::get('theme_border_radius', 'medium')] ?? '8px',
                '--shadow'              => $shadowMap[SiteSetting::get('theme_shadow', 'subtle')] ?? 'none',
            ];

            $lines = array_map(fn($prop, $val) => "  {$prop}: {$val};", array_keys($vars), $vars);
            return ":root {\n" . implode("\n", $lines) . "\n}";
        });

        return new HtmlString("<style>{$css}</style>");
    }

    // ── Google Fonts ─────────────────────────

    public function googleFontsUrl(): string
    {
        $pair = $this->get('theme_font_pair', 'inter_dm_sans');
        $fontsMap = [
            'inter_dm_sans'       => 'Inter:wght@400;500;600;700&family=DM+Sans:wght@400;500;700',
            'plus_jakarta_inter'  => 'Plus+Jakarta+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600',
            'outfit_inter'        => 'Outfit:wght@400;500;600;700&family=Inter:wght@400;500;600',
            'space_grotesk_inter' => 'Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600',
            'inter_merriweather'  => 'Inter:wght@400;500;600;700&family=Merriweather:wght@400;700',
            'poppins_lora'        => 'Poppins:wght@400;500;600;700&family=Lora:wght@400;700',
            'montserrat_roboto'   => 'Montserrat:wght@500;600;700&family=Roboto:wght@400;500',
            'dm_sans_dm_serif'    => 'DM+Sans:wght@400;500;700&family=DM+Serif+Display:wght@400',
        ];
        $families = $fontsMap[$pair] ?? $fontsMap['inter_dm_sans'];
        return "https://fonts.googleapis.com/css2?family={$families}&display=swap";
    }

    // ── Navigation ───────────────────────────

    public function navigation(): array
    {
        return [
            'style'       => $this->get('navigation_style', 'sticky'),
            'sticky'      => (bool) $this->get('navigation_sticky', true),
            'cta_text'    => $this->get('navigation_cta_text', 'Demander un audit'),
            'cta_url'     => $this->get('navigation_cta_url', '/audit'),
            'cta_visible' => (bool) $this->get('navigation_cta_visible', true),
            'show_phone'  => (bool) $this->get('navigation_show_phone', false),
            'phone'       => $this->get('contact_telephone', ''),
        ];
    }

    // ── Réseaux sociaux ──────────────────────

    public function socialLinks(): array
    {
        $socials = $this->getGroup('reseaux_sociaux');
        return collect($socials)
            ->filter(fn($url) => !empty($url) && filter_var($url, FILTER_VALIDATE_URL))
            ->map(fn($url, $key) => ['name' => ucfirst(str_replace('social_', '', $key)), 'url' => $url])
            ->values()
            ->toArray();
    }

    // ── Tracking (conditionné au consentement) ──

    public function trackingScripts(array $consent = []): array
    {
        $head = '';
        $body = '';
        $analyticsOk = $consent['analytics'] ?? false;
        $marketingOk = $consent['marketing'] ?? false;

        if ($analyticsOk && $gtm = $this->get('analytics_gtm_id')) {
            $gtm = e($gtm);
            $head .= "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','{$gtm}');</script>\n";
            $body .= "<noscript><iframe src=\"https://www.googletagmanager.com/ns.html?id={$gtm}\" height=\"0\" width=\"0\" style=\"display:none;visibility:hidden\"></iframe></noscript>\n";
        } elseif ($analyticsOk && $ga = $this->get('analytics_ga4_id')) {
            $ga = e($ga);
            $head .= "<script async src=\"https://www.googletagmanager.com/gtag/js?id={$ga}\"></script>\n<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','{$ga}',{anonymize_ip:true});</script>\n";
        }

        if ($marketingOk && $pixel = $this->get('analytics_pixel_meta')) {
            $pixel = e($pixel);
            $head .= "<script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init','{$pixel}');fbq('track','PageView');</script>\n";
        }

        if ($analyticsOk && $hj = $this->get('analytics_hotjar_id')) {
            $hj = e($hj);
            $head .= "<script>(function(h,o,t,j,a,r){h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};h._hjSettings={hjid:{$hj},hjsv:6};a=o.getElementsByTagName('head')[0];r=o.createElement('script');r.async=1;r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;a.appendChild(r);})(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');</script>\n";
        }

        return ['head' => new HtmlString($head), 'body' => new HtmlString($body)];
    }

    // ── JSON-LD Organization ─────────────────

    public function jsonLd(): HtmlString
    {
        $json = Cache::remember(self::CACHE_PREFIX . 'json_ld', self::CACHE_TTL, function () {
            $schema = [
                '@context'    => 'https://schema.org',
                '@type'       => $this->get('seo_schema_type', 'Organization'),
                'name'        => $this->get('entreprise_nom', 'NeoGTB'),
                'description' => $this->get('entreprise_description', ''),
                'url'         => config('app.url'),
                'contactPoint' => [
                    '@type'     => 'ContactPoint',
                    'telephone' => $this->get('contact_telephone', ''),
                    'email'     => $this->get('contact_email', ''),
                    'contactType' => 'customer service',
                    'availableLanguage' => 'French',
                ],
                'sameAs' => collect($this->socialLinks())->pluck('url')->values()->toArray(),
            ];
            return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        });

        return new HtmlString("<script type=\"application/ld+json\">{$json}</script>");
    }

    // ── Bandeau d'annonce ────────────────────

    public function announcementBar(): ?array
    {
        if (!$this->get('apparence_bandeau_info')) {
            return null;
        }
        return [
            'text'     => $this->get('apparence_bandeau_texte', ''),
            'url'      => $this->get('apparence_bandeau_lien'),
            'bg_color' => $this->get('apparence_bandeau_couleur', '#2563eb'),
        ];
    }

    // ── Invalidation cache calculé ───────────

    public function clearCache(): void
    {
        Cache::forget(self::CACHE_PREFIX . 'css_variables');
        Cache::forget(self::CACHE_PREFIX . 'json_ld');
    }
}
```

### 1.3 Observer unique `SiteSettingObserver`

**Un seul Observer** centralise toute la logique post-save. Remplace le `booted()` du model.

```php
<?php

namespace App\Observers;

use App\Models\SiteSetting;
use App\Models\PrivacyPolicyVersion;
use App\Services\SiteConfigService;

class SiteSettingObserver
{
    public function __construct(protected SiteConfigService $config) {}

    public function saved(SiteSetting $setting): void
    {
        // 1. Invalider cache model + service
        SiteSetting::clearCache();
        $this->config->clearCache();

        // 2. Auto-versioning politique de confidentialité
        if ($setting->key === 'legal_politique_confidentialite' && $setting->isDirty('value')) {
            $latest = PrivacyPolicyVersion::latest('published_at')->first();
            $next = $latest ? $this->incrementVersion($latest->version) : '1.0';

            PrivacyPolicyVersion::create([
                'version'      => $next,
                'content'      => $setting->value,
                'published_at' => now(),
                'is_current'   => true,
            ]);
        }
    }

    public function deleted(SiteSetting $setting): void
    {
        SiteSetting::clearCache();
        $this->config->clearCache();
    }

    private function incrementVersion(string $version): string
    {
        $parts = explode('.', $version);
        $parts[1] = ((int) ($parts[1] ?? 0)) + 1;
        return implode('.', $parts);
    }
}
```

> **IMPORTANT** : Retirer le `booted()` avec `static::saved()` / `static::deleted()` du model `SiteSetting` pour éviter le double clear.

### 1.4 ViewComposer — Injection dans le layout

Utiliser `View::share()` dans le ServiceProvider (appelé une seule fois) plutôt qu'un Composer wildcard `front.*` (qui serait appelé par chaque partial).

```php
// app/Providers/AppServiceProvider.php — boot()

use App\Services\SiteConfigService;

public function boot(): void
{
    $site = app(SiteConfigService::class);
    View::share('site', $site);

    SiteSetting::observe(\App\Observers\SiteSettingObserver::class);
}
```

Usage dans les vues :

```blade
{{-- Layout principal --}}
<link rel="stylesheet" href="{{ $site->googleFontsUrl() }}">
{!! $site->cssVariables() !!}
{!! $site->jsonLd() !!}

{{-- N'importe quelle vue front --}}
<a href="tel:{{ $site->get('contact_telephone') }}">
    {{ $site->get('contact_telephone') }}
</a>
<p>{{ $site->get('entreprise_nom', 'NeoGTB') }}</p>
```

---

## 2. ADMINISTRATION FILAMENT — NOUVEAUX ONGLETS

### 2.1 Onglet `theme` — Identité visuelle

```php
Tab::make('Thème')
    ->icon('heroicon-o-swatch')
    ->schema([

        // Presets rapides (avec confirmation)
        Section::make('Presets de thème')
            ->description('Appliquer un jeu de couleurs prédéfini.')
            ->schema([
                Actions::make([
                    Action::make('preset_gtb_pro')
                        ->label('GTB Pro')
                        ->icon('heroicon-o-building-office-2')
                        ->requiresConfirmation()
                        ->modalDescription('Les couleurs actuelles seront remplacées.')
                        ->action(fn($set) => $this->applyPreset($set, 'gtb_pro')),
                    Action::make('preset_eco_green')
                        ->label('Éco Green')
                        ->icon('heroicon-o-leaf')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn($set) => $this->applyPreset($set, 'eco_green')),
                    Action::make('preset_tech_blue')
                        ->label('Tech Blue')
                        ->icon('heroicon-o-cpu-chip')
                        ->color('info')
                        ->requiresConfirmation()
                        ->action(fn($set) => $this->applyPreset($set, 'tech_blue')),
                ]),
            ]),

        // Couleurs principales (3 colonnes)
        Section::make('Couleurs principales')->columns(3)->schema([
            ColorPicker::make('theme_primary_color')->label('Primaire')->required(),
            ColorPicker::make('theme_secondary_color')->label('Secondaire')->required(),
            ColorPicker::make('theme_accent_color')->label('Accent')->required(),
        ]),

        // Header & Footer (2 colonnes)
        Section::make('Header & Footer')->columns(2)->schema([
            ColorPicker::make('theme_header_bg')->label('Fond header'),
            ColorPicker::make('theme_header_text')->label('Texte header'),
            ColorPicker::make('theme_footer_bg')->label('Fond footer'),
            ColorPicker::make('theme_footer_text')->label('Texte footer'),
        ]),

        // Corps & Hero (3 colonnes)
        Section::make('Corps & Hero')->columns(3)->schema([
            ColorPicker::make('theme_body_bg')->label('Fond body'),
            ColorPicker::make('theme_hero_overlay')->label('Overlay hero'),
            TextInput::make('theme_hero_opacity')
                ->label('Opacité hero (%)')
                ->numeric()->minValue(0)->maxValue(100)->suffix('%'),
        ]),

        // Boutons CTA (2 colonnes)
        Section::make('Boutons CTA')->columns(2)->schema([
            ColorPicker::make('theme_cta_bg')->label('Fond CTA'),
            ColorPicker::make('theme_cta_text')->label('Texte CTA'),
        ]),

        // Typographie & Forme (2 colonnes)
        Section::make('Typographie & Forme')
            ->description('Police, taille de base et arrondi des composants.')
            ->columns(2)
            ->schema([
                Select::make('theme_font_pair')
                    ->label('Paire de polices')
                    ->options([
                        'inter_dm_sans'       => 'Inter + DM Sans',
                        'inter_merriweather'  => 'Inter + Merriweather',
                        'poppins_lora'        => 'Poppins + Lora',
                        'montserrat_roboto'   => 'Montserrat + Roboto',
                        'dm_sans_dm_serif'    => 'DM Sans + DM Serif',
                        'plus_jakarta_inter'  => 'Plus Jakarta + Inter',
                        'outfit_inter'        => 'Outfit + Inter',
                        'space_grotesk_inter' => 'Space Grotesk + Inter',
                    ]),
                Select::make('theme_font_size')
                    ->label('Taille de base')
                    ->options(['sm' => 'Petite (14px)', 'md' => 'Moyenne (16px)', 'lg' => 'Grande (18px)']),
                Select::make('theme_border_radius')
                    ->label('Arrondi des coins')
                    ->options(['none' => 'Aucun', 'small' => 'Léger (4px)', 'medium' => 'Moyen (8px)', 'large' => 'Prononcé (12px)', 'full' => 'Complet']),
                Select::make('theme_shadow')
                    ->label('Ombres')
                    ->options(['none' => 'Aucune', 'subtle' => 'Subtile', 'medium' => 'Moyenne', 'strong' => 'Prononcée']),
            ]),

        // Preview live (Alpine.js + $wire.data)
        Section::make('Aperçu en direct')->schema([
            ViewField::make('theme_preview')
                ->view('filament.forms.components.theme-preview'),
        ]),
    ]),
```

### 2.2 Onglet `legal` — Textes juridiques

```php
Tab::make('Juridique')
    ->icon('heroicon-o-scale')
    ->schema([
        Section::make('Mentions légales')
            ->description('Obligatoires (LCEN). Éditeur, hébergeur, directeur de publication.')
            ->schema([
                RichEditor::make('legal_mentions_legales')
                    ->toolbarButtons(['bold','italic','underline','h2','h3','bulletList','orderedList','link'])
                    ->columnSpanFull(),
            ]),
        Section::make('Politique de confidentialité')
            ->description('RGPD Art. 13 & 14. La modification crée automatiquement une nouvelle version.')
            ->schema([
                RichEditor::make('legal_politique_confidentialite')
                    ->toolbarButtons(['bold','italic','underline','h2','h3','bulletList','orderedList','link'])
                    ->columnSpanFull(),
            ]),
        Section::make('CGU')->schema([
            RichEditor::make('legal_cgu')->columnSpanFull(),
        ]),
        Section::make('Politique de cookies')->schema([
            RichEditor::make('legal_politique_cookies')->columnSpanFull(),
        ]),
    ]),
```

### 2.3 Onglet `navigation`

```php
Tab::make('Navigation')
    ->icon('heroicon-o-bars-3')
    ->schema([
        Section::make('Style')->columns(2)->schema([
            Select::make('navigation_style')
                ->options(['sticky' => 'Sticky', 'transparent' => 'Transparent', 'solid' => 'Fond solide']),
            Toggle::make('navigation_sticky')->label('Sticky au scroll'),
        ]),
        Section::make('Bouton CTA header')->columns(2)->schema([
            Toggle::make('navigation_cta_visible')->label('Afficher le CTA')->reactive(),
            TextInput::make('navigation_cta_text')
                ->maxLength(40)
                ->visible(fn($get) => $get('navigation_cta_visible')),
            TextInput::make('navigation_cta_url')
                ->visible(fn($get) => $get('navigation_cta_visible')),
        ]),
        Section::make('Téléphone')->schema([
            Toggle::make('navigation_show_phone')
                ->label('Afficher le numéro dans le header')
                ->helperText('Utilise le numéro défini dans l\'onglet Contact.'),
        ]),
    ]),
```

### 2.4 Onglet `email`

```php
Tab::make('Email')
    ->icon('heroicon-o-envelope')
    ->schema([
        Section::make('Expéditeur')->columns(2)->schema([
            TextInput::make('email_from_name')->required(),
            TextInput::make('email_from_address')->email()->required(),
        ]),
        Section::make('Notifications admin')->schema([
            TextInput::make('email_notification_to')->email()->required(),
            TextInput::make('email_notification_cc')->email(),
        ]),
        Section::make('Test')->schema([
            Actions::make([
                Action::make('send_test_email')
                    ->label('Envoyer un email de test')
                    ->icon('heroicon-o-paper-airplane')
                    ->requiresConfirmation()
                    ->action(fn() => $this->sendTestEmail()),
            ]),
        ]),
    ]),
```

### 2.5 Presets thème — Valeurs

Stockés dans `config/neogtb.php` :

```php
return [
    'presets' => [
        'gtb_pro' => [
            'theme_primary_color' => '#1E3A5F', 'theme_secondary_color' => '#2D5F8A',
            'theme_accent_color' => '#F59E0B', 'theme_header_bg' => '#0F172A',
            'theme_header_text' => '#F8FAFC', 'theme_footer_bg' => '#1E293B',
            'theme_footer_text' => '#CBD5E1', 'theme_body_bg' => '#FFFFFF',
            'theme_hero_overlay' => '#0F172A', 'theme_hero_opacity' => 60,
            'theme_cta_bg' => '#F59E0B', 'theme_cta_text' => '#0F172A',
        ],
        'eco_green' => [
            'theme_primary_color' => '#065F46', 'theme_secondary_color' => '#10B981',
            'theme_accent_color' => '#F59E0B', 'theme_header_bg' => '#064E3B',
            'theme_header_text' => '#ECFDF5', 'theme_footer_bg' => '#065F46',
            'theme_footer_text' => '#A7F3D0', 'theme_body_bg' => '#F0FDF4',
            'theme_hero_overlay' => '#064E3B', 'theme_hero_opacity' => 50,
            'theme_cta_bg' => '#10B981', 'theme_cta_text' => '#FFFFFF',
        ],
        'tech_blue' => [
            'theme_primary_color' => '#2563EB', 'theme_secondary_color' => '#3B82F6',
            'theme_accent_color' => '#06B6D4', 'theme_header_bg' => '#1E1B4B',
            'theme_header_text' => '#E0E7FF', 'theme_footer_bg' => '#1E1B4B',
            'theme_footer_text' => '#C7D2FE', 'theme_body_bg' => '#F8FAFC',
            'theme_hero_overlay' => '#1E1B4B', 'theme_hero_opacity' => 55,
            'theme_cta_bg' => '#2563EB', 'theme_cta_text' => '#FFFFFF',
        ],
    ],
];
```

---

## 3. BRICKS & PAGES — CONTENU 100% DYNAMIQUE

### 3.1 Principe

Chaque page est une composition ordonnée de bricks chargées depuis `page_bricks`. Les vues Blade ne contiennent que de la logique d'affichage — jamais de contenu en dur.

### 3.2 Structure JSON par brick

Chaque brick a deux colonnes JSON :
- **`content`** : données affichées (textes, images, liens, items)
- **`settings`** : options visuelles (couleur fond, padding, animation)

#### Settings communs (tous types)

```json
{
  "bg_color": "white",
  "padding_y": "lg",
  "max_width": "7xl",
  "animation": null,
  "anchor_id": null,
  "css_class": null,
  "dark_mode": false
}
```

#### Schémas des bricks principaux

**Hero** :
```json
{
  "title": "La GTB au service de la performance énergétique",
  "subtitle": "Gestion Technique du Bâtiment",
  "description": "Découvrez comment la GTB optimise la consommation énergétique.",
  "cta_primary": { "text": "Demander un audit", "url": "/audit" },
  "cta_secondary": { "text": "En savoir plus", "url": "/gtb" },
  "image": "pages/hero-gtb.webp",
  "image_alt": "Tableau de bord GTB"
}
```

**FAQ** :
```json
{
  "title": "Questions fréquentes sur la GTB",
  "items": [
    { "question": "Quelle différence entre GTB et GTC ?", "answer": "La GTB couvre..." },
    { "question": "Quel est le ROI moyen ?", "answer": "Entre 3 et 5 ans..." }
  ]
}
```

**Chiffres** :
```json
{
  "title": "La GTB en chiffres",
  "items": [
    { "value": "40", "suffix": "%", "label": "d'économies d'énergie" },
    { "value": "3", "suffix": " ans", "label": "de retour sur investissement" }
  ]
}
```

**Cartes**, **Comparatif**, **Témoignages**, **CTA** : mêmes patterns (title + items[] ou champs directs).

### 3.3 Renderer central

```blade
{{-- resources/views/front/bricks/_renderer.blade.php --}}
@php
    $content = is_array($brick->content) ? $brick->content : json_decode($brick->content, true) ?? [];
    $settings = is_array($brick->settings) ? $brick->settings : json_decode($brick->settings, true) ?? [];
    $viewName = 'front.bricks.' . $brick->brick_type;
@endphp

@if(view()->exists($viewName))
    <section
        @if($settings['anchor_id'] ?? false) id="{{ $settings['anchor_id'] }}" @endif
        class="brick brick--{{ $brick->brick_type }}"
    >
        @include($viewName, ['content' => $content, 'settings' => $settings])
    </section>
@endif
```

> **Sécurité** : les champs texte utilisent `{{ }}` (échappement). Seuls les champs explicitement HTML (RichEditor) utilisent `{!! !!}`.

### 3.4 Pages standard vs pages spéciales

**Pages standard** (100% bricks) : `/`, `/gtb`, `/gtc`, `/solutions`, `/reglementation`, `/about`, `/faq`, `/contact`

```php
// PageController — vue générique
$bricks = $page->bricks()->where('is_visible', true)->orderBy('order')->get();
return view('front.page', compact('page', 'bricks'));
```

**Pages spéciales** (vue dédiée + bricks hero/CTA) : `/audit`, `/comparateur`, `/generateur-cee`, `/tables-modbus`

```blade
{{-- front/audit.blade.php --}}
@foreach($topBricks as $brick)
    @include('front.bricks._renderer', ['brick' => $brick])
@endforeach

<section id="audit-wizard">
    @livewire('audit-wizard')
</section>

@foreach($bottomBricks as $brick)
    @include('front.bricks._renderer', ['brick' => $brick])
@endforeach
```

Le `WizardPlaceholder` brick sert de marqueur d'ordre — il sépare les bricks "avant" et "après" le contenu spécial.

---

## 4. SEO, TRACKING, RGPD & TEXTES LÉGAUX

### 4.1 SEO — Cascade meta tags

```
Meta spécifique (SitePage.meta_title / Post.meta_title)
  → Settings globaux (seo_meta_title_defaut)
    → Fallback hardcodé ('NeoGTB')
```

```php
// app/Helpers/SeoHelper.php
class SeoHelper
{
    public static function metaForPage(?object $page, array $defaults = []): array
    {
        return [
            'title'       => $page?->meta_title ?: SiteSetting::get('seo_meta_title_defaut', $defaults['title'] ?? 'NeoGTB'),
            'description' => $page?->meta_description ?: SiteSetting::get('seo_meta_description_defaut', ''),
            'og_image'    => $page?->og_image ?? SiteSetting::get('seo_og_image_defaut'),
            'canonical'   => url()->current(),
        ];
    }
}
```

### 4.2 Schema.org

| Type | Page | Injection |
|------|------|-----------|
| Organization | Toutes (layout) | `$site->jsonLd()` |
| Article | Blog show | `@push('schema')` dans la vue article |
| FAQPage | Bricks FAQ (si `settings.schema_org = true`) | `@push('schema')` dans `bricks/faq.blade.php` |
| BreadcrumbList | Toutes sauf accueil | `BreadcrumbComposer` automatique |

### 4.3 Breadcrumbs automatiques

```php
// app/View/Composers/BreadcrumbComposer.php
// config/breadcrumbs.php — labels par segment :
// 'gtb' => "Qu'est-ce que la GTB ?", 'gtc' => "Qu'est-ce que la GTC ?", etc.
```

### 4.4 Canonical domain (.com → .fr)

```php
// app/Http/Middleware/ForceCanonicalDomain.php
// Redirige 301 .com → .fr en production uniquement
// Conditionné à app()->isProduction() + config('neogtb.canonical_domain')
```

### 4.5 Tracking conditionnel

Les scripts sont injectés uniquement si le consentement est donné :

```blade
{{-- Dans le layout, les scripts sont injectés côté serveur --}}
@php $consent = App\Helpers\ConsentHelper::get(); @endphp
@php $tracking = $site->trackingScripts($consent); @endphp
{!! $tracking['head'] !!}
```

Après consentement via le bandeau cookie (Alpine.js), la page est rechargée pour que les scripts soient injectés au prochain rendu Blade.

### 4.6 RGPD — Flow complet

```
Visiteur arrive → Cookie consent existe ?
  NON → Bandeau cookie (Alpine.js)
    → Accepter / Configurer / Refuser
      → Cookie JSON (13 mois) + POST /rgpd/consent → CookieConsent model
        → Reload → Scripts injectés selon consentement
  OUI → Lire préférences → Injecter scripts autorisés
```

**Droits visiteur** : accès, rectification, suppression, portabilité, opposition → `GdprRequest` → traitement admin dans `RgpdDashboardPage`

### 4.7 Purge automatique RGPD

```php
// app/Console/Commands/PurgeExpiredDataCommand.php
// Durées configurables dans site_settings (groupe rgpd)
// Avec minimum en dur : max(config('neogtb.rgpd_min_retention'), $settingValue)
// Supporte --dry-run
// Schedule::command('rgpd:purge-expired')->dailyAt('03:00');
```

### 4.8 Textes légaux administrables

Routes : `/mentions-legales`, `/politique-de-confidentialite`, `/cgu`, `/cookies`

Contenu lu depuis `SiteSetting::get('legal_mentions_legales')` etc. → vue générique `front/legal.blade.php`. Versioning automatique de la politique de confidentialité via l'Observer.

---

## 5. CONVENTIONS & CHECKLIST

### 5.1 Checklist avant chaque merge

#### Contenu & Bricks
- [ ] Aucun contenu de page hardcodé dans les Blade front (tout via bricks)
- [ ] Fallback propre si le JSON brick est vide/malformé

#### Couleurs & Thème
- [ ] Aucune couleur hex en dur dans les vues front → `var(--color-primary)` etc.
- [ ] Classes Tailwind neutres OK (`bg-white`, `text-gray-600`)

#### Données entreprise
- [ ] Aucun email/téléphone/adresse en dur → `$site->get('contact_*')`
- [ ] Aucune info entreprise en dur → `$site->get('entreprise_*')`

#### SEO & Meta
- [ ] Meta title/description sur chaque page (fallback global)
- [ ] Canonical URL présente
- [ ] Schema.org JSON-LD (Organization global + Article/FAQ contextuel)

#### Sécurité & RGPD
- [ ] PII chiffrées sur les nouveaux modèles (`'email' => 'encrypted'`)
- [ ] Rate limiting sur les endpoints publics
- [ ] Scripts tracking conditionnés au consentement cookie
- [ ] CSRF sur tous les formulaires

#### Code quality
- [ ] Pas de `dd()` / `dump()` oubliés
- [ ] Nouveaux champs texte Blade : `{{ }}` par défaut, `{!! !!}` seulement si HTML explicite

### 5.2 Conventions de nommage

| Élément | Convention | Exemple |
|---------|-----------|---------|
| Clé settings | `groupe_nom` snake_case | `theme_primary_color` |
| Classe Brick | PascalCase | `BrickHero` |
| Vue Blade brick | kebab-case | `front.bricks.hero` |
| Commit git | `type(scope): desc` en FR | `feat(front): ajout brick timeline` |
| Route front | préfixe `front.` | `front.gtb`, `front.blog.show` |

### 5.3 CSS — Stratégie couleurs

```css
/* Injecté par $site->cssVariables() */
:root {
    --color-primary: #1E3A5F;
    --color-accent: #F59E0B;
    /* ... 15 variables au total */
}
```

```blade
{{-- Couleurs thème via CSS variables --}}
<div class="bg-[var(--color-primary)] text-white">...</div>
<button class="bg-[var(--color-cta-bg)] text-[var(--color-cta-text)]">CTA</button>

{{-- Tailwind utilitaire OK pour les neutres --}}
<div class="bg-white text-gray-800 border-slate-200">...</div>
```

### 5.4 Fichiers à créer / modifier

| Fichier | Action |
|---------|--------|
| `app/Services/SiteConfigService.php` | Créer |
| `app/Observers/SiteSettingObserver.php` | Créer |
| `app/Helpers/SeoHelper.php` | Créer |
| `app/Helpers/ConsentHelper.php` | Créer |
| `app/View/Composers/BreadcrumbComposer.php` | Créer |
| `app/Http/Middleware/ForceCanonicalDomain.php` | Créer |
| `app/Console/Commands/PurgeExpiredDataCommand.php` | Créer |
| `config/neogtb.php` | Créer |
| `config/breadcrumbs.php` | Créer |
| `database/migrations/xxxx_add_theme_legal_nav_email_rgpd_settings.php` | Créer |
| `database/seeders/SiteSettingsSeeder.php` | Modifier (ajouter 34 clés) |
| `app/Models/SiteSetting.php` | Modifier (retirer booted clearCache) |
| `app/Filament/Pages/SiteSettingsPage.php` | Modifier (4 onglets) |
| `app/Providers/AppServiceProvider.php` | Modifier (View::share + Observer) |
| `resources/views/front/layouts/app.blade.php` | Modifier (CSS vars, tracking, JSON-LD) |

### 5.5 Commandes post-installation

```bash
php artisan migrate
php artisan db:seed --class=SiteSettingsSeeder
php artisan cache:clear
php artisan config:clear
```

---

## PRINCIPE FONDAMENTAL

> **Si un administrateur ne peut pas modifier le contenu visible depuis le panel Filament, c'est un bug.**
>
> Le code ne contient que de la logique (conditions, boucles, calculs). Le contenu vient des bricks et des settings. Les structures techniques restent dans le code — c'est pragmatique, pas dogmatique.
