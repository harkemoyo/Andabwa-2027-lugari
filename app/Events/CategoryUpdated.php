<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CategoryUpdated implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    /**
     * Set the connection to 'reverb' or 'pusher' 
     */
    public $connection = 'reverb';

    public function __construct() {}

    public function broadcastOn(): array
    {
        return [new Channel('categories')];
    }

    public function broadcastAs(): string
    {
        return 'category.updated';
    }
}