<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SidebarUpdated implements ShouldBroadcast
{
    public function broadcastOn(): array
    {
        return [new Channel('sidebar')];
    }

    public function broadcastAs(): string
    {
        return 'sidebar.updated';
    }
}
