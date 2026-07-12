# Brief commun — Wireframes page d'accueil NeoGTB

## Contexte produit (FACTUEL — ne rien inventer au-delà de ceci)
- **NeoGTB** = tiers de confiance **indépendant** de la GTB/GTC (Gestion Technique du Bâtiment) en France.
  Message n°1 à faire ressentir : **l'indépendance**. « Nous ne vendons aucun matériel, nous ne représentons aucune marque. »
- **Cible** : décideurs B2B de bâtiments **tertiaires**, priorité PME/TPE propriétaires de **1 000–5 000 m²**,
  face au décret BACS (segment délaissé par les grands intégrateurs).
- **Fondateur** : Ulrich Calmo. (Ne PAS écrire « Nicolas G. » ni de faux ex-McKinsey.)
- **Ce que fait NeoGTB** : site éducatif + outils interactifs gratuits + prestations **AMO GTB/GTC**
  (assistance à maîtrise d'ouvrage : cahier des charges, appel d'offres, contrôle d'intégrateur).

## Faits réglementaires réels (utilisables tels quels)
- **Décret BACS n° 2025-1343** : systèmes d'automatisation et de contrôle des bâtiments tertiaires.
  - Puissance CVC **> 290 kW** : obligatoire **depuis 2025**.
  - Puissance CVC **70–290 kW** : échéance **1er janvier 2030**.
- **Décret tertiaire** (dispositif Éco Énergie Tertiaire) : réduction de conso -40 % d'ici 2030 / -50 % 2040 / -60 % 2050.
- **Norme EN 15232 / ISO 52120-1** : classes d'efficacité de la GTB **A / B / C / D** (A = meilleur).
- **CEE BAT-TH-116** : certificat d'économie d'énergie finançant l'installation d'un système de GTB.
- Sources d'autorité citables : Légifrance, ADEME, GIMELEC, COSTIC, norme EN 15232.

## Outils interactifs gratuits du site (réels)
- **Comparateur** de solutions/intégrateurs GTB
- **Générateur CEE** (estimation de la prime BAT-TH-116)
- **Jauge / simulateur EN 15232** (classe A/B/C/D)
- **Tables Modbus** (catalogue de 19 équipements, 7 catégories)
- **Audit** de conformité en ligne

## Preuves de neutralité (à privilégier plutôt que de faux témoignages clients)
- Badge « Indépendant — aucun lien commercial »
- Données factuelles + sources officielles citées
- Ton : sobre, institutionnel, pédagogique. PAS de survente, PAS de superlatifs, PAS d'urgence agressive.

## Contraintes de design (NON négociables — depuis le DESIGN.md prod)
- Importer les tokens : `<link rel="stylesheet" href="tokens.css">` (mêmes variables pour les 3 variantes).
- **Light-first** : fond blanc → `--primary-50`. Aucun overlay sombre en hero (sauf bande navy volontaire en section).
- Couleurs **uniquement** via `var(--...)`. Navy `--primary-500`, CTA **toujours** `--accent-600` texte blanc.
- **Jamais** : dégradé sur du texte, violet, néon, box-shadow tape-à-l'œil, carousel auto, stock photo de gens qui sourient, pop-up.
- Typo : titres `--font-display` (DM Sans) poids 700-800 ; corps `--font-sans` (Inter). H1 hero ~48-60px.
- Radius : boutons 8px, cartes 12px. Bordures `1px solid var(--border)` (fines).
- Décor autorisé : orbs ronds + halos flous **très doux** (opacité basse), dimensions fixes (CLS=0). Coupés sous `prefers-reduced-motion`.
- **Responsive** : desktop + mobile 375px (grilles → 1 colonne, nav → hamburger). Ne pas descendre le texte sous 14px.
- Un seul `<h1>` par page. HTML sémantique (`<nav> <main> <section> <footer>`).
- CTA principal orienté valeur : « Vérifier ma conformité », « Voir la méthode », « Utiliser les outils » — **jamais** « Contactez-nous » seul en hero.

## Structure attendue (chaque variante = page autonome, above-the-fold + 3-4 sections)
1. NAV (logo NeoGTB gauche + liens : Décret BACS · Outils · AMO · Réglementation · À propos ; CTA droite)
2. HERO (H1 positionnement + sous-titre + badge indépendance + 1 CTA primaire + 1 CTA secondaire + visuel/à droite selon direction)
3. Bande de preuve / crédibilité (chiffres décret OU sources officielles OU logos organismes en gris)
4. Section signature (DIFFÈRE selon la direction — voir brief spécifique)
5. CTA final (une seule action) + footer léger (indépendance rappelée + © NeoGTB)

Livrer un seul fichier HTML complet et valide, CSS de variante dans un `<style>` en tête (les tokens viennent de tokens.css).
