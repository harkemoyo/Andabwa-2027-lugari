@props(['stream'])

<div {{ $attributes->merge(['class' => 'border rounded-xl p-4 bg-white shadow-sm transition hover:shadow-md']) }}>
    <div class="flex justify-between items-start">
        <h3 class="font-bold text-lg text-gray-900">{{ $stream->title }}</h3>
        @if($stream->status === 'live')
            <span class="flex h-2 w-2 mt-2">
                <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
            </span>
        @endif
    </div>
    
    <p class="text-gray-500 text-sm line-clamp-2 mt-1">{{ $stream->description }}</p>
    
    <div class="mt-4 flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <div class="w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center text-[10px] font-bold text-indigo-600">
                {{ strtoupper(substr($stream->host->name, 0, 2)) }}
            </div>
            <span class="text-xs font-medium text-gray-600">{{ $stream->host->name }}</span>
        </div>
        
        <a href="{{ route('streams.show', $stream) }}" 
           wire:navigate
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition">
            {{ $stream->status === 'live' ? 'Join Stream' : 'View Details' }}
        </a>
    </div>
</div>