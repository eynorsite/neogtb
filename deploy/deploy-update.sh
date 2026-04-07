#!/usr/bin/env bash
# Déploie une nouvelle release NeoGTB depuis le code à jour de ~/neogtb
# Pré-requis : `git pull` déjà fait dans ~/neogtb
# Usage : sudo bash deploy/deploy-update.sh
set -euo pipefail

REPO_DIR="${REPO_DIR:-$HOME/neogtb}"
DEPLOY_ROOT="/var/www/neogtb"
SHARED_DIR="$DEPLOY_ROOT/shared/admin"
RELEASE_DIR="$DEPLOY_ROOT/releases/$(date +%Y%m%d-%H%M%S)"
PREVIOUS_RELEASE="$(readlink -f "$DEPLOY_ROOT/current" 2>/dev/null || echo "")"
KEEP_RELEASES="${KEEP_RELEASES:-5}"

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

echo "==> [2/9] Composer install (production)"
sudo -u www-data COMPOSER_ALLOW_SUPERUSER=0 composer install \
    --no-dev --optimize-autoloader --no-interaction --prefer-dist 2>&1 | tail -5

echo "==> [3/9] NPM install + build Vite"
sudo -u www-data npm ci --silent || sudo -u www-data npm install --silent
sudo -u www-data npm run build 2>&1 | tail -3

echo "==> [4/9] Symlinks shared (.env, storage, database SQLite)"
ln -sf "$SHARED_DIR/.env" "$RELEASE_DIR/admin/.env"
rm -rf "$RELEASE_DIR/admin/storage"
ln -sf "$SHARED_DIR/storage" "$RELEASE_DIR/admin/storage"
ln -sf "$SHARED_DIR/database/database.sqlite" "$RELEASE_DIR/admin/database/database.sqlite"

echo "==> [5/9] Permissions"
chown -R www-data:www-data "$RELEASE_DIR"
find "$RELEASE_DIR" -type d -exec chmod 755 {} \;
find "$RELEASE_DIR" -type f -exec chmod 644 {} \;
chmod -R 775 "$RELEASE_DIR/admin/bootstrap/cache"
# Le .sh et artisan restent exécutables
chmod +x "$RELEASE_DIR/admin/artisan" 2>/dev/null || true
find "$RELEASE_DIR/deploy" -name "*.sh" -exec chmod +x {} \; 2>/dev/null || true

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
cd "$DEPLOY_ROOT/releases"
ls -1t | tail -n +$((KEEP_RELEASES + 1)) | while read old; do
    echo "    🗑  rm $old"
    rm -rf "$old"
done

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
