<?php

namespace App\Events;

use App\Models\Stream;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StreamStarted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Stream $stream) {}

    public function broadcastOn(): array
    {
        // Broadcast to a public 'streams' channel
        return [new Channel('streams')];
    }

    public function broadcastWith(): array
    {
        return ['stream_id' => $this->stream->id, 'title' => $this->stream->title];
    }
}