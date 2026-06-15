# Recherche approfondie multi-agents — NeoGTB vs 4 concurrents GTB

> Produit par 22 agents (5 cibles × 4 angles Design/Contenu/UX/SEO + synthèse + critique adversariale).
> Run : workflow `recherche-multi-agents-neogtb`, 2026-06-15. Sources : axelia-energie.fr, nextiim.com,
> ef-consulting.com, smt-en.com, et le code front NeoGTB. Captures : [docs/refs-design/](refs-design/).
>
> ⚠️ **À LIRE EN PREMIER : la section « CRITIQUE ADVERSARIALE » en bas.** Elle liste les 5 bloquants
> à régler AVANT toute mise en production (faits réglementaires à reverifier, chiffres non sourcés à
> retirer, contradictions de design à trancher). Le rapport de synthèse pèche par endroits du même
> travers qu'il dénonce (chiffres non revérifiés) — la critique le corrige.

---

# PARTIE 1 — RAPPORT DE SYNTHÈSE

*Sources : 20 analyses (axelia, nextiim, ef-consulting, smt-en, neogtb) × 4 angles. Cible : se rapprocher
du design d'axelia (light mode, bleu nuit + vert d'action), 2 offres + page AMO GTB/GTC + page Décret BACS.*

## 1. Synthèse exécutive

1. **NeoGTB a déjà le socle technique le plus solide du panel — un avantage à défendre, pas à refaire.**
   Rendu serveur Blade (vs SPA React d'axelia/nextiim qui canonicalisent toutes leurs sous-pages vers la
   home), sitemap dynamique, robots.txt autorisant 11 bots IA + llms.txt, Plausible cookieless, a11y /audit
   100/100 et CLS 0, palette et keyframes déjà dans `app.css`. **Le gain visé est purement
   design/contenu/conversion, atteignable à ~95 % en CSS + composition de briques, sans migrer de stack.**

2. **Le trou de conversion n°1 : pas de /offres, pas de /amo-gtb-gtc, pas de /decret-bacs.** Les 4
   concurrents ont une page dédiée par intention de recherche. NeoGTB dilue le décret BACS dans une page
   /reglementation fourre-tout et n'a aucune URL exact-match sur LE mot-clé transactionnel du secteur. Les
   contenus de ces 3 pages sont déjà rédigés dans `docs/refonte-design-axelia-offres-amo-bacs.md`.

3. **Le design d'axelia est reproductible avec l'existant** : alternance fonds blanc/bleu-nuit, hero à orbs
   flottants animés, halos floutés pulsés, cartes à hover « lift », bandeau de stats pleine largeur.
   `app.css` contient déjà `@keyframes float`, `glow-pulse`, `glass-card`, `card-hover`,
   `prefers-reduced-motion`. Différenciateur ouvert : une police de titres self-hostée (axelia est en police système).

4. **L'indépendance est l'angle que NeoGTB seul peut tenir, et que tous les concurrents sous-exploitent.**
   Marteler « Indépendant · 0 commission · 0 matériel vendu · ISO 52120-1 · 0 cookie » en ligne de
   réassurance sous chaque hero.

5. **Trois incohérences internes à corriger avant tout cosmétique** : (a) deux briques hero concurrentes
   (`hero.blade.php` vs `hero-image.blade.php`) ; (b) deux seeders home contradictoires (`AccueilBricksSeeder`
   vs `HomePageSeeder`) — la copie LIVE vit en base `page_contents` ; (c) cinq styles de bouton « primaire ».

6. **Ne JAMAIS copier les chiffres de preuve gonflés/vides des concurrents (R1).** Axelia : « 500+ / 98 % /
   40 % » non sourcés ; smt : compteurs cassés à « +0 ». NeoGTB n'affiche que des chiffres vérifiables et
   masque une brique chiffres plutôt que la montrer à 0.

