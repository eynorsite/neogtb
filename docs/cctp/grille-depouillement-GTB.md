# GRILLE DE DÉPOUILLEMENT — Consultation GTB multi-protocole vendor-neutral
## Critères d'évaluation objectifs et méthode de notation

> **Document complémentaire au CCTP** `CCTP-GTB-multiprotocole-vendor-neutral.md`. Modèle réutilisable.
>
> **Statut juridique** : les règles du **Code de la commande publique** (pondération obligatoire et publiée, méthode de notation) ne s'imposent **qu'aux acheteurs publics**. En **marché privé**, elles constituent une **bonne pratique recommandée, non obligatoire**. Les pondérations ci-dessous sont un **exemple, choix du MOA** — à ajuster.

---

## 1. PRINCIPE DIRECTEUR
**Tout critère est adossé à une exigence du CCTP et noté sur une preuve vérifiable** (document fourni, certificat, listing, BPU, planning) — **jamais sur une impression**. Le barème est annoncé **avant** réception des offres.

---

## 2. CRITÈRES D'ÉVALUATION ET MESURE OBJECTIVE

| N° | Critère | Comment le mesurer objectivement | § CCTP de référence |
|---|---|---|---|
| **C1** | Conformité fonctionnelle | Tableau de conformité point par point (C / PC / NC) avec renvoi à la pièce justificative. Note = % d'exigences « Conforme » (PC = 0,5). Exigences **éliminatoires** = rejet si NC. | Art. 5, Annexe A |
| **C2** | **Ouverture / interopérabilité** | Sous-critères comptables (voir §4) : protocoles ouverts natifs, **certifications vérifiées** (BTL, KNX, DALI-2, OMS), réversibilité & propriété des données. | Art. 2, 6, 7 |
| **C3** | Classe d'efficacité NF EN ISO 52120-1 | Classe A/B/C **justifiée fonction par fonction** via la grille de la norme. ¹ | Art. 5.3 |
| **C4** | Maintenabilité / anti lock-in | Points par « verrou levé » : outils d'ingénierie accessibles, documentation complète, mots de passe admin, pas de format propriétaire fermé, pièces/firmware hors fournisseur unique. | Art. 7 |
| **C5** | Références & qualifications | Références **comparables** datées + contact MOA ; qualifications **vérifiables**. ² | A5 rubrique 1 + Art. 11 (CCTP) |
| **C6** | Délais | Planning daté engageant → délai global (semaines). Notation proportionnelle inverse **bornée**. | Art. 9, planning |
| **C7** | Garanties / SAV / formation | Durée garantie (mois), GTI/GTR (h), jours de formation, télémaintenance. Barème par seuils. | Art. 10, 8.3 |
| **C8** | **Coût global de possession (TCO)** | Somme sur durée de référence : CAPEX + maintenance + licences + énergie + réversibilité, sur **cadre de décomposition imposé** (A4 — BPU/DPGF + cadre TCO). | A4 (BPU/DPGF + cadre TCO) |

¹ **Si bâtiment assujetti au décret BACS** : la **classe ≥ B devient une exigence minimale éliminatoire** (pas un simple critère pondéré) ; C3 ne note alors que le **dépassement** (atteinte classe A).
² **En marché public** : les références/qualifications relèvent en principe de la **candidature** (capacités), non de l'**offre** (jugement). Les tenir séparées pour rester régulier.

---

## 3. EXEMPLE DE PONDÉRATION

> ⚠️ **Choix du MOA, non réglementaire.** Fourchette usuelle en achat technique : **valeur technique ≈ 50–70 %**, **prix/TCO ≈ 30–50 %**. Pour une GTB où l'ouverture et l'efficacité priment, on privilégie le haut de la fourchette technique.

| N° | Critère | Pondération (exemple) |
|---|---|---|
| C8 | **Coût global de possession (TCO)** | **30 %** |
| C2 | Ouverture / interopérabilité | 20 % |
| C1 | Conformité fonctionnelle | 12 % |
| C3 | Classe NF EN ISO 52120-1 ¹ | 10 % |
| C4 | Maintenabilité / anti lock-in | 10 % |
| C7 | Garanties / SAV / formation | 8 % |
| C5 | Références & qualifications ² | 6 % |
| C6 | Délais | 4 % |
| | **TOTAL** | **100 %** |

Bloc « valeur technique » (C1+C2+C3+C4+C5+C6+C7) = **70 %** · Prix/TCO = **30 %**.

> 🔀 OPTION MARCHÉ PUBLIC — pondérations à publier au règlement de consultation (art. R. 2152-11 / R. 2152-12 CCP) ; possibilité d'exprimer une **fourchette à écart maximal approprié**.

---

## 4. DÉTAIL DU CRITÈRE C2 — OUVERTURE (cœur « vendor-neutral »)

| Sous-critère | Mesure | Barème |
|---|---|---|
| **C2.1** Protocoles ouverts natifs | Nombre + nature (BACnet/IP, BACnet MS/TP, KNX, Modbus TCP/RTU, DALI-2, M-Bus, OPC UA…), justifiés par fiche produit | Points par protocole supporté nativement, **plafonné** |
| **C2.2** Certifications **vérifiées** | BACnet → **BTL Listing** (n° vérifiable) ; KNX → **certifié KNX** ; éclairage → **DALI-2** ; comptage → **OMS** | Points par certification **vérifiée dans la base officielle** ; **0 si seulement « compatible » déclaré** |
| **C2.3** Réversibilité & propriété des données | (i) propriété des données au MOA, (ii) export formats ouverts + config, (iii) pas de runtime bloquant, (iv) fourniture table de points + doc d'intégration | Oui / Partiel / Non → points |

