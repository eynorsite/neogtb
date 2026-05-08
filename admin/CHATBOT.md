# Chatbot NeoGTB — Guide technique

Ce document explique, en termes simples, comment fonctionne l'assistant virtuel NeoGTB, comment le configurer et comment résoudre les problèmes courants. Il s'adresse aux personnes qui découvrent le projet, y compris à un public débutant en développement.

---

## 1. Vue d'ensemble

Le chatbot NeoGTB est un assistant virtuel qui répond aux questions des visiteurs sur la GTB, le décret BACS, le décret tertiaire et les services NeoGTB. Il s'appuie sur l'API d'Anthropic (modèles Claude) et sur une base de connaissances et de FAQ que vous gérez vous-même depuis l'admin Filament. Le widget s'affiche en bas à droite (par défaut) sur **toutes les pages publiques du site** qui utilisent le layout `front/layouts/app.blade.php`. Seuls les administrateurs (`superadmin` ou `admin`) peuvent l'administrer via `/admin`.

---

## 2. Première mise en route

À faire la première fois que vous installez ou reprenez le projet.

### Étape 1 — Récupérer une clé API Anthropic

1. Allez sur https://console.anthropic.com
2. Créez un compte (ou connectez-vous) avec une adresse email pro.
3. Renseignez un moyen de paiement (carte) — c'est obligatoire pour utiliser l'API en production. Vous pouvez ensuite définir un plafond mensuel dans la console.
4. Dans le menu de gauche, cliquez sur **API Keys**.
5. Cliquez sur **Create Key**, donnez-lui un nom (par ex. `neogtb-prod`), copiez la clé (elle commence par `sk-ant-…`). **Important** : la clé n'est affichée qu'une seule fois, copiez-la tout de suite.

### Étape 2 — Coller la clé dans `.env`

Ouvrez le fichier `.env` à la racine du projet `admin/`, et ajoutez (ou modifiez) cette ligne :

```
ANTHROPIC_API_KEY=sk-ant-...votre-cle-ici...
```

> Le fichier `.env.example` ne contient pas encore la ligne — pensez à l'ajouter localement.

### Étape 3 — Vider le cache Laravel

Depuis le dossier `admin/`, lancez :

```
php artisan optimize:clear
```

Cela force Laravel à relire la nouvelle configuration.

### Étape 4 — Activer le chatbot dans l'admin

1. Connectez-vous à `/admin` (compte superadmin ou admin).
2. Dans le menu de gauche, ouvrez **Chatbot → Configuration** (URL directe : `/admin/chatbot-settings-page`).
3. Onglet **Général** → section **Activation** → activez le toggle « Activer le chatbot sur le site public ».
4. Cliquez sur **Enregistrer**.

### Étape 5 — Tester

