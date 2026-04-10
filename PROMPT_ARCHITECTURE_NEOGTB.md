# Prompt — Architecture NeoGTB 100% Base de Données

> Ce prompt doit etre donné à un LLM (Claude, GPT, etc.) pour implémenter l'architecture "zéro hardcode" sur le projet NeoGTB.
> Objectif : ZERO contenu hardcodé. Tout est administrable depuis le panel admin Filament.
> Stack : **Laravel 12 + Filament 3 + Livewire + Tailwind CSS + SQLite**

---

## CONTEXTE

Tu vas construire un site éducatif et vitrine sur la GTB/GTC (Gestion Technique du Bâtiment) avec la stack **Laravel 12 + Filament 3 + Livewire + Tailwind CSS + SQLite**.

**Domaine** : neogtb.fr / neogtb.com
**Objectif** : Éduquer sur la GTB/GTC, proposer des audits énergétiques, générer des leads (audit GTB, CEE)

**Règle absolue : RIEN ne doit être codé en dur.** Tout texte, toute couleur, tout label, toute configuration doit être stocké en base de données et modifiable depuis le panel d'administration Filament, sans toucher au code source.

Cela inclut :
- Textes d'interface (boutons, labels de formulaires, placeholders, messages de validation)
- Textes légaux (CGU, mentions légales, politique de confidentialité, cookie consent)
- Contenus de pages (titres, descriptions, FAQ, témoignages, chiffres clés, etc.)
- Statuts et workflows (labels, couleurs, icônes de chaque statut)
- Configuration visuelle (couleurs, polices, bordures, ombres)
- Navigation et menus
- SEO et tracking
- Données de référence (catégories blog, protocoles GTB, niveaux EN 15232)

---

## ARCHITECTURE GLOBALE

### 1. Table centrale : `general_settings`

Créer une table `general_settings` qui centralise TOUTE la configuration du site. C'est le coeur du système.

**Structure de la migration initiale :**

