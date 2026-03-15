# UtilityWise UAE — Laravel app (PHP 8.3)
FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install zip pdo_mysql mbstring exif pcntl bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction || true

# For production: run as non-root and use php-fpm + nginx if needed
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
