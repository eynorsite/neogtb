# Audit de sécurité NeoGTB — 2026-09-05

**Repo :** eynorsite/neogtb  
**Architecture :** Site public Laravel/Blade + Admin Filament v5 (sous-domaine admin.neogtb.fr)  
**Auditeur :** Agent autonome OpenClaw  
**Date :** 2026-09-05  

---

## Résumé exécutif

| Sévérité | Trouvées | Corrigées | Issues GitHub |
|----------|----------|-----------|---------------|
| Critical | 2        | 2 ✅       | #66           |
| High     | 4        | 4 ✅       | #67, #68, #69, #70 |
| Medium   | 3        | 3 ✅       | #71, #72, #73 |
| Low      | 2        | 2 ✅       | #75, #76      |
| **Total**| **11**   | **11 ✅**  | **9 issues**  |

Note : issue #74 (clé Brevo) signalée mais nécessite une action manuelle hors code.

---

## Périmètre audité

### Code source
- `admin/app/` — Controllers, Models, Services, Middleware, Filament
- `admin/resources/views/` — Vues Blade, bricks, layouts
- `admin/config/` — Configuration Laravel (session, CORS, services)
- `admin/routes/web.php` — Routes et protection
- `admin/public/.htaccess` — Configuration Apache

### Infrastructure
- `admin/deploy/nginx-neogtb-laravel.conf` — Config nginx production
- `admin/deploy/nginx-neogtb.conf` — Ancienne config nginx (pré-audit 08/2026)

