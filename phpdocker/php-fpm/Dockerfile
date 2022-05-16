ARG PHP_VERSION=8.0

FROM phpdockerio/php:${PHP_VERSION}-fpm
WORKDIR "/application"

RUN apt-get update \
    && apt-get -y --no-install-recommends install php8.0-mysql php8.0-intl \
    && apt-get -y --no-install-recommends install npm \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN npm install n -g && \
    n lts

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

CMD ["/entrypoint.sh"]
