<div class="lg:h-screen lg:overflow-hidden bg-white antialiased text-slate-900 selection:bg-purple-100 selection:text-purple-900">
    <div class="max-w-[1600px] mx-auto h-full  shadow-2xl shadow-blue-900/5 overflow-x-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-12 h-full gap-0 bg-white">

            {{-- ROTATING SIDEBAR (Desktop) --}}
            <aside class="hidden lg:flex lg:col-span-2 border-r border-slate-100 flex-col h-full bg-white" aria-label="Navigation Sidebar">
                <div class="p-3 h-full overflow-hidden">
                    <div class="mb-4 mt-4 px-2">
                        <h1 class="text-sm font-black uppercase tracking-[0.3em] text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600">
                            {{ $this->pageSettings->header_emoji ?? 'Portal.Core' }}
                        </h1>
                    </div>
                    <livewire:sidebar.rotating-widgets />
                </div>

            </aside>

            {{-- MAIN FEED --}}
            <main class="col-span-1 lg:col-span-8 h-full overflow-y-auto scroll-smooth bg-purple-50" aria-label="Main Feed">
                <div class="px-4 py-6 md:px-10 md:py-24 space-y-10 md:space-y-16 max-w-7xl mx-auto">

                    {{-- Featured Header & List --}}
                    <section class="space-y-8 mt-4 md:mt-0">
                        <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-b-2 border-purple-100 pb-5 gap-2 mb-6">
                            <h2 class="text-xl md:text-2xl text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 italic font-black tracking-tight">
                                {{ $this->pageSettings->featured_title ?? 'Featured Projects.' }}
                            </h2>
                            <span class="text-[10px] md:text-xs font-bold text-blue-600 uppercase tracking-[0.2em] bg-blue-50 px-2 py-1 rounded">
                                {{ $this->pageSettings->featured_description ?? 'Priority Updates' }}
                            </span>
                        </div>
                        @if ($this->featuredPosts->isNotEmpty())
                        <div class="grid grid-cols-1 gap-6 md:gap-8">
                            @foreach ($this->featuredPosts as $post)
                            @include('components.blog.post-card-bottom-horizontal-content', ['post' => $post])
                            @endforeach
                        </div>
                        @endif
                    </section>
                    {{-- Latest Header & Bottom Slider --}}
                    <section class="space-y-8 mt-4 md:mt-0">
                        <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-b-2 border-purple-100 pb-5 gap-2 mb-6">
                            <h2 class="text-xl md:text-2xl text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 italic font-black tracking-tight">
                                {{ $this->pageSettings->latest_title ?? 'Latest Projects.' }}
                            </h2>
                            <span class="text-[10px] md:text-xs font-bold text-pink-600 uppercase tracking-[0.2em] bg-pink-50 px-2 py-1 rounded">
                                {{ $this->pageSettings->latest_description ?? 'Happening Now' }}
                            </span>
                        </div>
                        <x-blog.latest-post-bottom />
                    </section>
                    {{-- <section><x-blog.latest-post-top /> </section> --}}
                    <div class="pt-4 pb-16 flex justify-center">
                        <x-blog.browse-more-button class="w-full md:w-auto" />
                    </div>
                </div>
            </main>
            {{-- SECONDARY SIDEBAR (Desktop) --}}
            <aside class="hidden lg:flex lg:col-span-2 border-l border-slate-100 flex-col h-full bg-white" aria-label="Secondary Sidebar">
                <div class="p-8 h-full overflow-hidden">
                    <livewire:left-sidebar />
                </div>
            </aside>
        </div>
    </div>
</div>