# Design References — Index des 100+ sites scrapés

> Généré le 2026-03-21 par `scripts/scrape-refs.cjs`
> **40 fichiers HTML** extraits + tokens CSS consolidés dans `_tokens-all.json`

---

## Tableau récapitulatif par domaine

### Santé (7/15 capturés)

| Fichier | Site | Pattern identifié |
|---|---|---|
| `doctolib-hero.html` | doctolib.fr | Hero conversion, CTA primaire/secondaire, bleu médical rassurant |
| `withings-hero.html` | withings.com | Product hero Apple-like, whitespace luxueux, imagery haute qualité |
| `nabla-homepage.html` | nabla.com | SaaS healthcare dark/light, autorité tech IA |
| `qare-homepage.html` | qare.fr | Conversion patient, confiance médicale, CTAs forts |
| `gleamer-hero.html` | gleamer.ai | MedTech dark hero, autorité IA, stats impact |
| `owkin-homepage.html` | owkin.com | Science premium, dark, typographie autoritaire |
| `livi-homepage.html` | livi.fr | Nordic clean, vert doux, conversion consultation |

### Formation (5/15 capturés)

| Fichier | Site | Pattern identifié |
|---|---|---|
| `openclassrooms-hero.html` | openclassrooms.com | LMS hero, CTA inscription forte, cours mis en avant |
| `42-homepage.html` | 42.fr | Dark coding school, identité forte, expérimental |
| `essec-homepage.html` | essec.edu | Business school, photographie executive, élégant |
| `mindvalley-fr.html` | mindvalley.com | Personal dev premium, dark luxueux, vidéo hero |

### Consulting (5/15 capturés)

| Fichier | Site | Pattern identifié |
|---|---|---|
| `sia-partners-hero.html` | sia-partners.com | Cabinet conseil premium, dark hero, thought leadership |
| `roland-berger-fr.html` | rolandberger.com | Strategy editorial, insights cards, institutionnel |
| `eleven-strategy.html` | eleven-strategy.com | Boutique consulting minimaliste extrême, autorité |
| `soprasteria-fr.html` | soprasteria.com | IT services corporate, bleu foncé, expertise |

### Alimentaire (8/15 capturés)

| Fichier | Site | Pattern identifié |
|---|---|---|
| `pierre-herme-hero.html` | pierreherme.com | Pâtisserie luxe, noir/or, photographie produit premium |
| `laduree-homepage.html` | laduree.fr | Heritage luxe, vert pastel signature, editorial |
| `fauchon-homepage.html` | fauchon.com | Épicerie luxe, rose signature, packaging premium |
| `crustac-fr.html` | crustac.fr | Marque alimentaire premium, animations scroll, épuré |
| `yooji-homepage.html` | yooji.fr | FMCG bio, pastels, famille, conversion e-commerce |
| `decathlon-hero.html` | decathlon.fr | E-commerce sport/food, bleu signature, catégories claires |

### Sport (8/15 capturés)

| Fichier | Site | Pattern identifié |
|---|---|---|
| `lacoste-fr.html` | lacoste.com | Sport luxe français, vert crocodile, editorial lifestyle |
| `psg-homepage.html` | psg.fr | Football premium, bleu/rouge, fan engagement |
| `lequipe-homepage.html` | lequipe.fr | Media sport, typographie forte, bleu/rouge/blanc |
| `trailrunner-fr.html` | trailrunner.fr | Niche sport media, nature photography, editorial |
| `stade-francais.html` | stade.fr | Rugby premium, rose/noir signature, fan engagement |
| `bikester-fr.html` | bikester.fr | Niche e-commerce vélo, filtres avancés, UX product |

### Informatique (7/15 capturés)

