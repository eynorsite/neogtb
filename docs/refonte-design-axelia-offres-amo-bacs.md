# Refonte NeoGTB — Design « axelia », 2 offres, AMO GTB/GTC & page Décret BACS

> Livrable consolidé. Recherche réalisée le 2026-06-15 sur sources réelles (DOM extrait),
> contenus réglementaires alignés sur les faits **déjà publiés par NeoGTB** (cohérence + zéro invention).
> Références visuelles : [docs/refs-design/](refs-design/) (axelia-home, nextiim-bacs, smt-accueil, smt-offres).

Sources d'inspiration par sujet :
- **Offres** → smt-en.com (Initial / 360)
- **AMO GTB/GTC + FAQ** → ef-consulting.com
- **Contenu Décret BACS** → nextiim.com (structure pédagogique)
- **Design global (cible)** → axelia-energie.fr

---

## A. LES 2 OFFRES (renommées « punchy »)

On garde **Initial** + **Offre 360** de smt-en.com (on abandonne le 3ᵉ « Final »), reformulées
en posture **tiers de confiance indépendant** (aucune vente de matériel, aucune commission).

### Offre 1 — ex « Initial »
- **Nom recommandé : « Cap Projet »** _(alternatives : « Tremplin GTB », « Cadrage »)_
- **Accroche** : « Lancez votre projet GTB sur des bases neutres et chiffrées. »
- **Contenu** :
  - Audit de l'existant
  - Estimation budgétaire (CAPEX / OPEX)
  - Rédaction du cahier des charges **neutre** (non orienté fabricant)
  - Analyse fonctionnelle et optimisation de la régulation
- **Idéal pour** : démarrer un projet GTB sans se faire enfermer par un fournisseur.
- **CTA** : « Cadrer mon projet »

### Offre 2 — ex « Offre 360 »
- **Nom recommandé : « Pilotage 360 »** _(alternatives : « Sérénité 360 », « Maîtrise Totale »)_
- **Accroche** : « Votre projet maîtrisé de A à Z, sans conflit d'intérêt. »
- **Contenu** :
  - Audit réglementaire & énergétique
  - Études et chiffrage
  - AMO & suivi opérationnel
  - Réception et **conformité finale (décret BACS)**
- **Idéal pour** : déléguer tout le projet à un expert qui défend VOS intérêts.
- **CTA** : « Être accompagné »

> 💶 À définir par Ulrich (non inventé) : modèle de prix (forfait / sur devis) et délai de réponse.

---

## B. PAGE « AMO GTB/GTC » + FAQ (modèle ef-consulting, version indépendante)

