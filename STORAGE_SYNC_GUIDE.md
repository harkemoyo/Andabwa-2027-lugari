# Storage Sync Guide for Laravel Cloud Production

## Problem
Locally uploaded images and videos are not visible in production because:
1. Files in `storage/app/public/` are local only
2. Laravel Cloud doesn't automatically sync storage files
3. External URLs (non-YouTube) may not be accessible

## Solution Options

### Option 1: Use Cloudflare R2 (Recommended)
Cloudflare R2 is S3-compatible, cost-effective, and has no egress fees.

**Set up Cloudflare R2:**
1. Go to Cloudflare Dashboard → R2 → Create Bucket
2. Create a bucket (e.g., `andabwa-storage`)
3. Go to R2 → Manage R2 API Tokens → Create API Token
4. Copy the Access Key ID and Secret Access Key
5. Get your Account ID from Cloudflare dashboard URL

**Set these environment variables in Laravel Cloud:**
```
FILESYSTEM_DISK=r2_public
R2_ACCESS_KEY_ID=your_r2_access_key
R2_SECRET_ACCESS_KEY=your_r2_secret_key
R2_BUCKET=andabwa-storage
R2_ENDPOINT=https://<your-account-id>.r2.cloudflarestorage.com
R2_PUBLIC_URL=https://<your-custom-domain-or-r2-public-url>
```

**Optional: Set up custom domain for R2:**
1. Go to R2 → Your Bucket → Settings → Public Access
2. Add a custom domain (e.g., `cdn.yourdomain.com`)
3. Update `R2_PUBLIC_URL` to your custom domain

**Benefits:**
- Files persist across deployments
- No egress fees (unlike AWS S3)
- S3-compatible (works with existing Laravel code)
- Can use Cloudflare CDN
- Cost-effective for high-traffic sites

### Option 2: Use AWS S3
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

### Option 3: Manual Storage Sync
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

## Current Configuration

Your `config/filesystems.php` has:
- `public` disk: Local storage at `storage/app/public`
- `r2` disk: Cloudflare R2 configuration (S3-compatible)
- `r2_public` disk: Cloudflare R2 with public URL
- `s3` disk: AWS S3 configuration
- `blog_media` disk: Configurable (local, R2, or S3)

## Deploy Process

The `laravel-cloud.json` now includes:
- `php artisan storage:link` - Creates symlink
- `php artisan production:cleanup` - Cleans up data
- `php artisan db:seed --force` - Seeds default data

## What You Need to Do

**For immediate fix with Cloudflare R2:**
1. Create Cloudflare R2 bucket
2. Generate R2 API token
3. Set environment variables in Laravel Cloud
4. Upload existing files to R2 bucket
5. Test file uploads work correctly

**For manual sync (temporary):**
1. Upload your local storage files to production server
2. Ensure `public/storage` symlink exists
3. Verify `APP_URL` is set correctly in production environment

## Uploading Files to R2

**Option 1: Using AWS CLI (works with R2):**
```bash
# Install AWS CLI
# Configure with R2 credentials
aws configure --profile r2

# Upload files
aws s3 sync storage/app/public/ s3://your-bucket-name/ --profile r2
```

**Option 2: Using Rclone:**
```bash
# Install rclone
# Configure R2 remote
rclone config

# Sync files
rclone sync storage/app/public/ r2:your-bucket-name
```

**Option 3: Using Cloudflare Dashboard:**
1. Go to R2 → Your Bucket
2. Upload files manually via browser

## Verification

After setting up R2, run:
```bash
php artisan production:diagnose
```

This will check:
- Storage configuration
- Symlink status
- File accessibility
- URL generation
