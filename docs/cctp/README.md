# Suite « Consultation & Audit GTB » — vendor-neutral

Boîte à outils NeoGTB pour la **Gestion Technique du Bâtiment (GTB/GTC)** : pièces de consultation et méthodologie d'audit, **n'avantageant aucune marque ni protocole**, tous types de bâtiment, lots **CVC + éclairage (DALI) + comptage + supervision**.

Tout repose sur la règle **zéro invention** : chaque fait réglementaire/normatif est sourcé et qualifié par un **statut** dans [C0_sources-et-statuts.md](C0_sources-et-statuts.md).

---

## Deux offres distinctes

| | **A — Kit Consultation GTB** | **B — Audit & AMO classification** |
|---|---|---|
| Nature | **Template** à instancier (modèle vendable / réutilisable) | **Prestation** NeoGTB, posture *tiers de confiance* |
| Pour qui | MOA ou son AMO qui rédige sa consultation | MOA qui veut situer/mettre en conformité son bâtiment |
| Engagement | Le MOA reste responsable de l'adaptation | NeoGTB signe, avec clause de responsabilité (B4) |
| Neutralité | Exigences fonctionnelles + anti-verrouillage | **0 matériel vendu, 0 commission, indépendant du fabricant** |

---

## Les pièces

### Bloc A — Kit Consultation GTB
| Réf. | Pièce | Fichier | Rôle |
|---|---|---|---|
| **A1** | CCTP technique | [CCTP-GTB-multiprotocole-vendor-neutral.md](CCTP-GTB-multiprotocole-vendor-neutral.md) | Exigences **techniques** (objet, fonctions, protocoles, recette). |
| **A2** | CCAP — clauses | [A2_CCAP-clauses-GTB.md](A2_CCAP-clauses-GTB.md) | Clauses **administratives** : propriété données, PI, réversibilité, licences, pénalités, dérogations CCAG. |
| **A3** | Cadre liste de points | [A3_cadre-liste-de-points.md](A3_cadre-liste-de-points.md) | Data points pré-remplis par lot, à adapter. |
| **A4** | Cadre BPU / DPGF | [A4_cadre-BPU-DPGF.md](A4_cadre-BPU-DPGF.md) | Décomposition de prix imposée → rend le **TCO comparable**. |
| **A5** | Cadre mémoire technique | [A5_cadre-memoire-technique.md](A5_cadre-memoire-technique.md) | Ce que le **candidat** doit produire pour être noté objectivement. |
| **A6** | Grille de dépouillement | [grille-depouillement-GTB.md](grille-depouillement-GTB.md) | Critères objectifs, barèmes, méthode de notation. |
| **A7** | Notice d'usage MOA | [A7_notice-usage-MOA.md](A7_notice-usage-MOA.md) | Comment instancier la suite + **check-list avant diffusion** + gating. |

### Bloc B — Audit & AMO classification
| Réf. | Pièce | Fichier | Rôle |
|---|---|---|---|
| **B1** | Méthodologie d'audit | [B1_methodologie-audit-classification.md](B1_methodologie-audit-classification.md) | Assujettissement → fonctions R.175-3 → classe 52120-1 (Method 1/2) → **3 états d'effectivité** + **intrusion** → gains en fourchette. |
| **B2** | Trame de rapport d'audit | [../exemple-audit-conformite-bacs.md](../exemple-audit-conformite-bacs.md) | Exemple de rapport (bâtiment fictif), corrigé. |
| **B3** | Grille fonctions 52120 | [B3_grille-fonctions-52120.md](B3_grille-fonctions-52120.md) | Squelette des 7 sections (détail normatif = Phase 2, texte AFNOR). |
| **B4** | Clause responsabilité / périmètre | [B4_clause-responsabilite-perimetre.md](B4_clause-responsabilite-perimetre.md) | Projet de clause — **à faire viser par un avocat**. |

### Bloc C — Socle commun
| Réf. | Pièce | Fichier | Rôle |
|---|---|---|---|
| **C0** | Sources et statuts | [C0_sources-et-statuts.md](C0_sources-et-statuts.md) | Référence unique des faits sourcés + légende des statuts. **Fait foi.** |

---

## Lead magnet public (freebie)
La page front `/decret-bacs/modele-cctp` et le fichier Word `modele-cctp-decret-bacs-neogtb.docx` sont une **version grand public simplifiée**, générée à partir de **A1 + A6**. Le fichier [CCTP-GTB-vendor-neutral.html](CCTP-GTB-vendor-neutral.html) en est la version imprimable (A1 + A6 réunis). Ne pas confondre avec la suite professionnelle complète ci-dessus.

## Produire une version Word / PDF
Aucun convertisseur installé sur ce poste. Pour une pièce donnée : ouvrir le `.md` dans un éditeur Markdown, ou le `.html` (A1+A6) dans un navigateur → *Imprimer → PDF*, ou dans Word. Pour un `.docx` fidèle : installer `pandoc` puis `pandoc <fichier>.md -o <fichier>.docx`.

## Avant de diffuser
Suivre **[A7_notice-usage-MOA.md](A7_notice-usage-MOA.md)** : renseigner les `[À COMPLÉTER]`, choisir les blocs `🔀 OPTION`, traiter la check-list, et respecter le **gating** :
1. **Usage interne** tant que les `[À COMPLÉTER]` ne sont pas traités.
2. **Livrable client « à adapter »** une fois les pièces complétées.
3. **Pièce opposable** seulement après : texte AFNOR NF EN ISO 52120-1:2022 acquis + R.175-3 recopié depuis Légifrance + clause B4 visée par un avocat (voir [C0 §4](C0_sources-et-statuts.md)).

---

## Historique
- **2026-06-18** — Restructuration en suite A/B/C (séparation CCTP/CCAP, cadres BPU-DPGF / liste de points / mémoire technique, méthodologie d'audit avec 3 états d'effectivité + intrusion, socle C0). Correction de la pièce B2 (classe ≠ conformité). Ajout des légendes de statuts.
