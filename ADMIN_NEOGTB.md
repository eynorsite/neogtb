# Admin NeoGTB — Documentation

**Stack** : Laravel 12 + Filament 5 + MySQL
**URL locale** : http://127.0.0.1:8001/admin
**Lancement** : `cd admin && php artisan serve --port=8001`

---

## Architecture générale

L'admin NeoGTB suit l'**architecture BIMACAD** — 100% base de données, zéro texte hardcodé. Toute la configuration du site (textes, couleurs, navigation, SEO, textes légaux, statuts) est stockée dans une table monolithique `general_settings` et éditable depuis Filament.

### Table centrale : `general_settings`

Pattern singleton : une seule ligne en BDD, modèle `App\Models\GeneralSetting` avec méthode statique `::get()` + cache applicatif.

**Colonnes principales** :
- Identité entreprise (name, tagline, logo, email, phone, SIRET, RCS, APE, TVA, etc.)
- Thème (primary/secondary/accent colors, font_pair, border_radius, shadow, color_scheme)
- Navigation (nav_items JSON, nav_style, nav_sticky, nav_show_phone, nav_cta_*)
- Homepage (homepage_sections + homepage_sections_config)
- Pages spécifiques (gtb/gtc/solutions/audit/contact/about/faq/comparateur _page_config)
- **UI Labels** (JSON) — 250 textes front éditables
- Status configs (JSON) — labels/couleurs/icônes des workflows
- Legal texts (JSON) — mentions, confidentialité, cookies, CGU
- SEO & tracking (GA, GTM, Plausible, Crisp, Hotjar)
- Catalogues (blog_categories, gtb_protocols, en15232_levels, font_pairs)
- Annonce bandeau, email SMTP, RGPD retention, sécurité

### Service `SiteConfigService`

Singleton injecté dans toutes les vues Blade via `SiteSettingsComposer` → variables `$site` et `$settings` disponibles partout.

**Méthodes clés** :
- `$site->label(string $path, string $default)` — lit `ui_labels.*.*` avec dot notation
- `$site->legalText(string $key)` — lit les textes légaux HTML
- `$site->cssVariables()` — génère `<style>:root{...}</style>` depuis la BDD
- `$site->navigation()` — items de nav filtrés (visible=true)
- `$site->jsonLd()` — Schema.org Organization JSON-LD
- `$site->trackingScripts($consent)` — GA/GTM/Pixel/Hotjar conditionnels au consentement
- `$site->announcementBar()` — bandeau d'annonce dismissable
- `$site->socialLinks()` — réseaux sociaux filtrés
- `$site->statusLabel/Color/Icon()` — workflows dynamiques

### View Composer

`App\Http\View\Composers\SiteSettingsComposer` injecte `$site` (service) et `$settings` (model) dans toutes les vues `front.*`. Purge de cache automatique via `SiteSettingObserver` quand un admin modifie la config.

---

## Structure de la sidebar admin

### MON SITE
Gestion éditoriale des pages dynamiques (système Bricks / Page Builder) :
- **Page d'accueil** — `SitePage` accueil avec `PageBrick` réordonnables
- **Pages** — CRUD des SitePage avec leurs bricks
- **Méthodologie** — page spécifique
- **Mentions du site** — pages éditoriales courtes

→ Chaque page est composée de bricks (Hero, CTA, Cartes, Comparatif, Timeline, Témoignages, etc.) stockés dans la table `page_bricks`, réordonnables et éditables individuellement.

### BLOG
- **Articles** — model `Post` (title, slug, excerpt, body HTML, category, tags, views_count, published_at)
- **Catégories** — model `PostCategory` (hiérarchie + couleur + icône)

### BOÎTE DE RÉCEPTION
- **Messages** — `ContactMessage` (form /contact, chiffrement PII, honeypot)
- **Leads diagnostic GTB** — `AuditLead` (score, building_type, surface, savings_euro, payload JSON)
- **Leads CEE** — `CeeLead`
- **Suivi RGPD** — `GdprRequest` (types: access, rectification, deletion, portability, opposition)
- **Droits visiteurs (RGPD)** — `CookieConsent` (visitor_id, consents JSON, policy_version)

