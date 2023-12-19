FROM php:7.4-apache

# Asegúrate de que los archivos de Oracle Instant Client estén en una subcarpeta llamada 'oracle-instantclient'
COPY ./php/instantclient-basic-linux.x64-12.2.0.1.0.zip /tmp/
COPY ./php/instantclient-sdk-linux.x64-12.2.0.1.0.zip /tmp/

# Instalar herramientas y dependencias necesarias
RUN apt-get update && apt-get install -y unzip libaio1

#intala git
RUN apt-get update && apt-get install -y git

# Descomprimir e instalar Oracle Instant Client
RUN mkdir -p /opt/oracle \
    && unzip "/tmp/instantclient-basic-linux.x64-12.2.0.1.0.zip" -d /opt/oracle \
    && unzip "/tmp/instantclient-sdk-linux.x64-12.2.0.1.0.zip" -d /opt/oracle \
    && rm -f /tmp/instantclient-basic-linux.x64-12.2.0.1.0.zip \
    && rm -f /tmp/instantclient-sdk-linux.x64-12.2.0.1.0.zip \
    && ln -s /opt/oracle/instantclient_12_2 /opt/oracle/instantclient

# Crear enlaces simbólicos necesarios para libclntsh.so
RUN ln -s /opt/oracle/instantclient/libclntsh.so.12.1 /opt/oracle/instantclient/libclntsh.so \
    && ln -s /opt/oracle/instantclient/libocci.so.12.1 /opt/oracle/instantclient/libocci.so

# Configurar variables de entorno para Oracle Instant Client
ENV LD_LIBRARY_PATH=/opt/oracle/instantclient
ENV ORACLE_BASE=/opt/oracle/instantclient
ENV ORACLE_HOME=/opt/oracle/instantclient

# Instalar la extensión OCI8
RUN docker-php-ext-configure oci8 --with-oci8=instantclient,/opt/oracle/instantclient,12.2 \
    && docker-php-ext-install oci8

# Copia tus archivos de la aplicación a /var/www/html
COPY ./php_codeneiter/app_clinica /var/www/html

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
