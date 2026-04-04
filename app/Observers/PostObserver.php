<?php
// app/Observers/PostObserver.php
namespace App\Observers;

use App\Models\Post;
use App\Events\PostUpdated;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Cache;

class PostObserver {
    public function saved(Post $post): void {
        // Only dispatch events for published posts to reduce unnecessary broadcasts
        if (!$post->is_published) {
            logger('PostObserver: Skipping unpublished post ' . $post->id);
            return;
        }
        
        logger('PostObserver: Post saved - ID: ' . $post->id . ', Changes: ' . json_encode($post->getChanges()));
        
        try {
            event(new PostUpdated());
            logger('PostObserver: Dispatched PostUpdated event for post ' . $post->id);
            
            // Enhanced cache clearing for all media-related changes
            $shouldClearCache = $post->wasChanged([
                'media_type', 'external_url', 'link_preview_data', 'title', 
                'content', 'is_featured', 'is_published'
            ]) || $post->hasMedia('featured');
            
            if ($shouldClearCache) {
                logger('PostObserver: Clearing comprehensive caches for post ' . $post->id);
                
                // Clear all relevant caches
                Cache::forget('blog_feed_cache');
                Cache::forget('featured_posts_cache');
                Cache::forget('latest_posts_cache');
                Cache::forget('homepage_cache');
                Cache::forget('post_' . $post->id . '_cache');
                Cache::forget('post_' . $post->slug . '_cache');
                
                // Clear category-specific caches
                if ($post->category_id) {
                    Cache::forget('category_' . $post->category_id . '_posts');
                }
                
                // Clear media-specific caches
                Cache::forget('media_gallery_cache');
                Cache::forget('featured_media_cache');
                
                logger('PostObserver: Cache clearing completed for post ' . $post->id);
            }
        } catch (\Exception $e) {
            // Gracefully handle broadcasting errors in development
            logger('PostObserver error: ' . $e->getMessage());
            report($e);
        }
    }

    public function deleted(Post $post): void {
        if (!$post->is_published) {
            return;
        }
        
        try {
            event(new PostUpdated());
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('PostObserver delete error: ' . $e->getMessage());
        }
    }

    public function forceDeleted(Post $post): void {
        if (!$post->is_published) {
            return;
        }
        
        try {
            event(new PostUpdated());
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('PostObserver forceDelete error: ' . $e->getMessage());
        }
    }
}