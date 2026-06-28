# B1 — MÉTHODOLOGIE D'AUDIT DE CLASSIFICATION & DE CONFORMITÉ
## Audit & AMO « classification GTB » — pièce méthodologique (tiers de confiance, 0 matériel vendu)

> **Nature du document** : méthodologie d'audit réutilisable, pièce **B1** du dossier d'offre « Audit & AMO classification GTB » de NeoGTB.
> Elle décrit **comment** NeoGTB conduit un audit de classification (NF EN ISO 52120-1:2022) **et** de conformité (décret BACS), en **posture d'indépendance** : aucun matériel vendu, aucune commission fabricant.
> Le **livrable** produit par cette méthodologie suit la trame de la pièce **B2** → [`docs/exemple-audit-conformite-bacs.md`](../exemple-audit-conformite-bacs.md). La grille de classement fonctionnel détaillée est la pièce **B3** → [`B3_grille-fonctions-52120.md`](./B3_grille-fonctions-52120.md). La clause de responsabilité / périmètre est la pièce **B4** → [`B4_clause-responsabilite-perimetre.md`](./B4_clause-responsabilite-perimetre.md).

---

## LÉGENDE DES STATUTS

| Marqueur | Sens |
|---|---|
| **[OBLIGATION]** | Exigence **réglementaire** opposable (décret / arrêté / code), à reconfirmer sur source primaire (Légifrance) à la date d'usage. |
| **[RECOMMANDATION]** | Bonne pratique conseillée par NeoGTB, **non obligatoire** ; relève du choix du maître d'ouvrage. |
| **[CONVENTION eu.bac]** | Élément relevant du référentiel **eu.bac System** (certification **tierce, payante, distincte** de l'auto-évaluation normative). **Non utilisable** comme s'il s'agissait d'une obligation ; cité pour information / délimitation de périmètre. |
| **[INFORMATIF]** | Explication, aide à la lecture, sans portée contraignante. |

> ⚠️ **Avertissement transversal à conserver dans tout livrable issu de cette méthode :**
> 1. **Classe ≠ conformité réglementaire.** La conformité au décret BACS se juge sur les **fonctions** de l'art. R. 175-3 CCH, **jamais** sur la seule classe NF EN ISO 52120-1. **[OBLIGATION]**
> 2. **Classe ≠ vendor-neutral.** Un système **fermé / propriétaire** peut très bien être **classe A**. La classe mesure le niveau **fonctionnel**, pas l'ouverture ni l'interopérabilité. **[INFORMATIF]**
> 3. **Un % de gain n'est jamais un engagement de résultat.** Les facteurs d'efficacité de la norme sont en **Annexes A/C *informatives*** ; seule l'**Annexe B (exigences minimales de fonctions) est *normative***. **[INFORMATIF]**
> 4. **Une auto-évaluation selon la norme n'est PAS une certification eu.bac System.** Ne jamais présenter un audit NeoGTB comme une « certification eu.bac ». **[CONVENTION eu.bac]**

---

## VUE D'ENSEMBLE DE LA MÉTHODE (6 étapes)

```
ÉTAPE 1  Test d'assujettissement ......... suis-je dans le périmètre réglementaire ?
ÉTAPE 2  Conformité aux FONCTIONS ........ les fonctions R. 175-3 sont-elles présentes ? (≠ classe)
ÉTAPE 3  Classification NF EN ISO 52120-1  quel niveau fonctionnel (A/B/C/D) ? quelle méthode ?
ÉTAPE 4  Cotation à 3 états d'effectivité  chaque fonction : absente / installée / prouvée
ÉTAPE 5  Niveau d'intrusion ............. coût/dérangement pour faire monter chaque fonction d'un cran
ÉTAPE 6  Chiffrage des gains EN FOURCHETTE  jamais une valeur sèche, toujours hypothèses tracées
```

> **[INFORMATIF]** Les étapes 1 et 2 répondent à une question **réglementaire** (binaire : conforme / non conforme aux fonctions). Les étapes 3 à 6 répondent à une question **de performance fonctionnelle** (graduée : classe, effectivité, gain). **Ne jamais fusionner les deux logiques** : c'est la source d'erreur la plus fréquente dans les audits GTB du marché.

---

## ÉTAPE 1 — TEST D'ASSUJETTISSEMENT

**Objet** : déterminer si le bâtiment entre dans un périmètre réglementaire, et à quelle échéance.

### 1.1 Décret BACS **[OBLIGATION]**

| Question | Donnée à collecter | Réf. |
|---|---|---|
| Bâtiment à usage **tertiaire** ? | Usage réel / déclaré | Art. R. 175-1 CCH |
| Équipé de **chauffage et/ou climatisation** (± ventilation) ? | Inventaire des systèmes techniques | Art. R. 175-1 CCH |
| **Puissance nominale utile cumulée** des systèmes concernés | Plaques signalétiques, CCTP installation, fiches techniques | Art. R. 175-1 CCH |
| Seuil franchi ? | **> 290 kW** → échéance **1ᵉʳ janv. 2025** · **70–290 kW** → échéance **1ᵉʳ janv. 2030** (report décret 2025-1343) | cf. pièce B2 §3 |

> **[OBLIGATION]** Les seuils (70 / 290 kW), les échéances et les cas d'exemption sont **détaillés et sourcés dans la pièce B2** ([`docs/exemple-audit-conformite-bacs.md`](../exemple-audit-conformite-bacs.md), §3, §4 et §10). **Ne pas les paraphraser ici** : s'y référer et **reconfirmer sur Légifrance** à la date de l'audit.
> `[À COMPLÉTER : puissance nominale utile cumulée constatée = ___ kW]` · `[À COMPLÉTER : échéance applicable = ___]`

### 1.2 Décret tertiaire (dispositif Éco Énergie Tertiaire) — **si applicable** 🔀 OPTION

🔀 **OPTION — activer uniquement si le bâtiment relève aussi du décret tertiaire**
**[OBLIGATION si applicable]** Vérifier l'assujettissement au **dispositif Éco Énergie Tertiaire** (surfaces ≥ 1 000 m² à usage tertiaire), qui est **distinct** du décret BACS (obligation de **réduction de consommation**, déclaration **OPERAT**), mais **complémentaire** : la GTB est un levier majeur d'atteinte des objectifs.
`[À COMPLÉTER : surface tertiaire cumulée = ___ m² → assujetti EET : oui / non]`
> **[INFORMATIF]** Ne pas confondre les deux décrets : BACS = obligation de **moyens/fonctions** sur la GTB ; tertiaire = obligation de **résultat** sur la consommation. Un bâtiment peut relever de l'un, de l'autre, des deux ou d'aucun.

### 1.3 Livrable d'étape

→ **Note d'assujettissement** : assujetti BACS (oui/non) + échéance · assujetti EET (oui/non). Reprise dans la section « Étape 1 » du livrable B2.

---

## ÉTAPE 2 — ÉVALUATION DE CONFORMITÉ AUX **FONCTIONS** R. 175-3 (≠ classe)

**Objet** : vérifier la **présence et l'effectivité** des fonctions imposées par l'art. R. 175-3 CCH — **pas** d'atteindre une classe ISO.

> **[OBLIGATION]** **La conformité au décret se juge fonction par fonction.** « Atteindre une classe A ou B » **n'est pas** une fonction de R. 175-3 et ne peut donc **jamais** figurer comme critère de conformité. La grille des fonctions R. 175-3 confrontées à l'existant est **déjà cadrée dans la pièce B2 (§6)** : la reprendre, l'actualiser sur la rédaction littérale de Légifrance, **ne pas l'inventer**.

| Famille de fonction (art. R. 175-3 — synthèse B2 §6) | À évaluer | Conforme ? |
|---|---|---|
| Suivre / enregistrer / **analyser en continu** les données par usage et par zone | `[À COMPLÉTER]` | ☐ oui ☐ non ☐ partiel |
| **Conserver** les données (5 ans, cf. B2) | `[À COMPLÉTER]` | ☐ oui ☐ non ☐ partiel |
| **Situer l'efficacité** et **déceler les pertes** d'efficacité | `[À COMPLÉTER]` | ☐ oui ☐ non ☐ partiel |
| **Arrêt manuel** + **gestion autonome** des systèmes | `[À COMPLÉTER]` | ☐ oui ☐ non ☐ partiel |
| **Interopérabilité** entre systèmes techniques | `[À COMPLÉTER]` | ☐ oui ☐ non ☐ partiel |
| **Alerter** en cas de dérive / dysfonctionnement | `[À COMPLÉTER]` | ☐ oui ☐ non ☐ partiel |

> **[OBLIGATION]** La rédaction **littérale exacte** des fonctions R. 175-3 doit être **recopiée depuis Légifrance**, pas paraphrasée (cf. avertissement B2 §9).

### 2.1 Articulation avec l'inspection périodique **[OBLIGATION]**

Si le bâtiment est déjà équipé, la conformité ne s'évalue pas seulement « sur plan » : l'**art. R. 175-5-1** impose la vérification du **fonctionnement réel** et du **paramétrage vs usage**. → C'est exactement ce que mesure la **cotation à 3 états** (Étape 4). Voir pièce B2 §8.

### 2.2 Livrable d'étape

→ **Avis de conformité aux fonctions** : conforme / non conforme, **motivé par fonction** (jamais « non conforme car classe C »).

---

## ÉTAPE 3 — CLASSIFICATION NF EN ISO 52120-1:2022

**Objet** : situer le niveau **fonctionnel** de la GTB sur l'échelle **A / B / C / D** de la norme.

> **[INFORMATIF]** **NF EN ISO 52120-1:2022 remplace EN 15232-1:2017.** Elle propose **deux méthodes**, à la **numérotation officielle** :
> - **Clause 6 — « Method 1 – Detailed method »** (méthode détaillée).
> - **Clause 7 — « Method 2 – Factor based method »** (méthode des facteurs).
>
> Les **facteurs d'efficacité** figurent en **Annexes A / C — *INFORMATIVES*** (donc **non opposables**, un % n'est jamais un engagement). Seule l'**Annexe B — *NORMATIVE*** fixe les **exigences minimales de fonctions** par classe. **4 classes : A (la plus performante) / B / C / D.**

