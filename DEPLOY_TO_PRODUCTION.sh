#!/bin/bash

# Production Deployment Script for Laravel Cloud
# This script sets up R2 storage and migrates/uploads media for production

echo "=== PRODUCTION DEPLOYMENT SCRIPT ==="
echo ""

# Check if R2 environment variables are set
if [ -z "$R2_ACCESS_KEY_ID" ] || [ -z "$R2_SECRET_ACCESS_KEY" ] || [ -z "$R2_BUCKET" ]; then
    echo "ERROR: R2 environment variables not set!"
    echo "Please set: R2_ACCESS_KEY_ID, R2_SECRET_ACCESS_KEY, R2_BUCKET, R2_ENDPOINT, R2_PUBLIC_URL"
    exit 1
fi

echo "✓ R2 environment variables found"
echo ""

# Set filesystem disk to R2
export FILESYSTEM_DISK=r2_public
echo "✓ FILESYSTEM_DISK set to: $FILESYSTEM_DISK"
echo ""

# Check if media exists in database
MEDIA_COUNT=$(php artisan tinker --execute="echo \Spatie\MediaLibrary\MediaCollections\Models\Media::count();" 2>/dev/null)

if [ "$MEDIA_COUNT" -gt "0" ]; then
    echo "Found $MEDIA_COUNT existing media records"
    echo "Migrating existing media to R2..."
    php artisan media:migrate-to-r2 --force
else
    echo "No existing media records found"
    echo "Uploading seed images to R2..."
    php artisan media:upload-seed-images --force
    
    echo ""
    echo "Running seeders to attach media..."
    php artisan db:seed --class=FooterSeeder
    php artisan db:seed --class=NavigationLogoHeaderSeeder
    php artisan db:seed --class=WidgetSeeder
fi

echo ""
echo "Verifying media setup..."
php artisan media:check

echo ""
echo "=== DEPLOYMENT COMPLETE ==="
echo "Navigation logo and widgets should now be visible in production"
