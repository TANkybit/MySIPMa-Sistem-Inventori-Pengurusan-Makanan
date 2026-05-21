# JimaHosting cPanel Upload Guide - My SIPMA

## Your Project Structure for cPanel

Your Laravel app uses a **wrapper setup** where the public_html folder is separate from the main Laravel code. This is ideal for cPanel:

```
public_html/
├── index.php           ← Entry point (wrapper that loads Laravel)
├── .htaccess           ← URL rewriting rules
├── css/
├── js/
└── frontend/

../mysipma_app/        ← Your complete Laravel app (parent directory)
├── app/
├── config/
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env                ← Created on server
├── bootstrap/
├── database/
├── composer.json
└── (all other Laravel files)
```

## Step-by-Step Deployment

### Step 1: Connect to Your Server

**Option A: Using FTP/SFTP (File Manager)**
- Use FileZilla, WinSCP, or cPanel File Manager
- Connect to your hosting account

**Option B: Using SSH (Recommended)**
- Open terminal/PowerShell on your computer
- SSH into: `ssh username@mysipma.com`

### Step 2: Create Directory Structure

If using **SSH**, run:
```bash
cd ~
mkdir -p mysipma_app
```

If using **File Manager**, create a new folder `mysipma_app` in the home directory (parent of public_html).

### Step 3: Upload the Laravel App Files

**Via FTP/File Manager:**
1. Go to your home directory (above public_html)
2. Open the `mysipma_app/` folder
3. Upload ALL files from your local project EXCEPT:
   - `node_modules/` folder
   - `.git/` folder
   - `tests/` folder (optional)
   - `.DS_Store`, `Thumbs.db`
   - IDE folders (`.vscode/`, `.idea/`)

Your upload should include:
- `app/`, `config/`, `resources/`, `routes/`, `database/`
- `bootstrap/`, `storage/`, `vendor/`
- `composer.json`, `composer.lock`
- All config files and hidden files except `.git`

**Via SSH:**
```bash
# Navigate to home
cd ~

# Upload via rsync (if available locally)
rsync -avz --exclude=node_modules --exclude=.git C:\laragon\www\MySIPMA_2\ username@mysipma.com:~/mysipma_app/
```

### Step 4: Upload to public_html

1. Upload the `public_html/index.php` (the wrapper file)
2. Upload `public_html/.htaccess`
3. Optionally upload frontend assets (CSS, JS, images)

### Step 5: Create Database

1. Go to cPanel → **MySQL Databases**
2. Create a new database (e.g., `mysipma_db`)
3. Create a MySQL user and assign to database with ALL PRIVILEGES
4. Note your:
   - Database name: `mysipma_db`
   - Username: `user_dbuser`
   - Password: `strong_password`

### Step 6: Create .env File on Server

**Via SSH:**
```bash
cd ~/mysipma_app
cp .env.production .env
nano .env
```

Edit `.env` and add your database credentials:
```
APP_KEY=
DB_HOST=localhost
DB_DATABASE=mysipma_db
DB_USERNAME=user_dbuser
DB_PASSWORD=your_strong_password
```

**Via File Manager:**
1. Navigate to `mysipma_app/` folder
2. Create a new file `.env`
3. Copy contents from `.env.production` and fill in database details

### Step 7: Install PHP Dependencies

**If SSH is available:**
```bash
cd ~/mysipma_app
composer install --optimize-autoloader --no-dev
```

**If SSH not available:**
1. Contact JimaHosting support to run `composer install`
2. Or upload the `vendor/` folder from your computer (large ~150MB)

### Step 8: Set Permissions

**Via SSH:**
```bash
cd ~/mysipma_app
chmod -R 755 .
chmod -R 777 storage/ bootstrap/cache/
```

**Via File Manager:**
- Right-click on `storage/` → Change Permissions → Set to 777
- Right-click on `bootstrap/cache/` → Change Permissions → Set to 777

### Step 9: Generate Application Key

**Via SSH:**
```bash
cd ~/mysipma_app
php artisan key:generate
```

**If no SSH:**
1. Ask JimaHosting support to run the command
2. Or generate one manually and add to `.env`:
   `APP_KEY=base64:randomly_generated_string_here`

### Step 10: Run Database Migrations

**Via SSH:**
```bash
cd ~/mysipma_app
php artisan migrate --force
```

**If no SSH:**
- Contact JimaHosting support

### Step 11: Verify Installation

1. Open your browser and visit `https://mysipma.com`
2. You should see your homepage (index.blade.php)
3. Check the browser console for any errors
4. Test your contact form and database functionality

## Troubleshooting

### Blank White Page / 500 Error
- Temporarily enable debug: Edit `.env` → `APP_DEBUG=true`
- Check error logs: `~/mysipma_app/storage/logs/laravel.log`
- Verify PHP version supports Laravel 10: `php -v` (needs 8.1+)

### "Connection refused" / Database Error
- Verify database credentials in `.env`
- Try `DB_HOST=127.0.0.1` instead of `localhost`
- Confirm database and user exist in cPanel

### 404 Errors on All Routes
- Ensure `.htaccess` is in `public_html/`
- Check that `index.php` wrapper is correct
- Verify mod_rewrite is enabled (contact JimaHosting)

### "Permission denied" Errors
- `storage/` and `bootstrap/cache/` must be 777 (writable)
- Run chmod commands from SSH

### Cannot Connect to Laravel App
- Verify `../mysipma_app/` path is correct relative to `public_html/`
- Check that all Laravel core files are uploaded
- Verify `vendor/autoload.php` exists

## Security Checklist

- [ ] Set `APP_DEBUG=false` in `.env` (production only)
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Generate a strong `APP_KEY`
- [ ] Use HTTPS: `APP_URL=https://mysipma.com`
- [ ] Set strong database password
- [ ] Keep `.env` file secure (don't commit to git)
- [ ] Regularly backup database and files

## Post-Deployment

1. Monitor logs: Check `~/mysipma_app/storage/logs/`
2. Test all features thoroughly
3. Set up regular backups
4. Keep Laravel and packages updated
5. Monitor for security updates

---

**For Support:** Contact JimaHosting at [support@jimahosting.com] or check their documentation.
