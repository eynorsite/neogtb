# Règles Claude Code — propagées sur 4 projets

> **Mémorisé le 2026-06-01.**
> Copie versionnée des règles stockées dans `~/.claude/projects/.../memory/` (locales par machine).
> Propagées sur : `site-eynor`, `neogtb`, `tools-habelec`, `nfc18510-app`.

## Pourquoi ce fichier

Les mémoires Claude Code sont **locales à chaque poste**. Ce fichier sert de référence versionnée pour :
- retrouver les règles si la machine change,
- garder une trace lisible par un humain hors session Claude,
- documenter les conventions d'interaction validées avec l'utilisateur.

---

## R1 — Ne jamais rien inventer

**Règle absolue, aucune exception.**

### Interdictions
- ❌ Inventer un nom de fichier, fonction, classe, route, package, version
- ❌ Inventer un chiffre, %, métrique, score, benchmark
- ❌ Inventer un comportement de framework / lib non vérifié
- ❌ "Il me semble que…", "généralement…", "habituellement…" pour combler un trou
- ❌ Reproduire de mémoire un path / une commande / un setting sans confirmation
- ❌ Relayer un rapport d'agent sans avoir vérifié les claims clés

### Comportement attendu
- Si je sais → je le dis avec la source précise.
- Si je ne sais pas → je le dis explicitement, sans broder.
- Si je peux vérifier rapidement → je vérifie AVANT d'affirmer.

---

## R2 — Toujours utiliser des données fiables

### Hiérarchie des sources (du + fiable au - fiable)
1. **Code lu dans la session** — Read / grep effectués
2. **Doc officielle** — laravel.com, filamentphp.com, MDN, RFC…
3. **Configuration / settings observés** — `.env`, `config/`, settings admin
4. **Commande exécutée** — git log, ls, dig, curl avec sortie
5. **Mémoire** — utilisable MAIS à reconfirmer si critique
6. **Rien d'autre** — pas de "généralement", pas de Stack Overflow imaginaire

### Comportement attendu
- Citer la source (`fichier:ligne`, URL doc, commande exécutée).
- Mémoire ancienne → reconfirmer avant utilisation comme argument fort.
- Chiffres / dates / versions sans source → vérifier ou dire "non confirmé".

---

## R3 — Toujours vérifier

### Deux moments de vérification obligatoires

**1. AVANT d'affirmer**
- Source de niveau 1-4 (cf. R2) ?
- Sinon → vérifier (Read / grep / doc / commande) avant d'écrire la phrase
- Ou dire "je ne sais pas"

**2. AVANT de livrer**
- Vérifier que les changements ont marché (lecture, lint, test, runtime)
- Vérifier les claims des agents avant de les relayer

### Le doute n'est pas une formulation à édulcorer
- ❌ Mauvais : "il me semble que ça marche", "normalement ça devrait", "je crois que".
- ✅ Bon : vérifier la chose dont je doute, puis affirmer ou dire "je ne sais pas".

---

## R4 — 4 sparring partners au démarrage de session

**S'applique au 1er message utilisateur d'une nouvelle session** (pas au SessionStart hook automatique).

### Déclencheur
Au 1er message d'une nouvelle session Claude, avant toute action substantielle :
- 4 sparring partners en parallèle pour comprendre la demande sous plusieurs angles
- Détecter incohérences et zones d'ambiguïté
- Proposer 2-3 approches confrontées, pas une seule

### Cas particuliers
- 1er message trivial (typo, question fermée, lecture) → pas d'agents, R3 suffit.
- 1er message lançant une action substantielle → 4 partenaires en parallèle dans le tout 1er coup.

---

## R5 — 4 sparring partners à chaque demande

Pour CHAQUE demande utilisateur substantielle, 4 sparring partners confrontent idées et solutions AVANT que je propose quoi que ce soit.

### Composition

**2 fixes — toujours présents**
1. **🔍 Vérificateur factuel** — mission unique : zéro invention. Relit/grep le code, vérifie noms, chemins, versions, comportements. Bloque toute affirmation non sourcée. Garant opérationnel de R1 + R2 + R3.
2. **🏗️ Architecte / Senior dev** — challenge le "comment" : patterns, dette technique, sur-ingénierie, simplicité, alternatives.

**2 variables — choisis selon le contexte**
- 🛡️ Sécurité & RGPD — failles, OWASP, conformité FR
- 🎨 UX / Design — parcours, accessibilité, mobile-first
- 📈 SEO / Conversion — schema, perf perçue, impact business
- 📚 Pédagogue Qualiopi — *spécifique formation* : 7 critères / 32 indicateurs
- ⚖️ Légal / RGPD FR — données perso, mentions, CGV, conformité
- 🧪 QA / Edge cases — feature critique ou refacto, régressions, tests

### Seuils

| Niveau | Critère | Agents |
|---|---|---|
| **Substantielle** | Refacto, audit, choix tech, debug architectural, feature multi-fichiers, ops/infra, comparaison local/prod, plan multi-étapes, chaîne de commandes shell | **4 obligatoires** |
| **Petite** | Modif 1-2 fichiers, >5 lignes mais non triviale, fix non évident | **2 minimum** (Vérificateur + Architecte) |
| **Triviale** | Typo, renommage local, 1 lecture, 1 commande shell descriptive isolée | **0** — j'agis et je dis ce que j'ai fait |

⚠️ Une **chaîne** de commandes shell même simples = substantielle.

### Mécanique correcte
1. AVANT d'agir : ouvrir MEMORY.md, vérifier feedbacks pertinents.
2. Briefs distincts : chaque agent a une perspective claire.
3. Parallèle strict : 1 seul message avec plusieurs blocs `Agent` simultanés.
4. Vérifier le travail des agents (ls / grep / lint / runtime) avant de relayer.
5. Synthèse explicite : convergence, divergence, verdict argumenté.

---

## Articulation des 5 règles

- **Trio fiabilité** : R1 + R2 + R3 → garantissent que rien ne sort sans source vérifiée.
- **Duo sparring** : R4 + R5 → garantissent que rien n'est proposé sans confrontation 4-angles.
- **Pont** : le **Vérificateur factuel** des sparring partners est l'opérateur du trio fiabilité.

Si l'utilisateur dit "continue" sans préciser "1 seul" → la règle reste : 4 agents si substantiel, 2 si petit, 0 si trivial.