### RÉGLAGES
- **Paramètres généraux** — **SiteSettingsPage** (19 tabs, voir ci-dessous)
- **Administrateurs** — CRUD des admins (roles: superadmin, admin, editeur)
- **Historique des actions** — `AdminActivityLog` (audit trail automatique via Observer)
- **Maintenance** — mode maintenance + cache + purge

---

## SiteSettingsPage — 19 tabs organisés en 8 groupes premium

La page centrale BIMACAD. Accessible via **Réglages → Paramètres généraux** (`/admin/site-settings-page`).

### G1 — Identité & Marque
1. **Général** — nom, slogan, site web, description, coordonnées (email, phone), adresse, SIRET/RCS/APE, infos légales
2. **Identité visuelle** — logo principal, logo blanc, logo carré, favicon, OG default image

### G2 — Apparence & Thème
3. **Couleurs** — 12 couleurs (primary, secondary, accent, header_bg/text, footer_bg/text, body_bg, cta_bg/text, hero_overlay + opacity) + ColorPicker Filament + presets (gtb_pro, eco_green, tech_blue)
4. **Typographie** — Select `font_pair` dynamique depuis `font_pairs_config` BDD (Inter/DM Sans, Poppins/Lora, Montserrat/Roboto, etc.) + font_size_base (sm/md/lg) + border_radius_style + shadow_style
5. **Bandeau d'annonce** — toggle + texte + URL + couleurs + dismissable (persistance localStorage côté front)

### G3 — Navigation
6. **Navigation** — nav_items JSON (Repeater), nav_style (sticky/static/transparent), nav_cta_text/url/visible, nav_show_phone, nav_show_search, nav_search_placeholder

### G4 — Page d'accueil & Contenu
7. **Page d'accueil** — homepage_sections (ordre) + homepage_sections_config (contenu par section : hero, expertises/cas-usage, chiffres, comparatif, solutions, témoignages, FAQ, CTA audit, blog_recent)

### G5 — SEO & Tracking
8. **SEO** — meta title suffix, default description, robots, schema type, Google verification
9. **Tracking** — Google Analytics ID, GTM, Meta Pixel, Crisp Chat, Hotjar, Google Maps API key