```php
Schema::create('general_settings', function (Blueprint $table) {
    $table->id();

    // ═══════════════════════════════════════════
    // IDENTITÉ ENTREPRISE
    // ═══════════════════════════════════════════
    $table->string('company_name', 100)->default('NeoGTB');
    $table->string('company_tagline')->nullable();               // "La GTB au service de la performance énergétique"
    $table->string('company_logo')->nullable();                  // path Storage
    $table->string('company_logo_white')->nullable();            // version claire
    $table->string('company_logo_icon')->nullable();             // version carrée mobile
    $table->string('company_email')->nullable();
    $table->string('company_phone')->nullable();
    $table->text('company_address')->nullable();
    $table->string('company_city')->nullable();
    $table->string('company_postal_code', 10)->nullable();
    $table->string('company_siret', 20)->nullable();
    $table->string('company_siren', 20)->nullable();
    $table->string('company_legal_form')->nullable();            // SAS, SARL, etc.
    $table->string('company_ape')->nullable();
    $table->string('company_tva_number')->nullable();
    $table->string('company_rcs')->nullable();
    $table->string('company_capital')->nullable();
    $table->string('company_website')->nullable();
    $table->string('legal_representative_name')->nullable();
    $table->string('legal_representative_title')->nullable();
    $table->text('company_description')->nullable();             // description footer
    $table->integer('company_founding_year')->nullable();
    $table->json('company_opening_hours')->nullable();           // [{day, hours}]

    // ═══════════════════════════════════════════
    // RÉSEAUX SOCIAUX
    // ═══════════════════════════════════════════
    $table->string('company_facebook_url')->nullable();
    $table->string('company_linkedin_url')->nullable();
    $table->string('company_youtube_url')->nullable();
    $table->string('company_instagram_url')->nullable();
    $table->string('company_twitter_url')->nullable();

    // ═══════════════════════════════════════════
    // THÈME & APPARENCE
    // ═══════════════════════════════════════════
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
    $table->string('font_pair')->default('modern');              // clé vers FontPairRegistry
    $table->string('font_size_base')->default('md');             // sm, md, lg
    $table->string('border_radius_style')->default('medium');    // none, small, medium, large, full
    $table->string('shadow_style')->default('subtle');           // none, subtle, medium, strong

    // ═══════════════════════════════════════════
    // IMAGES & HERO
    // ═══════════════════════════════════════════
    $table->string('favicon')->nullable();
    $table->string('og_default_image')->nullable();              // Open Graph par défaut
    $table->string('hero_default_image')->nullable();
    $table->string('hero_style')->default('static');             // static, gradient, animated
    $table->string('hero_title_line1')->nullable();              // "La GTB au service"
    $table->string('hero_title_line2')->nullable();              // "de la performance énergétique"
    $table->json('client_logos')->nullable();                    // logos partenaires/clients

    // ═══════════════════════════════════════════
    // NAVIGATION
    // ═══════════════════════════════════════════
    $table->json('nav_items')->nullable();                       // [{label, url, type, icon, visible, children}]
    $table->string('nav_cta_text')->nullable();                  // "Demander un audit"
    $table->string('nav_cta_url')->nullable();                   // "/audit"
    $table->boolean('nav_cta_visible')->default(true);
    $table->boolean('nav_show_phone')->default(false);
    $table->string('nav_style')->default('sticky');              // sticky, static, transparent

    // ═══════════════════════════════════════════
    // HOMEPAGE — SECTIONS
    // ═══════════════════════════════════════════
    $table->json('homepage_sections')->nullable();               // ['hero','expertises_gtb','chiffres_cles',...] — ordre des sections
    $table->json('homepage_sections_config')->nullable();        // {section_name: {title, subtitle, items, ...}}

    // ═══════════════════════════════════════════
    // PAGES — CONFIG PAR PAGE
    // ═══════════════════════════════════════════
    $table->json('gtb_page_config')->nullable();                 // Page "Qu'est-ce que la GTB ?"
    $table->json('gtc_page_config')->nullable();                 // Page "Qu'est-ce que la GTC ?"
    $table->json('solutions_page_config')->nullable();           // Page Solutions & Technologies
    $table->json('reglementation_page_config')->nullable();      // Page Réglementation (RE2020, décret tertiaire)
    $table->json('audit_page_config')->nullable();               // Page Audit GTB
    $table->json('about_page_config')->nullable();               // Page À propos
    $table->json('contact_page_config')->nullable();             // Page Contact
    $table->json('faq_page_config')->nullable();                 // Page FAQ
    $table->json('comparateur_page_config')->nullable();         // Page Comparateur GTB

    // ═══════════════════════════════════════════
    // CATALOGUES & REGISTRES (en BDD, pas en code)
    // ═══════════════════════════════════════════
    $table->json('blog_categories_config')->nullable();          // [{slug, label, icon, color, description}]
    $table->json('gtb_protocols_config')->nullable();            // [{slug, label, description}] — BACnet, KNX, Modbus, LON, etc.
    $table->json('en15232_levels_config')->nullable();           // [{key, label, description, color}] — Classes A, B, C, D
    $table->json('font_pairs_config')->nullable();               // [{key, label, heading, body, weights, google_url}]

    // ═══════════════════════════════════════════
    // LABELS D'INTERFACE (UI STRINGS)
    // ═══════════════════════════════════════════
    // Tout texte visible par l'utilisateur final
    $table->json('ui_labels')->nullable();
    // Structure attendue :
    // {
    //   "forms": {
    //     "name": "Nom",
    //     "email": "Email",
    //     "phone": "Téléphone",
    //     "company": "Entreprise",
    //     "building_type": "Type de bâtiment",
    //     "surface": "Surface (m²)",
    //     "message": "Message",
    //     "submit": "Envoyer",
    //     "required_fields": "Les champs marqués d'un * sont obligatoires",
    //     "success_message": "Votre message a bien été envoyé",
    //     "error_message": "Une erreur est survenue, veuillez réessayer",
    //     ...
    //   },
    //   "audit": {
    //     "step1_title": "Votre bâtiment",
    //     "step2_title": "Vos équipements",
    //     "step3_title": "Vos objectifs",
    //     "step4_title": "Vos coordonnées",
    //     "next": "Suivant",
    //     "previous": "Précédent",
    //     "submit": "Recevoir mon diagnostic",
    //     "success": "Votre demande d'audit a bien été envoyée !",
    //     ...
    //   },
    //   "newsletter": {
    //     "title": "Restez informé",
    //     "placeholder": "Votre adresse email",
    //     "subscribe": "S'inscrire",
    //     "success": "Inscription confirmée !",
    //     "already_subscribed": "Vous êtes déjà inscrit",
    //     ...
    //   },
    //   "header": {
    //     "breadcrumb_label": "Fil d'Ariane",
    //     "skip_to_content": "Aller au contenu",
    //     ...
    //   },
    //   "footer": {
    //     "col1_title": "GTB/GTC",
    //     "col2_title": "Ressources",
    //     "col3_title": "Services",
    //     "col4_title": "À propos",
    //     "copyright_prefix": "©",
    //     ...
    //   },
    //   "cta": {
    //     "pre_footer_title": "Optimisez la performance énergétique de votre bâtiment",
    //     "pre_footer_subtitle": "Demandez un audit GTB gratuit et sans engagement",
    //     "pre_footer_button": "Demander un audit gratuit",
    //     "diagnostic_cta": "Diagnostic GTB gratuit",
    //     "contact_us": "Nous contacter",
    //     "download_guide": "Télécharger le guide",
    //     ...
    //   },
    //   "cookie": {
    //     "title": "Gestion des cookies",
    //     "description": "Nous utilisons des cookies pour améliorer votre expérience de navigation et analyser notre trafic.",
    //     "accept": "Tout accepter",
    //     "reject": "Tout refuser",
    //     "customize": "Personnaliser",
    //     "save_preferences": "Enregistrer mes préférences",
    //     "necessary_title": "Cookies nécessaires",
    //     "necessary_desc": "Ces cookies sont indispensables au fonctionnement du site.",
    //     "analytics_title": "Cookies analytiques",
    //     "analytics_desc": "Ces cookies nous permettent de mesurer l'audience du site.",
    //     "marketing_title": "Cookies marketing",
    //     "marketing_desc": "Ces cookies sont utilisés pour vous proposer des publicités pertinentes.",
    //     ...
    //   },
    //   "validation": {
    //     "required": "Ce champ est obligatoire",
    //     "email_invalid": "L'adresse email n'est pas valide",
    //     "phone_invalid": "Le numéro de téléphone n'est pas valide",
    //     "min_length": "Ce champ doit contenir au moins :min caractères",
    //     "max_length": "Ce champ ne doit pas dépasser :max caractères",
    //     ...
    //   },
    //   "pagination": {
    //     "previous": "Précédent",
    //     "next": "Suivant",
    //     "showing": "Affichage de",
    //     "to": "à",
    //     "of": "sur",
    //     "results": "résultats",
    //     ...
    //   },
    //   "blog": {
    //     "read_more": "Lire la suite",
    //     "reading_time": "min de lecture",
    //     "published_on": "Publié le",
    //     "by_author": "Par",
    //     "all_articles": "Tous les articles",
    //     "related_articles": "Articles similaires",
    //     "share": "Partager cet article",
    //     "categories": "Catégories",
    //     "tags": "Mots-clés",
    //     "no_articles": "Aucun article trouvé",
    //     "search_placeholder": "Rechercher un article...",
    //     ...
    //   },
    //   "misc": {
    //     "loading": "Chargement...",
    //     "no_data": "Aucune donnée disponible",
    //     "back": "Retour",
    //     "close": "Fermer",
    //     "confirm": "Confirmer",
    //     "more": "En savoir plus",
    //     "share": "Partager",
    //     "print": "Imprimer",
    //     ...
    //   }
    // }

    // ═══════════════════════════════════════════
    // STATUTS & WORKFLOWS (en BDD, pas en enums)
    // ═══════════════════════════════════════════
    $table->json('status_configs')->nullable();
    // Structure attendue :
    // {
    //   "blog_post": [
    //     {"key": "draft", "label": "Brouillon", "color": "gray", "icon": "heroicon-o-pencil"},
    //     {"key": "published", "label": "Publié", "color": "success", "icon": "heroicon-o-check-circle"},
    //     {"key": "archived", "label": "Archivé", "color": "warning", "icon": "heroicon-o-archive-box"}
    //   ],
    //   "audit_lead": [
    //     {"key": "new", "label": "Nouveau", "color": "info", "icon": "heroicon-o-sparkles"},
    //     {"key": "contacted", "label": "Contacté", "color": "primary", "icon": "heroicon-o-phone"},
    //     {"key": "qualified", "label": "Qualifié", "color": "warning", "icon": "heroicon-o-star"},
    //     {"key": "converted", "label": "Converti", "color": "success", "icon": "heroicon-o-check-badge"},
    //     {"key": "lost", "label": "Perdu", "color": "danger", "icon": "heroicon-o-x-circle"}
    //   ],
    //   "cee_lead": [
    //     {"key": "new", "label": "Nouveau", "color": "info", "icon": "heroicon-o-sparkles"},
    //     {"key": "processing", "label": "En traitement", "color": "warning", "icon": "heroicon-o-cog-6-tooth"},
    //     {"key": "sent", "label": "Dossier envoyé", "color": "primary", "icon": "heroicon-o-paper-airplane"},
    //     {"key": "signed", "label": "Signé", "color": "success", "icon": "heroicon-o-check-badge"}
    //   ],
    //   "contact_message": [
    //     {"key": "new", "label": "Nouveau", "color": "info", "icon": "heroicon-o-envelope"},
    //     {"key": "read", "label": "Lu", "color": "primary", "icon": "heroicon-o-envelope-open"},
    //     {"key": "replied", "label": "Répondu", "color": "success", "icon": "heroicon-o-chat-bubble-left-right"},
    //     {"key": "archived", "label": "Archivé", "color": "gray", "icon": "heroicon-o-archive-box"}
    //   ],
    //   "gdpr_request": [
    //     {"key": "pending", "label": "En attente", "color": "warning", "icon": "heroicon-o-clock"},
    //     {"key": "processing", "label": "En traitement", "color": "info", "icon": "heroicon-o-cog-6-tooth"},
    //     {"key": "completed", "label": "Traitée", "color": "success", "icon": "heroicon-o-check-circle"},
    //     {"key": "rejected", "label": "Rejetée", "color": "danger", "icon": "heroicon-o-x-circle"}
    //   ]
    // }

    // ═══════════════════════════════════════════
    // TEXTES LÉGAUX (en BDD, pas en blade)
    // ═══════════════════════════════════════════
    $table->json('legal_texts')->nullable();
    // Structure :
    // {
    //   "cookie_consent": {
    //     "title": "Gestion des cookies",
    //     "description": "Nous utilisons des cookies...",
    //     "accept_button": "Tout accepter",
    //     "reject_button": "Tout refuser",
    //     "customize_button": "Personnaliser",
    //     "categories": [
    //       {"key": "necessary", "label": "Cookies nécessaires", "description": "Indispensables au fonctionnement du site.", "required": true},
    //       {"key": "analytics", "label": "Cookies analytiques", "description": "Mesure d'audience et statistiques."},
    //       {"key": "marketing", "label": "Cookies marketing", "description": "Publicités personnalisées."}
    //     ]
    //   },
    //   "mentions_legales": "<h1>Mentions légales</h1><p>...</p>",
    //   "politique_confidentialite": "<h1>Politique de confidentialité</h1><p>...</p>",
    //   "cgu": "<h1>Conditions Générales d'Utilisation</h1><p>...</p>",
    //   "politique_cookies": "<h1>Politique de cookies</h1><p>...</p>"
    // }

    // ═══════════════════════════════════════════
    // STATISTIQUES (chiffres clés du site)
    // ═══════════════════════════════════════════
    $table->integer('stat_buildings_audited')->nullable();       // Bâtiments audités
    $table->boolean('stat_buildings_auto')->default(false);      // Calculé auto depuis audit_leads
    $table->integer('stat_energy_savings_percent')->nullable();  // Économies moyennes (%)
    $table->integer('stat_years_experience')->nullable();        // Années d'expertise
    $table->integer('stat_clients_count')->nullable();           // Clients accompagnés
    $table->boolean('stat_clients_auto')->default(false);        // Calculé auto depuis leads convertis

    // ═══════════════════════════════════════════
    // ANNONCE BANDEAU
    // ═══════════════════════════════════════════
    $table->boolean('announcement_enabled')->default(false);
    $table->text('announcement_text')->nullable();
    $table->string('announcement_url')->nullable();
    $table->string('announcement_bg_color', 7)->default('#2563EB');
    $table->string('announcement_text_color', 7)->default('#FFFFFF');
    $table->boolean('announcement_dismissable')->default(true);

    // ═══════════════════════════════════════════
    // SEO
    // ═══════════════════════════════════════════
    $table->string('seo_title_suffix')->nullable();              // " | NeoGTB"
    $table->text('seo_default_description')->nullable();
    $table->string('seo_robots')->default('index');
    $table->string('seo_google_verification')->nullable();
    $table->string('seo_schema_type')->default('Organization');
    $table->string('seo_canonical_domain')->nullable();          // "neogtb.fr" (.com → .fr redirect)

    // ═══════════════════════════════════════════
    // TRACKING & ANALYTICS
    // ═══════════════════════════════════════════
    $table->string('google_analytics_id')->nullable();
    $table->string('google_tag_manager_id')->nullable();
    $table->string('facebook_pixel_id')->nullable();
    $table->string('hotjar_id')->nullable();
    $table->string('google_maps_api_key')->nullable();
    $table->string('google_place_id')->nullable();

    // ═══════════════════════════════════════════
    // MAINTENANCE
    // ═══════════════════════════════════════════
    $table->boolean('maintenance_enabled')->default(false);
    $table->text('maintenance_message')->nullable();
    $table->json('maintenance_allowed_ips')->nullable();
    $table->text('custom_head_code')->nullable();
    $table->text('custom_body_code')->nullable();

    // ═══════════════════════════════════════════
    // EMAIL
    // ═══════════════════════════════════════════
    $table->string('email_from_name')->default('NeoGTB');
    $table->string('email_from_address')->nullable();            // contact@neogtb.fr
    $table->string('email_notification_to')->nullable();         // admin email
    $table->string('email_notification_cc')->nullable();

    // ═══════════════════════════════════════════
    // RGPD — RÉTENTION DONNÉES
    // ═══════════════════════════════════════════
    $table->integer('rgpd_retention_contacts_days')->default(730);       // 2 ans
    $table->integer('rgpd_retention_leads_days')->default(1095);         // 3 ans
    $table->integer('rgpd_retention_cookies_days')->default(395);        // 13 mois
    $table->integer('rgpd_retention_newsletter_days')->default(1095);    // 3 ans

    $table->timestamps();
});
```

