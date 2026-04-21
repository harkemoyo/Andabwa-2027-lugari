<?php

namespace App\Livewire\Pages;

use App\Models\SocialLink;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

use Livewire\Attributes\Layout;
#[Layout('components.layouts.app')]
class ServiceDetailPage extends Component
{
    public $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        return view('livewire.pages.service-detail-page');
    }
}