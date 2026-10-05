#!/bin/sh
set -e

mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs
chown -R www-data:www-data storage bootstrap/cache

if [ "$1" = "php-fpm" ]; then
    php artisan storage:link --force
    php artisan migrate --force
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

exec "$@"
