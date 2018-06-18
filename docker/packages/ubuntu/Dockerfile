FROM ubuntu:xenial

#This images intends to have a virtual workspace to do PHP related tasks
USER root

ARG UBUNTU_USERNAME=default

RUN groupadd -g 1000 ${UBUNTU_USERNAME} \
    && useradd -u 1000 -g ${UBUNTU_USERNAME} -m ${UBUNTU_USERNAME}

# Install latest PHP
RUN apt-get update \
    && apt-get install -y software-properties-common \
    && export LANG=C.UTF-8 \
    && add-apt-repository -y ppa:ondrej/php

RUN apt-get update \
    && apt-get install -y --allow-downgrades --allow-remove-essential --allow-change-held-packages \
        php7.2-cli \
        php7.2-common \
        php7.2-curl \
        php7.2-intl \
        php7.2-json \
        php7.2-xml \
        php7.2-mbstring \
        php7.2-mysql \
        php7.2-pgsql \
        php7.2-sqlite \
        php7.2-sqlite3 \
        php7.2-zip \
        php7.2-bcmath \
        php7.2-memcached \
        php7.2-gd \
        php7.2-dev \
        phpunit \
        pkg-config \
        libcurl4-openssl-dev \
        libedit-dev \
        libssl-dev \
        libxml2-dev \
        xz-utils \
        mysql-client \
        postgresql-client \
        libsqlite3-dev \
        sqlite3 \
        git \
        curl \
        vim \
        nano \
        unzip \
        tar \
        openssh-server \
    && apt-get clean


# Add composer and to the image
RUN curl -s http://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && wget -O phpunit https://phar.phpunit.de/phpunit-7.phar \
    && mv phpunit /usr/local/bin/phpunit \
    && chmod +x /usr/local/bin/phpunit

# Creates a folder to host website files

RUN mkdir -p /var/www

WORKDIR /var/www

USER ${UBUNTU_USERNAME}

EXPOSE 22