<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\NavigationLogoHeader;
use Illuminate\Support\Facades\Cache;

class NavigationLogoHeaderComponent extends Component
{
    public ?string $logo = null;
    public ?string $link = null;
    public bool $isLoading = false;
    public bool $hasError = false;



    protected $listeners = [
        'echo:ui-updates,FooterUpdated' => 'refreshLogo',
        'FooterUpdated' => 'refreshLogo',
    ];

    public function mount(): void
    {
        $this->refreshLogo();
    }

    #[On('FooterUpdated')]
    public function refreshLogo(): void
    {
        try {
            $this->isLoading = true;
            $this->hasError = false;

            // Fetch without cache for real-time updates
            $record = NavigationLogoHeader::first();

            if ($record) {
                $this->logo = $record->full_logo_path;
                $this->link = $record->full_link_url ?? '/';
            } else {
                $this->logo = null;
                $this->link = '/';
            }
        } catch (\Exception $e) {
            $this->hasError = true;
            $this->logo = null;
            $this->link = '/';
        } finally {
            $this->isLoading = false;
        }
    }

   
    public function render()
    {
        return view('livewire.navigation-logo-header-component');
    }
}
