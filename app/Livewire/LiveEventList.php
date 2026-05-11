<?php

namespace App\Livewire;

use App\Models\LiveEvents;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class LiveEventList extends Component
{
    use WithPagination;

    protected $listeners = [
        'echo:landing-pages,LandingPageUpdated' => 'refreshLiveEvent',
        'LandingPageUpdated' => 'refreshLiveEvent',
    ];

    #[On('LandingPageUpdated')]
    public function refreshLiveEvent(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $activeStream = LiveEvents::where('is_published', true)
            ->where(function ($query) {
                $query->whereNull('scheduled_at')
                    ->orWhere('scheduled_at', '<=', now());
            })
            ->latest()
            ->first();

        $scheduledStream = LiveEvents::where('is_published', true)
            ->whereNotNull('scheduled_at')
            ->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at')
            ->first();

        return view('livewire.live-event-list', [
            'activeStream' => $activeStream,

            'scheduledStream' => $scheduledStream,

            'liveEvents' => LiveEvents::where('is_published', true)
                ->latest()
                ->paginate(6),
        ]);
    }
}
