# Exploration design — Page d'accueil NeoGTB (2026-07-12)

Exploration de directions visuelles pour la page d'accueil, générée via `/design-shotgun`.
**Ce sont des wireframes de direction, pas du code de production** : ils servent à choisir un
parti pris avant intégration dans les bricks/Blade.

## Comment visualiser

Servir le dossier en HTTP local (les `@font-face` et les iframes du board ont besoin d'un serveur) :

```bash
cd design-explorations/accueil-20260712
python3 -m http.server 8770
# puis ouvrir http://127.0.0.1:8770/design-board.html
```

## Les 3 directions

| Fichier | Direction | Parti pris | Signal |
|---|---|---|---|
| `variant-a.html` | Institutionnel / Autorité | Hero navy, carte « échéances BACS », KPI géants, sources officielles | Acteur établi, référence neutre |
| `variant-b.html` | Pédagogique / Clair | Blanc lumineux, méthode en timeline, vert d'accompagnement, orbs doux | On vous explique, on vous accompagne |
| `variant-c.html` | Outil / Preuve interactive | Hero avec **simulateur de conformité** (kW → échéance) + grille d'outils | Testez votre situation maintenant |

- `design-board.html` — board de comparaison (les 3 côte à côte, bascule desktop/mobile).
- `tokens.css` — design system partagé, **extrait du `DESIGN.md` réel** : navy `#1B3A5C`,
  vert d'action `#267a43`, ambre `#F59E0B`, DM Sans + Inter auto-hébergées (RGPD, zéro Google Fonts).
- `fonts/` — DM Sans + Inter (variables, `.woff2`) copiées depuis le build du projet.
- `BRIEF_COMMUN.md` — contexte produit + faits réglementaires réels ayant servi au contenu.

## Conformité au design system

- Couleurs 100 % via `var(--…)` — aucun violet, aucun dégradé sur du texte.
- Light-first, un seul `<h1>` par page, focus clavier visibles, `prefers-reduced-motion` respecté, CLS = 0.
- Seuils décret BACS exacts : > 290 kW obligatoire depuis 2025 · 70–290 kW échéance 2030.
- Aucune fausse statistique client (positionnement « tiers de confiance »).

## Statut

Wireframes en attente de choix de direction. Une fois la direction retenue, finalisation
en HTML/Blade propre pour intégration.
