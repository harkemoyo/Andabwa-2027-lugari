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

        // Dispatch event asynchronously without try-catch for speed
        event(new PostUpdated());

        // Only clear cache if relevant fields changed
        if ($post->wasChanged(['title', 'content', 'is_published', 'is_featured'])) {
            // Clear critical caches only
            Cache::forget('featured-posts-cache');
            Cache::forget('all-projects-categories-cache');
            Cache::forget('categories-cache');
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