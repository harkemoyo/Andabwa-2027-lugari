<?php

// app/Events/PostUpdated.php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostUpdated implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Broadcast channels
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('blog-feed'),
        ];
    }

    /**
     * Broadcast event name
     */
    public function broadcastAs(): string
    {
        return 'PostUpdated';
    }

    /**
     * Broadcast payload
     */
    public function broadcastWith(): array
    {
        return [
            'updated_at' => now()->toISOString(),
        ];
    }
}