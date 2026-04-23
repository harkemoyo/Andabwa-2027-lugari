# Production Deployment Guide - Andabwa 2027

## Overview
This guide provides a comprehensive production deployment strategy to ensure consistency between local and production environments.

## Pre-Deployment Checklist

### 1. Storage Configuration
```env
# Production .env
FILESYSTEM_DISK=public
APP_URL=https://your-domain.com
```

### 2. Create Storage Symlink
```bash
php artisan storage:link
```

### 3. Verify Media Files Exist
Ensure these files exist in `storage/app/public/`:
- `social-links/facebook.gif`
- `social-links/instagram.gif`
- `social-links/x.gif`
- `social-links/whatsapp.gif`
- `social-links/linkedin.gif`
- `widgets/easter.png`
- `widgets/smile-logo.png`
- `widgets/walinzi-sacco.png`
- `widgets/eagle.png`
- `widgets/andabwa-logo.svg`
- `landing-pages/hero/smile-logo.jpeg`
- `landing-pages/hero/walinzi.png`

## Database Seeding Strategy

### Production Cleanup Seeder
The `ProductionCleanupSeeder` class automatically:
1. **Removes duplicate social links** - Keeps only one per platform_name
2. **Removes orphaned navigation items** - Deletes items not in the allowed slug list
3. **Removes orphaned landing pages** - Deletes pages not in the allowed slug list
4. **Ensures footer singletons** - Keeps only one FooterInfo and one FooterCta

### Allowed Navigation Slugs
- `home` (News)
- `tv`
- `radio`
- `podcasts`
- `live-events`

### Allowed Landing Page Slugs
- `tv`
- `radio`
- `podcasts`
- `live-events`

## Deployment Steps

### Step 1: Deploy Code
```bash
git pull origin master
composer install --no-dev --optimize-autoloader
npm run build
```

### Step 2: Run Migrations
```bash
php artisan migrate --force
```

### Step 3: Run Seeders with Cleanup
```bash
php artisan db:seed --force
```

This will:
1. Run `ProductionCleanupSeeder` first (removes duplicates/orphans)
2. Run all other seeders in order
3. Ensure idempotent operations (no duplicates created)

### Step 4: Clear Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize
```

### Step 5: Verify Storage Link
```bash
# Check if symlink exists
ls -la public/storage

# If missing, create it
php artisan storage:link
```

## Model Storage URL Fixes

All models now use the correct storage URL generation:
- `SocialLink::getFullImagePathAttribute()` - Uses `config('filesystems.disks.public.url')`
- `NavigationLogoHeader::getFullLogoPathAttribute()` - Uses `config('filesystems.disks.public.url')`
- `Widget::fullWidgetImagePath` - Uses `config('filesystems.disks.public.url')`
- `LandingPage::getFullHeroImagePathAttribute()` - Uses `config('filesystems.disks.public.url')`

## Troubleshooting

### Social Links Not Showing Images
1. Check storage symlink exists: `public/storage -> storage/app/public`
2. Verify files exist in `storage/app/public/social-links/`
3. Check `APP_URL` is set correctly in `.env`
4. Run `php artisan storage:link` if symlink is missing

### Landing Pages Not Showing Images
1. Verify files exist in `storage/app/public/landing-pages/hero/`
2. Check `APP_URL` is set correctly
3. Ensure storage symlink is accessible

### Duplicate Navigation Items
Run the cleanup seeder:
```bash
php artisan db:seed --class=ProductionCleanupSeeder --force
```

### Social Links Duplicates
The `FooterSeeder` now uses `updateOrCreate` with `platform_name` as the unique key, preventing duplicates.

## Seeder Order (DatabaseSeeder.php)

1. `ProductionCleanupSeeder` - Cleans up production duplicates first
2. `RoleSeeder` - Create roles and permissions
3. `AdminSeeder` - Create users with roles
4. `PageSectionSeeder` - Create page sections
5. `NavigationSeeder` - Create navigation menus and items
6. `CategorySeeder` - Create categories
7. `TagSeeder` - Create tags
8. `SidebarWidgetSeeder` - Create sidebar widgets
9. `PostSeeder` - Create posts
10. `BlogPageSettingSeeder` - Create blog page settings
11. `ActivitySeeder` - Create activities
12. `NavigationLogoHeaderSeeder` - Create navigation logo
13. `FooterSeeder` - Create footer info, CTA, and social links
14. `WidgetSeeder` - Create widgets
15. `LandingPageSeeder` - Create landing pages and navigation items
16. `PodcastSeeder` - Create podcasts
17. `LiveEventsSeeder` - Create live events
18. `RadioChannelsSeeder` - Create radio channels
19. `TvChannelsSeeder` - Create TV channels
20. `WidgetImpressionSeeder` - Create widget impressions (fixed to use actual widget IDs)

## Post-Deployment Verification

### Check Social Links
```bash
php artisan tinker
>>> App\Models\SocialLink::count()
>>> App\Models\SocialLink::distinct('platform_name')->count()
# Both should return 5
```

### Check Navigation Items
```bash
php artisan tinker
>>> App\Models\NavigationItem::whereNull('parent_id')->count()
# Should return 5 (home, tv, radio, podcasts, live-events)
```

### Check Landing Pages
```bash
php artisan tinker
>>> App\Models\LandingPage::count()
# Should return 4 (tv, radio, podcasts, live-events)
```

### Check Storage URLs
```bash
php artisan tinker
>>> $link = App\Models\SocialLink::first();
>>> $link->full_image_path
# Should return: https://your-domain.com/storage/social-links/facebook.gif
```

## Security Considerations

- Never commit `.env` files to version control
- Use environment-specific configuration
- Rotate API keys regularly
- Enable HTTPS for all connections
- Validate all user inputs before storage

## Monitoring

After deployment, monitor:
- Social links images loading correctly
- Landing pages hero images loading correctly
- Navigation menu displaying correct items
- No duplicate entries in any tables
- Storage symlink is accessible

## Rollback Plan

If issues occur:
```bash
# Rollback migrations
php artisan migrate:rollback --step=1

# Restore from backup if needed
# Re-run seeders after fixing issues
php artisan db:seed --force
```
