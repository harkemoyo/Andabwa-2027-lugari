<?php

namespace App\Livewire\Pages;

use App\Models\SocialLink;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

use Livewire\Attributes\Layout;
#[Layout('components.layouts.app')]
class ServicesPage extends Component
{

 public function render()
    {
        return view('livewire.pages.services-page');
    }
}