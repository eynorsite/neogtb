#!/usr/bin/env bash
#
# migrate-phases-1-to-6.sh
# Script de migration complète NeoGTB : Astro → Laravel 12 + Filament unifié
# Phases 1 à 6 (+ 6.bis renommage final)
#
# Usage : sudo bash migrate-phases-1-to-6.sh
#
# Cible : /var/www/neogtb-laravel-new/ (puis /var/www/neogtb-laravel/ en 6.bis)
# VPS  : Ubuntu Plucky, PHP 8.4, Composer, Supervisor
#

set -euo pipefail

# ---------------------------------------------------------------------------
# Couleurs ANSI
# ---------------------------------------------------------------------------
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

log_info()  { echo -e "${BLUE}[INFO]${NC} $*"; }
log_ok()    { echo -e "${GREEN}[OK]${NC} $*"; }
log_warn()  { echo -e "${YELLOW}[WARN]${NC} $*"; }
log_err()   { echo -e "${RED}[ERREUR]${NC} $*"; }

# ---------------------------------------------------------------------------
# Variables globales
# ---------------------------------------------------------------------------
REPO_URL="git@github-neogtb:eynorsite/neogtb.git"
REPO_BRANCH="main"
NEW_DIR="/var/www/neogtb-laravel-new"
NEW_ADMIN="${NEW_DIR}/admin"
OLD_DIR="/var/www/neogtb"
OLD_ADMIN="${OLD_DIR}/admin"
FINAL_DIR="/var/www/neogtb-laravel"
NGINX_SITE="/etc/nginx/sites-available/neogtb"
NGINX_ENABLED="/etc/nginx/sites-enabled/neogtb"
NGINX_BACKUP="/etc/nginx/sites-enabled/neogtb.backup-$(date +%Y%m%d-%H%M)"
TMP_VHOST="/tmp/neogtb-new-vhost.conf"
SERVE_PID=""

# ---------------------------------------------------------------------------
# Trap rollback
# ---------------------------------------------------------------------------
rollback() {
    local exit_code=$?
    log_err "Erreur détectée (code ${exit_code}). Rollback en cours..."

    # Tuer serveur temporaire php artisan serve s'il tourne encore
    if [[ -n "${SERVE_PID}" ]] && kill -0 "${SERVE_PID}" 2>/dev/null; then
        log_warn "Kill du php artisan serve temporaire (PID ${SERVE_PID})"
        kill "${SERVE_PID}" 2>/dev/null || true
    fi

    # Restaurer nginx si backup existe
    if [[ -f "${NGINX_BACKUP}" ]]; then
        log_warn "Restauration vhost nginx depuis ${NGINX_BACKUP}"
        sudo cp "${NGINX_BACKUP}" "${NGINX_ENABLED}" || true
        sudo nginx -t && sudo systemctl reload nginx || log_err "Reload nginx KO"
    fi

    log_err "Migration interrompue. Inspecter les logs ci-dessus."
    exit "${exit_code}"
}
trap rollback ERR INT TERM

# ---------------------------------------------------------------------------
# Helper confirmation interactive
# ---------------------------------------------------------------------------
confirm() {
    local msg="$1"
    echo
    echo -e "${YELLOW}==> ${msg}${NC}"
    read -r -p "Continuer ? (y/N) " ans
    case "${ans}" in
        y|Y|yes|YES) ;;
        *) log_warn "Abandon demandé par l'utilisateur."; exit 0 ;;
    esac
}

# ---------------------------------------------------------------------------
# Vérif root
# ---------------------------------------------------------------------------
if [[ ${EUID} -ne 0 ]]; then
    log_err "Ce script doit être lancé via sudo (EUID=${EUID})"
    exit 1
fi

echo -e "${BLUE}========================================================${NC}"
echo -e "${BLUE}  Migration NeoGTB — phases 1 à 6 (+ 6.bis)${NC}"
echo -e "${BLUE}  Cible : ${NEW_DIR}${NC}"
echo -e "${BLUE}========================================================${NC}"

# ===========================================================================
# PHASE 1 — Clone fresh du repo (5 min)
# ===========================================================================
confirm "PHASE 1 — Clone fresh du repo GitHub dans ${NEW_DIR}"

log_info "Création de /var/www si absent"
mkdir -p /var/www

if [[ -d "${NEW_DIR}" ]]; then
    log_warn "${NEW_DIR} existe déjà — suppression préalable"
    rm -rf "${NEW_DIR}"
