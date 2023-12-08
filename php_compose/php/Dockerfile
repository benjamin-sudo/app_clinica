FROM php:7.4-apache

# Asegúrate de que los archivos de Oracle Instant Client estén en una subcarpeta llamada 'oracle-instantclient'
COPY ./php/instantclient-basic-linux.x64-12.2.0.1.0.zip /tmp/
COPY ./php/instantclient-sdk-linux.x64-12.2.0.1.0.zip /tmp/

# Instalar herramientas y dependencias necesarias, incluyendo git y Composer
RUN apt-get update && apt-get install -y unzip libaio1 git libicu-dev \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && rm -rf /var/lib/apt/lists/*

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

# Instalar la extensión intl
RUN docker-php-ext-install intl

# Instalar la extensión OCI8
RUN docker-php-ext-configure oci8 --with-oci8=instantclient,/opt/oracle/instantclient,12.2 \
    && docker-php-ext-install oci8


# Configurar variables de entorno para Composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Crear proyecto CodeIgniter 4
WORKDIR /var/www/html/app_clinica
RUN composer create-project codeigniter4/appstarter app_clinica

COPY ./php/html/ /var/www/html/app_clinica/

# Cambiar el DocumentRoot de Apache
RUN sed -i 's|/var/www/html|/var/www/html/app_clinica/public|g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's|/var/www/html|/var/www/html/app_clinica/public|g' /etc/apache2/apache2.conf


EXPOSE 80 443

