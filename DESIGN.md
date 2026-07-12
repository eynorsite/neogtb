# Design System — NeoGTB

> Source de vérité unique du design NeoGTB (site public **et** back-office admin).
> Toujours lire ce fichier avant toute décision visuelle ou UI. Les valeurs ci-dessous
> sont **extraites du code réel en production**, pas d'une intention : le front vient de
> `admin/resources/css/app.css` + `admin/resources/css/front/home-components.css`, l'admin
> de `admin/resources/views/filament/hooks/admin-styles.blade.php` +
> `app/Providers/Filament/AdminPanelProvider.php`.
>
> Documents **historiques à NE PAS suivre** (obsolètes, contredits par le code) :
> `README.md` (starter Astro), `CLAUDE.md` §Stack (React/Lovable), `CONFORMITE_RGPD_NEOGTB.md`
> §technique (Vercel/GA4), `design-refs/_index.md` §reco couleurs (accent violet `#534AB7`),
> `ROADMAP.md` §fonts (Plus Jakarta Sans), `RAPPORT_AUDIT_DESIGN_V2.md` (admin d'avant la v2.0).

---

## 0. Principe directeur — « Tiers de confiance »

**Ce qu'un visiteur doit retenir après sa 1ʳᵉ visite : l'indépendance.**
NeoGTB est le tiers de confiance indépendant de la GTB en France (« Nous ne vendons rien »).
Le design doit **prouver** cette neutralité, pas seulement l'affirmer.

Règle de décision — face à un choix visuel, préférer toujours l'option qui renforce la
confiance et la neutralité plutôt que l'option « qui vend » :

| Faire (prouve la confiance) | Éviter (ressemble à un vendeur) |
|---|---|
| Sobriété institutionnelle, data factuelle, sources citées | Survente, superlatifs, urgence agressive |
| Navy calme + vert mesuré, aplats francs | Dégradés tape-à-l'œil, néons, violets « SaaS » |
| Espaces aérés, hiérarchie claire, lisibilité | Densité commerciale, pop-ups intrusifs |
| Badge « Indépendant — aucun lien commercial » | Logos fabricants sans mention de neutralité |

Tout élément qui pourrait faire croire que NeoGTB vend du matériel ou représente une
marque est un **bug de design**, pas un détail.

---

## 1. Product Context

- **Ce que c'est :** site éducatif + outils interactifs + prestations AMO sur la GTB/GTC
  (Gestion Technique du Bâtiment), positionné en tiers de confiance indépendant.
- **Pour qui :** décideurs B2B de bâtiments **tertiaires**, en priorité PME/TPE propriétaires
  de 1 000–5 000 m² face au décret BACS (segment délaissé par les grands intégrateurs).
- **Espace / secteur :** GTB / smart building / conformité réglementaire. Pairs analysés
  (18 acteurs) : Siemens, Schneider, Honeywell, Johnson, Sauter, Distech (intégrateurs) ;
  KNX, GIMELEC, ADEME, COSTIC (organismes) ; CYRISEA, NEXTIIM, E&F Consulting, BTIB (PME).
- **Type de projet :** hybride — **site marketing/éditorial** (front public, orienté
  autorité + conversion douce) + **application d'admin** (back-office Filament).
- **Fondateur / auteur :** Ulrich Calmo.
- **Moteur produit :** décret BACS n° 2025-1343 (>290 kW obligatoire depuis 2025 ;
  70–290 kW reporté à **2030**), décret tertiaire, CEE BAT-TH-116, norme EN 15232 / ISO 52120-1.

---

## 2. Aesthetic Direction

- **Direction :** *Industrial/Utilitarian raffiné en clair* — rigueur institutionnelle,
  fonctionnelle, orientée data, mais lumineuse et accessible (pas corporate froid, pas SaaS ludique).
- **Niveau de décoration :** `intentional` — la typo et la mise en page portent le message ;
  décor limité à des halos floutés et orbs discrets, jamais d'ornement gratuit.
- **Mood :** clair, calme, expert, digne de confiance. « Un cabinet de conseil qui aurait
  aussi un très bon site. » Lumière plutôt qu'ombre, aplats plutôt que dégradés criards.
- **Signature visuelle :** hero **light mode** (fond blanc → `primary-50`, aucun overlay
  sombre) animé par des orbs ronds et des halos pulsés très doux ; CLS = 0 ; toutes les
  animations coupées par `prefers-reduced-motion`.
- **Sites de référence (cible) :** axelia-energie.fr (direction globale, clair/institutionnel),
  smt-en.com (offres), ef-consulting.com (AMO/FAQ), nextiim.com (pédagogie décret).
  Réfs premium internes : `design-refs/` (40 sites français scrapés + tokens).

---

## 3. Typography

- **Display / Hero :** **DM Sans** (`--font-display` / `--font-heading`) — géométrique,
  contemporain, autoritaire sans être froid. Poids 700–800 pour les titres.
- **Body :** **Inter** (`--font-sans`) — neutre, ultra-lisible, excellent en petit corps
  et en tableaux denses.
- **UI / Labels :** identique au body (Inter).
- **Data / Tables :** Inter avec `tabular-nums` pour l'alignement des chiffres (comparateur,
  jauges EN 15232, KPI admin).