| Fichier | Site | Pattern identifié |
|---|---|---|
| `scaleway-homepage.html` | scaleway.com | Developer cloud, violet signature, features grid |
| `contentsquare-homepage.html` | contentsquare.com | SaaS UX analytics, gradient violet, enterprise |
| `strapi-homepage.html` | strapi.io | Open source CMS, violet/bleu, developer community |
| `aircall-homepage.html` | aircall.io | Sales SaaS, vert/blanc, intégrations mise en avant |
| `wimi-homepage.html` | wimi-teamwork.com | Collaboration SaaS souverain, bleu/vert, productivité |

### Internationaux (session précédente — 8 fichiers)

| Fichier | Site | Pattern identifié |
|---|---|---|
| `sonet-hero.html` | webflow.io (template) | Hero consulting Webflow premium |
| `sonet-nav.html` | webflow.io (template) | Nav sticky consulting |
| `mckinsey-nav.html` | mckinsey.com | Nav autorité maximale |
| `stripe-cards.html` | stripe.com | Cards SaaS référence absolue |
| `linear-hero.html` | linear.app | Dark mode autorité tech |
| `vercel-nav.html` | vercel.com | Minimal dark sticky nav |
| `loom-testimonials.html` | loom.com | Social proof moderne |
| `notion-cta.html` | notion.so | CTA conversion sobre |

---

## 5 patterns CSS les plus récurrents

### 1. Hero section plein écran avec CTA double
Présent sur : Doctolib, Qare, OpenClassrooms, Sia Partners, PSG
- Un titre H1 large (32–48px), souvent serif ou bold sans-serif
- Un sous-titre en `--text-secondary` (gris 60-70%)
- Deux boutons : CTA primaire (accent) + CTA secondaire (outline/ghost)
- Max-width du contenu : 1100–1280px

### 2. Navigation sticky minimale
Présent sur : Vercel, McKinsey, Sonet, L'Équipe, Scaleway
- `position: sticky` + `backdrop-filter: blur`
- Logo à gauche, liens centrés, CTA à droite
- Hauteur fixe 56–72px
- Fond semi-transparent (rgba blanc ou noir 0.8–0.95)

### 3. Cards en grid responsive
Présent sur : Stripe, Strapi, Scaleway, Contentsquare, Bikester
- `display: grid` + `grid-template-columns: repeat(auto-fit, minmax(300px, 1fr))`
- Border subtile `rgba(0,0,0,0.08)` ou `1px solid #eee`
- `border-radius: 8–16px`
- Hover : `translateY(-2px)` + `box-shadow` léger

### 4. Section social proof / logos
Présent sur : Doctolib, Gleamer, Owkin, Contentsquare, Aircall
- Bandeau horizontal de logos clients en niveaux de gris
- `opacity: 0.5` au repos, `opacity: 1` au hover
- Souvent sous le hero, agit comme "preuve d'autorité"
- Grid ou flex row avec `gap: 32–48px`

### 5. Dark hero premium (tech/consulting)
Présent sur : 42, Linear, Eleven Strategy, Gleamer, Sia Partners
- Background `#0a0a0a` à `#1a1a2e`
- Texte blanc pur + accent color (violet, vert, bleu)
- Typographie XXL (48–72px) très espacée
- Animations subtiles (fade-in, gradient animé)

---

## 3 combinaisons de couleurs dominantes par domaine

### Santé
1. **Bleu médical + blanc** — Doctolib (`#107ACA` / `#0D2339`), Qare, Livi
2. **Dark + accent vert/teal** — Owkin, Nabla, Gleamer
3. **Blanc pur + gris doux** — Withings, Livi (style Apple)

### Formation
1. **Dark + violet/purple** — 42, Mindvalley (`#7451EB`)
2. **Blanc + bleu institutionnel** — OpenClassrooms, ESSEC
3. **Noir + accents néon** — 42 (coding school aesthetic)

### Consulting
1. **Navy / dark blue + blanc** — Sia Partners, Sopra Steria
2. **Noir absolu + accent vert/teal** — Eleven Strategy (`#1DE9B6`)
3. **Gris neutre + rouge/orange corporate** — Roland Berger

