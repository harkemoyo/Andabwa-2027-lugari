<?php

namespace App\Livewire;

use App\Models\LandingPage;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')] // Adjust if your main layout file has a different name
class DynamicLandingPage extends Component
{
    public LandingPage $landingPage;

    protected $listeners = [
        'echo:landing-pages,LandingPageUpdated' => 'refreshPage',
        'LandingPageUpdated' => 'refreshPage',
    ];

    public function mount(string $slug)
    {
        // ENGINEER STANDARD: firstOrFail() automatically aborts with a 404 if not found
        $this->landingPage = LandingPage::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

    }

    #[On('LandingPageUpdated')]
    public function refreshPage(): void
    {
        $this->landingPage = LandingPage::where('slug', $this->landingPage->slug)
            ->where('is_active', true)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.dynamic-landing-page');
    }
}