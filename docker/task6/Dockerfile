FROM php:8.2-fpm-alpine:latest

#System dependencies
RUN apk add --no-cache \
    postgresql-dev \
    libpng-dev \
    libzip-dev \
    icu-dev \
    imagemagick-dev \
    $PHPIZE_DEPS

# Install PHP extensions
RUN docker-php-ext-install \
    intl \
    bcmath \
    opcache \
    pdo \
    pdo_pgsql

# Install GD and Zip extensions
RUN apk add --no-cache freetype-dev libjpeg-turbo-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd

#Install Imagick
RUN pecl install imagick && \
    docker-php-ext-enable imagick

# Install XDebug
RUN pecl install xdebug && \
    docker-php-ext-enable xdebug

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www