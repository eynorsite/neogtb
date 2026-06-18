# CCTP — GESTION TECHNIQUE DU BÂTIMENT (GTB/GTC)
## Système ouvert, multi-protocole et non-discriminant

> **Modèle type réutilisable — vendor-neutral.** Document de référence n'avantageant aucune marque, aucun fabricant ni aucun protocole propriétaire. À adapter projet par projet.
>
> **Comment utiliser ce modèle**
> - Les champs `[À COMPLÉTER : …]` sont à renseigner selon le projet.
> - Les blocs `> 🔀 OPTION` sont **conditionnels** : conserver ou supprimer selon le contexte (assujettissement BACS, décret tertiaire, type de bâtiment).
> - Les balises ⚠️ **[À VÉRIFIER]** signalent un point réglementaire à reconfirmer sur la source officielle **à la date de publication** (la réglementation évolue — voir §13 « Points à vérifier avant diffusion »).
> - Maître d'ouvrage = **« le MOA »** ; titulaire du marché = **« le titulaire »**.

| Champ | Valeur |
|---|---|
| Maître d'ouvrage | `[À COMPLÉTER]` |
| Opération | `[À COMPLÉTER]` |
| Bâtiment(s) / site(s) | `[À COMPLÉTER : type, surface, usage]` |
| Lots couverts | CVC · Éclairage (DALI) · Comptage / sous-comptage énergie · Supervision GTB |
| Maître d'œuvre / AMO | `[À COMPLÉTER]` |
| Forme du marché | `[À COMPLÉTER : public / privé]` |
| Indice / date | `[À COMPLÉTER]` |

---

## SOMMAIRE

1. Objet et périmètre
2. Principes directeurs (neutralité, ouverture, réversibilité)
3. Documents de référence
4. Définitions et abréviations
5. Expression du besoin fonctionnel
6. Exigences d'interopérabilité et de protocoles
7. Exigences anti-verrouillage (clauses contractuelles)
8. Livrables et documents à remettre
9. Recette et vérifications
10. Garantie, maintenance, SAV
11. Critères d'évaluation des offres
12. Annexes (cadres à remplir par le candidat)
13. Points à vérifier avant diffusion

---

## ARTICLE 1 — OBJET ET PÉRIMÈTRE

### 1.1 Objet du marché
Le présent Cahier des Clauses Techniques Particulières (CCTP) définit les exigences relatives à la fourniture, l'installation, le paramétrage, la mise en service, la documentation et la garantie d'un système de **Gestion Technique du Bâtiment (GTB/GTC)** ouvert et interopérable pour `[À COMPLÉTER : opération]`.

Le système assure le pilotage, la régulation, le comptage, la supervision et l'optimisation énergétique des installations techniques, dans le respect des principes de **neutralité technologique** et d'**absence de verrouillage propriétaire (anti vendor lock-in)** énoncés à l'article 2.

### 1.2 Périmètre technique
Le marché couvre les lots suivants :

| Lot | Périmètre |
|---|---|
| **CVC** | Production, distribution, émission, ventilation, régulation terminale (chauffage / ventilation / rafraîchissement). |
| **Éclairage** | Pilotage, gradation, détection présence / luminosité, scènes, groupes — bus **DALI**. |
| **Comptage / sous-comptage** | Compteurs et sous-compteurs d'énergie et de fluides, par usage et par zone. |
| **Supervision GTB** | Superviseur, serveur, IHM/poste opérateur, historisation, alarmes, tableaux de bord, API d'ouverture des données. |

> 🔀 OPTION — Ajouter / retirer des lots selon le projet : `[ECS · sûreté · contrôle d'accès · GTC ascenseurs · production EnR…]`. **Ne pas inclure** la sûreté / le contrôle d'accès dans le périmètre GTB sauf besoin explicite (logiques et contraintes distinctes).

### 1.3 Limites de prestation
`[À COMPLÉTER : interfaces avec les lots CVC, électricité, plomberie ; fournitures à la charge du titulaire vs autres lots ; raccordements ; alimentations électriques ; chemins de câbles.]`

---

## ARTICLE 2 — PRINCIPES DIRECTEURS

Ces principes priment sur toute autre disposition technique. Toute solution proposée doit s'y conformer.

