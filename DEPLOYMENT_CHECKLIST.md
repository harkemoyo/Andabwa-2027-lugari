# Laravel Cloud Deployment Checklist

## Problem
Local changes (YouTube modal preview, video autoplay with mute) don't show on Laravel Cloud deployment.

## Root Cause
- Cached view files are stale on production
- Cache clearing commands need to run during deployment

## Solution Steps

### Step 1: Verify Git Push (✅ DONE)
```bash
git log --oneline -1
# Should show: c6835b4 (HEAD -> storage-link-in-production, origin/storage-link-in-production)
```

### Step 2: Trigger New Deployment on Laravel Cloud
1. Go to https://laravel.cloud
2. Navigate to your `andabwa-blog` project
3. Go to "Deployments" section
4. Click **"Deploy"** or **"Redeploy Latest"**
5. Wait for deployment to complete (5-10 minutes)

### Step 3: Verify Deployment (After Deployment Completes)
```bash
# SSH into Laravel Cloud (via dashboard)
cd /var/www/html
php artisan view:clear
php artisan config:clear
php artisan cache:clear
```

### Step 4: Clear Production Cache (If deployment doesn't clear cache)
**Option A: Via Laravel Forge/Cloud Dashboard SSH**
```bash
ssh user@your-server
cd /var/www/html
php artisan optimize:clear
php artisan view:clear
php artisan config:clear
```

**Option B: Via Artisan Tinker**
```bash
php artisan tinker
>>> Cache::flush()
>>> Artisan::call('view:clear')
>>> Artisan::call('config:clear')
```

## Files Changed (To Verify on Production)
- `resources/views/components/blog/media.blade.php` - YouTube modal with mute parameter
- `resources/views/livewire/pages/blog/external.blade.php` - Detail page improvements
- `resources/views/components/layouts/app.blade.php` - Modal CSS styling

## How to Check Production
After deployment, check these URLs:
1. Production site homepage → Look for YouTube thumbnails with play buttons
2. Click play button → Should show modal with muted video
3. Modal close button → Should close modal

## Troubleshooting

### Videos Still Show "Video Unavailable"
1. Clear production cache: `php artisan optimize:clear`
2. Rebuild views: `php artisan view:cache`
3. Hard refresh browser: `Ctrl+Shift+Delete` (clear all cache)
4. Wait 5 minutes for CDN to update

### Changes Still Not Showing
1. Check which branch is deployed: Should be `storage-link-in-production`
2. In Laravel Cloud dashboard, verify latest deployment used correct branch
3. Check deployment logs for errors
4. Check if `.env` production file has correct `APP_ENV=production`

## Prevention for Future Deployments
The `laravel-cloud.yaml` file already includes:
```yaml
deploy-commands:
  - "php artisan view:clear"
  - "php artisan config:clear"
  - "php artisan cache:clear"
  - "php artisan view:cache"
  - "php artisan config:cache"
```

These run automatically on every deployment, so future changes should display immediately.
