---
description: Créer un nouvel article de blog NeoGTB avec le bon format et le SEO
---

Crée un nouvel article de blog pour NeoGTB.

## Étapes

1. Demande-moi le **sujet** de l'article si je ne l'ai pas précisé
2. Lis les articles existants dans `src/content/blog/` pour respecter le format (frontmatter, structure, ton)
3. Crée le fichier markdown dans `src/content/blog/` avec :
   - Un **slug** optimisé SEO (court, mots-clés, pas d'accents)
   - Le **frontmatter** complet : title, description, date, author, image, tags, category
   - Une **meta description** de 150-160 caractères max
   - Le contenu structuré avec H2/H3, paragraphes courts, listes
   - Un **ton pédagogique** accessible (le public cible = professionnels du bâtiment, pas des experts IT)
   - Des **liens internes** vers les pages pertinentes du site (gtb, gtc, reglementation, solutions…)
4. Vérifie que le slug n'existe pas déjà
5. Lance `npm run build` pour vérifier qu'il n'y a pas d'erreur

## Règles de contenu
- Toujours expliquer les acronymes (GTB, GTC, BACS, CEE…) à la première occurrence
- Inclure des exemples concrets liés au bâtiment tertiaire
- Terminer par un appel à l'action ou un lien vers une page du site
