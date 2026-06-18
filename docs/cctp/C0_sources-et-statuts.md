# C0 — Sources et statuts (socle commun de la suite GTB)

> **Rôle** : pièce de référence unique de toute la suite « Consultation & Audit GTB » de NeoGTB. Elle matérialise la règle **zéro invention** : chaque fait réglementaire ou normatif utilisé dans les autres pièces (A1–A7, B1–B4) y est référencé, daté, sourcé et qualifié par un **statut**. En cas de doute, c'est ce fichier qui fait foi ; toute pièce qui le contredit doit être corrigée.
>
> **Dernière vérification des sources** : 2026-06-18.

---

## 1. Légende des statuts (canonique — à reprendre dans chaque pièce)

| Statut | Signification | Force |
|---|---|---|
| **[OBLIGATION]** | Exigence posée par un texte réglementaire opposable (décret, arrêté, code), sourcée. | S'impose de plein droit. |
| **[RECOMMANDATION]** | Bonne pratique, cible conseillée ou condition de financement (ex. classe B, CEE). | N'engage que si reprise au marché. |
| **[CLAUSE CONTRACTUELLE]** | Disposition qui n'a force **que parce qu'elle est écrite au marché** (ex. propriété des données, réversibilité). | Opposable si au contrat. |
| **[CONVENTION]** | Règle d'un référentiel privé non réglementaire (ex. méthode eu.bac System, label R2S). | Indicative, à attribuer correctement. |
| **[INFORMATIF]** | Repère sans valeur d'obligation ni de résultat (ex. classe NF EN ISO 52120-1, facteurs d'efficacité Annexe A). | Ne vaut ni conformité ni économie garantie. |

> **Règle d'or** : ne jamais présenter un **[INFORMATIF]** ou une **[CONVENTION]** comme une **[OBLIGATION]**. Le cas le plus piégeux : « le décret BACS impose la classe B » — **faux** (voir §3.1).

---

## 2. Sources réglementaires françaises

