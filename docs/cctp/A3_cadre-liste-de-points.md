# A3 — CADRE DE LISTE DE POINTS (DATA POINTS)
## Consultation GTB multi-protocole vendor-neutral — pièce pré-remplie par lot

> **Pièce de consultation complémentaire** au CCTP `CCTP-GTB-multiprotocole-vendor-neutral.md` (développe l'**Annexe B — Modèle de liste de points**). Modèle réutilisable, à adapter au projet.
>
> **À quoi sert cette pièce** : la liste de points (ou *table de points*) est l'**inventaire exhaustif et documenté des points de données** du bâtiment et de leur adressage. C'est la pièce qui **fait gagner ou perdre un projet GTB** : un périmètre de points flou rend les offres incomparables, masque les oublis fonctionnels et ouvre la porte aux avenants. Un cadre pré-rempli fixe le **niveau d'ambition fonctionnelle** dès la consultation.

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
- Les lignes ci-dessous sont des **EXEMPLES À ADAPTER** : elles illustrent un niveau de détail attendu, **elles ne décrivent pas une installation réelle**. Chaque ligne marquée *« exemple à adapter »* doit être confirmée, modifiée ou supprimée selon les équipements réellement prévus.
- **Les types (AI/AO/BI/BO/AV…), protocoles, adresses, unités et plages dépendent des équipements réels** retenus et de leur documentation constructeur. Tant que les équipements ne sont pas figés, ces colonnes restent indicatives.
- **[CLAUSE CONTRACTUELLE]** La **liste de points définitive, exhaustive et adressée** est un **livrable du titulaire** : elle est établie, complétée et tenue à jour par lui, remise à la réception **et à chaque évolution ultérieure**, dans le **dossier de réversibilité** (cf. CCTP **art. 6 — interopérabilité / table de points** et **art. 7 — réversibilité**, et **CCAP — clauses de réversibilité**). Le présent cadre fixe l'**ambition minimale** ; il **n'exonère pas** le titulaire de livrer la table complète.
- **[RECOMMANDATION]** Conserver le **repère** dans la même logique que les schémas / synoptiques et l'étiquetage terrain, pour une traçabilité MOA ↔ exploitation.
- **[INFORMATIF]** Les lots ci-dessous (CVC, ÉCLAIRAGE, COMPTAGE, SUPERVISION) forment le **tronc commun** réutilisable sur la plupart des bâtiments tertiaires. La section **« Variantes par typologie »** (en fin de pièce) cible **uniquement les points en plus / en moins** selon l'usage du bâtiment (bureaux, ERP, logistique, industriel) ; **elle ne recopie pas le tronc commun**.

### Colonnes du tableau
| Colonne | Contenu attendu |
|---|---|
| **Repère** | Identifiant unique du point (logique de nommage MOA, ex. `CVC-PC-01-T-DEP`). |
| **Désignation** | Libellé fonctionnel clair (équipement + grandeur). |
| **Lot** | Lot technique concerné (CVC, ÉCL, COMPT, SUPERV…). |
| **Type** | Nature du point : **AI** (entrée analogique / mesure), **AO** (sortie analogique / commande modulante), **BI** (entrée binaire / état), **BO** (sortie binaire / commande TOR), **AV** (valeur analogique calculée/consigne logicielle), **BV** (valeur binaire logicielle), **MSV** (multi-états). |
| **Protocole** | Protocole d'accès au point (BACnet/IP, BACnet MS/TP, KNX, Modbus TCP/RTU, DALI-2, M-Bus, OPC UA…). `[À COMPLÉTER]` selon équipement réel. |
| **Adresse** | Adresse / objet dans le protocole (n° objet BACnet, registre Modbus, GA KNX, adresse DALI…). `[À COMPLÉTER]` à l'intégration. |
| **Unité** | Unité physique (°C, %, Pa, m³/h, kWh, ppm…) ou sans unité. |
| **Plage** | Étendue de mesure / commande attendue (ex. 0–100 °C, 0–10 V, 0/1). À confirmer sur doc constructeur. |
| **Accès** | **R** = lecture seule (mesure, état, alarme) · **RW** = lecture/écriture (consigne, commande, scène). |

> **[INFORMATIF]** Conventions de remplissage : `[À COMPLÉTER]` = à renseigner par le MOA/maître d'œuvre avant diffusion ; les valeurs de type/adresse/plage non figées sont finalisées par le **titulaire**. Blocs `🔀 OPTION` = à activer/supprimer selon le contexte du bâtiment.

---

## LOT CVC — Chauffage · Ventilation · Climatisation

### CVC.1 — Production de chaud (chaudière / PAC)

*Lignes d'exemple à adapter aux équipements réellement prévus (nombre de générateurs, type chaudière condensation / PAC air-eau / réseau de chaleur).*

| Repère | Désignation | Lot | Type | Protocole | Adresse | Unité | Plage | Accès |
|---|---|---|---|---|---|---|---|---|
| `CVC-PC-01-T-DEP` | T° départ production *(exemple à adapter)* | CVC | AI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | °C | 0–100 | R |
| `CVC-PC-01-T-RET` | T° retour production *(exemple à adapter)* | CVC | AI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | °C | 0–100 | R |
| `CVC-PC-01-CONS-T` | Consigne T° départ *(exemple à adapter)* | CVC | AV | `[À COMPLÉTER]` | `[À COMPLÉTER]` | °C | 20–90 | RW |
| `CVC-PC-01-ET-BRUL` | État brûleur / compresseur marche/arrêt *(exemple à adapter)* | CVC | BI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | R |
| `CVC-PC-01-CMD-MA` | Commande marche/arrêt générateur *(exemple à adapter)* | CVC | BO | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | RW |
| `CVC-PC-01-DEFAUT` | Défaut générateur (synthèse) *(exemple à adapter)* | CVC | BI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | R |
| `CVC-PC-01-PUISS` | Taux de modulation / puissance instantanée *(exemple à adapter)* | CVC | AI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | % | 0–100 | R |
| `CVC-PC-01-HEURES` | Compteur horaire de fonctionnement *(exemple à adapter)* | CVC | AI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | h | 0–99999 | R |

> 🔀 **OPTION PAC** — si pompe à chaleur : ajouter T° source (air/eau/sol), COP/EER instantané si remonté par le constructeur, mode chaud/froid (MSV), dégivrage en cours (BI). *À activer selon équipement.*

### CVC.2 — Sous-station / distribution secondaire

*Exemple à adapter au nombre de départs et à la présence d'échangeur / vanne 3 voies.*

| Repère | Désignation | Lot | Type | Protocole | Adresse | Unité | Plage | Accès |
|---|---|---|---|---|---|---|---|---|
| `CVC-SS-01-V3V` | Position vanne 3 voies mélange *(exemple à adapter)* | CVC | AO | `[À COMPLÉTER]` | `[À COMPLÉTER]` | % | 0–100 | RW |
| `CVC-SS-01-T-DEP2` | T° départ secondaire *(exemple à adapter)* | CVC | AI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | °C | 0–100 | R |
| `CVC-SS-01-T-RET2` | T° retour secondaire *(exemple à adapter)* | CVC | AI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | °C | 0–100 | R |
| `CVC-SS-01-CONS-LOI` | Consigne loi d'eau (point de calcul) *(exemple à adapter)* | CVC | AV | `[À COMPLÉTER]` | `[À COMPLÉTER]` | °C | 20–80 | RW |
| `CVC-SS-01-CIRC-MA` | État circulateur secondaire *(exemple à adapter)* | CVC | BI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | R |
| `CVC-SS-01-CIRC-DEF` | Défaut circulateur *(exemple à adapter)* | CVC | BI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | R |

### CVC.3 — Centrale de traitement d'air (CTA)

*Exemple à adapter à la configuration CTA (double flux, registres, récupérateur, batteries chaud/froid, humidification).*

| Repère | Désignation | Lot | Type | Protocole | Adresse | Unité | Plage | Accès |
|---|---|---|---|---|---|---|---|---|
| `CVC-CTA-01-T-SOUF` | T° soufflage *(exemple à adapter)* | CVC | AI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | °C | 0–50 | R |
| `CVC-CTA-01-T-REPR` | T° reprise *(exemple à adapter)* | CVC | AI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | °C | 0–50 | R |
| `CVC-CTA-01-CONS-SOUF` | Consigne T° soufflage *(exemple à adapter)* | CVC | AV | `[À COMPLÉTER]` | `[À COMPLÉTER]` | °C | 14–30 | RW |
| `CVC-CTA-01-REG-NA` | Position registre air neuf *(exemple à adapter)* | CVC | AO | `[À COMPLÉTER]` | `[À COMPLÉTER]` | % | 0–100 | RW |
| `CVC-CTA-01-REG-REPR` | Position registre reprise *(exemple à adapter)* | CVC | AO | `[À COMPLÉTER]` | `[À COMPLÉTER]` | % | 0–100 | RW |
| `CVC-CTA-01-DEBIT-SOUF` | Débit d'air soufflé *(exemple à adapter)* | CVC | AI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | m³/h | 0–10000 | R |
| `CVC-CTA-01-CONS-DEBIT` | Consigne débit (ventilation modulée) *(exemple à adapter)* | CVC | AV | `[À COMPLÉTER]` | `[À COMPLÉTER]` | m³/h | 0–10000 | RW |
| `CVC-CTA-01-CO2` | Qualité d'air — CO₂ gaine reprise *(exemple à adapter)* | CVC | AI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | ppm | 0–2000 | R |
| `CVC-CTA-01-VENT-SOUF` | État ventilateur soufflage *(exemple à adapter)* | CVC | BI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | R |
| `CVC-CTA-01-VENT-REPR` | État ventilateur reprise *(exemple à adapter)* | CVC | BI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | R |
| `CVC-CTA-01-CMD-VENT` | Commande / consigne vitesse ventilateurs *(exemple à adapter)* | CVC | AO | `[À COMPLÉTER]` | `[À COMPLÉTER]` | % | 0–100 | RW |
| `CVC-CTA-01-FREECOOL` | État free-cooling actif *(exemple à adapter)* | CVC | BV | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | RW |
| `CVC-CTA-01-FILTRE-DEF` | Défaut encrassement filtre (pressostat) *(exemple à adapter)* | CVC | BI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | R |
| `CVC-CTA-01-DEFAUT` | Défaut général CTA (synthèse) *(exemple à adapter)* | CVC | BI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | R |

> 🔀 **OPTION récupérateur / humidification** — ajouter rendement échangeur, bypass récupérateur (AO), T° après récupérateur (AI), hygrométrie soufflage (AI), consigne d'humidité (AV). *À activer selon CTA réelle.*

### CVC.4 — Régulation terminale par zone

*Exemple à dupliquer par zone / local régulé (bureau, salle, plateau). Le nombre de zones dépend du plan d'occupation.*

| Repère | Désignation | Lot | Type | Protocole | Adresse | Unité | Plage | Accès |
|---|---|---|---|---|---|---|---|---|
| `CVC-ZON-01-T-AMB` | T° ambiante zone 01 *(exemple à adapter)* | CVC | AI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | °C | 0–40 | R |
| `CVC-ZON-01-CONS-T` | Consigne T° ambiante zone 01 *(exemple à adapter)* | CVC | AV | `[À COMPLÉTER]` | `[À COMPLÉTER]` | °C | 16–28 | RW |
| `CVC-ZON-01-PRESENCE` | Présence / occupation zone 01 *(exemple à adapter)* | CVC | BI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | R |
| `CVC-ZON-01-MODE` | Mode régulation (confort/réduit/hors-gel) *(exemple à adapter)* | CVC | MSV | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 1–3 | RW |
| `CVC-ZON-01-VANNE` | Position vanne / registre terminal zone 01 *(exemple à adapter)* | CVC | AO | `[À COMPLÉTER]` | `[À COMPLÉTER]` | % | 0–100 | RW |
| `CVC-ZON-01-FENETRE` | Contact fenêtre ouverte zone 01 *(exemple à adapter)* | CVC | BI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | R |

---

## LOT ÉCLAIRAGE — DALI

> **[RECOMMANDATION]** Privilégier des passerelles / luminaires **certifiés DALI-2** (et D4i pour les luminaires) afin de garantir l'interopérabilité multi-fournisseurs — cf. critère C2.2 de la grille de dépouillement. *Exemple à dupliquer par groupe / zone DALI.*

| Repère | Désignation | Lot | Type | Protocole | Adresse | Unité | Plage | Accès |
|---|---|---|---|---|---|---|---|---|
| `ECL-G01-ETAT` | État groupe d'éclairage 01 (ON/OFF) *(exemple à adapter)* | ÉCL | BI | DALI-2 | `[À COMPLÉTER]` | — | 0/1 | R |
| `ECL-G01-CMD` | Commande groupe 01 (ON/OFF) *(exemple à adapter)* | ÉCL | BO | DALI-2 | `[À COMPLÉTER]` | — | 0/1 | RW |
| `ECL-G01-NIV` | Niveau de gradation groupe 01 *(exemple à adapter)* | ÉCL | AO | DALI-2 | `[À COMPLÉTER]` | % | 0–100 | RW |
| `ECL-G01-PRESENCE` | Détection présence zone 01 *(exemple à adapter)* | ÉCL | BI | DALI-2 | `[À COMPLÉTER]` | — | 0/1 | R |
| `ECL-G01-LUX` | Mesure luminosité (capteur lumière du jour) *(exemple à adapter)* | ÉCL | AI | DALI-2 | `[À COMPLÉTER]` | lux | 0–2000 | R |
| `ECL-G01-DEFAUT-LUM` | Défaut luminaire / driver (DALI) *(exemple à adapter)* | ÉCL | BI | DALI-2 | `[À COMPLÉTER]` | — | 0/1 | R |
| `ECL-G01-SCENE` | Scène d'éclairage active groupe 01 *(exemple à adapter)* | ÉCL | MSV | DALI-2 | `[À COMPLÉTER]` | — | 0–15 | RW |

> 🔀 **OPTION D4i / reporting énergie** — si luminaires D4i : ajouter remontée de **consommation d'énergie luminaire** (AI, kWh), heures de fonctionnement et état de fin de vie estimée. *À activer selon matériel.*

---

## LOT COMPTAGE — Énergie & fluides

> **[OBLIGATION / À VÉRIFIER]** Le **décret BACS** impose des fonctions de **comptage et de suivi des consommations** par usage (à reconfirmer sur **art. R. 175-3 du CCH**, Légifrance, avant diffusion — cf. art. 13 du CCTP). Le **décret tertiaire / OPERAT** peut imposer un suivi par usage si le bâtiment est assujetti. *Exemple à adapter aux compteurs réellement posés.*

| Repère | Désignation | Lot | Type | Protocole | Adresse | Unité | Plage | Accès |
|---|---|---|---|---|---|---|---|---|
| `COMPT-ELEC-GEN-IDX` | Index énergie électrique général *(exemple à adapter)* | COMPT | AI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | kWh | 0–9999999 | R |
| `COMPT-ELEC-GEN-P` | Puissance active instantanée générale *(exemple à adapter)* | COMPT | AI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | kW | 0–9999 | R |
| `COMPT-ELEC-CVC-IDX` | Sous-compteur électrique usage CVC *(exemple à adapter)* | COMPT | AI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | kWh | 0–9999999 | R |
| `COMPT-ELEC-ECL-IDX` | Sous-compteur électrique usage éclairage *(exemple à adapter)* | COMPT | AI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | kWh | 0–9999999 | R |
| `COMPT-GAZ-GEN-IDX` | Index compteur gaz *(exemple à adapter)* | COMPT | AI | M-Bus | `[À COMPLÉTER]` | m³ | 0–999999 | R |
| `COMPT-CHAUD-IDX` | Index compteur d'énergie chaleur (réseau/échangeur) *(exemple à adapter)* | COMPT | AI | M-Bus | `[À COMPLÉTER]` | kWh | 0–9999999 | R |
| `COMPT-FROID-IDX` | Index compteur d'énergie froid *(exemple à adapter)* | COMPT | AI | M-Bus | `[À COMPLÉTER]` | kWh | 0–9999999 | R |
| `COMPT-EAU-GEN-IDX` | Index compteur d'eau général *(exemple à adapter)* | COMPT | AI | M-Bus | `[À COMPLÉTER]` | m³ | 0–999999 | R |

> **[RECOMMANDATION]** Prévoir un **sous-comptage par usage** (CVC, éclairage, prises/bureautique, process, autres) cohérent avec la nomenclature d'usages du suivi réglementaire applicable. *Adapter la granularité au projet.*

---

## LOT SUPERVISION — GTB / agrégation

> **[INFORMATIF]** Points de niveau supervision : synthèses d'alarmes et **santé de communication** des passerelles/automates. Ils sont **indispensables au critère « réversibilité / interopérabilité »** : sans état de communication remonté, un défaut de passerelle reste invisible. *Exemple à adapter à l'architecture réseau réelle.*

| Repère | Désignation | Lot | Type | Protocole | Adresse | Unité | Plage | Accès |
|---|---|---|---|---|---|---|---|---|
| `SUP-ALM-CVC` | Alarme agrégée lot CVC *(exemple à adapter)* | SUPERV | BV | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | R |
| `SUP-ALM-ECL` | Alarme agrégée lot éclairage *(exemple à adapter)* | SUPERV | BV | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | R |
| `SUP-ALM-COMPT` | Alarme agrégée lot comptage *(exemple à adapter)* | SUPERV | BV | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | R |
| `SUP-ALM-GEN` | Synthèse alarmes générale bâtiment *(exemple à adapter)* | SUPERV | BV | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | R |
| `SUP-COM-PASS01` | État de communication passerelle / automate 01 *(exemple à adapter)* | SUPERV | BI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | R |
| `SUP-COM-PASS02` | État de communication passerelle / automate 02 *(exemple à adapter)* | SUPERV | BI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | R |
| `SUP-COM-BUS-DALI` | État de communication bus DALI *(exemple à adapter)* | SUPERV | BI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | R |
| `SUP-COM-BUS-MBUS` | État de communication bus M-Bus comptage *(exemple à adapter)* | SUPERV | BI | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | R |

---

## Variantes par typologie

> **[INFORMATIF]** Cette section liste, **typologie par typologie**, les points de données **spécifiques en plus ou en moins** par rapport au **tronc commun** ci-dessus (lots CVC, ÉCLAIRAGE, COMPTAGE, SUPERVISION). **Le tronc commun n'est pas recopié** : on ne montre ici que les différences. Comme partout dans cette pièce, les lignes sont des **EXEMPLES À ADAPTER** : les **types (AI/AO/BI/BO/AV…) et protocoles** sont indiqués **à titre d'exemple à adapter** à l'équipement réel ; les **adresses** restent `[À COMPLÉTER]` à l'intégration et certaines **plages** restent `[À COMPLÉTER]` car elles dépendent du matériel posé. Aucune donnée chiffrée réglementaire n'est fixée ici (les seuils restent à confirmer sur source primaire — cf. art. 13 du CCTP). La **légende des statuts** en tête de pièce s'applique.

---

### V1 — BUREAUX

*Bâtiment de bureaux : forte granularité de régulation terminale (par zone / plateau), pilotage par occupation des open-spaces, sous-comptage par plateau ou par locataire, surveillance CO₂ dans les espaces à occupation variable (salles de réunion).*

**En PLUS du tronc commun :**

| Repère | Désignation | Lot | Type | Protocole | Adresse | Unité | Plage | Accès |
|---|---|---|---|---|---|---|---|---|
| `CVC-ZON-PLAT01-T-AMB` | T° ambiante plateau 01 *(exemple à adapter)* | CVC | AI *(exemple à adapter)* | `[À COMPLÉTER]` | `[À COMPLÉTER]` | °C | 0–40 | R |
| `CVC-ZON-PLAT01-CONS-T` | Consigne T° par plateau / zone de régulation *(exemple à adapter)* | CVC | AV *(exemple à adapter)* | `[À COMPLÉTER]` | `[À COMPLÉTER]` | °C | `[À COMPLÉTER]` | RW |
| `CVC-ZON-PLAT01-VANNE` | Position vanne / registre terminal plateau 01 *(exemple à adapter)* | CVC | AO *(exemple à adapter)* | `[À COMPLÉTER]` | `[À COMPLÉTER]` | % | 0–100 | RW |
| `ECL-OPEN01-PRESENCE` | Détection présence open-space 01 (pilotage éclairage) *(exemple à adapter)* | ÉCL | BI *(exemple à adapter)* | DALI-2 *(exemple à adapter)* | `[À COMPLÉTER]` | — | 0/1 | R |
| `ECL-OPEN01-NIV` | Niveau de gradation open-space 01 (daylight harvesting) *(exemple à adapter)* | ÉCL | AO *(exemple à adapter)* | DALI-2 *(exemple à adapter)* | `[À COMPLÉTER]` | % | 0–100 | RW |
| `CVC-SDR01-CO2` | Qualité d'air — CO₂ salle de réunion 01 *(exemple à adapter)* | CVC | AI *(exemple à adapter)* | `[À COMPLÉTER]` | `[À COMPLÉTER]` | ppm | `[À COMPLÉTER]` | R |
| `CVC-SDR01-PRESENCE` | Présence salle de réunion 01 (boost ventilation à l'occupation) *(exemple à adapter)* | CVC | BI *(exemple à adapter)* | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | R |
| `COMPT-ELEC-PLAT01-IDX` | Sous-comptage électrique par plateau 01 *(exemple à adapter)* | COMPT | AI *(exemple à adapter)* | `[À COMPLÉTER]` | `[À COMPLÉTER]` | kWh | `[À COMPLÉTER]` | R |
| `COMPT-ELEC-LOC-A-IDX` | Sous-comptage électrique par locataire A *(exemple à adapter)* | COMPT | AI *(exemple à adapter)* | `[À COMPLÉTER]` | `[À COMPLÉTER]` | kWh | `[À COMPLÉTER]` | R |

> 🔀 **OPTION refacturation locataires** — si l'immeuble est multi-locataires : dupliquer le sous-comptage (élec, chaud, froid, eau) **par lot privatif** pour permettre la répartition des charges. *À activer selon configuration locative.*

**En MOINS / sans objet :** rien de structurel en moins par rapport au tronc commun ; les bureaux constituent le cas de référence du tronc.

---

### V2 — ERP / ÉTABLISSEMENT RECEVANT DU PUBLIC

*Commerce, enseignement, santé léger : comptage par zone / locataire, interfaces de **report** vers des systèmes de sécurité tiers (désenfumage, CTA par zone publique), **plages d'occupation variables** selon les horaires d'ouverture au public, éclairage par zone d'accueil.*

**En PLUS du tronc commun :**

| Repère | Désignation | Lot | Type | Protocole | Adresse | Unité | Plage | Accès |
|---|---|---|---|---|---|---|---|---|
| `CVC-CTA-PUB01-CMD-VENT` | Commande CTA zone publique 01 (asservie aux horaires d'ouverture) *(exemple à adapter)* | CVC | AO *(exemple à adapter)* | `[À COMPLÉTER]` | `[À COMPLÉTER]` | % | 0–100 | RW |
| `CVC-OCC-PROG` | Programme horaire d'occupation public (plage variable) *(exemple à adapter)* | CVC | MSV *(exemple à adapter)* | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | `[À COMPLÉTER]` | RW |
| `SECU-DESENF-REPORT` | Report d'état désenfumage (interface lot SSI — **lecture seule**) *(exemple à adapter)* | SUPERV | BI *(exemple à adapter)* | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | R |
| `SECU-SSI-SYNTH` | Synthèse report système de sécurité incendie (interface lot SSI — **lecture seule**) *(exemple à adapter)* | SUPERV | BI *(exemple à adapter)* | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | R |
| `ECL-ACCUEIL01-CMD` | Commande éclairage zone d'accueil / hall public 01 *(exemple à adapter)* | ÉCL | BO *(exemple à adapter)* | DALI-2 *(exemple à adapter)* | `[À COMPLÉTER]` | — | 0/1 | RW |
| `ECL-ACCUEIL01-NIV` | Niveau gradation zone d'accueil 01 (ambiance / vitrine) *(exemple à adapter)* | ÉCL | AO *(exemple à adapter)* | DALI-2 *(exemple à adapter)* | `[À COMPLÉTER]` | % | 0–100 | RW |
| `COMPT-ELEC-ZONE-PUB-IDX` | Sous-comptage électrique zone publique 01 *(exemple à adapter)* | COMPT | AI *(exemple à adapter)* | `[À COMPLÉTER]` | `[À COMPLÉTER]` | kWh | `[À COMPLÉTER]` | R |
| `COMPT-ELEC-LOC-COM-IDX` | Sous-comptage électrique par locataire / cellule commerciale *(exemple à adapter)* | COMPT | AI *(exemple à adapter)* | `[À COMPLÉTER]` | `[À COMPLÉTER]` | kWh | `[À COMPLÉTER]` | R |

> **[INFORMATIF / À VÉRIFIER]** Les interfaces avec la **sécurité incendie (SSI / désenfumage)** sont réglementées : le report en GTB est en principe **en lecture seule** et **ne doit pas commander** les fonctions de sécurité. Le périmètre exact (autonomie du SSI, points reportés) est à **cadrer avec le lot SSI et le bureau de contrôle** — aucune commande de sécurité n'est figée ici.
>
> 🔀 **OPTION santé / enseignement** — selon l'usage : ajouter surveillance hygrométrie de locaux sensibles, report d'état des portes coupe-feu, comptage process spécifique (cuisine, plateau technique). *À activer selon établissement.*

**En MOINS / sans objet :** la régulation terminale fine *par poste de travail* (logique bureaux) est généralement **sans objet** ; on régule par **zone publique** plutôt que par occupant individuel.

---

### V3 — LOGISTIQUE / ENTREPÔT

*Entrepôt / plateforme logistique : **éclairage par détection avec temporisation longue et zonage par allées** (levier d'économies majeur), **destratification / chauffage radiant** plutôt que CTA tertiaire, **peu ou pas de froid de confort**, **free-cooling / surventilation nocturne**, et **comptage process (manutention, charge, froid industriel) séparé du tertiaire** — utile au regard du décret tertiaire / OPERAT.*

**En PLUS du tronc commun :**

| Repère | Désignation | Lot | Type | Protocole | Adresse | Unité | Plage | Accès |
|---|---|---|---|---|---|---|---|---|
| `ECL-ALLEE01-PRESENCE` | Détection présence allée 01 (déclenchement éclairage) *(exemple à adapter)* | ÉCL | BI *(exemple à adapter)* | DALI-2 *(exemple à adapter)* | `[À COMPLÉTER]` | — | 0/1 | R |
| `ECL-ALLEE01-CMD` | Commande éclairage allée 01 (zonage par allée) *(exemple à adapter)* | ÉCL | BO *(exemple à adapter)* | DALI-2 *(exemple à adapter)* | `[À COMPLÉTER]` | — | 0/1 | RW |
| `ECL-ALLEE01-TEMPO` | Temporisation d'extinction allée 01 (réglable, tempo longue) *(exemple à adapter)* | ÉCL | AV *(exemple à adapter)* | `[À COMPLÉTER]` | `[À COMPLÉTER]` | s | `[À COMPLÉTER]` | RW |
| `CVC-RAD01-T-AMB` | T° ambiante zone stockage 01 (chauffage radiant) *(exemple à adapter)* | CVC | AI *(exemple à adapter)* | `[À COMPLÉTER]` | `[À COMPLÉTER]` | °C | 0–40 | R |
| `CVC-RAD01-CMD` | Commande chauffage radiant / aérotherme zone 01 *(exemple à adapter)* | CVC | BO *(exemple à adapter)* | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | RW |
| `CVC-DESTRAT01-CMD` | Commande ventilateur de destratification zone 01 *(exemple à adapter)* | CVC | BO *(exemple à adapter)* | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | RW |
| `CVC-DESTRAT01-DT` | Écart T° haut/bas (pilotage destratification) *(exemple à adapter)* | CVC | AI *(exemple à adapter)* | `[À COMPLÉTER]` | `[À COMPLÉTER]` | °C | `[À COMPLÉTER]` | R |
| `CVC-SURVENT-NUIT-CMD` | Commande surventilation / free-cooling nocturne *(exemple à adapter)* | CVC | BO *(exemple à adapter)* | `[À COMPLÉTER]` | `[À COMPLÉTER]` | — | 0/1 | RW |
| `CVC-SURVENT-T-EXT` | T° extérieure (autorisation surventilation nocturne) *(exemple à adapter)* | CVC | AI *(exemple à adapter)* | `[À COMPLÉTER]` | `[À COMPLÉTER]` | °C | `[À COMPLÉTER]` | R |
| `COMPT-ELEC-PROCESS-IDX` | Sous-comptage électrique **process / manutention** (séparé du tertiaire) *(exemple à adapter)* | COMPT | AI *(exemple à adapter)* | `[À COMPLÉTER]` | `[À COMPLÉTER]` | kWh | `[À COMPLÉTER]` | R |
| `COMPT-ELEC-CHARGE-IDX` | Sous-comptage électrique zone de charge engins / chariots *(exemple à adapter)* | COMPT | AI *(exemple à adapter)* | `[À COMPLÉTER]` | `[À COMPLÉTER]` | kWh | `[À COMPLÉTER]` | R |

> **[INFORMATIF / À VÉRIFIER]** La **séparation comptage tertiaire vs process** facilite l'éventuelle exclusion des consommations process du périmètre assujetti au **décret tertiaire / OPERAT** (à confirmer sur source primaire selon le statut du bâtiment — cf. art. 13 du CCTP). Aucun seuil ni périmètre réglementaire n'est figé ici.
>
> 🔀 **OPTION zone froide / entrepôt frigorifique** — si présence de froid (chambres froides, quais réfrigérés) : ajouter T° par chambre froide, état groupe froid, alarme T° haute, dégivrage, comptage froid dédié. *À activer selon activité.*

**En MOINS / sans objet :** la **CTA double flux tertiaire** (lot CVC.3) et la **régulation terminale fine par poste** sont généralement **sans objet** sur les volumes de stockage ; le froid de confort est souvent absent. Adapter / supprimer les lignes correspondantes du tronc commun.

---

### 🔀 OPTION V4 — INDUSTRIEL / PROCESS

> 🔀 **OPTION à activer uniquement si le bâtiment comporte un process industriel.** *Sépare strictement le **CVC tertiaire** (bureaux, vestiaires, locaux sociaux) des **utilités process**, fait dominer les **automates Modbus**, et impose des contraintes de **continuité de service**.*

**En PLUS du tronc commun :**

| Repère | Désignation | Lot | Type | Protocole | Adresse | Unité | Plage | Accès |
|---|---|---|---|---|---|---|---|---|
| `UTIL-AIRCOMP-P` | Pression réseau air comprimé (utilité process) *(exemple à adapter)* | CVC | AI *(exemple à adapter)* | Modbus TCP *(exemple à adapter)* | `[À COMPLÉTER]` | bar | `[À COMPLÉTER]` | R |
| `UTIL-AIRCOMP-ETAT` | État compresseur d'air (utilité process) *(exemple à adapter)* | CVC | BI *(exemple à adapter)* | Modbus TCP *(exemple à adapter)* | `[À COMPLÉTER]` | — | 0/1 | R |
| `UTIL-EAUGLACEE-T` | T° production eau glacée process *(exemple à adapter)* | CVC | AI *(exemple à adapter)* | Modbus TCP *(exemple à adapter)* | `[À COMPLÉTER]` | °C | `[À COMPLÉTER]` | R |
| `UTIL-EAUGLACEE-DEFAUT` | Défaut groupe eau glacée process *(exemple à adapter)* | CVC | BI *(exemple à adapter)* | Modbus TCP *(exemple à adapter)* | `[À COMPLÉTER]` | — | 0/1 | R |
| `PROC-AUTO01-COM` | État de communication automate process 01 (Modbus) *(exemple à adapter)* | SUPERV | BI *(exemple à adapter)* | Modbus TCP *(exemple à adapter)* | `[À COMPLÉTER]` | — | 0/1 | R |
| `PROC-AUTO01-SYNTH` | Synthèse défaut process automate 01 (**report lecture seule**) *(exemple à adapter)* | SUPERV | BI *(exemple à adapter)* | Modbus TCP *(exemple à adapter)* | `[À COMPLÉTER]` | — | 0/1 | R |
| `COMPT-ELEC-PROCESS-IDX` | Sous-comptage électrique **utilités process** (séparé du tertiaire) *(exemple à adapter)* | COMPT | AI *(exemple à adapter)* | Modbus TCP *(exemple à adapter)* | `[À COMPLÉTER]` | kWh | `[À COMPLÉTER]` | R |
| `CVC-TERT01-T-AMB` | T° ambiante CVC **tertiaire** (locaux sociaux, séparé du process) *(exemple à adapter)* | CVC | AI *(exemple à adapter)* | `[À COMPLÉTER]` | `[À COMPLÉTER]` | °C | 0–40 | R |

> **[INFORMATIF / À VÉRIFIER]** **Contrainte de continuité de service** : le périmètre process est souvent piloté par des automates **autonomes** ; la GTB s'y interface en principe **en lecture seule (report / supervision)** et **ne prend pas la main** sur les sécurités ou les séquences process. Le périmètre exact (points reportés, points commandables) est à **cadrer avec le responsable process / le constructeur des machines**. Aucune commande process n'est figée ici.
>
> **[RECOMMANDATION]** Maintenir une **frontière nette** entre périmètre tertiaire (assujetti aux exigences réglementaires bâtiment) et périmètre process, jusque dans la nomenclature des repères (`CVC-TERT-…` vs `UTIL-…` / `PROC-…`), pour la lisibilité d'exploitation et le suivi des consommations.

**En MOINS / sans objet :** côté CVC, la logique « confort tertiaire » s'applique **seulement** aux locaux sociaux/bureaux ; les utilités process suivent une logique propre (Modbus, automates dédiés) et ne doivent pas être traitées comme des zones de confort.

---

## RAPPEL CONTRACTUEL

**[CLAUSE CONTRACTUELLE]** Cette liste de points est un **cadre** ; elle **n'est pas la table de points définitive**. Le titulaire :
1. établit et adresse la **liste exhaustive** au regard des équipements réellement installés (**art. 6** du CCTP) ;
2. la remet **complète et exploitable** dans le **dossier de réversibilité** à la réception et à chaque évolution (**art. 7.2** du CCTP, **CCAP — réversibilité**) ;
3. en garantit la propriété au **MOA**, sans format propriétaire fermé ni runtime bloquant.

Tout point ajouté en cours de marché est valorisé au **coût d'extension par point de données** figé au BPU (cf. pièce **A4 — cadre BPU/DPGF**), afin de prévenir toute facturation abusive.

---

*Cadre de liste de points GTB vendor-neutral — NeoGTB. Lignes = exemples à adapter, pas une installation réelle. Types / protocoles / adresses dépendent des équipements retenus. Liste définitive = livrable du titulaire.*
