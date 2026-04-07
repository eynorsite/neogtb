# Déploiement NeoGTB sur VPS

**Statut** : scripts prêts à exécuter, pas encore lancés (besoin d'accès SSH au VPS).

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

## Rollback

Si problème : `sudo bash rollback.sh` restaure la version précédente (via symlinks `current` → `releases/<timestamp>`).
