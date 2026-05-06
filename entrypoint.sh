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

# Fix permissions every time container starts, laravel needs write permissions to storage and bootstrap/cache directories
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache

chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

# Wait for MySQL to be ready
# until php -r "
# try {
#     new PDO(
#         'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_DATABASE'),
#         getenv('DB_USERNAME'),
#         getenv('DB_PASSWORD')
#     );
#     exit(0);
# } catch (Exception \$e) {
#     exit(1);
# }
# "; do
#     echo \"Waiting for DB...\"
#     sleep 2
# done
sleep 3

# Run artisan commands
echo "Clearing Laravel cache..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true

# Run migrations
echo "Running migrations..."
php artisan migrate

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

# Start Apache
echo "Starting Apache..."
apache2-foreground