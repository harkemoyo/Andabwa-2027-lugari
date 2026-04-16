<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Livewire\Component;
use App\Models\NavigationMenu;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\BreakingNews;

class DynamicNavbar extends Component
{
    public $menus;
    public $breakingItems;

    /* ----------------------------
     |  MENUS
     |----------------------------*/
    public function loadMenus()
    {
        $this->menus = NavigationMenu::with([
            'items' => fn($q) => $q->where('is_active', true)
                ->where('is_breaking', true)
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                        ->orWhere('expires_at', '>', now());
                })
                ->orderByDesc('ai_score')
                ->orderByDesc('created_at'),
        ])->get();
    }

    /* ----------------------------
     |  LIFECYCLE
     |----------------------------*/
    public function mount()
    {
        $this->refreshMenus();
        $this->loadBreakingItems();
    }

    #[On('menuUpdated')]
    public function refreshMenus()
    {
        // Log::info('DynamicNavbar: menuUpdated event received');

        Cache::forget('nav_menus');

        $this->menus = NavigationMenu::with([
            'items.children' => fn($q) => $q->where('is_active', true)
        ])
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        $this->loadBreakingItems();

        // Log::info('DynamicNavbar: menus and breaking items refreshed');
    }

    /* ----------------------------
     |  BREAKING NEWS (FIXED)
     |----------------------------*/
    public function loadBreakingItems()
    {
        // ✅ KEEP YOUR SORTING LOGIC (FIXED - NO DUPLICATION)
        $this->breakingItems = BreakingNews::active()
            ->orderByDesc('is_urgent')
            ->orderByDesc('priority')
            ->orderByDesc('ai_score')
            ->latest()
            ->limit(20)
            ->get();

        // ⚠️ SAFE VIEW TRACKING (only once per load)
        foreach ($this->breakingItems as $item) {
            $item->increment('views');
        }
    }

    /* ----------------------------
     |  CLICK TRACKING
     |----------------------------*/
    public function trackClick($id)
    {
        $item = BreakingNews::find($id);

        if ($item) {
            $item->increment('clicks');
            $item->updateScore();
        }
    }

    /* ----------------------------
     |  STATUS HELPER (FIXED)
     |----------------------------*/
    public function getStatus($item)
    {
        if ($item->is_urgent) {
            return 'URGENT';
        }

        if ($item->is_live) {
            return 'LIVE';
        }

        if ($item->created_at->diffInMinutes() < 5) {
            return 'NEW';
        }

        return null;
    }

    /* ----------------------------
     |  BREAKING CHECK
     |----------------------------*/
    public function hasBreaking(): bool
    {
        return $this->breakingItems && $this->breakingItems->isNotEmpty();
    }

    /* ----------------------------
     |  HYDRATION SAFETY (IMPORTANT)
     |----------------------------*/
    public function hydrate()
    {
        $this->breakingItems ??= collect();
        $this->menus ??= collect();
    }

    /* ----------------------------
     |  RENDER
     |----------------------------*/
    public function render()
    {
        return view('livewire.dynamic-navbar');
    }
}

// namespace App\Livewire;

// use Livewire\Attributes\On;
// use Livewire\Attributes\Computed;
// use Livewire\Component;
// use App\Models\NavigationMenu;
// use Illuminate\Support\Facades\Cache;
// use Illuminate\Support\Facades\Log;
// use App\Models\BreakingNews;

// class DynamicNavbar extends Component
// {
//     public $menus; // Standard menus for the main navbar
//     public $breakingItems; // Breaking news items

//     public function loadMenus()
//     {
//         $this->menus = NavigationMenu::with([
//             'items' => fn($q) => $q->where('is_active', true)
//                 ->where('is_breaking', true)
//                 // ⏱ Auto-expire logic: Only show if expires_at is null OR in the future
//                 ->where(function ($query) {
//                     $query->whereNull('expires_at')
//                         ->orWhere('expires_at', '>', now());
//                 })
//                 // 🧠 Priority sorting: Highest score first, then newest
//                 ->orderByDesc('ai_score')
//                 ->orderByDesc('created_at'),
//         ])->get();
//     }

