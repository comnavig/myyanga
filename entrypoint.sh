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

# Wait for MySQL to be ready
sleep 3

# Run artisan commands
echo "Clearing Laravel cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run migrations
echo "Running migrations..."
php artisan migrate

# Create storage symlink
echo "Creating storage symlink..."
php artisan storage:link || true

# Seed the database conditionally
if [ -n "$DB_BACKUP_FILE" ] && [ -f "$DB_BACKUP_FILE" ]; then
    echo "DB_BACKUP_FILE ($DB_BACKUP_FILE) exists, skipping database seeding..."
else
    if [ -n "$DB_BACKUP_FILE" ]; then
        echo "Warning: DB_BACKUP_FILE ($DB_BACKUP_FILE) was set but the file does not exist!"
    fi
    echo "Seeding database..."
    php artisan db:seed
fi

# Optimize Laravel
echo "Optimizing Laravel..."
php artisan optimize

# Start Apache
echo "Starting Apache..."
apache2-foreground