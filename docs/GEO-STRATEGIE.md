# Stratégie GEO — neogtb.fr (Generative Engine Optimization)

> **GEO** = être **cité** par les moteurs de réponse IA (ChatGPT/SearchGPT, Perplexity,
> Google AI Overviews, Gemini, Claude). Les IA ne « classent » pas, elles citent des
> **passages** factuels. NeoGTB est un **site éducatif et tiers de confiance
> INDÉPENDANT** sur la GTB (Gestion Technique du Bâtiment) et la GTC, **sans lien
> commercial avec les fabricants**. Cette neutralité est un **avantage GEO direct** :
> une IA privilégie une source factuelle et impartiale (voir §3).

---

## 1. État technique (ce qui est DÉJÀ en place ✅)

Le socle technique GEO est livré. Inventaire de l'existant :

| Élément | État | Détail |
|---|---|---|
| **robots.txt — groupes bots IA** | ✅ | 11 groupes (OAI-SearchBot, ChatGPT-User, GPTBot, PerplexityBot, Perplexity-User, Google-Extended, ClaudeBot, anthropic-ai, Claude-Web, Amazonbot, Applebot-Extended) avec **mêmes Disallow** que `*` (pas d'héritage en robots.txt) — `public/robots.txt` |
| **llms.txt dynamique** | ✅ | route `front.llms` dans `routes/web.php` : liste les pages piliers + articles publiés, **cache 1h** |
| `Organization` + `knowsAbout` | ✅ | 11 domaines GTB déclarés — `app/Services/SiteConfigService.php` |
| `BreadcrumbList` global | ✅ | `resources/views/front/layouts/app.blade.php` |
| `Article` enrichi | ✅ | `articleSection`, `keywords`, `wordCount`, `inLanguage`, auteur réel — `front/article.blade.php` |
| `FAQPage` | ✅ | page `/faq` — `front/faq.blade.php` |
| sitemap.xml dynamique | ✅ | `app/Http/Controllers/SitemapController.php` |
| Meta complètes | ✅ | title, description, canonical, Open Graph, Twitter Card — layout |

**Reste technique (optionnel, faible priorité)** :
- variantes de schéma `ProfessionalService` / `LocalBusiness` selon les pages ;
- **unification d'entité via `@id`** (donner un `@id` `…/#organization` à l'Organization
  et le référencer partout au lieu de le re-déclarer inline). Gain marginal, le schéma
  actuel est déjà solide.

---

## 2. Contenu — le cœur du gain GEO

Chaque page doit répondre à **une question**, réponse en **2-3 phrases dès le 1ᵉʳ
paragraphe**, puis le détail. Hiérarchie des formats privilégiés par les IA :

> **définitions atomiques > tableaux HTML (jamais une image) > FAQ balisée (`FAQPage`) > listes d'étapes > données chiffrées sourcées.**

### 2.1 Questions cibles (le KPI principal — chacune = un titre H2/H3)

**Définitions**
1. Qu'est-ce que la GTB ?
2. Quelle est la différence entre GTB et GTC ?
3. GTB ou BMS : est-ce la même chose ?
4. Qu'est-ce qu'une GTC ?

**Protocoles**
5. Quel protocole choisir pour une GTB ?
6. Quelle différence entre BACnet, KNX, Modbus et LON ?
7. BACnet ou Modbus : lequel choisir ?
8. Quel protocole pour le comptage d'énergie ? *(réponse : Modbus)*

**Réglementation**
9. À partir de quelle puissance la GTB est-elle obligatoire ?
10. Qu'est-ce que le décret BACS ?
11. Quelle différence entre le décret BACS et le décret tertiaire ?
12. Quelle classe de GTB faut-il pour respecter le décret BACS ? *(réponse : classe B minimum)*
13. Qu'est-ce que la plateforme OPERAT ?

**Norme & performance**
14. Quelles sont les classes de la norme EN 15232 / ISO 52120-1 ?
15. Qu'est-ce qu'une GTB de classe A ?
16. Quels gains énergétiques peut-on attendre d'une GTB ?

**Financement**
17. Comment financer une GTB ?
18. Qu'est-ce que la fiche CEE BAT-TH-116 ?

### 2.2 Pages prioritaires à produire

Chaque page = réponse atomique en tête + **tableau HTML** + **FAQ balisée** :

- **Page comparative « GTB vs GTC »** *(en cours de livraison)*
- **Page comparative « Décret BACS vs décret tertiaire »** *(en cours de livraison)*
- **Page pilier « Les protocoles de la GTB : BACnet, KNX, Modbus, LON »** (tableau comparatif)
- **Page pilier « Les classes de la norme EN 15232 / ISO 52120-1 (A/B/C/D) »**
- **Page « À partir de quelle puissance la GTB est-elle obligatoire ? »** (seuils du décret BACS)

