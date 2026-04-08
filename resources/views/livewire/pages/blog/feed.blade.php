<div class="min-h-screen ">
    {{-- Adjusted top padding from py-20 to pt-12 pb-20 --}}
    <div class="max-w-7xl md:max-w-7xl lg:max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- HEADER SECTION --}}
        <div class="relative max-w-5xl mx-auto text-center pb-10">

            <x-blog.soft-precision-background />

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
            <div class="text-2xl sm:text-3xl text-emerald-500  py-1 animate-pulse">
                {{ $this->pageSettings->header_emoji ?? '✨ ⚡ 🚀' }}
            </div>

            {{-- Subtitle --}}
            <p class="text-lg md:text-xl font-medium text-slate-800 max-w-3xl mx-auto ">
                {{ $this->pageSettings->header_description ?? 'Discover your 2027 Lugari MP.' }}
            </p>

        </div>

        {{-- SEARCH + FILTER BAR --}}
        <div class="bg-white p-3 rounded-xl shadow-sm flex flex-col md:flex-row items-center gap-4 max-w-4xl mx-auto">

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
            <x-blog.reset-button />

        </div>

        {{-- FEATURED POSTS --}}
        @if ($this->featuredPosts->isNotEmpty())
        <div class="py-10 ">

            <div class=" py-4 px-1 ">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 ">
                    {{ $this->pageSettings->featured_title ?? 'Featured Projects.' }}
                </h2>
                <p class="text-lg font-semibold text-slate-800 py-2">
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
        <div class="py-4 flex items-center justify-between">
            <div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">
                    {{ $this->pageSettings->latest_title ?? 'Latest Projects.' }}
                </h2>
                <p class="text-lg  font-semibold text-slate-800 py-2">
                    {{ $this->pageSettings->latest_description ?? 'Discover the latest in Dr. GM OGW Andabwa Projects In Lugari Constituency.' }}
                </p>
            </div>
            <a href="{{ route('blog.all-projects') }}" class="md:px-6 md:;py-3 px-2 py-1.5 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition-colors duration-200 shadow-md whitespace-nowrap">
                View All →
            </a>
        </div>

        {{-- LATEST POSTS WITH PAGINATION --}}
        @if($this->latestPosts->isNotEmpty())

        <div class="grid grid-cols-1 md:grid-cols-3  gap-6  py-4">
            @foreach($this->latestPosts as $post)
            <div class="relative group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 md:p-1">
                @if($post->external_url && \App\Enums\MediaType::isExternal($post->media_type))
                <a href="{{ route('blog.external', $post->slug) }}" class="block">
                    @else
                    <a href="{{ route('posts.show', $post->slug) }}" class="block">
                        @endif
                        <div class="bg-transparent rounded-xl overflow-hidden border border-slate-100">
                            {{-- Media --}}
                            <div class="aspect-video overflow-hidden">
                                <x-blog.media :post="$post" />
                            </div>

                            {{-- Content --}}
                            <div class="p-4">
                                <div class="flex items-center gap-2 mb-2">
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
                                <p class="text-sm text-slate-600 line-clamp-2 mb-2">
                                    {{ $post->meta_description }}
                                </p>
                                @endif

                                {{-- Read Article Button --}}
                                {{-- <x-blog.read-article-button/> --}}

                            </div>
                        </div>
                    </a>

            </div>
            @endforeach
        </div>
        @endif



        {{-- PAGINATION FOR MORE PROJECTS --}}
        @if ($this->posts->hasPages())
        <div class="flex justify-center mb-4 px-4  mt-4">
            <div class="bg-white  px-4 py-4 rounded-xl shadow-sm w-full max-w-md ">
                <a href="{{ route('blog.all-projects') }}" class="animate pulse">
                    <p class="hover:underline text-gray-600 text-sm text-slate-800 mb-3 text-center">Browse more projects</p>
                </a>

            </div>
        </div>

        @endif

    </div>

    {{-- <div class="flex justify-center hidden md:block">
        {{ $this->posts->links('pagination::tailwind') }}
    </div> --}}
</div>