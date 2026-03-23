<?php
// app/Observers/PostObserver.php
namespace App\Observers;

use App\Models\Post;
use App\Services\FeedCacheService;
use App\Events\PostUpdated;

class PostObserver {
    public function saved(Post $post): void {
        app(FeedCacheService::class)->invalidate();
        PostUpdated::dispatch();
    }

    public function deleted(Post $post): void {
        app(FeedCacheService::class)->invalidate();
        PostUpdated::dispatch();
    }
}