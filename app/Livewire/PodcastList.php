<?php 

namespace App\Livewire;

use App\Models\Podcast;
use App\Models\Stream;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class PodcastList extends Component 
{
    use WithPagination;

public Podcast $podcast;
    protected $listeners = [
        'echo:landing-pages,LandingPageUpdated' => 'refreshPodcast',
        'LandingPageUpdated' => 'refreshPodcast',
    ];


    #[On('LandingPageUpdated')]
    public function refreshPodcast(): void
    {
        $this->podcast = Podcast::where('is_published', $this->podcast->type)
            ->where('is_published', true)
            ->firstOrFail();
    }

    public function render() {
        return view('livewire.podcast-list', [
            'podcasts' => Podcast::where('is_published', true)
                ->orderBy('created_at', 'desc')
                ->paginate(6),
            'streams' => Stream::where('status', 'live')
                ->with('host')
                ->orderBy('created_at', 'desc')
                ->get()
        ]);
    }
}