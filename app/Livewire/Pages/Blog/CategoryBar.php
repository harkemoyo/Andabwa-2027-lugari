<?php

namespace App\Livewire\Pages\Blog;

use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;

class CategoryBar extends Component
{


    // The attribute MUST be directly above the property it manages
    #[Url(as: 'categoryId', history: true)]
    public ?int $activeCategory = null;

    public function mount($categoryId = null)
    {
        if ($categoryId) {
            $this->activeCategory = (int) $categoryId;
        }
    }

    // public function setCategory($id = null)
    // {
    //     $this->activeCategory = $id ? (int) $id : null;
        
    //     // Dispatches to your main post/project list component
    //     $this->dispatch('category-changed', categoryId: $this->activeCategory);
    // }

    public function setCategory($id = null)
{
    $this->activeCategory = $id;
    // This name must match the #[On('...')] attribute in AllProjects
    $this->dispatch('category-changed', categoryId: $id);
}

    #[Computed]
    public function categories()
    {
        return Category::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.pages.blog.category-bar');
    }
}