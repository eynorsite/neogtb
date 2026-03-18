# LOGOS PARTENAIRES — État des logos

**Date** : 18 mars 2026
**Emplacement** : `public/images/logos/partenaires/`

## État de chaque logo

| Marque | Fichier | Format | Statut | Source officielle |
|--------|---------|--------|--------|-------------------|
| **Siemens** | `logo-siemens.svg` | SVG placeholder | Placeholder texte | Télécharger depuis press.siemens.com/global/en/material/logos |
| **Schneider Electric** | `logo-schneider.svg` | SVG placeholder | Placeholder texte | Télécharger depuis se.com/fr/fr/about-us/press/brand-assets/ |
| **Honeywell** | `logo-honeywell.svg` | SVG placeholder | Placeholder texte | Télécharger depuis honeywell.com/us/en/press/media-resources |
| **Johnson Controls** | `logo-johnson.svg` | SVG placeholder | Placeholder texte | Télécharger depuis johnsoncontrols.com/media-center |
| **Sauter** | `logo-sauter.svg` | SVG placeholder | Placeholder texte | Contacter sauter-controls.com/fr pour kit presse |
| **Distech Controls** | `logo-distech.svg` | SVG placeholder | Placeholder texte | Contacter distech-controls.com/fr pour kit presse |
| **KNX Association** | `logo-knx.svg` | SVG placeholder | Placeholder texte | Télécharger depuis knx.org section presse |
| **TheWatchdog** | `logo-watchdog.svg` | SVG placeholder | Placeholder texte | Contacter le site officiel TheWatchdog |

## Comment obtenir les logos officiels

1. **Siemens, Schneider, Honeywell** : Kits presse disponibles en téléchargement libre sur leurs sites respectifs (section "Press" ou "Media Resources")
2. **Johnson Controls, Sauter, Distech** : Contacter le service presse/communication pour obtenir les fichiers SVG haute résolution
3. **KNX** : Logo disponible via MyKNX (compte professionnel) ou section presse knx.org
4. **TheWatchdog** : Contacter directement l'entreprise

## Spécifications techniques requises

- **Format** : SVG (priorité) + PNG transparent (fallback)
- **Hauteur minimale** : 200px pour le PNG
- **Fond** : Transparent obligatoire
- **Optimisation SVG** : Passer par SVGO avant intégration
- **Nommage** : `logo-[marque].svg` (minuscules, tirets)

## Intégration sur le site

- **Page d'accueil** : Section "Les technologies que nous maîtrisons"
- **Comportement** : Gris par défaut → couleur au hover (CSS `grayscale` filter)
- **Tooltip** : "Technologie maîtrisée par NeoGTB"
- **Lien** : Chaque logo renvoie vers `/comparateur`
- **Mobile** : Défilement horizontal avec snap scroll
- **Mention légale** : "NeoGTB est indépendant de ces marques"

## Remplacement des placeholders

Pour remplacer un placeholder par le logo officiel :
1. Télécharger le logo SVG officiel
2. Optimiser avec `npx svgo logo-[marque].svg`
3. Placer dans `public/images/logos/partenaires/`
4. Le site utilise automatiquement le nouveau fichier
