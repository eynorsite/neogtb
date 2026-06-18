# A4 — CADRE DE DÉCOMPOSITION DE PRIX IMPOSÉ (BPU / DPGF) + CADRE TCO
## Consultation GTB multi-protocole vendor-neutral — pièce financière

> **Pièce de consultation complémentaire** au CCTP `CCTP-GTB-multiprotocole-vendor-neutral.md` (développe l'**Annexe C — TCO**) et à la `grille-depouillement-GTB.md`. Modèle réutilisable, à adapter au projet.
>
> **À quoi sert cette pièce** : sans cadre de décomposition **imposé**, chaque candidat décompose son prix à sa façon → les offres deviennent **incomparables** et le critère **« Coût global de possession (TCO) » (C8 de la grille)** est **inapplicable**. Ce cadre force une décomposition **homogène** :
> - **BPU** (Bordereau des Prix Unitaires) = prix unitaires à appliquer aux quantités (utile pour les extensions et le coût au point) ;
> - **DPGF** (Décomposition du Prix Global et Forfaitaire) = ventilation du forfait par lot et par poste ;
> - **Cadre TCO** = projection du coût sur une durée de référence.

---

## LÉGENDE DES STATUTS

| Marqueur | Sens |
|---|---|
| **[OBLIGATION]** | Exigence réglementaire ou normative opposable (à reconfirmer sur source primaire avant diffusion). |
| **[RECOMMANDATION]** | Bonne pratique conseillée par NeoGTB, **non obligatoire** ; choix du MOA. |
| **[CLAUSE CONTRACTUELLE]** | Engagement à porter au CCTP / CCAP, opposable au titulaire une fois le marché signé. |
| **[INFORMATIF]** | Explication, aide à la lecture, sans portée contraignante. |

---

## NOTICE D'EMPLOI (à lire avant de remplir)

**[INFORMATIF]**
- **Tous les montants sont `[À COMPLÉTER]`** : ce cadre **ne contient aucun chiffre** de prix, de maintenance, de licence ni de gain. Les montants sont renseignés par le **candidat** (offre) ou par le **MOA** (estimation amont, cas du TCO prévisionnel).
- **[CLAUSE CONTRACTUELLE]** Le candidat **remplit ce cadre tel quel**, sans en modifier la structure ni les intitulés de postes. Une offre dont la décomposition diffère du cadre peut être déclarée **irrégulière** ou demandée à régulariser, car non comparable.
- **[RECOMMANDATION]** Préciser au règlement de consultation l'**unité monétaire**, le régime de **TVA** (HT/TTC), la **devise**, et si les prix sont **fermes ou révisables** (et selon quelle formule). `[À COMPLÉTER : € HT, TVA …, prix fermes/révisables]`.
- **[INFORMATIF]** Conventions : `[À COMPLÉTER]` = à renseigner ; `[À COMPLÉTER : …]` = à renseigner avec la consigne entre crochets ; blocs `🔀 OPTION` = à activer/supprimer selon le projet.

---

## 1. DPGF — DÉCOMPOSITION DU PRIX GLOBAL ET FORFAITAIRE (par lot)

> **[CLAUSE CONTRACTUELLE]** Le total de chaque lot est reporté au **récapitulatif §3**. Les postes ci-dessous sont **imposés** ; le candidat peut détailler sous chaque poste mais **ne supprime aucune ligne**.

### 1.1 — Lot CVC

| Poste | Détail / base de prix | Quantité | P.U. | Montant |
|---|---|---|---|---|
| Matériel (capteurs, actionneurs, régulateurs, automates, passerelles) | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` |
| Intégration / paramétrage (programmation, mappings, IHM) | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` |
| Mise en service (essais, réglages, COPREC) | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` |
| Documentation (DOE, table de points, dossier de réversibilité) | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` |
| Formation des exploitants | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` |
| **Sous-total lot CVC** | | | | **`[À COMPLÉTER]`** |

### 1.2 — Lot Éclairage (DALI)

| Poste | Détail / base de prix | Quantité | P.U. | Montant |
|---|---|---|---|---|
| Matériel (passerelles DALI-2, capteurs présence/lumière, drivers) | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` |
| Intégration / paramétrage (adressage DALI, groupes, scènes) | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` |
| Mise en service (commissioning DALI, essais) | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` |
| Documentation (plan d'adressage, table de points) | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` |
| Formation des exploitants | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` |
| **Sous-total lot Éclairage** | | | | **`[À COMPLÉTER]`** |

### 1.3 — Lot Comptage

| Poste | Détail / base de prix | Quantité | P.U. | Montant |
|---|---|---|---|---|
| Matériel (compteurs, sous-compteurs, concentrateurs M-Bus, TI) | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` |
| Intégration / paramétrage (relevé, agrégation par usage) | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` |
| Mise en service (vérification index, cohérence usages) | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` |
| Documentation (synoptique comptage, table de points) | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` |
| Formation des exploitants | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` |
| **Sous-total lot Comptage** | | | | **`[À COMPLÉTER]`** |

### 1.4 — Lot Supervision GTB

| Poste | Détail / base de prix | Quantité | P.U. | Montant |
|---|---|---|---|---|
| Matériel (serveur/superviseur, postes, réseau, sauvegarde) | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` |
| Intégration / paramétrage (vues, synoptiques, alarmes, droits) | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` |
| Mise en service (recette fonctionnelle, tests d'alarmes) | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` |
| Documentation (DOE supervision, dossier de réversibilité, mots de passe) | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` |
| Formation des exploitants / administrateurs | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` |
| **Sous-total lot Supervision** | | | | **`[À COMPLÉTER]`** |

> 🔀 **OPTION lots complémentaires** — ajouter un tableau identique par lot supplémentaire (CFO/TGBT, contrôle d'accès, désenfumage, photovoltaïque…). *À activer selon périmètre.*

---

## 2. BPU — BORDEREAU DES PRIX UNITAIRES

> **[CLAUSE CONTRACTUELLE]** Les prix unitaires ci-dessous s'appliquent à toute **quantité ajoutée ou retranchée** en cours de marché (ordres de service, avenants). **Ils figent notamment le « coût d'extension par point de données »** — cf. §2.2.

### 2.1 — Prix unitaires d'ouvrages élémentaires

| Code | Désignation prestation unitaire | Unité | P.U. |
|---|---|---|---|
| BPU-01 | Fourniture + pose capteur de température | u | `[À COMPLÉTER]` |
| BPU-02 | Fourniture + pose sonde CO₂ / qualité d'air | u | `[À COMPLÉTER]` |
| BPU-03 | Fourniture + pose actionneur de vanne / registre | u | `[À COMPLÉTER]` |
| BPU-04 | Fourniture + pose sous-compteur électrique | u | `[À COMPLÉTER]` |
| BPU-05 | Fourniture + pose passerelle protocolaire (par interface) | u | `[À COMPLÉTER]` |
| BPU-06 | Heure d'ingénierie / paramétrage | h | `[À COMPLÉTER]` |
| BPU-07 | Journée de mise en service | j | `[À COMPLÉTER]` |
| BPU-08 | Journée de formation exploitant | j | `[À COMPLÉTER]` |

### 2.2 — Coût d'extension par point de données (anti-licence abusive)

> **[RECOMMANDATION]** Poste **clé** du dispositif vendor-neutral : il **fige à l'avance** le prix d'ajout d'un point, supervision comprise, pour **empêcher toute facturation abusive** (licence « au point » non plafonnée) lors des évolutions du bâtiment.

| Code | Désignation | Unité | P.U. |
|---|---|---|---|
| BPU-PT-01 | Ajout d'un point physique (E/S) intégré et supervisé | point | `[À COMPLÉTER]` |
| BPU-PT-02 | Ajout d'un point logiciel (calcul / consigne) supervisé | point | `[À COMPLÉTER]` |
| BPU-PT-03 | Surcoût licence éventuel **par tranche de points** supervision | tranche | `[À COMPLÉTER : préciser la tranche, ou « néant »]` |

> **[CLAUSE CONTRACTUELLE]** Le candidat indique si l'extension de la supervision implique un **surcoût de licence** et, si oui, son **montant par tranche**. L'absence de réponse vaut **« sans surcoût de licence »**.

---

## 3. RÉCAPITULATIF FORFAIT (report DPGF §1)

| Lot | Sous-total (report §1) |
|---|---|
| CVC | `[À COMPLÉTER]` |
| Éclairage (DALI) | `[À COMPLÉTER]` |
| Comptage | `[À COMPLÉTER]` |
| Supervision GTB | `[À COMPLÉTER]` |
| 🔀 Lots optionnels | `[À COMPLÉTER]` |
| **TOTAL CAPEX (offre forfaitaire)** | **`[À COMPLÉTER]`** |

---

## 4. CADRE TCO — COÛT GLOBAL DE POSSESSION

> **[INFORMATIF]** Sert le critère **C8** de la grille de dépouillement : l'objectif vendor-neutral exige d'évaluer le coût **sur la durée**, pas le seul prix d'achat — un CAPEX bas peut cacher des **licences récurrentes** et un **lock-in** coûteux.
>
> **Durée de référence** : `[À COMPLÉTER : 8–10 ans]` (à figer au règlement de consultation, identique pour tous les candidats).

### 4.1 — Tableau TCO

| Poste | Base de calcul | Montant |
|---|---|---|
| **CAPEX** — matériel + intégration + mise en service | Report TOTAL CAPEX (§3) | `[À COMPLÉTER]` |
| **Maintenance annuelle × durée** | Maintenance an. `[À COMPLÉTER]` × durée `[À COMPLÉTER : 8–10 ans]` | `[À COMPLÉTER]` |
| **Licences / abonnements supervision × durée** | Abonnement an. `[À COMPLÉTER]` × durée | `[À COMPLÉTER]` |
| **Runtime / exécution × durée** | Coût runtime an. `[À COMPLÉTER]` × durée | `[À COMPLÉTER]` |
| **Coût de réversibilité estimé** | Coût estimé de reprise par un tiers (export, doc, dé-paramétrage) | `[À COMPLÉTER]` |
| **(Optionnel) Gain énergétique** | Voir §4.2 — **en fourchette uniquement** | `[À COMPLÉTER : fourchette, ou « non valorisé »]` |
| **TCO TOTAL** | | **`[À COMPLÉTER]`** |

### 4.2 — Gain énergétique : règle de prudence (🔀 OPTION)

> **[INFORMATIF / RECOMMANDATION]** Si le MOA choisit d'intégrer un gain énergétique au TCO :
> - il est **exprimé en FOURCHETTE**, **jamais en valeur sèche** ;
> - il porte la **mention obligatoire** : *« estimation amont, méthode des facteurs, hors climat et hors profil d'occupation réels, à confirmer par calcul détaillé »* ;
> - **aucun pourcentage d'économie « en dur »** n'est inscrit ici. Toute valeur chiffrée est `[À COMPLÉTER : fourchette … à confirmer par calcul détaillé]`.

| Élément | Valeur |
|---|---|
| Économie énergétique estimée (fourchette) | `[À COMPLÉTER : … à … — à confirmer par calcul détaillé]` |
| Hypothèse de prix de l'énergie | `[À COMPLÉTER]` |
| Méthode de vérification post-travaux | `[À COMPLÉTER : ex. mesure & vérification IPMVP, OPERAT]` |

> **[OBLIGATION NeoGTB — zéro invention]** Tant que le calcul détaillé n'est pas produit, **ne remplacer aucune `[À COMPLÉTER]` par un chiffre sec**. Le gain reste une **fourchette à confirmer** ou la mention **« non valorisé »**.

### 4.3 — Comparaison inter-offres

> **[RECOMMANDATION]** Reporter le **TCO TOTAL** de chaque candidat dans la grille de dépouillement, critère **C8**, et appliquer la formule du moins-disant **au TCO** (et non au seul CAPEX) : `Note = (TCO le plus bas / TCO de l'offre) × note max`.

| Candidat | CAPEX | Maint. ×durée | Licences ×durée | Réversibilité | TCO TOTAL |
|---|---|---|---|---|---|
| Candidat A | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` |
| Candidat B | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` |
| Candidat C | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` | `[À COMPLÉTER]` |

---

## RAPPEL CONTRACTUEL

**[CLAUSE CONTRACTUELLE]**
1. Le candidat remplit DPGF (§1), BPU (§2) et cadre TCO (§4) **sans altérer la structure** ; toute décomposition divergente rend l'offre **incomparable** (irrégulière / à régulariser).
2. Les **prix unitaires (§2)** s'appliquent aux extensions ; le **coût d'extension par point** est ferme pour la durée du marché (anti-licence abusive).
3. Le **TCO** est calculé sur la **durée de référence commune** `[À COMPLÉTER : 8–10 ans]` ; le **gain énergétique** éventuel reste en **fourchette à confirmer**, sans pourcentage sec.

---

*Cadre BPU / DPGF + TCO — GTB vendor-neutral, NeoGTB. Aucun montant fourni : tout est `[À COMPLÉTER]`. Gain énergétique en fourchette « à confirmer » uniquement. Cadre imposé = condition de comparabilité du critère C8 (TCO).*
