<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FooterUpdated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public function broadcastOn(): array
    {
        return [new Channel('footer')];
    }

    public function broadcastAs(): string
    {
        return 'FooterUpdated';
    }
}
