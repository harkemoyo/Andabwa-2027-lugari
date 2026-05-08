<?php

namespace App\Livewire\Pages;

use App\Models\Stream;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class HomePage extends Component
{
    public $scheduledStream = null;

    public function mount(): void
    {
        // Only load scheduled streams
        $this->scheduledStream = Stream::query()
            ->where('status', 'scheduled')
            ->latest('scheduled_for')
            ->first();
    }

    public function render()
    {
        return view('livewire.pages.home-page');
    }
}