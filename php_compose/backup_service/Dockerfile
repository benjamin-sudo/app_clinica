FROM alpine:latest
# 1. Instalar dependencias necesarias + tzdata
RUN apk update && \
    apk add --no-cache \
      cronie \
      dos2unix \
      bash \
      curl \
      docker-cli \
      tzdata && \
    cp /usr/share/zoneinfo/America/Santiago /etc/localtime && \
    echo "America/Santiago" > /etc/timezone && \
    apk del tzdata && \
    rm -rf /var/cache/apk/*
# 2. Crear carpetas necesarias
RUN mkdir -p /respaldo /var/log
# 3. Copiar y preparar scripts
COPY backup.sh /usr/local/bin/backup.sh
RUN dos2unix /usr/local/bin/backup.sh && chmod +x /usr/local/bin/backup.sh
COPY restaurar.sh /usr/local/bin/restaurar.sh
RUN dos2unix /usr/local/bin/restaurar.sh && chmod +x /usr/local/bin/restaurar.sh
# 4. Cron diario para backup a las 02:00
RUN echo "0 2 * * * /usr/local/bin/backup.sh >> /var/log/backup.log 2>&1" > /etc/crontabs/root
# 5. Copiar y preparar reporte por Telegram
COPY reporte_telegram.sh /usr/local/bin/reporte_telegram.sh
RUN dos2unix /usr/local/bin/reporte_telegram.sh && chmod +x /usr/local/bin/reporte_telegram.sh
# 6. Cron cada hora para reporte
RUN echo "0 * * * * /usr/local/bin/reporte_telegram.sh >> /var/log/reporte.log 2>&1" >> /etc/crontabs/root
# 7. Ejecutar primero reporte (sin detenerse si falla), luego cron en primer plano
CMD ["sh", "-c", "/usr/local/bin/reporte_telegram.sh >> /var/log/reporte.log 2>&1 ; crond -f"]
