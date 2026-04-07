---
description: Audit Lighthouse complet d'une page NeoGTB (performance, accessibilité, SEO, bonnes pratiques)
---

Fais un audit de type Lighthouse sur une page NeoGTB.

## Si une page est précisée, audite celle-ci. Sinon, audite la page d'accueil.

## Catégories à vérifier

### Performance
- Images : format WebP/AVIF, dimensions adaptées, lazy loading
- CSS : pas de CSS bloquant le rendu, Tailwind purgé
- JS : Alpine.js en defer/async, pas de JS bloquant
- Fonts : préchargées avec `<link rel="preload">`
- Taille totale de la page (cible : < 500 KB)

### Accessibilité
- Toutes les images ont un `alt` descriptif
- Contraste des couleurs suffisant (ratio 4.5:1 min pour le texte)
- Hiérarchie des titres logique (H1 → H2 → H3, pas de saut)
- Liens avec texte descriptif (pas de "cliquez ici")
- Formulaires avec `<label>` associés aux inputs
- Navigation au clavier possible (focus visible)
- Attributs ARIA si nécessaire (accordéons, modals)
- Langue de la page définie (`<html lang="fr">`)

### SEO
- `<title>` unique et optimisé
- `<meta description>` unique et incitative
- Un seul `<h1>` par page
- URL canonique
- Sitemap référencée
- Structured data (Schema.org) si pertinent

### Bonnes pratiques
- HTTPS
- Pas de `console.log` dans le code
- Pas de bibliothèques avec vulnérabilités connues
- Doctype HTML5
- Charset UTF-8 déclaré

## Rendu
Score estimé /100 par catégorie + actions prioritaires pour atteindre 95+ partout.
