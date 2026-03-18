# AUDIT ADMIN NEOGTB — Rapport complet

**Généré le** : 18 mars 2026
**Outil** : Playwright (Chromium headless)
**Pages auditées** : 22 (desktop + mobile = 44 screenshots)
**URL** : http://127.0.0.1:8001/admin

---

## RÉSUMÉ EXÉCUTIF

| Métrique | Valeur |
|----------|--------|
| Problèmes critiques | **6** |
| Problèmes importants | **11** |
| Problèmes mineurs | **9** |
| **Total** | **26** |
| Score UX global estimé | **4.5/10** |
| Temps de chargement moyen | ~1 570 ms |

**Verdict** : L'admin fonctionne (toutes les pages répondent en HTTP 200, toutes les CRUD sont opérationnelles), mais l'interface est un **Filament vanilla non personnalisé**. Aucune identité visuelle NeoGTB, pas de système de bricks, UX basique de formulaires plats. La page Paramètres et la page Maintenance ont des bugs visuels majeurs.

---

## CARTOGRAPHIE COMPLÈTE

```
ADMIN NEOGTB — http://127.0.0.1:8001/admin
│
├── /admin/login                         Login (2 champs, 1 bouton)
│
├── /admin                               Dashboard
│   ├── Widget Welcome (avatar + Sign out)
│   ├── Widget Stats (4 KPI cards : Messages, Articles, Pages, Dernière modif)
│   ├── Widget Derniers messages (tableau 4 colonnes, vide)
│   └── Widget Activité récente (tableau 4 colonnes, 2 entrées)
│
├── CONTENU
│   ├── /admin/pages                     Pages — Liste (8 lignes, 6 colonnes, tri, search)
│   │   ├── /admin/pages/create          Create Page (3 onglets : Contenu/Sections/SEO, 10 champs)
│   │   └── /admin/pages/{id}/edit       Edit Page (mêmes 3 onglets, pré-remplis)
│   │
│   └── /admin/media-library-page        Médiathèque (0 fichiers, upload, search, filtres)
│
├── BLOG
│   ├── /admin/posts                     Articles — Liste (5 lignes, 6 colonnes)
│   │   ├── /admin/posts/create          Create Article (5 onglets : Rédaction/Médias/Catégorie&Tags/SEO/Publication)
│   │   └── /admin/posts/{id}/edit       Edit Article (mêmes 5 onglets, éditeur riche TipTap)
│   │
│   └── /admin/post-categories           Catégories — Liste (4 lignes, 5 colonnes + couleur)
│       ├── /admin/post-categories/create  Create Catégorie (6 champs dont couleur)
│       └── /admin/post-categories/{id}/edit  Edit Catégorie
│
├── COMMUNICATION
│   └── /admin/contact-messages          Messages — Liste (vide, 5 colonnes)
│       └── /admin/contact-messages/{id}/edit  Détail message (non testé — aucun message)
│
├── CONFIGURATION
│   ├── /admin/navigation-menus          Menus — Liste (2 menus : header 8 items, footer 7 items)
│   │   ├── /admin/navigation-menus/create  Create Menu (2 sections : Menu + Éléments repeater)
│   │   └── /admin/navigation-menus/{id}/edit  Edit Menu (repeater avec 8 items dépliés)
│   │
│   └── /admin/site-settings-page        Paramètres du site (8 onglets icônes)
│                                         Contact / Réseaux sociaux / Entreprise / SEO
│                                         Analytics / Apparence / Sécurité / Maintenance
│
├── SYSTÈME
│   ├── /admin/admins                    Administrateurs — Liste (1 admin, 5 colonnes)
│   │   ├── /admin/admins/create         Create Admin (6 champs + avatar upload)
│   │   └── /admin/admins/{id}/edit      Edit Admin
│   │
│   ├── /admin/audit-log-page            Journal d'activité (2 entrées, 5 colonnes)
│   │
│   └── /admin/maintenance-page          Maintenance & Cache
│                                         Mode maintenance / 5 boutons cache / Santé du site
```

---

## PROBLÈMES PAR CATÉGORIE

### 🔴 CRITIQUES (6)

