<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; // Or ShouldBroadcast if queue worker is active
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MenuUpdated implements ShouldBroadcast
{
    public function broadcastOn(): Channel
    {
        return new Channel('ui-updates');
    }

    public function broadcastAs(): string
    {
        return 'MenuUpdated';
    }
}