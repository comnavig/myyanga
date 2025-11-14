# MyYanga cPanel Deployment Guide

This guide will help you deploy the MyYanga Laravel application to cPanel using Git deployment.

## 📋 Prerequisites

Before you begin, ensure you have:

- cPanel account with SSH access
- PHP 7.4 or higher enabled
- MySQL database created
- Git Version Control enabled in cPanel
- Composer installed on the server
- Domain/subdomain configured

---

## 🚀 Quick Deployment Using cPanel Git

### Method 1: Automatic Deployment with .cpanel.yml (Recommended)

The `.cpanel.yml` file in this repository automates the deployment process.

#### Step 1: Setup Git Repository in cPanel

1. Log into **cPanel**
2. Go to **Git™ Version Control**
3. Click **Create**
4. Fill in the details:
   - **Clone URL**: `https://github.com/yourusername/myyanga.git` (or your repo URL)
   - **Repository Path**: `myyanga_app`
   - **Repository Name**: `MyYanga Application`
5. Click **Create**

#### Step 2: Configure Deployment Path

1. After creating the repository, click **Manage**
2. Update the `.cpanel.yml` file variables:
   ```yaml
   - export DEPLOYPATH=/home/YOUR_USERNAME/public_html
   ```
   Replace `YOUR_USERNAME` with your actual cPanel username.

3. Update PHP version in `.cpanel.yml` if needed:
   - Change `ea-php74` to `ea-php80` or `ea-php81` based on your server

#### Step 3: Setup Environment File

1. In cPanel File Manager, navigate to the repository folder
2. Copy `.env.production` to `.env`:
   ```bash
   cp .env.production .env
   ```

3. Edit `.env` and update these critical values:
   ```env
   APP_URL=https://yourdomain.com

   DB_DATABASE=your_cpanel_database_name
   DB_USERNAME=your_cpanel_database_user
   DB_PASSWORD=your_database_password

   MAIL_HOST=smtp.yourdomain.com
   MAIL_USERNAME=info@myyanga.com
   MAIL_PASSWORD=your_email_password

   RECAPTCHA_SITE_KEY=your_site_key
   RECAPTCHA_SECRET_KEY=your_secret_key
   ```

#### Step 4: Deploy Using Git

1. In cPanel **Git™ Version Control**, click **Manage** on your repository
2. Click **Pull or Deploy** → **Deploy HEAD Commit**
3. The `.cpanel.yml` script will automatically:
   - Copy files to your public_html
   - Install Composer dependencies
   - Generate application key
   - Create storage symlink
   - Set permissions
   - Cache configurations

#### Step 5: Run Database Migrations

After deployment, SSH into your server and run:

```bash
cd /home/YOUR_USERNAME/public_html
/usr/local/bin/ea-php74 artisan migrate --force
```

Or use cPanel Terminal.

---

### Method 2: Manual Deployment Using deploy.sh Script

If you prefer manual control or cPanel Git isn't available.

#### Step 1: Upload Files

Upload your project files to the server:

```bash
# Via SSH
cd ~
git clone https://github.com/yourusername/myyanga.git myyanga_app
```

Or upload via cPanel File Manager.

#### Step 2: Configure Deployment Script

Edit `deploy.sh` and update these variables:

```bash
DEPLOY_PATH="/home/YOUR_USERNAME/public_html"
PHP_VERSION="74"  # or 80, 81, 82
```

#### Step 3: Make Script Executable

```bash
chmod +x deploy.sh
```

#### Step 4: Setup Environment

```bash
cp .env.production .env
nano .env  # Edit with your settings
```

#### Step 5: Run Deployment Script

```bash
./deploy.sh
```

The script will:
- Check requirements
- Create backup
- Install dependencies
- Setup environment
- Create symlinks
- Set permissions
- Optimize application
- Offer to run migrations
- Verify deployment

---

## 🔧 Post-Deployment Configuration

### 1. Configure Document Root

**Option A: Change Document Root (Recommended)**

1. In cPanel → **Domains**
2. Click your domain
3. Set **Document Root** to:
   ```
   /home/YOUR_USERNAME/public_html/public
   ```

**Option B: Create Symlink**

```bash
cd ~
mv public_html public_html.backup
ln -s ~/public_html/public ~/public_html
```

### 2. Setup SSL Certificate

1. In cPanel → **SSL/TLS Status**
2. Click **Run AutoSSL** for free Let's Encrypt certificate
3. Update `.env`:
   ```env
   APP_URL=https://yourdomain.com
   ```

### 3. Force HTTPS (Optional)

Edit `public/.htaccess` and add after `RewriteEngine On`:

