# Laravel Cloud Media Setup Guide

## Problem: Navigation Logo and Widgets Not Showing in Production

## Root Cause
Media records in database point to `public` disk, but Laravel Cloud production needs media on R2 disk.

## Solution: Complete Production Setup

### Step 1: Set Environment Variables in Laravel Cloud

Go to your Laravel Cloud project settings and add these environment variables:

```
FILESYSTEM_DISK=r2_public
R2_ACCESS_KEY_ID=your_actual_r2_access_key
R2_SECRET_ACCESS_KEY=your_actual_r2_secret_key
R2_BUCKET=your_bucket_name
R2_ENDPOINT=https://<account-id>.r2.cloudflarestorage.com
R2_PUBLIC_URL=https://<your-custom-domain-or-r2-url>
```

**Critical:** `FILESYSTEM_DISK` must be set to `r2_public` for media to work in production.

### Step 2: Deploy the Application

Deploy your application to Laravel Cloud. This will pull the latest code with media commands.

### Step 3: Run Media Setup Commands

SSH into your Laravel Cloud instance or use the Laravel Cloud CLI to run:

```bash
# Check current media status
php artisan media:check

# If media exists but on wrong disk, migrate it
php artisan media:migrate-to-r2 --force

# If no media exists, upload seed images and run seeders
php artisan media:upload-seed-images --force
php artisan db:seed --class=FooterSeeder
php artisan db:seed --class=NavigationLogoHeaderSeeder
php artisan db:seed --class=WidgetSeeder

# Verify setup
php artisan media:check
```

### Step 4: Verify Frontend

Check your frontend:
- Navigation logo should display
- 4 rotating widgets should display
- Social link icons should display

## Troubleshooting

### Images Still Not Showing?

1. **Check environment variables:**
   ```bash
   php artisan tinker
   >>> echo env('FILESYSTEM_DISK');
   ```
   Should return: `r2_public`

2. **Check media URLs:**
   ```bash
   php artisan media:check
   ```
   URLs should point to your R2 public URL, not local storage.

3. **Check R2 bucket:**
   - Log into Cloudflare dashboard
   - Navigate to R2 bucket
   - Verify files are uploaded
   - Check bucket is public or has custom domain

4. **Clear cache:**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```

### Common Issues

**Issue:** "404 Not Found" for images
- **Fix:** Files not uploaded to R2. Run `php artisan media:upload-seed-images --force`

**Issue:** Images show broken link
- **Fix:** `R2_PUBLIC_URL` not set correctly. Check environment variables.

**Issue:** Images show locally but not in production
- **Fix:** `FILESYSTEM_DISK` not set to `r2_public` in production.

## Quick Reference

**For fresh production deployment (no existing media):**
```bash
php artisan media:upload-seed-images --force
php artisan db:seed --class=FooterSeeder
php artisan db:seed --class=NavigationLogoHeaderSeeder
php artisan db:seed --class=WidgetSeeder
```

**For existing production deployment (media already exists):**
```bash
php artisan media:migrate-to-r2 --force
```

**Verify:**
```bash
php artisan media:check
```
