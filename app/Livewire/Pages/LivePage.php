<?php

namespace App\Livewire\Pages;

use App\Models\SocialLink;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
#[Layout('components.layouts.app')]
class LivePage extends Component
{

 public function render()
    {
        return view('livewire.pages.live-page');
    }
}