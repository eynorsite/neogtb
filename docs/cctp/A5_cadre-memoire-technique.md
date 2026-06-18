# A5 — Cadre du mémoire technique attendu

> **Pièce de la suite « Consultation GTB vendor-neutral » — NeoGTB.**
> Cadre imposé au candidat pour la rédaction de son mémoire technique.
> Sert de base à la notation objective du critère « valeur technique » (grille A6).

---

## Légende des statuts

| Statut | Sens |
|---|---|
| **[OBLIGATION]** | Imposé par le marché. Le non-respect rend l'offre irrégulière ou non notable sur la rubrique. |
| **[RECOMMANDATION]** | Bonne pratique attendue ; l'absence pénalise la note sans rendre l'offre irrégulière. |
| **[CONVENTION]** | Choix de présentation/format retenu par le MOA pour comparer les offres. |
| **[INFORMATIF]** | Explication, ne crée pas d'exigence en soi. |

*MOA = maître d'ouvrage (acheteur). Titulaire / candidat = prestataire qui remet l'offre.*

---

## 1. Objet et portée de ce cadre [INFORMATIF]

Ce document fixe **la trame imposée du mémoire technique** que chaque candidat doit produire à l'appui de son offre.

**Pourquoi une trame imposée ?** Un critère « valeur technique » noté sans support documentaire structuré est **contestable** : l'acheteur ne peut pas démontrer qu'il a comparé les offres sur une base homogène. En imposant la structure ci-dessous, chaque sous-critère de la grille de dépouillement **A6** est rattaché à une rubrique précise du mémoire, ce qui rend la notation traçable et défendable.

**Règle de notation [OBLIGATION] :** chaque rubrique 1 à 10 est **obligatoire**. Une rubrique **absente** est notée **0** sur les sous-critères qui en dépendent. Une rubrique **incomplète** (pièce justificative manquante, affirmation non étayée) est **pénalisée** : seul ce qui est **prouvé** est crédité. Les affirmations non sourcées (« compatible », « ouvert », « conforme ») **sans pièce jointe** ne sont pas créditées.

> 🔀 **OPTION format global** — le MOA choisit l'une des deux :
> - **Option A — volume libre encadré** : pas de plafond global, mais plafonds par rubrique ci-dessous.
> - **Option B — volume plafonné** : mémoire limité à **[À COMPLÉTER : ex. 30] pages** hors annexes/certificats. Au-delà, les pages excédentaires ne sont pas lues.

> 🔀 **OPTION pièces hors plafond** — préciser : `[À COMPLÉTER : les certificats, PICS/PICS-équivalents, fiches produits et CV comptent / ne comptent pas dans le volume]`.

---

## 2. Règles communes de forme [CONVENTION]

- **Format de remise :** PDF unique recherchable (OCR si scans), sommaire paginé reprenant les numéros de rubrique 1 à 10.
- **Traçabilité :** chaque affirmation technique sensible (protocole, classe, certification) **renvoie à une pièce jointe numérotée** (annexe).
- **Langue :** français. Documents constructeurs en anglais admis **en annexe**, avec synthèse en français dans le corps.
- **Tableaux imposés :** les tableaux des rubriques 4 et 5 sont **à reprendre tels quels** (mêmes colonnes), pour permettre la comparaison ligne à ligne entre candidats.
- **Renvois :** le mémoire s'articule avec les autres pièces de la consultation — cadre liste de points **A3**, BPU/DPGF **A4**, CCAP **A2**, grille de dépouillement **A6**.

---

## 3. Rubriques imposées

> Pour chaque rubrique : **objet**, **attendu détaillé**, **format / plafond**, **pièces à joindre**, **lien grille A6**, **règle de pénalité**.

---

### Rubrique 1 — Présentation de l'équipe et références comparables
**Lien grille A6 :** critère **C5** (références / capacité).

**[OBLIGATION] Attendu**
- Présentation de l'équipe **affectée** (pas seulement l'entreprise) : intégrateur GTB, automaticien, chargé d'affaires, responsable mise en service, référent cybersécurité.
- **Références comparables** : opérations de GTB de nature et d'ampleur similaires (typologie de bâtiment, surface, nombre de points, lots техniques pilotés), avec pour chacune : maître d'ouvrage, année de réception, périmètre, **protocoles déployés**, et si possible classe de performance visée/atteinte (cf. rubrique 5).

**[CONVENTION] Format**
- **[À COMPLÉTER : ex. 4] pages** maximum pour le corps.
- **Pièces à joindre :** CV synthétiques (1 page/personne, **en annexe**), fiches de référence (**[À COMPLÉTER : ex. 3 à 5]** fiches, 1 page chacune, **en annexe**), attestations de bonne exécution si disponibles.

