# B4 — Brief de validation juridique (clause de responsabilité + clauses CCAP)

> **Pour qui** : avocat / juriste en droit des contrats et de la commande publique, mandaté par NeoGTB.
> **Objet** : sécuriser juridiquement (a) la **clause de responsabilité / périmètre** de la prestation d'audit GTB ([B4_clause-responsabilite-perimetre.md](B4_clause-responsabilite-perimetre.md)) et (b) les **clauses administratives** du CCAP type ([A2_CCAP-clauses-GTB.md](A2_CCAP-clauses-GTB.md)).
> **Statut** : document de travail interne. Aucune des formulations ci-dessous ne doit être réputée validée tant que ce brief n'a pas reçu de réponse.

---

## 1. Contexte

NeoGTB intervient en **AMO / audit GTB-GTC** sous une posture de **tiers de confiance indépendant** : **aucun matériel vendu, aucune commission fabricant**. Deux usages des pièces concernées :
- un **modèle de CCAP** type (A2), réutilisable, joint à des consultations de GTB (marchés majoritairement de **travaux**, parfois privés) ;
- une **prestation d'audit de classification / conformité décret BACS** dont le rapport est remis au client, encadrée par la clause B4.

Pièces à examiner (jointes) : **A2** (CCAP clauses), **B4** (clause responsabilité), pour contexte **A1** (CCTP technique), **B1** (méthodologie d'audit), **B2** (`../exemple-audit-conformite-bacs.md`, trame de rapport), **C0** (sources et statuts).

---

## 2. Questions précises à valider

### Sur la prestation d'audit (clause B4)
1. **Nature et portée du rapport** : la formulation « le rapport ne vaut **pas attestation de conformité réglementaire** ni garantie d'économies d'énergie ; il constitue un avis fondé sur les éléments communiqués à une date donnée » est-elle suffisante pour écarter une requalification en obligation de résultat ?
2. **Limitation de responsabilité** : quel plafond et quelles exclusions sont valides et opposables (notamment vis-à-vis d'un client professionnel) ? Une clause limitative est-elle réputée non écrite en cas de faute lourde / manquement à une obligation essentielle ?
3. **Assurance RC professionnelle** : la posture « tiers de confiance / audit » impose-t-elle une couverture spécifique ? Faut-il une mention d'assurance dans la clause ?
4. **Indépendance affichée** (« 0 matériel, 0 commission ») : crée-t-elle un engagement opposable (déclaration d'absence de conflit d'intérêts) ? Risque si un lien commercial existe par ailleurs ?
5. **Données du client** : le rapport s'appuie sur des données communiquées par le client — quelle clause de **non-garantie de l'exactitude des données d'entrée** ?

### Sur le CCAP type (A2)
6. **CCAG applicable** : une GTB relève-t-elle du **CCAG-Travaux** (notre hypothèse), ou TIC / autre selon le montage (lot séparé vs sous-lot courants faibles) ? **Quels sont les articles exacts** du CCAG retenu pour : réception, pénalités, retenue de garantie, parfait achèvement (laissés en `[À COMPLÉTER]` dans A2) ?
7. **Cession des droits de propriété intellectuelle** (A2 art. 3) : la clause de cession exclusive des droits patrimoniaux sur la programmation/configuration est-elle correctement rédigée ? À défaut de cession, le titulaire conserve-t-il la propriété du code source (point que nous affirmons — à confirmer) ? Garantie d'éviction à prévoir ?
8. **Réversibilité portée « en dur »** (A2 art. 4, inspirée de l'art. 38 du CCAG-TIC) : transposer ces obligations dans un marché de **travaux** est-il valide ? Faut-il les inscrire en **dérogations explicites récapitulées** (A2 art. 10) ?
9. **Pénalité spécifique de non-remise du dossier de réversibilité** (codes sources, mots de passe admin, licences) : montant et mécanisme opposables ? Articulation avec la retenue de garantie.
10. **Garanties légales** : lesquelles s'appliquent à une GTB — parfait achèvement, **biennale (bon fonctionnement)**, **décennale** ? La part logicielle/paramétrage est-elle couverte ?
11. **RGPD** (A2 option, art. 2.4) : si le système traite des données personnelles (détection de présence, comptage individualisé par occupant), quelles obligations (responsable de traitement, sous-traitance art. 28) inscrire ?

---

## 3. Livrable attendu de l'avocat
- Pour chaque question : **validation**, **reformulation proposée**, ou **alerte**.
- Les **numéros d'articles exacts** du CCAG retenu à insérer dans A2 (réception, pénalités, retenue, garanties).
- Un avis sur la **qualification Travaux vs TIC** et son impact.
- Le cas échéant, une **clause d'assurance / limitation de responsabilité** type pour B4.

> Une fois ces réponses obtenues, lever les balises **[À VÉRIFIER en droit]** dans A2 et B4, et passer la pièce B4 du statut « projet » à « validée ».
