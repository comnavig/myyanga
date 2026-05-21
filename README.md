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

MyYanga is fully configured to use secure, private cloud storage (Railway S3 Buckets) in production, while seamlessly falling back to local storage during development.

### How it Works
1. **Dynamic Configuration:** In `config/filesystems.php`, all application disks (`public`, `avatar`, `temp`, `posts`, `ads`) dynamically switch between the `local` driver and the `s3` driver based on your `FILESYSTEM_DRIVER` environment variable.
2. **Uploading:** When uploading a file, Laravel automatically routes the file to the correct destination (either your local `storage/app/public` folder or directly into your Railway Bucket).
3. **Serving Private Files:** Railway Buckets are private by default. To securely serve images without making the bucket public, MyYanga uses the `\App\Helpers\StorageHelper::getUrl()` helper method.
   - **Locally:** It generates a standard local URL (`http://localhost/storage/avatar.jpg`).
   - **In Production:** It authenticates with AWS/Railway and generates a secure, **24-hour temporary presigned URL**. This allows users to view the image directly from the bucket without incurring backend proxy bandwidth costs.

### Environment Setup for Storage
To enable S3 storage on Railway, configure these variables in your environment:
```env
FILESYSTEM_DRIVER=s3
AWS_ACCESS_KEY_ID=your_railway_access_key
AWS_SECRET_ACCESS_KEY=your_railway_secret_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your_railway_bucket_name
AWS_ENDPOINT=https://s3.railway.app
AWS_URL=https://your_railway_bucket_public_url.up.railway.app
```

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
