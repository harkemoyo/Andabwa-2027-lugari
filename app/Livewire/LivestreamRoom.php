<?php

namespace App\Livewire;

use App\Events\StreamEnded;
use App\Models\Stream;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

#[Layout('layouts.app')]
class LivestreamRoom extends Component
{
    public Stream $stream;
    public bool $isHost;
    public int $viewerCount = 0;

    // public function mount(Stream $stream)
    // {
    //     $this->stream = $stream;
    //     $this->isHost = Auth::id() === $stream->user_id;
    // }

    public function mount(Stream $stream)
    {
        $this->stream = $stream;

        // Ensure both are cast to strings to avoid type-mismatch false negatives
        $this->isHost = Auth::check() && (string) Auth::id() === (string) $stream->user_id;
    }

    #[Computed]
    public function isLive()
    {
        return $this->stream->status === 'live';
    }

    public function startStream()
    {
        // Security check: Ensure ONLY the host can start the stream
        if ($this->stream->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Update the stream status in the database
        $this->stream->update([
            'status' => 'live',
            'started_at' => now(),
        ]);

        // Refresh the stream model to get updated status
        $this->stream->refresh();
    }

    #[On('echo-presence:stream.{stream.id},here')]
    public function updateViewerCount($users)
    {
        $this->viewerCount = count($users);
    }

    #[On('echo-presence:stream.{stream.id},joining')]
    public function incrementViewerCount()
    {
        $this->viewerCount++;
    }

    #[On('echo-presence:stream.{stream.id},leaving')]
    public function decrementViewerCount()
    {
        $this->viewerCount--;
    }

    #[Computed]
    public function livekitToken()
    {
        $apiKey = config('services.livekit.api_key');
        $apiSecret = config('services.livekit.api_secret');

        $payload = [
            'iss' => $apiKey,
            'nbf' => time(),
            'iat' => time(),
            'exp' => time() + 3600, // Token valid for 1 hour
            'sub' => (string) Auth::id(),
            'name' => Auth::user()->name ?? 'Viewer',
            'video' => [
                'roomJoin' => true,
                'room'     => (string) $this->stream->id,
                'canPublish' => $this->isHost,
                'canSubscribe' => true,
            ],
        ];

        return JWT::encode($payload, $apiSecret, 'HS256');
    }

    #[Computed]
    public function livekitUrl()
    {
        // Ensure you have LIVEKIT_URL in your .env (e.g., wss://your-project.livekit.cloud)
        return config('services.livekit.url');
    }


    // Add this method inside your LivestreamRoom class

    public function markStreamAsEnded()
    {
        // 1. Security check: Ensure ONLY the host can end the stream
        if ($this->stream->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // 2. Update the stream status in the database
        // Assuming you have 'ended_at' in your fillable array based on your Model
        $this->stream->update([
            'status' => 'ended',
            'ended_at' => now(),
        ]);

        // 3. Broadcast to any lingering viewers so their UI updates
        broadcast(new StreamEnded($this->stream->id))->toOthers();

        // 4. Redirect the host back to the stream feed (or dashboard)
        // Adjust the route name to match your actual feed route
        return $this->redirect('/streams', navigate: true);
    }





    public function saveChatMessage($content)
    {
        $this->validate(['chatInput' => 'max:500']);

        Message::create([
            'stream_id' => $this->stream->id,
            'user_id' => Auth::id(),
            'content' => $content,
        ]);
    }

    public function render()
    {
        return view('livewire.livestream-room');
    }
}
