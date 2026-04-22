<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\NavigationMenu;
use Illuminate\Support\Facades\Cache;
use App\Models\BreakingNews;
use App\Models\Category;
use Livewire\Attributes\Computed;

class DynamicNavbar extends Component
{
    public $menus;
    public $breakingItems;

    // protected $listeners = [
    //     'echo:ui-updates,MenusUpdated' => 'refreshMenus',
    //     'menu-updating' => 'updateMenuInstantly',
    // ];

    protected $listeners = [
    'echo:ui-updates,MenusUpdated' => 'applyMenuPatch',
];


public function applyMenuPatch($payload)
{
    if (!$this->menus) return;

    foreach ($this->menus as $menu) {
        foreach ($menu->items as $item) {

            // 🔥 MATCH ITEM
            if ($item->id === ($payload['id'] ?? null)) {

                // DELETE
                if (!empty($payload['deleted'])) {
                    $menu->items = $menu->items->reject(fn ($i) => $i->id === $item->id);
                    return;
                }

                // UPDATE TITLE (optimistic safe)
                if (isset($payload['title'])) {
                    $item->title = $payload['title'];
                }

                // 🔥 PATCH CHILDREN (NO REPLACEMENT)
                if (isset($payload['children'])) {
                    $this->patchChildren($item, $payload['children']);
                }

                return;
            }

            // 🔁 SEARCH IN CHILDREN (recursive safe)
            $this->patchNested($item, $payload);
        }
    }
}

protected function patchNested($parent, $payload)
{
    foreach ($parent->children as $child) {

        if ($child->id === ($payload['id'] ?? null)) {

            if (!empty($payload['deleted'])) {
                $parent->children = $parent->children->reject(fn ($c) => $c->id === $child->id);
                return;
            }

            if (isset($payload['title'])) {
                $child->title = $payload['title'];
            }

            return;
        }

        // go deeper
        $this->patchNested($child, $payload);
    }
}

protected function patchChildren($item, $childrenPayload)
{
    $existing = $item->children;

    foreach ($childrenPayload as $incoming) {

        $match = $existing->firstWhere('id', $incoming['id'] ?? null);

        if ($match) {
            // update only changed fields
            if (isset($incoming['title'])) {
                $match->title = $incoming['title'];
            }
        } else {
            // add new child (no reload needed)
            $existing->push((object) $incoming);
        }
    }

    $item->children = $existing;
}

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
    // Match the channel name and broadcastAs name exactly
    #[On('echo:breaking-news,breaking.updated')]
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

    /**
     * Fetch categories for the desktop category bar
     */
    #[Computed]
    public function categories()
    {
        return Category::select('id', 'name')
            ->whereHas('posts', function ($query) {
                $query->where('is_published', true);
            })
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('livewire.dynamic-navbar');
    }
}
