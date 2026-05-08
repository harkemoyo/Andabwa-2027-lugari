<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FooterUpdated implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public function broadcastOn(): array
    {
        return [new Channel('ui-updates')];
    }

    public function broadcastAs(): string
    {
        return 'FooterUpdated';
    }
}
