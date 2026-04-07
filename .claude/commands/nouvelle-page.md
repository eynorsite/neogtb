---
description: Créer une nouvelle page Astro NeoGTB en respectant le design system et le SEO
---

Crée une nouvelle page pour le site NeoGTB.

## Étapes

1. Demande-moi le **nom et l'objectif** de la page si je ne l'ai pas précisé
2. Lis `src/layouts/Layout.astro` pour utiliser le layout principal
3. Lis 2-3 pages existantes dans `src/pages/` pour capter le **style visuel** et les patterns utilisés
4. Lis les **design refs** dans `design-refs/` si disponibles pour cette page
5. Crée la page dans `src/pages/` avec :
   - Le **Layout** principal avec title, description, canonical URL
   - Les **balises SEO** complètes (meta description, Open Graph, structured data si pertinent)
   - Le design **fidèle aux mockups** de référence — pas de design mécanique
   - Les classes Tailwind cohérentes avec le reste du site
   - Du **maillage interne** (liens vers pages liées)
   - Le composant `RelatedPages` en bas si pertinent
6. Lance `npm run build` pour vérifier zéro erreur
7. Montre-moi l'URL locale pour prévisualiser : `http://localhost:4321/nom-page`

## Règles
- Responsive mobile-first
- Pas de CSS custom sauf si vraiment nécessaire — utiliser Tailwind
- Respecter la charte : couleurs, typographie, espacements du site existant
- Alpine.js pour les interactions (accordéons, onglets, etc.)
