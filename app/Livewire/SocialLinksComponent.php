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
    ];

    public function mount()
    {
        $this->loadLinks();
    }

    #[On('footerUpdated')]
    public function loadLinks()
    {
        Cache::forget('social_links');
        $this->links = SocialLink::where('is_active', true)
            ->orderBy('order')
            ->get();
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