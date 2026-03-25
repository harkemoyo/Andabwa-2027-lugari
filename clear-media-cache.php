<?php

/**
 * Clear Media Cache Script
 * Run this after uploading media in production to ensure changes appear
 */

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Clearing Media Cache ===\n\n";

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

// Clear various caches
$caches = [
    'blog_feed_cache',
    'featured_posts_cache', 
    'latest_posts_cache',
    'posts_cache',
    'media_cache',
];

foreach ($caches as $cache) {
    $cleared = Cache::forget($cache);
    echo $cleared ? "✅ Cleared: $cache\n" : "⚠️  Not found: $cache\n";
}

// Clear Laravel caches
echo "\n=== Clearing Laravel Caches ===\n";
Artisan::call('cache:clear');
echo "✅ Application cache cleared\n";

Artisan::call('view:clear');
echo "✅ View cache cleared\n";

Artisan::call('config:clear');
echo "✅ Config cache cleared\n";

// Check if storage link exists
echo "\n=== Checking Storage Link ===\n";
if (is_link(public_path('storage'))) {
    echo "✅ Storage link exists\n";
    echo "   Target: " . readlink(public_path('storage')) . "\n";
} else {
    echo "❌ Storage link missing - recreating...\n";
    Artisan::call('storage:link');
    echo "✅ Storage link recreated\n";
}

// Test media URLs
echo "\n=== Testing Media URLs ===\n";
$posts = \App\Models\Post::with('media')->limit(3)->get();

foreach ($posts as $post) {
    if ($post->hasMedia('featured')) {
        $media = $post->getFirstMedia('featured');
        $url = $media->getUrl();
        echo "Post: {$post->title}\n";
        echo "Media URL: $url\n";
        echo "File exists: " . (file_exists(public_path(str_replace(url('/'), '', $url))) ? 'YES' : 'NO') . "\n\n";
    }
}

echo "=== Cache Clear Complete ===\n";
echo "Frontend should now show updated media!\n";