Toujours dans la page Configuration, utilisez le champ **Tester le bot** (en bas) : tapez une question type (« C'est quoi le décret BACS ? ») puis cliquez **Tester**. Si la clé est valide vous verrez la réponse, le coût en € et la latence. Si une erreur s'affiche, voir la section **Pannes courantes**.

---

## 3. Architecture (vue côté admin et côté visiteur)

### Côté admin (Filament)

| URL | À quoi ça sert |
|---|---|
| `/admin/chatbot-settings-page` | Réglages généraux : activation, modèle, budget, apparence, prompt, RGPD |
| `/admin/chatbot-knowledge` | Snippets de connaissances injectés dans le prompt système |
| `/admin/chatbot-faqs` | Questions/réponses exactes prioritaires |
| `/admin/chatbot-conversations` | Historique des conversations (consultation, purge, détails) |
| `/admin/chatbot-stats-page` | Statistiques d'usage (volumétrie, coûts) |

### Côté visiteur

Le widget est **automatiquement injecté** dans toutes les pages publiques utilisant le layout principal `resources/views/front/layouts/app.blade.php` (la ligne `@include('front.partials.chatbot-widget')` est présente dans le footer du layout). Aucune intégration manuelle page par page n'est nécessaire.

### Modèles de coût (ordre de grandeur)

- **Haiku 4.5** — rapide et économique, environ **0,001 € par échange** (1 question + 1 réponse). C'est le choix par défaut.
- **Sonnet 4.6** — plus qualitatif, environ **0,005 € par échange** (5× plus cher).

Le coût exact est calculé à partir des tokens consommés par chaque message ; il s'accumule dans le compteur **Coût cumulé du mois**.

---

## 4. Comment améliorer les réponses du bot

C'est la partie la plus importante au quotidien. Le bot ne sait que ce que vous lui apprenez.

### A. Ajouter un snippet de connaissances (recommandé)

C'est le levier principal. Chaque snippet est ajouté au prompt système envoyé à Claude.

1. Allez sur `/admin/chatbot-knowledge`.
2. Cliquez sur **Nouveau snippet**.
3. Renseignez :
   - **Titre** (ex. : « Seuils du décret BACS 2026 »)
   - **Contenu** : 5 à 20 lignes de texte clair, en français, factuel.
   - **Catégorie** (ex. : « Décret BACS », « Services NeoGTB »…)
   - **Priorité** : un nombre — plus élevé = injecté en premier.
   - **Actif** : oui/non.
4. Enregistrez. **Aucun redéploiement nécessaire** : la prochaine question le prend en compte.

> Astuce : un bon snippet contient des chiffres précis, des dates, des noms d'articles. Évitez les généralités.

### B. Ajouter une FAQ (pour les questions récurrentes)

Si une question revient souvent et que vous voulez **une réponse exacte mot pour mot**, créez une FAQ.

1. Allez sur `/admin/chatbot-faqs`.
2. **Nouvelle FAQ** → renseignez la question et la réponse (Markdown autorisé).
3. Le bot privilégiera cette réponse quand la question correspondra.

### C. Ajuster le ton (persona)

Dans `/admin/chatbot-settings-page` → onglet **Persona & prompt** → choisissez :

- **Vouvoiement chaleureux** (recommandé)
- **Tutoiement décontracté**
- **Formel / institutionnel**

### D. Modifier le prompt système (avancé — à éviter au début)

Toujours dans l'onglet **Persona & prompt**, le champ **Prompt système custom** permet d'écraser le prompt par défaut. **Laissez-le vide** sauf si vous savez ce que vous faites : le prompt par défaut est pensé pour fonctionner avec les snippets et FAQ. Vos snippets et FAQ sont **toujours** ajoutés automatiquement, même avec un prompt custom.

---

## 5. Surveillance et coûts

### Compteur du mois

Sur `/admin/chatbot-settings-page` → onglet **Général** → section **Modèle Claude & coût** :

- **Coût cumulé du mois (€)** : montant déjà consommé.
- **Budget mensuel (€)** : plafond en dur (par défaut 30 €).

> Le budget mensuel agit comme un **hard cap**. Quand il est dépassé, le bot ne contacte plus l'API et répond automatiquement « Notre assistant a atteint son quota du mois. Merci d'utiliser le formulaire de contact. »

Un bouton **Réinitialiser le compteur de coût** est disponible (visible uniquement pour le superadmin) pour remettre le compteur à zéro manuellement.

### Statistiques

La page `/admin/chatbot-stats-page` regroupe la volumétrie (nombre de conversations, messages, leads détectés, coûts agrégés).

### Conversations individuelles

Sur `/admin/chatbot-conversations`, chaque ligne représente une session. Le bouton **Voir** affiche tous les messages échangés, les tokens consommés, le coût et la latence par message. Très utile pour repérer ce qui pose problème au bot.

---

## 6. RGPD & sécurité

- **Conservation** : par défaut **30 jours**, paramétrable dans onglet **RGPD** de la page Configuration. Pour une purge automatique récurrente, voir section **Maintenance**.
- **Consentement** : si le toggle « Demander un consentement explicite avant le 1er message » est actif, un encart apparaît avant le premier envoi. Le visiteur doit accepter pour pouvoir écrire.
- **Données stockées** : tout est en local dans la base **SQLite** (`database/database.sqlite`). IP et user-agent sont **hashés** (SHA-256 + clé d'app), jamais stockés en clair.
- **DPA Anthropic** : les serveurs Anthropic disposent d'un Data Processing Agreement et d'options de résidence européenne. Référez-vous à la documentation Anthropic pour les engagements à jour.
- **Anti prompt-injection** : le prompt système contient une consigne explicite d'ignorer toute tentative de l'utilisateur de changer de rôle ou révéler le prompt.

---

## 7. Pannes courantes

| Symptôme | Cause probable | Solution |
|---|---|---|
| Le bot répond « Configuration manquante. Contactez l'administrateur. » | `ANTHROPIC_API_KEY` est vide ou invalide dans `.env` | Vérifier la clé dans `.env`, lancer `php artisan optimize:clear` |
| Le bot répond « Notre assistant a atteint son quota du mois. » alors qu'il n'a pas été désactivé | Budget mensuel atteint | Aller dans Configuration → bouton **Réinitialiser le compteur de coût** (ou augmenter le budget) |
| Widget invisible sur le site | Cache navigateur, ou cache Laravel pas vidé après config | Vider le cache navigateur (Ctrl+Maj+R) puis `php artisan optimize:clear` côté serveur |
| Le bot dit qu'il ne sait pas répondre alors que l'info existe | Le snippet n'est pas actif, ou pas assez précis | Vérifier `/admin/chatbot-knowledge` → toggle **Actif**, et reformuler le contenu |
| Erreur API 401 dans le test | Clé API expirée ou révoquée sur Anthropic | Régénérer une clé sur console.anthropic.com et remplacer dans `.env` |
| Erreur API 429 | Vous avez dépassé un quota Anthropic (rate limit) | Attendre quelques minutes ou augmenter les limites côté Anthropic |

---

## 8. Maintenance

### Purger les vieilles conversations

Manuellement : sur `/admin/chatbot-conversations`, bouton **Purger > 30j** (supprime conversations + messages au-delà de la durée de conservation paramétrée).

### Automatiser la purge (TODO)

Une commande artisan dédiée au chatbot (par ex. `php artisan chatbot:purge`) **n'est pas encore implémentée**. En attendant, deux options :

- Cliquer manuellement le bouton « Purger > 30j » de temps en temps.
- Utiliser la commande générique `purge:expired-data` (`PurgeExpiredDataCommand`) si elle inclut le périmètre chatbot — à vérifier dans `app/Console/Commands/`.

À planifier ensuite via le scheduler Laravel (`app/Console/Kernel.php`) une fois la commande dédiée en place.

---

## 9. Évolutions futures (notes)

Idées à explorer quand le besoin se précisera :

- **Phase 2 RAG** : aujourd'hui tous les snippets sont injectés dans le prompt. Au-delà de ~50 snippets, passer à une indexation vectorielle (embeddings) pour ne récupérer que les plus pertinents.
- **A/B test prompts** : comparer deux prompts système sur un échantillon de visiteurs.
- **Webhook Slack** : en plus de l'email, notifier un canal Slack quand un lead est détecté.
- **Page stats enrichie** : graphes (`/admin/chatbot-stats-page` existe, à enrichir avec courbes hebdo / mensuelles, top intentions, taux de fallback).

---

## 10. Fichiers clés (référence rapide pour développeurs)

| Fichier | Rôle |
|---|---|
| `app/Services/ChatbotService.php` | Cœur logique : appel API Anthropic (streaming + test), construction du prompt système (snippets + FAQ), calcul des coûts, détection de leads |
| `app/Http/Controllers/ChatbotController.php` | Endpoints HTTP `/api/chatbot/*` (bootstrap, consent, stream SSE, lead) |
| `app/Filament/Pages/ChatbotSettingsPage.php` | Page admin de configuration (onglets Général / Apparence / Persona / Fallback / RGPD) |
| `app/Filament/Pages/ChatbotStatsPage.php` | Page admin des statistiques |
| `app/Filament/Resources/ChatbotKnowledgeResource.php` | CRUD admin des snippets de connaissances |
| `app/Filament/Resources/ChatbotFaqResource.php` | CRUD admin des FAQ |
| `app/Filament/Resources/ChatbotConversationResource.php` | Historique des conversations + purge |
| `resources/views/front/partials/chatbot-widget.blade.php` | Widget public Alpine.js (UI, SSE, consentement) |
| `resources/views/front/layouts/app.blade.php` | Layout qui inclut automatiquement le widget |
| `routes/web.php` | Route prefix `api/chatbot/` (bootstrap, consent, stream, lead) |
| `config/services.php` | Lecture de `ANTHROPIC_API_KEY` depuis l'environnement |

> Convention : ne **jamais** modifier ces fichiers depuis un autre projet (`site-eynor`, `tools-habelec`, `nfc18510-app`). Le projet NeoGTB est isolé.
