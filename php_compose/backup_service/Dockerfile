# Usa Alpine como base
FROM alpine:latest
# Instala cron (dcron) y dos2unix
RUN apk update \
 && apk add --no-cache dcron dos2unix
# Crea el directorio de backup
RUN mkdir -p /backup_service/backup
# Copia el script de backup
COPY backup.sh /usr/local/bin/backup.sh
# Convierte a formato Unix y dale permisos de ejecución
RUN dos2unix /usr/local/bin/backup.sh \
 && chmod +x /usr/local/bin/backup.sh
# Define la tarea en el crontab del root (Alpine almacena las crontabs en /etc/crontabs)
RUN echo "0 2 * * * /usr/local/bin/backup.sh >> /var/log/backup.log 2>&1" > /etc/crontabs/root
# Exponemos el log (opcional)
VOLUME [ "/var/log" ]
# Ejecuta cron en primer plano para que el contenedor no termine
CMD ["crond", "-f", "-L", "/var/log/backup.log"]
