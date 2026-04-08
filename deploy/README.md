# Déploiement NeoGTB sur VPS

**Statut** : scripts prêts à exécuter, pas encore lancés (besoin d'accès SSH au VPS).

## Script canonique : `deploy/deploy-update.sh`

Pour toute mise à jour en prod après le premier déploiement, **un seul script**
fait foi : `deploy/deploy-update.sh` (releases atomiques, symlink `current`,
mode maintenance, migrations, queue:restart, smoke test HTTP, rollback auto).

```bash
sudo bash deploy/deploy-update.sh
```

Il gère lui-même le `git pull` dans `~/neogtb` (refus si dirty), donc plus
besoin de pull à la main avant.

> `admin/deploy/deploy.sh` est **DEPRECATED** et refuse de s'exécuter en
> mode interactif. Conservé pour référence historique seulement.

## Architecture cible (100% Laravel)

```
neogtb.fr  ─┐
            │  Nginx (HTTPS Let's Encrypt)
www.neogtb.fr ─┤
            │
            └─ /  → Laravel (PHP-FPM)
                   root: /var/www/neogtb/current/admin/public
                   sert front public + admin Filament + storage
```

Astro a été retiré : tout (pages publiques et back-office) est servi par Laravel.

## Pré-requis VPS

- Ubuntu 22.04+ ou Debian 12+
- 2 vCPU / 2 Go RAM minimum
- Accès root SSH
- Domaine `neogtb.fr` + `www.neogtb.fr` pointé vers l'IP du VPS (DNS A records)

## Étapes (à lancer dans l'ordre)

1. **Installer dépendances** : `sudo bash 01-install-deps.sh`
   (Nginx, Certbot, PHP 8.3 + extensions, Composer, Node.js 20 pour Vite admin, UFW)
2. **Cloner le code** : `sudo bash 02-clone-code.sh`
   (clone du repo + `composer install` + `npm ci && npm run build` dans `admin/`)
3. **Configurer Laravel** : `sudo RELEASE_DIR=... bash 03-setup-laravel.sh`
   (.env, APP_KEY, migrations, seed, cache, symlink `current`)
4. **Configurer Nginx + SSL** : `sudo bash 04-nginx-ssl.sh`
5. **Vérifier** : `curl -I https://neogtb.fr` doit retourner 200

## Tests post-déploiement

- [ ] `https://neogtb.fr` charge la home (servie par Laravel)
- [ ] `https://neogtb.fr/admin` charge le login Filament
- [ ] `https://neogtb.fr/audit` charge le wizard
- [ ] Soumettre formulaire contact → mail reçu sur `hello@neogtb.fr`
- [ ] Soumettre newsletter → mail reçu
- [ ] `curl -I https://neogtb.fr/sitemap-index.xml` retourne 200
- [ ] Score Lighthouse > 90 sur la home

## Scheduler Laravel + worker queue (cron + supervisor)

Les fichiers de config vivent dans `admin/deploy/` et pointent sur le chemin
de release atomique `/var/www/neogtb/current/admin` (symlink géré par
`deploy-update.sh`). Ils doivent être (ré)installés **une fois** sur le VPS,
après le premier déploiement — ensuite ils suivent automatiquement chaque
nouvelle release via le symlink `current`.

### Réinstallation (après correction des chemins)

Un bug historique faisait pointer ces fichiers sur `/var/www/neogtb-admin`
(chemin inexistant en prod). Résultat : scheduler et worker tournaient à vide.
Après avoir `git pull` sur le VPS (ou déployé une release qui contient le
fix), rejouer :

```bash
# 1. Scheduler Laravel (cron www-data)
sudo crontab -u www-data /var/www/neogtb/current/admin/deploy/crontab-neogtb.txt
sudo crontab -u www-data -l   # vérifier

# 2. Worker queue (supervisor)
sudo cp /var/www/neogtb/current/admin/deploy/supervisor-neogtb-worker.conf \
        /etc/supervisor/conf.d/neogtb-worker.conf
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl restart neogtb-worker:*
sudo supervisorctl status neogtb-worker:*
```

### Vérifications

```bash
# Cron a bien tiqué dans la dernière minute
sudo grep CRON /var/log/syslog | tail

# Logs du worker
tail -f /var/www/neogtb/current/admin/storage/logs/worker.log
```

Note : le binaire PHP est figé sur `/usr/bin/php` dans les deux fichiers
(cohérent avec `deploy-update.sh` qui utilise `php` tout court via le PATH
de `www-data`). Si le VPS utilise un binaire versionné (`/usr/bin/php8.4`),
adapter les deux fichiers avant réinstallation.

## Rollback

Si problème : `sudo bash rollback.sh` restaure la version précédente (via symlinks `current` → `releases/<timestamp>`).
