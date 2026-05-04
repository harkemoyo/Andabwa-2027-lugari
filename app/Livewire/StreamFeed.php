<?php

namespace App\Livewire;

use App\Models\Stream;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class StreamFeed extends Component
{
    #[On('echo-presence:stream,StreamUpdated')]
    #[On('echo-presence:stream,StreamCreated')]
    public function refreshFeed()
    {
        // Triggers a silent re-render when a stream goes live or ends
    }

    #[Computed]
    public function streams()
    {
        return Stream::with('host')
            ->whereIn('status', ['live', 'scheduled'])
            ->orderByRaw("status = 'live' DESC")
            ->latest()
            ->get();
    }

    public function getStreams()
{
    return Stream::with('user')
        ->where('status', 'live')
        ->latest()
        ->get();
}

    public function render()
    {
        return view('livewire.stream-feed');
    }
}
