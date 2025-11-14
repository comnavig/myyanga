#!/bin/bash

###############################################################################
# MyYanga Laravel Deployment Script for cPanel
# This script automates the deployment process
###############################################################################

# Color codes for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Configuration - UPDATE THESE VALUES
DEPLOY_PATH="/home/username/public_html"
PHP_VERSION="74" # Options: 74, 80, 81, 82
COMPOSER_PATH="/usr/local/bin/composer"
PHP_PATH="/usr/local/bin/ea-php${PHP_VERSION}"

###############################################################################
# Functions
###############################################################################

print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

print_info() {
    echo -e "${YELLOW}ℹ $1${NC}"
}

print_header() {
    echo ""
    echo "========================================"
    echo "$1"
    echo "========================================"
}

check_requirements() {
    print_header "Checking Requirements"

    # Check if PHP exists
    if [ ! -f "$PHP_PATH" ]; then
        print_error "PHP not found at $PHP_PATH"
        exit 1
    fi
    print_success "PHP found: $($PHP_PATH -v | head -n 1)"

    # Check if Composer exists
    if [ ! -f "$COMPOSER_PATH" ]; then
        print_error "Composer not found at $COMPOSER_PATH"
        exit 1
    fi
    print_success "Composer found"

    # Check if deployment directory exists
    if [ ! -d "$DEPLOY_PATH" ]; then
        print_error "Deployment path does not exist: $DEPLOY_PATH"
        exit 1
    fi
    print_success "Deployment path exists: $DEPLOY_PATH"
}

backup_current() {
    print_header "Creating Backup"

    BACKUP_DIR="$HOME/backups/myyanga_$(date +%Y%m%d_%H%M%S)"

    if [ -d "$DEPLOY_PATH" ]; then
        mkdir -p "$HOME/backups"
        cp -r "$DEPLOY_PATH" "$BACKUP_DIR"
        print_success "Backup created at: $BACKUP_DIR"
    else
        print_info "No existing deployment to backup"
    fi
}

install_dependencies() {
    print_header "Installing Composer Dependencies"

    cd "$DEPLOY_PATH" || exit 1

    $PHP_PATH $COMPOSER_PATH install \
        --optimize-autoloader \
        --no-dev \
        --no-interaction \
        --prefer-dist

    if [ $? -eq 0 ]; then
        print_success "Dependencies installed successfully"
    else
        print_error "Failed to install dependencies"
        exit 1
    fi
}

setup_environment() {
    print_header "Setting Up Environment"

    cd "$DEPLOY_PATH" || exit 1

    # Check if .env exists
    if [ ! -f ".env" ]; then
        if [ -f ".env.production" ]; then
            cp .env.production .env
            print_success ".env created from .env.production"
        else
            print_error ".env file not found. Please create it manually."
            exit 1
        fi
    else
        print_success ".env file exists"
    fi

    # Generate APP_KEY if not set
    if ! grep -q "APP_KEY=base64:" .env; then
        $PHP_PATH artisan key:generate --force
        print_success "Application key generated"
    else
        print_info "Application key already exists"
    fi
}

create_symlinks() {
    print_header "Creating Symbolic Links"

    cd "$DEPLOY_PATH" || exit 1

    # Remove existing symlink if it exists
    if [ -L "public/storage" ]; then
        rm public/storage
    fi

    $PHP_PATH artisan storage:link --force

    if [ $? -eq 0 ]; then
        print_success "Storage symlink created"
    else
        print_error "Failed to create storage symlink"
    fi
}

set_permissions() {
    print_header "Setting Permissions"

    cd "$DEPLOY_PATH" || exit 1

    # Set general permissions
    find . -type f -exec chmod 644 {} \;
    find . -type d -exec chmod 755 {} \;

    # Set write permissions for storage and cache
    chmod -R 775 storage
    chmod -R 775 bootstrap/cache

    # If the above doesn't work, try 777 (less secure)
    # chmod -R 777 storage
    # chmod -R 777 bootstrap/cache

    print_success "Permissions set"
}

optimize_application() {
    print_header "Optimizing Application"

    cd "$DEPLOY_PATH" || exit 1

    # Clear all caches
    print_info "Clearing caches..."
    $PHP_PATH artisan config:clear
    $PHP_PATH artisan cache:clear
    $PHP_PATH artisan view:clear
    $PHP_PATH artisan route:clear

    # Cache for production
    print_info "Caching for production..."
    $PHP_PATH artisan config:cache
    $PHP_PATH artisan route:cache
    $PHP_PATH artisan view:cache

    # Optimize composer
    $PHP_PATH $COMPOSER_PATH dump-autoload --optimize

    print_success "Application optimized"
}

run_migrations() {
    print_header "Database Migrations"

    cd "$DEPLOY_PATH" || exit 1

    read -p "Do you want to run database migrations? (y/N): " -n 1 -r
    echo

    if [[ $REPLY =~ ^[Yy]$ ]]; then
        $PHP_PATH artisan migrate --force

        if [ $? -eq 0 ]; then
            print_success "Migrations completed"
        else
            print_error "Migrations failed"
        fi
    else
        print_info "Skipping migrations"
    fi
}

verify_deployment() {
    print_header "Verifying Deployment"

    cd "$DEPLOY_PATH" || exit 1

    # Check if vendor directory exists
    if [ -d "vendor" ]; then
        print_success "Vendor directory exists"
    else
        print_error "Vendor directory missing"
    fi

    # Check if .env exists
    if [ -f ".env" ]; then
        print_success ".env file exists"
    else
        print_error ".env file missing"
    fi

    # Check if storage symlink exists
    if [ -L "public/storage" ]; then
        print_success "Storage symlink exists"
    else
        print_error "Storage symlink missing"
    fi

    # Check storage permissions
    if [ -w "storage" ]; then
        print_success "Storage directory is writable"
    else
        print_error "Storage directory is not writable"
    fi
}

###############################################################################
# Main Deployment Process
###############################################################################

main() {
    print_header "MyYanga Deployment Started"
    print_info "Deploy Path: $DEPLOY_PATH"
    print_info "PHP Version: $PHP_VERSION"
    echo ""

    # Run deployment steps
    check_requirements
    backup_current
    install_dependencies
    setup_environment
    create_symlinks
    set_permissions
    optimize_application
    run_migrations
    verify_deployment

    print_header "Deployment Completed Successfully!"
    print_success "Your application is now deployed at: $DEPLOY_PATH"
    echo ""
    print_info "Next steps:"
    echo "  1. Update your .env file with production settings"
    echo "  2. Test your application in a browser"
    echo "  3. Setup SSL certificate if not done"
    echo "  4. Configure cron jobs for scheduled tasks"
    echo ""
}

# Run main function
main
