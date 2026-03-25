<?php

/**
 * Deployment Debug Script
 * Run this after deployment to verify everything is working
 */

use Illuminate\Support\Facades\DB;

echo "=== Laravel Cloud Deployment Debug ===\n\n";

// 1. Check database connection
echo "1. Database Connection:\n";
try {
    DB::connection()->getPdo();
    echo "✅ Database connected successfully\n";
    echo "   - Connection: " . config('database.default') . "\n";
    echo "   - Database: " . config('database.connections.' . config('database.default') . '.database') . "\n";
} catch (\Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
}

// 2. Check tables exist
echo "\n2. Database Tables:\n";
$tables = ['categories', 'tags', 'posts', 'blog_page_settings'];
foreach ($tables as $table) {
    try {
        DB::table($table)->count();
        echo "✅ Table '$table' exists\n";
    } catch (\Exception $e) {
        echo "❌ Table '$table' missing: " . $e->getMessage() . "\n";
    }
}

// 3. Check seed data
echo "\n3. Seed Data:\n";
try {
    $categoryCount = \App\Models\Category::count();
    $tagCount = \App\Models\Tag::count();
    $postCount = \App\Models\Post::count();
    
    echo "   - Categories: $categoryCount\n";
    echo "   - Tags: $tagCount\n";
    echo "   - Posts: $postCount\n";
    
    if ($categoryCount > 0 && $tagCount > 0 && $postCount > 0) {
        echo "✅ Seed data exists\n";
    } else {
        echo "❌ Missing seed data\n";
    }
} catch (\Exception $e) {
    echo "❌ Error checking seed data: " . $e->getMessage() . "\n";
}

// 4. Check published posts
echo "\n4. Published Posts:\n";
try {
    $publishedPosts = \App\Models\Post::where('is_published', true)->count();
    $featuredPosts = \App\Models\Post::where('is_featured', true)->count();
    
    echo "   - Published: $publishedPosts\n";
    echo "   - Featured: $featuredPosts\n";
    
    if ($publishedPosts > 0) {
        echo "✅ Published posts available\n";
    } else {
        echo "❌ No published posts found\n";
    }
} catch (\Exception $e) {
    echo "❌ Error checking posts: " . $e->getMessage() . "\n";
}

// 5. Check file paths
echo "\n5. File Paths:\n";
$paths = [
    'public/seed-images/scholorships.webp',
    'public/seed-images/security.jpg',
    'public/seed-images/www.ssvid.net--Andabwa-akanusha-kuwania-kiti-Cotu-Unknown-144p-h264-mp4.mp4',
    'public/images/placeholder.jpg'
];

foreach ($paths as $path) {
    if (file_exists(public_path(str_replace('public/', '', $path)))) {
        echo "✅ $path exists\n";
    } else {
        echo "❌ $path missing\n";
    }
}

// 6. Test Feed component
echo "\n6. Feed Component Test:\n";
try {
    $feed = new \App\Livewire\Pages\Blog\Feed();
    $latestPosts = $feed->latestPosts;
    $posts = $feed->posts;
    
    echo "   - Latest posts: " . $latestPosts->count() . "\n";
    echo "   - Paginated posts: " . $posts->total() . "\n";
    echo "   - Current page items: " . $posts->count() . "\n";
    echo "   - Total pages: " . $posts->lastPage() . "\n";
    
    if ($latestPosts->count() > 0) {
        echo "✅ Feed component working\n";
    } else {
        echo "❌ Feed component has no data\n";
    }
} catch (\Exception $e) {
    echo "❌ Feed component error: " . $e->getMessage() . "\n";
}

echo "\n=== Debug Complete ===\n";
