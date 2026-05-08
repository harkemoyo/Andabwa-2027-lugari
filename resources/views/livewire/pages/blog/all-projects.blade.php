<div class="min-h-screen bg-slate-100 antialiased selection:bg-emerald-100 selection:text-emerald-900">
    {{-- CATEGORY: NAVIGATION & UTILITIES --}}
    <header class="w-full pt-8 pb-4">
        <div class="max-w-3xl mx-auto px-4">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-2 transform hover:scale-[1.01] transition-transform duration-300">
                <livewire:sidebar.rotating-widgets position="sidebar" />
            </div>
        </div>
    </header>

    {{-- Category Bar --}}
    <div class="w-full bg-white border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <livewire:pages.blog.category-bar :category-id="$categoryId" />
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- CATEGORY: CONTENT FEED --}}
        @if($this->posts->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($this->posts as $post)
            <article class="group relative flex flex-col bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-emerald-500/10 hover:-translate-y-2 transition-all duration-500 overflow-hidden">

                {{-- Preserved Routing Logic --}}
                @php
                $url = ($post->external_url && \App\Enums\MediaType::isExternal($post->media_type))
                ? route('blog.external', $post->slug)
                : route('posts.show', $post->slug);
                @endphp

                <a href="{{ $url }}" class="flex flex-col h-full" aria-label="{{ $post->title }}">

                    {{-- Media: Cinematic Aspect Ratio --}}
                    <div class="relative aspect-video overflow-hidden bg-slate-200">
                        <x-blog.media :post="$post" />
                        {{-- Subtle Glass Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>

                    {{-- Content Body --}}
                    <div class="p-6 md:p-8 flex flex-col flex-1">
                        {{-- Badges & Meta --}}
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                @if($post->category)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100/50">
                                    {{ $post->category->name }}
                                </span>
                                @endif
                                @php
                                $mediaLabel = match($post->media_type?->value) {
                                    'article' => 'Article',
                                    'image' => 'Image',
                                    'local_video' => 'Video',
                                    'youtube' => 'YouTube',
                                    'external_link' => 'Link',
                                    default => 'Post',
                                };
                                $mediaClass = match($post->media_type?->value) {
                                    'article' => 'bg-blue-50 text-blue-600 border-blue-100/50',
                                    'image' => 'bg-purple-50 text-purple-600 border-purple-100/50',
                                    'local_video' => 'bg-red-50 text-red-600 border-red-100/50',
                                    'youtube' => 'bg-red-50 text-red-600 border-red-100/50',
                                    'external_link' => 'bg-amber-50 text-amber-600 border-amber-100/50',
                                    default => 'bg-slate-50 text-slate-600 border-slate-100/50',
                                };
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest border {{ $mediaClass }}">
                                    {{ $mediaLabel }}
                                </span>
                            </div>
                            <time class="text-[11px] font-semibold text-slate-400 uppercase tracking-tighter">
                                {{ $post->created_at->format('M j, Y') }}
                            </time>
                        </div>

                        {{-- Typography Hierarchy --}}
                        <h3 class="text-xl font-extrabold text-slate-900 leading-tight mb-3 group-hover:text-emerald-600 transition-colors duration-300 line-clamp-2">
                            {{ $post->title }}
                        </h3>

                        @if($post->meta_description)
                        <p class="text-sm leading-relaxed text-slate-500 line-clamp-2 mb-6">
                            {{ $post->meta_description }}
                        </p>
                        @endif

                        {{-- Visual CTA --}}
                        <div class="mt-auto pt-4 flex items-center text-emerald-600 text-sm font-bold tracking-tight">
                            <span class="mr-2">View Details</span>
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </div>
                    </div>
                </a>
            </article>
            @endforeach
        </div>

        {{-- CATEGORY: NAVIGATION & EMPTY STATE --}}
        @if($this->posts->hasPages())
        <div class="mt-16 flex justify-center">
            <div class="bg-white px-6 py-3 rounded-2xl shadow-sm border border-slate-100">
                {{ $this->posts->links('pagination::tailwind') }}
            </div>
        </div>
        @endif

        @else
        <div class="max-w-md mx-auto text-center py-24 px-6 bg-white rounded-[3rem] border border-dashed border-slate-200">
            <div class="mb-6 inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-50 text-slate-300">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">No projects found</h3>
            <p class="text-slate-500 mb-8 leading-relaxed">Adjust your filters or search terms to find what you're looking for.</p>

            <button
                wire:click="resetFilters"
                class="inline-flex items-center px-8 py-3 bg-slate-900 text-white text-sm font-bold rounded-xl hover:bg-emerald-600 hover:shadow-lg hover:shadow-emerald-200 transition-all duration-300">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Clear All Filters
            </button>
        </div>
        @endif
    </main>
</div>






