# 🚀 cPanel Deployment Quick Start Guide

**5-Minute Setup for MyYanga on cPanel**

---

## Prerequisites Checklist

- [ ] cPanel account access
- [ ] MySQL database created in cPanel
- [ ] Database user created and granted ALL PRIVILEGES
- [ ] Domain/subdomain pointed to your cPanel account
- [ ] Git Version Control enabled in cPanel (optional but recommended)

---

## Option 1: Automatic Git Deployment (Fastest) ⚡

### Step 1: Setup Git Repository in cPanel (2 minutes)

1. **cPanel** → **Git™ Version Control** → **Create**
2. Enter:
   - Clone URL: `https://github.com/yourusername/myyanga.git`
   - Repository Path: `myyanga_app`
3. Click **Create**

### Step 2: Configure Environment (1 minute)

1. **cPanel** → **File Manager** → Navigate to `myyanga_app`
2. Copy `.env.production` to `.env`
3. Edit `.env` and update:
   ```env
   APP_URL=https://yourdomain.com
   DB_DATABASE=your_database
   DB_USERNAME=your_db_user
   DB_PASSWORD=your_db_password
   MAIL_HOST=smtp.yourdomain.com
   MAIL_USERNAME=info@myyanga.com
   MAIL_PASSWORD=your_email_pass
   ```

### Step 3: Update Deployment Config (30 seconds)

Edit `.cpanel.yml` line 7:
```yaml
- export DEPLOYPATH=/home/YOUR_USERNAME/public_html
```
Replace `YOUR_USERNAME` with your actual cPanel username.

### Step 4: Deploy (1 minute)

1. **Git™ Version Control** → **Manage** (on your repository)
2. **Pull or Deploy** → **Deploy HEAD Commit**
3. Wait for deployment to complete

### Step 5: Run Migrations (30 seconds)

**cPanel Terminal** or SSH:
```bash
cd ~/public_html
/usr/local/bin/ea-php74 artisan migrate --force
```

### Step 6: Configure Domain

**cPanel** → **Domains** → Set Document Root to:
```
/home/YOUR_USERNAME/public_html/public
```

**Done!** Visit `https://yourdomain.com`

---

## Option 2: Manual Deployment with Script (Alternative)

### Step 1: Upload Files

**Method A - SSH:**
```bash
cd ~
git clone https://github.com/yourusername/myyanga.git myyanga_app
```

**Method B - File Manager:**
1. Compress project locally
2. Upload via cPanel File Manager
3. Extract to `myyanga_app`

### Step 2: Configure Script

Edit `deploy.sh`:
```bash
DEPLOY_PATH="/home/YOUR_USERNAME/public_html"
PHP_VERSION="74"
```

### Step 3: Setup Environment

```bash
cd ~/myyanga_app
cp .env.production .env
nano .env  # Update database and mail settings
```

### Step 4: Run Deployment

```bash
chmod +x deploy.sh
./deploy.sh
```

Follow the prompts. The script will handle everything automatically.

---

## Essential Post-Deployment Tasks

### 1. Enable SSL (Let's Encrypt)

**cPanel** → **SSL/TLS Status** → **Run AutoSSL**

Update `.env`:
```env
APP_URL=https://yourdomain.com
```

### 2. Setup Cron Job for Notifications

**cPanel** → **Cron Jobs** → Add:

```
0 8 * * * curl -s https://yourdomain.com/cronwork > /dev/null 2>&1
```

### 3. Verify Deployment

Visit your domain and check:
- [ ] Homepage loads
- [ ] Login works
- [ ] Registration works
- [ ] Images display
- [ ] No errors in browser console

---

## Common Issues & Quick Fixes

### 500 Error
```bash
chmod -R 775 storage bootstrap/cache
php artisan config:clear
```

### Images Not Loading
```bash
php artisan storage:link
```

### Database Connection Error
- Verify credentials in `.env`
- Check database user has privileges
- Try `DB_HOST=127.0.0.1`

---

## Update Your Application

### Git Method:
1. Push changes to GitHub
2. **cPanel Git** → **Manage** → **Update from Remote**
3. **Deploy HEAD Commit**

### Manual Method:
```bash
cd ~/public_html
git pull
composer install --no-dev
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Important Security Notes

- ✅ `APP_DEBUG=false` in production
- ✅ Strong `APP_KEY` generated
- ✅ `.env` file protected (not web accessible)
- ✅ Regular backups enabled
- ✅ SSL certificate active

---

## Need Help?

1. Check logs: `storage/logs/laravel.log`
2. See full guide: `DEPLOYMENT.md`
3. Check Laravel docs: https://laravel.com/docs/7.x

---

## File Structure Reference

```
/home/YOUR_USERNAME/
├── myyanga_app/          # Git repository
│   ├── .cpanel.yml       # Auto-deployment config
│   ├── deploy.sh         # Deployment script
│   ├── .env.production   # Template
│   └── ...
│
└── public_html/          # Deployed application
    ├── public/           # Web root (set as Document Root)
    ├── app/
    ├── config/
    ├── storage/
    └── ...
```

---

## Production Checklist

Before going live:

- [ ] `APP_DEBUG=false`
- [ ] Strong database password
- [ ] SSL certificate installed
- [ ] Cron jobs configured
- [ ] Email sending tested
- [ ] Storage permissions correct (775)
- [ ] reCAPTCHA keys configured
- [ ] Backups enabled
- [ ] Performance tested
- [ ] Security headers configured

---

**Estimated Total Setup Time**: 5-10 minutes

**Questions?** Refer to the complete `DEPLOYMENT.md` guide.
