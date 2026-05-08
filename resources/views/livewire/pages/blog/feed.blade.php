{{-- ============================= --}}
{{-- PREMIUM FEED LAYOUT (CORRECTED) --}}
{{-- ============================= --}}

<div class="min-h-screen bg-gradient-to-br
    from-slate-50 via-purple-50/30 to-pink-50/20
    antialiased text-slate-900
    selection:bg-purple-100 selection:text-purple-900
    pb-0">

    <div
        class="max-w-[1600px] mx-auto
        bg-white lg:border-x border-slate-200
        shadow-[0_10px_80px_rgba(88,28,135,0.06)] pb-12">

        <div            class="grid grid-cols-1 lg:grid-cols-12 items-start">

            {{-- LEFT SIDEBAR --}}
            {{-- LEFT SIDEBAR --}}
<aside
    class="hidden lg:block lg:col-span-2
    border-r border-slate-100
    bg-white
    sticky top-20 self-start
    h-screen z-50">

    <div class="h-full overflow-y-auto overflow-x-hidden hide-scrollbar">
        <div class="p-4">
                        <div class="mb-8 mt-4 px-2 flex items-center justify-between">
                            <h1 class="text-sm font-black uppercase tracking-[0.3em] text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600">
                                {{ $this->pageSettings->header_emoji ?? 'Portal.Core' }}
                            </h1>
                            <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                        </div>

                        <div class="space-y-4">
                            <livewire:sidebar.rotating-widgets position="sidebar" />
                        </div>

                        <div class="mt-10 border-t border-slate-100 pt-8">
                            <div class="px-2 mb-5">
                                <h3 class="text-[10px] uppercase tracking-[0.28em] font-black text-slate-400">Explore Segments</h3>
                            </div>
                            <div class="-ml-6">
                                <livewire:pages.blog.category-bar :category-id="$categoryId" />
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            {{-- MAIN CONTENT --}}
            <main class="col-span-1 lg:col-span-8 min-w-0">
                <div class="max-w-6xl mx-auto px-4 md:px-8 pt-24 md:pt-32 pb-12 min-w-0">

                    {{-- HERO / LATEST --}}
                    <section class="space-y-8 min-w-0">
                        <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-purple-100 pb-5 gap-3 min-w-0">
                            <div class="space-y-2">
                                <h2 class="text-2xl md:text-4xl text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 italic font-black tracking-tight min-w-0 break-words">
                                    {{ $this->pageSettings->latest_title ?? 'Latest Projects.' }}
                                </h2>
                                <p class="text-sm text-slate-500">{{ $this->pageSettings->header_title ?? 'Happening Now.' }}</p>
                            </div>
                            <span class="text-[10px] md:text-xs font-bold text-pink-600 uppercase tracking-[0.2em] bg-pink-50 border border-pink-100 px-3 py-1 rounded-full shrink-0">
                                {{ $this->pageSettings->latest_description ?? 'Latest description' }}
                            </span>
                        </div>
                        <div class="min-w-0 overflow-hidden">
                            <x-blog.latest-post-tops />
                        </div>
                    </section>

                    {{-- FEATURED --}}

                    <section
                        id="featured-updates"
                        class="space-y-8 min-w-0 scroll-mt-40 lg:scroll-mt-32">

                        <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-purple-100 pb-5 gap-3 min-w-0">
                            <div class="space-y-2">
                                <h2 class="text-2xl md:text-4xl text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 italic font-black tracking-tight min-w-0 break-words">
                                    {{ $this->pageSettings->featured_title ?? 'Featured Projects.' }}
                                </h2>

                                <p class="text-sm text-slate-500">{{ $this->pageSettings->header_description ?? 'Priority Updates.' }}</p>
                            </div>
                            <span class="text-[10px] md:text-xs font-bold text-blue-600 uppercase tracking-[0.2em] bg-blue-50 border border-blue-100 px-3 py-1 rounded-full shrink-0">
                                {{ $this->pageSettings->featured_description ?? 'Featured description' }}
                            </span>

                        </div>

                        @if ($this->featuredPosts->isNotEmpty())
                        <div class="grid grid-cols-1 gap-6 md:gap-8 min-w-0">
                            @foreach ($this->featuredPosts as $post)
                            <div class="min-w-0 overflow-hidden">
                                @include('components.blog.post-card-tops-horizontal-content', ['post' => $post])
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </section>

                    <div class="pt-16 pb-16 flex justify-center">
                        <x-blog.browse-more-button class="w-full md:w-auto" />
                    </div>
                </div>
            </main>

            {{-- RIGHT SIDEBAR --}}
            {{-- RIGHT SIDEBAR --}}
            <aside
                class="hidden lg:block lg:col-span-2
    border-l border-slate-100
    bg-white
    sticky top-20 self-start
    h-screen z-50">

                <div class="h-full overflow-y-auto overflow-x-hidden hide-scrollbar">
                    <div class="p-6">
                        <livewire:right-sidebar />
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>