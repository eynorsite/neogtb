# NeoGTB - Site Educatif GTB/GTC

**Projet** : Site web éducatif et informatif sur la GTB/GTC
**Domaines** : neogtb.fr / neogtb.com
**Objectif** : Eduquer sur la Gestion Technique du Bâtiment et proposer des audits
**Stack** : React (Lovable) + Tailwind CSS 4 + Laravel admin
**Date de création** : 9 mars 2026

---

## Stack Technique

- **Front** : React (Lovable) + Tailwind CSS 4
- **Admin** : Laravel + Filament
- **Build** : Vite
- **Hébergement** : Vercel ou Netlify (gratuit)
- **Formulaires** : Formspree ou Resend (emails)

---

## Architecture du site

```
NeoGTB
│
├── Pages Publiques
│   ├── Accueil (hero + présentation GTB/GTC + CTA)
│   ├── Qu'est-ce que la GTB ? (page éducative complète)
│   ├── Qu'est-ce que la GTC ? (page éducative complète)
│   ├── Solutions & Technologies (protocoles, capteurs, automates)
│   ├── Audit GTB/GTC (formulaire d'audit en ligne)
│   ├── Blog (articles techniques)
│   ├── Contact
│   └── A Propos
│
└── Blog
    ├── Articles techniques GTB/GTC
    ├── Actualités du secteur
    ├── Guides pratiques
    ├── Retours d'expérience
    └── Réglementation (RT2012, RE2020, décret tertiaire)
```

---

## Roadmap

### Phase 0 : Initialisation ✅
- [x] Choix du nom : NeoGTB
- [x] Réservation domaines : neogtb.fr + neogtb.com
- [x] Choix stack : React (Lovable) + Tailwind CSS 4 + Laravel admin
- [x] Initialisation projet
- [x] Installation Tailwind CSS 4
- [x] Initialisation Git

### Phase 1 : Fondations & Design System
- [ ] Définir la palette de couleurs (thème bâtiment intelligent / tech)
- [ ] Configurer Tailwind (couleurs, fonts, spacing)
- [ ] Créer le layout principal (header, nav, footer)
- [ ] Navigation responsive avec menu mobile
- [ ] Composants de base (boutons, cards, badges)
- [ ] Favicon et branding NeoGTB

### Phase 2 : Pages Principales
- [ ] Page d'accueil (hero, sections éducatives, CTA)
- [ ] Page "Qu'est-ce que la GTB ?"
- [ ] Page "Qu'est-ce que la GTC ?"
- [ ] Page "Solutions & Technologies"
- [ ] Page "A Propos"
- [ ] Page "Contact" (formulaire)

### Phase 3 : Blog & Contenu
- [ ] Système de blog
- [ ] Page liste des articles
- [ ] Page détail article
- [ ] Catégories et tags
- [ ] 5-10 articles initiaux GTB/GTC
- [ ] SEO optimisé (meta, Open Graph, Schema.org)

### Phase 4 : Outil d'Audit
- [ ] Formulaire d'audit interactif (Alpine.js)
- [ ] Questions par étapes (wizard multi-step)
- [ ] Génération de rapport/score
- [ ] Envoi par email des résultats
- [ ] PDF téléchargeable (optionnel)

### Phase 5 : SEO & Performance
- [ ] Meta tags dynamiques
- [ ] Sitemap XML automatique
- [ ] Schema.org (Organization, Article, FAQPage)
- [ ] Open Graph / Twitter Cards
- [ ] Optimisation images (WebP, lazy loading)
- [ ] Score Lighthouse 95+

### Phase 6 : Déploiement
- [ ] Configuration Vercel/Netlify
- [ ] Pointer DNS neogtb.fr + neogtb.com
- [ ] SSL automatique
- [ ] Analytics (GA4 ou Plausible)
- [ ] Tests multi-navigateurs

### Phase 7 : Chatbot IA (livré 2026-05-08)
Voir `docs/CHATBOT_LIVRAISON_2026-05-08.md` et `admin/CHATBOT.md` pour la doc complète.

- [x] Backend Laravel (5 tables, ChatbotService streaming, 4 endpoints API)
- [x] Admin Filament (Settings, Knowledge, FAQ, Conversations, Stats)
- [x] Widget public Alpine.js (streaming SSE, consentement RGPD, capture lead)
- [x] Seeder initial (8 snippets décret BACS + 5 FAQ)
- [x] Documentation utilisateur (CHATBOT.md, 215 lignes)
- [ ] Configurer la clé `ANTHROPIC_API_KEY` dans `.env` (local + VPS)
- [ ] Activer le toggle dans `/admin/chatbot-settings-page` après tests
- [ ] Phase 2 RAG vectoriel (sqlite-vec) si > 50 snippets
- [ ] Commande artisan `chatbot:purge` pour purge auto >30 j

---

## Conventions de Code

### React (Lovable)
- **Pages** : `src/pages/`
- **Composants** : `src/components/` (PascalCase)
- **Briques** : `src/components/bricks/` (architecture modulaire)
- **Hooks** : `src/hooks/`
- **Styles** : Tailwind CSS 4

### Tailwind CSS
- Mobile-first
- Ordre : Layout → Spacing → Typography → Visual

### Git
- Branches : `main` (prod), `feature/nom`, `fix/nom`
- Commits en français
- Format : `type: description courte`

---

## Thématiques Blog (idées d'articles)

1. Qu'est-ce que la GTB ? Guide complet 2026
2. GTB vs GTC : quelles différences ?
3. Les protocoles de communication (BACnet, KNX, Modbus, LON)
4. Le décret tertiaire et la GTB
5. RE2020 : impact sur la gestion technique du bâtiment
6. Les capteurs intelligents dans le bâtiment
7. ROI d'une installation GTB : étude de cas
8. Smart Building : tendances 2026
9. Comment réaliser un audit GTB ?
10. Les niveaux de GTB selon la norme EN 15232

---

**Version** : 0.1.0
**Dernière mise à jour** : 9 mars 2026

---

## RÈGLE D'ISOLATION — IMPORTANT

Ce projet est **100% indépendant**. Ne JAMAIS :
- Toucher aux fichiers d'un autre projet (site-eynor, tools-habelec, nfc18510-app)
- Importer du code ou des dépendances d'un autre projet
- Mélanger les bases de données ou configurations

Les 4 projets dans ~/projets/ sont totalement séparés :
- `site-eynor/` → Site web EYNOR (Laravel + Filament + PostgreSQL)
- `neogtb/` → **CE PROJET** (React Lovable + Laravel admin)
- `tools-habelec/` → Outils habilitation (Laravel + Livewire)
- `nfc18510-app/` → App NFC 18-510 (React + Vite)
