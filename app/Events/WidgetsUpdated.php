<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class WidgetsUpdated implements ShouldBroadcast
{
    public function broadcastOn(): Channel
    {
        return new Channel('widgets-updates');
    }

    public function broadcastAs(): string
    {
        return 'widgets.updated';
    }
}
