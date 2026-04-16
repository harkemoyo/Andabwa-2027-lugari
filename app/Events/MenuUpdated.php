<?php

namespace App\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MenuUpdated implements ShouldBroadcast
{
    public function broadcastOn()
    {
        return ['menus'];
    }

    public function broadcastAs()
    {
        return 'menu.updated';
    }
}


