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

Voir [ROADMAP.md](ROADMAP.md) pour la roadmap complète et à jour.

État actuel (résumé) :
- ✅ Phases 0-6 livrées : site en prod sur https://neogtb.fr depuis 2026-04-07
- ✅ Phase 7 Chatbot IA livré 2026-05-08 (à activer avec clé API Anthropic)
- 🟡 Phase 8 Optimisation chatbot (RAG, A/B test) — prévue après mise en service
- 🟡 Phase 9 Croissance & conversion (analytics, pages sectorielles, lead magnets)

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
