<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\NavigationItem;

class MenusUpdated implements ShouldBroadcast
{
    public $item;

    public function __construct($item)
    {
        // 1. If it's explicitly a NavigationItem, load children safely
        if ($item instanceof NavigationItem) {
            $this->item = $item->loadMissing('children'); // loadMissing saves a query if already loaded
        } 
        // 2. If it's an array (passed from your model's saved events), cast to object for property access
        else {
            $this->item = is_array($item) ? (object) $item : $item;
        }
    }

    public function broadcastOn()
    {
        return new Channel('ui-updates');
    }

    public function broadcastWith()
    {
        // Null coalescing ensures arrays/unrelated models don't crash the payload build
        return [
            'id'       => $this->item->id ?? null,
            'title'    => $this->item->title ?? null,
            'children' => $this->item->children ?? [],
        ];
    }
}