### 3.1 Règle d'arbitrage entre Method 1 et Method 2 — **[RECOMMANDATION] (à écrire dans chaque rapport)**

| Situation rencontrée | Méthode à retenir | Justification |
|---|---|---|
| Estimation **amont**, dégrossissage, chiffrage indicatif, parc homogène | **Method 2 — Factor based (Clause 7)** | Rapide ; suffisante pour un ordre de grandeur **en fourchette**. |
| Bâtiment **déjà performant** (facteurs peu discriminants en haut d'échelle) | **Method 1 — Detailed (Clause 6)** / simulation | Les facteurs perdent en finesse quand la marge de gain est faible. |
| Bâtiment **multi-typologie** (usages mélangés, plusieurs profils d'occupation) | **Method 1 — Detailed (Clause 6)** | La méthode des facteurs suppose **un** type de bâtiment déclaré. |
| **Fort taux de vitrage** / forte sensibilité aux apports solaires & stores | **Method 1 — Detailed (Clause 6)** / simulation | Effets dynamiques mal capturés par un facteur forfaitaire. |
| **Un engagement chiffré** est demandé (CEE, business case opposable…) | **Method 1 — Detailed (Clause 6)** / simulation | Un facteur informatif **ne peut pas** fonder un engagement. **[OBLIGATION de prudence]** |

> **[RECOMMANDATION]** **Par défaut** : facteurs (Method 2) en phase amont, **bascule** en méthode détaillée (Method 1) / simulation **dès** qu'une des conditions de la 2ᵉ colonne est réunie. **Tracer le choix et son motif dans le rapport.**
> `[À COMPLÉTER : méthode retenue = Method 1 / Method 2 — motif : ___]`

### 3.2 Déclaration du type de bâtiment **[OBLIGATION méthodologique]**

Method 2 suppose **un seul type de bâtiment déclaré** = celui correspondant à l'**usage énergétique majoritaire**.
`[À COMPLÉTER : type de bâtiment déclaré = ___ (usage énergétique majoritaire)]`
> **[INFORMATIF]** Si plusieurs usages cohabitent à parts comparables → c'est un signal de **bascule vers Method 1** (cf. ligne « multi-typologie » du tableau 3.1).

### 3.3 Pondération par zones **[RECOMMANDATION]**

Pondération d'une zone = **surface × temps de fonctionnement × poids de l'équipement**.
> ⚠️ **[INFORMATIF] Limite à signaler explicitement dans le rapport** : cette pondération est **fonctionnelle**, elle **n'est pas une pondération par l'énergie réellement consommée**. Une zone peu énergivore mais très étendue peut peser plus que sa réalité énergétique. **Le rapport doit mentionner cette limite** pour éviter toute sur-interprétation du résultat.
> `[À COMPLÉTER : tableau des zones — surface / temps de fonctionnement / poids équipement → pondération]`

### 3.4 Règle du **maillon faible** **[OBLIGATION normative — Annexe B]**

La **classe globale = la classe la plus faible** parmi les fonctions effectivement installées.
> **[INFORMATIF]** Conséquence directe : une seule fonction restée en classe D **tire toute l'installation en classe D**, quelles que soient les autres. La priorisation (Étape 5) doit donc viser **en premier** le maillon faible.

### 3.5 Exclusions **[OBLIGATION méthodologique : tracer + justifier]**

Une fonction peut être exclue du périmètre pertinent dans deux cas :
- **équipement absent** du bâtiment (ex. pas de stores motorisés, pas d'ECS) ;
- **part < 5 %** du périmètre (poids négligeable).

> ⚠️ **Règle stricte** :
> 1. **Toute exclusion est tracée et justifiée** (motif + preuve) dans le rapport. **[OBLIGATION méthodologique]**
> 2. Une exclusion **réduit le périmètre pertinent** ; elle **ne « rachète » jamais un maillon faible**. On ne peut pas exclure une fonction faible *pour* remonter la classe globale. **[OBLIGATION méthodologique]**
> `[À COMPLÉTER : liste des exclusions — fonction / motif (absent / <5 %) / preuve]`

### 3.6 Les 7 sections de fonctions

La classification s'évalue section par section : **(1) chauffage · (2) eau chaude sanitaire (ECS) · (3) refroidissement · (4) ventilation / climatisation · (5) éclairage · (6) stores · (7) GTB / gestion technique du bâtiment (TBM)**. → détail dans la pièce **B3** ([`B3_grille-fonctions-52120.md`](./B3_grille-fonctions-52120.md)).

### 3.7 Livrable d'étape

→ **Classe par fonction + classe globale** (maillon faible), méthode utilisée tracée, exclusions justifiées, **rappel que classe ≠ conformité et que cette évaluation n'est PAS une certification eu.bac**.

> **[CONVENTION eu.bac]** Le **barème de points propre à eu.bac System n'est pas confirmé** : **ne pas le citer comme certain**, ne pas l'utiliser pour scorer. L'audit NeoGTB reste une **auto-évaluation argumentée selon la norme**.

---

## ÉTAPE 4 — COTATION À **3 ÉTATS D'EFFECTIVITÉ** (par fonction)

**Objet** : ne créditer une fonction que si elle est **réellement effective**, en cohérence avec l'inspection R. 175-5-1.

Pour **chaque** fonction des 7 sections :

| État | Définition | Crédité ? |
|---|---|---|
| **Absente** | La fonction n'existe pas dans l'installation. | ❌ non crédité |
| **Installée — non prouvée** | La fonction semble présente (matériel/logiciel) mais **rien ne prouve qu'elle fonctionne et est paramétrée**. | ❌ non crédité (réserve) |
| **Installée — prouvée par la donnée** | La fonction est démontrée par une **preuve** : courbe de tendance (*trend*), **test de forçage**, **remontée d'alarme** observée, capture du paramétrage. | ✅ crédité |

> **[OBLIGATION méthodologique]** **Seul l'état « prouvée » est crédité** dans la classe. Une fonction « installée mais non prouvée » est **traitée comme une réserve**, pas comme un acquis. C'est la traduction directe de l'**art. R. 175-5-1** (vérification du **fonctionnement réel** et du **paramétrage vs usage**).
> **[INFORMATIF]** Exemples de preuves recevables : export de *trend* sur période représentative ; PV de **test de forçage** d'un actionneur ; **alarme** déclenchée et remontée jusqu'à l'exploitant ; copie d'écran horodatée du paramétrage de consigne/plage horaire.

→ Colonne « État d'effectivité » + colonne « Preuve » de la grille **B3**.

---

## ÉTAPE 5 — NIVEAU D'INTRUSION (par fonction manquante)

**Objet** : qualifier, pour chaque fonction à faire monter d'un cran, **l'ampleur des travaux** (coût + dérangement en site occupé). C'est ce qui rend la priorisation **réaliste**.

| Niveau d'intrusion | Description | Ordre de grandeur d'impact |
|---|---|---|
| **1 — Paramétrage logiciel seul** | Réglage / activation dans le superviseur existant, sans intervention physique. | Faible coût, **aucun** dérangement. |
| **2 — Ajout terrain léger** | Pose de capteurs/actionneurs ponctuels sur infrastructure existante. | Coût modéré, dérangement limité. |
| **3 — Passage de câbles en site occupé** | Tirage de câbles, percements, cheminements dans des locaux occupés. | Coût élevé, **dérangement notable** (planning, nuisances). |
| **4 — Remplacement d'équipement** | Dépose/repose d'équipement (automate, régulateur, CTA…). | Coût fort, arrêt d'exploitation possible. |

> **[RECOMMANDATION]** Croiser **niveau d'intrusion** (Étape 5) × **maillon faible** (3.4) pour prioriser : viser d'abord les fonctions **à fort effet sur la classe** et **à faible intrusion** (quick wins de niveau 1–2), puis arbitrer les niveaux 3–4 selon le ROI.
> `[À COMPLÉTER : par fonction manquante → niveau d'intrusion 1/2/3/4]`

→ Colonne « Niveau d'intrusion pour monter d'un cran » de la grille **B3**.

---

## ÉTAPE 6 — CHIFFRAGE DES GAINS **EN FOURCHETTE**

**Objet** : estimer le bénéfice attendu **sans jamais donner de valeur sèche**.

> **[OBLIGATION de prudence]** Tout gain est exprimé **en fourchette** (ex. « entre X et Y % », « de A à B € / an »), **assorti de ses hypothèses**. Un chiffre unique laisse croire à un engagement de résultat — **interdit** : les facteurs de la norme sont **informatifs** (Annexes A/C). cf. clause B4 « garantie d'économies ».

Pour chaque action chiffrée, documenter au minimum :

| Élément à tracer | Contenu |
|---|---|
| **Fourchette de gain** | `[À COMPLÉTER : entre ___ et ___ ]` (énergie, € ou point de classe) |
| **Hypothèses** | méthode (Method 1/2), type de bâtiment déclaré, périmètre, prix de l'énergie retenu, profil d'occupation… `[À COMPLÉTER]` |
| **Source du facteur** | renvoi explicite à l'**Annexe informative** mobilisée + rappel « informatif, non opposable ». |
| **Sensibilité** | ce qui ferait sortir le résultat de la fourchette (occupation, météo, prix énergie). |

> **[INFORMATIF]** Quand un **engagement chiffré** est demandé → la fourchette issue des facteurs **ne suffit pas** : basculer en **Method 1 / simulation** (cf. 3.1) **et** rappeler la clause de non-garantie (pièce **B4**).

→ Section « Plan de mise en conformité » / chiffrage du livrable **B2** (§7), exprimée en fourchettes.

---

## SYNTHÈSE — CE QUE LA MÉTHODE GARANTIT (ET CE QU'ELLE NE GARANTIT PAS)

| ✅ La méthode produit | ❌ La méthode **ne** produit **pas** |
|---|---|
| Un **avis de conformité aux fonctions** R. 175-3, motivé fonction par fonction. | Une **attestation de conformité réglementaire** (cf. clause B4). |
| Une **classe** A/B/C/D **par fonction + globale** (maillon faible), méthode tracée. | Une **certification eu.bac System** (tierce, payante, distincte). |
| Une **cotation d'effectivité** à 3 états, preuves à l'appui. | Une **garantie d'économies** (rating relatif, pas absolu — cf. B4). |
| Une **priorisation** intrusion × maillon faible et un **chiffrage en fourchette**. | Un **chiffre de gain sec** opposable. |
| Une posture **indépendante** (0 matériel, 0 commission). | Une préconisation de **marque/fabricant**. |

> **Rappels à imprimer en pied de chaque livrable :** classe **≠** conformité réglementaire · classe **≠** vendor-neutral (un système fermé peut être classe A) · un % de gain **n'est jamais** un engagement de résultat · cette auto-évaluation **n'est pas** une certification eu.bac.

---

*Pièce B1 du dossier « Audit & AMO classification GTB » — NeoGTB. Les exigences normatives de classe par fonction sont laissées en* **[À COMPLÉTER avec NF EN ISO 52120-1:2022 — Annexe B normative, Phase 2]** *dans la pièce B3.*
