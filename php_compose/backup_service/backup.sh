#!/bin/sh
# Registrar el inicio del script
echo "[$(date)] Backup script started" >> /var/log/backup.log

# Fecha actual para nombrar el archivo de respaldo
DATE=$(date +'%F_%H-%M-%S')

# Directorio donde se guardará el respaldo
BACKUP_DIR="/backup_service/backup"

# Nombre del archivo de respaldo
BACKUP_FILE="$BACKUP_DIR/mysql_backup_$DATE.tar.gz"

# Crear respaldo del volumen
tar czvf $BACKUP_FILE /var/lib/mysql >> /var/log/backup.log 2>> /var/log/backup.err

# Verifica si el respaldo fue exitoso
if [ $? -eq 0 ]; then
  echo "[$(date)] Backup completed successfully" >> /var/log/backup.log
else
  echo "[$(date)] Backup failed" >> /var/log/backup.log
fi

# Mantener solo los 10 respaldos más recientes
BACKUP_COUNT=$(ls -1 $BACKUP_DIR/*.tar.gz | wc -l)
if [ $BACKUP_COUNT -gt 10 ]; then
  ls -1t $BACKUP_DIR/*.tar.gz | tail -n +11 | xargs rm -f
  echo "[$(date)] Removed old backups, keeping only the 10 most recent ones." >> /var/log/backup.log
fi

# Registrar el final del script
echo "[$(date)] Backup script ended" >> /var/log/backup.log
