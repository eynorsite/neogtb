#!/usr/bin/env bash
# Déploie une nouvelle release NeoGTB depuis le code à jour de ~/neogtb
# Pré-requis : `git pull` déjà fait dans ~/neogtb
# Usage : sudo bash deploy/deploy-update.sh
set -euo pipefail

# Empêche 2 déploiements simultanés (lock fd 9 sur /var/lock/neogtb-deploy.lock).
# Si le lock est déjà pris, le 2e deploy abort proprement au lieu de croiser.
LOCK_FILE="/var/lock/neogtb-deploy.lock"
exec 9>"$LOCK_FILE"
if ! flock -n 9; then
    echo "❌ Un autre déploiement NeoGTB est déjà en cours (lock $LOCK_FILE). Abort."
    exit 1
fi

# SUDO_USER = utilisateur qui a invoqué sudo (ex: ubuntu) → on cherche son $HOME
INVOKING_USER="${SUDO_USER:-$USER}"
INVOKING_HOME=$(getent passwd "$INVOKING_USER" | cut -d: -f6)
REPO_DIR="${REPO_DIR:-${INVOKING_HOME:-$HOME}/neogtb}"
DEPLOY_ROOT="/var/www/neogtb"
SHARED_DIR="$DEPLOY_ROOT/shared/admin"
RELEASE_DIR="$DEPLOY_ROOT/releases/$(date +%Y%m%d-%H%M%S)"
PREVIOUS_RELEASE="$(readlink -f "$DEPLOY_ROOT/current" 2>/dev/null || echo "")"
KEEP_RELEASES="${KEEP_RELEASES:-5}"

# Sanitize KEEP_RELEASES : doit être un entier positif. Sinon fallback à 5.
if ! [[ "$KEEP_RELEASES" =~ ^[0-9]+$ ]]; then
    echo "⚠  KEEP_RELEASES='$KEEP_RELEASES' invalide (entier positif attendu) → fallback 5"
    KEEP_RELEASES=5
fi

if [ ! -d "$REPO_DIR" ]; then
    echo "❌ Repo introuvable : $REPO_DIR (set REPO_DIR=... si chemin différent)"
    exit 1
fi

if [ ! -d "$SHARED_DIR" ]; then
    echo "❌ Shared dir introuvable : $SHARED_DIR (déploiement initial pas fait ?)"
    exit 1
fi

echo "==> [1/9] Création release : $RELEASE_DIR"
mkdir -p "$RELEASE_DIR"
# Copie le code (sans .git ni node_modules ni vendor pour rester léger)
rsync -a --delete \
    --exclude='.git' \
    --exclude='node_modules' \
    --exclude='vendor' \
    --exclude='admin/storage/logs/*' \
    --exclude='admin/storage/framework/cache/*' \
    --exclude='admin/storage/framework/sessions/*' \
    --exclude='admin/storage/framework/views/*' \
    --exclude='admin/database/database.sqlite' \
    "$REPO_DIR/" "$RELEASE_DIR/"

cd "$RELEASE_DIR/admin"

echo "==> [2/9] Permissions initiales (avant composer/npm)"
chown -R www-data:www-data "$RELEASE_DIR"
find "$RELEASE_DIR" -type d -exec chmod 755 {} \;
find "$RELEASE_DIR" -type f -exec chmod 644 {} \;
chmod -R 775 "$RELEASE_DIR/admin/bootstrap/cache"
chmod +x "$RELEASE_DIR/admin/artisan" 2>/dev/null || true
find "$RELEASE_DIR/deploy" -name "*.sh" -exec chmod +x {} \; 2>/dev/null || true

echo "==> [3/9] Composer install (production)"
sudo -u www-data -H COMPOSER_ALLOW_SUPERUSER=0 COMPOSER_HOME=/tmp/composer composer install \
    --no-dev --optimize-autoloader --no-interaction --prefer-dist 2>&1 | tail -5

echo "==> [4/9] NPM install + build Vite"
sudo -u www-data -H npm ci --silent 2>&1 | tail -3 || sudo -u www-data -H npm install --silent 2>&1 | tail -3
sudo -u www-data -H npm run build 2>&1 | tail -3

