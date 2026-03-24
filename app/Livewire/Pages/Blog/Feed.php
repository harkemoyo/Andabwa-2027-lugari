<?php

namespace App\Livewire\Pages\Blog;

use App\Models\BlogPageSetting;
use App\Models\Category;
use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Feed extends Component
{
    use WithPagination;

    #[Url(except: '', history: true)]
    public string $search = '';

    #[Url(except: null, history: true)]
    public ?int $categoryId = null;

    #[Url(except: null, history: true)]
    public ?int $tagId = null;

    public function resetFilters(): void
    {
        $this->reset(['search', 'categoryId', 'tagId']);
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategoryId(): void
    {
        $this->resetPage();
    }

    public function updatedTagId(): void
    {
        $this->resetPage();
    }

    /**
     * Real-time feed refresh events
     */
    #[On('echo:blog-feed,PostUpdated')]
    public function refreshFeed(): void
    {
        $this->resetPage();
        $this->dispatch('feed-refreshed');
    }

    #[On('post-updated')]
    public function onPostUpdated(): void
    {
        $this->resetPage();
        $this->dispatch('feed-refreshed');
    }

    #[On('post.media-updated')]
    public function onMediaUpdated(): void
    {
        $this->resetPage();
        $this->dispatch('feed-refreshed');
    }

    #[On('post.external-updated')]
    public function onExternalLinkUpdated(): void
    {
        $this->resetPage();
        $this->dispatch('feed-refreshed');
    }

    #[On('settings-updated')]
    public function refreshPageSettings(): void
    {
        unset($this->_computed['pageSettings']);
        $this->dispatch('feed-refreshed');
    }

    /**
     * Categories for filter dropdown
     * No caching - real-time data
     */
    #[Computed]
    public function categories(): \Illuminate\Database\Eloquent\Collection
    {
        return Category::select('id', 'name')
            ->whereHas('posts', function ($query) {
                $query->where('is_published', true);
            })
            ->orderBy('name')
            ->get();
    }

    /**
     * Featured posts for hero section
     * Optimized query with proper eager loading
     */
    #[Computed]
    public function featuredPosts(): \Illuminate\Database\Eloquent\Collection
    {
        return Post::with([
                'category:id,name',
                'media' => function ($query) {
                    $query->where('collection_name', 'featured');
                },
                'tags:id,name'
            ])
            ->where('is_published', true)
            ->where('is_featured', true)
            ->latest('created_at')
            ->take(2)
            ->get();
    }

    /**
     * Build the base query for posts
     */
    private function buildBaseQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Post::with([
                'category:id,name',
                'media' => function ($query) {
                    $query->where('collection_name', 'featured');
                },
                'tags:id,name'
            ])
            ->where('is_published', true)
            ->latest('created_at');
    }

    /**
     * Apply search filters to query
     */
    private function applySearchFilters(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'LIKE', '%' . $this->search . '%')
                  ->orWhere('content', 'LIKE', '%' . $this->search . '%')
                  ->orWhere('meta_title', 'LIKE', '%' . $this->search . '%')
                  ->orWhere('meta_description', 'LIKE', '%' . $this->search . '%');
            });
        }

        if ($this->categoryId) {
            $query->where('category_id', $this->categoryId);
        }

        if ($this->tagId) {
            $query->whereHas('tags', function ($q) {
                $q->where('tags.id', $this->tagId);
            });
        }

        return $query;
    }

    /**
     * Get latest 3 posts for homepage display (non-paginated)
     */
    #[Computed]
    public function latestPosts(): \Illuminate\Database\Eloquent\Collection
    {
        $query = $this->buildBaseQuery();
        $query = $this->applySearchFilters($query);
        
        return $query->take(3)->get();
    }

    /**
     * Get paginated posts for main feed (excluding latest 3)
     * Direct database query - no cache service
     */
    #[Computed]
    public function posts(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = $this->buildBaseQuery();
        $query = $this->applySearchFilters($query);
        
        // Exclude the latest 3 posts to avoid duplication
        $latestPostIds = $this->latestPosts->pluck('id');
        if ($latestPostIds->isNotEmpty()) {
            $query->whereNotIn('id', $latestPostIds);
        }

        return $query->paginate(12);
    }

    /**
     * Page settings for blog
     */
    #[Computed]
    public function pageSettings(): BlogPageSetting
    {
        return BlogPageSetting::first() ?? new BlogPageSetting();
    }

    /**
     * Main render method - clean and efficient
     */
    #[Title('Andabwa Lugari Constituency Development Projects - Blog Feed')]
    public function render(): \Illuminate\View\View
    {
        return view('livewire.pages.blog.feed', [
            'latestPosts' => $this->latestPosts,
            'posts' => $this->posts,
        ]);
    }
}
