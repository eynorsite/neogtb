---
description: Vérifier le responsive d'une page NeoGTB (mobile, tablette, desktop)
---

Vérifie le responsive design d'une page NeoGTB.

## Étapes

1. Demande-moi quelle page vérifier si non précisée
2. Lis le code source de la page dans `src/pages/`

3. **Analyse des breakpoints Tailwind** pour chaque section :
   - **Mobile** (< 640px / défaut) : vérifier que tout est en colonne, lisible, pas de débordement
   - **Tablette** (640px-1024px / `sm:` et `md:`) : vérifier les grilles et espacements
   - **Desktop** (> 1024px / `lg:` et `xl:`) : vérifier la mise en page large

4. **Points de contrôle** :
   - Pas de `width` fixe en pixels (utiliser `w-full`, `max-w-*`)
   - Pas de `hidden` sans breakpoint (contenu caché sur mobile sans raison)
   - Les images sont responsives (`w-full`, `max-w-*`, `object-cover`)
   - Les textes sont lisibles sur mobile (pas de `text-xs` sur du contenu important)
   - La navigation est accessible sur mobile (menu hamburger)
   - Les boutons sont assez grands pour le tactile (min 44x44px)
   - Les formulaires sont utilisables sur mobile
   - Les tableaux ont un scroll horizontal ou se transforment en cards sur mobile
   - Les grilles passent en colonne sur mobile (`grid-cols-1` par défaut)

5. **Vérification du layout** :
   - Pas de scroll horizontal sur aucun breakpoint
   - Les paddings latéraux sont présents (`px-4` minimum sur mobile)
   - Le contenu ne touche pas les bords de l'écran

## Rendu
Liste des problèmes trouvés avec le correctif Tailwind exact pour chacun.
