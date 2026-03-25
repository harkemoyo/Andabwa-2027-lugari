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
            return;
        }
        
        try {
            PostUpdated::dispatch();
            // Broadcast only if not in CLI/artisan context (reduces overhead during seeding)
            if (app()->runningInConsole() === false) {
                Broadcast::event(new PostUpdated());
            }
            
            // Clear caches when media is updated to ensure frontend shows changes
            if ($post->wasChanged(['media_type', 'external_url', 'link_preview_data']) || $post->hasMedia('featured')) {
                Cache::forget('blog_feed_cache');
                Cache::forget('featured_posts_cache');
                Cache::forget('latest_posts_cache');
            }
        } catch (\Exception $e) {
            // Gracefully handle broadcasting errors in development
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