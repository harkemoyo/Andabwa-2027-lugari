<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\FooterInfo;
use App\Models\FooterCta;
use App\Models\SocialLink;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class FooterSection extends Component
{
    public $footerInfo;
    public $footerCta;
    public $socialLinks;

    public function mount()
    {
        $this->loadFooterData();
    }

    #[On('footerUpdated')]
    #[On('socialLinkUpdated')]
    public function loadFooterData()
    {
        Log::info('FooterSection: event received, loading footer data');
        Cache::forget('social_links');
        $this->footerInfo = FooterInfo::first();
        $this->footerCta = FooterCta::first();
        $this->socialLinks = SocialLink::where('is_active', true)
            ->orderBy('order')
            ->get();
        Log::info('FooterSection: footer data loaded', ['social_links_count' => $this->socialLinks->count()]);
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
