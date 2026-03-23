<?php

namespace App\Livewire\Pages\Blog;

use App\Models\BlogPageSetting;
use App\Models\Category;
use App\Models\Post;
use App\Services\FeedCacheService;
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

    #[On('echo:blog-feed,PostUpdated')]
    public function refreshFeed(): void
    {
        $this->resetPage();
    }




    /**
     * Categories for the filter dropdown
     */
    #[Computed(persist: true, seconds: 43200)]
    public function categories()
    {
        return Category::select('id', 'name')->orderBy('name')->get();
    }

    /**
     * Featured Posts (The top section)
     * CRUCIAL: Added ->with('media') so the photos actually show up.
     */
    #[Computed(persist: true, seconds: 3600)]
    public function featuredPosts()
    {
        return Post::with(['category', 'media']) // Eager load media here
            ->where('is_published', true)
            ->where('is_featured', true)
            ->latest()
            ->take(2)
            ->get();
    }

    /**
     * Main Feed Render
     * If you are using FeedCacheService, ensure THAT service also uses ->with('media')
     */
    #[Title('Andabwa Lugari Constituency Development Projects - Blog Feed')]
    public function render(FeedCacheService $cache)
    {
        // Option A: If using your Cache Service (Recommended)
        // Ensure FeedCacheService::getPaginatedFeed includes ->with('media') in its internal query
        $posts = $cache->getPaginatedFeed(
            page: $this->getPage(),
            search: $this->search,
            categoryId: $this->categoryId,
            tagId: $this->tagId
        );

        return view('livewire.pages.blog.feed', [
            'posts' => $posts
        ]);
    }



    // Add this computed property to fetch the settings without breaking your existing logic
    #[Computed]
    public function pageSettings()
    {
        // If the database has a row, it returns it.
        // If it is null (empty table), it creates a new temporary instance in memory.
        // This new instance automatically uses the default text you defined in your migration!
        return BlogPageSetting::first() ?? new BlogPageSetting();
    }

    // Add listener for real-time updates when settings are changed
    #[On('settings-updated')]
    public function refreshPageSettings(): void
    {
        // Clear the computed property cache
        unset($this->pageSettings);
    }
}
