FROM php:8.2-cli

WORKDIR /var/www

# installer dépendances système + librairies PostgreSQL
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev

# installer extensions PHP pour PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql

# installer composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copier le projet
COPY . .

# installer dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# permissions Laravel (important)
RUN chmod -R 775 storage bootstrap/cache

# exposer le port
EXPOSE 10000

# lancer migrations + serveur Laravel
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT