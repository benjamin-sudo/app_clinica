#!/bin/bash
# backup.sh
# Fecha actual para nombrar el archivo de respaldo
DATE=$(date +'%F_%H-%M-%S')
# Directorio donde se guardará el respaldo
BACKUP_DIR="/backup_service/backup"
# Nombre del archivo de respaldo
BACKUP_FILE="$BACKUP_DIR/mysql_backup_$DATE.tar.gz"
# Crear respaldo del volumen
tar czvf $BACKUP_FILE /var/lib/mysql
# Opcional: Eliminar respaldos más antiguos de 7 días
find $BACKUP_DIR -type f -name "*.tar.gz" -mtime +7 -exec rm {} \;
