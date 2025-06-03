FROM alpine:latest
# Instala cronie (en lugar de dcron), dos2unix y bash (si lo necesitas)
RUN apk update \
 && apk add --no-cache cronie dos2unix bash
# Crea el directorio de backup
RUN mkdir -p /backup_service/backup
# Copia el script y dale permisos
COPY backup.sh /usr/local/bin/backup.sh
RUN dos2unix /usr/local/bin/backup.sh \
 && chmod +x /usr/local/bin/backup.sh
# Define la tarea en /etc/crontabs/root (sin 'root' al inicio)
RUN echo "0 2 * * * /usr/local/bin/backup.sh >> /var/log/backup.log 2>&1" > /etc/crontabs/root
# Crea la carpeta de logs (opcional, para que exista /var/log y crond pueda escribir)
RUN mkdir -p /var/log
# Expón el log (opcional)
VOLUME [ "/var/log" ]
# Arranca cron en primer plano
CMD ["crond", "-f", "-l", "2"]