### 2. Model `GeneralSetting`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class GeneralSetting extends Model
{
    protected $guarded = ['id'];

    // ═══════════════════════════════════════════
    // SINGLETON PATTERN AVEC CACHE
    // ═══════════════════════════════════════════

    public static function instance(): self
    {
        return Cache::remember('general_settings', 3600, function () {
            return self::first() ?? self::create(['company_name' => 'NeoGTB']);
        });
    }

    public static function clearCache(): void
    {
        Cache::forget('general_settings');
    }

    protected static function booted(): void
    {
        static::saved(fn () => self::clearCache());
        static::deleted(fn () => self::clearCache());
    }

    // ═══════════════════════════════════════════
    // CASTS — TOUS LES CHAMPS
    // ═══════════════════════════════════════════

    protected $casts = [
        // JSON → array
        'nav_items' => 'array',
        'homepage_sections' => 'array',
        'homepage_sections_config' => 'array',
        'gtb_page_config' => 'array',
        'gtc_page_config' => 'array',
        'solutions_page_config' => 'array',
        'reglementation_page_config' => 'array',
        'audit_page_config' => 'array',
        'about_page_config' => 'array',
        'contact_page_config' => 'array',
        'faq_page_config' => 'array',
        'comparateur_page_config' => 'array',
        'blog_categories_config' => 'array',
        'gtb_protocols_config' => 'array',
        'en15232_levels_config' => 'array',
        'font_pairs_config' => 'array',
        'ui_labels' => 'array',
        'status_configs' => 'array',
        'legal_texts' => 'array',
        'client_logos' => 'array',
        'company_opening_hours' => 'array',
        'maintenance_allowed_ips' => 'array',

        // Booléens
        'nav_cta_visible' => 'boolean',
        'nav_show_phone' => 'boolean',
        'stat_buildings_auto' => 'boolean',
        'stat_clients_auto' => 'boolean',
        'announcement_enabled' => 'boolean',
        'announcement_dismissable' => 'boolean',
        'maintenance_enabled' => 'boolean',

        // Entiers
        'hero_overlay_opacity' => 'integer',
        'stat_buildings_audited' => 'integer',
        'stat_energy_savings_percent' => 'integer',
        'stat_years_experience' => 'integer',
        'stat_clients_count' => 'integer',
        'company_founding_year' => 'integer',
        'rgpd_retention_contacts_days' => 'integer',
        'rgpd_retention_leads_days' => 'integer',
        'rgpd_retention_cookies_days' => 'integer',
        'rgpd_retention_newsletter_days' => 'integer',
    ];

    // ═══════════════════════════════════════════
    // ACCESSEURS UTILES
    // ═══════════════════════════════════════════

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
        return collect([
            'facebook'  => $this->company_facebook_url,
            'linkedin'  => $this->company_linkedin_url,
            'youtube'   => $this->company_youtube_url,
            'instagram' => $this->company_instagram_url,
            'twitter'   => $this->company_twitter_url,
        ])->filter(fn ($url) => !empty($url) && filter_var($url, FILTER_VALIDATE_URL))->toArray();
    }

    public function getCopyrightAttribute(): string
    {
        return '© ' . date('Y') . ' ' . $this->company_name;
    }

    public function getLegalIdentityAttribute(): string
    {
        return implode(' | ', array_filter([
            $this->company_legal_form,
            $this->company_siret ? 'SIRET ' . $this->company_siret : null,
            $this->company_tva_number ? 'TVA ' . $this->company_tva_number : null,
            $this->company_rcs ? 'RCS ' . $this->company_rcs : null,
            $this->company_capital ? 'Capital ' . $this->company_capital : null,
        ]));
    }
}
```

### 3. Service `SiteConfigService`

Ce service est la **couche d'abstraction** entre la BDD et les vues Blade. Il fournit toutes les données du site avec cache.

```php
<?php

namespace App\Services;

use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;

class SiteConfigService
{
    private const CACHE_TTL = 3600; // 1 heure

    // ═══════════════════════════════════════════
    // ACCÈS AUX SETTINGS
    // ═══════════════════════════════════════════

    public function settings(): GeneralSetting
    {
        return GeneralSetting::instance();
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->settings()->{$key} ?? $default;
    }

    // ═══════════════════════════════════════════
    // THÈME & CSS VARIABLES
    // ═══════════════════════════════════════════

    public function cssVariables(): HtmlString
    {
        $css = Cache::remember('site_css_variables', self::CACHE_TTL, function () {
            $s = $this->settings();

            $radiusMap = [
                'none' => '0', 'small' => '4px', 'medium' => '8px',
                'large' => '12px', 'full' => '9999px',
            ];
            $shadowMap = [
                'none'   => 'none',
                'subtle' => '0 1px 3px rgba(0,0,0,0.08)',
                'medium' => '0 4px 6px rgba(0,0,0,0.1)',
                'strong' => '0 10px 25px rgba(0,0,0,0.15)',
            ];

            $fontPair = $this->fontPair();

            $vars = [
                '--color-primary'       => $s->primary_color ?? '#1E3A5F',
                '--color-secondary'     => $s->secondary_color ?? '#2D5F8A',
                '--color-accent'        => $s->accent_color ?? '#F59E0B',
                '--color-header-bg'     => $s->header_bg_color ?? '#0F172A',
                '--color-header-text'   => $s->header_text_color ?? '#F8FAFC',
                '--color-footer-bg'     => $s->footer_bg_color ?? '#1E293B',
                '--color-footer-text'   => $s->footer_text_color ?? '#CBD5E1',
                '--color-body-bg'       => $s->body_bg_color ?? '#FFFFFF',
                '--color-hero-overlay'  => $s->hero_overlay_color ?? '#0F172A',
                '--hero-overlay-opacity'=> ($s->hero_overlay_opacity ?? 60) / 100,
                '--color-cta-bg'        => $s->cta_bg_color ?? '#F59E0B',
                '--color-cta-text'      => $s->cta_text_color ?? '#0F172A',
                '--font-heading'        => $fontPair['heading'] ?? 'Inter',
                '--font-body'           => $fontPair['body'] ?? 'Inter',
                '--font-size-base'      => match($s->font_size_base ?? 'md') {
                    'sm' => '14px', 'lg' => '18px', default => '16px'
                },
                '--radius'              => $radiusMap[$s->border_radius_style ?? 'medium'] ?? '8px',
                '--shadow'              => $shadowMap[$s->shadow_style ?? 'subtle'] ?? 'none',
            ];

            $lines = array_map(fn($prop, $val) => "  {$prop}: {$val};", array_keys($vars), $vars);
            return ":root {\n" . implode("\n", $lines) . "\n}";
        });

        return new HtmlString("<style>{$css}</style>");
    }

    // ═══════════════════════════════════════════
    // POLICES (Font Pair Registry)
    // ═══════════════════════════════════════════

    public function fontPair(): array
    {
        $pairs = $this->settings()->font_pairs_config ?? [];
        $active = $this->settings()->font_pair ?? 'modern';

        foreach ($pairs as $pair) {
            if (($pair['key'] ?? '') === $active) {
                return $pair;
            }
        }

        // Fallback
        return ['key' => 'modern', 'heading' => 'Inter', 'body' => 'Inter',
                'google_families' => 'Inter:wght@400;500;600;700'];
    }

    public function googleFontsUrl(): string
    {
        $families = $this->fontPair()['google_families'] ?? 'Inter:wght@400;500;600;700';
        return "https://fonts.googleapis.com/css2?family={$families}&display=swap";
    }

    // ═══════════════════════════════════════════
    // NAVIGATION
    // ═══════════════════════════════════════════

    public function navigation(): array
    {
        $s = $this->settings();
        return [
            'items'       => collect($s->nav_items ?? [])->where('visible', true)->values()->toArray(),
            'style'       => $s->nav_style ?? 'sticky',
            'cta_text'    => $s->nav_cta_text ?? 'Demander un audit',
            'cta_url'     => $s->nav_cta_url ?? '/audit',
            'cta_visible' => $s->nav_cta_visible ?? true,
            'show_phone'  => $s->nav_show_phone ?? false,
            'phone'       => $s->company_phone ?? '',
        ];
    }

    // ═══════════════════════════════════════════
    // SEO & JSON-LD
    // ═══════════════════════════════════════════

    public function jsonLd(string $type = 'Organization'): HtmlString
    {
        $json = Cache::remember('site_json_ld', self::CACHE_TTL, function () use ($type) {
            $s = $this->settings();
            $schema = [
                '@context'     => 'https://schema.org',
                '@type'        => $type,
                'name'         => $s->company_name ?? 'NeoGTB',
                'description'  => $s->company_description ?? '',
                'url'          => config('app.url'),
                'telephone'    => $s->company_phone ?? '',
                'email'        => $s->company_email ?? '',
                'address'      => [
                    '@type'           => 'PostalAddress',
                    'streetAddress'   => $s->company_address ?? '',
                    'postalCode'      => $s->company_postal_code ?? '',
                    'addressLocality' => $s->company_city ?? '',
                    'addressCountry'  => 'FR',
                ],
                'sameAs' => array_values($s->social_links ?? []),
            ];
            return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        });

        return new HtmlString("<script type=\"application/ld+json\">{$json}</script>");
    }

    // ═══════════════════════════════════════════
    // TRACKING (conditionné au consentement cookie)
    // ═══════════════════════════════════════════

    public function trackingScripts(array $consent = []): array
    {
        $s = $this->settings();
        $head = $s->custom_head_code ?? '';
        $body = $s->custom_body_code ?? '';
        $analyticsOk = $consent['analytics'] ?? false;
        $marketingOk = $consent['marketing'] ?? false;

        if ($analyticsOk && $gtm = $s->google_tag_manager_id) {
            $gtm = e($gtm);
            $head .= "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','{$gtm}');</script>\n";
            $body .= "<noscript><iframe src=\"https://www.googletagmanager.com/ns.html?id={$gtm}\" height=\"0\" width=\"0\" style=\"display:none;visibility:hidden\"></iframe></noscript>\n";
        } elseif ($analyticsOk && $ga = $s->google_analytics_id) {
            $ga = e($ga);
            $head .= "<script async src=\"https://www.googletagmanager.com/gtag/js?id={$ga}\"></script>\n<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','{$ga}',{anonymize_ip:true});</script>\n";
        }

        if ($marketingOk && $pixel = $s->facebook_pixel_id) {
            $pixel = e($pixel);
            $head .= "<script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init','{$pixel}');fbq('track','PageView');</script>\n";
        }

        if ($analyticsOk && $hj = $s->hotjar_id) {
            $hj = e($hj);
            $head .= "<script>(function(h,o,t,j,a,r){h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};h._hjSettings={hjid:{$hj},hjsv:6};a=o.getElementsByTagName('head')[0];r=o.createElement('script');r.async=1;r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;a.appendChild(r);})(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');</script>\n";
        }

        return ['head' => new HtmlString($head), 'body' => new HtmlString($body)];
    }

    // ═══════════════════════════════════════════
    // RÉSEAUX SOCIAUX
    // ═══════════════════════════════════════════

    public function socialLinks(): array
    {
        return $this->settings()->social_links ?? [];
    }

    // ═══════════════════════════════════════════
    // ANNONCE BANDEAU
    // ═══════════════════════════════════════════

    public function announcementBar(): ?array
    {
        $s = $this->settings();
        if (!$s->announcement_enabled) {
            return null;
        }
        return [
            'text'        => $s->announcement_text ?? '',
            'url'         => $s->announcement_url,
            'bg_color'    => $s->announcement_bg_color ?? '#2563EB',
            'text_color'  => $s->announcement_text_color ?? '#FFFFFF',
            'dismissable' => $s->announcement_dismissable ?? true,
        ];
    }

