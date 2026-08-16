# Audit SEO / GEO — neogtb.fr

**Date** : 15 août 2026
**Périmètre** : 48 URLs du sitemap, en production
**Méthode** : crawl des 48 pages (métas, JSON-LD, en-têtes, liens, poids, temps), lecture du code source, vérification DNS/nginx, contrôle des sources officielles citées

---

## 1. Verdict

Le socle technique est **très au-dessus de la moyenne du secteur**, et il faut le dire :

| Contrôle | Résultat |
|---|---|
| Pages en HTTP 200 | 48/48 |
| Temps de réponse moyen | 0,18 s (max 0,30 s) |
| Title + description présents | 48/48 |
| Canonical auto-référent | 48/48 |
| Open Graph + Twitter Card | 48/48 |
| `Organization` + `BreadcrumbList` | 48/48 |
| `Article` sur les articles | 20/20 |
| `FAQPage` | 10 pages |
| `robots.txt` avec 11 groupes de bots IA | oui |
| `llms.txt` | oui, complet et à jour |
| HSTS, `X-Content-Type-Options`, CSP | oui |
| `www` → apex en 301 | oui |

Ce n'est pas un site à réparer. Les défauts trouvés sont **des fuites de crédibilité**, pas des pannes — et c'est précisément ce qui compte pour être cité par les moteurs de réponse.

Le point noir est unique et massif : **zéro citation de source externe sur les 48 pages**, y compris sur l'article intitulé « Décret BACS 2030 : toutes les sources officielles vérifiées et commentées », qui ne contenait aucun lien vers Légifrance. Les seuls liens sortants du site étaient `plausible.io` et un profil LinkedIn, tous deux dans le pied de page.

---

## 2. Défauts constatés et traitement

### 2.1 Corrigés dans ce lot

