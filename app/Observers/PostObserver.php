<?php
// app/Observers/PostObserver.php
namespace App\Observers;

use App\Models\Post;
use App\Services\FeedCacheService;
use App\Events\PostUpdated;
use Illuminate\Support\Facades\Broadcast;

class PostObserver {
    public function saved(Post $post): void {
        // Invalidate feed cache immediately
        app(FeedCacheService::class)->invalidate();

        // Dispatch the main update event for Livewire listeners
        try {
            PostUpdated::dispatch();
            // Also broadcast for real-time updates if broadcasting is enabled
            Broadcast::event('blog-feed', 'PostUpdated');
        } catch (\Exception $e) {
            // Gracefully handle broadcasting errors in development
            report($e);
        }
    }

    public function deleted(Post $post): void {
        app(FeedCacheService::class)->invalidate();
        try {
            PostUpdated::dispatch();
            Broadcast::event('blog-feed', 'PostUpdated');
        } catch (\Exception $e) {
            report($e);
        }
    }

    public function forceDeleted(Post $post): void {
        app(FeedCacheService::class)->invalidate();
        try {
            PostUpdated::dispatch();
            Broadcast::event('blog-feed', 'PostUpdated');
        } catch (\Exception $e) {
            report($e);
        }
    }
}