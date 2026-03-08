FROM php:8.2-cli

WORKDIR /var/www

# installer dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl

# installer composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copier le projet
COPY . .

# installer dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# exposer le port
EXPOSE 10000

# lancer Laravel
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000