    // ═══════════════════════════════════════════
    // STATISTIQUES (chiffres clés)
    // ═══════════════════════════════════════════

    public function stats(): array
    {
        $s = $this->settings();
        return [
            'buildings_audited'      => $s->stat_buildings_audited ?? 0,
            'energy_savings_percent' => $s->stat_energy_savings_percent ?? 0,
            'years_experience'       => $s->stat_years_experience ?? 0,
            'clients_count'          => $s->stat_clients_count ?? 0,
        ];
    }

    // ═══════════════════════════════════════════
    // LABELS D'INTERFACE (CRITIQUE — pas de hardcode)
    // ═══════════════════════════════════════════

    /**
     * Lit un label UI depuis general_settings.ui_labels via dot notation.
     * Usage : $site->label('forms.submit', 'Envoyer')
     */
    public function label(string $path, string $default = ''): string
    {
        $labels = $this->settings()->ui_labels ?? [];
        return data_get($labels, $path, $default);
    }

    // ═══════════════════════════════════════════
    // STATUTS (CRITIQUE — pas d'enums hardcodés)
    // ═══════════════════════════════════════════

    /**
     * Lit le label d'un statut depuis general_settings.status_configs
     * Usage : $site->statusLabel('audit_lead', 'new') → "Nouveau"
     */
    public function statusLabel(string $entity, string $key): string
    {
        return $this->statusField($entity, $key, 'label') ?? ucfirst($key);
    }

    public function statusColor(string $entity, string $key): string
    {
        return $this->statusField($entity, $key, 'color') ?? 'gray';
    }

    public function statusIcon(string $entity, string $key): string
    {
        return $this->statusField($entity, $key, 'icon') ?? 'heroicon-o-question-mark-circle';
    }

    /**
     * Retourne les options pour un Select Filament : ['new' => 'Nouveau', ...]
     */
    public function statusOptions(string $entity): array
    {
        $configs = $this->settings()->status_configs ?? [];
        $statuses = $configs[$entity] ?? [];
        return collect($statuses)->pluck('label', 'key')->toArray();
    }

    private function statusField(string $entity, string $key, string $field): ?string
    {
        $configs = $this->settings()->status_configs ?? [];
        $statuses = $configs[$entity] ?? [];
        foreach ($statuses as $status) {
            if (($status['key'] ?? '') === $key) {
                return $status[$field] ?? null;
            }
        }
        return null;
    }

    // ═══════════════════════════════════════════
    // TEXTES LÉGAUX
    // ═══════════════════════════════════════════

    /**
     * Lit un texte légal depuis general_settings.legal_texts via dot notation.
     * Usage : $site->legalText('mentions_legales')
     * Usage : $site->legalText('cookie_consent.title')
     */
    public function legalText(string $key): string
    {
        $texts = $this->settings()->legal_texts ?? [];
        return data_get($texts, $key, '');
    }

    // ═══════════════════════════════════════════
    // REGISTRES (lecture BDD + cache)
    // ═══════════════════════════════════════════

    public function blogCategories(): array
    {
        return Cache::remember('blog_categories', self::CACHE_TTL, function () {
            return $this->settings()->blog_categories_config ?? [];
        });
    }

    public function gtbProtocols(): array
    {
        return Cache::remember('gtb_protocols', self::CACHE_TTL, function () {
            return $this->settings()->gtb_protocols_config ?? [];
        });
    }

    public function en15232Levels(): array
    {
        return Cache::remember('en15232_levels', self::CACHE_TTL, function () {
            return $this->settings()->en15232_levels_config ?? [];
        });
    }

    // ═══════════════════════════════════════════
    // HOMEPAGE SECTIONS
    // ═══════════════════════════════════════════

    /**
     * Retourne l'ordre des sections de la homepage.
     */
    public function homepageSections(): array
    {
        return $this->settings()->homepage_sections ?? [];
    }

    /**
     * Retourne la config d'une section homepage.
     */
    public function homepageSectionConfig(string $section): array
    {
        $configs = $this->settings()->homepage_sections_config ?? [];
        return $configs[$section] ?? [];
    }

    // ═══════════════════════════════════════════
    // DIVERS
    // ═══════════════════════════════════════════

    public function openingHours(): array
    {
        return $this->settings()->company_opening_hours ?? [];
    }

    public function companyAge(): ?int
    {
        $year = $this->settings()->company_founding_year;
        return $year ? (int) date('Y') - $year : null;
    }

    // ═══════════════════════════════════════════
    // INVALIDATION CACHE
    // ═══════════════════════════════════════════

    public function clearCache(): void
    {
        Cache::forget('general_settings');
        Cache::forget('site_css_variables');
        Cache::forget('site_json_ld');
        Cache::forget('blog_categories');
        Cache::forget('gtb_protocols');
        Cache::forget('en15232_levels');
    }
}
```

### 4. Registries (100% BDD)

Contrairement aux registries avec des defaults hardcodés, **tout doit venir de la BDD** :

```php
// ❌ MAUVAIS — Ne pas faire ça :
class BlogCategoryRegistry {
    public static function defaults(): array {
        return [
            ['slug' => 'guides', 'label' => 'Guides pratiques', ...],
            // catégories hardcodées ← INTERDIT
        ];
    }
}

// ✅ BON — Faire ça :
// Utiliser $site->blogCategories() qui lit depuis general_settings.blog_categories_config
// Les données initiales sont peuplées par le Seeder, pas par du code
```

### 5. Seeder `GeneralSettingsSeeder`

Les seeders remplacent les "defaults" hardcodés. Ils ne s'exécutent qu'une fois (à l'installation).

```php
<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;

