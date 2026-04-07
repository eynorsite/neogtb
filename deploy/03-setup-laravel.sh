#!/usr/bin/env bash
# Configure Laravel : .env, APP_KEY, migrations, seed, cache, permissions
# Usage : sudo RELEASE_DIR=/var/www/neogtb/releases/<timestamp> bash 03-setup-laravel.sh
set -euo pipefail

: "${RELEASE_DIR:?RELEASE_DIR doit être défini}"
ADMIN_DIR="$RELEASE_DIR/admin"
SHARED_DIR="/var/www/neogtb/shared/admin"

cd "$ADMIN_DIR"

echo "==> [1/6] Création .env (si absent dans shared)"
if [ ! -f "$SHARED_DIR/.env" ]; then
  cp .env.example "$SHARED_DIR/.env"
  echo "⚠️  EDITEZ $SHARED_DIR/.env AVANT DE CONTINUER (DB, MAIL, APP_URL=https://neogtb.fr, APP_ENV=production, APP_DEBUG=false)"
  echo "    Puis relancez ce script."
  exit 1
fi

ln -sf "$SHARED_DIR/.env" "$ADMIN_DIR/.env"

echo "==> [2/6] APP_KEY si absent"
if ! grep -q "^APP_KEY=base64:" "$SHARED_DIR/.env"; then
  php artisan key:generate --force
fi

echo "==> [3/6] Storage symlink + permissions"
rm -rf "$ADMIN_DIR/storage"
ln -sf "$SHARED_DIR/storage" "$ADMIN_DIR/storage"
mkdir -p "$SHARED_DIR/storage/framework/"{cache,sessions,views,testing}
mkdir -p "$SHARED_DIR/storage/logs" "$SHARED_DIR/storage/app/public"
chown -R www-data:www-data "$SHARED_DIR/storage"
chmod -R 775 "$SHARED_DIR/storage"

echo "==> [4/6] DB SQLite + migrations + seed"
mkdir -p "$SHARED_DIR/database"
touch "$SHARED_DIR/database/database.sqlite"
chown www-data:www-data "$SHARED_DIR/database/database.sqlite"
ln -sf "$SHARED_DIR/database/database.sqlite" "$ADMIN_DIR/database/database.sqlite"
php artisan migrate --force
php artisan db:seed --force --class=DatabaseSeeder
php artisan db:seed --force --class=HomePageSeeder
php artisan storage:link

echo "==> [5/6] Cache config + routes + views"
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo "==> [6/6] Symlink current → release"
ln -sfn "$RELEASE_DIR" "/var/www/neogtb/current"

echo ""
echo "✅ Laravel prêt. Storage : $SHARED_DIR/storage, DB : $SHARED_DIR/database/database.sqlite"
echo "Prochaine étape : sudo bash 04-nginx-ssl.sh"
