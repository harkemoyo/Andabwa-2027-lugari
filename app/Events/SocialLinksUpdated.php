<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SocialLinksUpdated implements ShouldBroadcast
{
    public function broadcastOn(): Channel
    {
        return new Channel('ui-updates');
    }

    public function broadcastAs(): string
    {
        return 'SocialLinksUpdated';
    }
}