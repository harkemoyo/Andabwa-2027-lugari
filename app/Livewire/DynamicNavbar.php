<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\NavigationMenu;
use Illuminate\Support\Facades\Cache;
use App\Models\BreakingNews;

class DynamicNavbar extends Component
{
    public $menus;
    public $breakingItems;

    protected $listeners = [
        'echo:ui-updates,MenusUpdated' => 'refreshMenus',
        'menu-updating' => 'updateMenuInstantly',
    ];

    /* ---------------- MENUS ---------------- */

    public function getMenus()
    {
        return NavigationMenu::with('itemsRecursive')
            ->where('is_active', true)
            ->orderBy('order')
            ->get();
    }

    public function refreshMenus()
    {
        Cache::forget('nav_menus');

        // ✅ FULL RELOAD (prevents UI corruption)
        $this->menus = $this->getMenus();
    }

    public function updateMenuInstantly($id, $title)
    {
        foreach ($this->menus as $menu) {
            foreach ($menu->items as $item) {
                if ($item->id === $id) {
                    $item->title = $title;
                }
            }
        }
    }

    /* ---------------- BREAKING ---------------- */

    #[On('echo:breaking-news,.breaking-news.updated')]
    public function loadBreakingItems()
    {
        $this->breakingItems = BreakingNews::active()
            ->orderByDesc('is_urgent')
            ->orderByDesc('priority')
            ->orderByDesc('ai_score')
            ->latest()
            ->limit(20)
            ->get();

        foreach ($this->breakingItems as $item) {
            $item->increment('views');
        }
    }

    public function hasBreaking(): bool
    {
        return $this->breakingItems?->isNotEmpty() ?? false;
    }

    public function getStatus($item)
    {
        if ($item->is_urgent) return 'URGENT';
        if ($item->is_live) return 'LIVE';
        if ($item->created_at->diffInMinutes() < 5) return 'NEW';

        return null;
    }

    public function trackClick($id)
    {
        if ($item = BreakingNews::find($id)) {
            $item->increment('clicks');
            $item->updateScore();
        }
    }

    /* ---------------- LIFECYCLE ---------------- */

    public function mount()
    {
        $this->menus = $this->getMenus();
        $this->loadBreakingItems();
    }

    public function hydrate()
    {
        $this->menus ??= collect();
        $this->breakingItems ??= collect();
    }

    public function render()
    {
        return view('livewire.dynamic-navbar');
    }
}