- **Code :** non utilisé sur le produit (aucun bloc de code public).
- **Chargement :** **auto-hébergé** via `@fontsource-variable/inter` +
  `@fontsource-variable/dm-sans` (RGPD — **aucune** dépendance Google Fonts, contrainte
  non négociable).
- **Échelle (px, définie dans `@theme`) :**

  | Token | px | Usage type |
  |---|---|---|
  | `text-xs` | 12 | légendes, méta (⚠ `.eyebrow` et `.tag` codent 11px en dur, hors token) |
  | `text-sm` | 14 | corps secondaire, méta |
  | `text-base` | 16 | corps courant |
  | `text-lg` | 20 | chapô, sous-titres |
  | `text-xl` | 24 | titres de section mineurs |
  | `text-2xl` | 28 | H3 |
  | `text-3xl` | 32 | H2 |
  | `text-4xl` | 40 | gros titres |
  | `text-5xl` | 48 | hero mobile / titres forts |
  | `text-6xl` | 56 | hero desktop |
  | `text-7xl` | 72 | titres d'exception |

  H1 hero de référence : ~60px desktop, poids 700, `line-height: 1.1`. Nom de marque
  (« GTB / GTC / NeoGTB ») auto-emphasé en vert (`.text-gradient` = `accent-600` plein,
  **jamais** un dégradé sur le texte).

---

## 4. Color

- **Approche :** `balanced` — une primaire d'identité (navy), une couleur d'action (vert),
  un accent chaud rare (ambre) réservé aux KPI/badges. La couleur signifie ; elle ne décore pas.

### 4.1 Primary — Bleu marine institutionnel (identité, confiance)
`--color-primary-*` : `50 #e8eef5` · `100 #c5d5e6` · `200 #9bb5d1` · `300 #7095bc` ·
`400 #4a78a8` · **`500 #1B3A5C`** · `600 #183353` · `700 #142b47` · `800 #10233b` ·
`900 #0c1b2f` · `950 #08111f`.
Usage : titres, navy de fond des sections d'autorité, éléments de marque, texte fort.

