#!/bin/bash
# Laravel Cloud deployment cache clearing script
# Run this after deploying to clear stale caches

echo "Clearing Laravel caches on production..."
php artisan view:clear
php artisan config:clear
php artisan cache:clear
php artisan route:cache
echo "✅ All caches cleared successfully!"
