FROM php:8.2-cli-bookworm

RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip libaio1 libicu-dev libzip-dev $PHPIZE_DEPS \
 && docker-php-ext-install intl zip opcache \
 && rm -rf /var/lib/apt/lists/*


# Oracle Instant Client (basiclite + sdk; el sdk es necesario para compilar oci8)
RUN mkdir -p /opt/oracle && cd /opt/oracle \
 && curl -fsSLO https://download.oracle.com/otn_software/linux/instantclient/instantclient-basiclite-linuxx64.zip \
 && curl -fsSLO https://download.oracle.com/otn_software/linux/instantclient/instantclient-sdk-linuxx64.zip \
 && unzip -qo instantclient-basiclite-linuxx64.zip \
 && unzip -qo instantclient-sdk-linuxx64.zip \
 && rm -f *.zip \
 && mv instantclient_* instantclient \
 && echo /opt/oracle/instantclient > /etc/ld.so.conf.d/oracle.conf && ldconfig

ENV LD_LIBRARY_PATH=/opt/oracle/instantclient

# Extensión oci8 (misma versión que usas en Windows)
RUN echo 'instantclient,/opt/oracle/instantclient' | pecl install oci8-3.4.1 \
 && docker-php-ext-enable oci8

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/app