### Dépendances
- npm audit (front-end build)
- composer audit (PHP — non disponible dans l'environnement, analyse manuelle du composer.json)

---

## Détail des vulnérabilités

### 🔴 CRITICAL — Issue #66

**npm : shell-quote (CVE) & concurrently**

- `shell-quote` : `quote()` n'échappe pas les sauts de ligne dans les objets `.op` → injection de commandes shell. `parse()` : DoS quadratique (CWE-407).
- `concurrently` hérite de shell-quote.

**Correction :** `npm audit fix` — 0 vulnérabilité restante.  
**Commit :** `9a8db9f1`

---

### 🟠 HIGH — Issue #67

**npm : vite, postcss, nanoid (CVE)**

- **vite** : divulgation hash NTLMv2 via UNC (Windows), bypass `server.fs.deny`
- **postcss** : path traversal sourceMappingURL → lecture arbitraire de fichiers `.map`
- **nanoid** : boucle infinie avec taille négative ou nulle

**Correction :** `npm audit fix`.  
**Commit :** `9a8db9f1`

---

### 🟠 HIGH — Issue #68

**BrickPreviewController : path traversal via `brick_type` non whitelisté**

La méthode `renderBrick()` construisait le nom de vue dynamiquement depuis la colonne `brick_type` sans validation :

```php
// AVANT (vulnérable)
$html = view("front.bricks.{$brick->brick_type}", [...]);

// APRÈS (corrigé)
$allowedTypes = BrickRegistry::types();
if (!in_array($brick->brick_type, $allowedTypes, true)) {
    return response()->json(['error' => 'Invalid brick type'], 422);
}
$html = view("front.bricks.{$brick->brick_type}", [...]);
```

**Exploitabilité :** Nécessite un accès admin ou compromission DB.  
**Correction :** Whitelist via BrickRegistry.  
**Commit :** `22bda1cb`

---

### 🟠 HIGH — Issue #69

**XSS stocké : bricks `fondateur.titre` et `hero-image.pre_titre` sans purification**

```blade
{{-- AVANT (vulnérable) --}}
{!! $content['titre'] !!}

{{-- APRÈS (corrigé) --}}
{!! \Stevebauman\Purify\Facades\Purify::clean($content['titre']) !!}
```

**Impact :** XSS côté public via l'admin si rôle compromis.  
**Commit :** `f03b735c`

---

### 🟠 HIGH — Issue #70

**`custom_head_code`/`custom_body_code` accessibles aux rôles admin et éditeur**

Ces champs sont injectés sans filtrage sur chaque page publique (nécessaire pour le tracking). Ils étaient modifiables par tout administrateur ou éditeur.

```php
// AVANT
Section::make('Code personnalisé')

// APRÈS
Section::make('Code personnalisé')
    ->visible(fn () => $this->getRole() === 'superadmin')
```

**Commit :** `012efd2f`

---

### 🟡 MEDIUM — Issue #71

**npm : DOMPurify ≤ 3.4.12 et fflate (CVE)**

- DOMPurify : bypass sanitization via `CUSTOM_ELEMENT_HANDLING`, pollution `ALLOWED_ATTR`, XSS via hook `IN_PLACE`
- fflate : DoS boucle infinie sur ZIP64 malformé

**Correction :** `npm audit fix`.  
**Commit :** `9a8db9f1`

---

### 🟡 MEDIUM — Issue #72

**`SESSION_ENCRYPT` default `false` — sessions non chiffrées sur env. mal configuré**

```php
// AVANT
'encrypt' => env('SESSION_ENCRYPT', false),

// APRÈS
'encrypt' => env('SESSION_ENCRYPT', true),
```

**Commit :** `e6e93fb7`

---

### 🟡 MEDIUM — Issue #73

**nginx-neogtb.conf : ancienne config avec 8 problèmes de sécurité (risque déploiement accidentel)**

Fichier marqué OBSOLÈTE avec avertissement et liste des problèmes.  
**Commit :** `a269543c`

---

### 🟡 MEDIUM — Issue #74 ⚠️ ACTION MANUELLE REQUISE

**Clé Brevo potentiellement exposée — révocation non vérifiable par code**

Le fichier `SECURITY_NOTES.md` signale qu'une clé Brevo a été exposée. Vérifier et révoquer manuellement sur app.brevo.com.

**Aucun commit — action humaine requise.**

---

### 🔵 LOW — Issue #75

**npm : esbuild 0.27.3-0.28.0 — lecture fichiers en dev (Windows uniquement)**

**Correction :** `npm audit fix`. Impact nul en production Linux.  
**Commit :** `9a8db9f1`

---

### 🔵 LOW — Issue #76

**`.htaccess` — headers et protection fichiers sensibles absents (fallback Apache)**

En production nginx, les protections sont déjà en place. Correction appliquée pour couvrir un éventuel environnement Apache.  
**Commit :** `73ccdf8a`

---

## Ce qui était déjà bien sécurisé

Le projet présente un niveau de sécurité global solide, notamment :

- **CSP robuste avec nonce** : `FrontCspHeader` middleware, `@alpinejs/csp` (sans `unsafe-eval`), nonce Vite
- **CORS correctement configuré** : origines restreintes à `neogtb.fr` + `APP_URL`
- **CSRF** : `PreventRequestForgery` middleware actif sur toutes les routes web
- **Rate limiting** : tous les formulaires publics (`throttle:5,1`), chatbot (`throttle:30,1`), RGPD (`throttle:10,1`)
- **Honeypots anti-bot** : champ `_gotcha` avec règle `prohibited` sur tous les formulaires
- **Validation côté serveur** : `FormRequest` avec `email:rfc`, `not_regex:/[\r\n]/`, max longueurs
- **Purification HTML** : `Purify::clean()` sur le contenu article et les bricks texte
- **Chiffrement PII** : `last_login_ip` chiffré en DB, cast `'encrypted'`
- **Soft deletes + audit log** : `SoftDeletes` sur Admin, `AdminActivityLog`
- **Double opt-in newsletter** : token de confirmation signé
- **Gestion RGPD complète** : consentement, droits, politique de confidentialité, registre des traitements
- **Headers nginx production complets** : HSTS, COOP, CORP, X-Frame-Options, Permissions-Policy, X-Robots-Tag admin
- **Isolation admin.neogtb.fr** : sous-domaine dédié, redirection 301 depuis le domaine public
- **Protection fichiers sensibles nginx** : `return 444` sur `.env`, `.git`, manifests Vite
- **Session** : `SESSION_SECURE_COOKIE=true`, `SESSION_SAME_SITE=strict`, driver `database`, sérialisation JSON (pas PHP)
- **Admin** : auth guard dédié, rôles (superadmin/admin/éditeur), `EnsureAdminIsActive` middleware

---

## Commits de correction (dans l'ordre)

| Hash | Description |
|------|-------------|
| `9a8db9f1` | npm audit fix — 8 vulnérabilités (2 critical, 3 high, 2 moderate, 1 low) |
| `22bda1cb` | BrickPreviewController — whitelist brick_type |
| `f03b735c` | XSS — Purify::clean() sur fondateur.titre et hero-image.pre_titre |
| `a269543c` | nginx-neogtb.conf marqué OBSOLÈTE |
| `012efd2f` | custom_head_code/custom_body_code restreints au superadmin |
| `e6e93fb7` | SESSION_ENCRYPT default false→true |
| `73ccdf8a` | .htaccess — protection fichiers sensibles + headers Apache |

---

## Recommandations restantes (non corrigées par cet audit)

1. **Révoquer la clé Brevo exposée** (issue #74) — action manuelle sur app.brevo.com
2. **Envisager de supprimer** `admin/deploy/nginx-neogtb.conf` ou le renommer en `.deprecated`
3. **Passer DMARC en `p=reject`** une fois la politique de quarantaine validée (cf. SECURITY_HARDENING.md)
4. **Ajouter les records CAA DNS** pour neogtb.fr (cf. SECURITY_HARDENING.md)
5. **Audit Composer** : `composer audit` non disponible dans cet environnement — à exécuter en production (`composer audit` depuis `/var/www/neogtb/current/admin/`)
6. **Rotation périodique des sessions admin** : envisager une durée de session plus courte pour l'admin Filament (actuellement 120 min)

---

*Audit généré automatiquement par l'agent OpenClaw — 2026-09-05*
