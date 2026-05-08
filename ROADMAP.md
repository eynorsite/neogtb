# Roadmap NeoGTB

**Domaine** : https://neogtb.fr
**Stack** : Laravel 13 monolithe + Filament 5.4 + Tailwind v4 + Alpine.js + SQLite
**Dernière mise à jour** : 2026-05-08

---

## État actuel

✅ Site en production sur https://neogtb.fr depuis le 7 avril 2026
✅ Infra VPS finalisée (Nginx, PHP 8.4, Certbot, Supervisor, backup SQLite, cron)
✅ Refonte Option B (Astro retiré, monolithe Laravel) terminée
✅ Audit premium 2026-04-08/09 : 14 corrections SEO/RGPD/contenu/infra déployées
✅ Migration `PageContent` style BIMACAD (1278 entrées)
✅ Chatbot IA livré 2026-05-08, à activer (clé API + toggle)

---

## Phase 0 : Initialisation ✅

- [x] Choix du nom : NeoGTB
- [x] Réservation domaines : neogtb.fr + neogtb.com
- [x] Stack initiale puis pivot vers Laravel monolithe (Astro retiré 2026-04-08)
- [x] Initialisation projet + Git

---

## Phase 1 : Fondations & Design System ✅

- [x] Palette de couleurs (primary cyan/teal + accents NeoGTB)
- [x] Tailwind v4 + Vite (CSS ≈19 KB gzip, JS ≈31 KB gzip)
- [x] Layout principal (header, nav responsive, footer)
- [x] Composants de base via design system (boutons, cards, badges, eyebrow, heading)
- [x] Favicon et branding NeoGTB
- [x] Polices self-hosted (`@fontsource-variable/inter` + Plus Jakarta Sans)
- [x] Alpine.js bundlé via npm (3.14.9 + plugins intersect/collapse)

---

## Phase 2 : Pages Principales ✅

- [x] Page d'accueil (12 bricks éditables, hero + sections + CTA)
- [x] Page "Qu'est-ce que la GTB ?" (`/gtb`)
- [x] Page "Qu'est-ce que la GTC ?" (`/gtc`)
- [x] Page "Solutions & Technologies" (`/solutions`)
- [x] Page "À propos" (`/about`)
- [x] Page "Contact" (`/contact`) avec formulaire
- [x] Page "Réglementation" (`/reglementation`)
- [x] Page "Positionnement" (`/positionnement`)
- [x] Page "Tables Modbus" (`/tables-modbus`) — 19 équipements / 7 catégories

---

## Phase 3 : Blog & Contenu ✅

- [x] Système de blog Laravel/Filament (modèle `Post`, table `posts`)
- [x] Page liste des articles (`/blog`)
- [x] Page détail article (`/blog/{slug}`)
- [x] Catégories et tags (`PostCategory`, `PostTag`)
- [x] 20 articles GTB/GTC importés
- [x] SEO Schema.org Article + Author E-E-A-T
- [x] Image article par défaut éditable depuis admin

---

## Phase 4 : Outil d'Audit ✅

- [x] Formulaire d'audit interactif (`/audit`) wizard multi-step Alpine.js
- [x] Génération de score sur 100 + niveau
- [x] Envoi par email des résultats (Brevo SMTP)
- [x] Stockage des leads en BDD (`AuditLead`)
- [x] Export CSV des leads depuis admin
- [x] Comparateur des solutions GTB (`/comparateur`)
- [x] Générateur de fiches CEE (`/generateur-cee`)
- [x] FAQ structurée (`/faq`)

---

## Phase 5 : SEO & Performance ✅

