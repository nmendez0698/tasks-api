FROM php:8.5.12-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libsqlite3-dev \
    libonig-dev \
    curl \
    && docker-php-ext-install pdo pdo_sqlite bcmath

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.8.12

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8000

CMD php artisan config:cache && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000