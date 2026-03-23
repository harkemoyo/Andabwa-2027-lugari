<?php

// app/Livewire/Pages/Blog/Show.php

namespace App\Livewire\Pages\Blog;

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Actions\GenerateSeoTags; // Using the Action from earlier
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Show extends Component
{
    public Post $post;
    public array $seo;

    public function mount(Post $post): void
    {
        // Route Model Binding handles finding the post by slug automatically
        $this->post = $post;
        
        // Generate SEO metadata for the head
        $this->seo = app(GenerateSeoTags::class)->execute($post);
    }

    #[Title('Andabwa Lugari Constituency Development Projects - {{ $post->title }}')] 
    public function render()
    {
        return view('livewire.pages.blog.show');
    }

    

// ... inside your Show class

#[Computed]
public function relatedPosts()
{
    return Post::with('category')
        ->where('is_published', true)
        ->where('category_id', $this->post->category_id)
        ->where('id', '!=', $this->post->id) // Don't show the current post
        ->latest()
        ->take(3)
        ->get();
}
}