class GeneralSettingsSeeder extends Seeder
{
    public function run(): void
    {
        GeneralSetting::updateOrCreate(['id' => 1], [

            // ── IDENTITÉ ENTREPRISE ──
            'company_name'               => 'NeoGTB',
            'company_tagline'            => 'La GTB au service de la performance énergétique',
            'company_email'              => 'contact@neogtb.fr',
            'company_phone'              => '',
            'company_address'            => '',
            'company_city'               => '',
            'company_postal_code'        => '',
            'company_website'            => 'https://neogtb.fr',
            'company_description'        => 'NeoGTB est un site éducatif dédié à la Gestion Technique du Bâtiment (GTB/GTC). Nous accompagnons les professionnels dans l\'optimisation énergétique de leurs bâtiments.',
            'company_founding_year'      => 2026,

            // ── THÈME ──
            'primary_color'              => '#1E3A5F',
            'secondary_color'            => '#2D5F8A',
            'accent_color'               => '#F59E0B',
            'header_bg_color'            => '#0F172A',
            'header_text_color'          => '#F8FAFC',
            'footer_bg_color'            => '#1E293B',
            'footer_text_color'          => '#CBD5E1',
            'body_bg_color'              => '#FFFFFF',
            'hero_overlay_color'         => '#0F172A',
            'hero_overlay_opacity'       => 60,
            'cta_bg_color'               => '#F59E0B',
            'cta_text_color'             => '#0F172A',
            'font_pair'                  => 'modern',
            'font_size_base'             => 'md',
            'border_radius_style'        => 'medium',
            'shadow_style'               => 'subtle',

            // ── IMAGES & HERO ──
            'hero_style'                 => 'static',
            'hero_title_line1'           => 'La GTB au service',
            'hero_title_line2'           => 'de la performance énergétique',

            // ── NAVIGATION ──
            'nav_cta_text'               => 'Demander un audit',
            'nav_cta_url'                => '/audit',
            'nav_cta_visible'            => true,
            'nav_show_phone'             => false,
            'nav_style'                  => 'sticky',
            'nav_items'                  => [
                ['label' => 'Accueil', 'url' => '/', 'type' => 'link', 'visible' => true],
                ['label' => 'GTB', 'url' => '/gtb', 'type' => 'link', 'visible' => true],
                ['label' => 'GTC', 'url' => '/gtc', 'type' => 'link', 'visible' => true],
                ['label' => 'Solutions', 'url' => '/solutions', 'type' => 'link', 'visible' => true],
                ['label' => 'Réglementation', 'url' => '/reglementation', 'type' => 'link', 'visible' => true],
                ['label' => 'Blog', 'url' => '/blog', 'type' => 'link', 'visible' => true],
                ['label' => 'Contact', 'url' => '/contact', 'type' => 'link', 'visible' => true],
            ],

            // ── HOMEPAGE SECTIONS ──
            'homepage_sections' => [
                'hero', 'expertises_gtb', 'chiffres_cles', 'services',
                'protocoles', 'reglementation', 'temoignages', 'faq', 'cta_audit',
            ],

            'homepage_sections_config' => [
                'hero' => [
                    'title' => 'La GTB au service de la performance énergétique',
                    'subtitle' => 'Gestion Technique du Bâtiment',
                    'description' => 'Découvrez comment la GTB optimise la consommation énergétique de vos bâtiments, réduit vos coûts et améliore le confort des occupants.',
                    'cta_primary_text' => 'Demander un audit GTB',
                    'cta_primary_url' => '/audit',
                    'cta_secondary_text' => 'Qu\'est-ce que la GTB ?',
                    'cta_secondary_url' => '/gtb',
                ],
                'expertises_gtb' => [
                    'badge' => 'Notre expertise',
                    'title' => 'La GTB, levier de performance énergétique',
                    'subtitle' => 'Comprendre, optimiser, économiser',
                    'items' => [
                        ['icon' => 'heroicon-o-bolt', 'title' => 'Réduction des consommations', 'description' => 'Jusqu\'à 40% d\'économies d\'énergie grâce au pilotage intelligent des équipements.'],
                        ['icon' => 'heroicon-o-chart-bar', 'title' => 'Monitoring en temps réel', 'description' => 'Supervision centralisée de tous les lots techniques : CVC, éclairage, stores.'],
                        ['icon' => 'heroicon-o-shield-check', 'title' => 'Conformité réglementaire', 'description' => 'Respect du décret tertiaire, RE2020 et norme EN 15232.'],
                        ['icon' => 'heroicon-o-users', 'title' => 'Confort des occupants', 'description' => 'Température, qualité d\'air et éclairage ajustés automatiquement.'],
                    ],
                ],
                'chiffres_cles' => [
                    'title' => 'La GTB en chiffres',
                    'items' => [
                        ['value' => '40', 'suffix' => '%', 'label' => 'd\'économies d\'énergie'],
                        ['value' => '3', 'suffix' => ' ans', 'label' => 'de retour sur investissement moyen'],
                        ['value' => '500', 'suffix' => '+', 'label' => 'bâtiments accompagnés'],
                        ['value' => '15', 'suffix' => ' ans', 'label' => 'd\'expertise en GTB'],
                    ],
                ],
                'services' => [
                    'badge' => 'Nos services',
                    'title' => 'Comment nous pouvons vous aider',
                    'items' => [
                        ['title' => 'Audit GTB gratuit', 'description' => 'Évaluation complète de votre installation GTB actuelle.', 'url' => '/audit'],
                        ['title' => 'Accompagnement CEE', 'description' => 'Montage de vos dossiers Certificats d\'Économies d\'Énergie.', 'url' => '/cee'],
                        ['title' => 'Conseil réglementaire', 'description' => 'Mise en conformité décret tertiaire et RE2020.', 'url' => '/reglementation'],
                    ],
                ],
                'protocoles' => [
                    'badge' => 'Technologies',
                    'title' => 'Les protocoles de la GTB',
                    'subtitle' => 'Interopérabilité et communication',
                    'items' => [
                        ['name' => 'BACnet', 'description' => 'Standard ouvert de communication pour l\'automatisation du bâtiment.'],
                        ['name' => 'KNX', 'description' => 'Bus de terrain européen pour le contrôle du bâtiment.'],
                        ['name' => 'Modbus', 'description' => 'Protocole série largement utilisé dans l\'industrie et le bâtiment.'],
                        ['name' => 'LON', 'description' => 'Réseau de contrôle distribué pour bâtiments intelligents.'],
                    ],
                ],
                'reglementation' => [
                    'badge' => 'Réglementation',
                    'title' => 'Cadre légal et normes',
                    'items' => [
                        ['title' => 'Décret tertiaire', 'description' => 'Obligation de réduction des consommations énergétiques des bâtiments tertiaires.'],
                        ['title' => 'RE2020', 'description' => 'Réglementation environnementale pour les bâtiments neufs.'],
                        ['title' => 'EN 15232', 'description' => 'Norme européenne de classification GTB en 4 niveaux (A, B, C, D).'],
                        ['title' => 'Décret BACS', 'description' => 'Obligation d\'installer un système GTB avant 2025 pour les bâtiments >290 kW.'],
                    ],
                ],
                'temoignages' => [
                    'badge' => 'Témoignages',
                    'title' => 'Ils nous font confiance',
                    'items' => [
                        ['name' => 'Jean D.', 'role' => 'Directeur technique', 'company' => 'Groupe immobilier', 'text' => 'Grâce à l\'audit NeoGTB, nous avons identifié 35% d\'économies potentielles sur notre parc tertiaire.'],
                        ['name' => 'Marie L.', 'role' => 'Responsable énergie', 'company' => 'Collectivité territoriale', 'text' => 'Un accompagnement précieux pour la mise en conformité au décret tertiaire.'],
                    ],
                ],
                'faq' => [
                    'badge' => 'FAQ',
                    'title' => 'Questions fréquentes',
                    'items' => [
                        ['question' => 'Quelle différence entre GTB et GTC ?', 'answer' => 'La GTB (Gestion Technique du Bâtiment) englobe l\'ensemble du pilotage technique, tandis que la GTC (Gestion Technique Centralisée) désigne plus spécifiquement le système de supervision centralisé.'],
                        ['question' => 'Quel est le ROI moyen d\'une installation GTB ?', 'answer' => 'Le retour sur investissement se situe généralement entre 3 et 5 ans, selon la taille du bâtiment et le niveau d\'automatisation.'],
                        ['question' => 'La GTB est-elle obligatoire ?', 'answer' => 'Le décret BACS impose l\'installation d\'un système GTB pour les bâtiments tertiaires de plus de 290 kW avant 2025, et de plus de 70 kW avant 2027.'],
                        ['question' => 'Quels sont les niveaux de GTB selon la norme EN 15232 ?', 'answer' => 'La norme définit 4 classes : A (haute performance), B (avancé), C (standard) et D (non performant). La classe B est le minimum recommandé.'],
                    ],
                ],
                'cta_audit' => [
                    'title' => 'Optimisez la performance énergétique de votre bâtiment',
                    'subtitle' => 'Demandez un audit GTB gratuit et sans engagement',
                    'button_text' => 'Demander un audit gratuit',
                    'button_url' => '/audit',
                ],
            ],

            // ── PAGES CONFIG ──
            'gtb_page_config' => [
                'hero_title' => 'Qu\'est-ce que la GTB ?',
                'hero_subtitle' => 'Gestion Technique du Bâtiment — Guide complet',
                'meta_title' => 'Qu\'est-ce que la GTB ? Guide complet 2026',
                'meta_description' => 'Découvrez la GTB (Gestion Technique du Bâtiment) : définition, fonctionnement, avantages, niveaux EN 15232 et retour sur investissement.',
            ],
            'gtc_page_config' => [
                'hero_title' => 'Qu\'est-ce que la GTC ?',
                'hero_subtitle' => 'Gestion Technique Centralisée — Guide complet',
                'meta_title' => 'Qu\'est-ce que la GTC ? Guide complet 2026',
                'meta_description' => 'Comprendre la GTC (Gestion Technique Centralisée) : supervision, protocoles, différences avec la GTB et mise en oeuvre.',
            ],
            'solutions_page_config' => [
                'hero_title' => 'Solutions & Technologies',
                'hero_subtitle' => 'Protocoles, capteurs et automates pour la GTB',
                'meta_title' => 'Solutions GTB : BACnet, KNX, Modbus, capteurs intelligents',
                'meta_description' => 'Découvrez les solutions techniques de la GTB : protocoles de communication, capteurs, automates et systèmes de supervision.',
            ],
            'reglementation_page_config' => [
                'hero_title' => 'Réglementation GTB',
                'hero_subtitle' => 'Décret tertiaire, RE2020, EN 15232, décret BACS',
                'meta_title' => 'Réglementation GTB : décret tertiaire, RE2020, BACS',
                'meta_description' => 'Tout savoir sur le cadre réglementaire de la GTB : décret tertiaire, RE2020, norme EN 15232 et décret BACS.',
            ],
            'audit_page_config' => [
                'hero_title' => 'Audit GTB gratuit',
                'hero_subtitle' => 'Évaluez le potentiel d\'économies de votre bâtiment',
                'meta_title' => 'Audit GTB gratuit — Diagnostic performance énergétique',
                'meta_description' => 'Demandez un audit GTB gratuit et sans engagement. Identifiez les leviers d\'économies d\'énergie de votre bâtiment.',
            ],
            'about_page_config' => [
                'hero_title' => 'À propos de NeoGTB',
                'hero_subtitle' => 'Notre mission : démocratiser la GTB',
                'meta_title' => 'À propos — NeoGTB, experts GTB/GTC',
                'meta_description' => 'Découvrez NeoGTB : notre mission, notre équipe et notre engagement pour la performance énergétique des bâtiments.',
            ],
            'contact_page_config' => [
                'hero_title' => 'Contactez-nous',
                'hero_subtitle' => 'Une question sur la GTB ? Nous sommes là pour vous aider.',
                'meta_title' => 'Contact — NeoGTB',
                'meta_description' => 'Contactez l\'équipe NeoGTB pour toute question sur la GTB/GTC, un audit énergétique ou un accompagnement réglementaire.',
            ],
            'faq_page_config' => [
                'hero_title' => 'FAQ — Questions fréquentes',
                'hero_subtitle' => 'Tout ce que vous devez savoir sur la GTB/GTC',
                'meta_title' => 'FAQ GTB/GTC — Questions fréquentes',
                'meta_description' => 'Réponses aux questions les plus fréquentes sur la GTB, la GTC, les protocoles, la réglementation et le retour sur investissement.',
            ],
            'comparateur_page_config' => [
                'hero_title' => 'Comparateur GTB',
                'hero_subtitle' => 'Comparez les solutions GTB du marché',
                'meta_title' => 'Comparateur GTB — Comparez les solutions du marché',
                'meta_description' => 'Comparez les principales solutions GTB : fonctionnalités, protocoles supportés, prix et niveaux EN 15232.',
            ],

            // ── CATALOGUES & REGISTRES ──
            'blog_categories_config' => [
                ['slug' => 'guides', 'label' => 'Guides pratiques', 'color' => '#3B82F6', 'icon' => 'heroicon-o-book-open', 'description' => 'Guides complets sur la GTB/GTC'],
                ['slug' => 'reglementation', 'label' => 'Réglementation', 'color' => '#8B5CF6', 'icon' => 'heroicon-o-scale', 'description' => 'Décret tertiaire, RE2020, BACS'],
                ['slug' => 'technologies', 'label' => 'Technologies', 'color' => '#06B6D4', 'icon' => 'heroicon-o-cpu-chip', 'description' => 'Protocoles, capteurs, automates'],
                ['slug' => 'etudes-de-cas', 'label' => 'Études de cas', 'color' => '#10B981', 'icon' => 'heroicon-o-chart-bar', 'description' => 'Retours d\'expérience terrain'],
                ['slug' => 'actualites', 'label' => 'Actualités', 'color' => '#F59E0B', 'icon' => 'heroicon-o-newspaper', 'description' => 'Actualités du secteur GTB/GTC'],
                ['slug' => 'smart-building', 'label' => 'Smart Building', 'color' => '#EF4444', 'icon' => 'heroicon-o-building-office-2', 'description' => 'Bâtiment intelligent et IoT'],
            ],

            'gtb_protocols_config' => [
                ['slug' => 'bacnet', 'label' => 'BACnet', 'description' => 'Building Automation and Control Networks — Standard ASHRAE/ISO pour l\'automatisation du bâtiment.', 'type' => 'ouvert'],
                ['slug' => 'knx', 'label' => 'KNX', 'description' => 'Bus de terrain européen (ISO 14543) pour le contrôle domotique et immotique.', 'type' => 'ouvert'],
                ['slug' => 'modbus', 'label' => 'Modbus', 'description' => 'Protocole série/TCP largement utilisé dans l\'industrie et le bâtiment.', 'type' => 'ouvert'],
                ['slug' => 'lon', 'label' => 'LON', 'description' => 'Local Operating Network — Réseau de contrôle distribué (ISO 14908).', 'type' => 'ouvert'],
                ['slug' => 'dali', 'label' => 'DALI', 'description' => 'Digital Addressable Lighting Interface — Standard pour le pilotage d\'éclairage.', 'type' => 'ouvert'],
                ['slug' => 'mbus', 'label' => 'M-Bus', 'description' => 'Meter-Bus — Protocole de relevé de compteurs d\'énergie (EN 13757).', 'type' => 'ouvert'],
                ['slug' => 'zigbee', 'label' => 'Zigbee', 'description' => 'Protocole sans fil basse consommation pour l\'IoT bâtiment.', 'type' => 'sans_fil'],
                ['slug' => 'lorawan', 'label' => 'LoRaWAN', 'description' => 'Réseau longue portée basse consommation pour capteurs bâtiment.', 'type' => 'sans_fil'],
            ],

            'en15232_levels_config' => [
                ['key' => 'A', 'label' => 'Classe A — Haute performance', 'description' => 'Systèmes GTB haute performance avec régulation individuelle, optimisation, gestion de la demande.', 'color' => '#10B981', 'savings' => '30-40%'],
                ['key' => 'B', 'label' => 'Classe B — Avancé', 'description' => 'Systèmes GTB avancés avec régulation automatique, programmes horaires, détection de présence.', 'color' => '#3B82F6', 'savings' => '15-25%'],
                ['key' => 'C', 'label' => 'Classe C — Standard', 'description' => 'Systèmes GTB standard — automatisation de base, pas d\'optimisation.', 'color' => '#F59E0B', 'savings' => '0-5%'],
                ['key' => 'D', 'label' => 'Classe D — Non performant', 'description' => 'Pas de GTB — contrôle manuel, pas d\'automatisation.', 'color' => '#EF4444', 'savings' => 'Référence'],
            ],

            'font_pairs_config' => [
                ['key' => 'modern', 'label' => 'Moderne', 'heading' => 'Inter', 'body' => 'Inter', 'heading_weights' => [400,500,600,700], 'body_weights' => [400,500], 'google_families' => 'Inter:wght@400;500;600;700'],
                ['key' => 'elegant', 'label' => 'Élégant', 'heading' => 'Playfair Display', 'body' => 'Source Sans 3', 'heading_weights' => [400,700], 'body_weights' => [400,600], 'google_families' => 'Playfair+Display:wght@400;700&family=Source+Sans+3:wght@400;600'],
                ['key' => 'professional', 'label' => 'Professionnel', 'heading' => 'Montserrat', 'body' => 'Open Sans', 'heading_weights' => [500,600,700], 'body_weights' => [400,600], 'google_families' => 'Montserrat:wght@500;600;700&family=Open+Sans:wght@400;600'],
                ['key' => 'technical', 'label' => 'Technique', 'heading' => 'Space Grotesk', 'body' => 'Inter', 'heading_weights' => [400,500,600,700], 'body_weights' => [400,500,600], 'google_families' => 'Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600'],
                ['key' => 'minimal', 'label' => 'Minimaliste', 'heading' => 'DM Sans', 'body' => 'DM Sans', 'heading_weights' => [400,500,700], 'body_weights' => [400,500], 'google_families' => 'DM+Sans:wght@400;500;700'],
                ['key' => 'bold', 'label' => 'Audacieux', 'heading' => 'Outfit', 'body' => 'Inter', 'heading_weights' => [500,600,700], 'body_weights' => [400,500], 'google_families' => 'Outfit:wght@500;600;700&family=Inter:wght@400;500'],
            ],

            // ── STATISTIQUES ──
            'stat_buildings_audited'      => 500,
            'stat_buildings_auto'         => false,
            'stat_energy_savings_percent' => 40,
            'stat_years_experience'       => 15,
            'stat_clients_count'          => 200,
            'stat_clients_auto'           => false,

            // ── ANNONCE BANDEAU ──
            'announcement_enabled'     => false,
            'announcement_text'        => '',
            'announcement_bg_color'    => '#2563EB',
            'announcement_text_color'  => '#FFFFFF',
            'announcement_dismissable' => true,

            // ── SEO ──
            'seo_title_suffix'         => ' | NeoGTB',
            'seo_default_description'  => 'NeoGTB — Site éducatif sur la Gestion Technique du Bâtiment (GTB/GTC). Guides, réglementation, audit gratuit.',
            'seo_robots'               => 'index',
            'seo_schema_type'          => 'Organization',
            'seo_canonical_domain'     => 'neogtb.fr',

            // ── EMAIL ──
            'email_from_name'          => 'NeoGTB',
            'email_from_address'       => 'contact@neogtb.fr',

            // ── RGPD ──
            'rgpd_retention_contacts_days'   => 730,
            'rgpd_retention_leads_days'      => 1095,
            'rgpd_retention_cookies_days'    => 395,
            'rgpd_retention_newsletter_days' => 1095,

            // ── MAINTENANCE ──
            'maintenance_enabled' => false,

            // ── UI LABELS ──
            'ui_labels' => [
                'forms' => [
                    'name' => 'Nom',
                    'first_name' => 'Prénom',
                    'email' => 'Email',
                    'phone' => 'Téléphone',
                    'company' => 'Entreprise',
                    'building_type' => 'Type de bâtiment',
                    'surface' => 'Surface (m²)',
                    'message' => 'Message',
                    'subject' => 'Sujet',
                    'submit' => 'Envoyer',
                    'cancel' => 'Annuler',
                    'required_fields' => 'Les champs marqués d\'un * sont obligatoires',
                    'success_message' => 'Votre message a bien été envoyé',
                    'error_message' => 'Une erreur est survenue, veuillez réessayer',
                ],
                'audit' => [
                    'step1_title' => 'Votre bâtiment',
                    'step1_description' => 'Type, surface et localisation de votre bâtiment',
                    'step2_title' => 'Vos équipements',
                    'step2_description' => 'CVC, éclairage, stores et comptage',
                    'step3_title' => 'Vos objectifs',
                    'step3_description' => 'Économies visées et contraintes',
                    'step4_title' => 'Vos coordonnées',
                    'step4_description' => 'Pour recevoir votre diagnostic personnalisé',
                    'next' => 'Suivant',
                    'previous' => 'Précédent',
                    'submit' => 'Recevoir mon diagnostic',
                    'success' => 'Votre demande d\'audit a bien été envoyée ! Nous vous recontacterons sous 48h.',
                ],
                'newsletter' => [
                    'title' => 'Restez informé sur la GTB',
                    'description' => 'Recevez nos guides, actualités et conseils pour optimiser votre bâtiment.',
                    'placeholder' => 'Votre adresse email',
                    'subscribe' => 'S\'inscrire',
                    'success' => 'Inscription confirmée !',
                    'already_subscribed' => 'Vous êtes déjà inscrit à notre newsletter.',
                ],
                'header' => [
                    'breadcrumb_label' => 'Fil d\'Ariane',
                    'skip_to_content' => 'Aller au contenu principal',
                    'menu_open' => 'Ouvrir le menu',
                    'menu_close' => 'Fermer le menu',
                ],
                'footer' => [
                    'col1_title' => 'GTB/GTC',
                    'col2_title' => 'Ressources',
                    'col3_title' => 'Services',
                    'col4_title' => 'À propos',
                    'copyright_prefix' => '©',
                    'all_rights_reserved' => 'Tous droits réservés',
                ],
                'cta' => [
                    'pre_footer_title' => 'Optimisez la performance énergétique de votre bâtiment',
                    'pre_footer_subtitle' => 'Demandez un audit GTB gratuit et sans engagement',
                    'pre_footer_button' => 'Demander un audit gratuit',
                    'diagnostic_cta' => 'Diagnostic GTB gratuit',
                    'contact_us' => 'Nous contacter',
                    'download_guide' => 'Télécharger le guide',
                    'request_audit' => 'Demander un audit',
                ],
                'cookie' => [
                    'title' => 'Gestion des cookies',
                    'description' => 'Nous utilisons des cookies pour améliorer votre expérience de navigation et analyser notre trafic.',
                    'accept' => 'Tout accepter',
                    'reject' => 'Tout refuser',
                    'customize' => 'Personnaliser',
                    'save_preferences' => 'Enregistrer mes préférences',
                    'necessary_title' => 'Cookies nécessaires',
                    'necessary_desc' => 'Ces cookies sont indispensables au fonctionnement du site.',
                    'analytics_title' => 'Cookies analytiques',
                    'analytics_desc' => 'Ces cookies nous permettent de mesurer l\'audience du site.',
                    'marketing_title' => 'Cookies marketing',
                    'marketing_desc' => 'Ces cookies sont utilisés pour vous proposer des publicités pertinentes.',
                ],
                'validation' => [
                    'required' => 'Ce champ est obligatoire',
                    'email_invalid' => 'L\'adresse email n\'est pas valide',
                    'phone_invalid' => 'Le numéro de téléphone n\'est pas valide',
                    'min_length' => 'Ce champ doit contenir au moins :min caractères',
                    'max_length' => 'Ce champ ne doit pas dépasser :max caractères',
                    'file_too_large' => 'Le fichier est trop volumineux',
                    'invalid_format' => 'Le format n\'est pas valide',
                ],
                'pagination' => [
                    'previous' => 'Précédent',
                    'next' => 'Suivant',
                    'showing' => 'Affichage de',
                    'to' => 'à',
                    'of' => 'sur',
                    'results' => 'résultats',
                ],
                'blog' => [
                    'read_more' => 'Lire la suite',
                    'reading_time' => 'min de lecture',
                    'published_on' => 'Publié le',
                    'by_author' => 'Par',
                    'all_articles' => 'Tous les articles',
                    'related_articles' => 'Articles similaires',
                    'share' => 'Partager cet article',
                    'categories' => 'Catégories',
                    'tags' => 'Mots-clés',
                    'no_articles' => 'Aucun article trouvé',
                    'search_placeholder' => 'Rechercher un article...',
                ],
                'misc' => [
                    'loading' => 'Chargement...',
                    'no_data' => 'Aucune donnée disponible',
                    'back' => 'Retour',
                    'close' => 'Fermer',
                    'confirm' => 'Confirmer',
                    'yes' => 'Oui',
                    'no' => 'Non',
                    'more' => 'En savoir plus',
                    'share' => 'Partager',
                    'print' => 'Imprimer',
                ],
            ],

            // ── STATUS CONFIGS ──
            'status_configs' => [
                'blog_post' => [
                    ['key' => 'draft', 'label' => 'Brouillon', 'color' => 'gray', 'icon' => 'heroicon-o-pencil'],
                    ['key' => 'published', 'label' => 'Publié', 'color' => 'success', 'icon' => 'heroicon-o-check-circle'],
                    ['key' => 'archived', 'label' => 'Archivé', 'color' => 'warning', 'icon' => 'heroicon-o-archive-box'],
                ],
                'audit_lead' => [
                    ['key' => 'new', 'label' => 'Nouveau', 'color' => 'info', 'icon' => 'heroicon-o-sparkles'],
                    ['key' => 'contacted', 'label' => 'Contacté', 'color' => 'primary', 'icon' => 'heroicon-o-phone'],
                    ['key' => 'qualified', 'label' => 'Qualifié', 'color' => 'warning', 'icon' => 'heroicon-o-star'],
                    ['key' => 'converted', 'label' => 'Converti', 'color' => 'success', 'icon' => 'heroicon-o-check-badge'],
                    ['key' => 'lost', 'label' => 'Perdu', 'color' => 'danger', 'icon' => 'heroicon-o-x-circle'],
                ],
                'cee_lead' => [
                    ['key' => 'new', 'label' => 'Nouveau', 'color' => 'info', 'icon' => 'heroicon-o-sparkles'],
                    ['key' => 'processing', 'label' => 'En traitement', 'color' => 'warning', 'icon' => 'heroicon-o-cog-6-tooth'],
                    ['key' => 'sent', 'label' => 'Dossier envoyé', 'color' => 'primary', 'icon' => 'heroicon-o-paper-airplane'],
                    ['key' => 'signed', 'label' => 'Signé', 'color' => 'success', 'icon' => 'heroicon-o-check-badge'],
                ],
                'contact_message' => [
                    ['key' => 'new', 'label' => 'Nouveau', 'color' => 'info', 'icon' => 'heroicon-o-envelope'],
                    ['key' => 'read', 'label' => 'Lu', 'color' => 'primary', 'icon' => 'heroicon-o-envelope-open'],
                    ['key' => 'replied', 'label' => 'Répondu', 'color' => 'success', 'icon' => 'heroicon-o-chat-bubble-left-right'],
                    ['key' => 'archived', 'label' => 'Archivé', 'color' => 'gray', 'icon' => 'heroicon-o-archive-box'],
                ],
                'gdpr_request' => [
                    ['key' => 'pending', 'label' => 'En attente', 'color' => 'warning', 'icon' => 'heroicon-o-clock'],
                    ['key' => 'processing', 'label' => 'En traitement', 'color' => 'info', 'icon' => 'heroicon-o-cog-6-tooth'],
                    ['key' => 'completed', 'label' => 'Traitée', 'color' => 'success', 'icon' => 'heroicon-o-check-circle'],
                    ['key' => 'rejected', 'label' => 'Rejetée', 'color' => 'danger', 'icon' => 'heroicon-o-x-circle'],
                ],
            ],

            // ── LEGAL TEXTS ──
            'legal_texts' => [
                'cookie_consent' => [
                    'title' => 'Gestion des cookies',
                    'description' => 'Nous utilisons des cookies pour améliorer votre expérience de navigation et analyser notre trafic. Vous pouvez accepter, refuser ou personnaliser vos préférences.',
                    'accept_button' => 'Tout accepter',
                    'reject_button' => 'Tout refuser',
                    'customize_button' => 'Personnaliser',
                    'categories' => [
                        ['key' => 'necessary', 'label' => 'Cookies nécessaires', 'description' => 'Indispensables au fonctionnement du site.', 'required' => true],
                        ['key' => 'analytics', 'label' => 'Cookies analytiques', 'description' => 'Mesure d\'audience et statistiques de navigation.'],
                        ['key' => 'marketing', 'label' => 'Cookies marketing', 'description' => 'Publicités personnalisées et suivi inter-sites.'],
                    ],
                ],
                'mentions_legales' => '<h1>Mentions légales</h1><p>En vertu de l\'article 6 de la loi n° 2004-575 du 21 juin 2004...</p>',
                'politique_confidentialite' => '<h1>Politique de confidentialité</h1><p>Conformément au RGPD (Règlement Général sur la Protection des Données)...</p>',
                'cgu' => '<h1>Conditions Générales d\'Utilisation</h1><p>L\'utilisation du site neogtb.fr implique l\'acceptation des présentes CGU...</p>',
                'politique_cookies' => '<h1>Politique de cookies</h1><p>Ce site utilise des cookies pour...</p>',
            ],
        ]);
    }
}
```

---

## INJECTION DANS LES VUES BLADE

### View Composer

Créer un `SiteSettingsComposer` qui injecte automatiquement les données dans TOUTES les vues publiques :

```php
<?php

