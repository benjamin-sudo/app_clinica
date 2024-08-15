# Usar la imagen base de Ubuntu
FROM ubuntu:latest

# Instalar cron y cualquier otra dependencia que necesites
RUN apt-get update && \
    apt-get install -y cron && \
    apt-get clean

# Crear el directorio para guardar los backups
RUN mkdir -p /backup_service/backup

# Copiar el script de respaldo al contenedor
COPY backup.sh /usr/local/bin/backup.sh

# Hacer que el script sea ejecutable
RUN chmod +x /usr/local/bin/backup.sh

# Copiar la configuración de cron al directorio correcto
COPY crontab /etc/cron.d/backup-cron

# Ajustar permisos del archivo crontab
RUN chmod 0644 /etc/cron.d/backup-cron

# Aplicar el archivo crontab para el servicio cron
RUN crontab /etc/cron.d/backup-cron

# Crear un archivo de log para cron
RUN touch /var/log/backup.log

# Ejecutar el script de backup al inicio y luego iniciar cron en modo foreground
CMD ["/bin/bash", "-c", "/usr/local/bin/backup.sh && cron && tail -f /var/log/backup.log"]