//     // #[On('menuUpdated')]
//     // public function mount()
//     // {
//     //     $this->refreshMenus();
//     //     $this->loadMenus();
//     // }

//     // public function refreshMenus()
//     // {
//     //     Cache::forget('nav_menus');
//     //     $this->menus = Cache::remember('nav_menus', 60, function () {
//     //         return NavigationMenu::with(['items.children' => fn($q) => $q->where('is_active', true)])
//     //             ->where('is_active', true)
//     //             ->orderBy('order')
//     //             ->get();
//     //     });
//     // }

//     // public function refreshMenusFromBroadcast()
//     // {
//     //     Cache::forget('nav_menus');
//     //     $this->refreshMenus();
//     //     $this->dispatch('menus-refreshed');
//     // }

//     // public function render()
//     // {
//     //     return view('livewire.dynamic-navbar');
//     // }




//     public function mount()
//     {
//         $this->refreshMenus();
//         $this->loadBreakingItems();
//     }

//     #[On('menuUpdated')]
//     public function refreshMenus()
//     {
//         Log::info('DynamicNavbar: menuUpdated event received');
//         Cache::forget('nav_menus');
//         $this->menus = NavigationMenu::with(['items.children' => fn($q) => $q->where('is_active', true)])
//             ->where('is_active', true)
//             ->orderBy('order')
//             ->get();
//         $this->loadBreakingItems();
//         Log::info('DynamicNavbar: menus and breaking items refreshed');
//     }

//     // public function loadBreakingItems()
//     // {
//     //     Log::info('DynamicNavbar: loading breaking items');
//     //     Cache::forget('breaking_items');
//     //     $menus = NavigationMenu::with([
//     //         'items' => fn($q) => $q->where('is_active', true)
//     //             ->where('breaking', true)
//     //             // ⏱ Auto-expire logic
//     //             ->where(function ($query) {
//     //                 $query->whereNull('expires_at')
//     //                     ->orWhere('expires_at', '>', now());
//     //             })
//     //             // 🧠 Priority sorting
//     //             ->orderByDesc('ai_score')
//     //             ->orderByDesc('created_at'),
//     //     ])->get();

//     //     $this->breakingItems = $menus->flatMap->items;

//     //     Log::info('DynamicNavbar: breaking items loaded', [
//     //         'count' => $this->breakingItems->count(),
//     //         'menus_count' => $menus->count(),
//     //         'debug' => $menus->map(fn($m) => [
//     //             'menu' => $m->name,
//     //             'items_count' => $m->items->count(),
//     //             'items' => $m->items->map(fn($i) => ['id' => $i->id, 'title' => $i->title, 'breaking' => $i->breaking, 'is_breaking' => $i->is_breaking, 'is_active' => $i->is_active])
//     //         ])
//     //     ]);
//     // }





//     public function loadBreakingItems()
//     {
//         $this->breakingItems = BreakingNews::active()
//             //     foreach ($this->breakingItems as $item) {
//             //     $item->increment('views');
//             // }
//             ->orderByDesc('is_urgent')
//             ->orderByDesc('priority')
//             ->orderByDesc('ai_score')
//             ->latest()
//             ->limit(20)
//             ->get();

//         $this->breakingItems = BreakingNews::active()->get();

//         foreach ($this->breakingItems as $item) {
//             $item->increment('views');
//         }
//     }




//     public function trackClick($id)
//     {
//         $item = BreakingNews::find($id);
//         if ($item) {
//             $item->increment('clicks');
//             $item->updateScore();
//         }
//     }

//     #[Computed]
//     public function getStatusAttribute()
//     {
//         if ($this->is_urgent) return 'URGENT';
//         if ($this->is_live) return 'LIVE';
//         if ($this->created_at->diffInMinutes() < 5) return 'NEW';

//         return null;
//     }

//     public function hasBreaking(): bool
//     {
//         return $this->breakingItems && $this->breakingItems->isNotEmpty();
//     }

//     public function render()
//     {
//         return view('livewire.dynamic-navbar');
//     }
// }