7. **Les concurrents échouent sur le placement des CTA** : nextiim n'a aucun CTA dans le corps d'une page de
   4610 px ; ef hardcode `?month=2025-12` dans son Calendly ; smt enterre son lead magnet en footer. NeoGTB
   doit ponctuer chaque page longue de CTA contextuels + router vers son outil /audit.

## 2. Design — l'ADN axelia transposé

| Élément | Axelia (mesuré DOM) | NeoGTB (déjà dispo) |
|---|---|---|
| Palette | #1D385D bleu nuit, #11B981 émeraude, fond blanc | primary #1B3A5C, accent #2D8B4E, light — **quasi identique** |
| Hero « wow » | 4 div `rounded-full` animées désync + halos `blur-3xl` pulsés | `@keyframes float`, `glow-pulse` — **à composer** |
| Rythme | Alternance blanc / `bg-gray-900 text-white` | `bg-dark-50` + `primary-900` — **à systématiser** |
| Cartes | `rounded-2xl` + `hover:-translate-y-2` + image zoom hover | `glass-card`, hover -2px — **pousser à -8px + shadow-2xl** |
| Stats | Bandeau navy pleine largeur, 3 chiffres géants | brique `chiffres` existe |

**Plan par brique** : `hero` → choisir UN seul (orbs OU image+overlay), H1 60px lh~1.1 ; `chiffres` →
bandeau primary-900, **corriger vert hardcodé #10B981 → token accent** ; `cartes` → ajouter param `image`
optionnel (~10 lignes) ; `cta` → variante mince inter-sections + variante bloc sombre avec checklist ;
global → unifier largeur conteneur, activer scroll-reveal, halos pulsés, étendre `prefers-reduced-motion`.

**À ne PAS copier** : dark mode jaune/noir de smt, combo teal+jaune d'ef, texte gris sur bouton (échec WCAG),
PNG lourds.

## 3. Contenu & copywriting (extraits clés)

- Hero : verbe impératif + bénéfice + signature indépendance. Nommer la cible (maîtres d'ouvrage tertiaires,
  bailleurs, collectivités, exploitants).
- /offres : 2 offres (Cap Projet / Pilotage 360) + tableau comparatif (brique `comparatif`) qu'aucun
  concurrent n'a ; CTA différenciés (pas de « Demander un devis » uniforme).
- /decret-bacs : structure en questions d'acheteur (force de nextiim) + ajouter coût + sanction (que nextiim
  oublie) ; battre par la précision factuelle (tableau classes, frise échéances, exception TRI, CEE).
- /amo-gtb-gtc : 4 piliers + 4 étapes + 8 FAQ ; H1 en promesse (pas en libellé) ; matérialiser l'indépendance.
- Transverse : traduire chaque acronyme au 1er emploi ; relecture éditoriale (les concurrents fourmillent de
  fautes) ; trancher l'incohérence home sur la version forte.

## 4. UX & conversion (extraits clés)

- Unifier UN seul style de bouton primaire (vert plein) ; bannir « En savoir plus »/« Contact » génériques.
- CTA contextuels mid-funnel + bloc CTA sombre en clôture ; router vers /audit (outil interactif, avantage unique).
- Reproduire le bloc « Parlez-nous de votre projet » d'axelia (checklist « Ce que vous obtenez » + microcopy
  « Réponse 48h · Sans engagement »).
- Header sticky + UN CTA persistant ; promouvoir /audit en nav 1er niveau ; téléphone `tel:` (si numéro public).
- Mobile : garder le sticky CTA (best practice absente des 4 références) ; réserver l'espace des orbs (CLS 0).

## 5. SEO & structure (extraits clés)

- **Silo par sujet = le gap le plus net.** Créer /decret-bacs (exact-match), /amo-gtb-gtc, /offres
  (+ /secteurs plus tard). Garder /gtb et /gtc comme piliers informationnels (anti-cannibalisation).
- Poser canonical = URL de la page (les concurrents SPA pointent tout vers la home) ; déclarer les nouvelles
  pages dans `SitemapController.php` ; baliser les FAQ en FAQPage (ld+json exempté CSP).
