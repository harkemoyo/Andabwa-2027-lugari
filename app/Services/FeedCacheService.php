<?php

// app/Services/FeedCacheService.php
namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class FeedCacheService
{
    public const CACHE_TAG = 'blog_feed';
    public const PER_PAGE = 3;

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

        // 2. Use Tagged Cache
        // return Cache::tags([self::CACHE_TAG])->remember($cacheKey, now()->addHours(1), function () use ($query) {
        //     return $query->paginate(12);
        // });
        return Cache::remember($cacheKey, now()->addHours(1), function () use ($query) {
            return $query->paginate(self::PER_PAGE);
        });
    }

    public function invalidate(): void
    {
        // Warning: This clears the ENTIRE application cache, not just the feed!
        // Without tags, granular invalidation is much harder.
        Cache::flush();
    }

    // public function invalidate(): void
    // {
    //     Cache::tags([self::CACHE_TAG])->flush();
    // }
}
