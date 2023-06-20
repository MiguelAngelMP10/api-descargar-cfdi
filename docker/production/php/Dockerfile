FROM php:8.2-fpm
ARG NODE_VERSION=18

RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update

# Install useful tools
RUN apt-get -y install apt-utils nano wget dialog vim

RUN apt-get install -y \
        libzip-dev \
        zip \
        && docker-php-ext-install zip

RUN curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
    && curl -sLS https://deb.nodesource.com/setup_$NODE_VERSION.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm
