FROM php:8.2-cli

WORKDIR /var/www

# installer dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev

# installer extensions PHP PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql

# installer composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copier tout le projet Laravel
COPY . .

# installer dépendances
RUN composer install --no-dev --optimize-autoloader --no-interaction

# permissions Laravel
RUN chmod -R 775 storage bootstrap/cache

# exposer port
EXPOSE 10000

# lancer migrations + serveur
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT