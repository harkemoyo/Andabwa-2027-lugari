<?php 

namespace App\Livewire;

use App\Models\LandingPage;
use Livewire\Component;
use Livewire\Attributes\Layout; // Import the Attribute


class LandingPageComponent extends Component
{
    public LandingPage $page;

    public function mount($slug)
    {
        // Fetch the page or throw a 404 error
        $this->page = LandingPage::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
    }

     #[Layout('layouts.app')] 
    public function render()
    {
        return view('livewire.landing-page-component');
    }   

}