- [x] Meta tags dynamiques par page (titles ≤ 60 chars)
- [x] Sitemap XML automatique (`SitemapController`)
- [x] Schema.org : Organization + LocalBusiness + BreadcrumbList en `@graph`
- [x] Open Graph / Twitter Cards (og:type article correct depuis le fix d'avril)
- [x] Images compressées WebP, lazy loading
- [x] robots.txt + verification Google Search Console
- [x] Headers sécurité (X-Frame-Options, CSP, Referrer-Policy, Permissions-Policy)
- [x] Page 404 custom premium (noindex)
- [x] Page Cookies + politique de confidentialité + mentions légales + Mes droits RGPD

---

## Phase 6 : Déploiement ✅

- [x] VPS Ubuntu provisionné (Nginx + PHP 8.4 FPM + Certbot)
- [x] DNS neogtb.fr + www.neogtb.fr pointés
- [x] HTTPS Let's Encrypt avec auto-renew
- [x] Releases atomiques via `deploy/deploy-update.sh` (11 étapes)
- [x] Backup SQLite quotidien transactionnel (cron 3h, retention 30j)
- [x] Supervisor pour les workers de queue
- [x] Mode maintenance + git pull --ff-only en pré-deploy
- [x] Rollback script atomique
- [x] Nginx hardening + veille sécurité automatique
- [ ] Analytics (Plausible à régénérer si besoin)
- [ ] Tests multi-navigateurs systématiques

---

## Phase 7 : Chatbot IA — livré 2026-05-08

Doc complète : `admin/CHATBOT.md` et `docs/CHATBOT_LIVRAISON_2026-05-08.md`

### Livré ✅

- [x] **Backend Laravel** : 5 tables, `ChatbotService` streaming SSE + prompt caching, 4 endpoints `/api/chatbot/*` avec rate-limit
- [x] **Admin Filament** (groupe "Chatbot") : Settings (5 onglets), Knowledge, FAQ, Conversations, Stats Dashboard
- [x] **Widget public Alpine.js** : bulle bas-droite, streaming, suggestions, capture lead, consentement RGPD
- [x] **Seeder initial** : 8 snippets décret BACS + 5 FAQ
- [x] **Documentation utilisateur** (`CHATBOT.md`, 215 lignes)
- [x] **Détection auto de leads** par mots-clés + notification email
- [x] **Mode "Tester le bot"** intégré dans l'admin
- [x] **Workflow QA** : audit critique 3 BLOQUANT + 5 IMPORTANT corrigés, 5 agents parallèles, QA final E2E vert

### À faire avant mise en production

- [ ] Récupérer une clé API sur https://console.anthropic.com
- [ ] Coller dans `~/ProjetsWeb/neogtb/admin/.env` ligne `ANTHROPIC_API_KEY=`
- [ ] Coller la même clé sur le `.env` shared du VPS
- [ ] `php artisan optimize:clear` (local + VPS)
- [ ] Activer le toggle dans `/admin/chatbot-settings-page`
- [ ] Tester en local depuis l'admin (zone "Tester le bot")
- [ ] Tester en prod sur quelques pages publiques avant communication
- [ ] Définir un budget mensuel adapté (défaut 30 €/mois)

### Évolutions Phase 7.x

- [ ] Commande artisan `chatbot:purge` pour purge auto > 30 j (cron quotidien)
- [ ] Webhook Slack sur leads à fort intérêt commercial (en plus de l'email)
- [ ] Mode hors-ligne : afficher formulaire de contact si l'API Anthropic est down
- [ ] Internationalisation widget (anglais pour clients export)

---

## Phase 8 : Optimisation chatbot (post-mise en service)

À démarrer après quelques semaines de données réelles.

- [ ] **RAG vectoriel** : passer de prompt enrichi à `sqlite-vec` quand > 50 snippets
- [ ] **A/B test prompts** : comparer 2 personas sur 100 conversations
- [ ] **Citations sources** : le bot cite les pages dont il s'inspire (ex: "voir notre article Décret BACS")
- [ ] **Cache des questions fréquentes** : réponse instantanée + zéro coût pour les 20 questions les plus posées
- [ ] **Analyse sentiment** : identifier les conversations frustrées et alerter
- [ ] **Recommandations actives** : si visite répétée, proposer audit sur mesure
- [ ] **Top questions → FAQ auto** : suggestions de FAQ à créer à partir des questions récurrentes

---

## Phase 9 : Croissance & conversion

- [ ] Plausible Analytics ou GA4 propre
- [ ] Heatmaps sur les pages clés (Hotjar / Microsoft Clarity)
- [ ] Email marketing : séquence onboarding pour leads CEE et audit
- [ ] Chatbot Phase 2 : CTA contextuel selon la page (ex: sur /comparateur, suggérer audit gratuit)
- [ ] Pages sectorielles (industrie / hôtellerie / bureau / commerce / santé)
- [ ] Études de cas clients (1-3 cas réels avec chiffres)
- [ ] Webinaires et lead magnets PDF (ex: "Le guide complet du décret BACS 2027")

---

## Backlog technique (continu)

- [ ] CSP avec nonces (compromis Alpine `unsafe-eval`) — reporté au déploiement
- [ ] PPA `ondrej/php` cassé pour Ubuntu Plucky 25.04 (warning non bloquant)
- [ ] Migration `doctrine/dbal` si bascule MySQL/Postgres (actuellement SQLite)
- [ ] Tests Feature/Unit (couverture actuelle ≈ 0)
- [ ] Internationalisation site (anglais)

---

## Conventions

- Commits français, format `type(scope): description`
- Branches : `main` (prod), `feature/nom`, `fix/nom`
- Déploiement : `cd ~/neogtb && git pull --ff-only && sudo bash deploy/deploy-update.sh`
- Workflow QA : agent général-purpose en mode contrôle après chaque lot non trivial