echo "==> [5/9] Symlinks shared (.env, storage, database SQLite)"
ln -sf "$SHARED_DIR/.env" "$RELEASE_DIR/admin/.env"
rm -rf "$RELEASE_DIR/admin/storage"
ln -sf "$SHARED_DIR/storage" "$RELEASE_DIR/admin/storage"
ln -sf "$SHARED_DIR/database/database.sqlite" "$RELEASE_DIR/admin/database/database.sqlite"
chown -h www-data:www-data "$RELEASE_DIR/admin/.env" "$RELEASE_DIR/admin/storage" "$RELEASE_DIR/admin/database/database.sqlite"

echo "==> [6/9] Migrations + storage:link"
sudo -u www-data php artisan migrate --force 2>&1 | tail -10
sudo -u www-data php artisan storage:link 2>&1 | tail -3 || true

echo "==> [7/9] Cache config + routes + views (atomique avant swap)"
sudo -u www-data php artisan config:clear
sudo -u www-data php artisan route:clear
sudo -u www-data php artisan view:clear
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache
sudo -u www-data php artisan event:cache 2>&1 | tail -3 || true

echo "==> [8/9] Swap atomique : current → $RELEASE_DIR"
ln -sfn "$RELEASE_DIR" "$DEPLOY_ROOT/current"

# Reload PHP-FPM (détecte la version installée) + Nginx
PHP_FPM_SERVICE=$(systemctl list-unit-files 'php*-fpm.service' --no-legend 2>/dev/null | awk '{print $1}' | head -1)
if [ -n "$PHP_FPM_SERVICE" ]; then
    systemctl reload "$PHP_FPM_SERVICE" || systemctl restart "$PHP_FPM_SERVICE"
fi
nginx -t && systemctl reload nginx

echo "==> [9/9] Cleanup anciennes releases (garde les $KEEP_RELEASES dernières)"
# Tri par NOM (les noms sont YYYYMMDD-HHMMSS donc lexicographique == chronologique).
# Évite le piège `ls -1t` qui trie par mtime — peu fiable car rsync/chown ne
# touchent pas au mtime du dossier parent → la release qu'on vient de créer
# peut apparaître comme "la plus vieille" et se faire supprimer juste après
# le swap. Triple garde-fou : on skip explicitement la release courante
# (CURRENT_NAME) et la cible du symlink courant (CURRENT_TARGET) pour zéro
# risque même si KEEP_RELEASES=0.
CURRENT_NAME="$(basename "$RELEASE_DIR")"
CURRENT_TARGET="$(readlink -f "$DEPLOY_ROOT/current" 2>/dev/null || echo "")"
mapfile -t ALL_RELEASES < <(find "$DEPLOY_ROOT/releases" -mindepth 1 -maxdepth 1 -type d -printf '%f\n' | LC_ALL=C sort)
TOTAL=${#ALL_RELEASES[@]}
TO_REMOVE=$(( TOTAL - KEEP_RELEASES ))
if (( TO_REMOVE > 0 )); then
    for old in "${ALL_RELEASES[@]:0:TO_REMOVE}"; do
        # Triple garde-fou : jamais la release courante, jamais la cible du symlink
        if [ "$old" = "$CURRENT_NAME" ] || [ "$DEPLOY_ROOT/releases/$old" = "$CURRENT_TARGET" ]; then
            echo "    ⚠  skip $old (release courante)"
            continue
        fi
        echo "    🗑  rm $old"
        # || true : un rm bloqué (fichier busy) ne doit PAS faire crasher le script
        # alors que le swap [8/9] est déjà fait et la prod sert la nouvelle release.
        rm -rf -- "$DEPLOY_ROOT/releases/$old" || echo "    ⚠  rm $old a échoué (ignoré)"
    done
else
    echo "    (rien à supprimer, $TOTAL releases ≤ $KEEP_RELEASES)"
fi

echo ""
echo "✅ Déploiement terminé."
echo "   Release : $RELEASE_DIR"
echo "   Précédente (rollback) : $PREVIOUS_RELEASE"
echo ""
echo "Tests :"
echo "  curl -I https://neogtb.fr"
echo ""
echo "Rollback si problème :"
echo "  sudo ln -sfn $PREVIOUS_RELEASE /var/www/neogtb/current && sudo systemctl reload nginx"
