<?php 

namespace App\Livewire\Stream;

use App\Services\LivekitService;
use Livewire\Component;
use App\Models\Stream;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Firebase\JWT\JWT;

class ShowStream extends Component
{
    public Stream $stream;

    public $livekitToken;
    public $livekitUrl;
    public $isHost = false;
    public int $viewerCount = 0;

    public function mount($slug)
    {
        $this->stream = Stream::where('slug', $slug)->firstOrFail();

        // ✅ Determine host
        $this->isHost = Auth::id() === $this->stream->user_id;

        // ✅ Generate token using JWT directly (matching LivestreamRoom)
        $apiKey = config('services.livekit.api_key');
        $apiSecret = config('services.livekit.api_secret');

        $payload = [
            'iss' => $apiKey,
            'nbf' => time(),
            'iat' => time(),
            'exp' => time() + 3600,
            'sub' => (string) Auth::id(),
            'name' => Auth::user()->name ?? 'Viewer',
            'video' => [
                'roomJoin' => true,
                'room'     => (string) $this->stream->id,
                'canPublish' => $this->isHost,
                'canSubscribe' => true,
            ],
        ];

        $this->livekitToken = JWT::encode($payload, $apiSecret, 'HS256');
        $this->livekitUrl = config('services.livekit.url');
    }

    #[Computed]
    public function isLive()
    {
        return $this->stream->status === 'live';
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

    public function startStream()
    {
        if ($this->stream->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $this->stream->update([
            'status' => 'live',
            'started_at' => now(),
        ]);

        $this->stream->refresh();
    }

    public function markStreamAsEnded()
    {
        if ($this->stream->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $this->stream->update([
            'status' => 'ended',
            'ended_at' => now(),
        ]);

        return $this->redirect('/streams', navigate: true);
    }

    public function render()
    {
        return view('livewire.stream.show-stream');
    }
}