| # | Page | Problème | Détail |
|---|------|----------|--------|
| C1 | `/admin/site-settings-page` | **Icônes onglets géantes et cassées** | Les 8 icônes d'onglets (Contact, Réseaux, etc.) s'affichent en ~100px au lieu de ~20px. Elles prennent toute la largeur et poussent le contenu vers le bas. Totalement inutilisable visuellement. |
| C2 | `/admin/site-settings-page` | **Horaires affichées en JSON brut** | Le champ "Horaires d'ouverture" affiche `{"lun_ven":"09:00 - 18:00","sam":"Fermé","dim":"Fermé"}` en texte brut. Aucun champ structuré pour éditer. |
| C3 | `/admin/maintenance-page` | **Icônes santé du site géantes (300px+)** | Les icônes de santé (X, !, ✓) font ~300px de hauteur chacune. La page fait 4 écrans de scroll juste pour 4 indicateurs. |
| C4 | `/admin/site-settings-page` (mobile) | **Onglets cassés sur mobile** | Les 8 onglets icônes débordent sur 2 lignes, se chevauchent, labels tronqués. Navigation impossible. |
| C5 | `/admin/login` | **Labels en anglais** | "Email address", "Password", "Remember me", "Sign in" — tout en anglais alors que le reste de l'admin est en français. |
| C6 | `/admin` | **"No contact messages" en anglais** | Le widget "Derniers messages" affiche "No contact messages" au lieu d'un message en français. |

### 🟠 IMPORTANTS (11)

| # | Page | Problème |
|---|------|----------|
| I1 | `/admin/pages/create` | **Titre "Create Page" en anglais** au lieu de "Créer une page". Idem boutons "Create & create another", "Cancel" |
| I2 | `/admin/posts/create` | **Titre "Create Article" en anglais** + boutons anglais |
| I3 | `/admin/post-categories/create` | **"Create Catégorie"** — mélange anglais/français |
| I4 | `/admin/navigation-menus/create` | **"Create Menu"** + "Select an option" en anglais dans le dropdown |
| I5 | `/admin/admins/create` | **"Create Administrateur"** — mélange |
| I6 | `/admin/pages/{id}/edit` | **"Edit Page"** + bouton **"Save changes"** + "Cancel" en anglais |
| I7 | `/admin/posts/{id}/edit` | **"Edit Article"** + "Save changes" en anglais |
| I8 | `/admin` (Dashboard) | **"Welcome" et "Sign out" en anglais** dans le widget d'accueil |
| I9 | `/admin/pages` (mobile) | **Colonnes "Publiée", "Ordre", "Modifiée le" masquées** — on ne voit que Page + Slug. Pas d'action Edit visible. |
| I10 | `/admin/navigation-menus/{id}/edit` | **Tous les items dépliés** — 8 items x 6 champs = page très longue, difficile à naviguer. Pas d'accordéon. |
| I11 | `/admin` | **Pas de page Profil admin** — aucun lien trouvé pour modifier son propre profil/mot de passe. |

### 🟡 MINEURS (9)

| # | Page | Problème |
|---|------|----------|
| M1 | `/admin/media-library-page` | **"No media" en anglais** |
| M2 | `/admin/contact-messages` | **"No Messages"** mélange — M majuscule anglais |
| M3 | `/admin/pages` | **Bouton "New Page"** — devrait être "Nouvelle page" |
| M4 | `/admin/posts` | **Bouton "New Article"** en anglais |
| M5 | `/admin/post-categories` | **Bouton "New Catégorie"** — mélange |
| M6 | `/admin/navigation-menus` | **Bouton "New Menu"** en anglais |
| M7 | `/admin/admins` | **Bouton "New Administrateur"** — mélange |
| M8 | `/admin` | **Dashboard widget "Dernière modification" = "16 hours ago"** — en anglais relatif |
| M9 | Toutes les listes | **"Per page" en anglais** dans la pagination |

---

## ANALYSE DES PAGES POUR TRANSFORMATION EN BRICKS

| Page actuelle | Sections identifiables comme bricks | Complexité |
|---|---|---|
| **Accueil** (`/admin/pages/1/edit`) | Hero (titre, sous-titre, CTA, image), Description, Chiffres, Services, Témoignages, FAQ, Contact | **Haute** — 7-8 bricks |
| **Qu'est-ce que la GTB ?** | Hero, Texte riche, Chiffres, Schéma, FAQ | **Moyenne** — 5 bricks |
| **Qu'est-ce que la GTC ?** | Hero, Texte riche, Comparatif, FAQ | **Moyenne** — 4 bricks |
| **Solutions & Technologies** | Hero, Cartes technologies, Tableau comparatif, CTA | **Moyenne** — 4 bricks |
| **Audit GTB Gratuit** | Hero, Formulaire multi-étapes, CTA | **Haute** — brick formulaire custom |
| **Comparateur** | Hero, Tableau comparatif interactif, CTA | **Haute** — brick comparateur custom |
| **Contact** | Hero, Formulaire, Map, Infos contact | **Moyenne** — 4 bricks |
| **À Propos** | Hero, Texte, Équipe, Chiffres, Timeline | **Moyenne** — 5 bricks |

**Problème fondamental actuel** : Chaque page n'a qu'un seul formulaire plat avec des champs Hero (titre, sous-titre, CTA, image) et un onglet "Sections" — mais **pas de système de blocs modulaires**. On ne peut pas ajouter/supprimer/réordonner des sections visuellement. C'est un formulaire classique, pas un page builder.

