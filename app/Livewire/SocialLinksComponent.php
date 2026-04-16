<?php

// namespace App\Livewire;

// use Livewire\Component;
// use App\Models\SocialLink;

// class SocialLinksComponent extends Component
// {
//     public $links = [];
//     public bool $isLoading = false;
//     public bool $hasError = false;

//     public function mount()
//     {
//         $this->loadLinks();
//     }

//     public function loadLinks(): void
//     {
//         try {
//             $this->isLoading = true;
//             $this->hasError = false;

//             $this->links = SocialLink::query()
//                 ->where('is_active', true)
//                 ->orderBy('order')
//                 ->get();

//         } catch (\Throwable $e) {
//             $this->hasError = true;
//             $this->links = [];
//         } finally {
//             $this->isLoading = false;
//         }
//     }

//     public function render()
//     {
//         return view('livewire.social-links-component');
//     }
// }






namespace App\Livewire;

use Livewire\Component;
use App\Models\SocialLink;

class SocialLinksComponent extends Component
{
    public $links = [];

    protected $listeners = [
        'echo:ui-updates,SocialLinksUpdated' => 'loadLinks',
    ];

    public function mount()
    {
        $this->loadLinks();
    }

    public function loadLinks()
    {
        $this->links = SocialLink::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->get();
    }

    public function render()
    {
        return view('livewire.social-links-component');
    }
}