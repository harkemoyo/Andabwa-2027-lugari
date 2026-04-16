<?php

namespace App\Events;


use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Broadcasting\Channel;

class FooterUpdated implements ShouldBroadcastNow
{
    public function broadcastOn()
    {
        return new Channel('ui-updates');
    }

    public function broadcastAs()
    {
        return 'FooterUpdated';
    }
}




// use Illuminate\Foundation\Events\Dispatchable;
// use Illuminate\Queue\SerializesModels;
// use Illuminate\Broadcasting\InteractsWithSockets;
// use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
// use Illuminate\Foundation\Events\Dispatchable;
// use Illuminate\Queue\SerializesModels;

// class FooterInfoUpdated implements ShouldBroadcast
// {
//     use Dispatchable, InteractsWithSockets, SerializesModels;

//     public function __construct() {}

//     public function broadcastOn()
//     {
//         // public channel – consider private channel if sensitive
//         return ['footer_infos'];
//     }

//     public function broadcastAs()
//     {
//         return 'FooterInfoUpdated';
//     }
// }
