# Backup SQLite NeoGTB

Script de sauvegarde quotidienne de la base SQLite du site NeoGTB.

- **Source** : `/var/www/neogtb/shared/admin/database/database.sqlite`
- **Destination** : `/var/backups/neogtb/neogtb-YYYY-MM-DD-HHMM.sqlite.gz`
- **Rétention** : 30 jours
- **Méthode** : `sqlite3 .backup` (cohérence transactionnelle, contrairement à `cp`)
- **Logs** : `/var/log/neogtb-backup.log`
- **Lock** : `flock` sur `/var/lock/neogtb-backup.lock` (pas d'exécutions concurrentes)

## 1. Installation sur le VPS

```bash
# Copier le script à un emplacement système
sudo cp /var/www/neogtb/current/deploy/backup-sqlite.sh /usr/local/bin/backup-sqlite-neogtb.sh
sudo chown root:root /usr/local/bin/backup-sqlite-neogtb.sh
sudo chmod +x /usr/local/bin/backup-sqlite-neogtb.sh

# Créer les répertoires et le fichier de log
sudo mkdir -p /var/backups/neogtb
sudo touch /var/log/neogtb-backup.log
sudo chmod 640 /var/log/neogtb-backup.log

# Vérifier que sqlite3 est installé
sudo apt install -y sqlite3
```

## 2. Test manuel

```bash
sudo /usr/local/bin/backup-sqlite-neogtb.sh
ls -lh /var/backups/neogtb/
sudo tail -20 /var/log/neogtb-backup.log
```

Tu dois voir un fichier `neogtb-<date>.sqlite.gz` et une ligne `=== Fin backup NeoGTB SQLite (OK) ===`.

## 3. Planification cron (03h00 chaque nuit)

```bash
sudo crontab -e
```

Ajouter la ligne :

```
0 3 * * * /usr/local/bin/backup-sqlite-neogtb.sh
```

Vérifier :

```bash
sudo crontab -l
```

## 4. Off-site optionnel (rclone — Backblaze B2 ou S3)

Conserver une copie chez un tiers protège contre la perte totale du VPS (incendie, compromission, etc.).

### Installer rclone

```bash
sudo apt install -y rclone
```

### Configurer un remote

```bash
rclone config
```

Choisir :
- **Backblaze B2** : type `b2`, renseigner Account ID + Application Key, nommer le remote `b2-neogtb`.
- **AWS S3** : type `s3`, fournisseur `AWS`, Access Key + Secret, region (ex. `eu-west-3`), nommer le remote `s3-neogtb`.

Créer le bucket (une fois) :

```bash
rclone mkdir b2-neogtb:neogtb-backups
```

### Activer dans le script

Editer `/usr/local/bin/backup-sqlite-neogtb.sh` et décommenter la ligne :

```bash
rclone copy "$BACKUP_FILE_GZ" b2-neogtb:neogtb-backups/ --log-file="$LOG_FILE" --log-level INFO || log "AVERTISSEMENT: rclone off-site a échoué"
```

Remplacer `b2-neogtb` par le nom du remote configuré si différent.

### Tester

```bash
sudo /usr/local/bin/backup-sqlite-neogtb.sh
rclone ls b2-neogtb:neogtb-backups/
```

## 5. Tester un restore

Toujours tester une restauration **sur un fichier temporaire**, jamais directement sur la DB de prod.

```bash
# 1. Choisir un backup
LATEST=$(ls -1t /var/backups/neogtb/neogtb-*.sqlite.gz | head -1)
echo "Restore depuis : $LATEST"

# 2. Décompresser dans /tmp
cp "$LATEST" /tmp/restore-test.sqlite.gz
gunzip /tmp/restore-test.sqlite.gz

# 3. Vérifier l'intégrité
sqlite3 /tmp/restore-test.sqlite "PRAGMA integrity_check;"
# => doit afficher "ok"

# 4. Inspecter quelques tables
sqlite3 /tmp/restore-test.sqlite ".tables"
sqlite3 /tmp/restore-test.sqlite "SELECT COUNT(*) FROM users;"

# 5. Nettoyer
rm /tmp/restore-test.sqlite
```

### Restauration réelle en cas d'incident

```bash
# 1. Mettre le site en maintenance
sudo -u www-data php /var/www/neogtb/current/admin/artisan down

# 2. Sauvegarder la DB corrompue (au cas où)
sudo cp /var/www/neogtb/shared/admin/database/database.sqlite \
        /var/www/neogtb/shared/admin/database/database.sqlite.broken

# 3. Restaurer
LATEST=/var/backups/neogtb/neogtb-YYYY-MM-DD-HHMM.sqlite.gz
sudo gunzip -c "$LATEST" > /var/www/neogtb/shared/admin/database/database.sqlite
sudo chown www-data:www-data /var/www/neogtb/shared/admin/database/database.sqlite
sudo chmod 664 /var/www/neogtb/shared/admin/database/database.sqlite

# 4. Remettre en ligne
sudo -u www-data php /var/www/neogtb/current/admin/artisan up
```

## 6. Monitoring

Vérifier de temps en temps :

```bash
# Dernier backup
ls -lht /var/backups/neogtb/ | head -5

# Logs récents
sudo tail -50 /var/log/neogtb-backup.log

# Taille totale des backups
du -sh /var/backups/neogtb/
```

Si aucun backup depuis >48h, investiguer cron + logs.
