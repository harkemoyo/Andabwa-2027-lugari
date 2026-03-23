<div class="min-h-screen bg-gray-50">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">

        {{-- HEADER SECTION --}}
        <div class="relative max-w-5xl mx-auto text-center pt-20 pb-20">

            {{-- Soft Precision Background --}}
            <div class="absolute inset-0 -z-10 opacity-10 pointer-events-none"
                style="background-image: radial-gradient(circle, #6366f1 1px, transparent 1px);
                       background-size: 38px 38px;">
            </div>

            {{-- Badge --}}
            <div class="inline-flex items-center gap-3 px-6 py-2 bg-slate-100 rounded-full shadow-sm mb-10">
                <div class="relative h-2 w-2">
                    <span class="animate-ping absolute h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative h-2 w-2 rounded-full bg-emerald-500"></span>
                </div>
                <span class="text-[11px] font-bold tracking-widest uppercase text-slate-600">
                    {{ $this->pageSettings->header_subtitle ?? 'Community Insights' }}
                </span>
            </div>

            {{-- Title --}}
            <h1 class="text-5xl  md:text-6xl font-bold text-slate-900 leading-tight">
                <span class="bg-gradient-to-br from-slate-900 to-slate-600 bg-clip-text text-transparent">
                    {{ $this->pageSettings->header_title ?? 'Dr. Isaac GM Andabwa for Lugari' }}
                </span>
            </h1>

            {{-- Emoji --}}
            <div class="text-4xl sm:text-5xl text-emerald-500 mt-5  animate-pulse">
                {{ $this->pageSettings->header_emoji ?? '✨ ⚡ 🚀' }}
            </div>

            {{-- Subtitle --}}
            <p class="text-lg md:text-2xl font-medium text-slate-600 max-w-3xl mx-auto mt-6 mb-2 ">
                {{ $this->pageSettings->header_description ?? 'Discover the latest in Agriculture.' }}
            </p>

        </div>

        {{-- SEARCH + FILTER BAR --}}
        <div class="bg-white p-4 rounded-xl shadow-sm flex flex-col md:flex-row items-center gap-4 max-w-4xl mx-auto">

            {{-- Search --}}
            <div class="relative w-full md:flex-1">
                <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    placeholder="Search..."
                    class="w-full pr-12 pl-4 py-3 bg-white border rounded-lg text-sm text-slate-900 placeholder-slate-500
               focus:ring-2 focus:ring-emerald-500 focus:outline-none">

                <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400">
                    🔍
                </span>
            </div>

            {{-- Category --}}
            <select
                wire:model.live="categoryId"
                class="w-full md:w-56 py-3 px-4 bg-white border rounded-lg text-sm text-slate-700
                       focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                <option value="">{{ $this->pageSettings->search_title ?? 'All Categories' }}</option>
                @foreach($this->categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>



            {{-- Reset Button --}}
            <button
                wire:click="$set('search','');$set('categoryId',null);$set('tagId',null)"
                class="flex items-center justify-center px-6 py-3 bg-slate-600 text-gray-700 font-medium rounded-lg hover:bg-slate-800 transition-colors duration-200 shadow-sm">
                <svg class="w-4 h-4 ml-2 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Reset
            </button>

        </div>

        {{-- FEATURED POSTS --}}
        @if ($this->featuredPosts->isNotEmpty())
        <div class="mt-28">

            <div class="max-w-6xl mx-auto mb-12 px-4 mt-4">
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 ">
                    {{ $this->pageSettings->featured_title ?? 'Featured Projects.' }}
                </h2>
                <p class="text-lg text-slate-600 mt-2">
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
        <div class="mt-32 mb-16">
            <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900">
                {{ $this->pageSettings->latest_title ?? 'Latest Projects.' }}
            </h2>
            <p class="text-lg text-slate-600 mt-2">
                {{ $this->pageSettings->latest_description ?? 'Discover the latest in Dr. GM OGW Andabwa Projects In Lugari Constituency.' }}
            </p>
        </div>

        {{-- POSTS GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2  mb-10">
            @forelse($posts as $post)
            <div class="">
                <a class="" href="{{ route('posts.show', $post->slug) }}">
                    <x-blog.card :post="$post" />
                </a>
            </div>
            @empty
            <div class="col-span-full py-20 text-center bg-slate-100 rounded-xl">
                <h3 class="text-2xl font-bold text-slate-800">No Documentation Found</h3>
                <p class="text-slate-600 mt-2">Try adjusting your search criteria.</p>
                <button
                    wire:click="resetFilters"
                    class="mt-6 px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                    Reset Filters
                </button>
            </div>
            @endforelse

        </div>

        {{-- PAGINATION --}}
        @if ($posts->hasPages())
        <div class=" flex justify-center">
            {{ $posts->links() }}
        </div>
        @endif

    </div>
</div>