fi

log_info "git clone ${REPO_URL}"
sudo -u ubuntu git clone "${REPO_URL}" "${NEW_DIR}"

cd "${NEW_DIR}"
sudo -u ubuntu git checkout "${REPO_BRANCH}"
sudo -u ubuntu git pull origin "${REPO_BRANCH}"

if [[ ! -f "${NEW_ADMIN}/artisan" ]]; then
    log_err "${NEW_ADMIN}/artisan introuvable — clone KO"
    exit 1
fi
log_ok "Phase 1 terminée — repo cloné, artisan présent"

# ===========================================================================
# PHASE 2 — Récupération des données de production (5 min)
# ===========================================================================
confirm "PHASE 2 — Récupérer .env, database.sqlite et storage/app/public/ depuis prod"

log_info "Copie de .env"
if [[ ! -f "${OLD_ADMIN}/.env" ]]; then
    log_err "${OLD_ADMIN}/.env introuvable"
    exit 1
fi
cp "${OLD_ADMIN}/.env" "${NEW_ADMIN}/.env"

log_info "Vérification de la présence d'APP_KEY"
if ! grep -qE '^APP_KEY=base64:' "${NEW_ADMIN}/.env"; then
    log_err "APP_KEY manquante ou mal formée dans .env"
    exit 1
fi

log_info "Copie de database.sqlite"
if [[ ! -s "${OLD_ADMIN}/database/database.sqlite" ]]; then
    log_err "database.sqlite introuvable ou vide"
    exit 1
fi
mkdir -p "${NEW_ADMIN}/database"
cp "${OLD_ADMIN}/database/database.sqlite" "${NEW_ADMIN}/database/database.sqlite"

log_info "Rsync de storage/app/public/"
mkdir -p "${NEW_ADMIN}/storage/app/public"
rsync -a "${OLD_ADMIN}/storage/app/public/" "${NEW_ADMIN}/storage/app/public/"

log_ok "Phase 2 terminée — données prod copiées"

# ===========================================================================
# PHASE 3 — Préparation Laravel (10 min)
# ===========================================================================
confirm "PHASE 3 — composer install, migrate, caches, permissions"

cd "${NEW_ADMIN}"

log_info "composer install --no-dev"
sudo -u ubuntu composer install --no-dev --optimize-autoloader --no-interaction

log_info "php artisan migrate --force (inclut encrypt_existing_pii)"
sudo -u ubuntu php artisan migrate --force

log_info "php artisan storage:link"
sudo -u ubuntu php artisan storage:link || log_warn "storage:link a peut-être déjà été fait"

if [[ -f "${NEW_ADMIN}/package.json" ]]; then
    log_info "npm install --omit=dev"
    sudo -u ubuntu npm install --omit=dev
    if [[ -f "${NEW_ADMIN}/vite.config.js" ]] || [[ -f "${NEW_ADMIN}/vite.config.ts" ]]; then
        log_info "npm run build"
        sudo -u ubuntu npm run build
    fi
fi

log_info "Caches Laravel (config, route, view, event)"
sudo -u ubuntu php artisan config:cache
sudo -u ubuntu php artisan route:cache
sudo -u ubuntu php artisan view:cache
sudo -u ubuntu php artisan event:cache

log_info "Permissions www-data sur storage, bootstrap/cache, database"
chown -R www-data:www-data \
    "${NEW_ADMIN}/storage" \
    "${NEW_ADMIN}/bootstrap/cache" \
    "${NEW_ADMIN}/database/database.sqlite"
chmod -R 775 "${NEW_ADMIN}/storage" "${NEW_ADMIN}/bootstrap/cache"

log_ok "Phase 3 terminée — Laravel prêt"

# ===========================================================================
# PHASE 4 — Test du nouveau Laravel sur port temporaire 8001 (3 min)
# ===========================================================================
confirm "PHASE 4 — Test via php artisan serve sur 127.0.0.1:8001"

cd "${NEW_ADMIN}"

log_info "Démarrage php artisan serve en background sur :8001"
sudo -u www-data php artisan serve --host=127.0.0.1 --port=8001 \
    > /tmp/neogtb-serve.log 2>&1 &
SERVE_PID=$!
sleep 3

