# MyYanga - Multi-Featured E-commerce & Content Platform

MyYanga is a comprehensive Laravel-based platform that combines business directory listings, e-commerce marketplace, premium content subscriptions, and social features focused on grooming, fashion, and lifestyle services in Nigeria.

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
- **PHP**: 7.4+
- **Database**: MySQL/MariaDB
- **Storage**: Railway S3 Buckets / Local Storage
- **Mail**: Mailgun/SMTP
- **Image Processing**: Intervention/Image

---

## Image Storage & Serving Architecture ☁️

MyYanga is fully configured to securely serve images from a **private cloud storage bucket** (like Railway/Tigris) in production without public access exposures or link expirations, while seamlessly falling back to local storage during development.

### How it Works:
1. **Dynamic Disk configuration:** All application disks in `config/filesystems.php` dynamically switch between local and S3 storage based on `FILESYSTEM_DRIVER`.
2. **Unified Backend Proxy:** In production, files are securely fetched from the S3 bucket behind the scenes and streamed via a local `/storage/{path}` proxy route (`HomeController@serve_file`).
3. **Database Portability:** We only save clean relative paths (e.g. `settings/logo.svg` or `products/image.jpg`) in the database.
4. **Eloquent Accessor:** Settings like logos and background images are resolved on-the-fly dynamically via a Settings model accessor.
5. **CDN Cacheable:** All URLs generated are static and permanent, allowing 100% efficient edge caching via CDNs (like Cloudflare) to completely eliminate repeating server egress charges.

**📘 Detailed Architecture**: [IMAGES_README.md](IMAGES_README.md) - Complete documentation on uploads, serving logic, S3 proxy routing, and environment parameters.

---

## Docker Setup (Recommended) 🐳

For a fast and consistent development environment, we recommend using Docker.

**📘 Read**: [DOCKER_README.md](DOCKER_README.md) - Detailed Docker setup and architecture.

### Quick Start with Docker
```bash
# 1. Prepare environment file
cp .env.local .env

# 2. Start containers
docker-compose up -d
```
The Docker environment is pre-configured with PHP 7.4, MySQL, and PHPMyAdmin.

---

## Local Installation (Without Docker)

1. **Clone & Install Dependencies**
   ```bash
   git clone <repository-url>
   cd myyanga
   composer install
   npm install
   ```

2. **Environment & Database**
   ```bash
   cp .env.example .env
   php artisan key:generate
   # (Configure your DB credentials in .env now)
   php artisan migrate
   php artisan db:seed
   php artisan storage:link
   ```

3. **Compile & Run**
   ```bash
   npm run dev
   php artisan serve
   ```

---

## Deployment (Railway) 🚂

MyYanga is optimized for modern PaaS deployment on Railway.

1. Create a MySQL database and a Storage Bucket in your Railway project.
2. Connect your GitHub repository to a new Railway web service.
3. Add the required environment variables (Database, `APP_URL`, `APP_KEY`, and all AWS/S3 Storage credentials listed above).
4. Define your build and start commands in Railway or let the default Nixpacks configuration handle the PHP/Laravel setup.

---

## Security & Maintenance

- **Permissions:** If running locally without Docker, ensure `storage` and `bootstrap/cache` are writable (`chmod -R 775`).
- **Caches:** In production, always optimize your app:
  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  ```

---

**Version**: 1.0.0  
**Maintainer**: MyYanga Development Team
