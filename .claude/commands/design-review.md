---
description: Vérifier qu'une page NeoGTB respecte les mockups et le design system
---

Compare le code d'une page avec les **références design** du projet.

## Étapes

1. Demande-moi quelle page vérifier si non précisé
2. Lis la page source dans `src/pages/`
3. Lis les mockups/références dans `design-refs/` et le fichier de design system en mémoire
4. Compare point par point :

### Vérifications
- **Couleurs** : utilisation correcte des couleurs de la charte (pas de couleurs hardcodées hors charte)
- **Typographie** : tailles, graisses, line-height conformes
- **Espacements** : marges et paddings cohérents avec le reste du site
- **Composants** : boutons, cards, badges respectent les patterns existants
- **Responsive** : vérifier les breakpoints mobile/tablette/desktop
- **Animations** : transitions et effets conformes au design system
- **Hiérarchie visuelle** : le regard est guidé correctement (titres > sous-titres > contenu)
- **CTA** : boutons d'action visibles et bien placés

### Attention
- Ne PAS appliquer les règles mécaniquement — l'objectif est d'atteindre le **STYLE** des mockups
- Signaler les écarts visuels importants, pas les micro-détails
- Proposer les corrections avec le code Tailwind exact

## Rendu
Liste des écarts trouvés avec le correctif pour chacun.
