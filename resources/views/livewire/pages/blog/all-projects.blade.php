<div class="min-h-screen">



    <div class="max-w-7xl md:max-w-7xl lg:max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 mt-2 pb-20">

        {{-- HEADER SECTION --}}
        <div class="relative max-w-5xl mx-auto text-center pb-10  ">

            {{-- Soft Precision Background --}}
            <x-blog.soft-precision-background />


            <div class="max-w-sm mx-auto text-center  grid grid-cols-1 md:grid-cols-2 ">
                <div class="inline-flex items-center gap-3 px-6 py-2 bg-slate-100 rounded-full shadow-sm mt-2 mb-6">

                    <div class="relative h-2 w-2">
                        <span class="animate-ping absolute h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative h-2 w-2 rounded-full bg-emerald-500"></span>
                    </div>
                    <span class="text-[11px] font-bold tracking-widest uppercase text-slate-800 leading-tight">
                        {{ $this->pageSettings->posts_title ?? 'All Projects' }}
                    </span>
                </div>


                {{-- BACK TO HOME BUTTON --}}
                <div class="justfy-self-center md:justify mt-2 ">
                    <a href="{{ route('home') }}" wire:navigate class="px-4 py-1 shadow-sm inline-flex   hover:underline items-center text-sm font-medium text-green-600  mb-6 transition-colors px-4 py-2 bg-slate-100 rounded-full">
                        <svg class="w-4 h-4 mr-2 animate-ping" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>

                        <span class="text-[11px] font-bold tracking-widest uppercase text-slate-800 leading-tight">
                            {{ $this->pageSettings->editorial_button_text ?? 'Back to Editorial' }}
                        </span>

                    </a>
                </div>

            </div>

            <p class="text-lg md:text-xl font-medium text-slate-800 max-w-3xl mx-auto">
                Explore our complete collection of development initiatives and community projects for Lugari Constituency
            </p>

        </div>

        {{-- SEARCH + FILTER BAR --}}
        <div class="bg-white p-3 rounded-xl shadow-sm flex flex-col md:flex-row items-center gap-4 max-w-4xl mx-auto mb-10">

            {{-- Search --}}
            <div class="relative w-full md:flex-1">
                <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    placeholder="Search projects..."
                    class="w-full pr-12 pl-4 py-3 bg-white border rounded-lg text-sm text-slate-900 placeholder-slate-500
               focus:ring-2 focus:ring-emerald-500 focus:outline-none">

                <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-800">
                    🔍
                </span>
            </div>

            {{-- Category --}}
            <select
                wire:model.live="categoryId"
                class="w-full md:w-56 py-3 px-4 bg-white border rounded-lg text-sm text-slate-800
                       focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                <option value="">All Categories</option>
                @foreach($this->categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            {{-- Reset Button --}}
            <button
                wire:click="resetFilters"
                class="flex items-center justify-center px-6 py-3 bg-slate-100 text-slate-800 font-medium rounded-lg hover:bg-slate-500 transition-colors duration-200 shadow-sm whitespace-nowrap">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Reset
            </button>
        </div>

        {{-- ALL PROJECTS GRID --}}
        @if($this->posts->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
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