```apache
# Force HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### 4. Setup Cron Jobs

For email notifications, add a cron job:

1. In cPanel → **Cron Jobs**
2. Add:
   ```
   0 8 * * * curl -s https://yourdomain.com/cronwork > /dev/null 2>&1
   ```

For Laravel scheduler (if you add scheduled tasks):
```
* * * * * cd /home/YOUR_USERNAME/public_html && /usr/local/bin/ea-php74 artisan schedule:run >> /dev/null 2>&1
```

### 5. Configure Queue Workers (Optional)

If using queue workers, add to cron:
```
* * * * * cd /home/YOUR_USERNAME/public_html && /usr/local/bin/ea-php74 artisan queue:work --stop-when-empty >> /dev/null 2>&1
```

---

## 🔄 Updating Your Application

### Using Git Deployment

1. Push your changes to GitHub/GitLab
2. In cPanel **Git™ Version Control** → **Manage**
3. Click **Pull or Deploy** → **Update from Remote**
4. Click **Deploy HEAD Commit**

The `.cpanel.yml` will automatically handle the deployment.

### Manual Update

```bash
cd /home/YOUR_USERNAME/public_html

# Pull latest changes
git pull origin master

# Install/update dependencies
/usr/local/bin/ea-php74 /usr/local/bin/composer install --optimize-autoloader --no-dev

# Run migrations if needed
/usr/local/bin/ea-php74 artisan migrate --force

# Clear and recache
/usr/local/bin/ea-php74 artisan config:clear
/usr/local/bin/ea-php74 artisan cache:clear
/usr/local/bin/ea-php74 artisan config:cache
/usr/local/bin/ea-php74 artisan route:cache
/usr/local/bin/ea-php74 artisan view:cache
```

---

## 🐛 Troubleshooting

### 500 Internal Server Error

```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Check permissions
chmod -R 775 storage bootstrap/cache

# Clear caches
php artisan config:clear
php artisan cache:clear
```

### Storage Images Not Loading

```bash
# Recreate storage symlink
php artisan storage:link

# Check if symlink exists
ls -la public/storage
```

### Composer Memory Limit Error

```bash
# Increase memory limit temporarily
/usr/local/bin/ea-php74 -d memory_limit=512M /usr/local/bin/composer install
```

### Database Connection Issues

1. Verify credentials in `.env`
2. Check database exists in cPanel → MySQL Databases
3. Ensure user has ALL PRIVILEGES on the database
4. Try `DB_HOST=127.0.0.1` instead of `localhost`

---

## 📊 Verification Checklist

After deployment, verify:

- [ ] Application loads at https://yourdomain.com
- [ ] No 500 errors
- [ ] Login/registration works
- [ ] Images display correctly
- [ ] Email sending works (test notifications)
- [ ] Database connections work
- [ ] SSL certificate is active (green padlock)
- [ ] Storage symlink works
- [ ] No debug information showing
- [ ] Cron jobs are running

---

## 🔐 Security Recommendations

1. **Disable Debug Mode**: Ensure `APP_DEBUG=false` in production
2. **Use Strong Keys**: Generate unique `APP_KEY`
3. **Protect .env**: Never commit `.env` to git
4. **Regular Backups**: Enable cPanel automated backups
5. **Update Dependencies**: Regularly run `composer update`
6. **Monitor Logs**: Check `storage/logs/` regularly
7. **Enable Rate Limiting**: Already configured in routes

---

## 📞 Support

If you encounter issues:

1. Check Laravel logs: `storage/logs/laravel.log`
2. Check Apache error logs in cPanel
3. Verify file permissions: `775` for storage and bootstrap/cache
4. Ensure PHP extensions are enabled in cPanel

---

## 📝 Notes

- The `.cpanel.yml` file is version-controlled and runs automatically on deployment
- Always backup before deploying updates
- Test locally before pushing to production
- Keep your `.env` file secure and never commit it to version control
- The deployment script creates automatic backups in `~/backups/`

---

## 🎯 Quick Commands Reference

```bash
# Clear all caches
php artisan cache:clear && php artisan config:clear && php artisan route:clear && php artisan view:clear

# Recache everything
php artisan config:cache && php artisan route:cache && php artisan view:cache

# Check application status
php artisan about

# Enable maintenance mode
php artisan down --message="Upgrading" --retry=60

# Disable maintenance mode
php artisan up

# View logs
tail -f storage/logs/laravel.log
```

---

**Last Updated**: 2025-01-14
**Laravel Version**: 7.30.4
**PHP Requirement**: 7.2.5 - 8.0
