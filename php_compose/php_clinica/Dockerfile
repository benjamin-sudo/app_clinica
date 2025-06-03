FROM php:7.4-apache
# Instala tzdata para manejo de zonas horarias
RUN apt-get update && apt-get install -y tzdata
# Configura la zona horaria
RUN ln -fs /usr/share/zoneinfo/America/Santiago /etc/localtime && \
    echo "America/Santiago" > /etc/timezone && \
    dpkg-reconfigure -f noninteractive tzdata
# Instalar mysqli
RUN docker-php-ext-install mysqli
# Copiar archivos de la aplicación a /var/www/html
COPY ./php_codeneiter/html /var/www/html
# Cambiar propietario y permisos para garantizar que Apache tenga acceso
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
# Habilitar mod_rewrite y configurar Apache
RUN a2enmod rewrite \
    && echo '<Directory "/var/www/html">' > /etc/apache2/conf-available/htaccess.conf \
    && echo '    AllowOverride All' >> /etc/apache2/conf-available/htaccess.conf \
    && echo '</Directory>' >> /etc/apache2/conf-available/htaccess.conf \
    && a2enconf htaccess \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf
# Exponer puertos
EXPOSE 80
EXPOSE 443

# Comando para mantener el contenedor en ejecución
CMD ["apache2-foreground"]