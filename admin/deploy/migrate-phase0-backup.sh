#!/usr/bin/env bash
#
# migrate-phase0-backup.sh
# Phase 0 de la migration NeoGTB (Astro+Laravel -> Laravel-only)
#
# Script 100% LECTURE SEULE sur la prod : il ne fait que des cp/tar.
# A lancer sur le VPS via : sudo bash migrate-phase0-backup.sh
#
# Il cree un dossier horodate /home/ubuntu/migration-backup-YYYYMMDD-HHMM/
# contenant tous les artefacts critiques avant bascule.
#

set -euo pipefail

# --- Couleurs ANSI ---------------------------------------------------------
RED=$'\033[0;31m'
GREEN=$'\033[0;32m'
YELLOW=$'\033[1;33m'
BLUE=$'\033[0;34m'
NC=$'\033[0m'

info()    { echo "${BLUE}[INFO]${NC}  $*"; }
ok()      { echo "${GREEN}[OK]${NC}    $*"; }
warn()    { echo "${YELLOW}[WARN]${NC}  $*"; }
err()     { echo "${RED}[ERREUR]${NC} $*" >&2; }

# --- Trap d'erreur ---------------------------------------------------------
on_error() {
    local exit_code=$?
    local line_no=${1:-?}
    err "Echec du script ligne ${line_no} (code ${exit_code})."
    err "Backup potentiellement incomplet : ${BACKUP_DIR:-<non cree>}"
    exit 1
}
trap 'on_error $LINENO' ERR

# --- 1. Verification qu'on est bien sur le VPS -----------------------------
info "Verification de l'environnement (VPS)..."
if [[ ! -d /var/www/neogtb ]]; then
    err "/var/www/neogtb introuvable : ce script doit tourner sur le VPS NeoGTB."
    exit 1
fi
HOSTNAME_CURRENT="$(hostname)"
ok "Hote : ${HOSTNAME_CURRENT} - /var/www/neogtb present."

# --- 2. Creation du dossier de backup horodate -----------------------------
TIMESTAMP="$(date +%Y%m%d-%H%M)"
BACKUP_DIR="/home/ubuntu/migration-backup-${TIMESTAMP}"
info "Creation du dossier de backup : ${BACKUP_DIR}"
mkdir -p "${BACKUP_DIR}"
ok "Dossier cree."

# --- 3. Tar.gz complet de /var/www/neogtb (Astro statique) -----------------
info "Archivage de /var/www/neogtb (Astro statique)..."
tar --warning=no-file-changed \
    --exclude='node_modules' \
    -czf "${BACKUP_DIR}/neogtb-static.tar.gz" \
    -C /var/www neogtb
ok "Archive : neogtb-static.tar.gz"

# --- 4. Tar.gz complet de /var/www/neogtb-src (source Astro) ---------------
if [[ -d /var/www/neogtb-src ]]; then
    info "Archivage de /var/www/neogtb-src (source Astro)..."
    tar --warning=no-file-changed \
        --exclude='node_modules' \
        --exclude='dist' \
        -czf "${BACKUP_DIR}/neogtb-src.tar.gz" \
        -C /var/www neogtb-src
    ok "Archive : neogtb-src.tar.gz"
else
    warn "/var/www/neogtb-src absent, etape ignoree."
fi

# --- 5. Copie de la base SQLite admin --------------------------------------
SQLITE_SRC="/var/www/neogtb/admin/database/database.sqlite"
if [[ -f "${SQLITE_SRC}" ]]; then
    info "Copie de la base SQLite admin..."
    cp -p "${SQLITE_SRC}" "${BACKUP_DIR}/database.sqlite"
    ok "SQLite sauvegardee."
else
    warn "SQLite introuvable a ${SQLITE_SRC}"
fi

# --- 6. Copie du .env admin ------------------------------------------------
ENV_SRC="/var/www/neogtb/admin/.env"
if [[ -f "${ENV_SRC}" ]]; then
    info "Copie du .env admin..."
    cp -p "${ENV_SRC}" "${BACKUP_DIR}/admin.env"
    chmod 600 "${BACKUP_DIR}/admin.env"
    ok ".env admin sauvegarde (perms 600)."
else
    warn ".env admin introuvable a ${ENV_SRC}"
fi

# --- 7. Copie de la config nginx sites-enabled -----------------------------
NGINX_ENABLED="/etc/nginx/sites-enabled/neogtb"
if [[ -e "${NGINX_ENABLED}" ]]; then
    info "Copie de ${NGINX_ENABLED}..."
    cp -pL "${NGINX_ENABLED}" "${BACKUP_DIR}/nginx-sites-enabled-neogtb"
    ok "Config nginx (enabled) sauvegardee."
else
    warn "${NGINX_ENABLED} introuvable."
fi

