<div class="bg-white min-h-screen"
    x-data="{ 
        percent: 0, 
        copied: false, 
        copyToClipboard() {
            navigator.clipboard.writeText(window.location.href);
            this.copied = true;
            setTimeout(() => this.copied = false, 2000);
        }
     }"
    x-on:scroll.window="percent = (window.pageYOffset / (document.documentElement.scrollHeight - window.innerHeight)) * 100">

    {{-- 1. Reading Progress Bar --}}
    <div class="fixed top-0 left-0 w-full h-1 z-[60] pointer-events-none">
        <div class="h-full bg-indigo-600 transition-all duration-150 ease-out" :style="'width: ' + percent + '%'"></div>
    </div>

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        {{-- 2. Navigation --}}
            <a href="{{ route('home') }}" wire:navigate class="inline-flex  hover:text-indigo-100 hover:underline items-center text-sm font-medium text-gray-600  mb-6 transition-colors px-4 py-2 bg-slate-100 rounded-lg">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ $this->pageSettings->editorial_button_text ?? 'Back to Editorial' }}
            </a>
        
        <article class="max-w-3xl mx-auto">
            {{-- Article Header, Media, and Content go here... --}}
            <header class="mb-10 text-center">
                @if($post->is_featured)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 uppercase tracking-widest mb-6">
                    {{ $this->pageSettings->featured_insight_text ?? 'Featured Insight' }}
                </span>
                @endif
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight leading-[1.1] mb-6">
                    {{ $post->title }}
                </h1>
                {{-- ... --}}
            </header>

            <div class="rounded-2xl overflow-hidden shadow-sm ring-1 ring-gray-100 mb-8 aspect-video">
                <x-blog.media :post="$post" />
            </div>

            <div class="prose prose-lg prose-indigo mx-auto text-gray-700 leading-relaxed mb-16">
                {!! $post->content !!}
            </div>

            {{-- Share Section --}}
            <div class="pt-4  border-t border-gray-300">
                
                <div class="flex items-center gap-4">
                    <h1 class="text-md font-bold">share</h1>
                    {{-- X (Twitter) --}}
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}"
                        target="_blank"
                        class="p-3.5 bg-gray-50 text-gray-600 rounded-full hover:bg-blue-50 hover:text-black transition-all duration-300 border border-transparent hover:border-blue-100"
                        title="Share on X">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z" />
                        </svg>
                    </a>

                    {{-- LinkedIn --}}
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                        target="_blank"
                        class="p-3.5 bg-gray-50 text-gray-600 rounded-full hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 border border-transparent hover:border-blue-100"
                        title="Share on LinkedIn">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451c.979 0 1.778-.773 1.778-1.729V1.729C24 .774 23.204 0 22.225 0z" />
                        </svg>
                    </a>

                    {{-- Copy Link --}}
                    <div class="relative">
                        <button @click="copyToClipboard"
                            class="p-3.5 bg-gray-50 text-gray-600 rounded-full hover:bg-indigo-50 hover:text-green-600 transition-all duration-300 border border-transparent hover:border-indigo-100"
                            title="Copy Link">
                            <svg x-show="!copied" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                            </svg>
                            <svg x-show="copied" class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>

                        {{-- Tooltip --}}
                        <span x-show="copied"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="absolute -bottom-10 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-[10px] px-2 py-1 rounded shadow-lg whitespace-nowrap z-10" x-cloak>
                            Copied to clipboard!
                        </span>
                    </div>
                </div>
            </div>
        </article>
    </div>

    {{-- 3. Related Articles (NOW INSIDE THE ROOT DIV) --}}
    @if($this->relatedPosts->count() > 0)
    <section class="bg-gray-50 border-t border-gray-100 py-20 p-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-6">
                <div>
                    <h3 class="text-3xl font-bold text-gray-900 tracking-tight">Related Articles</h3>
                    <div class="h-1 w-20 bg-indigo-600 mt-4 rounded-full"></div>
                </div>
                <button type="button" class="py-2 px-3 bg-white rounded-lg">
                    <a href="{{ route('home') }}" class="hidden sm:flex items-center text-sm font-bold text-green-600 hover:underline hover:text-green-200 transition-colors">
                        View All Stories
                        <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($this->relatedPosts as $relatedPost)
                <x-blog.card :post="$relatedPost" />
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>
{{-- End of Single Root Element --}}