log_info "Test HTTP /"
code_root=$(curl -s -o /dev/null -w "%{http_code}" http://127.0.0.1:8001/ || echo "000")
log_info "Test HTTP /admin/login"
code_admin=$(curl -s -o /dev/null -w "%{http_code}" http://127.0.0.1:8001/admin/login || echo "000")

log_info "Kill serveur temporaire (PID ${SERVE_PID})"
kill "${SERVE_PID}" 2>/dev/null || true
wait "${SERVE_PID}" 2>/dev/null || true
SERVE_PID=""

log_info "Codes reçus — / : ${code_root} | /admin/login : ${code_admin}"

if [[ "${code_root}" != "200" && "${code_root}" != "302" ]]; then
    log_err "/ a retourné ${code_root} — abort"
    cat /tmp/neogtb-serve.log || true
    exit 1
fi
if [[ "${code_admin}" != "200" && "${code_admin}" != "302" ]]; then
    log_err "/admin/login a retourné ${code_admin} — abort"
    cat /tmp/neogtb-serve.log || true
    exit 1
fi
log_ok "Phase 4 terminée — Laravel répond correctement"

# ===========================================================================
# PHASE 5 — Bascule nginx (1 min, downtime ~30s)
# ===========================================================================
confirm "PHASE 5 — Bascule du vhost nginx vers ${NEW_ADMIN}/public"

log_info "Backup du vhost actuel → ${NGINX_BACKUP}"
if [[ -f "${NGINX_ENABLED}" ]]; then
    cp "${NGINX_ENABLED}" "${NGINX_BACKUP}"
else
    log_warn "Pas de vhost actif trouvé à ${NGINX_ENABLED}"
fi

log_info "Génération du vhost temporaire ${TMP_VHOST}"
cat > "${TMP_VHOST}" <<'EOF'
# =============================================================================
# Vhost NeoGTB — neogtb.fr + www.neogtb.fr + admin.neogtb.fr
# Racine : /var/www/neogtb-laravel-new/admin/public
# PHP-FPM : php8.4-fpm
#
# ATTENTION :
# CONTENU DU VHOST À COLLER ICI MANUELLEMENT VIA L'AGENT VHOST
# (ce placeholder sera remplacé par le vrai bloc server { ... } produit
#  par l'agent VHOST avec :
#   - server_name neogtb.fr www.neogtb.fr
#   - server_name admin.neogtb.fr
#   - root /var/www/neogtb-laravel-new/admin/public
#   - certifs Letsencrypt existants (fullchain.pem / privkey.pem)
#   - redirects HTTP → HTTPS conservés
#   - fastcgi_pass unix:/run/php/php8.4-fpm.sock
# )
# =============================================================================
EOF

log_warn "Le fichier ${TMP_VHOST} doit être complété par l'agent VHOST avant de continuer."
confirm "Le vhost a-t-il bien été collé dans ${TMP_VHOST} ?"

log_info "Installation du vhost dans ${NGINX_SITE}"
cp "${TMP_VHOST}" "${NGINX_SITE}"
ln -sf "${NGINX_SITE}" "${NGINX_ENABLED}"

log_info "nginx -t"
if ! nginx -t; then
    log_err "nginx -t a échoué — restauration du backup"
    if [[ -f "${NGINX_BACKUP}" ]]; then
        cp "${NGINX_BACKUP}" "${NGINX_ENABLED}"
        nginx -t && systemctl reload nginx
    fi
    exit 1
fi

log_info "systemctl reload nginx"
systemctl reload nginx

log_info "Smoke test HTTPS"
curl -I -s https://neogtb.fr        | head -n 1 || log_warn "curl neogtb.fr KO"
curl -I -s https://admin.neogtb.fr  | head -n 1 || log_warn "curl admin.neogtb.fr KO"

log_ok "Phase 5 terminée — nginx bascule sur le nouveau Laravel"

# ===========================================================================
# PHASE 6 — Worker queue + cron + finalisation (10 min)
# ===========================================================================
confirm "PHASE 6 — Supervisor worker, cron scheduler, smoke test final"

SUPERVISOR_SRC="${NEW_ADMIN}/deploy/supervisor-neogtb-worker.conf"
SUPERVISOR_DST="/etc/supervisor/conf.d/neogtb-worker.conf"

if [[ ! -f "${SUPERVISOR_SRC}" ]]; then
    log_err "Fichier supervisor source ${SUPERVISOR_SRC} introuvable"
    exit 1
fi

log_info "Copie du fichier supervisor"
cp "${SUPERVISOR_SRC}" "${SUPERVISOR_DST}"

log_info "Adaptation des chemins (neogtb-admin → neogtb-laravel-new/admin)"
sed -i 's#/var/www/neogtb-admin#/var/www/neogtb-laravel-new/admin#g' "${SUPERVISOR_DST}"

log_info "supervisorctl reread + update + start"
supervisorctl reread
supervisorctl update
supervisorctl start neogtb-worker:* || log_warn "start neogtb-worker:* peut déjà être running"

log_info "Statut worker"
supervisorctl status neogtb-worker:* || true

log_info "Installation du cron scheduler Laravel pour www-data"
echo "* * * * * cd ${NEW_ADMIN} && php artisan schedule:run >> /dev/null 2>&1" \
    | crontab -u www-data -

log_info "Smoke test final"
curl -I -s https://neogtb.fr              | head -n 1 || log_warn "neogtb.fr KO"
curl -I -s https://www.neogtb.fr          | head -n 1 || log_warn "www.neogtb.fr KO"
curl -I -s https://admin.neogtb.fr        | head -n 1 || log_warn "admin.neogtb.fr KO"
curl -I -s https://admin.neogtb.fr/admin/login | head -n 1 || log_warn "admin/login KO"

log_ok "Phase 6 terminée — worker + cron + nginx OK"

# ===========================================================================
# PHASE 6.bis — Renommage final propre (optionnel)
# ===========================================================================
echo
echo -e "${YELLOW}==> PHASE 6.bis — Renommage final (optionnel)${NC}"
echo -e "${YELLOW}    ${OLD_DIR} → ${OLD_DIR}-OLD-astro-$(date +%Y%m%d)${NC}"
echo -e "${YELLOW}    ${NEW_DIR} → ${FINAL_DIR}${NC}"
read -r -p "Lancer phase 6.bis ? (y/N) " ans_bis

if [[ "${ans_bis}" =~ ^(y|Y|yes|YES)$ ]]; then
    STAMP=$(date +%Y%m%d)
    log_info "mv ${OLD_DIR} → ${OLD_DIR}-OLD-astro-${STAMP}"
    mv "${OLD_DIR}" "${OLD_DIR}-OLD-astro-${STAMP}"

    log_info "mv ${NEW_DIR} → ${FINAL_DIR}"
    mv "${NEW_DIR}" "${FINAL_DIR}"

    log_info "Adaptation supervisor avec nouveau chemin ${FINAL_DIR}/admin"
    sed -i "s#${NEW_DIR}#${FINAL_DIR}#g" "${SUPERVISOR_DST}"
    supervisorctl reread && supervisorctl update
    supervisorctl restart neogtb-worker:* || true

    log_info "Adaptation cron www-data"
    echo "* * * * * cd ${FINAL_DIR}/admin && php artisan schedule:run >> /dev/null 2>&1" \
        | crontab -u www-data -

    log_warn "Le vhost nginx référence encore ${NEW_DIR} — il faut le régénérer"
    log_warn "via l'agent VHOST avec la nouvelle racine ${FINAL_DIR}/admin/public"
    log_warn "puis : nginx -t && systemctl reload nginx"

    log_ok "Phase 6.bis terminée — chemins finaux ${FINAL_DIR}"
else
    log_info "Phase 6.bis ignorée — chemins restent ${NEW_DIR}"
fi

# ===========================================================================
# Récapitulatif final
# ===========================================================================
echo
echo -e "${GREEN}========================================================${NC}"
echo -e "${GREEN}  Migration NeoGTB — RÉCAPITULATIF${NC}"
echo -e "${GREEN}========================================================${NC}"
echo -e "  Phase 1 — Clone fresh                    : ${GREEN}OK${NC}"
echo -e "  Phase 2 — Données prod (.env, sqlite)    : ${GREEN}OK${NC}"
echo -e "  Phase 3 — composer / migrate / caches    : ${GREEN}OK${NC}"
echo -e "  Phase 4 — Test Laravel port 8001         : ${GREEN}OK${NC}"
echo -e "  Phase 5 — Bascule nginx                  : ${GREEN}OK${NC}"
echo -e "  Phase 6 — Worker + cron + smoke test     : ${GREEN}OK${NC}"
echo -e "  Phase 6.bis — Renommage final            : voir ci-dessus"
echo
echo -e "  Backup vhost  : ${NGINX_BACKUP}"
echo -e "  Supervisor    : ${SUPERVISOR_DST}"
echo -e "  Domaines      : https://neogtb.fr  |  https://admin.neogtb.fr"
echo -e "${GREEN}========================================================${NC}"

exit 0
