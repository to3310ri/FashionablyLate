FROM php:8.2-fpm

COPY php.ini /usr/local/etc/php/

RUN apt-get update \
  && apt-get install -y zlib1g-dev mariadb-client vim libzip-dev unzip \
  && docker-php-ext-install zip pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www