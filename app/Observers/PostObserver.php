<?php
// app/Observers/PostObserver.php
namespace App\Observers;

use App\Models\Post;
use App\Events\PostUpdated;

class PostObserver {
    public function saved(Post $post): void {
        // Only dispatch events for published posts to reduce unnecessary processing
        if (!$post->is_published) {
            return;
        }
        
        // Check if important fields actually changed to avoid redundant events
        if ($post->wasChanged(['title', 'content', 'category_id', 'is_published'])) {
            try {
                event(new PostUpdated());
            } catch (\Exception $e) {
                // Gracefully handle broadcasting errors in development
                \Illuminate\Support\Facades\Log::error('PostObserver save error: ' . $e->getMessage());
            }
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