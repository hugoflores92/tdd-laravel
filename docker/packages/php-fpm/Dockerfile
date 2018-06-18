FROM php:7.2-fpm-alpine

COPY ./xdebug.ini /xdebug.tmp

# Install the xdebug extension
RUN apk update \
    && apk upgrade \
    && apk add --no-cache autoconf \
    && apk --no-cache add pcre-dev ${PHPIZE_DEPS} \
    && pecl install xdebug \
    && echo "[XDebug]\nzend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" \
        | cat - /xdebug.tmp > /usr/local/etc/php/conf.d/xdebug.ini \
    && rm -f /xdebug.tmp \
    && docker-php-ext-enable xdebug \
    && apk del pcre-dev ${PHPIZE_DEPS}

RUN set -ex \
    && apk --no-cache add zlib-dev postgresql-dev \
    && docker-php-ext-install zip \
    && docker-php-ext-install mysqli pdo pdo_mysql pdo_pgsql

RUN echo http://dl-2.alpinelinux.org/alpine/edge/community/ >> /etc/apk/repositories

RUN apk --no-cache add shadow \
    && usermod -u 1000 www-data

WORKDIR /var/www

CMD ["php-fpm"]

ARG PHP_UPSTREAM_PORT=9000
ENV PHP_UPSTREAM_PORT=${PHP_UPSTREAM_PORT}

EXPOSE ${PHP_UPSTREAM_PORT}