| Réf. | Texte | Statut | Confiance | Source |
|---|---|---|---|---|
| R-1 | **Décret n° 2020-887 du 20 juillet 2020** (décret « BACS ») | [OBLIGATION] | élevée | [Légifrance](https://www.legifrance.gouv.fr/jorf/id/JORFTEXT000042128488/) |
| R-2 | **Décret n° 2023-259 du 7 avril 2023** (abaisse le seuil à 70 kW, inspection) | [OBLIGATION] | élevée | [Légifrance](https://www.legifrance.gouv.fr/jorf/id/JORFTEXT000047422489) |
| R-3 | **Arrêté du 7 avril 2023** (inspection périodique BACS) | [OBLIGATION] | élevée | [Légifrance](https://www.legifrance.gouv.fr/jorf/id/JORFTEXT000047422562) |
| R-4 | **Décret n° 2025-1343 du 26 décembre 2025** (report tranche 70–290 kW à 2030) | [OBLIGATION] | élevée | [Légifrance](https://www.legifrance.gouv.fr/jorf/id/JORFTEXT000053175245) |
| R-5 | **Articles R. 175-1 et s. du CCH** (notamment **R. 175-3** fonctions ; **R. 175-5-1** inspection) | [OBLIGATION] | élevée | [Légifrance R.175-3](https://www.legifrance.gouv.fr/codes/article_lc/LEGIARTI000043819541) |
| R-6 | **Décret n° 2019-771 du 23 juillet 2019** (éco-énergie tertiaire) | [OBLIGATION] | élevée | [Légifrance](https://www.legifrance.gouv.fr/jorf/id/JORFTEXT000038812251) |
| R-7 | **CCP — art. R. 2111-7, R. 2111-8, R. 2111-11** (spécifications fonctionnelles, « ou équivalent ») | [OBLIGATION] (marché public) | élevée | Légifrance |
| R-8 | **CCP — art. R. 2152-11, R. 2152-12** (pondération / hiérarchisation publiée) | [OBLIGATION] (marché public) | élevée | Légifrance |
| R-9 | **CCAG-TIC art. 38** (réversibilité ; arrêté du 30 mars 2021) — *inspiration des clauses de réversibilité* | [CLAUSE CONTRACTUELLE] | élevée | Légifrance |

### Seuils et échéances décret BACS (R-1 à R-5)
| Bâtiment | Seuil puissance CVC | Échéance | Statut |
|---|---|---|---|
| Existant | **> 290 kW** | **1ᵉʳ janvier 2025** | [OBLIGATION] |
| Existant | **70 – 290 kW** | **1ᵉʳ janvier 2030** (report R-4, anciennement 2027) | [OBLIGATION] |
| Neuf | **> 70 kW** | **8 avril 2024** | [OBLIGATION] |

> ⚠️ **[À VÉRIFIER]** la rédaction en vigueur sur Légifrance à la date de chaque marché (la réglementation évolue).

---

## 3. Sources normatives

### 3.1 NF EN ISO 52120-1:2022 — point sensible
- **[OBLIGATION]** : le décret BACS impose des **FONCTIONS** (art. R. 175-3 du CCH). *Confiance élevée.*
- **[RECOMMANDATION] / [INFORMATIF]** : la **« classe A ou B »** n'est **pas** écrite dans le décret. C'est la **lecture pratique** + la **condition de la prime CEE** (fiche **BAT-TH-116**). La conformité se juge sur les **fonctions**, pas sur la classe. *Confiance élevée.*
- **[INFORMATIF]** : la norme **NF EN ISO 52120-1:2022 remplace l'EN 15232-1:2017**. Classes **A/B/C/D** ; classe globale = **classe la plus faible** des fonctions installées (« maillon faible »). *Confiance moyenne-élevée — acquérir le texte AFNOR pour usage opposable.*
- **Méthodes (numérotation officielle)** : **Clause 6 « Method 1 – Detailed method »**, **Clause 7 « Method 2 – Factor based method »**. Les **facteurs d'efficacité (Annexes A et C) sont INFORMATIFS** → un % de gain **n'est jamais un engagement de résultat** ; seule l'**Annexe B (exigences minimales de fonctions) est NORMATIVE**. *Confiance élevée (vérifié 2026-06-18).*
- **[CONVENTION]** : **eu.bac System** est une **certification tierce payante distincte** de l'auto-évaluation normative. Un audit NeoGTB est une **auto-évaluation argumentée selon la norme** — **jamais** « certifié eu.bac ». Le barème de points propre eu.bac = **NON CONFIRMÉ**, ne pas le citer comme certain.

### 3.2 Protocoles ouverts (à exiger par certification, sans marque)
| Protocole | Norme | Preuve d'interopérabilité | Confiance |
|---|---|---|---|
| **BACnet** | ISO 16484-5 | BTL Listing + PICS | élevée |
| **KNX** | ISO/IEC 14543-3 + EN 50090 | « certifié KNX » | élevée |
| **Modbus** | spéc. modbus.org | **pas de modèle objet → mapping documenté obligatoire** | élevée |
| **DALI** | IEC 62386 | DALI-2 / D4i | élevée |
| **M-Bus** | EN 13757 | OMS | élevée |
| **LON** | ISO/IEC 14908 | LonMark (compatibilité existant) | élevée |

---

## 4. Points NON CONFIRMÉS / à acquérir avant usage opposable (Phase 2)

| # | Point | Action |
|---|---|---|
| 1 | Rédaction littérale de l'**art. R. 175-3** | Recopier depuis Légifrance (R-5) entre guillemets. |
| 2 | **NF EN ISO 52120-1:2022** (texte intégral, Annexe B normative, facteurs Annexe A) | **Acquérir le texte AFNOR** (≈ 200 € HT) — bloquant pour B3 et tout chiffrage opposable. |
| 3 | **Sanctions BACS** | **NON CONFIRMÉ** — aucune sanction chiffrée propre au BACS. Ne rien inventer. |
| 4 | **CCAG applicable** (Travaux vs TIC) | Trancher par projet ; récapituler les dérogations au CCAP (A2). |
| 5 | **eu.bac System** (barème de points propre) | NON CONFIRMÉ — ne pas citer ; ne pas présenter un audit comme « certifié eu.bac ». |
| 6 | **« ~16 % des sites équipés » (GIMELEC)**, **gains « 30 %/10 % »**, notation **f_BAC,hc** | **RETIRÉS** — non sourcés / informatifs. Tout gain énergétique en **fourchette** + hypothèses. |

---

## 5. Règle zéro invention (rappel)
Aucune affirmation sans source vérifiable. Pas de numéro de texte, de date, de chiffre ou de seuil fabriqué. En cas de doute : **[À VÉRIFIER]** + source primaire, ou « NON CONFIRMÉ ». Hiérarchie : texte officiel lu > doc officielle > source secondaire concordante (à reconfirmer).

---
*C0 — socle de sources et statuts. Référencé par toutes les pièces de la suite. Mettre à jour la date de vérification à chaque revue.*
