@props(['post'])

@php
    // Initialize variables with proper error handling
    $isExternal = \App\Enums\MediaType::isExternal($post->media_type);
    $mediaTypeValue = $post->media_type?->value;
    $data = $post->link_preview_data ?? [];
    
    // Get featured media with fallback
    $featuredMedia = $post->getFirstMedia('featured');
    $featuredMediaUrl = null;
    $featuredMediaIsVideo = false;
    
    if ($featuredMedia) {
        // getUrl() returns the full URL already (e.g., http://127.0.0.1:8001/storage/1/filename.jpg)
        $featuredMediaUrl = $featuredMedia->getUrl();
        $featuredMediaIsVideo = str_contains($featuredMedia->mime_type ?? '', 'video');
    }
@endphp

<div class="relative w-full h-full overflow-hidden group bg-white">
    {{-- Featured uploaded media (images and local videos) --}}
    @if($featuredMediaUrl && !$isExternal)
        @if($featuredMediaIsVideo)
            {{-- Local Video Player --}}
            <video 
                controls 
                class="w-full h-full min-h-[224px] object-cover transition-transform duration-700 group-hover:scale-105"
                preload="metadata"
                poster="{{ $featuredMedia && $featuredMedia->hasGeneratedConversion('preview') ? $featuredMedia->getUrl('preview') : '' }}">
                <source src="{{ $featuredMediaUrl }}" type="{{ $featuredMedia->mime_type }}">
                Your browser does not support the video tag.
            </video>
            
            {{-- Video overlay info --}}
            <div class="absolute top-3 left-3 bg-black/70 text-white px-3 py-1.5 rounded-md text-sm font-medium">
                <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Video
            </div>
        @else
            {{-- Image --}}
            <img 
                src="{{ $featuredMediaUrl }}" 
                alt="{{ $post->title }}" 
                class="w-full h-full min-h-[224px] object-cover transition-transform duration-700 group-hover:scale-105 pointer-events-none"
                loading="lazy">
        @endif

        {{-- Visit Details Button --}}
        <a href="{{ route('blog.external', $post->slug) }}"
           class="absolute top-3 right-3 z-30 px-3 py-1.5 text-xs font-semibold text-white rounded-md backdrop-blur-sm transition-all duration-300 shadow-lg pointer-events-auto visit-source-blink">
            View Details
            <svg class="w-3 h-3 ml-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
        </a>

    {{-- External embeds (YouTube, Vimeo, articles) --}}
    @elseif($isExternal && $mediaTypeValue === 'youtube')
        @php
        // Get thumbnail image from link preview data
        $imageUrl = $data['image'] ?? null;
        $embedUrl = $data['embed_url'] ?? null;
        $videoId = $data['video_id'] ?? null;
        @endphp
        
        @if($imageUrl)
            {{-- Display YouTube thumbnail with play button --}}
            <img 
                src="{{ $imageUrl }}" 
                alt="{{ $post->title }}" 
                class="w-full h-full min-h-[224px] object-cover transition-transform duration-700 group-hover:scale-105 pointer-events-none"
                loading="lazy"
                onerror="this.classList.add('hidden')">
            
            {{-- Fallback gradient if image fails to load --}}
            <div class="absolute inset-0 w-full h-full min-h-[224px] bg-gradient-to-br from-red-50 to-slate-100 flex items-center justify-center p-8 hidden" id="fallback-youtube-{{ $post->id }}">
                <div class="text-center">
                    <svg class="w-16 h-16 mx-auto text-red-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    </svg>
                    <p class="text-slate-600 font-medium">{{ $post->title }}</p>
                </div>
            </div>
            
            <script>
                const youtubeImg = document.querySelector('img[src="{{ $imageUrl }}"]');
                if (youtubeImg) {
                    youtubeImg.addEventListener('error', function() {
                        this.style.display = 'none';
                        const fallback = document.getElementById('fallback-youtube-{{ $post->id }}');
                        if (fallback) fallback.classList.remove('hidden');
                    });
                }
            </script>
            
            {{-- Clickable Play Button - Opens Modal --}}
            <button 
                onclick="document.getElementById('youtube-modal-{{ $post->id }}').showModal()"
                class="absolute inset-0 flex items-center justify-center group-hover:opacity-80 transition-opacity duration-300 cursor-pointer focus:outline-none"
                title="Click to preview video">
                <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center shadow-lg group-hover:bg-red-700 transition-colors duration-300 hover:scale-110 transform">
                    <svg class="w-8 h-8 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                </div>
            </button>

            {{-- Video Preview Modal --}}
            @if($embedUrl)
            <dialog id="youtube-modal-{{ $post->id }}" class="fixed inset-0 max-h-screen max-w-none z-50 rounded-lg shadow-2xl backdrop:bg-black backdrop:bg-opacity-80 p-0">
                <div class="w-full h-full flex flex-col bg-black">
                    {{-- Modal Header --}}
                    <div class="flex items-center justify-between p-4 border-b border-slate-700">
                        <h2 class="text-lg font-semibold text-white truncate flex-1">{{ $post->title }}</h2>
                        <button 
                            onclick="document.getElementById('youtube-modal-{{ $post->id }}').close()"
                            class="ml-4 p-2 hover:bg-slate-700 rounded-lg transition-colors"
                            title="Close (Esc)">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Modal Video Container --}}
                    <div class="flex-1 flex items-center justify-center p-4 overflow-hidden">
                        <iframe 
                            src="{{ $embedUrl }}?rel=0&modestbranding=1&playsinline=1&autoplay=1" 
                            class="w-full h-full max-w-4xl rounded-lg" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen
                            title="{{ $post->title }}">
                        </iframe>
                    </div>

                    {{-- Modal Footer --}}
                    <div class="p-4 border-t border-slate-700 flex items-center gap-3 bg-slate-900">
                        <span class="text-sm text-slate-400 flex-1">Press <kbd class="px-2 py-1 bg-slate-700 rounded text-sm text-white">Esc</kbd> to close</span>
                        @if($post->external_url)
                        <a href="{{ $post->external_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition-colors">
                            Watch on YouTube
                            <svg class="w-4 h-4 ml-2 inline" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19.615 3.654c-1.318-.72-3.43-.743-8.614-.743-5.185 0-7.298.023-8.616.743C2.047 4.374.96 5.42.96 8.05v7.9c0 2.678 1.113 3.754 2.425 4.396 1.32.72 3.43.743 8.614.743 5.186 0 7.298-.023 8.616-.743 1.312-.642 2.42-1.718 2.42-4.396V8.05c0-2.678-1.113-3.754-2.425-4.396zM8.5 15.5V8.5l7 3.5-7 3.5z"/>
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>

                {{-- Close modal with Escape key --}}
                <script>
                    document.getElementById('youtube-modal-{{ $post->id }}')?.addEventListener('keydown', (e) => {
                        if (e.key === 'Escape') {
                            document.getElementById('youtube-modal-{{ $post->id }}').close();
                        }
                    });
                </script>
            </dialog>
            @endif
        @else
            {{-- Fallback if no image available --}}
            <div class="w-full h-full min-h-[224px] bg-gradient-to-br from-red-50 to-slate-100 flex items-center justify-center p-8">
                <div class="text-center">
                    <svg class="w-16 h-16 mx-auto text-red-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    </svg>
                    <p class="text-slate-600 font-medium">{{ $post->title }}</p>
                </div>
            </div>
        @endif
        
        {{-- Visit Source Button --}}
        <a href="{{ route('blog.external', $post->slug) }}"
           class="absolute top-3 right-3 z-30 px-3 py-1.5 text-xs font-semibold text-white rounded-md backdrop-blur-sm bg-red-600 hover:bg-red-700 transition-all duration-300 shadow-lg pointer-events-auto">
            View Video
            <svg class="w-3 h-3 ml-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
        </a>

    {{-- Article preview --}}
    @elseif($isExternal && ($mediaTypeValue === 'article' || $mediaTypeValue === 'external_link'))
        @php
        // Try to get image from link preview data
        $imageUrl = $data['image'] ?? null;
        @endphp
        
        @if($imageUrl)
            {{-- Display article image if available --}}
            <img 
                src="{{ $imageUrl }}" 
                alt="{{ $post->title }}" 
                class="w-full h-full min-h-[224px] object-cover transition-transform duration-700 group-hover:scale-105 pointer-events-none"
                loading="lazy"
                onerror="this.classList.add('hidden')">
            
            {{-- Fallback gradient if image fails to load --}}
            <div class="absolute inset-0 w-full h-full min-h-[224px] bg-gradient-to-br from-emerald-50 to-slate-100 flex items-center justify-center p-8 hidden" id="fallback-{{ $post->id }}">
                <div class="text-center max-w-2xl">
                    <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center mb-6 mx-auto shadow-md">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 005.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 5.656l-1.1 1.1" />
                        </svg>
                    </div>
                    <h1 class="text-lg font-bold text-slate-900 mb-2 line-clamp-2">{{ $post->title }}</h1>
                    @if(!empty($data['description']))
                        <p class="text-xs text-slate-600 mb-3 line-clamp-2">{{ $data['description'] }}</p>
                    @endif
                </div>
            </div>
            
            <script>
                document.querySelectorAll('img[src="{{ $imageUrl }}"]').forEach(img => {
                    img.addEventListener('error', function() {
                        this.style.display = 'none';
                        const fallback = document.getElementById('fallback-{{ $post->id }}');
                        if (fallback) fallback.classList.remove('hidden');
                    });
                });
            </script>
        @else
            {{-- Article placeholder without image --}}
            <div class="w-full h-full min-h-[224px] bg-gradient-to-br from-emerald-50 to-slate-100 flex items-center justify-center p-8">
                <div class="text-center max-w-2xl">
                    <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center mb-6 mx-auto shadow-md">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 005.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 5.656l-1.1 1.1" />
                        </svg>
                    </div>
                    
                    <h1 class="text-2xl font-bold text-slate-900 mb-4 line-clamp-3">{{ $post->title }}</h1>
                    
                    @if(!empty($data['description']))
                        <p class="text-sm text-slate-600 mb-6 leading-relaxed line-clamp-3">{{ $data['description'] }}</p>
                    @endif
                    
                    <p class="text-xs text-slate-500">External Article • Click "View Details" to read more</p>
                </div>
            </div>
        @endif
        
        {{-- Visit Source Button --}}
        <a href="{{ route('blog.external', $post->slug) }}"
           class="absolute top-3 right-3 z-30 px-3 py-1.5 text-xs font-semibold text-white rounded-md backdrop-blur-sm bg-emerald-600 hover:bg-emerald-700 transition-all duration-300 shadow-lg pointer-events-auto">
            Read Article
            <svg class="w-3 h-3 ml-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
        </a>

    {{-- Default fallback --}}
    @else
        @php
        // For non-external posts, try to get featured media
        $imageUrl = $post->getFirstMediaUrl('featured') ?: $post->getFirstMediaUrl();
        @endphp

        @if($imageUrl)
        <img 
            src="{{ $imageUrl }}" 
            alt="{{ $post->title }}" 
            class="w-full h-full min-h-[224px] object-cover transition-transform duration-700 group-hover:scale-105">
        @elseif($isExternal)
        {{-- Fallback for external posts of unknown type --}}
        <div class="w-full h-full min-h-[224px] bg-gradient-to-br from-indigo-50 to-slate-100 flex items-center justify-center p-8">
            <div class="text-center max-w-xl">
                <svg class="w-12 h-12 mx-auto text-indigo-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 005.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 5.656l-1.1 1.1" />
                </svg>
                <p class="text-sm font-semibold text-slate-700">External Content</p>
                <p class="text-xs text-slate-500 mt-1">{{ strtoupper(str_replace('_', ' ', $mediaTypeValue)) }}</p>
            </div>
        </div>
        
        {{-- Visit Details Button --}}
        <a href="{{ route('blog.external', $post->slug) }}"
           class="absolute top-3 right-3 z-30 px-3 py-1.5 text-xs font-semibold text-white rounded-md backdrop-blur-sm bg-indigo-600 hover:bg-indigo-700 transition-all duration-300 shadow-lg pointer-events-auto">
            View
            <svg class="w-3 h-3 ml-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
        </a>
        @else
        <div class="flex items-center justify-center h-full min-h-[224px] bg-gradient-to-br from-gray-50 to-gray-100 text-gray-400 text-sm font-medium">
            <svg class="w-8 h-8 mb-1 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 005.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 5.656l-1.1 1.1" />
            </svg>
            <p>No Media Available</p>
        </div>
        @endif
    @endif
</div>
