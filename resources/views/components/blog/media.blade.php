@props(['post'])

@php
// Core logic remains untouched
$isExternal = \App\Enums\MediaType::isExternal($post->media_type);
$mediaTypeValue = $post->media_type?->value;
$data = $post->link_preview_data ?? [];

$featuredMedia = $post->getFirstMedia('featured');
$featuredMediaUrl = $featuredMedia?->getUrl();
$featuredMediaIsVideo = str_contains($featuredMedia->mime_type ?? '', 'video');
@endphp

{{--
    ENGINEER STANDARD: 
    1. 'aspect-video' guarantees uniform grid heights and prevents Layout Shift.
    2. 'bg-slate-100' provides a skeleton loading feel before media paints.
    3. 'isolate' creates a new z-index stacking context for this specific component.
--}}
<div class="relative w-full aspect-video bg-slate-100 rounded-md overflow-hidden group isolate">

    {{-- ==========================================
         1. UPLOADED LOCAL MEDIA (VIDEO OR IMAGE)
         ========================================== --}}
    @if($featuredMediaUrl && !$isExternal)

    @if($featuredMediaIsVideo)
    <video
        controls
        preload="metadata"
        poster="{{ $featuredMedia->hasGeneratedConversion('preview') ? $featuredMedia->getUrl('preview') : '' }}"
        class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
        <source src="{{ $featuredMediaUrl }}" type="{{ $featuredMedia->mime_type }}">
    </video>

    {{-- Video Type Badge --}}
    <div class="absolute top-3 left-3 bg-black/60 backdrop-blur-md text-white px-2.5 py-1 rounded-sm text-xs font-medium z-10 flex items-center gap-1.5 shadow-sm">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Video
    </div>
    @else
    