### Alimentaire
1. **Noir + or/beige** — Pierre Hermé, Fauchon (luxe pâtisserie)
2. **Vert pastel + blanc** — Ladurée, Yooji (bio/nature)
3. **Bleu-gris + accents warm** — Crustac (premium artisanal)

### Sport
1. **Bleu + rouge + blanc** — PSG, L'Équipe, FFF (tricolore sport)
2. **Dark + accents vifs** — Stade Français (rose/noir), Lacoste
3. **Blanc + bleu signature** — Decathlon, Bikester

### Informatique
1. **Violet/purple + dark** — Scaleway, Contentsquare, Strapi (`#4945FF`)
2. **Vert + blanc** — Aircall, Wimi
3. **Dark minimal + accent unique** — pattern récurrent SaaS

---

## Fonts les plus populaires détectées

| Rang | Font | Occurrences | Usage typique |
|---|---|---|---|
| 1 | **system-ui / sans-serif** | 13 | Fallback universel, body text |
| 2 | **Arial** | 10 | Sites corporate, compatibilité |
| 3 | **Inter** | 5 | SaaS modernes (Strapi, Scaleway) |
| 4 | **Montserrat** | 5 | Startup/moderne (Doctolib, consulting) |
| 5 | **Rubik** | 4 | Tech/startup friendly |
| 6 | **Times / serif** | 17 | Titres éditoriaux, autorité (McKinsey, HEC) |
| 7 | **Roboto** | 3 | Material-adjacent, médical |
| 8 | **Figtree** | 2 | Nouveau standard startup |

**Tendance** : Les sites d'autorité utilisent un **serif pour les titres** (Times, Georgia, custom serif) et un **sans-serif géométrique pour le body** (Inter, Montserrat, system-ui).

---

## Border-radius les plus communs

| Valeur | Occurrences | Usage |
|---|---|---|
| `50%` | 22 | Avatars, badges circulaires |
| `8px` | 16 | Cards standard, inputs |
| `4–6px` | 23 | Boutons, tags, badges |
| `12–16px` | 19 | Cards premium, modals |
| `32px` | 9 | Pills, boutons arrondis |
| `20px` | 9 | Cards luxe, containers |

**Consensus** : Le standard est `8px` pour les cards, `4–6px` pour les boutons, `12–16px` pour les sections premium.

---

## Font-sizes les plus communs

| Taille | Occurrences | Rôle typique |
|---|---|---|
| `16px` | 32 | Body text (base) |
| `14px` | 29 | Small text, labels, nav links |
| `12px` | 27 | Captions, meta, tags |
| `18px` | 22 | Body large, sous-titres |
| `20px` | 21 | H4, intros |
| `24px` | 20 | H3 |
| `32px` | 16 | H2 |
| `40px` | 10 | H1 mobile |
| `48px` | 7 | H1 desktop |

---

## Recommandations pour le design system NEOGTB

Sur la base de l'analyse de ces 40 sites premium français :

1. **Typo** : Utiliser un duo serif (titres) + sans-serif géométrique (body) pour l'autorité. Inter ou Montserrat en body, un serif custom ou Georgia pour les H1/H2.
2. **Radius** : `6px` boutons, `8px` cards, `12px` sections premium — cohérent avec le design system actuel.
3. **Palette** : Le bleu tech + blanc + gris est le standard pour les sites techniques/éducatifs. L'accent violet de NEOGTB (`#534AB7`) est dans la tendance SaaS (Scaleway, Strapi, Contentsquare).
4. **Hero** : CTA double (primaire + secondaire), max-width 1200px, H1 entre 40–48px.
5. **Nav** : Sticky, semi-transparente, hauteur 64px, blur backdrop.

---

*Ce fichier est lu automatiquement par Claude Code pour guider les décisions de design.*
