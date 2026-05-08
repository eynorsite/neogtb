# Chatbot NeoGTB — Récap de livraison

**Date** : 2026-05-08
**Stack** : Laravel 13 + Filament 5.4 + SQLite + Alpine.js + API Anthropic Claude
**Statut** : Livré, prêt pour tests utilisateur (clé API à configurer)

---

## Vue d'ensemble

Chatbot IA custom intégré dans le site NeoGTB. Visiteurs peuvent poser des questions sur le décret BACS, la GTB/GTC, et les services NeoGTB. Réponses générées par Claude Haiku 4.5 à partir d'une base de connaissances éditable depuis l'admin Filament.

Solution **100% maison** (refus de Chatbase pour rester maître des données et tout intégrer dans Filament).

---

## Ce qui a été construit

### Base de données (5 tables)

- `chatbot_settings` — Configuration singleton (modèle, budget, persona, RGPD)
- `chatbot_knowledge_snippets` — Blocs de connaissances injectés dans le prompt système
- `chatbot_faqs` — Questions/réponses exactes privilégiées par le bot
- `chatbot_conversations` — Historique anonymisé (session_id, IP hashée, lead detection)
- `chatbot_messages` — Messages individuels avec tokens, coût €, latence

### Backend Laravel

- **Service** : `app/Services/ChatbotService.php`
  - Appel API Anthropic en streaming (Server-Sent Events)
  - Prompt caching (réduit 90% du coût après le 1er appel)
  - Calcul du coût en EUR (avec tokens cache pris en compte)
  - Détection automatique de leads par mots-clés
  - Mode test sans streaming pour l'admin

- **Controller** : `app/Http/Controllers/ChatbotController.php`
  - `GET /api/chatbot/bootstrap` — Config publique du widget
  - `POST /api/chatbot/consent` — Consentement RGPD
  - `POST /api/chatbot/stream` — Conversation en streaming
  - `POST /api/chatbot/lead` — Capture email visiteur

- **Sécurité** : rate-limit (30 msg/IP/jour, 20/session), CSRF actif, cookies httpOnly+SameSite, validation stricte

### Admin Filament (groupe "Chatbot")

| URL | Rôle |
|---|---|
| `/admin/chatbot-settings-page` | Configuration : 5 onglets (Général/Apparence/Persona/Fallback/RGPD) + zone "Tester le bot" intégrée |
| `/admin/chatbot-knowledge` | CRUD snippets de connaissances |
| `/admin/chatbot-faqs` | CRUD FAQ avec mode "suggestion" pour les boutons rapides du widget |
| `/admin/chatbot-conversations` | Historique anonymisé, export CSV, purge >30 j, marquage lead |
| `/admin/chatbot-stats-page` | Dashboard KPI : conversations 7j, coût mois, budget, top questions, activité |

### Widget public

- Fichier : `resources/views/front/partials/chatbot-widget.blade.php`
- Bulle flottante en bas-droite (configurable)
- Streaming des réponses (effet ChatGPT)
- Questions suggérées au démarrage
- Consentement RGPD avant 1er message
- Capture lead email intégrée (apparait après 2 messages)
- Design adaptable : couleur, position, titre depuis l'admin

---

## Économie

- **Modèle par défaut** : Claude Haiku 4.5 → ~0,001 €/échange
- **Budget mensuel** : 30 € hard cap (modifiable, le bot retourne "indisponible" au-delà)
- **Estimation** : 5-20 €/mois pour un trafic standard
- **vs Chatbase Standard** : 99 $/mois (~1100 €/an) → économie de 80-95 %

---

## Workflow QA appliqué

Méthodologie multi-agents (cf. memory `feedback_audit_workflow.md`) :

1. Construction par lots successifs (migrations → models → service → controller → admin → widget → seeder)
2. **QA agent intermédiaire** après livraison initiale → 3 BLOQUANT + 5 IMPORTANT identifiés
3. **5 agents en parallèle** pour finaliser : fixes critiques, capture lead UI, page Stats, migration cleanup, doc README
4. **QA agent final E2E** → validation totale, "OK pour livraison"

---

## Fichiers clés

| Fichier | Description |
|---|---|
| `admin/CHATBOT.md` | Documentation utilisateur complète (215 lignes) |
| `admin/app/Services/ChatbotService.php` | Cœur logique : appel Claude + streaming + coûts |
| `admin/app/Http/Controllers/ChatbotController.php` | Endpoints API |
| `admin/app/Filament/Pages/ChatbotSettingsPage.php` | Admin config |
| `admin/app/Filament/Pages/ChatbotStatsPage.php` | Dashboard stats |
| `admin/app/Filament/Resources/Chatbot*Resource.php` | CRUD knowledge / faq / conversations |
| `admin/resources/views/front/partials/chatbot-widget.blade.php` | Widget Alpine.js public |
| `admin/database/seeders/ChatbotSeeder.php` | 8 snippets + 5 FAQ initiaux |

---

## Setup pour mise en service

1. Récupérer une clé API sur https://console.anthropic.com
2. Coller dans `~/ProjetsWeb/neogtb/admin/.env` ligne `ANTHROPIC_API_KEY=`
3. `php artisan optimize:clear`
4. `/admin/chatbot-settings-page` → onglet Général → activer le toggle
5. Cliquer "Tester le bot" pour valider la configuration
6. Sur le VPS prod : ajouter la même clé dans le `.env` shared puis `php artisan config:clear`

---

## À surveiller / évolutions futures

- **Phase 2 — RAG vectoriel** : quand on aura > 50 snippets, passer à `sqlite-vec` pour indexer plutôt qu'injecter tout en prompt système
- **Commande artisan** `chatbot:purge` pour automatiser la purge >30 j (actuellement bouton manuel dans l'admin)
- **A/B test prompts** : comparer 2 personas sur 100 conversations
- **Webhook Slack** sur leads à fort intérêt commercial (actuellement email seulement)
- **Mode hors-ligne** : afficher un formulaire de contact si l'API est down

---

## Mémoire associée

`~/.claude/projects/-Users-calmoulrich/memory/project_neogtb_chatbot.md`
