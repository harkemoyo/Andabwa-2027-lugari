<?php

namespace App\Livewire;

use App\Models\SocialLink;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;

class SocialLinksComponent extends Component
{
    public $links = [];
    public $loading = true;

    protected $listeners = [
        'echo:ui-updates,SocialLinksUpdated' => 'reload',
        'FooterUpdated' => 'loadLinks',
        'SocialLinksUpdated' => 'loadLinks',
    ];

    public function mount()
    {
        $this->loadLinks();
    }

    #[On('FooterUpdated')]
    #[On('SocialLinksUpdated')]
    public function loadLinks()
    {
        Cache::forget('social_links');
        
        $this->links = SocialLink::where('is_active', true)
            ->orderBy('order')
            ->get();
            
        // FIX: Disable the skeleton loader once data is populated
        $this->loading = false;
    }

    public function reload()
    {
        $this->loadLinks();
    }

    public function render()
    {
        return view('livewire.social-links-component');
    }
}