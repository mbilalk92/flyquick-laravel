# Fly Quick — Hostinger Deployment Guide

**Hosting:** Hostinger Business Plan  
**Stack:** Laravel 10 · PHP 8.1+ · MySQL · Filament v3

---

## Prerequisites

Before you start, have the following ready:

- [ ] Hostinger hPanel login credentials
- [ ] Your domain pointed to Hostinger nameservers (or subdomain created)
- [ ] FTP client — [FileZilla](https://filezilla-project.org/) (free)
- [ ] SSH client — Terminal (Mac/Linux) or PuTTY / Windows Terminal (Windows)
- [ ] Google reCAPTCHA v3 site key + secret key
- [ ] SMTP mail credentials (Gmail App Password, or Hostinger email)

---

## Step 1 — Prepare Your Local Project

### 1.1 Install production dependencies only

```bash
composer install --no-dev --optimize-autoloader
```

### 1.2 Build frontend assets (if applicable)

```bash
npm run build
```

### 1.3 Optimise for production

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:cache-components
```

### 1.4 Create a deployment archive

Zip your entire project folder **excluding** the following:

```
.git/
node_modules/
storage/app/public/    ← keep the folder, skip uploaded files if large
storage/logs/
.env
```

Alternatively use Git (see Step 3B).

---

## Step 2 — Set Up Hostinger

### 2.1 Create a MySQL database

1. Log in to **hPanel** → **Databases → MySQL Databases**
2. Click **Create a new MySQL database**
3. Fill in:
   - **Database name:** `flyquick` (Hostinger prepends your username, e.g. `u123456_flyquick`)
   - **Username:** `flyquick_user`
   - **Password:** generate a strong one and save it
4. Note down:
   - Full database name: `u123456_flyquick`
   - Full username: `u123456_flyquick_user`
   - Password
   - Host: `127.0.0.1`

### 2.2 Set PHP version

1. hPanel → **Advanced → PHP Configuration**
2. Set version to **8.1** or **8.2**
3. Enable these extensions if not already on:
   - `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, `gd`, `curl`, `zip`

### 2.3 Set the document root

By default Hostinger serves from `public_html/`. Laravel's entry point is `public/`. You have two options:

**Option A — Subdomain with custom root (cleanest)**
1. hPanel → **Domains → Subdomains** → create `app.yourdomain.com`
2. Set its document root to `public_html/flyquick/public`

**Option B — Main domain**
1. Upload your project to `public_html/flyquick/` (not inside `public_html/` directly)
2. hPanel → **Advanced → Website → Document Root** → set to `public_html/flyquick/public`
3. If the option isn't available, see Step 2.4

### 2.4 Fallback: `.htaccess` redirect (if you can't change the document root)

Place this `.htaccess` in `public_html/`:

```apache
RewriteEngine On
RewriteRule ^(.*)$ /flyquick/public/$1 [L]
```

---

## Step 3 — Upload Your Files

### Option A — FTP Upload (simpler)

1. In hPanel → **Files → FTP Accounts**, create an FTP account or use the main one
2. Open FileZilla, connect with your FTP credentials:
   - Host: `ftp.yourdomain.com`
   - Port: `21`
3. Upload your project folder to `/public_html/flyquick/`
4. **Do not upload** `.env` — you will create it on the server

### Option B — Git Deployment (recommended for updates)

1. Push your project to a private GitHub repository
2. SSH into your Hostinger server (see Step 4 for SSH setup)
3. Navigate to the web root:
   ```bash
   cd ~/public_html
   ```
4. Clone your repo:
   ```bash
   git clone https://github.com/yourusername/flyquick-laravel.git flyquick
   ```
5. For future deployments, just run inside the folder:
   ```bash
   git pull origin main
   ```

---

## Step 4 — SSH Access

1. hPanel → **Advanced → SSH Access** → enable SSH
2. Note your SSH hostname, port (usually `22`), and username
3. Connect:
   ```bash
   ssh u123456@yourdomain.com -p 65002
   ```
   *(Hostinger sometimes uses a non-standard port — check hPanel)*

All subsequent commands in this guide run over SSH.

---

## Step 5 — Configure the `.env` File

SSH into your server and create the `.env` file:

```bash
cd ~/public_html/flyquick
cp .env.example .env
nano .env
```

Fill in every value below — replace placeholders with your real values:

```ini
APP_NAME="Fly Quick"
APP_ENV=production
APP_KEY=                          # leave blank — generated in Step 6
APP_DEBUG=false
APP_URL=https://yourdomain.com

LOG_CHANNEL=stack
LOG_LEVEL=error

# ── Database ──────────────────────────────────────────
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u123456_flyquick
DB_USERNAME=u123456_flyquick_user
DB_PASSWORD=your_db_password

# ── Cache / Session / Queue ───────────────────────────
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=database         # or 'sync' if you don't set up a queue worker

# ── Mail ──────────────────────────────────────────────
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com          # or smtp.hostinger.com for Hostinger email
MAIL_PORT=587
MAIL_USERNAME=you@gmail.com
MAIL_PASSWORD=your_app_password   # Gmail App Password (not your Gmail login)
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=you@gmail.com
MAIL_FROM_NAME="Fly Quick"

# ── Google reCAPTCHA v3 ───────────────────────────────
RECAPTCHA_SITE_KEY=your_site_key
RECAPTCHA_SECRET_KEY=your_secret_key
RECAPTCHA_SKIP_IP=

# ── Filesystem ────────────────────────────────────────
FILESYSTEM_DISK=public

# ── Site-wide contact details (config/site.php) ───────
# Shown across the hero, trust row, footer and contact section —
# these have hard-coded fallbacks in config/site.php but should
# always be overridden here for a real deployment.
SITE_URL=https://yourdomain.com
SITE_PHONE="+61 3 9017 1800"
SITE_PHONE_HREF=tel:+61390171800
SITE_EMAIL=support@yourdomain.com
SITE_WHATSAPP="https://wa.me/61390171800"
SITE_HOURS="Mon–Sat 9am–11pm · Sun 11am–7pm, Melbourne time"
BLOG_URL=https://yourdomain.com/blog
```

> **Note:** these `SITE_*` values are separate from the **Site Settings** page in the admin panel (`/admin` → Configuration → Site Settings) — that page only controls `site_name`, `site_logo`, social links, etc. (stored in the `settings` table). The `SITE_*` env vars above are what the public page templates actually read for phone/email/WhatsApp/hours, so update `.env` (and re-run `php artisan config:cache`) if those details change.

Save and exit: `Ctrl+O` → `Enter` → `Ctrl+X`

---

## Step 6 — Run Server-Side Setup Commands

SSH into the project folder and run these **in order**:

```bash
cd ~/public_html/flyquick
```

### 6.1 Generate application key

```bash
php artisan key:generate
```

### 6.2 Run database migrations and seed

```bash
# Run migrations
php artisan migrate --force

# Seed all pages and initial data
php artisan db:seed --class=PagesSeeder --force
php artisan db:seed --class=RolesAndAdminSeeder --force
```

> **Important:** `--force` is required in production to bypass the confirmation prompt.

### 6.3 Create storage symlink

```bash
php artisan storage:link
```

This creates `public/storage` → `storage/app/public` so uploaded media is publicly accessible.

> **Hostinger note:** shared hosting plans disable PHP's `symlink()` function (along with `shell_exec`, `exec`, `proc_open`, etc.) for security, and this is **not** something support will re-enable on a shared plan — only on VPS/Cloud. If `storage:link` fails with `Call to undefined function Illuminate\Filesystem\symlink()`, skip it and instead copy the files manually via File Manager or SFTP:
>
> ```bash
> mkdir -p public/storage
> cp -r storage/app/public/* public/storage/
> ```
>
> Repeat this copy step after every deploy that adds new files under `storage/app/public` (e.g. new media uploads bundled with a release), since there's no live symlink keeping them in sync.

### 6.4 Set correct file permissions

```bash
chmod -R 755 storage bootstrap/cache
chmod -R 644 storage/logs
```

> **Hostinger note:** if `chmod` fails with `Permission denied` on an existing file (e.g. `storage/logs/laravel.log`), it's usually because that file was created earlier by the PHP-FPM process user, which can differ from your SSH user even under the same account. You can't `chown`/`chmod` a file you don't own without root. Delete the file via hPanel File Manager (which runs with full account privileges) and let Laravel recreate it on the next request, rather than trying to chmod it over SSH.

### 6.5 Create the admin user

```bash
php artisan tinker
```

> **Hostinger note:** tinker may print `Error: Call to undefined function shell_exec()` on startup — this is Psy Shell trying to use a disabled convenience function (paging/readline) and is harmless; tinker still works normally for running the code below.

Inside tinker:

```php
$user = \App\Models\User::create([
    'name'     => 'Admin',
    'email'    => 'admin@yourdomain.com',
    'password' => bcrypt('YourStrongPassword123!'),
]);
$user->assignRole('admin');
exit
```

### 6.6 Cache everything for production

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:cache-components
```

---

## Step 7 — SSL Certificate

1. hPanel → **Security → SSL**
2. Click **Install SSL** next to your domain
3. Choose **Hostinger Free SSL** (Let's Encrypt — auto-renews)
4. Wait 1–5 minutes for it to activate

Once SSL is active, force HTTPS in your `.env`:

```ini
APP_URL=https://yourdomain.com
```

And add this to `app/Http/Middleware/TrustProxies.php` → `$proxies`:

```php
protected $proxies = '*';
```

This ensures `https://` URLs are generated correctly behind Hostinger's proxy.

---

## Step 8 — Queue Worker (for email 2FA codes)

If you set `QUEUE_CONNECTION=database`, the 2FA email codes are dispatched via the queue. Set up a cron-based worker:

1. hPanel → **Advanced → Cron Jobs**
2. Add a new cron job:
   - **Command:** `php ~/public_html/flyquick/artisan queue:work --sleep=3 --tries=3 --max-time=3600`
   - **Frequency:** Every minute (`* * * * *`)

> **Alternative:** Set `QUEUE_CONNECTION=sync` in `.env` if you want emails sent inline (simpler but slightly slower on form submit).

---

## Step 9 — Cron Job for Laravel Scheduler

Add a second cron job for Laravel's task scheduler (used for cache cleanup, etc.):

- **Command:** `php ~/public_html/flyquick/artisan schedule:run`
- **Frequency:** Every minute (`* * * * *`)

---

## Step 10 — Verify the Deployment

Work through this checklist in your browser:

| Check | URL |
|-------|-----|
| Homepage loads | `https://yourdomain.com` |
| A content page loads | `https://yourdomain.com/flights` |
| Admin login page shows Fly Quick branding | `https://yourdomain.com/admin` |
| Admin login works | Login with the user created in Step 6.5 |
| Media Library visible in admin | Admin sidebar → Media |
| Contact form submits | Fill and submit the contact form |
| Enquiry appears in admin | Admin → Enquiries → Contact Enquiries |
| Uploaded image via section editor | Edit a page section, pick/upload an image |
| Section content fields editable | Admin → Content → Pages → edit a page → Sections tab → open a section (e.g. Hero, Services, Reviews) and confirm text/image fields show and save |
| reCAPTCHA active (check Network tab) | A call to `google.com/recaptcha` should appear |

---

## Updating the Site (After First Deploy)

For future code changes:

```bash
ssh u123456@yourdomain.com -p 65002
cd ~/public_html/flyquick

git pull origin main
composer install --no-dev --optimize-autoloader

php artisan migrate --force
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:cache-components
```

> **Note:** `php artisan view:clear` before re-caching matters whenever a deploy changes Blade templates (e.g. `resources/views/sections/*.blade.php`) or Filament admin forms — stale compiled views can otherwise linger even after `view:cache` runs again. `migrate --force` is a no-op if a deploy only touches templates/admin forms and adds no new migration file — not every update ships a schema change.

---

## Common Issues

### White screen / 500 error
```bash
# Check the Laravel log
tail -50 storage/logs/laravel.log

# Ensure APP_DEBUG=false in .env (never true in production)
# Check file permissions: storage/ and bootstrap/cache/ must be writable
```

### "No application encryption key" error
```bash
php artisan key:generate
php artisan config:cache
```

### Uploaded images not showing
```bash
# Re-run storage link
php artisan storage:link

# Check FILESYSTEM_DISK=public in .env
```

### Admin shows "Filament" branding instead of Fly Quick
```bash
php artisan filament:cache-components
php artisan view:clear
```

### reCAPTCHA not working
- Ensure your production domain is added in the [reCAPTCHA admin console](https://www.google.com/recaptcha/admin)
- `localhost` and `127.0.0.1` are separate entries from your live domain
- Check `RECAPTCHA_SITE_KEY` and `RECAPTCHA_SECRET_KEY` are set in `.env`

### Email not sending (2FA codes, notifications)
- Test with `php artisan tinker` → `Mail::raw('test', fn($m) => $m->to('you@email.com')->subject('test'))`
- Verify SMTP credentials — Gmail requires an **App Password** (not your account password)
- Check `storage/logs/laravel.log` for mail errors

---

## Security Checklist Before Going Live

- [ ] `APP_DEBUG=false` in `.env`
- [ ] `APP_ENV=production` in `.env`
- [ ] Strong admin password set
- [ ] `.env` not publicly accessible (Laravel's `public/` folder is the web root — `.env` is outside it and safe)
- [ ] SSL active and `APP_URL` uses `https://`
- [ ] reCAPTCHA keys added
- [ ] Run `php artisan storage:link` confirmed
- [ ] Remove any test/seeded data if not needed in production

---

*Guide prepared for Fly Quick · Hostinger Business Plan · Laravel 10*
