#!/usr/bin/env bash
set -e

echo "==> Waiting for MySQL to be ready..."
until php artisan db:show --no-ansi > /dev/null 2>&1; do
    sleep 2
done

echo "==> Running migrations..."
php artisan migrate --force

echo "==> Clearing caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Setting storage permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

echo "==> Starting services..."
exec "$@"
