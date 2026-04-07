---
description: Auditer le SEO d'une ou toutes les pages NeoGTB
---

Fais un audit SEO du site NeoGTB.

## Si une page est spécifiée, audite cette page. Sinon, audite toutes les pages.

## Pour chaque page, vérifie :

### Balises essentielles
- `<title>` : présent, unique, 50-60 caractères, mot-clé principal inclus
- `<meta description>` : présente, unique, 150-160 caractères, incitative
- `<h1>` : un seul par page, contient le mot-clé principal
- Hiérarchie H2/H3 logique (pas de saut de niveau)
- `<canonical>` correcte

### Open Graph & réseaux sociaux
- og:title, og:description, og:image présents
- og:url correcte

### Contenu
- Liens internes vers d'autres pages du site
- Texte alt sur toutes les images
- Pas de contenu dupliqué entre pages
- Mots-clés GTB/GTC/BACS présents naturellement

### Technique
- URL propres (pas de majuscules, accents, underscores)
- Sitemap à jour (`astro-sitemap`)
- Pas de pages orphelines (accessibles depuis la nav ou des liens internes)

## Rendu
Donne un tableau récapitulatif par page avec un score /10 et les actions correctives prioritaires.
