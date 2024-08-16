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
# Eliminar respaldos más antiguos de 7 días
find $BACKUP_DIR -type f -name "*.tar.gz" -mtime +7 -exec rm {} \;
# Eliminar el archivo más antiguo si ya existen más de 10 archivos de respaldo
NUM_FILES=$(ls -1 $BACKUP_DIR/*.tar.gz | wc -l)
if [ $NUM_FILES -gt 10 ]; then
    OLDEST_FILE=$(ls -1t $BACKUP_DIR/*.tar.gz | tail -1)
    rm $OLDEST_FILE
fi
