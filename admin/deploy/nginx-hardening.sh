#!/usr/bin/env bash
# Hardening sécurité nginx neogtb.fr
# - Backup auto
# - Test syntax avant reload
# - Rollback automatique si test échoue

set -euo pipefail

CONF_SRC="${CONF_SRC:-$(dirname "$0")/nginx-neogtb.conf}"
TARGET="/etc/nginx/sites-enabled/neogtb"
TS=$(date +%Y%m%d-%H%M%S)
BACKUP_DIR="/root/nginx-backup-$TS"

if [[ ! -f "$CONF_SRC" ]]; then
    echo "❌ Fichier source introuvable : $CONF_SRC"
    exit 1
fi

echo "📦 Backup vers $BACKUP_DIR"
sudo mkdir -p "$BACKUP_DIR"
sudo cp -a /etc/nginx/sites-available "$BACKUP_DIR/"
sudo cp -a /etc/nginx/sites-enabled    "$BACKUP_DIR/"

echo "📝 Installation nouvelle config..."
sudo cp "$CONF_SRC" "$TARGET"

echo "🧪 Test syntax nginx..."
if ! sudo nginx -t; then
    echo "⚠️  Test échoué, rollback..."
    sudo cp "$BACKUP_DIR/sites-enabled/neogtb" "$TARGET"
    sudo nginx -t
    echo "↩️  Rollback effectué."
    exit 1
fi

echo "♻️  Reload nginx..."
sudo systemctl reload nginx

echo ""
echo "✅ Done. Backup conservé dans $BACKUP_DIR"
echo ""
echo "🔍 Vérification headers :"
curl -sI https://www.neogtb.fr/ | grep -iE "strict-transport|content-security|cross-origin|x-frame|x-content|referrer|permissions" || true
echo ""
curl -s  https://www.neogtb.fr/.well-known/security.txt
