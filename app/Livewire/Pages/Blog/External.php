<?php

namespace App\Livewire\Pages\Blog;

use App\Models\Post;
use App\Models\BlogPageSetting;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

#[Layout('components.layouts.app')]
class External extends \Livewire\Component
{
    public $post;
    public $relatedPosts;

    public function mount($slug)
    {
        $this->post = Post::where('slug', $slug)
            ->with(['category', 'media'])
            ->firstOrFail();

        // Get related posts (same category, excluding current post)
        if ($this->post->category_id) {
            $this->relatedPosts = Post::where('category_id', $this->post->category_id)
                ->where('id', '!=', $this->post->id)
                ->where('is_published', true)
                ->whereNotIn('media_type', ['youtube', 'vimeo', 'video_embed'])
                ->whereNotNull('external_url')
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();
        } else {
            $this->relatedPosts = collect();
        }
    }

    /**
     * Page settings for blog
     */
    #[Computed]
    public function pageSettings(): BlogPageSetting
    {
        return BlogPageSetting::first() ?? new BlogPageSetting();
    }
}
