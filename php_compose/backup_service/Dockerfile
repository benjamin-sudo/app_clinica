FROM alpine:latest

# Instalar dependencias necesarias
RUN apk update && apk add --no-cache cronie dos2unix bash curl docker-cli

# Crear carpetas necesarias
RUN mkdir -p /respaldo /var/log

# Copiar scripts de respaldo y restauración
COPY backup.sh /usr/local/bin/backup.sh
RUN dos2unix /usr/local/bin/backup.sh && chmod +x /usr/local/bin/backup.sh

COPY restaurar.sh /usr/local/bin/restaurar.sh
RUN dos2unix /usr/local/bin/restaurar.sh && chmod +x /usr/local/bin/restaurar.sh

# Cron diario para backup a las 02:00
RUN echo "0 2 * * * /usr/local/bin/backup.sh >> /var/log/backup.log 2>&1" > /etc/crontabs/root

# Copiar script de reporte por Telegram
COPY reporte_telegram.sh /usr/local/bin/reporte_telegram.sh
RUN dos2unix /usr/local/bin/reporte_telegram.sh && chmod +x /usr/local/bin/reporte_telegram.sh

# Cron cada hora para reporte
RUN echo "0 * * * * /usr/local/bin/reporte_telegram.sh >> /var/log/reporte.log 2>&1" >> /etc/crontabs/root

# Ejecutar reporte al iniciar el contenedor, luego cron en primer plano
CMD /usr/local/bin/reporte_telegram.sh >> /var/log/reporte.log 2>&1 && crond -f
