#!/usr/bin/env bash
# Clone le code NeoGTB et installe les dépendances applicatives
# Usage : sudo bash 02-clone-code.sh
set -euo pipefail

REPO_URL="${REPO_URL:-https://github.com/eynorsite/neogtb.git}"
DEPLOY_ROOT="/var/www/neogtb"
RELEASE_DIR="$DEPLOY_ROOT/releases/$(date +%Y%m%d-%H%M%S)"

echo "==> [1/3] Création de l'arborescence"
mkdir -p "$DEPLOY_ROOT/releases" "$DEPLOY_ROOT/shared"
mkdir -p "$DEPLOY_ROOT/shared/admin/storage" "$DEPLOY_ROOT/shared/admin/database"

echo "==> [2/3] Clone du repo dans $RELEASE_DIR"
git clone --depth 1 "$REPO_URL" "$RELEASE_DIR"

echo "==> [3/3] Installation dépendances Laravel (admin)"
cd "$RELEASE_DIR/admin"
composer install --no-dev --optimize-autoloader --no-interaction
npm ci || npm install
npm run build  # Vite assets admin

echo ""
echo "✅ Code cloné dans : $RELEASE_DIR"
echo "Prochaine étape : sudo RELEASE_DIR=$RELEASE_DIR bash 03-setup-laravel.sh"
