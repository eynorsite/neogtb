# Lot 4 — Contenu & crédibilité (à coller dans Filament)

> Ces éléments vivent en **base de prod** (éditables dans Filament), pas dans le code git.
> Source : audit qualité du 2026-06-11/12 (agents Prospect, Conformité, Créatif).
> **Objectif central : supprimer toute affirmation invérifiable** — c'est le point qui sabote
> aujourd'hui la confiance, alors que l'honnêteté est l'argument de vente n°1 du site.

---

## 0. Arbitrages — STATUT (tranchés le 2026-06-12)

1. ✅ **TRANCHÉ — Compteurs « 340+ / 1 200+ / 2,4 M€ »** : confirmés **inventés / invérifiables**
   → **RETIRER** entièrement et remplacer par le bloc « 4 piliers de confiance » (§3).
2. ✅ **TRANCHÉ — 2 « retours d'expérience » (-23 % / -35 %)** : confirmés **illustratifs**
   → **PRÉFIXER « Scénario-type illustratif »** (ne plus les présenter comme des cas réels).
3. ✅ **TRANCHÉ — « 23 % »** : c'est un coefficient de barème (`audit.blade.php:994`), pas une
   moyenne client → **reformuler en potentiel normatif** (§2, label réécrit).
4. ✅ **TRANCHÉ (2026-06-15) — Prix** : Audit sur site **700 € HT** (affiché en prod sur /audit), CCTP et AMO **sur devis** (mention en prod).
5. ⏳ Délais (3-4 sem. / 3-5 sem.) : indicatifs, non affichés sur le site à ce jour.

---

## 1. Page COOKIES — corriger le mensonge sur Plausible (CRITIQUE conformité)

**Problème** : le texte (`legalText('cookies')` en base) affirme « aucun cookie de mesure d'audience
actif » alors que Plausible tourne sur 100 % des pages. Un vendeur de conformité ne peut pas se le permettre.

