# syntax=docker/dockerfile:1

# ---- Frontend assets ----
FROM node:22-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY vite.config.js ./
COPY resources ./resources
COPY public ./public
RUN npm run build

# ---- PHP dependencies ----
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist --optimize-autoloader --ignore-platform-reqs
COPY . .
RUN composer dump-autoload --no-dev --optimize --no-scripts

# ---- Production PHP-FPM ----
FROM php:8.4-fpm AS production
WORKDIR /var/www/html

RUN apt-get update && apt-get install -y --no-install-recommends \
        libzip-dev libpng-dev libonig-dev libxml2-dev libicu-dev \
    && docker-php-ext-install pdo_mysql mbstring bcmath exif pcntl zip intl opcache \
    && rm -rf /var/lib/apt/lists/*

RUN { \
        echo 'opcache.enable=1'; \
        echo 'opcache.validate_timestamps=0'; \
        echo 'opcache.memory_consumption=128'; \
        echo 'expose_php=0'; \
    } > /usr/local/etc/php/conf.d/production.ini

COPY --from=vendor /app ./
COPY --from=assets /app/public/build ./public/build

RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

COPY docker/app/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]

# ---- Nginx with static assets ----
FROM nginx:1.27-alpine AS web
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY --from=production /var/www/html/public /var/www/html/public
