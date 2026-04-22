<?php

namespace App\Livewire;

use App\Models\LandingPage;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')] // Adjust if your main layout file has a different name
class DynamicLandingPage extends Component
{
    public LandingPage $landingPage;

    public function mount(string $slug)
    {
        // 🔥 ENGINEER STANDARD: firstOrFail() automatically aborts with a 404 if not found
        $this->landingPage = LandingPage::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

            
    }

    public function render()
    {
        return view('livewire.dynamic-landing-page')
            ->title($this->landingPage->title); // Dynamically injects into your layout's <title>
    }
}