namespace App\Http\View\Composers;

use App\Models\GeneralSetting;
use App\Services\SiteConfigService;
use Illuminate\View\View;

class SiteSettingsComposer
{
    public function compose(View $view): void
    {
        $site = app(SiteConfigService::class);
        $settings = GeneralSetting::instance();

        $view->with([
            'site' => $site,
            'settings' => $settings,
        ]);
    }
}
```

```php
// Dans AppServiceProvider::boot()
use Illuminate\Support\Facades\View;
use App\Http\View\Composers\SiteSettingsComposer;

public function boot(): void
{
    View::composer('front.*', SiteSettingsComposer::class);
    View::composer('components.front.*', SiteSettingsComposer::class);
}
```

### Usage dans les Blade (exemples)

```blade
{{-- ❌ INTERDIT — Ne jamais écrire de texte en dur --}}
<h2>Optimisez la performance énergétique de votre bâtiment</h2>
<button>Envoyer</button>
<p>Les champs marqués d'un * sont obligatoires</p>

{{-- ✅ CORRECT — Toujours lire depuis la BDD via $site --}}
<h2>{{ $site->label('cta.pre_footer_title') }}</h2>
<button>{{ $site->label('forms.submit') }}</button>
<p>{{ $site->label('forms.required_fields') }}</p>

