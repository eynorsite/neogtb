---
description: Vérifier la cohérence entre le front Astro et l'admin Laravel/Filament NeoGTB
---

Vérifie que le **backend admin** (Laravel/Filament) et le **frontend** (Astro) sont bien synchronisés.

## Vérifications

1. **Modèles Laravel vs contenu Astro** :
   - Les champs des modèles dans `admin/app/Models/` correspondent aux données utilisées dans les pages Astro
   - Les migrations dans `admin/database/migrations/` sont à jour

2. **Routes API** :
   - Les endpoints API dans `admin/routes/api.php` sont bien consommés côté Astro
   - Pas d'endpoints orphelins ou manquants

3. **Ressources Filament** :
   - Les ressources dans `admin/app/Filament/` couvrent bien tous les contenus éditables du site
   - Les formulaires Filament exposent les bons champs

4. **Contenu** :
   - Les articles de blog dans `src/content/blog/` sont bien gérables depuis l'admin
   - Les pages dans `src/content/pages/` aussi

## Rendu
- Liste des incohérences trouvées
- Actions correctives avec priorité (haute/moyenne/basse)
