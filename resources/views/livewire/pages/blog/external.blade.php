<div class="external-content-page">
    <div class="min-h-screen bg-slate-50">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-20">

            {{-- Breadcrumb Navigation --}}
            <nav class="flex items-center justify-center mb-8">
                <a href="{{ route('home') }}" wire:navigate class="inline-flex   hover:underline items-center text-sm font-medium text-green-600  mb-6 transition-colors px-4 py-2 bg-slate-100 rounded-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ $this->pageSettings->editorial_button_text ?? 'Back to Blog' }}
                </a>
            </nav>

            {{-- External Content Display --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="relative aspect-video w-full">
                    <x-blog.media :post="$post" />

                    {{-- Blinking Visit Source Button --}}
                    @if($post->external_url)
                    <a href="{{ $post->external_url }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        onclick="window.open(this.href, '_blank'); return false;"
                        class="absolute top-4 right-4 z-50 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg backdrop-blur-sm transition-all duration-300 hover:bg-red-700 shadow-lg pointer-events-auto visit-source-blink"
                        style="animation: blink-visit-source 2s ease-in-out infinite; background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%) !important;">
                        Visit Source
                        <svg class="w-4 h-4 ml-2 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                    @endif
                </div>

                {{-- Content Info --}}
                <div class="p-8 bg-white border-t">
                    <div class="max-w-4xl mx-auto">
                        <h2 class="text-2xl font-bold text-slate-900 mb-4">{{ $post->title }}</h2>

                        <div class="flex items-center gap-4 mb-6">
                            @if($post->category)
                            <span class="text-sm font-semibold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">
                                {{ $post->category->name }}
                            </span>
                            @endif
                            <span class="text-sm text-slate-500">
                                {{ $post->created_at->format('M j, Y') }}
                            </span>
                        </div>

                        @if($post->meta_description)
                        <p class="text-slate-600 leading-relaxed mb-6">{{ $post->meta_description }}</p>
                        @endif

                        {{-- External URL Info --}}
                        @if($post->external_url)
                        <div class="bg-slate-50 rounded-lg p-4 mb-6">
                            <h3 class="text-sm font-semibold text-slate-700 mb-2">External Source</h3>
                            <a href="{{ $post->external_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-emerald-600 hover:text-emerald-700 break-all text-sm">
                                {{ $post->external_url }}
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Related Articles Section --}}
                @if($relatedPosts && $relatedPosts->isNotEmpty())
                <div class="bg-white border-t p-8">
                    <div class="max-w-4xl mx-auto">
                        <h3 class="text-xl font-bold text-slate-900 mb-6">Related Articles</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($relatedPosts as $relatedPost)
                            <x-blog.card :post="$relatedPost" />
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>