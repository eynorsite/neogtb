# AUDIT NEOGTB — RAPPORT PRÉLIMINAIRE ADMIN

**Date** : 18 mars 2026
**Agents** : ✅ ARCHITECT | ✅ SECURITY

---

## 1. ÉTAT ACTUEL DU PROJET

### Stack détectée
| Élément | Valeur |
|---------|--------|
| Framework | **Astro 5.17.1** (SSG — Static Site Generation) |
| CSS | Tailwind CSS 4.2.1 + @tailwindcss/typography |
| JS interactif | Alpine.js 3.x (via CDN) |
| Build | Vite (intégré Astro) |
| Backend | **AUCUN** — pas de PHP, pas de Laravel |
| Base de données | **AUCUNE** |
| Authentification | **AUCUNE** |
| composer.json | **ABSENT** |
| .env | **ABSENT** |

### Conclusion critique
> ⚠️ **NeoGTB est un site 100% statique (Astro/Node.js).** Il n'y a aucune infrastructure Laravel en place. La création de l'admin nécessite d'initialiser un projet Laravel complet en parallèle ou de migrer l'existant.

---

## 2. TABLES EXISTANTES EN BDD

**Aucune base de données n'existe.** Tout le contenu est :
- **Codé en dur** dans les fichiers `.astro` (pages)
- **En Markdown** dans `src/content/blog/` (articles)

---

## 3. MODÈLES EXISTANTS

**Aucun modèle Eloquent.** Pas de PHP dans le projet.

---

## 4. ROUTES EXISTANTES

**Routage Astro (fichiers → URL)** :

| Fichier | Route |
|---------|-------|
| `src/pages/index.astro` | `/` |
| `src/pages/gtb.astro` | `/gtb` |
| `src/pages/gtc.astro` | `/gtc` |
| `src/pages/solutions.astro` | `/solutions` |
| `src/pages/audit.astro` | `/audit` |
| `src/pages/contact.astro` | `/contact` |
| `src/pages/about.astro` | `/about` |
| `src/pages/comparateur.astro` | `/comparateur` |
| `src/pages/blog/index.astro` | `/blog` |
| `src/pages/blog/[...slug].astro` | `/blog/{slug}` |

**Route `/admin`** : ❌ Non définie → **aucun conflit** avec Filament.

---

## 5. CONTENU CODÉ EN DUR À MIGRER