- **Corriger le title par défaut « décret BACS 2027 » → cohérent avec 2030.**
- Renforcer le maillage interne cornerstone (bloc « Pour aller plus loin », 6-10 liens).

## 6. Tableau de priorisation (impact/effort sur 5)

| Action | Impact | Effort |
|---|---|---|
| Vérifier `page_contents` LIVE + aligner home sur version forte | 5 | 1 |
| Unifier UN style de bouton primaire | 4 | 1 |
| Corriger verts hardcodés #10B981 → token accent | 3 | 1 |
| Corriger title « BACS 2027 » → 2030 | 4 | 1 |
| Ligne réassurance badges sous hero | 4 | 1 |
| Activer scroll-reveal (déjà dispo) | 3 | 1 |
| Créer /decret-bacs (contenu prêt) + sitemap + FAQPage | 5 | 2 |
| Créer /amo-gtb-gtc (contenu prêt + 8 FAQ) | 5 | 2 |
| Créer /offres (2 offres + comparatif) | 5 | 2 |
| Bloc CTA sombre + checklist « Ce que vous obtenez » | 4 | 2 |
| Maillage interne cornerstone | 4 | 2 |
| CTA contextuels mid-funnel | 4 | 2 |
| Unifier hero (UN signature) | 4 | 3 |
| Largeur conteneur + alternance fonds | 3 | 2 |
| Image d'en-tête dans `cartes` + hover lift | 3 | 2 |
| Police de titres self-hostée | 3 | 3 |
| Téléphone header (si validé) | 4 | 2 |
| Lead magnet « guide BACS » / mini-simulateur | 4 | 3 |
| Pages sectorielles | 3 | 3 |

## 7. Ce que NeoGTB fait DÉJÀ bien et doit GARDER

Socle technique en avance (Blade SSR, sitemap dynamique, llms.txt + 11 bots IA, Plausible cookieless, a11y
100/100, CLS 0, WebP, canonical/OG/BreadcrumbList) ; la thèse d'indépendance (/positionnement, « pas de faux
témoignages ici ») ; le contenu réglementaire factuel à jour ; les outils interactifs reliés (audit,
comparateur, CEE) ; le sticky CTA mobile ; le mega-menu par intention ; la palette light + bleu nuit + vert ;
la posture R1 (zéro invention).

---

# PARTIE 2 — CRITIQUE ADVERSARIALE (à appliquer avant exécution)

## (a) Recommandations douteuses / non sourcées (risque R1)

1. **« ~35 % d'économies D→A » érigé en chiffre-roi** alors qu'il flotte (35 % / 25 % / -35 %) selon les
   passages. → Relire `reglementation.blade.php` et vérifier la valeur littérale + le référentiel avant de
   la graver dans le hero. Fourchette prudente tant que non confirmé.
2. **« jusqu'à 35 % » dans le hero = registre publicitaire** reproché à axelia/smt. Un tiers de confiance ne
   dit pas « jusqu'à ». → Formulation conditionnelle factuelle.
3. **Compteurs « 340+ diagnostics / 2,4 M€ CEE / 23 % »** : invraisemblables pour un projet récent qui
   revendique « pas de faux témoignages ». → Les retirer, pas les « faire valider » (R3 : le doute suffit à exclure).
4. **TRI : divergence interne non tranchée (>6 ans vs <10 ans)**. → Bloquant. Lire la valeur exacte dans
   `reglementation.blade.php` (source code = sommet de R2) avant toute rédaction.
5. **« amende jusqu'à 7 500 € » appliquée au décret BACS** alors que c'est la sanction du décret tertiaire
   (dispositifs distincts). → Vérifier le régime de sanction PROPRE au décret BACS ; ne pas importer par analogie.
6. **« bonification CEE clôturée au 1er janvier 2026 » repris de nextiim** = sourcer une échéance sur un
   concurrent (anti-R2). → Doc officielle (fiche BAT-TH-116 / arrêté) ou rien.