# --- 8. Copie de sites-available si different ------------------------------
NGINX_AVAILABLE="/etc/nginx/sites-available/neogtb"
if [[ -f "${NGINX_AVAILABLE}" ]]; then
    # On copie toujours pour avoir le fichier reel (au cas ou enabled est un symlink casse)
    info "Copie de ${NGINX_AVAILABLE}..."
    cp -p "${NGINX_AVAILABLE}" "${BACKUP_DIR}/nginx-sites-available-neogtb"
    ok "Config nginx (available) sauvegardee."
else
    warn "${NGINX_AVAILABLE} introuvable."
fi

# Backup complet du dossier nginx pour securite
if [[ -d /etc/nginx ]]; then
    info "Archivage complet de /etc/nginx..."
    tar -czf "${BACKUP_DIR}/etc-nginx.tar.gz" -C /etc nginx
    ok "Archive : etc-nginx.tar.gz"
fi

# --- 9. Snapshot du commit git du Laravel admin ----------------------------
ADMIN_DIR="/var/www/neogtb/admin"
if [[ -d "${ADMIN_DIR}/.git" ]]; then
    info "Snapshot git du Laravel admin..."
    {
        echo "# Snapshot git - ${TIMESTAMP}"
        echo "# Repo : ${ADMIN_DIR}"
        echo
        echo "## HEAD"
        git -C "${ADMIN_DIR}" rev-parse HEAD
        echo
        echo "## Branche courante"
        git -C "${ADMIN_DIR}" rev-parse --abbrev-ref HEAD
        echo
        echo "## git log --oneline -10"
        git -C "${ADMIN_DIR}" log --oneline -10
        echo
        echo "## git status"
        git -C "${ADMIN_DIR}" status --short || true
    } > "${BACKUP_DIR}/git-snapshot.txt"
    ok "Snapshot git sauvegarde."
else
    warn "Pas de repo git a ${ADMIN_DIR}"
fi

# --- 10. Permissions actuelles (ls -la) ------------------------------------
info "Capture des permissions critiques..."
PERMS_FILE="${BACKUP_DIR}/permissions.txt"
{
    echo "# Permissions - ${TIMESTAMP}"
    echo
    for p in \
        /var/www/neogtb \
        /var/www/neogtb-src \
        /var/www/neogtb/admin \
        /var/www/neogtb/admin/database \
        /var/www/neogtb/admin/storage \
        /var/www/neogtb/admin/bootstrap/cache \
        /etc/nginx/sites-enabled \
        /etc/nginx/sites-available
    do
        echo "## ${p}"
        if [[ -e "${p}" ]]; then
            ls -la "${p}" 2>&1 || true
        else
            echo "(absent)"
        fi
        echo
    done
} > "${PERMS_FILE}"
ok "Permissions capturees : permissions.txt"

# --- 11. Backup certificats Let's Encrypt ----------------------------------
info "Sauvegarde des certificats Let's Encrypt..."
LE_BACKUP_DIR="${BACKUP_DIR}/letsencrypt"
mkdir -p "${LE_BACKUP_DIR}"
for domain in neogtb.fr admin.neogtb.fr; do
    LE_SRC="/etc/letsencrypt/live/${domain}"
    if [[ -d "${LE_SRC}" ]]; then
        # -L pour suivre les symlinks, -p pour garder metadonnees
        cp -rLp "${LE_SRC}" "${LE_BACKUP_DIR}/${domain}"
        chmod -R a-w "${LE_BACKUP_DIR}/${domain}"
        ok "Certificat ${domain} sauvegarde (read-only)."
    else
        warn "Certificat ${domain} introuvable (${LE_SRC})."
    fi
done
# Archive complete letsencrypt pour securite absolue
if [[ -d /etc/letsencrypt ]]; then
    info "Archivage complet de /etc/letsencrypt..."
    tar -czf "${BACKUP_DIR}/etc-letsencrypt.tar.gz" -C /etc letsencrypt
    chmod 600 "${BACKUP_DIR}/etc-letsencrypt.tar.gz"
    ok "Archive : etc-letsencrypt.tar.gz (perms 600)"
fi

# --- 12. Recapitulatif -----------------------------------------------------
echo
echo "============================================================"
echo "${GREEN}BACKUP PHASE 0 TERMINE${NC}"
echo "============================================================"
info "Dossier : ${BACKUP_DIR}"
TOTAL_SIZE="$(du -sh "${BACKUP_DIR}" | awk '{print $1}')"
info "Taille totale : ${TOTAL_SIZE}"
echo
info "Contenu :"
ls -lah "${BACKUP_DIR}"
echo
info "Espace disque restant :"
df -h /home | tail -n +1
echo "============================================================"
ok "Phase 0 OK - backup complet, pret pour la migration."

exit 0
