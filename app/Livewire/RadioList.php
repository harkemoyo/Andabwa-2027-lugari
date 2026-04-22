<?php 

namespace App\Livewire;

use App\Models\RadioChannels;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class RadioList extends Component 
{
    use WithPagination;

public RadioChannels $radioChannel;
    protected $listeners = [
        'echo:landing-pages,LandingPageUpdated' => 'refreshRadioChannel',
        'LandingPageUpdated' => 'refreshRadioChannel',
    ];


    #[On('LandingPageUpdated')]
    public function refreshRadioChanne(): void
    {
        $this->radioChannel = RadioChannels::where('is_published', $this->radioChannel->type)
            ->where('is_published', true)
            ->firstOrFail();
    }

    public function render() {
        return view('livewire.radio-list', [
            'radioChannels' => RadioChannels::where('is_published', true)
                ->orderBy('created_at', 'desc')
                ->paginate(6)
        ]);
    }
}