### G6 — Textes & Labels (cœur de l'admin)
10. **Labels d'interface** — **19 sections collapsibles × 250 champs** couvrant tous les textes du site front :
    - Navigation (13 champs)
    - Layout & fil d'Ariane
    - Pied de page (brand_description, col1/2/3_title, newsletter, 15 liens nav_*, manage_cookies)
    - Formulaires (contact + wizard audit)
    - Validation (messages d'erreur)
    - CTA globaux
    - Sticky CTA (mobile)
    - Bandeau cookies
    - Pagination & divers
    - Page Contact
    - Page FAQ
    - Page Blog
    - Page About (RichEditor sur story.content)
    - Page Positionnement
    - Page Audit Hero & étapes
    - Page Audit Lots techniques
    - Page Audit Résultats
    - Page Audit Premium & modal PDF
    - Newsletter confirmée
    - Pages légales (eyebrow + title)

    → Chaque section est collapsible, contient des TextInput (strings courts) ou Textarea (textes longs/HTML), pré-remplis avec les valeurs actuelles de la BDD. **Éditable en un clic**.

11. **Textes légaux** — RichEditor pour mentions_legales, politique_confidentialite, cgu, cookies (HTML complet avec h2/h3/p/ul)

### G7 — Communication
12. **Réseaux sociaux** — URLs LinkedIn, Facebook, YouTube, Instagram, Twitter/X, TikTok (affichage dynamique dans footer)
13. **Email** — SMTP host/port/encryption/username/password, from_name, from_email

### G8 — Système
14. **Avancé** — custom_head_code + custom_body_code (injectés dans layout)
15. **Statuts & Workflows** — Repeater pour définir les labels/couleurs/icônes des statuts par entité (post, audit_lead, cee_lead, contact_message, gdpr_request)
16. **Catalogues** — gtb_protocols_config (7 protocoles BACnet/KNX/Modbus/LON/DALI/MQTT/EnOcean), en15232_levels_config, blog_categories_config, font_pairs_config
17. **Sécurité** — politique mot de passe, 2FA, session lifetime, rate limiting
18. **RGPD** — retention durées (contacts, leads, cookies, newsletter), DPO, référent handicap, info accessibilité
19. **Statistiques** — KPI manuels (buildings_audited, avg_savings_percent, years_experience, clients_count) avec toggle auto/manuel

---

## Système de labels 100% administrables

### Pattern utilisé dans les Blade

```blade
{{ $site->label('audit.hero.title', 'Pré-diagnostic GTB de votre bâtiment') }}
```

Le 2e argument est le **fallback** si la clé n'existe pas en BDD. Mais comme le seeder peuple la BDD avec toutes les valeurs, **la BDD est toujours la source de vérité**.

### Stockage

Table `general_settings`, colonne `ui_labels` (JSON), structure nested :

```json
{
  "audit": {
    "hero": {
      "title": "Pré-diagnostic GTB de votre bâtiment",
      "subtitle": "Évaluez votre conformité...",
      "eyebrow": "Diagnostic gratuit · Rapport PDF"
    },
    "step1_title": "Décrivez votre bâtiment",
    "results": { "score_label": "Score de maturité GTB", ... }
  },
  "contact": { "success_title": "...", ... },
  "footer": { "col3_title": "Légal", ... },
  "nav": { "explorer": "Explorer", ... },
  "faq": { "title": "...", ... },
  ...
}
```

### 20 groupes top-level (250 labels)

`about`, `audit`, `blog`, `breadcrumb`, `contact`, `cookie`, `cta`, `faq`, `footer`, `forms`, `layout`, `legal`, `misc`, `nav`, `newsletter`, `pagination`, `positionnement`, `search`, `sticky_cta`, `validation`

### Flow complet

```
Admin modifie un texte dans Filament
         ↓
GeneralSetting saved → SiteSettingObserver
         ↓
SiteConfigService::clearCache() purge tous les caches
         ↓
Prochaine requête front → $site->label() lit depuis BDD
         ↓
Nouveau texte affiché immédiatement
```

---

## Seeder initial

**Fichier** : `admin/database/seeders/GeneralSettingsSeeder.php`

**Commande** : `php artisan db:seed --class=GeneralSettingsSeeder --force`

Utilise `updateOrCreate(['id' => 1], [...])` pour être idempotent. Peuple :
- Identité entreprise par défaut (NeoGTB, slogan, description, coordonnées)
- Thème par défaut (palette NeoGTB verte)
- 250 labels UI extraits des 15 fichiers Blade front
- Homepage sections config (9 sections éditoriales)
- FAQ page config (11 Q/R réparties en 3 catégories)
- Legal texts complets (mentions, confidentialité, cookies, CGU)
- Status configs pour toutes les entités métier
- Catalogues (7 protocoles GTB, 8 paires de fonts, 4 niveaux EN 15232)

---

## Fichiers clés

### Configuration
- `admin/app/Models/GeneralSetting.php` — Model singleton (casts, accesseurs, observer)
- `admin/app/Services/SiteConfigService.php` — Service central (cache, label, jsonLd, tracking)
- `admin/app/Services/HomepageSectionsService.php` — Service dédié homepage
- `admin/app/Http/View/Composers/SiteSettingsComposer.php` — Injection $site/$settings dans les vues
- `admin/app/Providers/AppServiceProvider.php` — Bindings + memory limit admin

### Filament
- `admin/app/Filament/Pages/SiteSettingsPage.php` — Page principale 19 tabs (1708 lignes)
- `admin/app/Filament/Pages/HomepagePage.php` — Éditeur Bricks homepage
- `admin/app/Filament/Resources/` — CRUD models (Post, ContactMessage, AuditLead, etc.)

### Migrations
- `2026_04_10_400000_create_general_settings_table.php` — Structure initiale
- `2026_04_10_500000_add_missing_columns_to_general_settings.php`
- `2026_04_11_000000_add_bimacad_columns_to_general_settings.php` — APE, dark mode, search, video, Crisp
- `2026_04_11_000001_add_accessibility_columns_to_general_settings.php`

### Seeder
- `admin/database/seeders/GeneralSettingsSeeder.php` — Toutes les valeurs par défaut

---

## Commandes utiles

### Installation initiale
```bash
cd admin
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed --class=GeneralSettingsSeeder --force
php artisan storage:link
php artisan serve --port=8001
```

### Purger les caches après modif
```bash
php artisan cache:clear && php artisan view:clear && php artisan config:clear && php artisan route:clear
```

### Re-peupler les labels (idempotent)
```bash
php artisan db:seed --class=GeneralSettingsSeeder --force
```

### Créer un admin
```bash
php artisan tinker
>>> App\Models\Admin::create(['name' => 'Test', 'email' => 'test@neogtb.fr', 'password' => bcrypt('password'), 'role' => 'superadmin']);
```

---

## Architecture des pages front

### Pages avec Bricks (éditables via Mon Site → Pages)
- `/` (accueil) — SitePage slug=accueil avec PageBricks réordonnables
- Autres pages dynamiques si créées dans l'admin

### Pages Blade statiques avec labels administrables
- `/gtb`, `/gtc`, `/solutions`, `/audit`, `/contact`, `/blog`, `/faq`, `/about`, `/positionnement`, `/reglementation`, `/comparateur`, `/generateur-cee`, `/tables-modbus`
- `/mentions-legales`, `/politique-de-confidentialite`, `/cookies`, `/mes-droits-rgpd`, `/newsletter-confirmee`
- **Structure** : Blade `@extends('front.layouts.app')` + contenu avec `$site->label()` partout
- **Textes administrables** via **Réglages → Paramètres généraux → Labels d'interface**

---

## Règles d'isolation BIMACAD

1. **Zéro hardcode** — aucun texte, couleur, label, URL hardcodé dans les vues. Tout passe par `$site->label()` ou `$site->get()`.
2. **Une seule source de vérité** — la table `general_settings` est canonique. Les doublons (comme l'ancien `SiteSetting` key-value) ont été supprimés.
3. **Cache applicatif** — `Cache::remember('site_css_variables', 3600, ...)` + purge auto via observer.
4. **Pas de doublons de tabs** — le tab "Pages" précédent a été supprimé car il dupliquait le système Bricks (Mon Site → Pages).
5. **Séparation des responsabilités** :
   - **Mon Site** → contenu éditorial (bricks, pages dynamiques)
   - **Blog** → articles & catégories
   - **Boîte de réception** → CRM (messages, leads, RGPD)
   - **Réglages** → configuration globale (identité, thème, SEO, labels, légal)

---

## Workflow type pour modifier un texte

1. Admin se connecte sur http://127.0.0.1:8001/admin
2. Sidebar → **Réglages** → **Paramètres généraux**
3. Onglet **Labels d'interface**
4. Déplier la section concernée (ex. "Page FAQ")
5. Modifier le texte dans le champ (ex. changer "Vos questions sur la GTB/GTC" en "Questions fréquentes")
6. Cliquer **Enregistrer les paramètres** en bas
7. Observer purge le cache → la page front affiche immédiatement le nouveau texte

**Aucun déploiement**, **aucune édition de code**, **aucun redémarrage** nécessaire.

---

## Rôles et permissions

- **superadmin** — accès total à tous les tabs et CRUD
- **admin** — accès à tous les tabs sauf "Sécurité" et "RGPD retention"
- **editeur** — accès uniquement aux tabs Labels, Textes légaux, Pages contenu

Défini dans `SiteSettingsPage::canAccess()` et dans les Filament Resource Policies.

---

## Audit & historique

Chaque action (create/update/delete) sur les models admin-managed (`GeneralSetting`, `SitePage`, `Post`, `ContactMessage`, `AuditLead`, etc.) est automatiquement tracée dans `admin_activity_logs` via `AdminAuditObserver`.

Consultable via **Réglages → Historique des actions**.

---

**Version** : 2.0
**Dernière mise à jour** : 2026-04-11
**Maintenu par** : équipe NeoGTB
