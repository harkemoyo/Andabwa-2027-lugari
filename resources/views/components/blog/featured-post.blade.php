    {{-- Main Container --}}
    <div class="-mt-4 sm:mt-16 md:-mt-16 lg:-mt-8 z-0">

        {{-- FEATURED POSTS --}}
        @if ($this->featuredPosts->isNotEmpty())
        <section class="mb-6">

            {{-- Section Header 
            <div class="mb-6 -mt-0 sm:mt-16 md:mt-16 lg:mt-2">
                <div class="max-w-3xl">
                    <span class="h-0.5 w-12 bg-gradient-to-r from-purple-600 to-pink-500 block mb-2"></span>

                    <h2 class="text-sm md:text-xl font-bold uppercase tracking-[0.3em] text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 italic">
                        {{ $this->pageSettings->featured_title ?? 'Featured Projects.' }}
                    </h2>

                    <p class="text-sm md:text-lg text-slate-500 mt-2 max-w-2xl">
                        {{ $this->pageSettings->featured_description ?? 'Highlighted projects for Dr. GM OGW Andabwa Projects In Lugari Constituency.' }}
                    </p>
                </div>
            </div>--}}

            {{-- FEATURED LIST --}}
            <div class="space-y-6">

                @foreach ($this->featuredPosts as $featuredPost)

                <div class="group relative bg-white rounded-3xl border border-1 hover:border-2 border-blue-300 hover:border-pink-500 transition-all duration-500 hover:-translate-y-1 overflow-hidden">

                    {{-- Hover Glow --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-red-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                    {{-- 2-COLUMN LAYOUT --}}
                    <div class="relative grid grid-cols-1 md:grid-cols-2">

                        {{-- LEFT: MEDIA --}}
                        <div class="h-full">
                            <x-blog.media
                                :post="$featuredPost"
                                class="h-full w-full rounded-none md:rounded-l-3xl" />
                        </div>

                        {{-- RIGHT: CONTENT --}}
                        <div class="p-6 md:p-8 flex flex-col h-full">

                            {{-- META --}}
                            <div class="flex items-center justify-between mb-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-100">
                                    {{ $featuredPost->category->name ?? 'Uncategorized' }}
                                </span>

                                <span class="text-xs text-gray-400 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $featuredPost->read_time ?? '5 min' }}
                                </span>
                            </div>

                            {{-- TITLE --}}
                            <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-green-600 transition">
                                @php
                                $url = ($featuredPost->external_url && \App\Enums\MediaType::isExternal($featuredPost->media_type))
                                ? route('blog.external', $featuredPost->slug)
                                : route('posts.show', $featuredPost->slug);
                                @endphp

                                <a href="{{ $url }}">
                                    {{ $featuredPost->title }}
                                </a>
                            </h2>

                            {{-- EXCERPT --}}
                            <p class="text-gray-600 text-sm md:text-base line-clamp-3 mb-6">
                                {!! strip_tags($featuredPost->content) !!}
                            </p>

                            {{-- FOOTER --}}
                            <div class="mt-auto pt-4 border-t border-gray-100">
                                <a href="{{ $url }}"
                                    class="inline-flex items-center text-sm font-semibold text-green-600 hover:text-green-700 transition">

                                    {{ $featuredPost->external_url ? 'View Details' : 'Read Article' }}

                                    <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>

                        </div>

                    </div>
                </div>

                @endforeach

            </div>
        </section>
        @endif

    </div>