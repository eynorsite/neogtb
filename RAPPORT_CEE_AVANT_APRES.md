# RAPPORT CEE — AVANT / APRÈS

**Date** : 18 mars 2026

---

## AVANT
Aucun générateur CEE n'existait sur le site NEOGTB.

## APRÈS — Générateur CEE créé de A à Z

### Page : `/generateur-cee`

### Étape 1 — Votre bâtiment
- 6 types de bâtiment : Bureaux, Industrie, Santé, Enseignement, Hôtellerie, Commerce
- Surface en m² (validation min 100)
- 3 zones climatiques : H1 (Nord & Est), H2 (Ouest & Centre), H3 (Méditerranée)
- 4 tranches d'année de construction
- Validation temps réel avant passage à l'étape 2

### Étape 2 — Vos équipements
- 6 équipements sélectionnables : Chauffage, Climatisation, Éclairage, Ventilation, Eau chaude, Motorisation
- Checkbox interactif avec feedback visuel
- Champs dynamiques par équipement sélectionné :
  - État actuel (ancien > 15 ans / standard / récent)
  - Action prévue (remplacement / optimisation / ajout GTB)
- Référence fiche CEE pour chaque équipement

### Étape 3 — Résultats
- Volume CEE en GWh cumac
- Valeur financière estimée en €
- Fourchette basse / haute (±25%)
- Détail par opération avec n° de fiche CEE
- Avertissement "estimation indicative"
- Rappel des paramètres saisis
- Actions : Nouvelle simulation / Demander un avis d'expert

### Formule de calcul
```
CEE = baseCee × surface × zoneCoeff × ageCoeff × typeCoeff × actionCoeff × stateCoeff
```

### Positionnement tiers de confiance
- Badge "Outil indépendant & gratuit" dans le hero
- Badge "NeoGTB ne perçoit aucune commission sur les CEE générés" en bas de page
- Lien "Demander un avis d'expert" (pas "Acheter" ni "Devis")

### Screenshots
- `audit_screenshots/etape3/cee-step1-desktop.png` — Formulaire vide
- `audit_screenshots/etape3/cee-step1-filled-desktop.png` — Formulaire rempli
- `audit_screenshots/etape3/cee-step2-filled-desktop.png` — Équipements sélectionnés
- `audit_screenshots/etape3/cee-step3-results-desktop.png` — Résultats desktop
- `audit_screenshots/etape3/cee-step3-results-mobile.png` — Résultats mobile
