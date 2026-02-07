FROM php:8.2-fpm-alpine

# Installa le dipendenze di sistema usando apk (non apt-get)
RUN apk update && apk add --no-cache \
    git \
    curl \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    icu-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Installa Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Imposta la directory di lavoro
WORKDIR /var/www

# Copia i file dell'applicazione
COPY . .

# Installa le dipendenze di Laravel
RUN composer install --no-dev --optimize-autoloader

# Imposta i permessi
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

EXPOSE 9000

CMD ["php-fpm"]