Nouvelle page `/amo-gtb-gtc`. L'AMO est déjà revendiquée par NeoGTB
([about.blade.php:53](admin/resources/views/front/about.blade.php#L53)) → cette page la détaille.

### Structure de la page
1. **Hero** — Titre : « AMO GTB / GTC : sécurisez vos projets de gestion technique du bâtiment »
   Sous-titre : « Une assistance à maîtrise d'ouvrage 100 % indépendante — aucun matériel vendu,
   aucune commission. » + CTA « Parler à un expert ».
2. **Les enjeux** — « Un projet GTB mal cadré, c'est des surcoûts, des dérives et un système
   inexploitable. Notre rôle : éviter ça. »
3. **Notre mission AMO — 4 piliers** :
   - **Analyse de l'existant** : audit des installations CVC, protocoles (BACnet, Modbus, KNX), architecture.
   - **Définition des besoins** : équipements à superviser, fonctions de pilotage, suivi énergétique, interfaces.
   - **Cahier des charges neutre** : exigences de performance, interopérabilité, cybersécurité, exploitation.
   - **Pilotage du projet** : consultation des entreprises, analyse des offres, suivi de mise en œuvre, vérification des performances.
4. **Les 4 étapes clés** :
   1. Définition des besoins et objectifs (périmètre supervision, reporting, interfaces)
   2. État des lieux et diagnostic (équipements, régulation, protocoles, limites)
   3. Planification technique & budgétaire (architecture cible, phasage, CAPEX/OPEX, **CEE BAT-TH-116**)
   4. Cadrage des contrats d'exploitation (responsabilités, KPI, objectifs énergétiques)
5. **FAQ** (voir ci-dessous)
6. **Pourquoi NeoGTB** : encart indépendance (0 matériel, 0 commission, du côté du maître d'ouvrage).
7. **CTA contact**.

### FAQ AMO (8 questions — réponses alignées sur les faits NeoGTB)

**1. Qu'est-ce qu'une mission AMO GTB / GTC ?**
Une Assistance à Maîtrise d'Ouvrage qui accompagne le maître d'ouvrage dans la conception, le
déploiement et l'exploitation de son système de gestion technique, pour garantir une installation
performante, interopérable et conforme.

**2. Pourquoi un AMO *indépendant* pour un projet GTB ?**
Parce qu'un AMO indépendant sécurise les choix techniques sans aucun intérêt à vous vendre une
marque plutôt qu'une autre. Chez NeoGTB, le revenu vient exclusivement du conseil — jamais du
matériel ni de commissions.

**3. Quelle différence entre GTB et GTC ?**
La GTB (Gestion Technique du Bâtiment) supervise l'ensemble des équipements techniques. La GTC
(Gestion Technique Centralisée) désigne un périmètre plus restreint ou spécifique. Les deux sont
aujourd'hui souvent utilisées conjointement. _(cf. pages /gtb et /gtc)_

**4. Quels équipements une GTB peut-elle piloter ?**
Chauffage, ventilation, climatisation (CVC), éclairage, comptage énergétique, sécurité, contrôle
d'accès et autres installations techniques.

**5. Quels bénéfices d'une GTB performante ?**
Selon la norme NF EN ISO 52120-1 : jusqu'à ~35 % d'économies en passant d'une classe D à une
classe A (≈10 % pour D→C, ≈25 % pour D→B). Plus de confort, maintenance anticipée, dérives détectées.

**6. L'AMO NeoGTB est-elle vraiment indépendante ?**
Oui. Aucune vente de matériel, aucun partenariat commercial avec un fabricant, aucune commission.
C'est notre différence avec un bureau d'études classique.

**7. Quelles obligations réglementaires liées à la GTB ?**
Le **décret BACS** impose une GTB de **classe B minimum** : obligatoire depuis le **1er janvier 2025**
pour les bâtiments tertiaires > 290 kW, et au **1er janvier 2030** pour ceux entre 70 et 290 kW.
Le **décret tertiaire** impose -40 % (2030), -50 % (2040), -60 % (2050).

**8. À quel moment faire intervenir un AMO ?**
Idéalement dès les premières phases du projet — mais aussi en cours de route pour corriger,
optimiser ou valider la conformité d'une installation existante.

---

## C. PAGE « DÉCRET BACS » refaite (contenu nextiim + faits NeoGTB + design axelia)

Nouvelle page dédiée `/decret-bacs` (SEO : nextiim et axelia ont toutes deux une page dédiée).
**Tous les chiffres ci-dessous proviennent de [reglementation.blade.php](admin/resources/views/front/reglementation.blade.php) — vérifiés.**

### Structure
1. **Hero** (image bâtiment, overlay sombre façon axelia/nextiim)
   Titre : « Décret BACS : rendez votre bâtiment conforme »
   Intro : « Le décret BACS impose une GTB pour automatiser et piloter les consommations des
   bâtiments tertiaires. On vous dit qui est concerné, à quelle échéance, et comment vous mettre en règle. »

2. **Comprendre le décret BACS**
   - **Qu'est-ce que le décret BACS ?** Décret n° 2020-887 du 20 juillet 2020 (transposition de la
     directive EPBD 2018/844), modifié par le décret n° 2025-1343 du 26 décembre 2025. Il impose une
     GTB (Building Automation & Control Systems) de **classe B minimum** (norme NF EN ISO 52120-1).
   - **Objectifs** : suivre/enregistrer/analyser les consommations · piloter en temps réel selon les
     besoins · détecter les dérives et alerter avant la panne.
   - **Bâtiments concernés** (puissance CVC cumulée) :
     - **> 290 kW (existant)** → obligatoire **depuis le 1er janvier 2025**
     - **70–290 kW (existant)** → **1er janvier 2030** (report)
     - **Neuf > 290 kW** (permis > 21/07/2021) → à la construction
     - **Neuf > 70 kW** (permis > 08/04/2024) → à la construction
   - **Exception (dérogation)** : possible si un audit énergétique démontre un temps de retour sur
     investissement **supérieur à 6 ans** (source vérifiée : [reglementation.blade.php:149](admin/resources/views/front/reglementation.blade.php#L149) — PAS « 10 ans », erreur recopiée de nextiim).

3. **Les classes GTB (NF EN ISO 52120-1)** — tableau :
   | Classe | Niveau | Économies (vs D) |
   |---|---|---|
   | **A** | Haute perf. (régulation pièce par pièce, optimisation multi-lots) | ~35 % |
   | **B** | Avancé (GTB centralisée, suivi énergétique, détection de dérives) — **seuil décret** | ~25 % |
   | **C** | Standard (régulation de base + programmation horaire) | ~10 % |
   | **D** | Non performant, aucune automatisation | — |

4. **Notre accompagnement (Audit Décret BACS)** — étapes (façon nextiim) :
   Collecte des données → entretien exploitant → visite des installations → analyse → **livrable d'audit**
   + préconisations techniques/budgétaires + estimation des **CEE (BAT-TH-116)**.

5. **CEE** : la fiche **BAT-TH-116** finance une GTB classe A ou B (complément BAT-TH-112).

6. **FAQ courte** (3–4 Q : « suis-je concerné ? », « quelle classe ? », « combien ça coûte / quels CEE ? »,
   « que risque-t-on ? » → amende décret tertiaire jusqu'à 7 500 €).

7. **CTA** : « Vérifier ma conformité » → `/audit` (ton outil de pré-diagnostic existant).

---

## D. DESIGN « AXELIA » : plan d'implémentation

Axelia = **light mode**, vert émeraude sur blanc, **sections bleu nuit en alternance**, images
fortes, méthodo numérotée, stats, grille secteurs, animations au scroll. Tes tokens collent déjà :
accent `#2D8B4E` (≈ émeraude axelia), primary `#1B3A5C` (≈ bleu nuit des sections sombres).

### Ce qui est DÉJÀ faisable sans coder (composition de briques en admin Filament)
| Section axelia | Brique NeoGTB existante |
|---|---|
| Hero image + titre + 2 CTA | `hero` |
| Bandeau de stats | `chiffres` |
| Grille d'expertises / offres | `cartes` |
| Méthodologie 4 étapes numérotées | `methodologie` |
| 2 cartes réglementation | `cartes` ou `comparatif` |
| Bénéfices « pourquoi nous » | `cartes` + `comparatif` |
| Grille secteurs | `cartes` |
| Section CTA fond sombre | `cta` |
| Logos / réassurance | `logos` |

### Les 2 SEULES vraies évolutions de code à prévoir
1. **Carte avec image d'en-tête** (le look « expertise » d'axelia) : ajouter un paramètre `image`
   optionnel à [bricks/cartes.blade.php](admin/resources/views/front/bricks/cartes.blade.php)
   → photo `h-40 object-cover rounded-t` au-dessus de l'icône/titre/liste. ~10 lignes.
2. **Hero « images circulaires flottantes »** : nouvelle classe CSS (`.hero-orbs` : 3-4 `rounded-full`
   en `position:absolute` + ombre douce + `animate-float` déjà existant), branchée dans `hero`.
   Réutilise les `hero-*.webp` existants recadrés en rond.

### Détails « finition » à reprendre d'axelia
- Petite **ligne de réassurance** sous le hero (badges) : « Indépendant · 0 commission · ISO 52120-1 · 0 cookie ».
- **Alternance** fond blanc / fond `primary-900` entre sections (rythme visuel axelia).
- **Téléphone cliquable** dans le header (axelia, smt et ef-consulting le font tous) — si numéro public dispo.
- Animations : `animate-fade-in-up` (déjà là) sur chaque section au scroll.

### Nouvel ordre de la page d'accueil (calqué axelia)
1. Hero (orbs + image, h1, 2 CTA, ligne réassurance)
2. Stats (`chiffres`)
3. Offres & outils (`cartes` avec images) : **Cap Projet · Pilotage 360 · AMO GTB/GTC** + Diagnostic / Comparateur / CEE
4. Méthodologie 4 étapes (`methodologie`)
5. Réglementations : 2 cartes → `/decret-bacs` & décret tertiaire
6. Pourquoi NeoGTB (indépendance, `comparatif`)
7. Secteurs (`cartes`)
8. CTA fond sombre « Parlez-nous de votre projet » + checklist « ce que vous obtenez »
9. Ressources / Blog
10. Footer

---

## E. ORDRE DE RÉALISATION RECOMMANDÉ

1. **Évolutions design** (les 2 changements de code ci-dessus) → débloque le look axelia partout.
2. **Recomposer la home** dans l'ordre axelia (admin Filament, contenu en base).
3. **Page `/decret-bacs`** (contenu prêt section C) → fort SEO, 100 % factuel.
4. **Page `/amo-gtb-gtc` + FAQ** (section B).
5. **Page `/offres`** avec les 2 offres (section A) une fois noms + prix validés par Ulrich.
6. `sudo -u www-data php artisan cache:clear`.

## F. CE QU'IL ME FAUT D'ULRICH POUR LANCER
1. Valider les **noms d'offres** (Cap Projet / Pilotage 360 ou alternatives).
2. **Modèle de prix** des offres.
3. **Téléphone public** à afficher (ou non).
4. Trancher le point réglementaire **classe B vs C** (ton site dit B).
