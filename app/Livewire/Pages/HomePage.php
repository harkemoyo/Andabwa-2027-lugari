<?php

namespace App\Livewire\Pages;

use App\Models\SocialLink;
use App\Models\Stream;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;


#[Layout('components.layouts.app')]
class HomePage extends Component
{
    public $activeStream;

    public function mount()
    {
        // Get the first active live stream
        $this->activeStream = Stream::where('status', 'live')->first();
    }

 public function render()
    {
        return view('livewire.pages.home-page');
    }
}