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
use Illuminate\Database\Eloquent\Builder;

#[Layout('components.layouts.app')]
class Feed extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public ?int $categoryId = null;

    #[Url]
    public int $perPage = 10;

    public int $loadedPages = 1;

    #[Url(except: null, history: true)]
    public ?int $tagId = null;

    public function resetFilters(): void
    {
        $this->reset(['search', 'categoryId', 'tagId']);
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
        $this->clearComputedCache();
        $this->resetPage();
        $this->dispatch('feed-refreshed');
    }

    #[On('post-updated')]
    public function onPostUpdated(): void
    {
        $this->clearComputedCache();
        $this->resetPage();
        $this->dispatch('feed-refreshed');
    }

    #[On('post.media-updated')]
    public function onMediaUpdated(): void
    {
        $this->clearComputedCache();
        $this->resetPage();
        $this->dispatch('feed-refreshed');
    }

    #[On('post.external-updated')]
    public function onExternalLinkUpdated(): void
    {
        $this->clearComputedCache();
        $this->resetPage();
        $this->dispatch('feed-refreshed');
    }

    #[On('settings-updated')]
    public function refreshPageSettings(): void
    {
        $this->clearComputedCache();
        unset($this->_computed['pageSettings']);
        $this->dispatch('feed-refreshed');
    }

    #[On('category-changed')]
    public function updateCategory($categoryId = null)
    {
        $this->categoryId = $categoryId;
        $this->resetPage();
    }

    /**
     * Clear all computed property caches to force fresh data fetch
     */
    private function clearComputedCache(): void
    {
        unset($this->_computed['posts']);
        unset($this->_computed['latestPosts']);
        unset($this->_computed['featuredPosts']);
        unset($this->_computed['categories']);
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
            ->latest('updated_at')
            ->take(8)
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


    #[Computed]
    public function latestPosts()
    {
        return $this->applySearchFilters(
            $this->buildBaseQuery()
        )
            ->limit($this->perPage * $this->loadedPages)
            ->latest('updated_at')
            ->take(8)
            ->get();
    }


    public function getLatestPostsProperty()
    {
        $query = $this->buildBaseQuery();
        $query = $this->applySearchFilters($query);

        return $query->take($this->perPage)->get();
    }



    public function loadMore(): void
    {
        $this->loadedPages += 1;
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->loadedPages = 1;
    }

    public function updatedCategoryId()
    {
        $this->resetPage();
        $this->loadedPages = 1;
    }

    private function baseQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Post::with(['category', 'media'])
            ->where('is_published', true)
            ->latest('created_at');
    }

    private function applyFilters(Builder $query): Builder
    {
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                    ->orWhere('content', 'like', "%{$this->search}%");
            });
        }

        if ($this->categoryId) {
            $query->where('category_id', $this->categoryId);
        }

        return $query;
    }

    #[Computed]
    public function posts()
    {
        return $this->applyFilters(
            $this->baseQuery()
        )
            ->limit($this->perPage * $this->loadedPages)
            ->get();
    }

    #[Computed]
    public function categories()
    {
        return Category::orderBy('name')->get();
    }

    #[Computed]
    public function pageSettings(): BlogPageSetting
    {
        return BlogPageSetting::first() ?? new BlogPageSetting();
    }

    #[Title('Blog Feed')]
    public function render()
    {
        return view('livewire.pages.blog.feed');
    }
}