**[OBLIGATION] Pénalité**
- Référence non comparable (typologie ou ampleur sans rapport) = non créditée.
- Référence sans périmètre technique vérifiable (pas de protocoles, pas de volume de points) = non créditée.

---

### Rubrique 2 — Architecture proposée (3 niveaux, schéma, protocoles par lot)
**Lien grille A6 :** critères **C1** (architecture) et **C2** (ouverture / interopérabilité).

**[OBLIGATION] Attendu**
- **Schéma d'architecture** lisible faisant apparaître les **3 niveaux** : terrain (capteurs/actionneurs), automation (automates/contrôleurs), gestion (supervision/serveur GTB).
- **Protocole(s) par lot technique** : pour chaque lot (CVC, éclairage, CFO/CFA, comptage, etc.), indiquer le protocole de communication retenu et la passerelle éventuelle.
- Positionnement des passerelles, des bus, du réseau IP, et localisation physique des équipements.
- Justification des choix au regard de l'**ouverture** (cf. rubrique 4) et de la **réversibilité** (cf. rubrique 6).

**[CONVENTION] Format**
- **[À COMPLÉTER : ex. 6] pages** + **1 schéma** A3 dépliable (**en annexe**).
- **Pièces à joindre :** schéma d'architecture, synoptique réseau.

**[OBLIGATION] Pénalité**
- Architecture ne distinguant pas les 3 niveaux = pénalisée sur C1.
- Protocoles non précisés par lot, ou protocole **propriétaire** imposé sans justification ni voie d'ouverture = pénalisée sur C2.

---

### Rubrique 3 — Liste de points prévisionnelle et plan d'adressage
**Renvoi cadre :** **A3** (cadre de la liste de points). **Lien grille A6 :** contribue à **C1**.

**[OBLIGATION] Attendu**
- **Liste de points prévisionnelle** au **format imposé du cadre A3** (mêmes colonnes : repère, équipement, type AI/AO/BI/BO, unité, lot, protocole…).
- **Plan d'adressage** cohérent (logique de nommage des points/objets, plan d'adressage réseau et bus).
- Mise en évidence des **points obligatoires** au regard des fonctions visées (cf. rubrique 5).

**[CONVENTION] Format**
- Tableau **A3** complété (**en annexe**, tableur + PDF).
- **[À COMPLÉTER : ex. 2] pages** de note explicative dans le corps.

**[OBLIGATION] Pénalité**
- Liste non conforme au format A3 (colonnes modifiées/supprimées) = non comparable, pénalisée.
- Plan d'adressage absent = pénalisé.

---

### Rubrique 4 — Preuves d'ouverture et d'interopérabilité
**Lien grille A6 :** critère **C2** (ouverture / interopérabilité). **C'est la rubrique « preuves », pas « déclarations ».**

**[OBLIGATION] Attendu**
- **Certifications / déclarations de conformité protocolaires** des produits proposés, avec pièces à l'appui :
  - **BACnet** : certificat **BTL** (BACnet Testing Laboratories) et **PICS** (Protocol Implementation Conformance Statement) des équipements concernés ;
  - **KNX** : certification KNX des produits ;
  - **DALI-2** : certification DALI-2 (référence du certificat / numéro d'enregistrement) ;
  - **OMS** (Open Metering System) pour le comptage, le cas échéant.
- **Tableau des protocoles supportés nativement** (imposé, à reprendre tel quel) :

| Équipement / produit | Rôle (niveau) | Protocole(s) natif(s) | Certification (BTL/KNX/DALI-2/OMS) | N° / réf. certificat | Pièce jointe n° |
|---|---|---|---|---|---|
| [À COMPLÉTER] | terrain / automation / gestion | [À COMPLÉTER] | [À COMPLÉTER] | [À COMPLÉTER] | [À COMPLÉTER] |

- Distinguer **support natif** vs **support via passerelle** (à signaler explicitement).

**[CONVENTION] Format**
- **[À COMPLÉTER : ex. 3] pages** + tableau ci-dessus.
- **Pièces à joindre :** certificats BTL / PICS / KNX / DALI-2 / OMS (**en annexe**), fiches produits.

**[OBLIGATION] Pénalité**
- Affirmation d'ouverture **sans certificat / PICS joint** = **non créditée**.
- Support « via passerelle » présenté comme « natif » = pénalisé (information inexacte).

> **[INFORMATIF]** L'ouverture est ici **prouvée par pièces**, pas déclarée. Un produit « compatible BACnet » sans PICS n'est pas considéré comme prouvé.

---

### Rubrique 5 — Démarche d'atteinte de la classe NF EN ISO 52120-1 visée
**Lien grille A6 :** critère **C3** (performance / classe).

**[OBLIGATION] Attendu**
- Rappel de la **classe visée** : `[À COMPLÉTER : classe A / B / C selon NF EN ISO 52120-1:2022]`.
- **Justification fonction par fonction** : pour chaque fonction d'automatisation et de gestion technique requise, démontrer **comment** la solution proposée atteint le niveau de la classe visée (point(s) mis en œuvre, séquence de régulation, supervision associée).
- **Tableau de justification** (imposé) :

| Fonction (réf. NF EN ISO 52120-1:2022) | Niveau requis pour la classe visée | Solution proposée | Points / équipements concernés | Renvoi liste A3 |
|---|---|---|---|---|
| [À COMPLÉTER] | [À COMPLÉTER] | [À COMPLÉTER] | [À COMPLÉTER] | [À COMPLÉTER] |

**[CONVENTION] Format**
- **[À COMPLÉTER : ex. 5] pages** + tableau de justification.
- **Pièces à joindre :** matrice fonctions ↔ points.

**[OBLIGATION] Pénalité**
- Classe **affirmée sans justification fonction par fonction** = non créditée (seule la classe **démontrée** est notée).
- Fonctions manquantes par rapport au niveau revendiqué = la classe réellement justifiée est retenue (généralement inférieure), pénalisation à due proportion.

> **[INFORMATIF] — repères normatifs vérifiés.**
> - La norme **NF EN ISO 52120-1:2022** remplace l'**EN 15232-1:2017** comme référentiel des classes de performance d'automatisation/gestion technique du bâtiment.
> - Le **décret BACS** (décret n° **2020-887** modifié par le décret n° **2023-259**) impose des **fonctions** (article **R.175-3** du Code de la construction et de l'habitation), **pas une classe**. La classe NF EN ISO 52120-1 est un **objectif de performance** que le MOA peut fixer contractuellement, à distinguer de l'obligation réglementaire de fonctions.
> - Toute autre référence (numéro d'article, version, échéance) non listée ici est à traiter comme **[À VÉRIFIER]** sur Légifrance / le texte AFNOR avant diffusion.

---

### Rubrique 6 — Plan de réversibilité
**Lien grille A6 :** critère **C4** (réversibilité). **Renvoi :** CCAP **A2** (clauses de réversibilité / propriété).

**[OBLIGATION] Attendu**
- **Sources et configurations** : engagement de remise des programmes automates, configurations supervision, schémas, dans des **formats exploitables**.
- **Licences** : nature des licences (perpétuelles / locatives), périmètre, transférabilité au MOA ou à un tiers mainteneur.
- **Mots de passe / comptes d'administration** : remise des accès administrateur au MOA (pas de verrouillage constructeur).
- **Formats ouverts** : formats d'export des données et de la configuration (éviter les formats propriétaires fermés).
- **API** : interfaces ouvertes documentées permettant l'interopérabilité et la reprise par un tiers.

**[CONVENTION] Format**
- **[À COMPLÉTER : ex. 4] pages**.
- **Pièces à joindre :** engagement de réversibilité signé renvoyant aux clauses du **CCAP A2**, liste des livrables de réversibilité.

**[OBLIGATION] Pénalité**
- Toute dépendance créant un **verrouillage** (licence non transférable, accès admin retenu, format fermé sans export) = pénalisée sur C4.
- Plan de réversibilité incohérent avec le CCAP A2 = pénalisé.

---

### Rubrique 7 — Cybersécurité
**Lien grille A6 :** **[À COMPLÉTER : critère C—] s'il existe une ligne cybersécurité dédiée dans A6 ; sinon contribue à C1 (architecture).**

**[OBLIGATION] Attendu**
- **Segmentation OT/IT** : séparation des réseaux d'automatisation (OT) et bureautique (IT), VLAN, pare-feu, règles de flux.
- **Sécurisation des protocoles** : recours à **BACnet/SC** (Secure Connect) ou équivalent lorsque le protocole le permet ; chiffrement / authentification des communications.
- Gestion des comptes et des accès distants (mise en service, télémaintenance), journalisation, gestion des mises à jour de sécurité.

**[CONVENTION] Format**
- **[À COMPLÉTER : ex. 3] pages** + schéma de segmentation (**en annexe**).
- **Pièces à joindre :** schéma OT/IT, politique d'accès distant.

**[RECOMMANDATION] Pénalité**
- Absence de segmentation OT/IT ou de toute mesure de sécurisation des échanges = pénalisée.

---

### Rubrique 8 — Plan de charge, planning, jalons
**Lien grille A6 :** critère **C6** (planning / organisation).

**[OBLIGATION] Attendu**
- **Planning détaillé** : études, approvisionnements, déploiement, mise en service, essais (COSME / autocontrôles), réception.
- **Jalons** contractuels et **plan de charge** (ressources affectées par phase).
- Articulation avec les autres lots et les contraintes d'exploitation du site (interventions en site occupé le cas échéant).

**[CONVENTION] Format**
- **[À COMPLÉTER : ex. 3] pages** + **diagramme de Gantt** (**en annexe**).
- **Pièces à joindre :** Gantt, plan de charge.

**[OBLIGATION] Pénalité**
- Planning non daté / sans jalons = pénalisé.
- Délai incompatible avec le calendrier du marché = pénalisé (voire irrégulier si délai impératif au CCAP A2).

---

### Rubrique 9 — Maintenance, SAV, formation
**Lien grille A6 :** critère **C7** (exploitation / maintenance / formation).

**[OBLIGATION] Attendu**
- **Maintenance** : périmètre, niveaux (préventif/correctif), GMAO le cas échéant, pièces de rechange.
- **SAV** : délais d'intervention garantis (GTI/GTR), modalités de support et de télémaintenance, astreinte.
- **Formation** : programme de formation des exploitants/utilisateurs (contenu, durée, supports remis), transfert de compétences.

**[CONVENTION] Format**
- **[À COMPLÉTER : ex. 4] pages**.
- **Pièces à joindre :** plan de formation, modèle de contrat de maintenance / engagement GTI-GTR.

**[OBLIGATION] Pénalité**
- Délais SAV non chiffrés = non crédités.
- Formation absente ou non détaillée = pénalisée.

---

### Rubrique 10 — Décomposition de prix / TCO (coût global)
**Renvoi cadre :** **A4** (BPU / DPGF). **Lien grille A6 :** critère **C8** (prix / coût global).

**[OBLIGATION] Attendu**
- **Décomposition de prix** cohérente avec le **BPU / DPGF (cadre A4)** — aucune divergence de chiffres entre le mémoire et A4.
- **TCO (Total Cost of Ownership)** sur une durée de référence : `[À COMPLÉTER : ex. 10 ans]` — investissement initial, maintenance, licences récurrentes, énergie/exploitation si pertinent, réversibilité.
- Mise en évidence des **coûts récurrents** (licences, abonnements cloud, télémaintenance) qui pèsent sur le coût global et la réversibilité.

**[CONVENTION] Format**
- **[À COMPLÉTER : ex. 3] pages** + tableau TCO (**en annexe**, tableur).
- **Pièces à joindre :** TCO, **renvoi au cadre A4 complété** (le BPU/DPGF reste la pièce financière contractuelle).

**[OBLIGATION] Pénalité**
- Chiffres du mémoire divergents de A4 = **A4 fait foi**, divergence signalée et pénalisée.
- TCO absent ou masquant les coûts récurrents = pénalisé sur C8.

---

## 4. Synthèse — table de correspondance rubriques ↔ grille A6 [CONVENTION]

| Rubrique mémoire | Objet | Critère(s) A6 | Pièce(s) renvoyée(s) |
|---|---|---|---|
| 1 | Équipe / références comparables | **C5** | — |
| 2 | Architecture 3 niveaux / protocoles par lot | **C1, C2** | — |
| 3 | Liste de points prévisionnelle + adressage | C1 | **A3** |
| 4 | Preuves d'ouverture (BTL/PICS, KNX, DALI-2, OMS) | **C2** | — |
| 5 | Démarche classe NF EN ISO 52120-1 | **C3** | A3 |
| 6 | Plan de réversibilité | **C4** | **CCAP A2** |
| 7 | Cybersécurité (OT/IT, BACnet/SC) | C1 / **[À COMPLÉTER]** | — |
| 8 | Plan de charge / planning / jalons | **C6** | A2 |
| 9 | Maintenance / SAV / formation | **C7** | — |
| 10 | Décomposition de prix / TCO | **C8** | **A4** |

> **[OBLIGATION] Rappel final :** toute rubrique **manquante** = 0 sur les critères associés ; toute rubrique **incomplète** ou **non prouvée par pièces** est **pénalisée**. Seul ce qui est **démontré et joint** est noté.
