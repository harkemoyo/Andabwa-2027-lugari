<div class="min-h-screen">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-8">

        {{-- HEADER SECTION --}}
        <div class="relative max-w-5xl mx-auto text-center   ">
            {{-- Soft Precision Background --}}
            <x-blog.soft-precision-background />
        </div>

        {{-- ALL PROJECTS GRID --}}
        @if($this->posts->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 ">
            @foreach($this->posts as $post)
            <div class="relative group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col">
                @if($post->external_url && \App\Enums\MediaType::isExternal($post->media_type))
                <a href="{{ route('blog.external', $post->slug) }}" class="block flex-1 flex flex-col">
                    @else
                    <a href="{{ route('posts.show', $post->slug) }}" class="block flex-1 flex flex-col">
                        @endif
                        <div class="flex flex-col h-full">
                            {{-- Media --}}
                            <div class="aspect-video overflow-hidden bg-slate-100">
                                <x-blog.media :post="$post" />
                            </div>

                            {{-- Content --}}
                            <div class="p-5 flex flex-col flex-1">
                                <div class="flex items-center gap-2 mb-3">
                                    @if($post->category)
                                    <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">
                                        {{ $post->category->name }}
                                    </span>
                                    @endif
                                    <span class="text-xs text-slate-500 whitespace-nowrap">
                                        {{ $post->created_at->format('M j, Y') }}
                                    </span>
                                </div>

                                <h3 class="text-lg font-bold text-slate-900 mb-2 line-clamp-2 group-hover:text-emerald-600 transition-colors flex-1">
                                    {{ $post->title }}
                                </h3>

                                @if($post->meta_description)
                                <p class="text-sm text-slate-600 line-clamp-2 mb-4">
                                    {{ $post->meta_description }}
                                </p>
                                @endif

                                <span class="text-emerald-600 font-semibold text-sm group-hover:text-emerald-700 transition-colors mt-auto">
                                    Read More →
                                </span>
                            </div>
                        </div>
                    </a>
            </div>
            @endforeach
        </div>

        {{-- PAGINATION --}}
        @if($this->posts->hasPages())
        <div class="flex justify-center mb-8">
            {{ $this->posts->links('pagination::tailwind') }}
        </div>
        @endif
        @else
        <div class="text-center py-20">
            <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-lg text-slate-600 mb-4">No projects found</p>
            <p class="text-slate-500 mb-6">Try adjusting your search or filter criteria</p>
            <button
                wire:click="resetFilters"
                class="px-6 py-2 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition-colors">
                Clear Filters
            </button>
        </div>
        @endif

    </div>
</div>