---

## SYNTHÈSE DES PROBLÈMES PAR DOMAINE

### Localisation (FR) — 20 occurrences
L'admin mélange français et anglais partout. Les labels Filament par défaut ("Create", "Edit", "Save changes", "Cancel", "New", "Per page", "No results") n'ont pas été traduits. La page de login est 100% anglais.

### Design & Branding — Score 2/10
- Aucune couleur NeoGTB (tout est Filament bleu par défaut)
- Pas de logo dans la sidebar ou le header
- Sidebar fond blanc générique
- Aucune personnalisation CSS
- Cards KPI sans icônes colorées
- Pas de design system cohérent

### UX / Ergonomie — Score 4/10
- Pages de formulaires fonctionnelles mais plates
- Bon système d'onglets sur articles (5 onglets bien organisés)
- Éditeur riche TipTap complet et fonctionnel
- Navigation repeater pour les menus (fonctionne mais pas ergonomique)
- Pas de page profil admin
- Pas de preview frontend depuis l'admin

### Fonctionnalités existantes — Score 7/10
- CRUD complet pour : Pages, Articles, Catégories, Menus, Admins
- Médiathèque avec upload
- Journal d'activité
- Paramètres du site (8 onglets)
- Maintenance & cache
- Système de rôles (superadmin, admin, editor, lecteur)

### Mobile — Score 3/10
- Layout responsive Filament de base fonctionne
- Sidebar se transforme en hamburger menu (OK)
- Tableaux perdent des colonnes importantes
- Page Paramètres cassée (onglets icônes débordent)
- Formulaires lisibles mais longs

---

## RECOMMANDATIONS PRIORITAIRES

### Priorité 1 — Corrections critiques (avant Phase 2)
1. **Fixer les icônes géantes** sur Paramètres et Maintenance (CSS `max-width` ou remplacement par icônes Heroicon standard)
2. **Traduire TOUT en français** — installer le package `filament-language-fr` ou créer les fichiers de langue manuellement
3. **Structurer les horaires** en champ repeater au lieu de JSON brut

### Priorité 2 — Système Bricks (Phase 2)
4. Créer la migration `page_bricks` + modèle `PageBrick`
5. Créer l'éditeur visuel de bricks (page Filament custom)
6. Implémenter les 5 bricks essentiels (Hero, Texte, CTA, Cartes, Chiffres)
7. Migrer les données existantes des pages vers le nouveau système bricks

### Priorité 3 — Design & Polish (Phase 2)
8. Design system admin NeoGTB (sidebar sombre, couleurs, typo)
9. Refonte du dashboard (QG de contrôle)
10. Refonte de chaque section (Pages en cards, Médias en galerie, Messages en inbox)

---

## SCREENSHOTS PRIS

| Fichier | Description |
|---------|-------------|
| `00_login_desktop.png` / `_mobile.png` | Page de login |
| `01_dashboard_desktop.png` / `_mobile.png` | Dashboard avec widgets |
| `02_pages_list_desktop.png` / `_mobile.png` | Liste des pages |
| `03_pages_create_desktop.png` / `_mobile.png` | Formulaire création page |
| `04_media_desktop.png` / `_mobile.png` | Médiathèque |
| `05_posts_list_desktop.png` / `_mobile.png` | Liste des articles |
| `06_posts_create_desktop.png` / `_mobile.png` | Formulaire création article |
| `07_categories_list_desktop.png` / `_mobile.png` | Liste des catégories |
| `08_categories_create_desktop.png` / `_mobile.png` | Formulaire création catégorie |
| `09_messages_desktop.png` / `_mobile.png` | Messages de contact |
| `10_navigation_list_desktop.png` / `_mobile.png` | Liste des menus |
| `11_navigation_create_desktop.png` / `_mobile.png` | Formulaire création menu |
| `12_settings_desktop.png` / `_mobile.png` | Paramètres du site |
| `13_admins_list_desktop.png` / `_mobile.png` | Liste des administrateurs |
| `14_admins_create_desktop.png` / `_mobile.png` | Formulaire création admin |
| `15_audit_log_desktop.png` / `_mobile.png` | Journal d'activité |
| `16_maintenance_desktop.png` / `_mobile.png` | Maintenance & Cache |
| `17_page_edit_desktop.png` / `_mobile.png` | Édition page Accueil |
| `18_post_edit_desktop.png` / `_mobile.png` | Édition article GTB |
| `19_category_edit_desktop.png` / `_mobile.png` | Édition catégorie |
| `20_nav_edit_desktop.png` / `_mobile.png` | Édition menu Navigation principale |
| `21_admin_edit_desktop.png` / `_mobile.png` | Édition admin |
| `22_message_detail_desktop.png` | Détail message (page vide) |

**Total : 44 screenshots**
