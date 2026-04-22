<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class WidgetsUpdated implements ShouldBroadcast
{
    public function broadcastOn(): Channel
    {
        return new Channel('widget-upates');
    }

    public function broadcastAs(): string
    {
        return 'widgets.updated';
    }
}
