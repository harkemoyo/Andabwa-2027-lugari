<?php


// namespace App\Livewire;

// use Livewire\Attributes\Layout;
// use Livewire\Component;
// use App\Models\Stream;
// use App\Services\LiveKitService;
// use Illuminate\Support\Facades\Auth;


// #[Layout('layouts.app')] 
// class StreamRoom extends Component
// {
//     public Stream $stream;

//     public string $token;        // ✅ match blade
//     public string $livekitUrl;

//     public bool $isHost;         // ✅ FIX 1

//     public int $viewerCount = 0;

//     public function mount(Stream $stream, LiveKitService $livekit)
//     {
//         $this->stream = $stream;

//         // ✅ determine host BEFORE using it
//         $this->isHost = Auth::id() === $stream->user_id;

//         $data = $livekit->generateToken(
//             Auth::user(),
//             $stream->uuid,
//             $this->isHost
//         );

//         // ✅ FIX 2: match property names
//         $this->token = $data['token'];
//         $this->livekitUrl = $data['url'];
//     }

//     protected $listeners = [
//         'viewerJoined' => 'incrementViewers',
//         'viewerLeft' => 'decrementViewers',
//     ];

//     public function incrementViewers()
//     {
//         $this->viewerCount++;
//     }

//     public function decrementViewers()
//     {
//         $this->viewerCount = max(0, $this->viewerCount - 1);
//     }

//     public function render()
//     {
//         return view('livewire.stream-room');
//     }
// }






namespace App\Livewire;

use Livewire\Component;
use App\Models\Stream;
use App\Services\LiveKitService;
use Illuminate\Support\Facades\Auth;
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
        $this->isHost = Auth::id() === $stream->user_id;

        $data = $livekit->generateToken(
            Auth::user(),
            $stream->uuid,
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