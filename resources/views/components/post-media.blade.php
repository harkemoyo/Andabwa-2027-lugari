@props(['post'])

@php
    $isExternal = \App\Enums\MediaType::isExternal($post->media_type);
    $data = $post->link_preview_data ?? [];
    $type = $data['type'] ?? $post->media_type?->value;
@endphp

{{-- 
    Removed h-60 and fixed borders. 
    Added aspect-video to ensure it always takes up the same proportional space 
--}}
<div class="relative w-full overflow-hidden bg-gray-100 dark:bg-gray-800 aspect-video rounded-t-2xl">

    {{-- Case 1: YouTube/External Embeds --}}
    @if($isExternal && in_array($type, ['youtube', 'vimeo', 'video_embed']) && !empty($data['embed_url']))
        <div class="w-full h-full bg-black" wire:ignore>
            <iframe src="{{ $data['embed_url'] }}" class="w-full h-full border-0" allowfullscreen></iframe>
        </div>

    {{-- Case 2: Local or External Video File --}}
    @elseif($post->media_type?->value === 'local_video' || $type === 'video_file')
        <div class="w-full h-full bg-black" wire:ignore>
            <video controls class="w-full h-full object-cover" poster="{{ $data['image'] ?? $data['thumbnail'] ?? '' }}">
                <source src="{{ $isExternal ? ($data['embed'] ?? '') : $post->getFirstMediaUrl('featured') }}" type="video/mp4">
            </video>
        </div>

    {{-- Case 3: External Links (Articles) with Image Preview --}}
    @elseif($isExternal && !empty($data['url']))
        <a href="{{ $data['url'] }}" target="_blank" rel="noopener noreferrer" class="relative block h-full group">
            @if(!empty($data['image']))
                <img src="{{ $data['image'] }}" alt="Preview" class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-110">
                <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors"></div>
            @else
                <div class="flex items-center justify-center h-full bg-indigo-50">
                    <span class="text-xs font-bold text-indigo-400">View External Source</span>
                </div>
            @endif
            
            {{-- Source Badge overlay --}}
            <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-1 rounded text-[10px] font-bold text-gray-800 uppercase">
                {{ $data['source'] ?? parse_url($data['url'], PHP_URL_HOST) }}
            </div>
        </a>

    {{-- Case 4: Standard Local Images --}}
    @else
        @php
            $mediaUrl = $post->getFirstMediaUrl('featured');
            if (!$mediaUrl && $post->hasMedia()) {
                $mediaUrl = $post->getFirstMediaUrl();
            }
            if (!$mediaUrl) {
                $mediaUrl = asset('images/default-blog.jpg');
            }
        @endphp
        <div class="w-full h-full">
            <img 
                src="{{ $mediaUrl }}" 
                alt="{{ $post->title }}" 
                class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-105"
            >
        </div>
    @endif

</div>




