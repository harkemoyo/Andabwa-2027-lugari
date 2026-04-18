<?php 
namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class CategoryShowComponent extends Component
{
    public Category $category;

    public function mount($slug)
    {
        // Find the category by the slug passed in the URL, or throw a 404
        $this->category = Category::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.category-show-component');
    }
}