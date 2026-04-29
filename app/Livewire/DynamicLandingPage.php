<?php

namespace App\Livewire;

use App\Models\LandingPage;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')] 
class DynamicLandingPage extends Component
{
    public LandingPage $landingPage;

    protected $listeners = [
        'echo:landing-pages,LandingPageUpdated' => 'refreshPage',
        'LandingPageUpdated' => 'refreshPage',
    ];

    public function mount(string $slug)
    {
        $this->landingPage = LandingPage::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
    }

    #[On('LandingPageUpdated')]
    public function refreshPage(): void
    {
        // Reload fresh model from DB (same logic, safer)
        $this->landingPage = LandingPage::find($this->landingPage->id);

        if (!$this->landingPage || !$this->landingPage->is_active) {
            abort(404);
        }
    }

    public function render()
    {
        return view('livewire.dynamic-landing-page');
    }
}

// namespace App\Livewire;

// use App\Models\LandingPage;
// use Livewire\Component;
// use Livewire\Attributes\Layout;
// use Livewire\Attributes\On;

// #[Layout('layouts.app')] 
// class DynamicLandingPage extends Component
// {
//     public LandingPage $landingPage;

//     protected $listeners = [
//         'echo:landing-pages,LandingPageUpdated' => 'refreshPage',
//         'LandingPageUpdated' => 'refreshPage',
//     ];

//     public function mount(string $slug)
//     {
//         $this->landingPage = LandingPage::where('slug', $slug)
//             ->active()
//             ->firstOrFail();
//     }

//     #[On('LandingPageUpdated')]
//     public function refreshPage(): void
//     {
//         // ENGINEER FIX: Specifically refresh the existing model instance
//         $this->landingPage->refresh(); 
        
//         // Safety check if visibility changed
//         if (!$this->landingPage->is_active) {
//             abort(404);
//         }
//     }

//     public function render()
//     {
//         return view('livewire.dynamic-landing-page');
//     }
// }

