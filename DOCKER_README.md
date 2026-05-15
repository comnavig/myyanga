# 🐳 Docker Environment for MyYanga

This repository provides a containerized development environment specifically tuned for MyYanga's requirements (Laravel 7 on PHP 7.4).

## 🚀 Why Docker?

- **Environment Consistency**: Eliminates "it works on my machine" issues by locking PHP 7.4 and specific extensions.
- **One-Command Setup**: Boots up the web server, MySQL database, and PHPMyAdmin simultaneously.
- **Isolated Database**: Keeps the project database separate from your system's global MySQL installation.

## 🏗️ The Architecture

The setup consists of three core services orchestrated by `docker-compose.yml`:

1.  **`php74` (Web Server)**: 
    - Uses `Dockerfile-74` to build a PHP 7.4 + Apache environment.
    - Runs `entrypoint.sh` on startup to automate migrations and seeding.
    - Maps to [http://localhost:8074](http://localhost:8074).
2.  **`db` (MySQL)**: 
    - Uses MySQL 8.0.
    - Persists data in a Docker volume (`db_data`) so your data survives container restarts.
    - Supports automated SQL restoration via the `DB_BACKUP_FILE` environment variable.
3.  **`phpmyadmin` (Database GUI)**:
    - Provides a web interface to manage your database.
    - Maps to [http://localhost:8081](http://localhost:8081).

## 🛠️ Getting Started

### 1. Configure Environment
Docker uses `.env.local` for container-specific settings. Ensure your `.env.local` has:
```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=myyanga
DB_USERNAME=root
DB_PASSWORD=root
```

### 2. Launch Containers
```bash
docker-compose up -d
```

### 3. Automated Setup
On startup, the `php74` container runs `entrypoint.sh` which:
1.  Waits for the database to be ready.
2.  Runs `composer install` (if vendors are missing).
3.  Runs `php artisan migrate`.
4.  **Conditional Seeding**: If `DB_BACKUP_FILE` is defined in your `.env` and the file exists, it skips seeding (assuming you are restoring a backup). If the file is missing, it runs `php artisan db:seed`.

## 📦 Service Ports Summary

| Service | Host Port | Internal Port | Description |
| :--- | :--- | :--- | :--- |
| **Web App** | `8074` | `80` | Laravel Application |
| **MySQL** | `3306` | `3306` | Database Server |
| **PHPMyAdmin** | `8081` | `80` | DB Management Tool |

## 💡 Common Commands

- **View Logs**: `docker-compose logs -f php74`
- **Run Artisan**: `docker-compose exec php74 php artisan ...`
- **Restart All**: `docker-compose restart`
- **Rebuild Image**: `docker-compose up -d --build`
