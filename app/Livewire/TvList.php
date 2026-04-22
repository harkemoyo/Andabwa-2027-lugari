<?php 

namespace App\Livewire;

use App\Models\TvChannels;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TvList extends Component 
{
    use WithPagination;

public TvChannels $tvChannel;
    protected $listeners = [
        'echo:landing-pages,LandingPageUpdated' => 'refreshTvChannel',
        'LandingPageUpdated' => 'refreshTvChannel',
    ];


    #[On('LandingPageUpdated')]
    public function refreshRadioChanne(): void
    {
        $this->tvChannel = TvChannels::where('is_published', $this->tvChannel->type)
            ->where('is_published', true)
            ->firstOrFail();
    }

    public function render() {
        return view('livewire.tv-list', [
            'tvChannels' => TvChannels::where('is_published', true)
                ->orderBy('created_at', 'desc')
                ->paginate(6)
        ]);
    }
}