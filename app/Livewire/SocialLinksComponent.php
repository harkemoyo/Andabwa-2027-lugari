<?php

namespace App\Livewire;

use App\Models\SocialLink;
use Illuminate\Database\Eloquent\Collection;
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

    public function loadLinks()
    {
        $this->loading = true;

        $this->links = SocialLink::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

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