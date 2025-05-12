FROM php:8.2-fpm-alpine

# System dependencies
RUN apk add --no-cache \
    postgresql-dev \
    libpng-dev \
    libzip-dev \
    icu-dev \
    imagemagick-dev \
    linux-headers \
    hiredis-dev \
    autoconf \
    build-base \
    $PHPIZE_DEPS

# Install PHP extensions
RUN docker-php-ext-install \
    intl \
    bcmath \
    opcache \
    pdo \
    pdo_pgsql

# Install Redis extension
RUN pecl install redis && \
    docker-php-ext-enable redis

# Install GD and Zip extensions
RUN apk add --no-cache freetype-dev libjpeg-turbo-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd

# Install Imagick
RUN pecl install imagick && \
    docker-php-ext-enable imagick

# Install XDebug
RUN pecl install xdebug && \
    docker-php-ext-enable xdebug

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www