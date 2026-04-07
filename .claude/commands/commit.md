---
description: Créer un commit propre avec message en français au format NeoGTB
---

Crée un commit Git propre pour NeoGTB.

## Étapes

1. Lance `git status` pour voir les fichiers modifiés
2. Lance `git diff --stat` pour comprendre l'ampleur des changements
3. Analyse les changements pour déterminer le **type** :
   - `feat:` — nouvelle fonctionnalité ou page
   - `fix:` — correction de bug
   - `style:` — changement visuel (CSS, design)
   - `content:` — ajout/modification de contenu (articles, textes)
   - `seo:` — amélioration SEO
   - `perf:` — amélioration performance
   - `refactor:` — refactoring sans changement fonctionnel
   - `chore:` — maintenance, config, dépendances

4. Génère un message de commit en français :
   - Format : `type: description courte`
   - Description claire de ce qui a changé et pourquoi
   - Max 72 caractères pour la première ligne

5. Stage les fichiers pertinents (pas de fichiers sensibles)
6. Crée le commit

## Exemples
- `feat: ajout page comparateur GTB/GTC`
- `content: nouvel article sur le décret BACS`
- `fix: correction lien cassé page solutions`
- `seo: ajout meta description pages principales`
- `style: refonte hero page accueil`