### 5.1 Informations de contact
- **Email** : `contact@neogtb.fr`
- **Localisation** : France (pas d'adresse précise)
- **Téléphone** : non renseigné
- **Réseaux sociaux** : aucun

### 5.2 Contenu des pages (tout hardcodé)

| Page | Contenu à extraire |
|------|-------------------|
| **Accueil** | Hero (titre, sous-titre, CTA), stats (40% économies, 30% maintenance), 7 cartes thématiques |
| **GTB** | Définition, 5 chiffres clés, 6 fonctions principales, 4 niveaux EN 15232, architecture 3 niveaux |
| **GTC** | Définition, 5 fonctions, tableau comparatif GTB/GTC, 3 composants |
| **Solutions** | 4 protocoles (BACnet, KNX, Modbus, LON), 5 capteurs/actionneurs, 3 tendances |
| **Audit** | 8 questions wizard, logique de scoring, recommandations par classe (D/C/B/A) |
| **Contact** | Formulaire (nom, email, société, sujet, message) — **NON FONCTIONNEL** (action="#") |
| **À propos** | Mission, valeurs, audiences cibles |
| **Comparateur** | **15 marques** avec données détaillées (score, produits, protocoles, budget, 6 critères) |

### 5.3 Blog (Markdown)
- **5 articles** dans `src/content/blog/`
- Schema : title, description, date, author, category, tags, image, featured
- À migrer vers une table `posts` en BDD

### 5.4 Navigation
- **Header** : 8 liens (Accueil, GTB, GTC, Solutions, Comparateur, Blog, Audit CTA, Contact)
- **Footer** : 3 colonnes (Brand, Navigation, Contact)

### 5.5 SEO (basique)
- Meta title/description par page (dans Layout.astro)
- Favicon SVG + ICO
- **Manquant** : Open Graph, Schema.org, Twitter Cards, sitemap custom

---

## 6. DESIGN SYSTEM

### Palette de couleurs
| Token | Couleur | Hex principal |
|-------|---------|--------------|
| Primary | Bleu | `#2563eb` (primary-600) |
| Accent | Vert | `#22c55e` (accent-500) |
| Dark | Slate | `#0f172a` (dark-900) |

### Typographie
- **Corps** : Inter (400, 500, 600, 700)
- **Titres** : Plus Jakarta Sans (600, 700, 800)

### Couleurs par domaine
- CVC → Rouge | Éclairage → Jaune | Énergie → Bleu
- Sécurité → Vert | Automatisme → Violet | Reporting → Cyan

---

## 7. DÉPENDANCES UTILES POUR L'ADMIN

**Depuis le projet Astro** : aucune (écosystème Node.js, pas PHP).

**À installer pour Laravel + Filament** :
```
laravel/laravel (fresh install)
filament/filament:^3.0
spatie/laravel-backup (sauvegardes)
intervention/image (optimisation images)
```

---

## 8. AUDIT SÉCURITÉ

### État actuel
| Point | Statut |
|-------|--------|
| Système d'auth existant | ❌ Aucun |
| Route `/admin` exposée | ❌ N'existe pas (pas de conflit) |
| Données sensibles dans le code | ⚠️ Email contact@neogtb.fr hardcodé |
| Formulaire contact | ⚠️ Non fonctionnel (pas de backend) |
| Protection CSRF | ❌ Aucune (pas de backend) |
| Variables d'environnement | ❌ Aucun `.env` |

### Recommandations sécurité
1. Guard admin séparé (table `admins`, pas `users`)
2. 2FA obligatoire pour le panel admin
3. Rate limiting sur `/admin/login`
4. Headers `X-Robots-Tag: noindex` sur toutes les routes `/admin/*`
5. Stockage des uploads hors `public/` avec accès sécurisé

---

## 9. RECOMMANDATION ARCHITECTURALE

### Option retenue : **Laravel séparé dans le même repo**

```
/Users/calmoulrich/Documents/neogtb/
├── src/                    ← Frontend Astro (existant, inchangé)
├── public/                 ← Assets statiques Astro
├── admin/                  ← NOUVEAU : Projet Laravel/Filament
│   ├── app/
│   ├── config/
│   ├── database/
│   ├── routes/
│   └── ...
├── package.json            ← Astro
├── astro.config.mjs        ← Astro
└── CLAUDE.md
```

**Pourquoi cette approche** :
- ✅ Isolation totale — le frontend Astro reste intact
- ✅ Pas de conflit de routes
- ✅ Déploiement indépendant possible
- ✅ Le frontend peut consommer l'API Laravel pour les données dynamiques (contact, blog)
- ✅ Filament v3 recommandé (mature, complet, bien maintenu)

### Alternative : Laravel à la racine
On pourrait aussi initialiser Laravel à la racine et garder Astro comme build tool pour le frontend. Mais cela mélange les deux écosystèmes.

---

## 10. PRÉREQUIS TECHNIQUES

Avant de commencer l'Étape 1, vérifier :
- [ ] PHP 8.2+ installé (`php -v`)
- [ ] Composer installé (`composer -V`)
- [ ] MySQL/MariaDB ou SQLite disponible
- [ ] Node.js 18+ (déjà en place pour Astro)

---

## VALIDATION REQUISE

Avant de passer à l'**Étape 1 — Fondations**, confirme :

1. **Approche architecturale** : Laravel dans un sous-dossier `admin/` ou à la racine ?
2. **Base de données** : MySQL/MariaDB ou SQLite pour le dev ?
3. **Hébergement cible** : Le serveur supporte-t-il PHP ? (Vercel/Netlify = non)
4. **Priorité** : On commence par quel bloc après les fondations ?
