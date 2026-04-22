<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LandingPageUpdated implements ShouldBroadcast
{
    public function broadcastOn(): Channel
    {
        return new Channel('landing-pages');
    }

    public function broadcastAs(): string
    {
        return 'LandingPageUpdated';
    }
}