{{-- ❌ INTERDIT — Pas de couleurs hardcodées --}}
<div style="background: linear-gradient(160deg, #0c1222 0%, #131c31 50%)">

{{-- ✅ CORRECT — Utiliser les CSS variables --}}
<div style="background: linear-gradient(160deg, var(--color-header-bg) 0%, var(--color-primary) 100%)">

{{-- ❌ INTERDIT — Pas de statuts hardcodés --}}
@if($lead->status === 'new')
    <span class="text-blue-500">Nouveau</span>
@endif

{{-- ✅ CORRECT — Lire label et couleur depuis la BDD --}}
<span class="text-{{ $site->statusColor('audit_lead', $lead->status) }}-500">
    {{ $site->statusLabel('audit_lead', $lead->status) }}
</span>
```

### Layout principal

```blade
{{-- resources/views/front/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') {{ $site->get('seo_title_suffix') }}</title>
    <meta name="description" content="@yield('description', $site->get('seo_default_description'))">
    <meta name="robots" content="{{ $site->get('seo_robots', 'index') }}">

    {{-- Favicon depuis BDD --}}
    @if($settings->favicon)
        <link rel="icon" href="{{ Storage::url($settings->favicon) }}">
    @endif

    {{-- Google Fonts depuis BDD --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="{{ $site->googleFontsUrl() }}" rel="stylesheet">

    {{-- Variables CSS générées depuis BDD --}}
    {!! $site->cssVariables() !!}

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('title') {{ $site->get('seo_title_suffix') }}">
    <meta property="og:description" content="@yield('description', $site->get('seo_default_description'))">
    @if($settings->og_default_image)
        <meta property="og:image" content="{{ Storage::url($settings->og_default_image) }}">
    @endif

    {{-- Tracking (conditionné au consentement cookie) --}}
    @php
        $consent = App\Helpers\ConsentHelper::get();
        $tracking = $site->trackingScripts($consent);
    @endphp
    {!! $tracking['head'] !!}

    {{-- JSON-LD Schema.org --}}
    {!! $site->jsonLd($site->get('seo_schema_type', 'Organization')) !!}

    @stack('head')
</head>
<body>
    {!! $tracking['body'] !!}

    @include('front.partials.announcement-bar')
    @include('front.partials.header')

    <main>@yield('content')</main>

    @include('front.partials.footer')
    @include('front.partials.cookie-consent')

    @stack('scripts')
</body>
</html>
```

---

## PAGE ADMIN FILAMENT — SETTINGS

Créer UNE page Filament `GeneralSettingsPage.php` avec des **onglets** organisés :

### Structure des onglets

```
📋 Général
  ├── Coordonnées (company_name, tagline, email, phone, address, etc.)
  ├── Identité Juridique (legal_form, SIRET, TVA, RCS, capital)
  ├── Représentant Légal (name, title)
  └── Horaires (Repeater : day + hours)

🌐 Mon Site Web
  ├── Identité Visuelle (logos, favicon, OG image)
  ├── Couleurs (12 ColorPickers)
  ├── Typographie (font pair, size, radius, shadow)
  ├── Navigation (Repeater drag-and-drop avec sub-items)
  ├── Page d'Accueil
  │   ├── Hero (style, title lines, image)
  │   ├── Sections (CheckboxList activer/désactiver + ordre)
  │   └── Config par section (Repeater pour FAQ, expertises, chiffres, services, etc.)
  ├── Chiffres Clés (counts + auto-calculate toggles)
  ├── Footer (description, horaires, logos partenaires)
  ├── Bandeau d'Annonce (enable, text, url, colors, dismissable)
  ├── Réseaux Sociaux (5 URLs)
  ├── SEO (suffix, description, robots, schema type, canonical domain, verification)
  ├── Tracking (GA, GTM, Pixel, Hotjar, Maps)
  └── Avancé (maintenance mode, custom code head/body)

📄 Pages
  ├── Page GTB (hero, SEO)
  ├── Page GTC (hero, SEO)
  ├── Page Solutions (hero, SEO)
  ├── Page Réglementation (hero, SEO)
  ├── Page Audit (hero, SEO)
  ├── Page À Propos (hero, SEO)
  ├── Page Contact (hero, SEO)
  ├── Page FAQ (hero, SEO)
  └── Page Comparateur (hero, SEO)

🏷️ Labels d'Interface
  ├── Formulaires (name, email, phone, submit, cancel, etc.)
  ├── Audit wizard (step titles, buttons, messages)
  ├── Newsletter (title, placeholder, subscribe, messages)
  ├── En-tête (breadcrumb, skip to content, menu)
  ├── Pied de page (titres colonnes, copyright)
  ├── Appels à l'action (pré-footer, boutons CTA)
  ├── Cookies (title, description, buttons, catégories)
  ├── Validation (required, email invalid, etc.)
  ├── Pagination (previous, next, showing, etc.)
  ├── Blog (read more, reading time, published on, etc.)
  └── Divers (loading, no data, back, close, etc.)

🔄 Statuts & Workflows
  ├── Articles blog (Repeater : key, label, color select, icon select)
  ├── Leads audit GTB (idem)
  ├── Leads CEE (idem)
  ├── Messages contact (idem)
  └── Demandes RGPD (idem)

📂 Catalogues
  ├── Catégories blog (Repeater : slug, label, icon, color, description)
  ├── Protocoles GTB (Repeater : slug, label, description, type)
  ├── Niveaux EN 15232 (Repeater : key, label, description, color, savings)
  └── Paires de polices (Repeater : key, label, heading, body, weights, Google URL)

📜 Textes Légaux
  ├── Cookie consent (RichEditor : title, description, boutons, catégories)
  ├── Mentions légales (RichEditor)
  ├── Politique de confidentialité (RichEditor)
  ├── CGU (RichEditor)
  └── Politique de cookies (RichEditor)

📧 Email
  ├── Expéditeur (name, email)
  ├── Notifications admin (to, cc)
  └── Test (bouton envoyer email de test)

🛡️ RGPD
  ├── Rétention contacts (jours)
  ├── Rétention leads (jours)
  ├── Rétention cookies (jours)
  └── Rétention newsletter inactifs (jours)
```

### Composants UI Filament utilisés

| Composant | Usage |
|-----------|-------|
| `TextInput` | Champs texte simples |
| `Textarea` | Textes multi-lignes |
| `RichEditor` | Textes HTML (légaux) |
| `ColorPicker` | Toutes les couleurs |
| `FileUpload` | Logos, images |
| `Toggle` | Tous les booléens |
| `Select` | Listes déroulantes (font pair, style) |
| `Repeater` | Listes dynamiques (nav items, FAQ, sections, statuts, protocoles) |
| `CheckboxList` | Sélection multiple (sections homepage) |
| `Tabs` | Organisation onglets principaux |
| `Section` | Regroupement avec titre + description |
| `Grid` | Layout multi-colonnes |
| `Actions` | Boutons d'action (test email, reset) |

### Exemple onglet Statuts & Workflows

```php
Tab::make('Statuts & Workflows')
    ->icon('heroicon-o-arrow-path')
    ->schema([
        Section::make('Articles blog')
            ->description('Statuts possibles pour les articles du blog.')
            ->schema([
                Repeater::make('status_configs.blog_post')
                    ->label('')
                    ->schema([
                        TextInput::make('key')->label('Clé technique')->required()->maxLength(30),
                        TextInput::make('label')->label('Label affiché')->required()->maxLength(50),
                        Select::make('color')->label('Couleur')
                            ->options(['gray' => 'Gris', 'info' => 'Bleu', 'primary' => 'Primaire', 'success' => 'Vert', 'warning' => 'Orange', 'danger' => 'Rouge']),
                        TextInput::make('icon')->label('Icône Heroicon')->placeholder('heroicon-o-...'),
                    ])
                    ->columns(4)
                    ->reorderable()
                    ->collapsible()
                    ->defaultItems(0),
            ]),

        Section::make('Leads audit GTB')
            ->schema([
                Repeater::make('status_configs.audit_lead')
                    ->label('')
                    ->schema([
                        TextInput::make('key')->label('Clé technique')->required(),
                        TextInput::make('label')->label('Label affiché')->required(),
                        Select::make('color')->label('Couleur')
                            ->options(['gray' => 'Gris', 'info' => 'Bleu', 'primary' => 'Primaire', 'success' => 'Vert', 'warning' => 'Orange', 'danger' => 'Rouge']),
                        TextInput::make('icon')->label('Icône Heroicon'),
                    ])
                    ->columns(4)
                    ->reorderable()
                    ->collapsible()
                    ->defaultItems(0),
            ]),

        // Idem pour : cee_lead, contact_message, gdpr_request
    ]),
```

---

## PATTERN DE CACHE

Toute donnée lue depuis `general_settings` doit être cachée :

```php
// Le model utilise Cache::remember('general_settings', 3600, ...)
// Le service cache les valeurs calculées : CSS variables, JSON-LD, registres

// Invalidation à chaque sauvegarde dans la page Settings :
GeneralSetting::clearCache();     // Model → forget 'general_settings'
$site->clearCache();              // Service → forget CSS, JSON-LD, registres

// Dans la page Filament Settings :
protected function afterSave(): void
{
    GeneralSetting::clearCache();
    app(SiteConfigService::class)->clearCache();
}
```

---

## CHECKLIST DE VÉRIFICATION "ZÉRO HARDCODE"

Avant chaque merge, vérifier qu'aucun texte n'est hardcodé :

### Dans les vues Blade (`resources/views/front/`)

- [ ] Aucun texte français en dur (utiliser `$site->label()`)
- [ ] Aucune couleur hex en dur (utiliser `var(--color-*)`)
- [ ] Aucun gradient hardcodé (utiliser les CSS vars)
- [ ] Aucune image path en dur (utiliser `Storage::url($settings->field)`)
- [ ] Aucun lien de contact en dur (utiliser `$settings->company_email`, `$settings->company_phone`)
- [ ] Aucun label de formulaire en dur (utiliser `$site->label('forms.*')`)
- [ ] Aucun label d'audit en dur (utiliser `$site->label('audit.*')`)
- [ ] Aucun message de validation en dur (utiliser `$site->label('validation.*')`)
- [ ] Aucun texte légal en dur (utiliser `$site->legalText('*')`)
- [ ] Aucun label de blog en dur (utiliser `$site->label('blog.*')`)

### Dans les Controllers

- [ ] Aucun message d'erreur/succès en dur (lire depuis `ui_labels`)
- [ ] Aucune règle de validation avec message custom hardcodé

### Dans les Models

- [ ] Aucun `const STATUS_*` avec label hardcodé
- [ ] Aucune méthode `label()` avec `match()` hardcodé
- [ ] Utiliser `SiteConfigService::statusLabel()` partout

### Dans les Enums

- [ ] **NE PAS utiliser d'enums PHP pour les statuts métier**
- [ ] Les statuts doivent être de simples strings stockés en BDD
- [ ] Labels, couleurs, icônes lus depuis `general_settings.status_configs`

### Dans les Services

- [ ] Aucun tableau de defaults hardcodé
- [ ] Les defaults sont dans les Seeders, pas dans le code
- [ ] Tout est lu depuis la BDD avec cache

### Dans les Filament Resources

- [ ] Les options de `Select` viennent de la BDD (`$site->statusOptions('entity')`)
- [ ] Les labels de colonnes utilisent des traductions ou des labels BDD
- [ ] Les couleurs de badges lisent la BDD

---

## RÉSUMÉ DES FICHIERS À CRÉER

| Fichier | Rôle |
|---------|------|
| `database/migrations/xxxx_create_general_settings_table.php` | Migration table centrale (toutes les colonnes) |
| `database/seeders/GeneralSettingsSeeder.php` | Données par défaut (labels, statuts, sections, catalogues, textes légaux) |
| `app/Models/GeneralSetting.php` | Model central (singleton + cache + casts + accesseurs) |
| `app/Services/SiteConfigService.php` | Couche d'abstraction BDD vers vues (30+ méthodes, cache, label(), statusLabel(), legalText()) |
| `app/Http/View/Composers/SiteSettingsComposer.php` | Injection `$site` + `$settings` dans toutes les vues `front.*` |
| `app/Filament/Admin/Pages/GeneralSettingsPage.php` | Page admin mega-formulaire (tous les onglets) |
| `app/Helpers/ConsentHelper.php` | Lecture cookie consentement pour tracking conditionnel |
| `resources/views/front/layouts/app.blade.php` | Layout principal (CSS vars, tracking, JSON-LD, fonts) |
| `resources/views/front/partials/announcement-bar.blade.php` | Bandeau d'annonce |
| `resources/views/front/partials/header.blade.php` | Header avec navigation BDD |
| `resources/views/front/partials/footer.blade.php` | Footer avec labels BDD |
| `resources/views/front/partials/cookie-consent.blade.php` | Bandeau cookie avec textes BDD |

---

## COMMANDES POST-INSTALLATION

```bash
# Créer les tables
php artisan migrate

# Peupler les données par défaut
php artisan db:seed --class=GeneralSettingsSeeder

# Vider le cache après modification des settings
php artisan cache:clear
php artisan config:clear
```

---

## PRINCIPE FONDAMENTAL

> **Si un administrateur ne peut pas le modifier depuis le panel Filament, c'est un bug.**
>
> Chaque texte, chaque couleur, chaque label, chaque statut, chaque configuration doit avoir son champ dans la BDD et son formulaire dans l'admin.
>
> Le code ne contient que de la logique métier (conditions, boucles, calculs). Le contenu vient TOUJOURS de la BDD.
