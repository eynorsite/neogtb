---
description: Vérifier que le site NeoGTB build sans erreur et contrôler la qualité
---

Lance une vérification complète du build NeoGTB.

## Étapes

1. Lance `npm run build` dans `/Users/calmoulrich/Documents/neogtb`
2. Si des erreurs apparaissent :
   - Identifie la cause de chaque erreur
   - Corrige-les une par une
   - Relance le build jusqu'à ce qu'il passe
3. Vérifie les **warnings** importants (liens cassés, images manquantes, imports inutilisés)
4. Donne un résumé court :
   - Build OK ou KO
   - Nombre de pages générées
   - Warnings à traiter
   - Taille du dossier `dist/`
