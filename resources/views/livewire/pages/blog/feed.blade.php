<div class="min-h-screen ">

    {{-- Adjusted top padding from py-20 to pt-12 pb-20 --}}
    <div class="max-w-[1400px]  xl:max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-10 mt-2 pb-6">
        {{-- HEADER SECTION --}}
        <div class="relative max-w-5xl mx-auto text-center pb-10">

            {{-- Soft Precision Background --}}
            <div class="absolute inset-0 -z-10 opacity-95 pointer-events-none" style="background-image: radial-gradient(circle, #6366f1 1.5px, transparent 1.5px); background-size: 38px 38px;">
            </div>

            {{-- Badge --}}
            <div class="inline-flex items-center gap-3 px-6 py-2 bg-slate-100 rounded-full shadow-sm  mb-4">
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
            <div class="text-2xl sm:text-3xl text-emerald-500 py-1 animate-pulse">
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
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search..." class="w-full pr-12 pl-4 py-3 bg-white border rounded-lg text-sm text-slate-900 placeholder-slate-500 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-800">
                    🔍
                </span>
            </div>

            {{-- Category --}}
            <select wire:model.live="categoryId" class="w-full md:w-56 py-3 px-4 bg-white border rounded-lg text-sm text-slate-800 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                <option value="">{{ $this->pageSettings->search_title ?? 'All Categories' }}</option>
                @foreach($this->categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            {{-- Reset Button --}}
            <button wire:click="$set('search','');$set('categoryId',null);$set('tagId',null)"
                class="flex items-center justify-center px-6 py-3 bg-slate-100 text-slate-800 font-medium rounded-lg hover:bg-slate-200 transition-colors duration-200 shadow-sm">
                <svg class="w-4 h-4 ml-2 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Reset
            </button>
        </div>

        {{-- FEATURED POSTS --}}
        @if ($this->featuredPosts->isNotEmpty())
        <div class="py-4">
            <div class="py-4 px-1">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">
                    {{ $this->pageSettings->featured_title ?? 'Featured Projects.' }}
                </h2>
                <p class="text-lg font-semibold text-slate-800 py-2">
                    {{ $this->pageSettings->featured_description ?? 'Discover the latest in Andabwa Projects.' }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 auto-rows-fr">
                @foreach ($this->featuredPosts as $featuredPost)
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden">
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
            <a href="{{ route('blog.all-projects') }}"
                class=" hidden md:block px-4 py-2 text-gray-500 hover:underline font-semibold rounded-lg hover:text-emerald-400 transition-colors duration-300 shadow-md whitespace-nowrap">
                {{ $this->pageSettings->view_all_button ?? 'View All →' }}
            </a>
        </div>

        {{-- LATEST POSTS INFINITE SCROLLER --}}

        @if($this->latestPosts->isNotEmpty())

        <div
            x-data="insaneInfiniteSlider()"
            x-init="init()"
            class="relative group">

            {{-- PROGRESS BAR (Netflix style) --}}
            <div class="absolute top-0 left-0 w-full h-[2px] bg-slate-200 overflow-hidden">
                <div
                    class="h-full bg-emerald-500 transition-all duration-300"
                    :style="`width: ${progress}%`"></div>
            </div>

            {{-- LEFT BUTTON --}}
            <button
                @click="scroll(-1)"
                class="hidden lg:flex items-center justify-center absolute left-2 top-1/2 -translate-y-1/2 z-10 
               bg-white/90 hover:bg-white shadow-xl rounded-full w-11 h-11
               opacity-0 group-hover:opacity-100 transition">
                ←
            </button>

            {{-- RIGHT BUTTON --}}
            <button
                @click="scroll(1)"
                class="hidden lg:flex items-center justify-center absolute right-2 top-1/2 -translate-y-1/2 z-10 
               bg-white/90 hover:bg-white shadow-xl rounded-full w-11 h-11
               opacity-0 group-hover:opacity-100 transition">
                →
            </button>

            {{-- SCROLLER --}}
            <div
                x-ref="track"
                @mouseenter="pause()"
                @mouseleave="play()"
                class="flex overflow-x-auto gap-5 px-1 lg:px-12 py-5
               snap-x snap-mandatory scroll-smooth
               scrollbar-hide cursor-grab active:cursor-grabbing bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-3">

                {{-- LEFT CLONE --}}
                @foreach($this->latestPosts as $post)
                @include('components.blog.post-card', ['post' => $post])
                @endforeach

                {{-- ORIGINAL --}}
                @foreach($this->latestPosts as $post)
                @include('components.blog.post-card', ['post' => $post])
                @endforeach

                {{-- RIGHT CLONE --}}
                @foreach($this->latestPosts as $post)
                @include('components.blog.post-card', ['post' => $post])
                @endforeach

            </div>

        </div>

        @endif

        {{-- PAGINATION FOR MORE PROJECTS --}}
        {{-- @if ($this->posts->hasPages()) --}}
        <div class="flex justify-center py-4 px-4 ">
            <a href="{{ route('blog.all-projects') }}"
                class="px-6 py-3 hover:shadow-green-200 shadow-lg bg-green-100 text-wite hover:underline font-semibold rounded-lg hover:text-emerald-700 transition-colors duration-300  whitespace-nowrap">
                <p class="text-sm  text-center">Browse more projects</p>
            </a>

        </div>
        {{-- @endif --}}
    </div>
</div>