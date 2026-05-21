# cPanel Deployment Checklist - My SIPMA

## Pre-Upload Checklist

### Local Testing
- [ ] Run `php artisan serve` and verify site works locally
- [ ] Test homepage (index.blade.php) displays correctly
- [ ] Test all forms and functionality
- [ ] Check console for JavaScript errors
- [ ] Verify database connectivity (if using local DB)

### Files to Exclude from Upload
Do NOT upload these:
- [ ] `node_modules/` - Too large, you'll run composer on server
- [ ] `.git/` - Version control, not needed on server
- [ ] `.gitignore` - Not needed on server
- [ ] `.env` or `.env.local` - You'll create new one on server
- [ ] `tests/` - Optional, not needed in production
- [ ] IDE folders: `.vscode/`, `.idea/`, `*.sublime-project`
- [ ] OS files: `.DS_Store`, `Thumbs.db`
- [ ] `Laravel.log` and other temp logs

### Files to Ensure Are Included
- [ ] `public/index.php` - Entry point wrapper
- [ ] `public/.htaccess` - URL rewriting
- [ ] `composer.json` and `composer.lock` - For dependencies
- [ ] All Laravel framework files (app/, config/, resources/, routes/, etc.)
- [ ] `.env.production` - Template for server configuration
- [ ] `artisan` - CLI tool

### Project Configuration
- [ ] `APP_NAME` set appropriately in config
- [ ] Routes defined correctly in `routes/web.php`
- [ ] All controllers referenced in routes exist
- [ ] Blade templates in `resources/views/` exist (including index.blade.php)

## Upload Phase

### Create Remote Structure
- [ ] Log into cPanel
- [ ] Create `mysipma_app/` folder (parent of public_html)
- [ ] Ensure `public_html/` already exists (default)

### Upload Files
- [ ] Upload Laravel app to `~/mysipma_app/`
- [ ] Upload `public/index.php` to `~/public_html/`
- [ ] Upload `public/.htaccess` to `~/public_html/`
- [ ] Verify upload completed without errors

### Verify File Structure
```
Expected on server:
~/public_html/
├── index.php
├── .htaccess
└── (frontend assets if any)

~/mysipma_app/
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
├── vendor/
├── composer.json
├── composer.lock
├── artisan
└── (other Laravel files)
```

## Post-Upload Configuration

### Database Setup
- [ ] Log into cPanel
- [ ] Go to MySQL Databases
- [ ] Create new database (e.g., `mysipma_db`)
- [ ] Create MySQL user (e.g., `mysipma_user`)
- [ ] Assign user to database with ALL PRIVILEGES
- [ ] Note credentials for `.env` file

### Create .env File
- [ ] Via SSH or File Manager, create `~/mysipma_app/.env`
- [ ] Copy content from `.env.production` template
- [ ] Fill in these values:
  ```
  APP_KEY=           (will generate)
  DB_HOST=localhost
  DB_DATABASE=mysipma_db
  DB_USERNAME=mysipma_user
  DB_PASSWORD=your_password
  MAIL_FROM_ADDRESS=your_email@mysipma.com
  ```

### Install Dependencies
- [ ] Via SSH, run: `cd ~/mysipma_app && composer install --optimize-autoloader --no-dev`
- [ ] Wait for completion (may take 2-5 minutes)
- [ ] Verify `vendor/` folder is populated

### Set Permissions
- [ ] Via SSH, run:
  ```bash
  cd ~/mysipma_app
  chmod -R 755 .
  chmod -R 777 storage/ bootstrap/cache/
  ```
- [ ] Verify via File Manager if SSH not available

### Generate Application Key
- [ ] Via SSH, run: `php artisan key:generate`
- [ ] Verify `.env` file has `APP_KEY=base64:xxxxx`
- [ ] If no SSH, contact support or manually add one

### Run Database Migrations
- [ ] Via SSH, run: `php artisan migrate --force`
- [ ] Check for errors in output
- [ ] Verify database tables created in cPanel MySQL section

## Testing Phase

### Basic Functionality
- [ ] Open `https://mysipma.com` in browser
- [ ] Verify homepage loads (index.blade.php)
- [ ] Check page title and content
- [ ] Verify no white/blank pages

### Asset Loading
- [ ] Check CSS is loading (styled correctly)
- [ ] Check JavaScript is loading (no console errors)
- [ ] Verify all images display correctly
- [ ] Check icon fonts load properly

### Form Testing (if applicable)
- [ ] Test contact form submission
- [ ] Verify form validation works
- [ ] Check database receives submission data
- [ ] Verify success message displays

### Database Connectivity
- [ ] Verify forms can save/retrieve data
- [ ] Check database queries work
- [ ] Monitor for any database errors

### Error Handling
- [ ] Visit non-existent page - should get 404
- [ ] Verify error messages are meaningful
- [ ] Check logs in `~/mysipma_app/storage/logs/laravel.log`

## Security hardening

### Before Going Live
- [ ] Set `APP_DEBUG=false` in `.env` (hide sensitive info from errors)
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Verify `.env` file permissions (should not be publicly readable)
- [ ] Ensure HTTPS is enabled (use cPanel's AutoSSL)
- [ ] Update `APP_URL=https://mysipma.com` (with https)
- [ ] Change default Laravel secrets if any

### Access Control
- [ ] Set appropriate file permissions (755 for most, 777 only for storage/cache)
- [ ] Verify sensitive files not accessible via web
- [ ] Check `.htaccess` is blocking access to non-public files

## Final Checks

### Performance
- [ ] Test page load speed
- [ ] Check if pages load assets efficiently
- [ ] Monitor server resource usage in cPanel

### Backups
- [ ] Create database backup in cPanel
- [ ] Create file backup via cPanel File Manager
- [ ] Document backup location and access

### Monitoring
- [ ] Enable error logging if available
- [ ] Set up email notifications for errors
- [ ] Plan regular backup schedule

### Documentation
- [ ] Document database credentials (secure location)
- [ ] Document FTP/SSH connection details
- [ ] Note any custom configurations made
- [ ] Record deployment date and deployed by

## Troubleshooting Guide

### If Homepage Shows Blank Page
1. [ ] Enable `APP_DEBUG=true` temporarily
2. [ ] Check error logs: `~/mysipma_app/storage/logs/laravel.log`
3. [ ] Verify PHP version: `php -v` (minimum 8.1)
4. [ ] Check file permissions on `storage/` and `bootstrap/cache/`

### If Getting 404 Errors
1. [ ] Verify `.htaccess` in `public_html/` has correct content
2. [ ] Check mod_rewrite is enabled (ask JimaHosting)
3. [ ] Ensure `index.php` wrapper is correct
4. [ ] Verify route definitions in `routes/web.php`

### If Database Connection Fails
1. [ ] Verify credentials in `.env`
2. [ ] Try `DB_HOST=127.0.0.1` instead of `localhost`
3. [ ] Confirm database exists in cPanel
4. [ ] Confirm user has privileges for database

### If Getting Permission Errors
1. [ ] `storage/` must be `chmod 777`
2. [ ] `bootstrap/cache/` must be `chmod 777`
3. [ ] Re-run chmod commands if errors persist

---

**Deployment Completed:** _______________
**Deployed By:** _______________________
**Notes/Issues:** 
