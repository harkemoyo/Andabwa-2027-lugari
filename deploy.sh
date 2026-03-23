#!/bin/bash

# Pre-deployment setup
echo "🚀 Deploying Andabwa Foundation Blog to Laravel Cloud..."

# Clear caches locally
php artisan optimize:clear

# Install dependencies
composer install --no-dev --optimize-autoloader
npm ci --only=production
npm run build

# Create necessary directories
mkdir -p storage/app/public
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views

echo "✅ Ready for deployment!"
