# Exemple d'audit de conformité — Décret BACS

> **Nature du document** : modèle de rapport d'audit, illustré sur un bâtiment **fictif mais réaliste**.
> Toutes les données du bâtiment (surfaces, puissances, équipements) sont **fictives** et servent
> uniquement à dérouler la méthode. **Les faits réglementaires, eux, sont vérifiés et sourcés**
> (voir § 9). Date de rédaction : 2026-06-15.
>
> Usage NeoGTB : trame réutilisable pour un livrable d'audit « conformité décret BACS »,
> en cohérence avec la posture *tiers de confiance indépendant* (0 matériel vendu, 0 commission).

> **Statuts employés dans ce rapport** — pour distinguer ce qui est opposable de ce qui ne l'est pas :
> **[OBLIGATION]** = exigence réglementaire (décret/arrêté, sourcée) · **[RECOMMANDATION]** = bonne
> pratique ou cible conseillée (ex. classe B, financement CEE) · **[INDICATEUR]** = repère non
> réglementaire (ex. classe NF EN ISO 52120-1 : elle mesure le niveau fonctionnel de la GTB et
> **ne vaut pas** conformité au décret, qui se juge sur les fonctions de l'article R. 175-3).

---

## 1. Contexte (exemple fictif)

| Élément | Valeur (exemple) |
|---|---|
| Bâtiment | Immeuble de bureaux « Le Hêtre », R+4 |
| Surface | 4 200 m² SU, tertiaire (usage bureaux) |
| Localisation | Zone d'activité, France métropolitaine |
| Maître d'ouvrage | SCI propriétaire, gestion confiée à un property manager |
| Date de demande | Juin 2026 |
| Demande | Vérifier l'assujettissement au décret BACS et l'écart de conformité |

**Systèmes techniques en place (CVC) :**

| Système | Puissance nominale utile (exemple) |
|---|---|
| Chaufferie gaz (2 chaudières) | 350 kW |
| Production de froid (groupe froid) | 180 kW |
| Ventilation (CTA double flux) | — (intégrée au calcul d'assujettissement) |

---

## 2. Objet de l'audit

Déterminer :
1. **Si** le bâtiment est assujetti au décret BACS (test de seuil).
2. **À quelle échéance** il doit être conforme.
3. **L'écart** entre le système d'automatisation existant et les exigences (fonctions + classe).
4. **Le plan d'actions** pour atteindre la conformité, avec priorisation.
5. **Le volet inspection périodique** (obligation récurrente, pas seulement à l'installation).

---

## 3. Rappel réglementaire (faits vérifiés — sources § 9)

- **Décret BACS** = *Building Automation and Control Systems*.
- Texte fondateur : **décret n° 2020-887 du 20 juillet 2020** (publié au JO le 21 juillet 2020).
- Renforcé par le **décret n° 2023-259 du 7 avril 2023** (abaissement du seuil à 70 kW).
- Échéances modifiées par le **décret n° 2025-1343 du 26 décembre 2025** (report de la tranche 70–290 kW à 2030).
- Codifié aux **articles R. 175-1 à R. 175-6 du Code de la construction et de l'habitation (CCH)**.

**Champ d'application** : bâtiments **tertiaires** équipés de systèmes de **chauffage et/ou de climatisation**
(combinés ou non avec la ventilation), dont la **puissance nominale utile** dépasse un seuil.

**Seuils et échéances de mise en conformité (bâtiments existants) :**

| Puissance des systèmes (chauffage / clim. ± ventilation) | Échéance de conformité |
|---|---|
| **> 290 kW** | **1ᵉʳ janvier 2025** |
| **> 70 kW** (tranche 70–290 kW) | **1ᵉʳ janvier 2030** (reporté ; était 2027) |

> ⚠️ Le seuil a été **abaissé de 290 kW à 70 kW** par le décret 2023-259 : c'est ce qui fait entrer
> des dizaines de milliers de bâtiments supplémentaires dans le périmètre.
> ⚠️ **Report officiel** : le **décret n° 2025-1343 du 26 décembre 2025** repousse l'échéance de la
> tranche 70–290 kW (bâtiments existants) du 1ᵉʳ janvier **2027** au 1ᵉʳ janvier **2030**.

**Bâtiments neufs** : permis de construire déposé ≥ 1 an après publication du décret → obligation
d'installer un BACS, **sauf** étude démontrant un retour sur investissement > 10 ans.

**Classe de GTB — précision importante** : le décret BACS impose des **fonctions** (art. R. 175-3 du
CCH), **pas une classe** au sens de la **NF EN ISO 52120-1:2022** (qui remplace l'ancienne EN 15232).
La conformité se juge sur la **présence et l'effectivité des fonctions**, jamais sur la seule classe
ISO. En pratique, ces fonctions correspondent au niveau **classe B**, qui est aussi le niveau financé
par la fiche CEE **BAT-TH-116** : c'est la cible recommandée. La **classe A** est une GTB haute
performance (condition de certaines primes CEE).

---

## 4. Étape 1 — Test d'assujettissement (exemple)

| Question | Réponse (exemple) |
|---|---|
| Bâtiment à usage tertiaire ? | ✅ Oui (bureaux) |
| Équipé de chauffage et/ou climatisation ? | ✅ Oui (chaud + froid) |
| Puissance cumulée des systèmes concernés | **350 + 180 = 530 kW** |
| Seuil franchi | **> 290 kW** |

**→ Conclusion : bâtiment assujetti, échéance applicable = 1ᵉʳ janvier 2025 (déjà dépassée).**
Le bâtiment est donc **en situation de non-conformité de calendrier** : mise en conformité à engager sans délai.

> Note de méthode : si le cumul avait été, par exemple, de 120 kW, l'assujettissement tiendrait toujours
> (> 70 kW) mais l'échéance serait le **1ᵉʳ janvier 2030** (report du décret 2025-1343).

---

## 5. Étape 2 — État des lieux du système existant (exemple)

| Point examiné | Constat (exemple) |
|---|---|
| GTB / régulation en place | Régulateurs de chaufferie autonomes + horloges ; pas de superviseur centralisé |
| Comptage énergétique | Compteur gaz général uniquement ; aucun sous-comptage par usage |
| Suivi des consommations | Relevés manuels mensuels, pas d'historisation continue |
| Interopérabilité | Aucune (systèmes îlotés, protocoles propriétaires non interconnectés) |
| Alertes / détection de dérive | Inexistantes |
| Classe NF EN ISO 52120-1 estimée | **Classe C / D** (fonctions de base, pas d'analyse continue) |

---

## 6. Étape 3 — Grille de conformité (fonctions exigées par R. 175-3)

Synthèse des principales fonctions exigées (telles que décrites par le portail réglementaire
gouvernemental — § 9), confrontées à l'existant :

| Fonction exigée (art. R. 175-3) | Existant | Conforme ? |
|---|---|---|
| Suivre, enregistrer et **analyser en continu** les données de production/consommation, par usage et par zone (pas horaire) | Relevés manuels | ❌ |
| **Conserver** ces données (au pas mensuel) pendant **5 ans** | Non | ❌ |
| **Situer l'efficacité énergétique** et **déceler les pertes** d'efficacité des systèmes techniques | Non | ❌ |
| Permettre l'**arrêt manuel** et la **gestion automatique** des systèmes techniques | Partiel (horloges) | ⚠️ |
| Assurer l'**interopérabilité** entre systèmes techniques | Non | ❌ |
| **Alerter** la personne en charge en cas de dérive / dysfonctionnement | Non | ❌ |

> **Sur la classe — précision** : « atteindre une classe A ou B » n'est **pas** une fonction de
> l'article R. 175-3 ; ce n'est donc pas une ligne de cette grille. Le décret impose les **fonctions**
> ci-dessus. La classe (ici estimée **C/D**) n'est qu'un **indicateur** du niveau fonctionnel ; la
> **classe B** est la traduction pratique de ces fonctions et la condition de la prime CEE (fiche BAT-TH-116).

**Avis de conformité : NON CONFORME.** La non-conformité tient à l'**absence des fonctions** exigées
par R. 175-3 (analyse continue, conservation 5 ans, interopérabilité, alertes…), **pas** au niveau de
classe : le bâtiment dispose d'une régulation locale mais pas d'un système d'automatisation et de
contrôle au sens du décret.

---

## 7. Étape 4 — Plan de mise en conformité (exemple)

| Priorité | Action | Objectif visé |
|---|---|---|
| P1 | Déployer un **superviseur GTB** central interopérable (protocole ouvert : BACnet/Modbus/KNX) | Interopérabilité + pilotage |
| P1 | Mettre en place le **sous-comptage** par usage (chaud, froid, ventilation, élec.) | Suivi continu R. 175-3 |
| P2 | Historisation + tableau de bord avec **détection automatique de dérives** et alertes | Analyse + alertes |
| P2 | Régulation automatique des systèmes CVC (programmation, optimisation) | Montée en **classe B** |
| P3 | Documentation, analyse fonctionnelle, formation de l'exploitant | Pré-requis inspection |

**Cible recommandée** : le niveau **classe B** NF EN ISO 52120-1:2022 — c'est le niveau qui permet de
remplir les fonctions R. 175-3 et qui est financé par les CEE (la conformité reste jugée sur les
fonctions, pas sur la classe) ; la classe A étant un sur-investissement à arbitrer selon le ROI.

> Posture NeoGTB : ce plan est **neutre** (aucun fabricant imposé). Le cahier des charges et le
> comparatif de solutions se font côté maître d'ouvrage — voir l'offre « Cadrage » et les outils
> `/comparateur` et `/audit`.

---

## 8. Étape 5 — Volet inspection périodique (art. R. 175-5-1)

Obligation **récurrente**, distincte de l'installation :

| Élément | Exigence vérifiée |
|---|---|
| Périodicité | **Tous les 5 ans** (ramenée à **2 ans** après une installation ou un remplacement) |
| Inspecteur | **Tiers indépendant et compétent** (pas le fabricant du système) |
| Contenu | Analyse fonctionnelle (1ʳᵉ inspection), vérification du bon fonctionnement, évaluation du respect de R. 175-3, évaluation du paramétrage vs usage réel, recommandations |
| Conservation du rapport | **10 ans** par le propriétaire |
| Obligation annexe | Le propriétaire veille à ce que **l'exploitant soit formé** au fonctionnement du système |

> L'indépendance vis-à-vis du fabricant fait de l'inspection périodique un terrain naturel pour NeoGTB.

---

## 9. Sources (vérifiées le 2026-06-15)

- [Légifrance — Décret n° 2023-259 du 7 avril 2023](https://www.legifrance.gouv.fr/jorf/id/JORFTEXT000047422489) — texte modificatif, seuil 70 kW, échéances, articles R. 175-1 à R. 175-6.
- [Légifrance — Décret n° 2025-1343 du 26 décembre 2025](https://www.legifrance.gouv.fr/jorf/id/JORFTEXT000053175245) — report de l'échéance 70–290 kW (existants) de 2027 à 2030.
- [Portail réglementaire bâtiment (developpement-durable.gouv.fr) — Présentation et guide du décret BACS](https://rt-re-batiment.developpement-durable.gouv.fr/presentation-et-guide-du-decret-bacs-a712.html) — guide officiel.
- [Veille réglementaire QSE — Décret BACS](https://www.qse-veille.fr/veille-reglementaire-environnement/decret-bacs) — détail inspection périodique (R. 175-5-1), conservation 10 ans, exemptions.
- [Cegibat (GRDF) — Décret BACS, obligations des bâtiments tertiaires](https://cegibat.grdf.fr/reglementation/energetique/decret-bacs-obligations-batiments-tertiaires) — classe A ou B, NF EN ISO 52120-1:2022.
- [SERCE — Décret 2023-259 (PDF)](https://serce.fr/wp-content/uploads/doc_premium/Decret-2023-259-du-7-avril-2023-relatif-aux-systemes-dautomatisation-et-de-controle-des-batiments-tertiaires-BACS.pdf) — reproduction du décret.

> **À confirmer / approfondir avant usage client** : la rédaction *littérale* de l'article R. 175-3
> (liste exacte des fonctions) gagnera à être recopiée depuis Légifrance plutôt que paraphrasée.
> Les exemptions (démolition/désaffectation à court terme, non-rentabilité ROI > 10 ans,
> incompatibilité technique) doivent être vérifiées au cas par cas avec le texte codifié.

---

## 10. Cas d'exemption (à vérifier au cas par cas)

Le décret prévoit des situations de non-application / exemption, notamment :
- bâtiment voué à la **démolition** ou à la **désaffectation à court terme** ;
- **non-rentabilité** de l'installation (analyse coûts-bénéfices démontrant un ROI > 10 ans) ;
- **incompatibilité technique ou fonctionnelle** avérée avec les systèmes existants.

Chaque exemption doit être **justifiée et documentée** par le propriétaire.
