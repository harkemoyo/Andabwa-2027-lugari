<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SidebarWidgetsUpdated implements ShouldBroadcast
{
    public function broadcastOn(): Channel
    {
        return new Channel('sidebar-widgets');
    }

    public function broadcastAs(): string
    {
        return 'widgets.updated';
    }
}
