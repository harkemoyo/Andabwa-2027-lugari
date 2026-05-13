<div class="lg:h-screen lg:overflow-hidden bg-white antialiased text-slate-900 selection:bg-purple-100 selection:text-purple-900">
    <div class="max-w-[1800px] mx-auto h-full shadow-2xl shadow-blue-900/5 overflow-x-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-12 h-full gap-0 bg-white">

            {{-- ROTATING SIDEBAR (Desktop) --}}
            <aside class="hidden lg:flex lg:col-span-2 border-r border-slate-100 flex-col h-full bg-white" aria-label="Navigation Sidebar">
                <div class="p-3 h-full overflow-hidden">
                    <div class="mb-4 mt-4 px-2">
                        <h1 class="text-sm font-black uppercase tracking-[0.3em] text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600">
                            {{ $this->pageSettings->header_emoji ?? 'Portal.Core' }}
                        </h1>
                    </div>
                    <div class="space-y-4">
                        <livewire:sidebar.rotating-widgets position="sidebar" />
                    </div>

                    <div class="mt-10 border-t border-slate-100 pt-8">
                        <div class="px-2 mb-5 justify-center">
                            <h3 class="text-[10px] uppercase tracking-[0.28em] font-black text-slate-400">Explore Segments</h3>
                        </div>
                        <div class="md:-ml-10">
                            <livewire:pages.blog.category-bar :category-id="$categoryId" />
                        </div>
                    </div>
                </div>
            </aside>

            {{-- MAIN FEED --}}
            <main class="col-span-1 lg:col-span-8 h-full overflow-y-auto scroll-smooth bg-slate-50" aria-label="Main Feed"
            >
                {{-- Adjusted padding back to normal, footer handles the bottom spacing --}}
                <div class="px-4 pt-2 pb-2 md:px-10 md:py-24 space-y-10  max-w-7xl mx-auto flex flex-col min-h-full">

                    <div class="flex-grow space-y-10  ">
                        {{-- LATEST HEADER & BOTTOM SLIDER --}}
                        <section class="space-y-2 ">
                            <div class="flex flex-col md:flex-row md:items-center justify-between border-b-2 border-purple-100 pb-3 gap-2 ">
                                <h2 class="text-xl md:text-2xl text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 italic font-black tracking-tight">
                                    {{ $this->pageSettings->latest_title ?? 'Latest Projects.' }}
                                </h2>
                                <span class="text-[10px] md:text-xs font-bold text-pink-600 uppercase tracking-[0.2em] bg-pink-50 px-2 py-1 rounded">
                                    {{ $this->pageSettings->latest_description ?? 'Happening Now' }}
                                </span>
                            </div>
                            <x-blog.latest-post-tops />
                        </section>

                        {{-- FEATURED HEADER & LIST --}}
                        <section class="space-y-8 mt-4 ">
                            <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-b-2 border-purple-100 pb-5 gap-2 mb-6">
                                <h2 class="text-xl md:text-2xl text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 italic font-black tracking-tight">
                                    {{ $this->pageSettings->featured_title ?? 'Featured Updates.' }}
                                </h2>
                                <span class="text-[10px] md:text-xs font-bold text-blue-600 uppercase tracking-[0.2em] bg-blue-50 px-2 py-1 rounded">
                                    {{ $this->pageSettings->featured_description ?? 'Priority Updates' }}
                                </span>
                            </div>
                            @if ($this->featuredPosts->isNotEmpty())
                            <div class="grid grid-cols-1 gap-6 md:gap-8">
                                @foreach ($this->featuredPosts as $post)
                                @include('components.blog.post-card-tops-horizontal-content', ['post' => $post])
                                @endforeach
                            </div>
                            @endif
                        </section>

                        <div class="flex justify-center">
                            <x-blog.browse-more-button class="w-full md:w-auto" />
                        </div>
                    </div>

                    {{-- PROFESSIONAL END OF FEED FOOTER --}}
                    <footer class=" border-t border-purple-200/50 flex flex-col items-center justify-center gap-4">

                        <div class="flex items-center gap-3 text-slate-400">
                            <div class="h-px w-8 bg-slate-200"></div>
                            {{--<span class="text-[10px] font-black tracking-[0.2em] uppercase">End of Feed</span>--}}
                            <div class="h-px w-8 bg-slate-200"></div>
                        </div>

                        {{-- ACTION BUTTONS --}}
                        <div class="flex flex-wrap items-center justify-center gap-3 md:-mt-5">

                            {{-- BACK TO TOP --}}
                            <button
                                onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
                                class="group mt-2 px-4 py-2 text-xs font-bold
            text-purple-600 bg-purple-100/50 hover:bg-purple-100
            rounded-full transition-all duration-300
            flex items-center gap-2 hover:scale-[1.02]">
                                <svg class="w-4 h-4 transition-transform duration-300 group-hover:-translate-y-0.5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 10l7-7m0 0l7 7m-7-7v18">
                                    </path>

                                </svg>

                                Back to Top
                            </button>

                            {{-- SCROLL TO BOTTOM --}}
                            <button
                                onclick="window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' })"
                                class="group mt-2 px-4 py-2 text-xs font-bold
            text-pink-600 bg-pink-100/50 hover:bg-pink-100
            rounded-full transition-all duration-300
            flex items-center gap-2 hover:scale-[1.02]">
                                <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-y-0.5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 14l-7 7m0 0l-7-7m7 7V3">
                                    </path>

                                </svg>

                                Scroll to Bottom
                            </button>

                        </div>

                    </footer>

                </div>
            </main>

            {{-- SECONDARY SIDEBAR (DESKTOP) --}}
            <aside class="hidden lg:flex lg:col-span-2 border-l border-slate-100 flex-col h-full bg-white" aria-label="Secondary Sidebar">
                <div class="p-1  pt-4 h-full overflow-hidden">
                    <livewire:right-sidebar />
                </div>
            </aside>

        </div>
    </div>
</div>