## (b) Contradictions

7. **Hero light (titre dark) vs overlay sombre obligatoire (titre blanc)** présentés tous deux comme « la »
   solution. → Trancher : cible = light mode → titre dark, orbs, pas d'overlay sombre.
8. **Slug BACS : /decret-bacs vs /audit-decret-bacs + « garder un pilier qui maille vers lui-même »** =
   risque de doublon/cannibalisation. → UNE seule page /decret-bacs (transactionnelle + informationnelle).
9. **Année dans slug/title : « jamais » (smt) vs « Décret BACS 2025 » (ef)**, aggravé par le bug « BACS 2027 »
   actuel. → Zéro année dans les SLUGS ; reco : pas d'année dans le title non plus (évite la péremption).
10. **Police self-hostée notée « la plus rentable » ET effort 3/5.** → Effort réel 3 + risque CLS ;
    `font-display: optional` + `size-adjust` obligatoires pour ne pas régresser le CLS 0.
11. **Téléphone cliquable matraqué ~8 fois** alors que le numéro public n'existe pas. → Une seule mention
    conditionnelle ; défaut = CTA « Prendre RDV ».

## (c) Lacunes

12. **Aucune mesure des concurrents n'est revérifiable ici** (timings d'animation, « 70 occurrences de
    jaune », canonical). → Marquer « à reconfirmer par inspection directe » avant d'en faire des specs.
13. **RGPD du lead magnet / simulateur : zéro mot.** Capturer un email ≠ « 0 cookie ». → Mention RGPD +
    finalité + lien politique de confidentialité sur toute capture.
14. **Migration home en base prod sous-estimée (effort 1).** Copie LIVE hors git, cache 1h, déploiement
    manuel. → Procédure explicite (lire base, sauvegarder, éditer Filament, `cache:clear`). Effort 2.
15. **Coût de maintenance de 9+ pages ignoré.** → Prioriser 3 pages (BACS, AMO, offres). Reporter les
    sectorielles tant que le fond n'est pas stabilisé.
16. **Aucune baseline analytics** pour justifier les « impact 5/5 ». → Poser la baseline (vues /audit, taux
    de complétion) avant de décréter les priorités.

## (d) Recommandations qui casseraient le positionnement « tiers de confiance »

17. **Accroche « double contraste » empruntée au « 2 %/90 % » de smt** : calquer la rhétorique d'un vendeur
    affaiblit la posture. → Garder le registre sobre de /positionnement.
18. **Jouer la peur de l'amende (angle nextiim)** = rhétorique de vendeur. → Échéance présentée comme fait
    neutre daté, sans dramatisation.
19. **Calendly/Cal.com** posent des cookies tiers, incompatibles avec le badge « 0 cookie ». → RDV
    auto-hébergé cookieless vérifié, sinon formulaire.
20. **« Estimer mes CEE » comme produit d'appel** rapproche de l'apporteur d'affaires CEE. → « Comprendre vos
    CEE éligibles » (pédagogie), pas « estimer/obtenir ».
21. **Surjouer les credentials individuels (emprunt ef)** glisse vers l'argument d'autorité d'un BE.
    → L'indépendance se prouve par le modèle éco (0 commission), pas par un CV prestigieux.

## Top 5 bloquants avant toute exécution

1. **Trancher TRI (>6 vs <10 ans), report 2030, sanction BACS** sur `reglementation.blade.php`.
2. **Retirer** les compteurs 340+/2,4 M€/23 % et le « jusqu'à 35 % ».
3. **Un seul hero** : light, titre dark, orbs — supprimer l'overlay sombre.
4. **Une seule page /decret-bacs**, sans année dans slug ni title.
5. **RGPD + cookieless** sur toute capture email et toute prise de RDV.

> Rien ne doit aller en production avant relecture de `reglementation.blade.php` comme source unique de
> vérité réglementaire.
