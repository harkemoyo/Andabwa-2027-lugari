# Storage Sync Guide for Laravel Cloud Production

## Problem
Locally uploaded images and videos are not visible in production because:
1. Files in `storage/app/public/` are local only
2. Laravel Cloud doesn't automatically sync storage files
3. External URLs (non-YouTube) may not be accessible

## Solution Options

### Option 1: Use S3 for Production (Recommended)
Configure your Laravel Cloud environment to use AWS S3 for storage.

**Set these environment variables in Laravel Cloud:**
```
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_aws_access_key
AWS_SECRET_ACCESS_KEY=your_aws_secret_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name
AWS_URL=https://your-bucket-name.s3.amazonaws.com
```

**Benefits:**
- Files persist across deployments
- Scalable storage
- CDN support possible
- No manual sync needed

### Option 2: Manual Storage Sync
If you want to keep using local storage, you need to sync files manually.

**Steps:**
1. Upload files from local `storage/app/public/` to production server
2. Use FTP, SFTP, or Laravel Cloud's file manager
3. Upload to `/var/www/html/storage/app/public/`

**Required directories to sync:**
- `storage/app/public/social-links/`
- `storage/app/public/widgets/`
- `storage/app/public/landing-pages/`
- `storage/app/public/blog/media/`
- `storage/app/public/livewire-tmp/`
- Any other uploaded media directories

### Option 3: Use Laravel Cloud's Persistent Storage
Laravel Cloud may offer persistent storage options. Check your plan settings.

## Current Configuration

Your `config/filesystems.php` has:
- `public` disk: Local storage at `storage/app/public`
- `s3` disk: AWS S3 configuration (ready to use)
- `blog_media` disk: Configurable (local or S3)

## Deploy Process

The `laravel-cloud.json` now includes:
- `php artisan storage:link` - Creates symlink
- `php artisan production:cleanup` - Cleans up data
- `php artisan db:seed --force` - Seeds default data

## What You Need to Do

**For immediate fix:**
1. Upload your local storage files to production server
2. Ensure `public/storage` symlink exists
3. Verify `APP_URL` is set correctly in production environment

**For long-term solution:**
1. Set up AWS S3 bucket
2. Configure environment variables in Laravel Cloud
3. Change `FILESYSTEM_DISK=s3` in production
4. Upload existing files to S3
5. Test file uploads work correctly

## Verification

After syncing storage, run:
```bash
php artisan storage:verify
```

This will check if all required files exist in storage.
