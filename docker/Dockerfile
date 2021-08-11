FROM debian:bullseye

RUN set -e \
    && export DEBIAN_FRONTEND=noninteractive \
    && apt-get update -y \
    && apt-get dist-upgrade -y \
    && apt-get install -y supervisor zip unzip git wget \
    && wget -q -O - https://packages.sury.org/php/README.txt | bash \
    && apt-get install -y php-cli php-zip php-mbstring php-xml \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY . /opt/api-descargar-cfdi
WORKDIR /opt/api-descargar-cfdi

RUN set -e \
    && export COMPOSER_ALLOW_SUPERUSER=1 \
    && composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader \
    && rm -rf "$(composer config cache-dir --global)" "$(composer config data-dir --global)" "$(composer config home --global)"

EXPOSE 80

COPY ./docker/supervisord.conf /etc/supervisor/supervisord.conf

ENTRYPOINT ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
