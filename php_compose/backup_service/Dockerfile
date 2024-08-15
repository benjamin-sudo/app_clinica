# Usa la imagen base que estés utilizando
FROM ubuntu:latest
# Actualiza el repositorio de paquetes e instala cron, nano y otros paquetes necesarios
RUN apt-get update && apt-get install -y cron nano
# Copia el script de backup al directorio correcto
COPY backup.sh /usr/local/bin/backup.sh
# Otorga permisos de ejecución al script
RUN chmod +x /usr/local/bin/backup.sh
# Configura el crontab para el usuario root
RUN echo "* * * * * /usr/local/bin/backup.sh >> /var/log/backup.log 2>&1" > /etc/cron.d/backup-cron
# Otorga permisos adecuados al archivo crontab y lo activa
RUN chmod 0644 /etc/cron.d/backup-cron
# Aplicar el crontab
RUN crontab /etc/cron.d/backup-cron
# Asegúrate de que cron se ejecuta en el primer plano
CMD ["cron", "-f"]
