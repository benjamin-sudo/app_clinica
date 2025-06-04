FROM alpine:latest
# 1. Instalar cronie, dos2unix y bash
RUN apk update \
 && apk add --no-cache cronie dos2unix bash
# 2. Crear el directorio /respaldo (para montar allí los .tar.gz para restauración)
RUN mkdir -p /respaldo
# 3. Crear el directorio donde cron escribirá logs
RUN mkdir -p /var/log
# 4. Copiar backup.sh (script para generar .tar.gz) y darle permisos
COPY backup.sh /usr/local/bin/backup.sh
RUN dos2unix /usr/local/bin/backup.sh \
 && chmod +x /usr/local/bin/backup.sh
# 5. Copiar restaurar.sh (script para restaurar .tar.gz) y darle permisos
COPY restaurar.sh /usr/local/bin/restaurar.sh
RUN dos2unix /usr/local/bin/restaurar.sh \
 && chmod +x /usr/local/bin/restaurar.sh
# 6. Crear el cron job para backup.sh (se ejecuta todos los días a las 02:00)
RUN echo "0 2 * * * /usr/local/bin/backup.sh >> /var/log/backup.log 2>&1" > /etc/crontabs/root
# 7. Montar /var/log como volumen (opcional, para poder ver logs desde el host)
VOLUME [ "/var/log" ]
# 8. Por defecto arranca cron en primer plano
CMD ["crond", "-f"]
