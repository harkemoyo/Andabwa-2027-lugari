<?php


namespace App\Livewire;
use Livewire\Component;
use App\Models\Stream;
use App\Services\LiveKitService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class StreamRoom extends Component
{
    public Stream $stream;
    public string $token;
    public string $livekitUrl;
    public bool $isHost; // Critical: initialized once

    public function mount(Stream $stream, LiveKitService $livekit)
    {
        $this->stream = $stream;
        
        // Check if user is authenticated, otherwise use guest user
        $user = Auth::check() ? Auth::user() : null;
        $this->isHost = $user && $user->id === $stream->user_id;

        // Debug logging
        logger('StreamRoom: isHost = ' . ($this->isHost ? 'true' : 'false') . ', userId = ' . ($user ? $user->id : 'null') . ', streamUserId = ' . $stream->user_id);

        // Use livekit_room if available, otherwise use uuid, otherwise use id
        $room = $stream->livekit_room ?? $stream->uuid ?? (string) $stream->id;

        $data = $livekit->generateToken(
            $user,
            $room,
            $this->isHost
        );

        $this->token = $data['token'];
        $this->livekitUrl = $data['url'];
    }

    

    public function render()
    {
        return view('livewire.stream-room');
    }
}