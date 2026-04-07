#!/usr/bin/env bash
# =============================================================================
# Deploy script — NeoGTB Admin (Laravel + Filament)
# -----------------------------------------------------------------------------
# À exécuter SUR LE VPS, dans /var/www/neogtb-admin (ou ton chemin).
#
# Usage :
#   cd /var/www/neogtb-admin
#   chmod +x deploy/deploy.sh
#   ./deploy/deploy.sh
#
# Pré-requis :
#   - php >= 8.2, composer, git
#   - .env présent et configuré (APP_KEY de PROD intacte, jamais régénérée)
#   - Backup base de données déjà effectué
#   - Worker supervisor configuré (voir deploy/supervisor-neogtb-worker.conf)
#   - Cron scheduler configuré (voir deploy/crontab-neogtb.txt)
#
# Le script :
#   1. Vérifie qu'on est dans un repo git Laravel
#   2. Met le site en maintenance avec un secret aléatoire
#   3. Pull le dernier code
#   4. Installe les deps prod (sans dev)
#   5. Lance les migrations (incluant la migration d'encryption rétroactive)
#   6. Cache config/route/view/event
#   7. Restart le worker queue (supervisor)
#   8. Sort de la maintenance
#   9. Smoke test sur l'URL admin
#
# IMPORTANT :
#   - Ne JAMAIS lancer `php artisan key:generate` sur le VPS (les données
#     chiffrées deviendraient illisibles).
#   - La migration encrypt_existing_pii est IDEMPOTENTE — ne casse rien si
#     relancée.
# =============================================================================

set -euo pipefail

# Couleurs
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

log()  { echo -e "${GREEN}[deploy]${NC} $*"; }
warn() { echo -e "${YELLOW}[deploy]${NC} $*"; }
err()  { echo -e "${RED}[deploy]${NC} $*" >&2; }

# -----------------------------------------------------------------------------
# 0. Sanity checks
# -----------------------------------------------------------------------------
if [ ! -f artisan ]; then
    err "Pas dans un projet Laravel (artisan introuvable). cd dans le bon dossier."
    exit 1
fi

if [ ! -f .env ]; then
    err ".env manquant. Créer .env avec l'APP_KEY de prod existante."
    exit 1
fi

if ! command -v composer >/dev/null 2>&1; then
    err "composer introuvable dans le PATH."
    exit 1
fi

if ! command -v php >/dev/null 2>&1; then
    err "php introuvable dans le PATH."
    exit 1
fi

PHP_VERSION=$(php -r 'echo PHP_VERSION;')
log "PHP version : $PHP_VERSION"

APP_URL=$(grep -E '^APP_URL=' .env | cut -d '=' -f2- | tr -d '"' || echo "")
log "APP_URL : ${APP_URL:-(non défini)}"

# -----------------------------------------------------------------------------
# 1. Backup APP_KEY (sécurité)
# -----------------------------------------------------------------------------
APP_KEY=$(grep -E '^APP_KEY=' .env | cut -d '=' -f2- || echo "")
if [ -z "$APP_KEY" ]; then
    err "APP_KEY absent du .env. Refus de déployer."
    exit 1
fi
log "APP_KEY présente (longueur ${#APP_KEY})."

# -----------------------------------------------------------------------------
# 2. Mode maintenance
# -----------------------------------------------------------------------------
MAINT_SECRET=$(openssl rand -hex 16)
log "Activation mode maintenance (secret bypass : $MAINT_SECRET)"
php artisan down --secret="$MAINT_SECRET" --render="errors::503" || warn "down a échoué (peut-être déjà down)"

# Trap : si quoi que ce soit foire, on remonte la maintenance
cleanup() {
    local code=$?
    if [ $code -ne 0 ]; then
        err "Échec déploiement (code $code). Sortie maintenance."
        php artisan up || true
    fi
}
trap cleanup EXIT

# -----------------------------------------------------------------------------
# 3. Git pull
# -----------------------------------------------------------------------------
log "Git pull..."
git fetch origin
CURRENT_BRANCH=$(git rev-parse --abbrev-ref HEAD)
log "Branche actuelle : $CURRENT_BRANCH"
git pull --ff-only origin "$CURRENT_BRANCH"

# -----------------------------------------------------------------------------
# 4. Composer install (prod)
# -----------------------------------------------------------------------------
log "Composer install (no-dev, optimisé)..."
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# -----------------------------------------------------------------------------
# 5. Migrations (incluant encryption rétroactive)
# -----------------------------------------------------------------------------
log "Migrations en cours..."
warn "La migration encrypt_existing_pii peut prendre du temps (chunk de 200 lignes par table)."
php artisan migrate --force

# -----------------------------------------------------------------------------
# 6. Cache Laravel
# -----------------------------------------------------------------------------
log "Cache Laravel..."
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
php artisan view:clear
php artisan view:cache
php artisan event:clear
php artisan event:cache || true   # ignore si pas d'events à cacher

# -----------------------------------------------------------------------------
# 7. Permissions storage
# -----------------------------------------------------------------------------
log "Fix permissions storage/ et bootstrap/cache..."
if [ "$(whoami)" = "root" ] || sudo -n true 2>/dev/null; then
    sudo chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
    sudo chmod -R 775 storage bootstrap/cache 2>/dev/null || true
else
    warn "Pas de sudo dispo, skip chown. À faire manuellement si besoin."
fi

# -----------------------------------------------------------------------------
# 8. Restart worker queue (supervisor)
# -----------------------------------------------------------------------------
if command -v supervisorctl >/dev/null 2>&1; then
    log "Restart worker neogtb-worker via supervisor..."
    sudo supervisorctl restart neogtb-worker:* 2>/dev/null || warn "Worker non démarré (configurer deploy/supervisor-neogtb-worker.conf)."
else
    warn "supervisorctl absent. Worker queue NON démarré → les jobs ne seront pas exécutés."
    warn "Voir deploy/supervisor-neogtb-worker.conf pour la config."
fi

# -----------------------------------------------------------------------------
# 9. Sortie maintenance
# -----------------------------------------------------------------------------
log "Sortie mode maintenance..."
php artisan up

# Désactiver le trap (succès)
trap - EXIT

# -----------------------------------------------------------------------------
# 10. Smoke test
# -----------------------------------------------------------------------------
if [ -n "$APP_URL" ]; then
    log "Smoke test : curl -I $APP_URL/admin/login"
    if command -v curl >/dev/null 2>&1; then
        HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" "$APP_URL/admin/login" || echo "000")
        if [ "$HTTP_CODE" = "200" ] || [ "$HTTP_CODE" = "302" ]; then
            log "✅ Smoke test OK (HTTP $HTTP_CODE)"
        else
            warn "⚠️  Smoke test inattendu : HTTP $HTTP_CODE"
        fi
    fi
fi

log "✅ Déploiement terminé."
log ""
log "Prochaines vérifications manuelles :"
log "  1. Tester la connexion admin sur $APP_URL/admin/login"
log "  2. Vérifier qu'aucune ligne ne crashe en affichage (ContactMessage, GdprRequest, etc.)"
log "  3. Vérifier le worker : sudo supervisorctl status neogtb-worker:*"
log "  4. Vérifier le cron : sudo grep CRON /var/log/syslog | tail"
log "  5. Tester un envoi de formulaire contact pour valider la queue"