| # | Constat mesuré | Impact | Correctif |
|---|---|---|---|
| 1 | `author.name = "Super Admin"` dans le schema `Article` des 20 articles, et affiché sous chaque titre | E-E-A-T : l'auteur est le premier signal d'expertise lu par Google et par les moteurs de réponse | Migration `2026_08_15_000001` ciblant le compte par son nom (l'ancienne migration filtrait sur un e-mail absent en prod, elle n'a donc jamais rien fait) |
| 2 | `<lastmod>` = heure de génération sur les 28 routes statiques ; les 48 URLs annonçaient « modifiée à l'instant » à chaque crawl | Google déclare ignorer les `lastmod` qu'il juge non fiables, et la défiance porte sur le sitemap entier | `SitemapController` : vraie date d'édition, ou **absence** de balise si aucune date fiable n'existe |
| 3 | 16 titres d'articles de 65 à 103 c, 10 descriptions de 167 à 201 c | Titres tronqués puis réécrits par Google ; le message maîtrisé est perdu | Migration `2026_08_15_000002` (titres ≤ 48 c, descriptions ≤ 158 c). Seules les **métas** changent : les titres éditoriaux et les H1 sont intacts |
| 4 | 5 métas de pages statiques hors limites | idem | `StaticPageController::DEFAULT_SEO` + migration `2026_08_15_000003` |
| 5 | `BreadcrumbList` plat (2 niveaux) sur les 48 pages, articles compris ; le dernier maillon reprenait le title SEO, suffixe de marque inclus | La hiérarchie réelle du site n'était pas lisible | Composant `breadcrumb-schema` : 3 niveaux sur les articles (Accueil > Perspectives > article), suffixe de marque retiré, plus aucun fil sur l'accueil |
| 6 | `Organization` nommée « NéoGTB », `publisher` nommé « NeoGTB », `og:site_name` « NeoGTB » — trois graphies concurrentes, aucun `@id`, aucun nœud `WebSite` | Entité de marque fragmentée pour le Knowledge Graph | `@graph` liant `Organization` et `WebSite` par `@id`, avec `alternateName` et `inLanguage` |
| 7 | `wordCount` du schema `Article` calculé par `str_word_count()`, qui scinde chaque mot accentué en deux (« réglementation » → 2 mots) : **+28 % de surcompte** mesuré | Profondeur de contenu déclarée fausse | Comptage `\p{L}` en UTF-8 |
| 8 | **`neogtb.com` et `www.neogtb.com` résolvent vers le VPS (51.210.11.125) mais aucun bloc nginx ne les sert** : ni HTTP ni HTTPS ne répondent | 100 % du trafic .com perdu (saisie directe, signatures d'e-mail, liens de partenaires) | Bloc nginx de redirection 301 vers le .fr, **à activer après émission du certificat** (voir §4) |
| 9 | Aucune citation externe sur les pages réglementaires | Le levier de citation par IA le plus documenté | Composant `sources-officielles` + 6 sources sur `/decret-bacs`, 8 sur `/reglementation`, toutes vérifiées une par une |

**Vérification** : 15 tests dans `SeoTest` (11 existants + 4 ajoutés), tous au vert. Les nouveaux tests verrouillent les correctifs 2, 5 et 6.

### 2.2 Faux positifs écartés

- **« Images sans alt »** : la balise concernée porte `alt="" aria-hidden="true"`. C'est le marquage correct d'une image décorative, pas un défaut.
- **Légifrance en HTTP 403** : protection anti-robot côté Légifrance. Les URLs ont été confirmées par recherche avant intégration ; l'identifiant que j'avais d'abord retenu pour le décret 2025-1343 était erroné et a été remplacé par le bon (`JORFTEXT000053175245`).

---

## 3. Sources officielles intégrées

Toutes vérifiées avant publication.

| Source | URL |
|---|---|
| Décret n° 2025-1343 du 26 décembre 2025 (report à 2030) | `legifrance.gouv.fr/jorf/id/JORFTEXT000053175245` |
| Décret n° 2020-887 du 20 juillet 2020 (texte fondateur BACS) | `legifrance.gouv.fr/jorf/id/JORFTEXT000042128488` |
| Décret n° 2023-259 du 7 avril 2023 (seuil abaissé à 70 kW) | `legifrance.gouv.fr/jorf/id/JORFTEXT000047422489` |
| Décret n° 2019-771 du 23 juillet 2019 (décret tertiaire) | `legifrance.gouv.fr/jorf/id/JORFTEXT000038812251` |
| Articles R. 175-1 à R. 175-6 du CCH | `legifrance.gouv.fr/codes/section_lc/LEGITEXT000006074096/LEGISCTA000043819535/` |
| Présentation et guide du décret BACS | `rt-re-batiment.developpement-durable.gouv.fr/presentation-et-guide-du-decret-bacs-a712.html` |
| Mise à jour du calendrier BACS | `rt-re-batiment.developpement-durable.gouv.fr/bacs-thermostats-calorifugeage-mise-a-jour-du-a1216.html` |
| Éco Énergie Tertiaire | `ecologie.gouv.fr/politiques-publiques/eco-energie-tertiaire-eet` |
| Plateforme OPERAT | `operat.ademe.fr` |

---

## 4. À faire côté serveur (non applicable depuis le dépôt)

**Activer neogtb.com.** Le bloc HTTPS est présent mais **commenté** dans `admin/deploy/nginx-neogtb-laravel.conf` : sans certificat, nginx refuserait de démarrer.

```bash
# 1. Synchroniser la conf, puis émettre le certificat
sudo certbot --nginx -d neogtb.com -d www.neogtb.com
# 2. Décommenter le bloc 443 du fichier de conf
sudo nginx -t && sudo systemctl reload nginx
# 3. Contrôler
curl -sI https://neogtb.com/ | head -3   # attendu : 301 vers https://neogtb.fr/
```

**Appliquer les migrations** (elles touchent le contenu de la base de production) :

```bash
sudo -u www-data php artisan migrate --force
sudo -u www-data php artisan cache:clear   # indispensable : le JSON-LD Organization est en cache 1 h
```

---

## 5. Ce qui reste ouvert

Classé par rapport impact/effort.

1. **Étendre les citations aux 20 articles et aux pages piliers** (`/gtb`, `/gtc`, `/solutions`, guides, comparatifs). Le composant existe, il ne reste qu'à choisir les sources page par page. C'est le levier restant le plus fort.
2. **`FAQPage` absente des 20 articles** et des 4 pages piliers. Le composant `faq-schema` existe déjà et alimente affichage et schema depuis la même donnée : le coût est éditorial, pas technique.
3. **Pas de page index `/guide` ni `/comparatif`.** Conséquence directe : leur fil d'Ariane reste à 2 niveaux, faute de parent réel — je n'ai pas inventé de maillon vers une URL inexistante. Créer ces deux hubs améliorerait le maillage interne autant que le fil.
4. **`Cache-Control: no-cache, private` et cookie de session sur toutes les pages publiques.** Aucun cache edge possible sur des pages pourtant identiques pour tous. TTFB déjà excellent (0,18 s), donc gain limité — mais c'est du travail serveur gratuit économisé.
5. **`BreadcrumbComposer` (`app/View/Composers/`) est du code mort** : il calcule un `$breadcrumbs` complet, partagé sur toutes les vues `front.*`, que rien ne rend. À brancher ou à supprimer.
6. **Profondeur de contenu.** Plusieurs articles restent courts une fois le chrome déduit. Sur des requêtes réglementaires disputées, la profondeur reste un facteur de sélection.
7. **`sameAs` ne contient qu'un profil LinkedIn.** Toute présence supplémentaire vérifiable (annuaire professionnel, fiche entreprise) renforce la désambiguïsation d'entité.

---

## 6. Deux réserves à connaître

- **Deux tests échouaient déjà avant ce lot** : `SubmitContactMessageRequestTest > valid data passes` et `ExampleTest`. Vérifié par mise de côté de mes modifications : ils échouent à l'identique sans elles. Ils relèvent du travail en cours sur la branche (honeypot, base de test), pas de cet audit.
- **Aucune donnée d'audience réelle n'a été consultée** (Search Console, Plausible). Tout ce qui précède est déduit du code et du HTML servi. Les positions, impressions et pages réellement citées par les IA restent à confirmer côté Search Console.
