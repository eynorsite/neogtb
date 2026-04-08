#!/usr/bin/env bash
#
# backup-sqlite.sh — Sauvegarde quotidienne de la base SQLite NeoGTB
#
# Utilise `sqlite3 .backup` pour une copie transactionnellement cohérente
# (vs cp brut qui peut copier une DB en cours d'écriture).
#
# Installation : voir deploy/README-backup.md
#

set -euo pipefail

# ---------- Configuration ----------
DB="/var/www/neogtb/shared/admin/database/database.sqlite"
BACKUP_DIR="/var/backups/neogtb"
LOG_FILE="/var/log/neogtb-backup.log"
LOCK_FILE="/var/lock/neogtb-backup.lock"
RETENTION_DAYS=30
TIMESTAMP="$(date +%F-%H%M)"
BACKUP_FILE="${BACKUP_DIR}/neogtb-${TIMESTAMP}.sqlite"

# ---------- Logging ----------
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $*" >> "$LOG_FILE"
}

die() {
    log "ERREUR: $*"
    echo "ERREUR: $*" >&2
    exit 1
}

# ---------- Lock (flock) pour éviter exécutions concurrentes ----------
exec 9>"$LOCK_FILE" || die "Impossible d'ouvrir le fichier de lock $LOCK_FILE"
if ! flock -n 9; then
    log "Une autre instance est déjà en cours — abandon."
    exit 0
fi

log "=== Début backup NeoGTB SQLite ==="

# ---------- Pré-checks ----------
[[ -f "$DB" ]] || die "Base SQLite introuvable : $DB"
command -v sqlite3 >/dev/null 2>&1 || die "sqlite3 non installé"
command -v gzip    >/dev/null 2>&1 || die "gzip non installé"

mkdir -p "$BACKUP_DIR" || die "Impossible de créer $BACKUP_DIR"

# ---------- Backup transactionnel ----------
log "Backup en cours : $BACKUP_FILE"
if ! sqlite3 "$DB" ".backup '${BACKUP_FILE}'"; then
    die "Échec de sqlite3 .backup"
fi

# ---------- Intégrité ----------
if ! sqlite3 "$BACKUP_FILE" "PRAGMA integrity_check;" | grep -q '^ok$'; then
    rm -f "$BACKUP_FILE"
    die "Contrôle d'intégrité échoué sur $BACKUP_FILE"
fi

# ---------- Compression ----------
if ! gzip -9 "$BACKUP_FILE"; then
    die "Échec compression gzip"
fi
BACKUP_FILE_GZ="${BACKUP_FILE}.gz"
SIZE="$(du -h "$BACKUP_FILE_GZ" | cut -f1)"
log "Backup OK : $BACKUP_FILE_GZ ($SIZE)"

# ---------- Off-site (rclone) — OPTIONNEL ----------
# Pour activer la copie off-site :
#   1. Installer rclone      : sudo apt install rclone
#   2. Configurer un remote  : rclone config  (ex. Backblaze B2 nommé "b2-neogtb")
#   3. Décommenter la ligne suivante et ajuster le nom du remote/bucket :
#
# rclone copy "$BACKUP_FILE_GZ" b2-neogtb:neogtb-backups/ --log-file="$LOG_FILE" --log-level INFO || log "AVERTISSEMENT: rclone off-site a échoué"

# ---------- Rétention 30 jours ----------
DELETED=$(find "$BACKUP_DIR" -maxdepth 1 -type f -name 'neogtb-*.sqlite.gz' -mtime +${RETENTION_DAYS} -print -delete | wc -l)
log "Rétention : ${DELETED} fichier(s) > ${RETENTION_DAYS}j supprimé(s)"

log "=== Fin backup NeoGTB SQLite (OK) ==="
exit 0
