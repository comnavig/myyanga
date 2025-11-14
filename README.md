# MyYanga - Multi-Featured E-commerce & Content Platform

MyYanga is a comprehensive Laravel-based platform that combines business directory listings, e-commerce marketplace, premium content subscriptions, and social features focused on grooming, fashion, and lifestyle services in Nigeria.

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [System Architecture](#system-architecture)
- [Installation](#installation)
- [Database Structure](#database-structure)
- [User Types & Access Control](#user-types--access-control)
- [Core Modules](#core-modules)
- [API Documentation](#api-documentation)
- [Configuration](#configuration)
- [Deployment](#deployment)
- [Contributing](#contributing)

---

## Overview

**MyYanga** is a multi-tenant platform that serves as:
- 📋 **Business Directory** - Yellow pages style business listings
- 🛒 **E-commerce Marketplace** - Product catalog and online shopping
- 💎 **Premium Content Platform** - Subscription-based exclusive content
- 📺 **Video Platform** - MyYanga TV for video content
- 📰 **Content Management** - Blog, grooming tips, and discovery content
- 👗 **Social Features** - Post Your Look fashion competitions

### Tech Stack

- **Framework**: Laravel 7.x
- **PHP**: 7.2.5+ or 8.0+
- **Database**: MySQL/MariaDB
- **Storage**: Local/DigitalOcean Spaces/AWS S3
- **Mail**: Mailgun/SMTP
- **Image Processing**: Intervention/Image
- **HTTP Client**: Guzzle

---

## Features

### 🏢 Business Directory
- Business listing registration with CAC (Corporate Affairs Commission) verification
- Multi-branch support (parent-child business relationships)
- Multiple contact methods (phones, emails, website URLs)
- Location-based search and filtering
- Featured listings
- User following/subscription to businesses

### 🛍️ E-commerce Marketplace
- Product catalog with categories and subcategories
- Multiple product images
- Shopping cart functionality
- Multi-address checkout system
- Product reviews and ratings
- Wishlist/favourites
- Order management and tracking
- Delivery notes and shipment tracking
- Featured products showcase
- Advanced search and filtering

### 💳 Premium Subscription System
- Monthly subscription service
- Payment processing with transaction tracking
- VAT calculation
- Subscription expiry automation
- Exclusive premium content access
- Email notifications for new content

### 📱 Content Management
- **Blog** - Multi-category blog system
- **Grooming Tips** - Categorized grooming and beauty articles
- **Discover** - Editorial and lifestyle content
- **MyYanga TV** - Video content platform with categories
- All content types support multiple images

### 👔 Social Features
- **Post Your Look** - Fashion/style competitions
- User submissions and entries
- Public voting system
- Competition status tracking

### 🔔 Notification System
- Email notifications for:
  - Order confirmations
  - Product purchases
  - Premium content updates
  - Subscription renewals
- User notification preferences

### 📊 Admin Panel
- Complete dashboard with analytics
- User management (approve/suspend/delete)
- Content approval workflows
- Product and listing moderation
- Order and delivery management
- Settings and configuration management
- Advertisement management

---

## System Architecture

### Directory Structure

```
myyanga/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin panel controllers
│   │   │   ├── Business/       # Business user controllers
│   │   │   ├── Individual/     # Individual user controllers
│   │   │   └── Auth/           # Authentication controllers
│   │   └── Middleware/         # Custom middleware
│   ├── Mail/                   # Email notifications
│   ├── Models/                 # 32+ Eloquent models
│   └── Helpers/                # Helper classes (ResizeImg, etc.)
├── database/
│   ├── migrations/             # 43 database migrations
│   ├── seeds/                  # Database seeders
│   └── factories/              # Model factories
├── resources/
│   └── views/
│       ├── admin/              # Admin panel views
│       ├── business/           # Business dashboard views
│       ├── user/               # User dashboard views
│       ├── shop/               # E-commerce views
│       ├── blog/               # Blog views
│       ├── groomingtips/       # Grooming tips views
│       ├── tvs/                # Video platform views
│       ├── discovers/          # Discovery content views
│       ├── premiums/           # Premium content views
│       └── emails/             # Email templates
├── routes/
│   ├── web.php                 # Web routes (~349 lines)
│   └── api.php                 # API routes
├── config/                     # Configuration files
└── public/
    ├── assets/                 # Frontend assets
    ├── products/               # Product images
    └── uploads/                # User uploads
```

---

## Installation

### Prerequisites

- PHP >= 7.2.5
- MySQL/MariaDB
- Composer
- Node.js & NPM (for asset compilation)

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd myyanga
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Environment configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database** in `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=myyanga_myyanga
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Configure mail settings** in `.env`:
   ```env
   MAIL_MAILER=mailgun
   MAIL_FROM_ADDRESS=info@myyanga.com
   MAILGUN_DOMAIN=myyanga.com
   MAILGUN_SECRET=your_mailgun_secret
   ```

7. **Configure storage** (optional - for cloud storage):
   ```env
   # DigitalOcean Spaces
   DO_ACCESS_KEY_ID=your_key
   DO_SECRET_ACCESS_KEY=your_secret
   DO_DEFAULT_REGION=nyc3
   DO_BUCKET=your_bucket
   ```

8. **Run migrations**
   ```bash
   php artisan migrate
   ```

9. **Seed the database** (optional)
   ```bash
   php artisan db:seed
   ```

10. **Create storage symlink**
    ```bash
    php artisan storage:link
    ```

11. **Set proper permissions**
    ```bash
    chmod -R 775 storage bootstrap/cache
    ```

12. **Compile assets**
    ```bash
    npm run dev
    # or for production
    npm run production
    ```

13. **Start development server**
    ```bash
    php artisan serve
    ```

Visit: `http://localhost:8000`

### Default Seeded Credentials

After running seeders, you can login with:

- **Admin**: admin@myyanga.com / password
- **User**: john@example.com / password
- **Business**: business@example.com / password

---

## Database Structure

### Core Tables (43 migrations)

#### User & Authentication
- `users` - User accounts (INDIVIDUAL, BUSINESS, ADMIN types)
- `password_resets` - Password reset tokens
- `failed_jobs` - Failed queue jobs

#### Business Listings
- `listings` - Business/brand listings
- `listing_categories` - Listing category associations
- `listing_emails` - Multiple emails per listing
- `listing_phones` - Multiple phones per listing
- `listing_urls` - Website/social URLs
- `listing_follows` - User-listing subscriptions

#### E-commerce
- `products` - Product catalog
- `product_pictures` - Product images
- `product_shipments` - Shipping information
- `product_favourites` - User wishlists
- `product_reviews` - Product ratings
- `product_solds` - Sold items record
- `orders` - Purchase orders
- `addresses` - Shipping addresses
- `delivery_notes` - Delivery tracking

#### Content
- `posts` - Blog posts
- `post_categories` - Blog categories
- `post_pictures` - Blog images
- `groom_tips` - Grooming tips articles
- `groom_tip_categories` - Grooming categories
- `groom_tips_pictures` - Grooming tip images
- `discovers` - Discovery/editorial content
- `discover_categories` - Discovery categories
- `discover_pictures` - Discovery images
- `premia` - Premium subscriber content
- `premium_categories` - Premium content categories
- `premium_pictures` - Premium content images
- `tvs` - Video content (MyYanga TV)
- `tv_categories` - Video categories

#### Social Features
- `post_your_looks` - Fashion competitions
- `user_post_your_looks` - User entries
- `post_your_look_votes` - Competition votes

#### System
- `categories` - Product categories
- `locations` - Cities/regions
- `featured_categories` - Featured product groupings
- `featured_products` - Featured items
- `ads` - Advertisement management
- `pages` - CMS pages
- `settings` - Site configuration
- `premium_subscriptions` - Premium memberships
- `user_notifications` - User notification preferences

---

## User Types & Access Control

### User Types

1. **INDIVIDUAL** - Regular customers
   - Browse and purchase products
   - Follow businesses
   - Submit Post Your Look entries
   - Purchase premium subscriptions
   - Manage orders and favourites

2. **BUSINESS** - Business owners
   - Create and manage listings
   - Add and manage products
   - View sold items and delivery notes
   - Access business dashboard

3. **ADMIN** - Platform administrators
   - Full system access
   - Approve/moderate listings and products
   - Manage all content
   - User management
   - Site configuration

### Middleware

- `OnlyAdmin` - Admin-only access
- `OnlyBusiness` - Business user access
- `OnlyUser` - Individual user access
- `Subscriber` - Active premium subscription required
- `Verified` - Email verification required
- `NotVerified` - Non-verified users only

---

## Core Modules

### 1. Business Listings Module

**Controllers**: `Business\ListingController`, `Admin\ListingController`

**Features**:
- Create business listings with CAC verification
- Multi-branch support (parent-child relationships)
- Upload business logos
- Add multiple contact methods
- Location and category selection
- Featured listing promotion
- Approval workflow

**Routes**:
```
GET  /businesses          - Browse all businesses
GET  /businesses/{slug}   - View business details
POST /business/listing    - Create listing (business users)
GET  /admin/listings      - Manage listings (admin)
```

### 2. E-commerce Module

**Controllers**: `ShopController`, `Business\ProductController`, `Admin\ProductController`

**Features**:
- Product catalog with categories
- Shopping cart system
- Multi-step checkout
- Multiple shipping addresses
- Product reviews and ratings
- Wishlist functionality
- Order tracking
- Delivery management

**Routes**:
```
GET  /shop                    - Browse products
GET  /shop/product/{slug}     - Product details
POST /shop/cart/add           - Add to cart
GET  /shop/checkout           - Checkout page
POST /shop/order              - Place order
GET  /user/orders             - Order history
```

### 3. Premium Subscription Module

**Controllers**: `Individual\DashboardController`, `Admin\DashboardController`

**Features**:
- Monthly subscription plans
- Payment processing
- VAT calculation
- Auto-expiry tracking
- Access control for premium content
- Email notifications

**Routes**:
```
GET  /user/premium-subscriptions     - View subscriptions
POST /user/subscribe                 - Purchase subscription
GET  /premium                        - Premium content (subscriber only)
```

### 4. Content Management Module

**Controllers**:
- `Admin\BlogController`
- `Admin\GroomTipsController`
- `Admin\DiscoverController`
- `Admin\TVsController`

**Features**:
- Multi-category blog system
- Grooming tips and guides
- Editorial discovery content
- Video content platform
- Image galleries
- Content approval workflow

**Routes**:
```
GET /blog                      - Blog listing
GET /blog/{slug}              - Blog post
GET /grooming-tips            - Grooming tips
GET /discover                 - Discovery content
GET /tv                       - MyYanga TV
```

### 5. Social Features Module

**Controllers**: `Admin\PYLController`, `Individual\DashboardController`

**Features**:
- Post Your Look competitions
- User photo submissions
- Public voting system
- Competition management
- Winner selection

**Routes**:
```
GET  /post-your-look              - View competitions
POST /user/pyl/upload             - Submit entry
POST /post-your-look/{id}/vote    - Vote for entry
```

---

## API Documentation

### Authentication

API uses Laravel Sanctum token authentication.

### Endpoints

Currently minimal API implementation:

```
GET /api/user
```
**Headers**: `Authorization: Bearer {token}`
**Response**: Authenticated user data

**Rate Limiting**: 60 requests per minute

### Extending the API

The application is ready for API expansion. Add routes in `routes/api.php`:

```php
Route::middleware('auth:api')->group(function () {
    Route::get('/products', 'API\ProductController@index');
    Route::get('/listings', 'API\ListingController@index');
});
```

---

## Configuration

### Key Configuration Files

#### Mail Configuration (`config/mail.php`)
- Mailgun (default)
- SMTP
- SES
- Postmark

#### Storage Configuration (`config/filesystems.php`)
- **local** - Local storage
- **public** - Public files
- **s3** - AWS S3
- **spaces** - DigitalOcean Spaces (active)
- Custom disks: avatar, posts, ads, temp

#### Session Configuration
- Driver: file
- Lifetime: 21600 minutes (15 days)
- Cookie encryption: enabled

#### Services Configuration
- Mailgun API
- AWS services
- DigitalOcean Spaces
- reCAPTCHA keys

### Environment Variables

Required `.env` variables:

```env
APP_NAME='My Yanga'
APP_ENV=production
APP_KEY=base64:...
APP_DEBUG=false
APP_URL=https://myyanga.com

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=myyanga_myyanga
DB_USERNAME=myyanga_user
DB_PASSWORD=secure_password

# Mail
MAIL_MAILER=mailgun
MAIL_FROM_ADDRESS=info@myyanga.com
MAILGUN_DOMAIN=myyanga.com
MAILGUN_SECRET=your_mailgun_key

# Storage (DigitalOcean Spaces)
DO_ACCESS_KEY_ID=your_key
DO_SECRET_ACCESS_KEY=your_secret
DO_DEFAULT_REGION=nyc3
DO_BUCKET=your_bucket

# reCAPTCHA
RECAPTCHA_SITE_KEY=your_site_key
RECAPTCHA_SECRET_KEY=your_secret_key
```

---

## Deployment

MyYanga provides **automated deployment** support for cPanel hosting with comprehensive deployment guides.

### 🚀 Quick Deployment Options

#### **Option 1: Automated cPanel Git Deployment** (Recommended)

Perfect for cPanel hosting with Git Version Control enabled.

**5-Minute Setup:**
1. Setup Git repository in cPanel
2. Configure `.env` file
3. Click "Deploy HEAD Commit"
4. Run migrations
5. **Done!** ✅

**📘 Read**: [DEPLOYMENT_QUICKSTART.md](DEPLOYMENT_QUICKSTART.md) - Fast-track 5-minute setup guide

#### **Option 2: Manual Script Deployment**

For servers with SSH access or when Git deployment isn't available.

**Using the deployment script:**
```bash
# Configure the script
nano deploy.sh  # Update DEPLOY_PATH and PHP_VERSION

# Run deployment
chmod +x deploy.sh
./deploy.sh
```

The script automatically handles:
- ✅ Requirement checks
- ✅ Backup creation
- ✅ Dependency installation
- ✅ Environment setup
- ✅ Permission management
- ✅ Cache optimization
- ✅ Deployment verification

**📘 Read**: [DEPLOYMENT.md](DEPLOYMENT.md) - Complete deployment guide with troubleshooting

---

### 📦 Deployment Files

This repository includes:

| File | Purpose | Usage |
|------|---------|-------|
| [`.cpanel.yml`](.cpanel.yml) | cPanel Git automation | Auto-runs on Git deploy |
| [`deploy.sh`](deploy.sh) | Interactive script | `./deploy.sh` on server |
| [`.env.production`](.env.production) | Production config template | Copy to `.env` |
| [`DEPLOYMENT.md`](DEPLOYMENT.md) | Complete guide | Full documentation |
| [`DEPLOYMENT_QUICKSTART.md`](DEPLOYMENT_QUICKSTART.md) | Quick start | 5-minute setup |

---

### ⚙️ Server Requirements

**Minimum Requirements:**
- **PHP**: 7.2.5 - 8.0 (7.4+ recommended)
- **MySQL/MariaDB**: 5.7+ / 10.3+
- **Composer**: Latest version
- **PHP Extensions**:
  - BCMath, Ctype, Fileinfo, JSON, Mbstring
  - OpenSSL, PDO, pdo_mysql, Tokenizer, XML
  - GD or Imagick (for Intervention/Image)
  - ZIP (for package management)

**Recommended:**
- **Memory**: 512MB+ PHP memory limit
- **Storage**: 2GB+ available disk space
- **SSL**: Let's Encrypt or commercial certificate

---

### 🔧 Production Checklist

Before deploying to production:

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Generate unique `APP_KEY`
- [ ] Configure database credentials
- [ ] Setup SMTP mail settings
- [ ] Configure reCAPTCHA keys
- [ ] Enable SSL certificate
- [ ] Set document root to `/public`
- [ ] Configure cron jobs for notifications
- [ ] Run database migrations
- [ ] Test email sending
- [ ] Verify file uploads work
- [ ] Enable production caching:
  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  ```

---

### 🔄 Post-Deployment

#### **Setup Cron Jobs**

For email notifications (runs daily at 8 AM):
```bash
0 8 * * * curl -s https://yourdomain.com/cronwork > /dev/null 2>&1
```

For Laravel scheduler (if you add scheduled tasks):
```bash
* * * * * cd /path-to-app && php artisan schedule:run >> /dev/null 2>&1
```

#### **Setup Queue Workers** (Optional)

If using database queue driver:
```bash
# Create queue table
php artisan queue:table
php artisan migrate

# Run queue worker via cron
* * * * * cd /path-to-app && php artisan queue:work --stop-when-empty >> /dev/null 2>&1
```

Or use Supervisor for persistent workers:
```ini
[program:myyanga-worker]
command=php /path-to-app/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path-to-app/storage/logs/worker.log
```

---

### 🔐 Security Recommendations

1. **Environment Protection**
   - Never commit `.env` to version control
   - Use strong `APP_KEY` (auto-generated)
   - Disable debug mode in production

2. **File Permissions**
   ```bash
   chmod -R 755 storage bootstrap/cache
   # On shared hosting, may need 775 or 777
   ```

3. **Force HTTPS**
   Add to `public/.htaccess`:
   ```apache
   RewriteCond %{HTTPS} off
   RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
   ```

4. **Regular Backups**
   - Enable automated cPanel backups
   - Backup both files and database
   - Test restore procedures

5. **Update Dependencies**
   ```bash
   composer update --no-dev
   ```

---

### 🆘 Common Deployment Issues

#### 500 Internal Server Error
```bash
# Check logs
tail -f storage/logs/laravel.log

# Fix permissions
chmod -R 775 storage bootstrap/cache

# Clear caches
php artisan config:clear
php artisan cache:clear
```

#### Storage/Images Not Loading
```bash
# Recreate storage symlink
php artisan storage:link
```

#### Database Connection Failed
- Verify credentials in `.env`
- Ensure database user has privileges
- Try `DB_HOST=127.0.0.1` instead of `localhost`

**For more troubleshooting**, see [DEPLOYMENT.md](DEPLOYMENT.md#troubleshooting)

---

### 📚 Deployment Documentation

- **🚀 [Quick Start Guide](DEPLOYMENT_QUICKSTART.md)** - 5-minute deployment
- **📖 [Complete Deployment Guide](DEPLOYMENT.md)** - Detailed instructions, troubleshooting, updates
- **🔧 [Deploy Script](deploy.sh)** - Automated deployment tool
- **⚙️ [cPanel Config](.cpanel.yml)** - Git deployment automation

---

### 🔄 Updating Production

**Using Git Deployment:**
1. Push changes to repository
2. cPanel → Git Version Control → Manage
3. Update from Remote → Deploy HEAD Commit

**Manual Update:**
```bash
cd /path-to-app
git pull origin master
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Project Structure Overview

### Models (32 total)

**Core Business Models**:
- `User` - User accounts
- `Listing` - Business listings
- `Product` - E-commerce products
- `Category` - Product categories
- `Location` - Geographic locations

**Content Models**:
- `Post` - Blog posts
- `GroomTips` - Grooming articles
- `Discover` - Discovery content
- `Premium` - Premium content
- `Tv` - Video content

**E-commerce Models**:
- `Order` - Purchase orders
- `ProductReview` - Product reviews
- `ProductFavourite` - Wishlists
- `ProductSold` - Sales records
- `DeliveryNote` - Delivery tracking

**Social Models**:
- `PostYourLook` - Competitions
- `UserPostYourLook` - User entries
- `PostYourLookVote` - Votes

### Key Routes Summary

- **Public Routes**: ~100 routes
- **Auth Routes**: Standard Laravel auth
- **User Routes**: `/user/*` - Individual user dashboard
- **Business Routes**: `/business/*` - Business management
- **Admin Routes**: `/admin/*` - Admin panel
- **API Routes**: `/api/*` - RESTful API

---

## Email Notifications

### Available Notifications

1. **OrderPurchased** - Sent when order is placed
2. **ProductPurchased** - Product purchase confirmation
3. **ProductNotification** - Product updates
4. **PremiumNotification** - Premium content alerts
5. **NewPremiumNotification** - New premium content available
6. **PremiumSubscriptionPurchased** - Subscription confirmation
7. **SubscriptionPurchased** - General subscription confirmation

### Notification Configuration

Configure in [config/mail.php](config/mail.php) and `.env`

---

## Scheduled Tasks

### Cron Jobs

Add to crontab:
```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

### Custom Route for Notifications
```
GET /cronwork - Scheduled notification processing
```

---

## Third-Party Integrations

### Current Integrations

1. **Mailgun** - Email delivery service
2. **DigitalOcean Spaces** - Cloud file storage
3. **reCAPTCHA** - Form protection
4. **Intervention/Image** - Image processing

### Ready for Integration

- AWS S3 storage
- Pusher for real-time features
- Redis for caching/queues
- Broadcasting services

---

## Development Guidelines

### Code Style

- Follow PSR-2 coding standards
- Use meaningful variable and function names
- Document complex logic with comments
- Keep controllers thin, move logic to services/repositories

### Database Migrations

Always create migrations for schema changes:
```bash
php artisan make:migration create_table_name
```

### Creating Seeders

```bash
php artisan make:seeder TableNameSeeder
```

Register in `DatabaseSeeder.php`

### Testing

```bash
php artisan test
# or
./vendor/bin/phpunit
```

---

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## Security

### Security Features

- CSRF protection on all forms
- Password hashing (bcrypt)
- Email verification required
- SQL injection protection (Eloquent ORM)
- XSS protection
- HTTPS recommended for production

### Reporting Security Issues

If you discover a security vulnerability, please email security@myyanga.com

---

## Troubleshooting

### Common Issues

**Permission Errors**:
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

**Clear Caches**:
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

**Regenerate Autoload**:
```bash
composer dump-autoload
```

**Storage Link Issue**:
```bash
php artisan storage:link
```

---

## License

This project is proprietary software. All rights reserved.

---

## Support

For support, email support@myyanga.com or visit [https://myyanga.com](https://myyanga.com)

---

## Acknowledgments

- Built with [Laravel](https://laravel.com)
- Image processing by [Intervention/Image](http://image.intervention.io)
- Icons and UI components from various open-source projects

---

**Version**: 1.0.0
**Last Updated**: November 2025
**Maintainer**: MyYanga Development Team
