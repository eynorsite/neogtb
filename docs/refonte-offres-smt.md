# Refonte « 3 offres + simplicité » — inspirée de smt-en.com

> Objectif : reprendre la **simplicité** et la **structure en 3 offres** de smt-en.com,
> **sans dark mode** et **sans abandonner** le positionnement « tiers de confiance indépendant ».
> Source de l'audit : DOM réel de smt-en.com extrait le 2026-06-15 + cartographie front NeoGTB.

---

## 0. Décision de positionnement (actée)

**Option retenue : tiers de confiance + 3 offres de conseil indépendant.**

- On garde le socle : *« 100 % indépendant · 0 matériel vendu · 0 commission »* (badge visible).
- Les 3 offres sont de l'**accompagnement / AMO côté maître d'ouvrage** : aucune vente de matériel.
- Différenciateur vs smt-en.com : *« on est de VOTRE côté, pas celui de l'installateur ni du fabricant »*.

Pourquoi pas le pivot commercial : SMT est un bureau d'études parmi d'autres ; l'indépendance
est le seul angle que NeoGTB possède et que SMT n'a pas. Le pivot détruirait cet actif.

---

## 1. Les 3 offres (à valider par Ulrich)

Structure calquée sur la logique « par phase de projet » de SMT (Initial / 360 / Final),
mais reformulée en posture indépendante.

> ⚠️ À confirmer par Ulrich (je ne l'invente pas) : le **périmètre exact**, les **délais**,
> et le **modèle de prix** (gratuit / forfait / sur devis). Les contenus ci-dessous sont une
> proposition rédactionnelle prête à l'emploi, pas une donnée.

### Offre 1 — Diagnostic
- **Promesse** : « Savoir où vous en êtes. »
- **Pour qui** : propriétaire / gestionnaire qui ignore s'il est concerné par le décret BACS.
- **Contenu** :
  - Pré-diagnostic GTB ISO 52120-1 (outil existant `/audit`)
  - Rapport de maturité technique
  - Estimation des primes CEE (outil existant `/generateur-cee`)
  - Lecture de l'éligibilité au décret BACS
- **Modèle suggéré** : **gratuit** (porte d'entrée / génération de leads).
- **CTA** : « Lancer mon diagnostic »

### Offre 2 — Cadrage
- **Promesse** : « Lancer votre projet sur des bases neutres. »
- **Pour qui** : maître d'ouvrage qui va lancer une consultation ou un projet GTB.
- **Contenu** :
  - Cahier des charges neutre (non orienté fabricant)
  - Comparatif objectif des solutions adaptées (outil existant `/comparateur`)
  - Chiffrage CEE et retour sur investissement
  - Recommandations d'architecture / protocoles
- **Modèle suggéré** : forfait ou sur devis (à définir).
- **CTA** : « Cadrer mon projet »

### Offre 3 — Accompagnement (AMO indépendante)
- **Promesse** : « Sécuriser jusqu'à la conformité. »
- **Pour qui** : maître d'ouvrage en cours ou en fin de projet.
- **Contenu** :
  - AMO indépendante côté maître d'ouvrage
  - Contrôle de conformité décret BACS
  - Vérification des installations livrées + accompagnement à la réception
  - Montage du dossier CEE
- **Modèle suggéré** : sur devis (réponse sous 48 h — comme SMT, si tenable).
- **CTA** : « Être accompagné »

---

## 2. Simplifier la navigation (le gros levier de simplicité)

SMT = 4 liens. NeoGTB = mega-menu 3 colonnes + ~10 entrées. À réduire.

**Header cible :**

```
Accueil · Offres · Ressources ▾ · À propos · Contact      [☎ tél] [Parler à un expert]
```

- **Ressources ▾** (menu léger, pas mega) regroupe l'actif SEO existant :
  GTB, GTC, Réglementation, Solutions, Comparateur, Tables Modbus, Générateur CEE, Blog.
- **CTA unique** partout : « Parler à un expert » → `/contact`.
- **Téléphone cliquable** dans le header → SEULEMENT si NeoGTB a un numéro public
  (à confirmer — ne pas inventer). Sinon, garder uniquement le CTA.

> Important : on NE supprime AUCUNE page. Les 22 pages sont un actif SEO que SMT n'a pas.
> On les range sous « Ressources » et on désencombre juste la barre principale.

---

## 3. Home : hero plus tranchant

Reprendre le principe SMT « une phrase choc + une stat », avec les chiffres DÉJÀ présents
sur le site (40 % d'économies, décret BACS) — rien d'inventé.

Proposition d'accroche :

> **Le décret BACS rend la GTB obligatoire. Jusqu'à 40 % d'économies d'énergie à la clé.**
> Nous vous aidons à comprendre, comparer et décider — sans rien vous vendre.

Conserver les 4 chiffres existants (40 % · 6 Md€ · 500k bâtiments · calendrier décret).

---

## 4. À NE PAS copier de smt-en.com (défauts réels constatés)

- ❌ Titres animés **lettre par lettre** (chaque lettre dans un `<span>`) → catastrophe SEO + accessibilité.
- ❌ Compteurs figés à « +0 » / « Audit validé 0 % » (animation au scroll mal gérée).
- ❌ Footer cassé : liens sociaux tous vers LinkedIn, libellés incohérents, accents manquants.
- ❌ Le dark mode (choix assumé : le light bleu/vert est plus crédible en B2B).

NeoGTB conserve ses atouts qui dépassent déjà SMT : Plausible (0 cookie), CSP stricte,
JSON-LD, lazy-loading, `h1` propres, A11y (`aria-current`, focus trap).

---

## 5. Plan d'implémentation (ordre conseillé)

1. **Page `/offres`** : créer `SitePage` + brique `cartes` 3 colonnes (composant déjà utilisé
   en brique 2 de l'accueil). Contenu = les 3 offres ci-dessus.
2. **Ajouter « Offres »** dans le header.
3. **Simplifier le header** : mega-menu → 4-5 liens + 1 CTA (+ tél si dispo).
   Fichier : `admin/resources/views/front/partials/header-nav.blade.php`.
4. **Unifier les CTA** du site sur « Parler à un expert ».
5. **Retoucher le hero** de l'accueil (brique `hero` en base, éditable Filament).
6. `sudo -u www-data php artisan cache:clear` (cache front 1 h).

Étapes 1 et 6 = sans code (admin Filament). Étapes 2-5 = 1 fichier Blade + contenu en base.

---

## 6. Ce que j'attends d'Ulrich pour démarrer l'implémentation

1. Validation / ajustement du **périmètre** des 3 offres (section 1).
2. **Modèle de prix** par offre (gratuit / forfait / sur devis).
3. **Téléphone public** à afficher dans le header — ou non.
4. Feu vert sur l'**accroche du hero** (section 3).
