<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Database\Eloquent\Collection;

class CategoryBarComponent extends Component
{
    public Collection $categories;

    public function mount(): void
    {
        $this->refreshCategories();
    }

    /**
     * Listen for the Broadcast event.
     * The dot (.) before category.updated is required for custom event names.
     */
    #[On('echo:categories,.category.updated')]
    public function refreshCategories(): void
    {
        $this->categories = Category::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }


      // Listen for the 'refresh-navigation' event sent from Filament or other components
    #[On('refresh-navigation')] 
    public function render()
    {
        return view('livewire.category-bar-component', [
            'categories' => Category::where('is_active', true)
                ->orderBy('sort_order')
                ->get()
        ]);
    }

    
}



