<?php


namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\FooterInfo;
use App\Models\FooterCta;
use App\Models\SocialLink;
use Illuminate\Support\Facades\Cache;

class FooterSection extends Component
{
    public $footerInfo;
    public $footerCta;
    public $socialLinks;

    /**
     * FIX 1: Point the listener to 'loadFooterData' (the method that exists)
     * instead of 'refreshLogo' (which does not exist in this class).
     */
    protected $listeners = [
        'echo:ui-updates,FooterUpdated' => 'loadFooterData',
    ];

    public function mount()
    {
        $this->loadFooterData();
    }

    /**
     * FIX 2: Ensure the case matches the Event class name 'FooterUpdated'.
     * This handles local events dispatched within Livewire.
     */
    #[On('FooterUpdated')] 
    public function loadFooterData()
    {
        Cache::forget('social_links');
        $this->footerInfo = FooterInfo::first();
        $this->footerCta = FooterCta::first();
        $this->socialLinks = SocialLink::where('is_active', true)
            ->orderBy('order')
            ->get();
    }

    public function render()
    {
        return view('livewire.footer-section', [
            'footerInfo' => $this->footerInfo,
            'footerCta' => $this->footerCta,
            'socialLinks' => $this->socialLinks,
        ]);
    }
}