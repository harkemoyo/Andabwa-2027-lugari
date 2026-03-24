<?php
// app/Observers/PostObserver.php
namespace App\Observers;

use App\Models\Post;
use App\Events\PostUpdated;
use Illuminate\Support\Facades\Broadcast;

class PostObserver {
    public function saved(Post $post): void {
        // Dispatch the main update event for Livewire listeners
        try {
            PostUpdated::dispatch();
            // Also broadcast for real-time updates if broadcasting is enabled
            Broadcast::event(new PostUpdated());
        } catch (\Exception $e) {
            // Gracefully handle broadcasting errors in development
            report($e);
        }
    }

    public function deleted(Post $post): void {
        try {
            PostUpdated::dispatch();
            Broadcast::event(new PostUpdated());
        } catch (\Exception $e) {
            report($e);
        }
    }

    public function forceDeleted(Post $post): void {
        try {
            PostUpdated::dispatch();
            Broadcast::event(new PostUpdated());
        } catch (\Exception $e) {
            report($e);
        }
    }
}