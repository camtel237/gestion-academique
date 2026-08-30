FROM php:8.3-cli

# Dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Dossier de travail
WORKDIR /var/www

# Copier les fichiers Composer
COPY composer.json composer.lock ./

# Installer les dépendances Laravel
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader

# Copier le projet
COPY . .

# Permissions Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Port utilisé par Render
EXPOSE 10000

# Démarrer Laravel
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}