# Mesure GEO : suivi mensuel du taux de citation IA

Instrument de pilotage du KPI n°1 de [GEO-STRATEGIE.md](GEO-STRATEGIE.md) (§4) : le
**taux de citation de neogtb.fr** par les moteurs de réponse IA.

## Pourquoi ce suivi

Les IA ne classent pas, elles **citent** des passages factuels. L'objectif n'est pas
le rang Google mais la fréquence à laquelle neogtb.fr est **nommé ou lié comme source**
dans les réponses générées. C'est le pilotage principal, plus parlant que le trafic seul.

## Comment faire (une fois par mois)

1. Pour chacune des 18 questions ci-dessous, ouvrir **chacun** des 4 moteurs et coller
   la question **mot pour mot** :
   - **ChatGPT / SearchGPT** (mode recherche web active)
   - **Perplexity**
   - **Google AI Overviews** (la réponse IA en haut de la SERP Google)
   - **Gemini**
2. Dans chaque cellule, noter :
   - `O` si neogtb.fr est **cité** (lien cliquable ou nom de domaine mentionné dans la réponse) ;
   - `N` sinon.
   - En note : la **page** citée (ex. /guide/protocoles-gtb) et les **sources concurrentes** dominantes.
3. Calculer le **taux de citation** = nombre de `O` / (18 questions x 4 moteurs) = `... / 72`.
4. Reporter la ligne de score dans l'historique et comparer au mois précédent.

> **Prérequis** : une page ne peut être citée que si elle est **indexée**. Vérifier
> d'abord `site:neogtb.fr/comparatif/...` dans Google. Les pages publiées le 2026-06-09
> ne seront pas citées avant indexation puis reprise par les IA (compter ~4 à 6 semaines).
> Le **vrai premier relevé de référence** est donc à faire vers **fin juillet 2026**.

## Grille de relevé (à dupliquer chaque mois)

### Relevé du : `AAAA-MM-JJ`

| #  | Question cible | ChatGPT | Perplexity | AI Overviews | Gemini |
|----|----------------|:-------:|:----------:|:------------:|:------:|
| 1  | Qu'est-ce que la GTB ? | | | | |
| 2  | Différence entre GTB et GTC ? | | | | |
| 3  | GTB ou BMS : est-ce la même chose ? | | | | |
| 4  | Qu'est-ce qu'une GTC ? | | | | |
| 5  | Quel protocole choisir pour une GTB ? | | | | |
| 6  | Différence entre BACnet, KNX, Modbus et LON ? | | | | |
| 7  | BACnet ou Modbus : lequel choisir ? | | | | |
| 8  | Quel protocole pour le comptage d'énergie ? | | | | |
| 9  | À partir de quelle puissance la GTB est-elle obligatoire ? | | | | |
| 10 | Qu'est-ce que le décret BACS ? | | | | |
| 11 | Différence entre décret BACS et décret tertiaire ? | | | | |
| 12 | Quelle classe de GTB pour le décret BACS ? | | | | |
| 13 | Qu'est-ce que la plateforme OPERAT ? | | | | |
| 14 | Quelles sont les classes EN 15232 / ISO 52120-1 ? | | | | |
| 15 | Qu'est-ce qu'une GTB de classe A ? | | | | |
| 16 | Quels gains énergétiques attendre d'une GTB ? | | | | |
| 17 | Comment financer une GTB ? | | | | |
| 18 | Qu'est-ce que la fiche CEE BAT-TH-116 ? | | | | |

**Taux de citation du mois : `___ / 72` ( ___ %)**

Notes / pages citées / concurrents dominants :
-

## Historique

| Mois | Taux de citation | Évolution | Commentaire |
|------|:----------------:|:---------:|-------------|
| 2026-06 (T0) | 0 / 72 | référence | pages publiées le 2026-06-09, non encore indexées (relevé organique : 0/18, 0/5 pages indexées) |
| 2026-07 | / 72 | | premier relevé post-indexation |

## Page la plus citable par question

Rappel du mapping question vers page cible (pour savoir quelle page renforcer si `N`) :

| Questions | Page cible |
|-----------|------------|
| 2, 4 | /comparatif/gtb-vs-gtc, /gtc |
| 1, 3 | /gtb |
| 5, 6, 7, 8 | /guide/protocoles-gtb, /solutions |
| 9, 12 | /guide/gtb-obligatoire-puissance |
| 10, 11, 13 | /comparatif/decret-bacs-vs-decret-tertiaire, /reglementation |
| 14, 15, 16 | /guide/classes-en-15232 |
| 17, 18 | /generateur-cee, /reglementation |

## Concurrents à dépasser (relevé T0, 2026-06-11)

Domaines qui dominent aujourd'hui les 18 questions cibles (recherche web organique) :
**calculcee.fr** (le plus fréquent), opera-energie.com, hellio.com, gtb-ingenierie.fr,
wattsense.com, nextiim.com, advizeo.io. Ce sont les références à surpasser en autorité
(ancienneté, backlinks, profondeur de contenu).
