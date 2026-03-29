<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Laravel Cloud Debug Script ===\n\n";

// Check environment
echo "Environment: " . app()->environment() . "\n";
echo "App URL: " . config('app.url') . "\n";

// Check filesystem configuration
echo "\n=== Filesystem Configuration ===\n";
echo "Default Filesystem Disk: " . config('filesystems.default') . "\n";
echo "Public Disk Root: " . config('filesystems.disks.public.root') . "\n";
echo "Public Disk URL: " . config('filesystems.disks.public.url') . "\n";

if (config('filesystems.disks.public-cloud')) {
    echo "Public Cloud Disk Root: " . config('filesystems.disks.public-cloud.root') . "\n";
    echo "Public Cloud Disk URL: " . config('filesystems.disks.public-cloud.url') . "\n";
}

// Check storage directories
echo "\n=== Storage Directories ===\n";
$storagePaths = [
    'storage/app/public' => storage_path('app/public'),
    'public/storage' => public_path('storage'),
    '/var/www/html/storage/app/public' => '/var/www/html/storage/app/public',
    '/var/www/html/public/storage' => '/var/www/html/public/storage',
];

foreach ($storagePaths as $name => $path) {
    $exists = is_dir($path);
    $isLink = is_link($path);
    $readable = is_readable($path);
    echo sprintf("%-40s: %s (Dir: %s, Link: %s, Readable: %s)\n", 
        $name, 
        $exists ? 'EXISTS' : 'MISSING',
        $exists ? 'YES' : 'NO',
        $isLink ? 'YES' : 'NO',
        $readable ? 'YES' : 'NO'
    );
}

// Check seed images
echo "\n=== Seed Images ===\n";
$seedImagePaths = [
    'public/seed-images' => public_path('seed-images'),
    '/var/www/html/public/seed-images' => '/var/www/html/public/seed-images',
];

foreach ($seedImagePaths as $name => $path) {
    $exists = is_dir($path);
    $readable = is_readable($path);
    echo sprintf("%-30s: %s (Readable: %s)\n", 
        $name, 
        $exists ? 'EXISTS' : 'MISSING',
        $readable ? 'YES' : 'NO'
    );
    
    if ($exists && $readable) {
        $files = scandir($path);
        $imageFiles = array_filter($files, fn($file) => !in_array($file, ['.', '..']));
        echo "  Files: " . count($imageFiles) . "\n";
        foreach (array_slice($imageFiles, 0, 3) as $file) {
            $fullPath = $path . '/' . $file;
            $fileExists = is_file($fullPath);
            $fileReadable = is_readable($fullPath);
            echo sprintf("  - %s (%s, %s)\n", $file, $fileExists ? 'EXISTS' : 'MISSING', $fileReadable ? 'READABLE' : 'NOT READABLE');
        }
        if (count($imageFiles) > 3) {
            echo "  ... and " . (count($imageFiles) - 3) . " more files\n";
        }
    }
}

// Check database connection
echo "\n=== Database Connection ===\n";
try {
    $dbConnection = \Illuminate\Support\Facades\DB::connection();
    echo "Database: CONNECTED\n";
    echo "Database Name: " . $dbConnection->getDatabaseName() . "\n";
    
    $postCount = \App\Models\Post::count();
    echo "Posts in Database: $postCount\n";
    
    $mediaCount = \App\Models\Post::whereHas('media')->count();
    echo "Posts with Media: $mediaCount\n";
    
} catch (\Exception $e) {
    echo "Database: ERROR - " . $e->getMessage() . "\n";
}

// Check cache
echo "\n=== Cache Configuration ===\n";
echo "Cache Driver: " . config('cache.default') . "\n";
echo "Cache Prefix: " . config('cache.prefix') . "\n";

// Test media URL generation
echo "\n=== Media URL Test ===\n";
try {
    $posts = \App\Models\Post::whereHas('media')->take(2)->get();
    foreach ($posts as $post) {
        echo "Post: " . $post->title . "\n";
        echo "Media Type: " . $post->media_type?->value . "\n";
        echo "Featured Image URL: " . $post->featured_image . "\n";
        
        if ($post->hasMedia('featured')) {
            $media = $post->getFirstMedia('featured');
            echo "Media URL: " . $media->getUrl() . "\n";
            echo "Media Path: " . $media->getPath() . "\n";
            echo "File Exists: " . (file_exists($media->getPath()) ? 'YES' : 'NO') . "\n";
        }
        echo "---\n";
    }
} catch (\Exception $e) {
    echo "Media URL Test: ERROR - " . $e->getMessage() . "\n";
}

echo "\n=== Debug Complete ===\n";