> **Pourquoi la certification compte** : une certification (ex. **BTL**) atteste qu'un produit a passé les tests de conformité d'un laboratoire reconnu et garantit l'interopérabilité **multi-fournisseurs** — preuve objective de l'ouverture, par opposition à une compatibilité **auto-déclarée**.

---

## 5. MÉTHODE DE NOTATION (anti-arbitraire)

### 5.1 Critères techniques
Notation sur **sous-critères à seuils explicites** (un fait observable → un nombre de points fixé d'avance). **Bannir** les notations « impression » non justifiables.

### 5.2 Critère prix / TCO
Formule recommandée (**pratique courante**, identifiée par la **DAJ de Bercy** comme régulière) :

> **Note = (montant le plus bas / montant de l'offre examinée) × note maximale**

- ⚠️ La DAJ **ne rend aucune méthode obligatoire** : « il n'existe pas de méthode unique », libre choix de l'acheteur.
- **Appliquer la formule au TCO** (coût global, Annexe C du CCTP), **pas au seul prix d'achat** : un CAPEX faible peut cacher des licences / un lock-in coûteux. C'est ce qui sert réellement l'objectif vendor-neutral.

### 5.3 Délais
Même logique proportionnelle inverse, avec **bornes** pour écarter les délais irréalistes (un délai anormalement court peut être écarté ou exiger justification).

---

## 6. TABLEAUX DE DÉPOUILLEMENT (prêts à remplir)

### Table 1 — Détail par critère (à dupliquer par candidat, ou colonnes côte à côte)

| N° | Critère | § CCTP | Pondération % | Méthode / barème | Note brute /20 | Note pondérée | Justif. / pièce |
|---|---|---|---|---|---|---|---|
| C1 | Conformité fonctionnelle | §5 | 12 | % exigences conformes (PC=0,5) × 20 | | | Tableau conformité p.… |
| C2 | Ouverture / interopérabilité | §2,6,7 | 20 | Barème C2.1/2.2/2.3 (Table 2) | | | Fiches + listings BTL/KNX/DALI-2 |
| C3 | Classe 52120-1 | §5.3 | 10 | A=20 / B=12 / (C,D éliminés si assujetti) | | | Grille fonctions 52120-1 |
| C4 | Maintenabilité / anti lock-in | §7 | 10 | Σ points par verrou levé (6 items) | | | Engagements contractuels |
| C5 | Références & qualifications | A5 rubrique 1 + Art. 11 (CCTP) | 6 | Barème par réf. recevable + qualifs | | | Attestations |
| C6 | Délais | §9 | 4 | (délai mini recevable / délai offre) × 20 | | | Planning daté |
| C7 | Garanties / SAV / formation | §10, 8.3 | 8 | Barème par seuils (garantie, GTI, formation) | | | Mémoire + CCAP |
| C8 | **TCO** | A4 (BPU/DPGF + cadre TCO) | 30 | **(TCO le plus bas / TCO offre) × 20** | | | BPU/DPGF cadre imposé |
| | **TOTAL** | | **100** | | | **/20** | |

### Table 2 — Détail sous-critères C2

| Sous-critère | Mesure | Barème |
|---|---|---|
| C2.1 Protocoles ouverts natifs | Nombre + nature | Points/protocole, plafonné |
| C2.2 Certifications vérifiées | BTL / KNX certified / DALI-2 / OMS (listing à l'appui) | Points/certif **vérifiée** ; 0 si déclarée seule |
| C2.3 Réversibilité & propriété données | Export ouvert + pas de runtime bloquant + doc complète | Oui / Partiel / Non → points |

### Table 3 — Synthèse & classement

| Rang | Candidat | Σ notes pondérées /20 | Offre conforme (O/N) | Observations |
|---|---|---|---|---|
| 1 | | | | |
| 2 | | | | |
| 3 | | | | |

---

## 7. SOURCES (vérifiées)
- **Code de la commande publique**, art. **R. 2152-11** et **R. 2152-12** (pondération / hiérarchisation et publication des critères) — Légifrance *(confiance élevée)*.
- **Fiche DAJ — Méthodes de notation du critère prix** (formule du moins-disant, libre choix de l'acheteur) — DAJ Bercy / marche-public.fr *(confiance élevée)*.
- **NF EN ISO 52120-1:2022** (classes A/B/C/D, remplace NF EN 15232-1:2017) — *confiance moyenne-élevée, acquérir le texte AFNOR pour usage opposable*.
- **Décret BACS** (2020-887 modifié 2023-259) — exigence GTB pour bâtiments assujettis — *vérifier l'assujettissement réel et les seuils sur Légifrance avant d'en faire un critère éliminatoire*.
- Certification **BTL** (BACnet Testing Laboratories) — bacnet.org / btl.org *(confiance élevée)*. KNX certified / DALI-2 / OMS : vérifier sur les bases officielles lors de l'analyse des offres.

---

*Grille de dépouillement GTB vendor-neutral — NeoGTB. Pondérations = exemple à valider par le MOA. Distinguer candidature/offre en marché public.*