### 4.2 Accent — Vert NeoGTB (action, validation, croissance)
`--color-accent-*` : `50 #eaf5ee` · `100 #d0e8d6` · `200 #a3d4b2` · `300 #6fbc88` ·
`400 #4caf64` · `500 #2D8B4E` · **`600 #267a43` (couleur d'action canonique)** ·
`700 #1f6637` · `800 #19532d` · `900 #134023` · `950 #0c2916`.
**Invariant accessibilité :** un CTA primaire est **toujours** `accent-600` (`#267a43`,
ratio 5.32:1 sur blanc = WCAG AA), texte **blanc**, jamais gris. On ne descend **jamais**
à `accent-500` (`#2D8B4E` = 4.27:1, sous le seuil AA) pour du texte. Hover : `accent-700`.

### 4.3 Highlight — Ambre chaud (KPI, badges, mise en avant rare)
`--color-highlight-*` : `50 #FFFBEB` … **`500 #F59E0B`** … `900 #78350F`.
Usage : chiffres-clés, badges « à retenir ». Rare et intentionnel.

### 4.4 Neutrals — Slate (texte, surfaces, bordures)
`--color-dark-*` : `50 #f8fafc` · `100 #f1f5f9` · `200 #e2e8f0` (bordure standard) ·
`300 #cbd5e1` · `400 #94a3b8` · `500 #64748b` · `600 #475569` (corps) · `700 #334155` ·
`800 #1e293b` · `900 #0f172a` (`theme-color` mobile `#0F172A`) · `950 #020617`.
Texte titres `#111827`. Fond cartes `#fff`, bordure cartes `#e2e8f0`.

### 4.5 Semantic (front)
- Jauge **EN 15232** : niveau A `#0284c7` · B `#2D8B4E` · C `#f97316` · D `#ef4444`.
- Tags de contenu : réglementation `#fef3c7`/`#92400e` · technique `#dbeafe`/`#1e40af` ·
  protocoles `#ede9fe`/`#5b21b6` · gtb `#dcfce7`/`#166534`.

### 4.6 Dark mode
Le front public est **light-first assumé** (c'est la signature « clair, lumineux »).
Pas de dark mode public prévu. Les couleurs de site sont surchargeables dynamiquement
depuis l'admin (`$site->cssVariables()`).

---

## 5. Spacing

- **Unité de base :** 4px (échelle Tailwind v4 par défaut — non redéfinie, donc standard :
  `1`=4 · `2`=8 · `3`=12 · `4`=16 · `6`=24 · `8`=32 · `12`=48 · `16`=64…).
- **Densité :** `comfortable` côté **front** (sections respirantes, autorité = espace),
  `compact` côté **admin** (dashboard dense mais lisible).
- **Rythme vertical :** sections front généreuses ; l'espace négatif est un outil de
  crédibilité (moins = plus sérieux).

---

## 6. Layout

- **Approche :** `hybrid` — grille disciplinée pour l'app (admin, comparateur, tableaux),
  éditorial maîtrisé pour le marketing (hero, pages pédagogiques).
- **Grille cartes :** `auto-fit minmax(~200px, 1fr)` (front, ex. brick fondateur), grilles KPI admin 4 → 2 → 1 colonnes
  (breakpoints 1280 / 640px).
- **Largeur de contenu max :** conteneurs centrés type `max-w-7xl` (usage Tailwind courant).
- **Border-radius (hiérarchie réelle) :**

  | Contexte | Valeur | Éléments |
  |---|---|---|
  | Front — petits | 6px | jauge EN 15232, puces |
  | Front — boutons/inputs | 8px | `.btn-primary`, `.btn-secondary`, inputs, `metric-cell` |
  | Front — cartes | 12px | `.card` |
  | Front — glass | 16px | `.glass-card` |
  | Front — pilules | 20px / 9999px | tags, orbs |
  | Admin | 10px | boutons, inputs, items sidebar |
  | Admin `--neo-radius` | 12px | toasts |
  | Admin `--neo-radius-lg` | 16px | sections, cartes |
  | Admin `--neo-radius-xl` | 20px | modals, KPI cards, login |

---

## 7. Motion

- **Approche :** `intentional` — entrées douces et transitions d'état signifiantes, jamais
  de chorégraphie gratuite.
- **Animations front :** `fade-in-up` (0.6s ease-out), `float` (8–16s, orbs), `glow-pulse`
  (3–6s, halos), scroll-reveal via Alpine `x-intersect`.
- **Animations admin :** `fadeInUp` (0.5s, cartes en cascade 0.05s→0.52s), `pulse-dot`
  (statuts), `shimmer`, `neo-target-pulse` (deep-link recherche).
- **Easing :** `cubic-bezier(0.4, 0, 0.2, 1)` (standard du projet).
- **Durée :** micro 150ms · court 200–300ms · moyen 500–600ms.
- **Invariant a11y non négociable :** tout est coupé sous `@media (prefers-reduced-motion:
  reduce)` (front ET admin). Ne jamais introduire d'animation sans ce garde-fou.
- **CLS = 0 :** les décoratifs (orbs, halos) ont des dimensions fixes en markup. Ne jamais
  régresser cet invariant.

---

## 8. Composants canoniques (front)

Utiliser ces classes / composants Blade partagés plutôt que de recréer localement :

- **CTA primaire :** `.btn-primary` (ou `<x-front.shared.btn-primary>`) — vert `accent-600`,
  focus ring blanc + halo vert. **Couleurs hors `@layer`** = non surchargeables (invariant a11y).
- **Boutons secondaires :** `.btn-secondary` (blanc, bordure) · `.btn-ghost` (lien vert souligné).
- **Cartes :** `.card` (blanc, bordure `#e2e8f0`, radius 12, hover shadow) · `.glass-card`
  (backdrop-blur, radius 16).
- **Eyebrow :** `.eyebrow` (11px, 600, uppercase, vert `#267a43`) — sur-titre de section.
- **Décoratifs :** `.glow-halo` (+ `--accent`/`--primary`/`--warm`), `.orb` (+ `--filled`/
  `--outline`/`--slow`/`--reverse`/`--delay`). Toujours `aria-hidden` + `pointer-events:none`.
- **Reveal au scroll :** `<x-front.shared.reveal>` ou `class="reveal"` + `x-intersect`.
- **Blocs métier :** jauge `.gauge-en15232`, `.timeline-regl`, `.method-flow`,
  `.comparateur-preview`, `.tag-*`, `.sticky-cta-mobile`.
- **Focus visible global :** `outline: 2px solid accent-600` (WCAG 2.4.7). Ne jamais retirer.

---

## 9. Système Admin (Filament) — aligné sur la marque (migré le 2026-07-12)

**État AVANT migration (historique — ne décrit plus le code actuel) :** thème « v2.0 premium »,
techniquement soigné (dashboard KPI animé, quick actions, timeline, login brandé,
`prefers-reduced-motion` respecté). Palette **violette** :
- Primaire `--neo-primary #6C3AED` / light `#8B5CF6` / dark `#5B21B6` ; fond `#F5F3FF` ;
  texte `#1e1b4b`.
- Sidebar indigo sombre `#1e1b4b` → `#15133a`, texte `#c4b5fd`, item actif = gradient violet.
- Radius 12/16/20 ; ombres `--neo-shadow*` ; sémantiques emerald/rose/amber/sky.

**✅ Palette admin ACTUELLE (migration appliquée le 2026-07-12) :** l'ancienne palette violette
(vestige de la reco `design-refs` `#534AB7`, abandonnée par le front) a été remplacée par la
marque navy + vert. Système unifié front/admin :
- Primaire (Filament + `--neo-primary`) : **vert `accent-600 #267a43`** ; gradients d'action et
  d'items actifs s'**assombrissent** vers `accent-700 #1f6637` (texte blanc reste ≥ AA — jamais accent-500).
- Sidebar : **navy sombre** `#0c1b2f → #08111f`, texte `#c5d5e6`.
- Sémantiques : emerald/rose/amber/sky (inchangées, déjà cohérentes).
- KPI « Pages » différencié en **navy `#1B3A5C`** (sparkline + icône) pour se distinguer du vert.
- Ergonomie conservée intégralement (radius 10/12/16/20, ombres, animations, densité, `prefers-reduced-motion`).

**Fichiers migrés :** `AdminPanelProvider.php`, `admin-styles.blade.php`, `dashboard.blade.php`,
`SiteSettingsPage.php`. **Zéro teinte violette résiduelle** (vérifié par grep exhaustif).

---

## 10. Contraintes non négociables (RGPD, juridique, marque)

- **Images hero :** ambiance **claire, lumineuse, aérée** (jamais le noir dramatique type SMT).
  Palette évoquée en lumière : navy `#1B3A5C`, vert `#2D8B4E`, touches ambre `#F59E0B`, dominante blanc.
  **Interdits absolus :** aucun visage/personne identifiable, aucune marque/logo/écran de marque
  réelle, aucun bâtiment réel plagiable. Espace négatif réservé au titre en overlay.
  Formats : hero 16:9 1600×900 ; bandeau offres ~8:3 1600×600.
- **Logos partenaires :** 6 admis (Siemens, Schneider, Honeywell, Sauter, KNX, TheWatchdog).
  **Exclus :** Johnson Controls, Distech. **Mention légale obligatoire à proximité :**
  « NeoGTB est indépendant de ces marques » + tooltip « Technologie maîtrisée par NeoGTB ».
  Chaque logo pointe vers `/comparateur`. *(✅ Brick `logos.blade.php` refait le 2026-07-12 :
  fond clair, logos gris→couleur au survol, mention légale intégrée en dur, lien `/comparateur`,
  `aria-label` + tooltip.)*
- **Polices :** auto-hébergées uniquement, jamais de CDN externe.
- **Cookies / RGPD :** bandeau 3 catégories (« Tout refuser » aussi accessible que
  « Accepter »), bouton flottant « Gérer mes cookies » persistant, Consent Mode v2.
  Bloc légal footer (mentions légales, confidentialité, `/mes-droits-rgpd`).

---

## 11. Decisions Log

| Date | Décision | Rationale |
|------|----------|-----------|
| 2026-07-12 | Design system créé via /design-consultation | Consolidation « premium » de l'existant réel (front + admin) en source de vérité unique, fil directeur « indépendance ». |
| 2026-07-12 | Source de vérité = code réel (`app.css`, `home-components.css`, `admin-styles.blade.php`, `AdminPanelProvider.php`) | Les docs (`README`, `CLAUDE.md`, `design-refs`, `ROADMAP`, audit v2) sont contradictoires et obsolètes ; le code déployé fait foi. |
| 2026-07-12 | Palette front actée : navy `#1B3A5C` + vert `#267a43` + ambre `#F59E0B` | Palette réellement en prod ; le violet `#534AB7` de `design-refs` et le `#0F6BAF` de l'audit sont abandonnés. |
| 2026-07-12 | Fonts actées : Inter (body) + DM Sans (titres) | Réellement installées ; « Plus Jakarta Sans » de ROADMAP jamais installée → écarté. |
| 2026-07-12 | **✅ Résolu** : admin migré violet → vert/navy de marque | 4 fichiers, zéro violet résiduel, contraste AA vérifié (gradients s'assombrissent vers accent-700), KPI « Pages » en navy. |
| 2026-07-12 | **✅ Résolu** : brick `logos.blade.php` refait | Fond clair, gris→couleur, mention légale de neutralité en dur, lien `/comparateur`. Obligation légale désormais satisfaite. |
| 2026-07-12 | Prototype `/design-html` : section « Pourquoi nous faire confiance » | Charte d'indépendance en HTML/CSS portable (dogfood du design system) ; Pretext volontairement écarté (inutile au stack Blade). À porter en brick. |

---

## 12. Pour l'agent (règle d'or)

Avant toute modification visuelle : lire ce fichier. Ne jamais dévier des tokens, fonts,
couleurs, radius ou invariants a11y sans validation explicite de l'utilisateur. En mode QA,
signaler tout code qui ne respecte pas ce DESIGN.md (notamment : CTA non `accent-600`,
animation sans garde `prefers-reduced-motion`, police externe, logo partenaire sans mention
de neutralité). Ne jamais casser la structure NeoGTB existante.