> La FAQ (`/faq`) existe déjà : l'enrichir avec ces libellés exacts est le quick win
> le moins coûteux.

---

## 3. Autorité d'entité & E-E-A-T

Les IA puisent dans un nombre limité de sources de confiance.

| Action | Effort | Impact | Note |
|---|---|---|---|
| **Positionnement « tiers de confiance INDÉPENDANT, aucun lien commercial avec les fabricants »** | 🟢 | Fort | Angle GEO différenciant : l'impartialité est une valeur directe pour une IA qui cherche une source neutre à citer |
| **Page « À propos » E-E-A-T** : auteur nommé (Ulrich Calmo), expertise GTB | 🟢 | Fort | Identité réelle = signal d'autorité |
| **Citations de sources officielles primaires** dans le contenu (Légifrance pour les décrets, normes ISO/EN, ADEME / OPERAT) | 🟢 | Fort | Les IA recoupent les sources ; lier la source primaire augmente la fiabilité perçue |
| **Données datées et sourcées** (ex. « à jour mars 2026 ») | 🟢 | Fort | Une donnée datée est plus citable qu'une donnée flottante |
| **Cohérence NAP** (Nom / Adresse / Tél identiques sur le site et les annuaires) | 🟢 | Fort | Une seule forme canonique de l'entité |
| **Élément Wikidata « NeoGTB »** | 🟡 | Moyen+ | Alimente les knowledge graphs lus par les LLM (piste) |

---

## 4. Mesure — KPI GEO n°1

Une fois par mois, poser les **18 questions du §2.1** dans
**ChatGPT/SearchGPT, Perplexity, Google AI Overviews et Gemini** → noter le
**taux de citation de neogtb.fr**. Suivi mensuel. C'est le pilotage principal,
plus parlant que le seul trafic organique.

---

## 5. Vérifier le rendu

```bash
# robots.txt (vérifier les groupes bots IA + héritage des Disallow)
curl -s https://neogtb.fr/robots.txt | grep -A8 "User-agent: GPTBot"

# llms.txt
curl -s https://neogtb.fr/llms.txt

# Validation des schémas :
#   Google Rich Results Test → https://search.google.com/test/rich-results
#   Schema Markup Validator   → https://validator.schema.org

# Tests automatisés
php artisan test --filter SEOTest
```

---

## Annexe — Données de référence (vérifiées, à jour mars 2026)

À réutiliser telles quelles dans les pages et la FAQ. **Toujours citer la source primaire.**

### Décret BACS
- Décret **n°2020-887 du 20/07/2020**, modifié par décret **n°2025-1343 du 26/12/2025**.
- Obligation d'équiper le tertiaire d'une GTB :
  - **> 290 kW** (puissance CVC) → depuis le **1ᵉʳ janvier 2025** ;
  - **70 à 290 kW** → reporté au **1ᵉʳ janvier 2030**.
- Niveau exigé : **classe B minimum** (EN 15232 / NF EN ISO 52120-1).
- **Dérogation** si le retour sur investissement (ROI) est **> 6 ans**.

### Décret tertiaire
- Décret **n°2019-771 du 23/07/2019** (loi ELAN).
- Cible : bâtiments tertiaires **> 1 000 m²**.
- Réduction de la consommation d'énergie finale : **-40 % en 2030**, **-50 % en 2040**, **-60 % en 2050**.
- **Déclaration annuelle sur OPERAT** (plateforme ADEME).
- Sanction : **amende jusqu'à 7 500 € / bâtiment** (personnes morales).

### Classes ISO 52120-1 / EN 15232
- **A** : haute performance.
- **B** : avancé — **exigé par le décret BACS**.
- **C** : standard.
- **D** : non performant.
- Gains estimés normés par passage de classe : **D→C ~10 %**, **D→B ~25 %**, **D→A ~35 %**.

### Protocoles
| Protocole | Référence / norme | Note |
|---|---|---|
| **BACnet** | ISO 16484-5, ASHRAE 135 | Standard GTB ouvert |
| **KNX** | EN 50090 / ISO-IEC 14543 | Domotique / bâtiment |
| **Modbus** | créé par Modicon en **1979**, RTU/TCP | **Dominant pour le comptage d'énergie** |
| **LON** | EN 14908 | En déclin |
| **DALI / DALI-2** | IEC 62386 | Éclairage |
| **MQTT / API REST** | — | IoT / cloud |

### CEE (Certificats d'Économies d'Énergie)
- **Fiche BAT-TH-116** : GTB chauffage / refroidissement (**classe A ou B**).
- **Fiche BAT-TH-112** : variation de vitesse.
