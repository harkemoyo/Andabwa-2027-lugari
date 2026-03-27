<div class="min-h-screen bg-slate-50">

    {{-- Adjusted top padding from py-20 to pt-12 pb-20 --}}
    <div class="max-w-7xl md:max-w-7xl lg:max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-20">

        {{-- HEADER SECTION --}}
        {{-- Increased pb-4 to pb-10 for better balance with the search bar below --}}
        <div class="relative max-w-5xl mx-auto text-center pb-10">

            {{-- Soft Precision Background --}}
            <div class="absolute inset-0 -z-10 opacity-10 pointer-events-none" style="background-image: radial-gradient(circle, #101111 2px, transparent 2px);
                       background-size: 24px 24px;">
            </div>

            {{-- Badge - Added mt-2 and increased mb to 6 for better vertical rhythm --}}
            <div class="inline-flex items-center gap-3 px-6 py-2 bg-slate-100 rounded-full shadow-sm mt-2 mb-6">
                <div class="relative h-2 w-2">
                    <span class="animate-ping absolute h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative h-2 w-2 rounded-full bg-emerald-500"></span>
                </div>
                <span class="text-[11px] font-bold tracking-widest uppercase text-slate-800 leading-tight">
                    {{ $this->pageSettings->header_subtitle ?? 'Community Insights' }}
                </span>
            </div>

            {{-- Title --}}
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900 leading-tight">
                <span class="bg-gradient-to-br from-slate-900 to-slate-600 bg-clip-text text-transparent">
                    {{ $this->pageSettings->header_title ?? 'Dr. Isaac GM Andabwa for Lugari' }}
                </span>
            </h1>

            {{-- Emoji --}}
            <div class="text-2xl sm:text-3xl text-emerald-500 mt-2 mb-2 animate-pulse">
                {{ $this->pageSettings->header_emoji ?? '✨ ⚡ 🚀' }}
            </div>

            {{-- Subtitle --}}
            <p class="text-lg md:text-2xl font-medium text-slate-800 max-w-3xl mx-auto ">
                {{ $this->pageSettings->header_description ?? 'Discover your 2027 Lugari MP.' }}
            </p>

        </div>

        {{-- SEARCH + FILTER BAR --}}
        <div class="bg-white p-3 rounded-xl shadow-sm flex flex-col md:flex-row items-center gap-4 max-w-4xl mx-auto mt-2 ">

            {{-- Search --}}
            <div class="relative w-full md:flex-1">
                <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    placeholder="Search..."
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
                <option value="">{{ $this->pageSettings->search_title ?? 'All Categories' }}</option>
                @foreach($this->categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>



            {{-- Reset Button --}}
            <button
                wire:click="$set('search','');$set('categoryId',null);$set('tagId',null)"
                class="flex items-center justify-center px-6 py-3 bg-slate-100 text-slate-800 font-medium rounded-lg hover:bg-slate-500 transition-colors duration-200 shadow-sm">
                <svg class="w-4 h-4 ml-2 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Reset
            </button>

        </div>

        {{-- FEATURED POSTS --}}
        @if ($this->featuredPosts->isNotEmpty())
        <div class="mt-16 mb-2">

            <div class=" mb-4 px-1 mt-2">
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 ">
                    {{ $this->pageSettings->featured_title ?? 'Featured Projects.' }}
                </h2>
                <p class="text-lg text-slate-800 mt-2">
                    {{ $this->pageSettings->featured_description ?? 'Discover the latest in Andabwa Projects.' }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-2 ">
                @foreach ($this->featuredPosts as $featuredPost)
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 md:p-0">
                    <x-blog.card :post="$featuredPost" />
                </div>
                @endforeach
            </div>

        </div>
        @endif

        {{-- LATEST POSTS HEADER --}}
        <div class="mt-16 mb-4">
            <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900">
                {{ $this->pageSettings->latest_title ?? 'Latest Projects.' }}
            </h2>
            <p class="text-lg text-slate-800 mt-2">
                {{ $this->pageSettings->latest_description ?? 'Discover the latest in Dr. GM OGW Andabwa Projects In Lugari Constituency.' }}
            </p>
        </div>

        {{-- LATEST POSTS WITH PAGINATION --}}
        @if($latestPosts->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            @foreach($latestPosts as $post)
            <div class="relative group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 md:p-0">
                @if($post->external_url && \App\Enums\MediaType::isExternal($post->media_type))
                <a href="{{ $post->external_url }}" target="_blank" rel="noopener noreferrer" class="block">
                @else
                <a href="{{ route('posts.show', $post->slug) }}" class="block">
                @endif
                    <div class="bg-transparent rounded-xl overflow-hidden border border-slate-100">
                        {{-- Media --}}
                        <div class="aspect-video overflow-hidden">
                            <x-blog.media :post="$post" />
                        </div>
                        
                        {{-- Content --}}
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-3">
                                @if($post->category)
                                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
                                    {{ $post->category->name }}
                                </span>
                                @endif
                                <span class="text-xs text-slate-500">
                                    {{ $post->created_at->format('M j, Y') }}
                                </span>
                            </div>
                            
                            <h3 class="text-lg font-bold text-slate-900 mb-2 line-clamp-2 group-hover:text-emerald-600 transition-colors">
                                {{ $post->title }}
                            </h3>
                            
                            @if($post->meta_description)
                            <p class="text-sm text-slate-600 line-clamp-2 mb-4">
                                {{ $post->meta_description }}
                            </p>
                            @endif
                            
                            {{-- Read Article Button --}}
                            <div class="flex items-center justify-between">
                                <span class="text-emerald-600 font-semibold text-sm group-hover:text-emerald-700 transition-colors">
                                    Read Article →
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @endif

        {{-- PAGINATION FOR MORE PROJECTS --}}
        @if ($posts->hasPages())
        <div class="flex justify-center mb-10 px-4  mt-10">
            <div class="bg-white px-4 py-4 rounded-xl shadow-sm w-full max-w-md hidden md:block">
                <p class="text-sm text-slate-800 mb-3 text-center">Browse more projects</p>
                <div class="flex justify-center">
                    {{ $posts->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
        @endif

        </div>
    </div>
</div>
