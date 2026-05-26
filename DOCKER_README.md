# 🐳 Docker Environment for MyYanga

This repository provides a containerized development environment specifically tuned for MyYanga's requirements (Laravel 7 on PHP 7.4).

## 🚀 Why Docker?

- **Environment Consistency**: Eliminates "it works on my machine" issues by locking PHP 7.4 and specific extensions.
- **One-Command Setup**: Boots up the web server, MySQL database, and PHPMyAdmin simultaneously.
- **Isolated Database**: Keeps the project database separate from your system's global MySQL installation.

## 🏗️ The Architecture

The setup consists of three core services orchestrated by `docker-compose.yml`:

1.  **`php74` (Web Server)**: 
    - Uses the root `Dockerfile` to build a PHP 7.4 + Apache environment.
    - Runs `entrypoint.sh` on startup to automate migrations and seeding.
    - Maps to [http://localhost:8080](http://localhost:8080).
2.  **`db` (MySQL)**: 
    - Uses MySQL 8.0.
    - Persists data in a Docker volume (`db_data`) so your data survives container restarts.
    - Supports automated SQL restoration via the `DB_BACKUP_FILE` environment variable.
3.  **`phpmyadmin` (Database GUI)**:
    - Provides a web interface to manage your database.
    - Maps to [http://localhost:8088](http://localhost:8088).

## 📂 Environments & Container Files

To keep development fast and production deployments secure, this repository maintains separate Docker environments:

### 💻 Local Development Setup (Root Directory)
Optimized for active development, real-time code changes, and interactive debugging.

*   **[`docker-compose.yml`](file:///Users/bigchris/Documents/Jobs/Comnavig/standard-myyanga/docker-compose.yml)**: Orchestrates development services. Mounts the project folder as a bind volume (`.:/var/www/html`) so any local code changes immediately reflect in the container.
*   **[`Dockerfile`](file:///Users/bigchris/Documents/Jobs/Comnavig/standard-myyanga/Dockerfile)**: Builds the PHP 7.4 + Apache base image, installs composer, enables rewrite modules, and turns on developer error reporting.
*   **[`entrypoint.sh`](file:///Users/bigchris/Documents/Jobs/Comnavig/standard-myyanga/entrypoint.sh)**: The startup script. Installs dev dependencies if missing, updates local permissions, runs migrations, and **conditionally seeds the database** if no database backup is specified.

---

### 🚀 Production/Deployment Setup (`docker/prod/`)
Optimized for production PaaS environments (like Railway) for fully static, compiled, and optimized builds.

*   **[`docker/prod/docker-compose.yml`](file:///Users/bigchris/Documents/Jobs/Comnavig/standard-myyanga/docker/prod/docker-compose.yml)**: Local production configuration to test and simulate the production container behavior locally.
*   **[`docker/prod/Dockerfile`](file:///Users/bigchris/Documents/Jobs/Comnavig/standard-myyanga/docker/prod/Dockerfile)**: Builds the production image. Instead of dynamic volume binds, it **copies the entire codebase into the image** (`COPY . /var/www/html/`) making it entirely self-contained. It embeds the production entrypoint and locks standard production variables.
*   **[`docker/prod/entrypoint.sh`](file:///Users/bigchris/Documents/Jobs/Comnavig/standard-myyanga/docker/prod/entrypoint.sh)**: The production bootstrap script. Installs only production dependencies, clears dev caches, runs migrations, optimizes caches (`php artisan optimize`), and **never seeds the database**.
*   **[`docker/prod/.env.production`](file:///Users/bigchris/Documents/Jobs/Comnavig/standard-myyanga/docker/prod/.env.production)**: Sample configuration template for production deployments.



## 🛠️ Getting Started

### 1. Configure Environment

Docker Compose automatically reads the file named `.env` for **variable substitution** (like `${DB_BACKUP_FILE}`). However, the `php74` service is configured to load its **runtime variables** from `.env.local`.

1.  **Create a `.env` file** (if it doesn't exist) to handle Docker-specific variables:
    ```bash
    cp .env.local .env
    ```
2.  **Ensure your `.env.local`** (and `.env`) has these database settings:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=myyanga
    DB_USERNAME=root
    DB_PASSWORD=root
    ```
3.  **Optional**: If you want to restore a database backup on the first run, add this to your `.env`:
    ```env
    DB_BACKUP_FILE=./myyanga_backup.sql
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
| **Web App** | `8080` | `80` | Laravel Application |
| **MySQL** | `3306` | `3306` | Database Server |
| **PHPMyAdmin** | `8088` | `80` | DB Management Tool |

## 💡 Common Commands

- **View Logs**: `docker-compose logs -f php74`
- **Run Artisan**: `docker-compose exec php74 php artisan ...`
- **Restart All**: `docker-compose restart`
- **Rebuild Image**: `docker-compose up -d --build`
