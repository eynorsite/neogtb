---
description: Analyser la performance du site NeoGTB (poids pages, images, CSS/JS inutilisé)
---

Fais un audit de performance complet du site NeoGTB.

## Étapes

1. Lance `npm run build` pour avoir le dossier `dist/` à jour

2. **Analyse du poids des pages** :
   - Liste toutes les pages HTML dans `dist/`
   - Donne le poids de chaque fichier HTML
   - Identifie les pages les plus lourdes (> 50 KB)

3. **Analyse des images** :
   - Liste toutes les images dans `public/` et `src/assets/`
   - Identifie les images > 200 KB (trop lourdes)
   - Vérifie le format : les images devraient être en WebP ou AVIF, pas en PNG/JPG
   - Vérifie que le lazy loading est utilisé sur les images sous le fold

4. **Analyse CSS** :
   - Vérifie la taille du CSS généré dans `dist/`
   - Identifie les classes Tailwind potentiellement inutilisées

5. **Analyse JS** :
   - Vérifie la taille des scripts dans `dist/`
   - Identifie les imports inutilisés
   - Vérifie que Alpine.js est chargé en defer

6. **Bonnes pratiques** :
   - Vérifier les balises `<link rel="preload">` pour les ressources critiques
   - Vérifier que les fonts sont préchargées
   - Vérifier la compression des assets

## Rendu
Tableau récapitulatif avec :
- Poids total du site
- Top 5 des fichiers les plus lourds
- Actions correctives classées par impact (fort/moyen/faible)
