@php
$data = $getState();
$type = $data['type'] ?? null;
@endphp
<div class="relative overflow-hidden transition-all duration-200 bg-white border border-gray-200 shadow-sm rounded-xl ring-1 ring-gray-900/5 dark:bg-gray-900 dark:border-gray-700">
    @if($data && $type)
    <div class="flex flex-col">

        {{-- VIDEO: YouTube / Vimeo / Embeds --}}
        @if(in_array($type, ['youtube', 'video_embed']) && !empty($data['embed_url']))
        <div class="w-full bg-black aspect-video" wire:ignore>
            <iframe
                src="{{ $data['embed_url'] }}"
                class="w-full h-full"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen
                referrerpolicy="strict-origin-when-cross-origin"
                loading="lazy">
            </iframe>
        </div>
        @endif

        {{-- DIRECT VIDEO FILE (MP4, WebM) --}}
        @if($type === 'video_file' && !empty($data['embed_url']))
        <div class="w-full bg-black aspect-video">
            <video
                class="w-full h-full"
                controls
                preload="metadata"
                playsinline>
                <source src="{{ $data['embed_url'] }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        @endif

        <div class="flex flex-col sm:flex-row">
            {{-- 2. Thumbnail Section (For Links/Images or if video is just a link) --}}
            @if(!in_array($type, ['youtube', 'vimeo']) && ($data['image'] ?? null))
            <div class="shrink-0 sm:w-1/3">
                <img src="{{ $data['image'] }}"
                    alt="Preview"
                    class="object-cover w-full h-48 sm:h-full max-h-64">
            </div>
            @endif

            {{-- 3. Content Section --}}
            <div @class([ 'flex flex-col justify-between p-4 flex-1' , 'sm:w-2/3'=> !in_array($type, ['youtube', 'vimeo']) && ($data['image'] ?? null)
                ])>
                <div>
                    {{-- Type Badge --}}
                    <div class="flex items-center gap-2 mb-2">
                        @php
                        $badgeColor = match($type) {
                        'youtube' => 'bg-red-600',
                        'video', 'vimeo' => 'bg-purple-600',
                        'image' => 'bg-green-600',
                        default => 'bg-blue-600',
                        };
                        @endphp
                        <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white {{ $badgeColor }} rounded">
                            {{ $type }}
                        </span>
                    </div>

                    <h4 class="text-base font-semibold leading-tight text-gray-900 dark:text-white line-clamp-2">
                        {{ $data['title'] ?? 'No Title Found' }}
                    </h4>

                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 line-clamp-3">
                        {{ $data['description'] ?? 'No description available for this link.' }}
                    </p>
                </div>

                {{-- Link Footer --}}
                <div class="flex items-center gap-2 mt-4 text-xs font-medium text-primary-600 dark:text-primary-400 truncate">
                    {{-- <x-heroicon-m-link class="w-4 h-4 shrink-0" /> --}}
                    <a href="{{ $data['url'] ?? '#' }}" target="_blank" class="truncate hover:underline">
                        {{ $data['url'] ?? 'Source Link' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    @else
    {{-- Empty State --}}
    <div class="flex flex-col items-center justify-center p-8 text-center bg-gray-50/50 dark:bg-gray-800/50">
        <div class="p-3 mb-3 border border-gray-200 rounded-full bg-white dark:bg-gray-900 dark:border-gray-700">
            <x-heroicon-o-link class="w-6 h-6 text-gray-400" />
        </div>
        <span class="text-sm font-medium text-gray-900 dark:text-white">Preview is empty</span>
        <span class="max-w-[200px] mt-1 text-xs text-gray-500">
            Enter a valid URL and click the sparkle icon to generate a preview.
        </span>
    </div>
    @endif
</div>


{{-- @php
    $data = $getState();
@endphp

@if($data)
    <div class="flex flex-col gap-4 p-4 border rounded-lg bg-gray-50 dark:bg-gray-800">
        <div class="flex items-center gap-4">
            @if(!empty($data['image']))
                <img src="{{ $data['image'] }}" class="w-24 h-24 object-cover rounded-md shadow">
            @endif
            <div class="flex-1">
                <h4 class="font-bold text-lg">{{ $data['title'] ?? 'No Title Found' }}</h4>
                <p class="text-sm text-gray-500 line-clamp-2">{{ $data['description'] ?? 'No description available.' }}</p>
                <span class="text-xs font-mono text-primary-600">{{ $data['type'] ?? 'website' }}</span>
            </div>
        </div>
    </div>
@else
    <div class="p-4 border border-dashed rounded-lg text-gray-400 text-center">
        No preview data available. Enter a URL to fetch metadata.
    </div>
@endif --}}



