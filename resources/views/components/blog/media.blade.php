@props(['post'])

@php
$isExternal = \App\Enums\MediaType::isExternal($post->media_type);
$data = $post->link_preview_data ?? [];
$type = $data['type'] ?? $post->media_type?->value;

$featuredMedia = $post->hasMedia('featured') ? $post->getFirstMedia('featured') : null;
$featuredMediaUrl = $featuredMedia?->getUrl();
$featuredMediaIsVideo = $featuredMedia?->mime_type ? str_starts_with($featuredMedia->mime_type, 'video') : false;

// Fallback to model's featured_image attribute if no direct media
if (!$featuredMediaUrl) {
    $featuredMediaUrl = $post->featured_image;
    if ($featuredMediaUrl && str_starts_with($featuredMediaUrl, '/')) {
        $featuredMediaUrl = asset($featuredMediaUrl);
    }
    $featuredMediaIsVideo = str_contains($featuredMediaUrl, '.mp4') || str_contains($featuredMediaUrl, '.mov') || str_contains($featuredMediaUrl, '.avi');
}
@endphp

<div class="relative aspect-video w-full overflow-hidden bg-gray-50 border-b border-gray-100">

    {{-- Featured uploaded media --}}
    @if($featuredMediaUrl)
        @if($featuredMediaIsVideo)
        {{-- z-20 ensures the video controls sit ABOVE the stretched link --}}
        <video controls class="relative z-20 w-full h-full object-cover">
            <source src="{{ $featuredMediaUrl }}" type="video/mp4">
        </video>
        @else
        <img src="{{ $featuredMediaUrl }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
        @endif

    {{-- External embeds (YouTube, Vimeo) --}}
    @elseif($isExternal && in_array($type, ['youtube','vimeo','video_embed']) && !empty($data['embed_url']))
        {{-- z-20 ensures iframe play buttons are clickable --}}
        <iframe src="{{ $data['embed_url'] }}" class="relative z-20 w-full h-full border-0" allowfullscreen loading="lazy"></iframe>    

    {{-- YouTube fallback - generate embed URL from external_url if no embed_url --}}
    @elseif($isExternal && $type === 'youtube' && !empty($post->external_url))
        @php
        // Extract YouTube ID from external_url
        preg_match('/(youtu\.be\/|youtube\.com.*v=|youtube\.com\/shorts\/)([^&]+)/', $post->external_url, $matches);
        $youtubeId = $matches[2] ?? null;
        $embedUrl = $youtubeId ? "https://www.youtube.com/embed/{$youtubeId}" : null;
        @endphp
        @if($embedUrl)
        <iframe src="{{ $embedUrl }}" class="relative z-20 w-full h-full border-0" allowfullscreen loading="lazy"></iframe>
        @endif    

    {{-- External article preview --}}
    @elseif($isExternal && !empty($data['url']))
    @if(!empty($data['image']))
    {{-- Let clicks pass through the image to the stretched external link --}}
    <img src="{{ asset($data['image']) }}"
        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 pointer-events-none">
    @endif

    {{-- Stretched external link layer (below the button, above the image) --}}
    <a href="{{ $data['url'] }}"
        target="_blank"
        rel="noopener noreferrer"
        class="absolute inset-0 z-10"
        aria-label="Open external source">
    </a>

    {{-- Explicit external button (stays on top and clickable) --}}
    <a href="{{ $data['url'] }}"
        target="_blank"
        rel="noopener noreferrer"
        class="absolute bottom-3 right-3 z-20 px-3 py-1.5 text-xs font-semibold text-white bg-black/75 rounded-md backdrop-blur-sm transition-colors hover:bg-black flex items-center gap-1 shadow-sm pointer-events-auto">
        Visit Source
        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
        </svg>
    </a>

    {{-- Default image fallback --}}
    @else
    @php
    $imageUrl = $post->getFirstMediaUrl('featured') ?: $post->getFirstMediaUrl();
    // Fallback to link preview image if no local media
    if (!$imageUrl && !empty($data['image'])) {
        $imageUrl = asset($data['image']);
    }
    @endphp

    @if($imageUrl)
    <img src="{{ $imageUrl }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
    @else
    <div class="flex items-center justify-center h-full bg-gradient-to-br from-gray-50 to-gray-100 text-gray-400 text-sm font-medium">
        <svg class="w-8 h-8 mb-1 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
    </div>
    @endif
    @endif

</div>