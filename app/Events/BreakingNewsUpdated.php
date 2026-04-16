<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Events\BreakingNewsUpdated as Breaking;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// class BreakingNewsUpdated
// {
//     use Dispatchable, InteractsWithSockets, SerializesModels;

//     /**
//      * Create a new event instance.
//      */
//     public function __construct()
//     {
//         //
//     }

//     /**
//      * Get the channels the event should broadcast on.
//      *
//      * @return array<int, Channel>
//      */
//     public function broadcastOn()
//     {
//         // public channel – consider private channel if sensitive
//         return ['breaking_news'];
//     }

//     public function broadcastAs()
//     {
//         return 'BreakingNewsUpdated';
//     }
// }


// app/Events/BreakingNewsUpdated.php

class BreakingNewsUpdated implements ShouldBroadcast
{
    public function broadcastOn()
    {
        return new Channel('breaking-news');
    }

    public function broadcastAs()
    {
        return 'breaking.updated';
    }
}