FROM php:7.1-fpm-alpine

RUN apk add --no-cache --virtual .persistent-deps \
    # for mcrypt extension
    libmcrypt-dev \
    libpng-dev

RUN set -xe \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql \
    && docker-php-ext-install \
        mcrypt \
        pdo_mysql \
        sockets \
        gd