**Texte de remplacement (section mesure d'audience)** :

> **Mesure d'audience.** Nous utilisons Plausible Analytics, une solution **sans cookie** et **sans
> traceur publicitaire**, dont les données sont **hébergées dans l'Union européenne**. Aucune donnée
> personnelle identifiante n'est collectée et aucun profil n'est constitué. Conformément à la
> recommandation de la CNIL, cette mesure d'audience est **exemptée de consentement**. Vous n'avez
> donc aucune bannière à accepter pour que votre visite reste anonyme.

---

## 2. HERO — 2 variantes (champ `HomePageSeeder.php` brick 1)

### Variante 1 — « le problème, sans détour » (proche du ton actuel)
- **Badge** : `Décret BACS 2030 · Êtes-vous en conformité ?`
- **Titre** : `Votre bâtiment consomme trop. On vous montre où, et pourquoi — sans rien vous vendre.`
- **Sous-titre** : `Pré-diagnostic gratuit basé sur la norme ISO 52120-1, comparateur de solutions sans aucun lien fabricant. Vous repartez avec un rapport clair. Pas avec un devis déguisé.`
- **CTA 1** : `Évaluer mon bâtiment (3 min)` · **CTA 2** : `Comparer les solutions GTB`

### Variante 2 — « l'angle indépendance » (plus différenciant)
- **Badge** : `Conseil GTB indépendant · 0 € de commission fabricant`
- **Titre** : `Le seul avis GTB qui ne vous vend rien.`
- **Sous-titre** : `Ceux qui vous conseillent en GTB sont souvent ceux qui vous la vendent. NeoGTB fait l'inverse : pré-diagnostic ISO 52120-1 gratuit, comparateur neutre, et un expert qui ne touche aucune commission. Jamais.`
- **CTA 1** : `Lancer mon pré-diagnostic gratuit` · **CTA 2** : `Voir notre charte d'indépendance` (→ /about)

### Stat hero (remplacer le « 23 % » par du 100 % vérifiable)
- `A → B` — `niveau ISO 52120-1 visé par le décret BACS`
- `10+` — `fabricants évalués sans lien commercial`
- `0 €` — `commission fabricant, jamais`

> Si le 23 % est sourçable : le garder mais reformuler le label en
> `d'économies CVC visées (potentiel ISO 52120-1, D→B)` au lieu de « identifient en moyenne ».

---

## 3. BLOC CRÉDIBILITÉ — remplace les faux compteurs (brick `cta-counter`)

**Eyebrow** : `Pourquoi nous faire confiance (sans témoignages bidon)`
**Titre** : `NeoGTB est un projet récent. Voici ce qui le rend crédible quand même.`
**Sous-titre** : `Pas de logos clients empruntés, pas d'avis inventés. À la place, quatre choses que vous pouvez vérifier vous-même, tout de suite.`

1. **Indépendance prouvée, pas promise** — `0 € de commission, aucun partenariat fabricant, aucune affiliation. Notre seul revenu vient du conseil que vous payez — donc notre seul intérêt, c'est que VOUS preniez la bonne décision. Charte d'indépendance publique en 5 points.`
2. **Une méthode normée, pas une opinion** — `Chaque évaluation s'appuie sur la norme NF EN ISO 52120-1:2022 (ex-EN 15232) et les données publiques ADEME / OID / OPERAT. Nos critères sont affichés, vérifiables, et identiques pour tous les bâtiments.`
3. **15+ ans de terrain CVC** — `NeoGTB est porté par Ulrich Calmo (structure EYNOR, près de Bordeaux) : +15 ans en CVC et efficacité énergétique tertiaire, formateur habilité. Profil LinkedIn public, parcours vérifiable.`
4. **L'outil gratuit est la démonstration** — `Notre pré-diagnostic ISO 52120-1 calcule votre classe A→D, votre benchmark énergétique et vos pistes CEE — gratuitement, sans inscription, sans relance. Si l'outil est rigoureux, imaginez l'audit.`

**Bandeau de transparence** : `Les premiers retours clients seront publiés ici dès qu'ils seront réels et vérifiables. En attendant, on préfère le vide à l'invention.`

---

## 4. OFFRE PAYANTE — 3 formules (résout l'opacité)

> ✅ **Prix tranchés (2026-06-15), déjà en prod sur /audit** : Audit sur site = **700 € HT** ; CCTP et AMO = **sur devis**.

### Formule 1 — Audit GTB sur site
- **Pour qui** : gestionnaire/propriétaire qui doit objectiver l'état réel avant d'investir (conformité BACS).
- **Inclus** : visite + relevé des lots techniques · classification ISO 52120-1 vérifiée sur site ·
  plan d'actions chiffré et priorisé · estimation CEE (BAT-TH-116 / 112) · point de conformité BACS.
- **Livrable** : rapport 20+ pages + restitution commentée. **Délai** : 3-4 semaines (indicatif).
- **Prix** : **700 € HT** — ✅ affiché en prod sur /audit.

### Formule 2 — Cahier des charges GTB neutre
- **Pour qui** : maître d'ouvrage qui veut un CCTP qui n'avantage aucune marque ni protocole.
- **Inclus** : expression de besoin fonctionnelle · specs ouvertes multi-protocoles (BACnet/KNX/Modbus/DALI) ·
  critères d'évaluation objectifs · exigences d'interopérabilité (anti-verrouillage).
- **Livrable** : CCTP prêt à diffuser + grille de dépouillement. **Délai** : 3-5 semaines (indicatif).
- **Prix** : **Sur devis** — ✅ mention en prod sur /audit.

### Formule 3 — AMO GTB (accompagnement complet)
- **Pour qui** : gestionnaire multi-sites ou projet d'envergure, accompagné de bout en bout.
- **Inclus** : phases 1-4 de la méthode NeoGTB · assistance choix intégrateur + dépouillement ·
  suivi de chantier + recette technique · transfert de compétences aux équipes d'exploitation.
- **Livrable** : mission par lots, CR d'étape, recette documentée. **Délai** : durée du projet.
- **Prix** : `sur devis` — critères affichés : nb de sites, surface, nb de lots, durée, niveau ISO visé.

**Garantie transversale (sous les 3)** : `Sur chaque mission : 0 € de commission fabricant, méthode ISO 52120-1, livrable et délai écrits dans le devis.`

> **Décision produit** : garder le comparatif 2 colonnes (Gratuit vs Audit sur site) sur `/audit`,
> et placer les 3 formules complètes sur une page `/offre` dédiée. Le bouton premium de `/audit`
> pointerait alors vers `/offre` plutôt que `/contact`.

---

## 5. Quick wins copy

- **Réassurance email (gate PDF de l'audit)** : `Votre email sert uniquement à vous envoyer votre rapport. Aucune revente, aucune liste, aucune relance commerciale automatique. Donnée supprimable sur simple demande à hello@neogtb.fr.`
- **CTA sticky** : `Pré-diagnostic GTB gratuit · 3 min · sans inscription` → bouton `Évaluer mon bâtiment`.
- **Objection-killer (« c'est gratuit, où est le piège ? »)** : `Aucun. Les outils sont gratuits parce qu'ils démontrent notre méthode. Si vous avez besoin d'aller plus loin, vous payez un conseil — pas une commission cachée.`
