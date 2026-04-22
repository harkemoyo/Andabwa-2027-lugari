<?php 

namespace App\Livewire;


use App\Models\LiveEvents; // Note: Standard Laravel convention is singular (LiveEvent), but kept plural to match your setup
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class LiveEventList extends Component 
{
    use WithPagination;

    // Optional: Reset pagination when a new event is broadcasted
    #[On('LandingPageUpdated')]
    #[On('echo:landing-pages,LandingPageUpdated')]
    public function refreshLiveEvents(): void
    {
        // Simply resetting the page or doing nothing forces the render() method to re-run, 
        // fetching the freshest data automatically without breaking pagination.
        $this->resetPage(); 
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