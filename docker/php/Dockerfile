FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo_mysql zip sockets \
    && rm -rf /var/lib/apt/lists/*
    
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer