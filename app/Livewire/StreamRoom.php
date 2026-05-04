<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Stream;
use App\Services\LiveKitService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class StreamRoom extends Component
{
    public Stream $stream;

    public string $token;
    public string $livekitUrl;

    public int $viewerCount = 0;

    public function mount(Stream $stream)
    {
        $this->stream = $stream;

        $livekit = app(LiveKitService::class)->token(
            Auth::user(),
            $stream->livekit_room,
            Auth::id() === $stream->user_id // host check
        );

        $this->token = $livekit['token'];
        $this->livekitUrl = $livekit['url'];
    }

    protected $listeners = [
        'viewerJoined' => 'incrementViewers',
        'viewerLeft' => 'decrementViewers',
    ];

    // public function incrementViewers()
    // {
    //     $this->viewerCount++;
    // }

    // public function decrementViewers()
    // {
    //     $this->viewerCount = max(0, $this->viewerCount - 1);
    // }

    

    public function incrementViewers()
    {
        Cache::increment("stream:{$this->stream->id}:viewers");
        $this->viewerCount = Cache::get("stream:{$this->stream->id}:viewers");
    }

    public function decrementViewers()
    {
        Cache::decrement("stream:{$this->stream->id}:viewers");
        $this->viewerCount = max(0, Cache::get("stream:{$this->stream->id}:viewers"));
    }

    public function render()
    {
        return view('livewire.stream-room');
    }
}