### 2.1 Neutralité technologique et non-discrimination
Les spécifications du présent CCTP sont exprimées en **exigences fonctionnelles et niveaux de performance** ; aucune marque, brevet, type, procédé de fabrication ou origine n'est imposé.

> 🔀 OPTION MARCHÉ PUBLIC — clauses reprenant le Code de la commande publique (à conserver pour un acheteur public ; en marché privé, les conserver à titre de bonne pratique) :
> - « Les spécifications techniques sont formulées conformément à l'article **R. 2111-8** du Code de la commande publique (en termes de performances et d'exigences fonctionnelles). »
> - « Lorsqu'une référence à une marque, un brevet ou un type apparaît, **elle est réputée suivie de la mention "ou équivalent"** au sens de l'article **R. 2111-7** du Code de la commande publique. Le titulaire peut proposer toute solution équivalente et en apporte la preuve par tout moyen approprié (art. **R. 2111-11**). »

Tout composant matériel ou logiciel **imposant le recours exclusif à un fournisseur unique** pour son exploitation, sa maintenance ou son évolution est **proscrit**, sauf justification écrite acceptée par le MOA.

### 2.2 Ouverture et interopérabilité
Le système repose **exclusivement sur des protocoles ouverts et normalisés** (article 6). Le système doit être **interopérable avec les différents systèmes techniques du bâtiment** (exigence fondée sur le décret BACS — voir §3 et §5.4). Tout protocole propriétaire fermé est proscrit pour la couche d'interopérabilité.

### 2.3 Propriété des données et réversibilité
Le MOA est propriétaire de l'intégralité des **données, configurations, paramétrages et programmations** réalisés au titre du marché. Le système doit être **reprenable par tout tiers qualifié** sans dépendance au titulaire initial (article 7).

### 2.4 Architecture en couches
L'architecture sépare les **trois niveaux** terrain / automation / supervision (article 6.1), de sorte qu'un changement de superviseur n'impose pas le remplacement des équipements de terrain, et inversement.

---

## ARTICLE 3 — DOCUMENTS DE RÉFÉRENCE

Le système est conforme aux textes et normes en vigueur **à la date de remise des offres**. Le titulaire vérifie l'édition applicable. Liste indicative (⚠️ **[À VÉRIFIER]** : éditions et dates à jour — voir §13) :

**Réglementation française**
- **Décret n° 2020-887 du 20 juillet 2020** relatif au système d'automatisation et de contrôle des bâtiments (décret « BACS »), **modifié par le décret n° 2023-259 du 7 avril 2023** (abaissement du seuil à 70 kW).
- **Arrêté du 7 avril 2023** relatif à l'inspection périodique des systèmes d'automatisation et de contrôle.
- **Articles R. 175-1 et suivants du Code de la construction et de l'habitation (CCH)** — fonctions exigées du système (notamment art. R. 175-3).
- **Décret n° 2025-1343 du 26 décembre 2025** (vérifié sur Légifrance, JORFTEXT000053175245) reportant au **1ᵉʳ janvier 2030** l'échéance d'équipement des bâtiments existants dont la puissance CVC est comprise entre **70 et 290 kW** (échéance antérieure : 2027). ⚠️ Vérifier la rédaction en vigueur à la date du marché.
- > 🔀 OPTION (si bâtiment assujetti au dispositif éco-énergie tertiaire) — **Décret n° 2019-771 du 23 juillet 2019** (éco-énergie tertiaire / dispositif « décret tertiaire »), plateforme **OPERAT** (ADEME).

**Normes — performance énergétique de la GTB**
- **NF EN ISO 52120-1:2022** « Performance énergétique des bâtiments — Contribution de l'automatisation, de la régulation et de la gestion technique » (**remplace la NF EN 15232-1:2017**). Définit les classes d'efficacité **A / B / C / D**.

