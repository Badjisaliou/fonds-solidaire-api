FROM php:8.2-cli

WORKDIR /var/www

# installer dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    libzip-dev

# installer extensions PHP nécessaires
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    zip

# installer composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copier uniquement composer pour profiter du cache docker
COPY composer.json composer.lock ./

# installer dépendances Laravel
RUN composer install --no-dev --optimize-autoloader --no-interaction

# copier le reste du projet
COPY . .

# optimiser Laravel
RUN php artisan config:cache || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

# permissions nécessaires
RUN chmod -R 775 storage bootstrap/cache

# exposer le port utilisé par Render
EXPOSE 10000

# lancer migrations puis serveur
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT