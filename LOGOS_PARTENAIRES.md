# LOGOS PARTENAIRES — État des logos

**Date** : 19 mars 2026
**Emplacement** : `public/images/logos/partenaires/`

## État de chaque logo

| Marque | Fichier | Format | Statut | Source |
|--------|---------|--------|--------|--------|
| **Siemens** | `logo-siemens.svg` | SVG officiel | ✅ Intégré | Wikimedia Commons |
| **Schneider Electric** | `logo-schneider.svg` | SVG officiel | ✅ Intégré | se.com (officiel) |
| **Honeywell** | `logo-honeywell.svg` | SVG officiel | ✅ Intégré | Wikimedia Commons |
| **Sauter** | `logo-sauter.svg` | SVG officiel | ✅ Intégré | Wikimedia Commons |
| **KNX Association** | `logo-knx.svg` | SVG officiel | ✅ Intégré | Wikimedia Commons |
| **TheWatchdog** | `logo-watchdog.png` | PNG officiel | ✅ Intégré | thewatchdog.io |

## Logos exclus du projet

| Marque | Raison |
|--------|--------|
| **Johnson Controls** | Retiré par décision du 19/03/2026 |
| **Distech Controls** | Retiré par décision du 19/03/2026 |

## Comment obtenir les logos officiels

1. **Siemens, Schneider, Honeywell** : Kits presse disponibles en téléchargement libre sur leurs sites respectifs (section "Press" ou "Media Resources")
2. **Sauter** : Contacter le service presse/communication pour obtenir les fichiers SVG haute résolution
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