**Normes — protocoles et systèmes**
- **NF EN ISO 16484-2** (matériel des systèmes d'automatisation des bâtiments) et **NF EN ISO 16484-5** (protocole **BACnet**) ; conformité testée selon **ISO 16484-6**.
- **ISO/IEC 14543-3** et **EN 50090** (protocole **KNX**).
- **IEC 62386** (protocole **DALI** / DALI-2).
- **EN 13757** (protocole **M-Bus** filaire et sans fil — comptage).
- **ISO/IEC 14908** (protocole **LON / LonWorks** — compatibilité existant).
- Spécifications **Modbus** publiées par la Modbus Organization (modbus.org).

**Cadre contractuel**
- `[À COMPLÉTER : CCAG applicable]` — ⚠️ **[À VÉRIFIER]** : une GTB relève en principe d'un **marché de travaux (CCAG-Travaux)**. Les clauses de réversibilité de l'article 7 sont inspirées de l'article 38 du **CCAG-TIC** (arrêté du 30 mars 2021) et sont **portées en dur dans le présent CCTP** pour s'appliquer quel que soit le CCAG visé.

---

## ARTICLE 4 — DÉFINITIONS ET ABRÉVIATIONS

| Terme | Définition |
|---|---|
| **GTB / GTC** | Gestion Technique du Bâtiment / Centralisée. |
| **Point de données (data point)** | Variable physique ou logique du système (mesure, consigne, état, commande, alarme). |
| **Table / liste de points** | Inventaire exhaustif et documenté des points de données et de leur adressage. |
| **Passerelle (gateway)** | Équipement traduisant un protocole vers un autre (ex. Modbus → BACnet/IP). |
| **PICS** | *Protocol Implementation Conformance Statement* — fiche de conformité BACnet du fabricant. |
| **BIBBs** | *BACnet Interoperability Building Blocks* — briques d'interopérabilité BACnet. |
| **BTL** | *BACnet Testing Laboratories* — laboratoire et marque de certification de conformité BACnet. |
| **DPT** | *Datapoint Type* — type de point normalisé KNX. |
| **TCO** | *Total Cost of Ownership* — coût global de possession. |
| **DOE** | Dossier des Ouvrages Exécutés. |
| **FDD** | *Fault Detection & Diagnostics* — détection et diagnostic de défauts. |

---

## ARTICLE 5 — EXPRESSION DU BESOIN FONCTIONNEL

### 5.1 Fonctions générales attendues
Le système doit assurer les fonctions suivantes (formulées en exigences) :

- **Acquisition** des mesures et états de l'ensemble des installations techniques du périmètre.
- **Régulation et pilotage** automatiques, avec programmation horaire, calendaire et par zone fonctionnelle.
- **Suivi, enregistrement et analyse en continu** des consommations et productions énergétiques, **par usage et par zone**, à un **pas de temps au moins horaire**.
- **Historisation** des données et **conservation** sur une durée permettant le suivi pluriannuel (voir §5.4 pour l'exigence réglementaire BACS).
- **Comparaison à des valeurs de référence** (benchmarking) et **détection des dérives / pertes d'efficacité** des systèmes techniques, avec information de l'exploitant sur les améliorations possibles.
- **Gestion des alarmes** (hiérarchisées, horodatées, acquittables) et notification.
- **Tableaux de bord** et restitution exploitable (synoptiques, courbes de tendance, rapports).
- **Arrêt manuel et gestion autonome** d'un ou plusieurs systèmes techniques.
- **Accès aux données par le MOA**, qui en est propriétaire, et mise à disposition du gestionnaire.

### 5.2 Fonctions par lot

#### 5.2.1 CVC
`[À COMPLÉTER : installations réelles]` — exigences types :
- Régulation des productions (chaud / froid) et de la distribution (loi d'eau, pompes à débit variable, optimisation départ/arrêt).
- Pilotage des centrales de traitement d'air (CTA) : débits, registres, récupération, free-cooling, qualité d'air (CO₂) si applicable.
- Régulation terminale **par zone** (température, occupation, réduit/relance).
- Délestage / optimisation de la puissance appelée si requis.
- Comptage de l'énergie thermique (voir §5.2.3).

#### 5.2.2 Éclairage (DALI)
- Adressage individuel des luminaires / drivers, gradation, scènes, groupes.
- Détection de **présence** et de **luminosité** (gradation en fonction de l'apport de lumière naturelle — *daylight harvesting*), temporisations.
- Gestion des zones, des horaires et des dérogations locales.
- Remontée des **états et défauts** des luminaires vers la supervision.
- > 🔀 OPTION — gestion de l'**éclairage de sécurité** et/ou **tunable white / couleur** (DALI device types correspondants).

#### 5.2.3 Comptage et sous-comptage énergie
- Comptage général et **sous-comptage par usage** (CVC, éclairage, prises, process le cas échéant) et **par zone / par locataire** si applicable.
- Remontée des index, puissances, et grandeurs électriques / thermiques / fluides.
- Horodatage, historisation, agrégation par usage pour le suivi réglementaire.
- > 🔀 OPTION (décret tertiaire) — distinction des consommations relevant des activités tertiaires et **export vers OPERAT** ; structuration des compteurs/sous-comptages permettant cette distinction.

#### 5.2.4 Supervision / poste central
- Superviseur centralisant l'ensemble des lots, **indépendant des marques des équipements de terrain**.
- IHM ergonomique : synoptiques, navigation par zone, gestion des droits utilisateurs.
- Historisation, courbes de tendance, **export des données aux formats ouverts** (CSV, JSON…) et **API documentée** (voir §6 et §7).
- Gestion centralisée des alarmes, rapports automatiques, tableaux de bord énergétiques.
- > 🔀 OPTION (patrimoine multi-sites) — supervision multi-bâtiments homogène, agrégation de parc, accès distant sécurisé.

### 5.3 Niveau de performance énergétique (NF EN ISO 52120-1:2022)
La GTB doit atteindre **a minima la classe** `[À COMPLÉTER : B (par défaut) ou A]` au sens de la **NF EN ISO 52120-1:2022**, **justifiée fonction par fonction** (CVC, éclairage, ECS, stores…) à l'aide de la grille fonctionnelle de la norme, et non par une simple affirmation globale.

> **Note de rédaction (zéro sur-affirmation)** : la classe globale d'un bâtiment correspond à la **classe la plus faible** atteinte parmi les fonctions installées. Viser « classe B globale » impose donc que **toutes** les fonctions applicables atteignent au moins B.

### 5.4 Conformité réglementaire

> 🔀 OPTION — BÂTIMENT ASSUJETTI AU DÉCRET BACS (à conserver si le bâtiment dépasse les seuils — voir §13) :
>
> Le système constitue un système d'automatisation et de contrôle au sens du **décret BACS** et assure les fonctions de l'**article R. 175-3 du CCH**.
>
> Texte de l'art. R. 175-3 du CCH (source : [Légifrance](https://www.legifrance.gouv.fr/codes/article_lc/LEGIARTI000043819541), version en vigueur depuis le 9 avril 2023) :
>
> > Les systèmes d'automatisation et de contrôle des bâtiments mentionnés à l'article R. 175-2 :
> >
> > 1° « Suivent, enregistrent et analysent en continu, par zone fonctionnelle et à un pas de temps horaire, les données de production et de consommation énergétique des systèmes techniques du bâtiment et ajustent les systèmes techniques en conséquence. Ces données sont conservées à l'échelle mensuelle pendant cinq ans » ;
> > 2° « Situent l'efficacité énergétique du bâtiment par rapport à des valeurs de référence, correspondant aux données d'études énergétiques ou caractéristiques de chacun des systèmes techniques ; ils détectent les pertes d'efficacité des systèmes techniques et informent l'exploitant du bâtiment des possibilités d'amélioration de l'efficacité énergétique » ;
> > 3° « Sont interopérables avec les différents systèmes techniques du bâtiment » ;
> > 4° « Permettent un arrêt manuel et la gestion autonome d'un ou plusieurs systèmes techniques de bâtiment ».
> >
> > Les systèmes techniques considérés sont ceux reliés au système d'automatisation et de contrôle dans les conditions prévues au II de l'article R. 175-2.
> >
> > Les données produites et archivées sont accessibles au propriétaire du système d'automatisation et de contrôle, qui en a la propriété. Ce dernier les met à disposition du gestionnaire du bâtiment, à sa demande, et transmet à chacun des exploitants des différents systèmes techniques reliés les données qui les concernent.
>
> Le système est **inspectable** : il permet la vérification documentaire et fonctionnelle prévue par l'arrêté du 7 avril 2023.
>
> ⚠️ **[À VÉRIFIER]** — Échéances d'équipement selon la puissance nominale utile des systèmes de CVC : **> 290 kW → 1ᵉʳ janvier 2025** ; **70–290 kW → 1ᵉʳ janvier 2030** (report introduit par le décret n° 2025-1343, anciennement 2027). **Confirmer sur Légifrance** la rédaction en vigueur à la date du marché.

> 🔀 OPTION — BÂTIMENT ASSUJETTI AU DÉCRET TERTIAIRE : le système contribue à l'atteinte des objectifs de réduction des consommations (**-40 % en 2030, -50 % en 2040, -60 % en 2050** par rapport à une année de référence pleine ≥ 2010, ou niveau de consommation absolu par usage) et permet le **sous-comptage** et la **déclaration annuelle OPERAT**.

> **Avertissement** : le présent CCTP ne fixe **aucune sanction** au titre du décret BACS — l'existence d'un régime de sanction propre au BACS n'est pas confirmée. Ne pas insérer de montant de pénalité réglementaire sans vérification.

---

## ARTICLE 6 — EXIGENCES D'INTEROPÉRABILITÉ ET DE PROTOCOLES

### 6.1 Architecture en trois niveaux
Le système est organisé selon trois niveaux ; les exigences sont spécifiées par niveau :

| Niveau | Contenu | Protocoles attendus |
|---|---|---|
| **Terrain** | Capteurs, actionneurs, luminaires, compteurs, contrôleurs terminaux | KNX, DALI, M-Bus, Modbus RTU |
| **Automation** | Automates / régulateurs (DDC) des procédés primaires | BACnet, (LON existant) |
| **Supervision** | Superviseur, serveur, IHM, tableaux de bord | **BACnet/IP** (ou BACnet/SC), OPC UA, Modbus TCP |

Le **backbone d'intégration et de supervision** est constitué d'un protocole ouvert standard de niveau supervision (**BACnet/IP** par défaut) ; les bus de terrain spécialisés (DALI, KNX, M-Bus, Modbus) remontent via des **passerelles documentées** (§6.4).

### 6.2 Exigences par protocole
Le candidat précise pour **chaque équipement** le ou les protocoles supportés et fournit les preuves de conformité demandées.

#### 6.2.1 BACnet (supervision / automation)
- Conformité à **ISO 16484-5** [préciser l'édition retenue : `[À COMPLÉTER]`].
- **Profil d'appareil par rôle** (Annexe L) : automate de tête **B-BC**, contrôleur terminal **B-ASC/B-AAC**, poste de supervision **B-OWS/B-AWS** (ou équivalent).
- **Liste de BIBBs minimaux** par domaine : partage de données (DS), alarmes & événements (AE), programmation horaire (SCHED), historisation (T), gestion d'équipement (DM), gestion réseau (NM).
- **Certification BTL** : équipements **BTL Listed** ; le titulaire **fournit la PICS** de chaque équipement BACnet pour vérification.
- Transports : **BACnet/IP** et/ou **BACnet MS/TP** (RS-485). 
- > 🔀 OPTION CYBERSÉCURITÉ — exiger **BACnet/SC (Secure Connect)** (WebSocket + TLS) sur le backbone IP.

#### 6.2.2 KNX (terrain — éclairage, CVC terminal, stores)
- Produits **« certifiés KNX »** (marque KNX, test en laboratoire tiers accrédité), conformes **ISO/IEC 14543-3** et **EN 50090**.
- Paramétrables via **ETS** ; fichiers produit (`.knxprod`) et projet **ETS** remis au MOA.
- Usage des **Datapoint Types (DPT) normalisés** ; médium(s) précisé(s) : `[À COMPLÉTER : TP / IP / RF]`.

#### 6.2.3 Modbus (terrain et TCP supervision)
- Conformité aux spécifications **Modbus Organization** (Modbus RTU série RS-485 et/ou **Modbus TCP**, port 502).
- ⚠️ **Modbus ne définit aucun modèle d'objet normalisé.** En conséquence, **livrable obligatoire** : pour chaque équipement Modbus, une **table de cartographie complète et documentée** des registres (adresse, type de table, type de donnée, *endianness*, facteur d'échelle, unité, plage, droit d'accès R/RW). Une offre sans engagement de fourniture de ces tables est réputée non conforme.

#### 6.2.4 DALI (terrain — éclairage)
- Composants **certifiés DALI-2** (et **D4i** pour luminaires intelligents / drivers communicants), conformes **IEC 62386** (parties 101/102/103 et 2xx selon besoin), **présents dans la base produits de la DALI Alliance**.
- Le candidat fournit les **références de certification** ; exiger « certified » (et non seulement « registered » DALI v1) pour garantir l'interopérabilité vérifiée.

#### 6.2.5 M-Bus / wireless M-Bus (terrain — comptage)
- Compteurs conformes à **EN 13757** (filaire -2/-3 et/ou sans fil -4) ; **certification OMS** privilégiée.
- **Livrable** : documentation des télégrammes / registres (codes DIF/VIF ou identifiants **OBIS**, unités, échelles, adressage). Pour le sans-fil : bande (868 MHz) et mode précisés.

#### 6.2.6 LON / LonWorks (compatibilité existant)
- Le cas échéant, **compatibilité avec l'existant LON** (remontée via passerelle LON ↔ BACnet/IP), conforme **ISO/IEC 14908** et certifié **LonMark**. **Non prioritaire** en prescription neuve.

### 6.3 Synthèse des exigences par protocole

| Protocole | Niveau | Norme | Modèle objet normalisé ? | Preuve d'interopérabilité exigée |
|---|---|---|---|---|
| **BACnet** | Automation / Supervision | ISO 16484-5 | Oui | Profil Annexe L + BIBBs + **BTL Listing** + **PICS** |
| **KNX** | Terrain | ISO/IEC 14543-3 + EN 50090 | Oui (DPT) | **Certifié KNX** + projet ETS remis |
| **Modbus** | Terrain / TCP | Spéc. modbus.org | **Non** | **Table de registres documentée (obligatoire)** |
| **DALI** | Terrain (éclairage) | IEC 62386 | Oui | **Certifié DALI-2 / D4i** + base DALI Alliance |
| **M-Bus** | Terrain (comptage) | EN 13757 | Partiel (DIF/VIF, OBIS) | **Certifié OMS** + télégrammes documentés |
| **LON** | Terrain / Automation (legacy) | ISO/IEC 14908 | Oui (SNVT) | **LonMark** (compatibilité existant) |

### 6.4 Passerelles
Toute passerelle entre protocoles est **standardisée et documentée**. Le titulaire fournit le **mapping complet des points traduits**, la documentation de configuration et les paramètres de la passerelle, dans un format réutilisable par un tiers.

### 6.5 Cybersécurité
`[À COMPLÉTER selon politique du MOA]` — au minimum : segmentation réseau OT/IT, comptes nominatifs, gestion des droits, mises à jour de sécurité, journalisation. Privilégier **BACnet/SC** sur le backbone IP. Le système ne doit pas exposer de service propriétaire non maîtrisé par le MOA.

---

## ARTICLE 7 — EXIGENCES ANTI-VERROUILLAGE (clauses contractuelles)

> Ces clauses sont contractuelles et **opposables** dès lors qu'elles figurent au marché. Sauf l'article 2.1 (reprise du Code de la commande publique pour les acheteurs publics), ce sont des **exigences contractuelles** que le MOA impose explicitement.

### 7.1 Propriété des données, de la configuration et de la programmation
1. **Le MOA est, sans réserve ni coût supplémentaire, propriétaire de l'intégralité des données** produites, collectées, historisées ou calculées par la GTB (temps réel, historiques, alarmes, courbes de tendance, métadonnées), ainsi que de **la configuration, du paramétrage et de la programmation** réalisés au titre du marché.
2. Le titulaire **cède au MOA, à titre exclusif et définitif**, les droits patrimoniaux nécessaires à l'utilisation, la modification, la maintenance et l'évolution de la programmation et des configurations spécifiques développées pour le projet, **y compris par un tiers** de son choix.
3. Aucune donnée du bâtiment ne peut être hébergée, traitée ou exploitée par le titulaire ou un tiers **sans que le MOA en conserve un accès complet et un droit d'export permanent** aux formats ouverts.

### 7.2 Remise complète / dossier de réversibilité
À la réception, **et à chaque évolution ultérieure**, le titulaire remet au MOA un **dossier de réversibilité complet** comprenant au minimum :
- a. les **codes sources de la programmation** des automates et régulateurs, sous forme **éditable et recompilable** ;
- b. l'ensemble des **fichiers de configuration et de paramétrage** du superviseur, des automates et des passerelles ;
- c. les **licences logicielles** (superviseur, outils, runtime), **pérennes et nominatives au MOA** ;
- d. **l'ensemble des mots de passe et comptes administrateur de plus haut niveau** (superviseur, automates, passerelles, équipements réseau), avec les droits permettant la **modification complète** du système ;
- e. la **documentation technique et fonctionnelle**, les scripts d'exploitation et les supports de formation ;
- f. la **liste / table exhaustive des points de données**, le **plan d'adressage**, les **schémas d'architecture** et les **synoptiques**.

Ces éléments sont fournis dans des **formats documentés et exploitables en dehors des outils propres au titulaire**, avec les interfaces techniques (API, format pivot) permettant l'accès aux données selon un schéma documenté.

### 7.3 Licences
- Toutes les licences sont **pérennes, transférables au MOA et exemptes de tout coût récurrent caché** (abonnement, redevance par point, réactivation). Toute licence à durée limitée, liée au matériel du titulaire, ou révocable unilatéralement, est **interdite**.
- Le **nombre de points de données n'est pas limité par licence** au-delà du besoin du projet ; à défaut, le **coût d'extension par point est figé et annexé** au marché.

### 7.4 Outils d'ingénierie
Les **outils de configuration et de programmation** (logiciels d'ingénierie des automates et du superviseur) sont soit **librement disponibles**, soit **remis au MOA** avec les licences correspondantes, permettant à tout intervenant qualifié de reconfigurer le système.

### 7.5 Maintenabilité par un tiers
Le MOA pourra **confier la reprise de la maintenance et des évolutions à tout tiers de son choix** ; le titulaire ne pourra opposer **aucune restriction technique, contractuelle ou de propriété intellectuelle** à cette reprise.

### 7.6 Accès ouvert aux données
Le superviseur expose une **API documentée et ouverte** et permet l'**export des données aux formats ouverts** (CSV, JSON, et formats d'échange standard), **sans dépendance à un service propriétaire** du titulaire.

---

## ARTICLE 8 — LIVRABLES ET DOCUMENTS À REMETTRE

### 8.1 En phase études / exécution
- Note d'architecture (3 niveaux, protocoles, passerelles).
- Tableau de conformité renseigné (Annexe A).
- Listes de points prévisionnelles, plans d'adressage, synoptiques.
- PICS BACnet, certificats KNX / DALI-2 / OMS / BTL des équipements.

### 8.2 À la réception (DOE)
- Dossier de réversibilité complet (article 7.2) : sources, configurations, licences, mots de passe, documentation, table de points.
- Tables de cartographie Modbus et télégrammes M-Bus documentés (articles 6.2.3 et 6.2.5).
- Justification de la classe NF EN ISO 52120-1 atteinte, fonction par fonction.
- Procès-verbaux d'essais (article 9).

### 8.3 Formation
`[À COMPLÉTER : nombre de jours, public, supports]` — formation à l'exploitation, à la supervision et à la reconfiguration de base, supports remis et réutilisables.

---

## ARTICLE 9 — RECETTE ET VÉRIFICATIONS

### 9.1 Essais fonctionnels
Vérification du fonctionnement de chaque fonction de l'article 5, par lot et par zone, selon un protocole d'essais `[À COMPLÉTER / à annexer]`.

### 9.2 Vérification de l'ouverture — condition de réception
La conformité aux exigences d'ouverture constitue une **condition de la réception**. Sont vérifiés :
- la **remise effective** des sources, configurations, licences pérennes et **mots de passe administrateur** ;
- la **table de points** complète et exploitable, les **mappings Modbus / M-Bus** documentés ;
- la disponibilité de l'**API** et de l'**export aux formats ouverts** ;
- les **certifications** (BTL/PICS, KNX, DALI-2, OMS) des équipements.

À défaut, la réception est **prononcée avec réserves bloquant le solde**.

### 9.3 Vérification de la classe NF EN ISO 52120-1
Contrôle de l'atteinte de la classe cible (§5.3), justifiée fonction par fonction via la grille de la norme.

---

## ARTICLE 10 — GARANTIE, MAINTENANCE, SAV
`[À COMPLÉTER]` — durée de garantie, GTI/GTR contractuelles, télémaintenance (dans le respect de l'article 7 : aucun accès distant ne prive le MOA de la maîtrise de son système), conditions de maintenance ouvertes à un tiers.

---

## ARTICLE 11 — CRITÈRES D'ÉVALUATION DES OFFRES
Les offres sont évaluées selon les critères objectifs et la grille de dépouillement détaillés dans le document **« Grille de dépouillement GTB »** (fichier `grille-depouillement-GTB.md`), qui fait partie intégrante de la consultation.

> 🔀 OPTION MARCHÉ PUBLIC — Rappel : les critères sont **pondérés (ou hiérarchisés) et publiés** conformément aux **articles R. 2152-11 et R. 2152-12 du Code de la commande publique** ; les valeurs de pondération relèvent du choix du MOA.

---

## ARTICLE 12 — ANNEXES (cadres à remplir par le candidat)

### Annexe A — Tableau de conformité (extrait, à compléter)
| § CCTP | Exigence | Conforme (C) / Partiel (PC) / Non conforme (NC) | Renvoi pièce justificative |
|---|---|---|---|
| 6.2.1 | BACnet — profil + BIBBs + BTL + PICS | | |
| 6.2.3 | Modbus — table de registres documentée | | |
| 6.2.4 | DALI-2 / D4i certifiés | | |
| 7.2 | Dossier de réversibilité complet | | |
| 5.3 | Classe NF EN ISO 52120-1 atteinte | | |
| … | … | | |

### Annexe B — Modèle de liste de points
| Repère | Désignation | Lot | Type (AI/AO/BI/BO/AV…) | Protocole | Adresse | Unité | Plage | Accès |
|---|---|---|---|---|---|---|---|---|

### Annexe C — Cadre de décomposition du coût global de possession (TCO)
| Poste | Détail | Montant |
|---|---|---|
| Investissement (CAPEX matériel + intégration + mise en service) | | |
| Maintenance annuelle × durée de référence `[À COMPLÉTER : 8–10 ans]` | | |
| Licences / abonnements supervision et runtime × durée | | |
| Énergie (gain estimé selon classe 52120-1, base de calcul imposée) | | |
| Réversibilité (coût estimé de reprise par un tiers) | | |
| **TCO total** | | |

---

## ARTICLE 13 — POINTS À VÉRIFIER AVANT DIFFUSION

> Liste de contrôle « zéro invention » à traiter par le rédacteur **avant** d'envoyer ce CCTP en consultation. Chaque point a été signalé par la recherche documentaire comme nécessitant une **confirmation sur source primaire**.

1. **Échéances décret BACS** (palier 70–290 kW : 2027 → **2030** via décret n° 2025-1343 du 26/12/2025) : confirmer la rédaction en vigueur sur **Légifrance**.
2. **Article R. 175-3 du CCH** : recopier la liste exacte des fonctions depuis Légifrance (l'extrait du §5.4 est une restitution fidèle, non garantie au mot près).
3. **« Classe B » n'est pas écrite littéralement dans le décret BACS** : le décret impose des **fonctions** ; la classe A/B provient du tableau fonctionnel et du dispositif CEE (fiche BAT-TH-116). Ne pas écrire « le décret impose la classe B » sans nuance.
4. **NF EN ISO 52120-1:2022** : acquérir le texte AFNOR pour un CCTP opposable (classes vérifiées via sources secondaires concordantes).
5. **Éditions de normes** à figer : ISO 16484-5 (édition), liste exacte des profils BACnet Annexe L (varie selon l'édition), désignation d'annexe BACnet/SC.
6. **Modbus** : libellés exacts du programme de conformité Modbus à valider sur modbus.org.
7. **CCAG applicable** : trancher Travaux vs TIC ; si Travaux, porter les clauses de réversibilité (article 7) en **dérogations explicites au CCAP**.
8. **Décret tertiaire / OPERAT** : ne conserver le bloc que si le bâtiment est réellement assujetti.
9. **Sanctions BACS** : ne **pas** insérer de montant — régime de sanction propre non confirmé.

---

*Modèle CCTP GTB multi-protocole vendor-neutral — NeoGTB. Sources réglementaires et normatives vérifiées sur Légifrance, ISO/IEC, AFNOR et organismes de certification (BACnet International/BTL, KNX Association, DALI Alliance, OMS-Group). Les dates et numéros de textes doivent être reconfirmés à la date de diffusion (article 13).*
