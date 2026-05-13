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

#[Layout('components.layouts.app')]
class AllProjects extends Component
{
    use WithPagination;

    protected string $paginationView = 'pagination::tailwind';
    protected string $pageName = 'page';

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


    #[On('category-changed')]
    public function updateCategory($categoryId = null): void
    {
        $this->categoryId = $categoryId ? (int) $categoryId : null;

        // Reset the pagination so if they are on page 3 and click a category,
        // it drops them back to page 1 of the new results.
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
        $this->dispatch('feed-refreshed');
    }

    /**
     * Categories for filter dropdown
     * Cached for better performance
     */
    #[Computed(cache: true, key: 'all-projects-categories-cache')]
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
     * Build the base query for all posts
     */
    private function buildBaseQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Post::with([
            'category:id,name,color',
            'media',
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
     * Get paginated posts for all projects view
     */
    #[Computed]
    public function posts(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = $this->buildBaseQuery();
        $query = $this->applySearchFilters($query);

        return $query->paginate(12)
            ->withPath(route('blog.all-projects'))
            ->appends(request()->query());
    }

    /**
     * Page settings for blog
     */
    #[Computed(cache: true, key: 'all-projects-page-settings-cache')]
    public function pageSettings(): BlogPageSetting
    {
        return BlogPageSetting::first() ?? new BlogPageSetting();
    }

    /**
     * Main render method
     */
    #[Title('All Projects | Andabwa Lugari Constituency Development')]
    public function render(): \Illuminate\View\View
    {
        return view('livewire.pages.blog.all-projects');
    }
}
