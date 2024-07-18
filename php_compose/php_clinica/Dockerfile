FROM php:7.4-apache

RUN docker-php-ext-install mysqli

# Copia tus archivos de la aplicación a /var/www/html
COPY ./php_codeneiter/html /var/www/html

# Cambia los permisos para garantizar que Apache tenga acceso
RUN chmod -R 755 /var/www/html

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Configurar Apache para permitir .htaccess
# Reemplaza /var/www/html con tu DocumentRoot si es diferente
RUN echo '<Directory "/var/www/html">' > /etc/apache2/conf-available/htaccess.conf \
    && echo '    AllowOverride All' >> /etc/apache2/conf-available/htaccess.conf \
    && echo '</Directory>' >> /etc/apache2/conf-available/htaccess.conf \
    && a2enconf htaccess

# Configurar el ServerName de Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Reiniciar Apache para aplicar los cambios
RUN service apache2 restart

# Exponer puertos
EXPOSE 80
EXPOSE 443

# Comando para mantener el contenedor en ejecución
CMD ["apache2-foreground"]
