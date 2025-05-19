FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    postgresql-dev \
    libzip-dev \
    icu-dev

RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    zip \
    intl \
    fileinfo

RUN addgroup -g 1000 appgroup && \
    adduser -u 1000 -G appgroup -h /home/appuser -D appuser

RUN mkdir -p /srv/app/var/cache /srv/app/var/log /srv/app/storage /srv/app/public/storage && \
    chown -R www-data:www-data /srv/app/var && \
    ln -sf /srv/app/storage /srv/app/public/storage

USER www-data

WORKDIR /srv/app

HEALTHCHECK --interval=10s --timeout=5s --retries=5 --start-period=60s \
    CMD php-fpm -t || exit 1