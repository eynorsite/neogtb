# RAPPORT AUDIT DESIGN v2 — Admin NeoGTB
**Date** : 19 mars 2026
**Pages auditées** : 21 (17 desktop + 4 mobile)
**Verdict** : Le design actuel n'est PAS à la hauteur. Voici pourquoi.

---

## SCORE DESIGN : 4/10

La sidebar sombre est en place mais le reste de l'interface est un **Filament vanilla déguisé**. Le CSS custom ne suffit pas — il faut une refonte visuelle profonde.

---

## PROBLÈMES CRITIQUES

### 1. Widget "Pages du site" sur le dashboard — CASSÉ
Les pages s'affichent en **liste inline** horizontale (emojis + texte + slugs collés les uns aux autres) au lieu d'une grille de cards propre. Le CSS grid ne fonctionne pas car le widget Filament ne render pas le HTML comme attendu. **Résultat : un bloc de texte illisible.**

### 2. Cards pages sur /admin/pages — PAS DE CARDS
Les cards en haut de la page /admin/pages s'affichent comme une **liste verticale texte** (Accueil /accueil, Publiée, Ordre 1...) au lieu de cards en grille 4 colonnes. Le widget `PagesGrid` ne rend pas les divs grid correctement dans Filament.

### 3. Éditeur de bricks — LAYOUT 3 COLONNES NE MARCHE PAS
Les 3 zones (Bibliothèque / Canvas / Propriétés) s'affichent **en une seule colonne verticale** à la suite. Le `grid-template-columns: 240px 1fr 320px` est écrasé par le conteneur Filament. L'éditeur fait 4 écrans de scroll au lieu de tenir en un écran avec 3 panneaux côte à côte.

### 4. Paramètres — Onglets toujours mal rendus
Les 8 onglets emojis s'affichent en **ligne horizontale non cliquable** visuellement. Pas de sidebar de navigation comme prévu. L'onglet actif n'est pas visible. Les champs de formulaire en dessous sont des inputs sans bordures visibles — on ne voit pas où cliquer.

### 5. JSON brut toujours visible
Les horaires d'ouverture affichent toujours `{"lun_ven":"09:00 - 18:00","sam":"Fermé","dim":"Fermé"}` en texte brut.

---

## PROBLÈMES IMPORTANTS

### 6. Inputs de formulaires invisibles
Sur toutes les pages de formulaires, les champs input n'ont **pas de bordure visible**. On ne distingue pas un champ vide d'un label. Il faut un fond légèrement gris ou une bordure visible pour chaque input.

### 7. Dashboard "Bonjour / Déconnexion" prend trop de place
Le widget AccountWidget occupe toute la largeur pour juste un avatar + "Bonjour" + bouton déconnexion. C'est du gaspillage d'espace vertical.

### 8. Pas de logo NeoGTB
Le header sidebar affiche "NeoGTB Admin" en texte blanc. Il n'y a pas de logo SVG/PNG. Ça fait amateur.

### 9. Mobile dashboard — Pages en vrac
Sur mobile le widget "Pages du site" affiche les 8 pages comme un bloc de texte continu avec des emojis — totalement illisible.

### 10. Mobile settings — Onglets pas navigables
Les 8 onglets emojis sur 2 lignes sur mobile. Pas de scroll horizontal. Pas de dropdown.

---

## PROBLÈMES MINEURS

### 11. Sidebar — Hover state trop subtil
Le hover sur les items de la sidebar (#252840) est quasi invisible sur fond #1A1D2E.

### 12. Breadcrumbs peu visibles
Les breadcrumbs "Pages > Modifier" sont en gris très clair, presque invisibles.

### 13. Pas d'avatar personnalisé
L'avatar "SA" est un cercle noir avec des initiales blanches. Pas de photo uploadable.

### 14. Tableau des pages — Double affichage
La page /admin/pages affiche le widget cards (cassé) EN PLUS du tableau. C'est redondant et confus. Il faut l'un OU l'autre.

---

## CE QUI FONCTIONNE BIEN

- Sidebar sombre — la couleur #1A1D2E est bonne, le contraste est correct
- 100% FR — plus aucun texte en anglais
- Couleur primaire NeoGTB — le bleu #0F6BAF est professionnel
- Page Maintenance — propre et fonctionnelle
- Articles — tableau clair avec badges catégories
- Empty states FR — "Aucun message" avec icône

---

## RECOMMANDATIONS POUR ATTEINDRE 8/10

| Priorité | Action | Impact |
|----------|--------|--------|
| **P0** | Fixer le layout 3 colonnes de l'éditeur de bricks (forcer avec `!important` et `display: flex` au lieu de grid) | Énorme — c'est la feature principale |
| **P0** | Fixer les widgets cards (soit les supprimer, soit forcer le grid à fonctionner) | Le dashboard et la page pages sont cassés |
| **P1** | Ajouter des bordures visibles à TOUS les inputs | Utilisabilité de base |
| **P1** | Refaire les onglets Paramètres en sidebar cliquable au lieu d'emojis inline | Navigation |
| **P2** | Supprimer le widget AccountWidget, mettre le nom dans la topbar | Gain d'espace |
| **P2** | Ajouter un logo SVG NeoGTB dans la sidebar | Branding |
| **P3** | Supprimer le double affichage cards + tableau sur /admin/pages | Clarté |
