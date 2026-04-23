<?php

namespace App\Livewire;

use App\Models\LiveEvents;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class LiveEventList extends Component
{
    use WithPagination;

    public LiveEvents $liveEvent;
    protected $listeners = [
        'echo:landing-pages,LandingPageUpdated' => 'refreshLiveEvent',
        'LandingPageUpdated' => 'refreshLiveEvent',
    ];


    #[On('LandingPageUpdated')]
    public function refreshRadioChanne(): void
    {
        $this->liveEvent = LiveEvents::where('is_published', $this->liveEvent->type)
            ->where('is_published', true)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.live-event-list', [
            'liveEvents' => LiveEvents::where('is_published', true)
                ->orderBy('created_at', 'desc')
                ->paginate(6)
        ]);
    }
}