{{-- For images, we can directly use the URL from Spatie's media library --}}
{{-- ENGINEER UI: Use Spatie's URL method for better compatibility with different storage disks 

--}}


         @if($post->hasMedia('featured'))
        <img src="{{ $post->getFirstMediaUrl('featured') }}" alt="{{ $post->title }}  class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 pointer-events-none"
        loading="lazy">
        @else
        <img src="{{ asset('images/placeholder.png') }}" alt="Default Image">
        @endif
    @endif




    



    

    {{-- ==========================================
         2. EXTERNAL YOUTUBE VIDEO
         ========================================== --}}
    @elseif($isExternal && $mediaTypeValue === 'youtube')
    @php
    $imageUrl = $data['image'] ?? $post->youtube_thumbnail_url;
    $embedUrl = $data['embed_url'] ?? $post->youtube_embed_url;
    @endphp

    @if($imageUrl)
    {{-- Cleanest DOM way to handle image fallbacks without external script tags --}}
    <img
        src="{{ $imageUrl }}"
        alt="{{ $post->title }}"
        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
        class="absolute inset-0 w-full h-l/2 object-fit transition-transform duration-700 group-hover:scale-105 pointer-events-none z-0"
        loading="lazy">

    {{-- Fallback Gradient (Hidden by default) --}}
    <div class="absolute inset-0 bg-gradient-to-br from-red-50 to-slate-100 hidden items-center justify-center p-6 z-0 text-center">
        <div>
            <svg class="w-12 h-12 mx-auto text-red-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
            </svg>
            <p class="text-sm text-slate-600 font-medium line-clamp-2">{{ $post->title }}</p>
        </div>
    </div>
    @endif

    {{-- Play Overlay Button --}}
    <button
        onclick="document.getElementById('youtube-modal-{{ $post->id }}').showModal()"
        class="absolute inset-0 z-10 flex items-center justify-center bg-black/10 group-hover:bg-black/20 transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-inset"
        aria-label="Play YouTube Video">
        <div class="w-14 h-14 bg-red-600 rounded-full flex items-center justify-center shadow-lg group-hover:bg-red-700 transition-all duration-300 transform group-hover:scale-110">
            <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M8 5v14l11-7z" />
            </svg>
        </div>
    </button>

    {{-- Native HTML5 Dialog for Modal --}}
    @if($embedUrl)
    <dialog id="youtube-modal-{{ $post->id }}" class="fixed inset-0 m-auto max-w-5xl w-11/12 bg-transparent backdrop:bg-black/90 p-0 rounded-xl shadow-2xl z-50 overflow-hidden" onclick="if(event.target === this) this.close()">
        <div class="flex flex-col bg-slate-950 rounded-sm overflow-hidden shadow-2xl">
            <div class="flex items-center justify-between p-3 border-b border-slate-800">
                <h2 class="text-sm font-medium text-slate-200 truncate pr-4">{{ $post->title }}</h2>
                <form method="dialog">
                    <button class="p-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-md transition-colors" aria-label="Close modal">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </form>
            </div>
            <div class="w-full aspect-video bg-black">
                <iframe
                    src="{{ $embedUrl }}?rel=0&modestbranding=1&playsinline=1"
                    class="w-full h-full"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                    title="{{ $post->title }}">
                </iframe>
            </div>
        </div>
    </dialog>
    @endif

    {{-- ==========================================
         3. EXTERNAL ARTICLES & LINKS
         ========================================== --}}
    @elseif($isExternal && in_array($mediaTypeValue, ['article', 'external_link']))
    @php $imageUrl = $data['image'] ?? null; @endphp

    @if($imageUrl)
    <img
        src="{{ $imageUrl }}"
        alt="{{ $post->title }}"
        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
        class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 pointer-events-none z-0"
        loading="lazy">

    {{-- Fallback (hidden by default) --}}
    <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-slate-100 hidden items-center justify-center p-6 z-0">
        <div class="text-center max-w-sm">
            <div class="w-12 h-12 bg-white rounded-sm flex items-center justify-center mx-auto shadow-sm mb-3">
                <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 005.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 5.656l-1.1 1.1" />
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-900 line-clamp-2">{{ $post->title }}</p>
        </div>
    </div>
    @else
    {{-- No Image Available --}}
    <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-emerald-50 to-slate-100 p-6 text-center">
        <div class="max-w-sm">
            <svg class="w-10 h-10 mx-auto text-emerald-500/50 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
            </svg>
            <p class="text-sm font-semibold text-slate-800 line-clamp-2">{{ $post->title }}</p>
            <p class="text-xs text-slate-500 mt-2">External Article</p>
        </div>
    </div>
    @endif

    {{-- ==========================================
         4. DEFAULT FALLBACKS
         ========================================== --}}
    @else
    @php
    $imageUrl = $post->getFirstMediaUrl('featured') ?: $post->getFirstMediaUrl();
    @endphp

    @if($imageUrl)
    <img
        src="{{ $imageUrl }}"
        alt="{{ $post->title }}"
        class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
    @else
    <div class="absolute inset-0 flex items-center justify-center bg-slate-50 text-slate-400">
        <div class="text-center">
            <svg class="w-8 h-8 mx-auto mb-2 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="text-xs font-medium uppercase tracking-wider">No Media</span>
        </div>
    </div>
    @endif
    @endif

    {{-- ==========================================
         UNIVERSAL ACTION BUTTON (TOP RIGHT)
         ========================================== --}}
    <a href="{{ route('blog.external', $post->slug) }}"
        class="absolute top-3 right-3 z-20 px-2.5 py-1.5 text-xs font-semibold text-white rounded-sm backdrop-blur-md shadow-sm transition-colors duration-200 pointer-events-auto
       {{ $mediaTypeValue === 'youtube' ? 'bg-red-600/90 hover:bg-red-600' : 'bg-slate-900/70 hover:bg-slate-900' }}">

        {{ $mediaTypeValue === 'youtube' ? 'Watch' : ($isExternal ? 'Visit Link' : 'View') }}

        <svg class="w-3 h-3 ml-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            @if($isExternal)
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            @else
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            @endif
        </svg>
    </a>

</div>