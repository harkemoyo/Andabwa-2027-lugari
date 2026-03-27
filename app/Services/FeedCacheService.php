<?php

// app/Services/FeedCacheService.php
namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class FeedCacheService
{
    public const CACHE_TAG = 'blog_feed';
    public const PER_PAGE = 12; // Fixed: Should match blog feed pagination

    public function getPaginatedFeed(
        int $page = 1,
        string $search = '',
        ?int $categoryId = null,
        ?int $tagId = null
    ) {
        // 1. Generate a unique cache key based on ALL filters
        $cacheKey = "feed_p{$page}_s" . md5($search) . "_c{$categoryId}_t{$tagId}";

        $query = Post::query()
            ->with(['category', 'tags', 'media']) // Eager load relationships including media
            ->where('is_published', true)
            ->when(
                $search,
                fn($q) =>
                $q->where('title', 'ilike', "%{$search}%")->orWhere('content', 'ilike', "%{$search}%")
            )
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->when($tagId, fn($q) => $q->whereHas('tags', fn($t) => $t->where('tags.id', $tagId)))
            ->orderBy('is_featured', 'desc')
            ->latest();

        // 2. Use appropriate caching method based on environment
        if (config('cache.default') === 'redis' || config('cache.default') === 'memcached') {
            // Use tagged cache for Redis/Memcached
            return Cache::tags([self::CACHE_TAG])->remember($cacheKey, now()->addHours(1), function () use ($query) {
                return $query->paginate(self::PER_PAGE);
            });
        } else {
            // Use simple cache for Database/File drivers (Laravel Cloud)
            return Cache::remember($cacheKey, now()->addHours(1), function () use ($query) {
                return $query->paginate(self::PER_PAGE);
            });
        }
    }

    public function invalidate(): void
    {
        if (config('cache.default') === 'redis' || config('cache.default') === 'memcached') {
            // Use tagged cache invalidation for Redis/Memcached
            Cache::tags([self::CACHE_TAG])->flush();
        } else {
            // Use pattern-based cache clearing for Database/File drivers (Laravel Cloud)
            $this->clearFeedCacheByPattern();
        }
    }

    /**
     * Clear cache by pattern for drivers that don't support tagging
     */
    private function clearFeedCacheByPattern(): void
    {
        // Clear common feed cache keys
        $patterns = [
            'feed_p*',
            'blog_feed_cache',
            'featured_posts_cache',
            'latest_posts_cache',
            'posts_cache',
        ];

        foreach ($patterns as $pattern) {
            if (config('cache.default') === 'file') {
                // For file cache, delete matching files
                $cachePath = storage_path('framework/cache/data');
                if (is_dir($cachePath)) {
                    $files = glob($cachePath . '/' . $pattern);
                    foreach ($files as $file) {
                        if (is_file($file)) {
                            unlink($file);
                        }
                    }
                }
            } elseif (config('cache.default') === 'database') {
                // For database cache, delete matching entries
                \Illuminate\Support\Facades\DB::table('cache')
                    ->where('key', 'like', $pattern)
                    ->delete();
            }
        }
    }
}
