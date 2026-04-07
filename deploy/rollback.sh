#!/usr/bin/env bash
# Rollback à la release précédente
# Usage : sudo bash rollback.sh
set -euo pipefail

DEPLOY_ROOT="/var/www/neogtb"
RELEASES_DIR="$DEPLOY_ROOT/releases"
CURRENT_LINK="$DEPLOY_ROOT/current"

PREVIOUS=$(ls -1t "$RELEASES_DIR" | sed -n '2p')
if [ -z "$PREVIOUS" ]; then
  echo "❌ Pas de release précédente trouvée"
  exit 1
fi

echo "==> Rollback vers $PREVIOUS"
ln -sfn "$RELEASES_DIR/$PREVIOUS" "$CURRENT_LINK"
nginx -t && systemctl reload nginx
echo "✅ Rollback effectué : current → $PREVIOUS"
