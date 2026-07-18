# Deployment Checklist

This document describes the recommended deployment process for the Laravel rental management project.

## 1. Pre-deployment setup

1. Ensure the target environment has:
   - PHP 8.4+ with required extensions
   - Composer
   - A database server (MySQL, PostgreSQL, or SQLite as configured)
   - A queue backend if using queued jobs (`database`, `redis`, etc.)
   - A web server or PHP application server (Nginx/Apache)

2. Copy the environment file:

```bash
cp .env.example .env
```

3. Configure `.env` values:

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://your-domain.com`
- `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `QUEUE_CONNECTION=database` or `redis` if using queued notifications/jobs
- `SESSION_DRIVER=database` or `redis`
- `CACHE_STORE=database` or `redis`
- `MAIL_MAILER=smtp` (or a production mailer)
- `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME`
- `PAYMENT_WEBHOOK_SECRET=<random-secret>`

4. Generate the application key:

```bash
php artisan key:generate
```

5. If using database sessions or queue table:

```bash
php artisan session:table
php artisan queue:table
php artisan migrate
```

## 2. Staging deployment

1. Pull the latest code from the feature branch.
2. Install PHP dependencies:

```bash
composer install --optimize-autoloader --no-dev
```

3. Install frontend assets if applicable:

```bash
npm install
npm run build
```

4. Run database migrations:

```bash
php artisan migrate --force
```

5. Clear and cache configuration:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

6. Restart or start the queue worker if using queued jobs:

```bash
php artisan queue:restart
php artisan queue:work --sleep=3 --tries=3
```

7. Run the application smoke tests:

```bash
php artisan test --stop-on-failure
```

8. Verify webhook endpoint and secret value.

## 3. Production deployment

Follow the same steps as staging, with an additional focus on backups and maintenance mode.

1. Put the app into maintenance mode:

```bash
php artisan down --render="errors::503"
```

2. Create a database backup before running migrations.
3. Pull the latest code.
4. Install dependencies:

```bash
composer install --optimize-autoloader --no-dev
```

5. Build assets if needed:

```bash
npm ci
npm run build
```

6. Run migrations:

```bash
php artisan migrate --force
```

7. Clear and cache framework caches:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

8. Restart queue workers and scheduler if used:

```bash
php artisan queue:restart
php artisan queue:work --sleep=3 --tries=3
```

9. Bring the app back up:

```bash
php artisan up
```

10. Confirm the application is running and the key pages work.

## 4. Webhook verification

The app expects payment webhooks signed with `PAYMENT_WEBHOOK_SECRET`.

- Set a strong random value in `.env`.
- The webhook endpoint is:

```text
POST /webhook/pembayaran
```

- The request must include an `X-Signature` header containing the HMAC-SHA256 hash of the JSON body using the secret.

## 5. Rollback guidance

1. If deployment fails, revert to the previous Git revision.
2. Use a database backup to restore data if the migration changed production data.
3. If only a migration is bad and you have a safe rollback path:

```bash
php artisan migrate:rollback --step=1
```

4. Restart the queue worker after rollback.

## 6. Optional production hardening

- Use HTTPS with a valid TLS certificate.
- Set `APP_DEBUG=false`.
- Ensure `storage`, `bootstrap/cache`, and `vendor` are writable by the web server user.
- Set strong permissions on `.env`.
- Enable `QUEUE_CONNECTION=database` or `redis` and run a queue worker if your app uses queued notifications.

## 7. Deployment automation

### Deploy script
A helper script is included in `deploy.sh` to perform a basic deployment:

```bash
./deploy.sh
```

It will:

- pull latest code
- install composer dependencies
- install npm dependencies and build assets
- run migrations
- cache config/routes/views
- restart queue workers if `QUEUE_CONNECTION` is not `sync`

### Supervisor example
A Supervisor configuration example is available in `SUPERVISOR.md`.

### PowerShell deployment
A PowerShell deployment script is available in `deploy.ps1`.

Run this from the project root in PowerShell:

```powershell
.\\deploy.ps1
```

To skip npm build:

```powershell
.\\deploy.ps1 -SkipNpm
```

## 8. Local development notes

For local development, you may use:

```bash
php artisan migrate
php artisan serve
php artisan queue:work --sleep=3 --tries=3
```

If you don't need background queue processing, `QUEUE_CONNECTION=sync` can keep everything synchronous.
