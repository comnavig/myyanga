#!/bin/bash

set -e

echo "Running Laravel setup..."

# Install dependencies if vendor is missing
if [ ! -d "vendor" ]; then
    echo "Installing Composer dependencies..."
    composer install --no-dev --optimize-autoloader
fi

# Fix permissions every time container starts, laravel needs write permissions to storage and bootstrap/cache directories
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache

chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

sleep 3

# Run artisan commands
echo "Clearing Laravel cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Create storage symlink
echo "Creating storage symlink..."
php artisan storage:link || true

# Run optimizations
echo "Running optimizations..."
php artisan optimize


echo "Laravel setup completed successfully!"
echo "Starting Apache now..."
apache2-foreground
