#!/bin/bash

set -e

echo "Running Laravel setup..."

# Install dependencies if vendor is missing
if [ ! -d "vendor" ]; then
    echo "Installing Composer dependencies..."
    composer install
fi

# Generate app key if not set
if ! grep -q "APP_KEY=" .env || grep -q "APP_KEY=$" .env; then
    echo "Generating app key..."
    php artisan key:generate
fi

# Fix permissions every time container starts
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache

chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

# Run artisan commands
echo "Clearing Laravel cache..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true

php artisan migrate

# Starting Apache
echo "Starting Apache..."
apache2-foreground