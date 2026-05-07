<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\Stream;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Chat extends Component
{
    public string $room;
    public string $message = '';
    public array $messages = [];
    public ?int $streamId = null;

    public function mount($room)
    {
        $this->room = $room;

        // Find the stream by room identifier (livekit_room is string, uuid is uuid type)
        $query = Stream::where('livekit_room', $room);

        // Only check uuid column if room looks like a valid UUID to avoid PostgreSQL type error
        if (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $room)) {
            $query->orWhere('uuid', $room);
        }

        $stream = $query->first();

        if ($stream) {
            $this->streamId = $stream->id;
            // Load existing messages
            $this->loadMessages();
        }
    }

    public function loadMessages()
    {
        if (!$this->streamId) {
            return;
        }

        $dbMessages = Message::with('user')
            ->where('stream_id', $this->streamId)
            ->orderBy('created_at', 'asc')
            ->take(100)
            ->get();

        $this->messages = $dbMessages->map(function ($msg) {
            return [
                'user' => $msg->user?->name ?? 'Guest',
                'text' => $msg->body,
                'time' => $msg->created_at->format('H:i'),
            ];
        })->toArray();
    }

    public function sendMessage()
    {
        if (trim($this->message) === '') return;

        $user = Auth::user();
        $userName = $user?->name ?? 'Guest';

        // Persist to database if we have a stream
        if ($this->streamId && $user) {
            Message::create([
                'stream_id' => $this->streamId,
                'user_id' => $user->id,
                'body' => $this->message,
            ]);
        }

        $this->messages[] = [
            'user' => $userName,
            'text' => $this->message,
            'time' => now()->format('H:i'),
        ];

        $this->message = '';
    }

    public function render()
    {
        return view('livewire.chat');
    }
}