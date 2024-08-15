# Dockerfile
FROM ubuntu:latest

# Instalar cron
RUN apt-get update && apt-get install -y cron

# Crear directorio para backups
RUN mkdir -p /backup_service/backup

# Copiar el script de respaldo
COPY backup.sh /usr/local/bin/backup.sh
RUN chmod +x /usr/local/bin/backup.sh

# Copiar crontab al directorio de cron.d
COPY crontab /etc/cron.d/backup-cron
RUN chmod 0644 /etc/cron.d/backup-cron

# Ejecutar respaldo al inicio
#RUN /usr/local/bin/backup.sh

# Iniciar cron en modo foreground
CMD ["cron", "-f"]

