<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($streams as $stream)
        <div class="border rounded-xl p-4 bg-white shadow-sm">
            <h3 class="font-bold text-lg">{{ $stream->title }}</h3>
            <p class="text-gray-500 text-sm line-clamp-2">{{ $stream->description }}</p>
            
            <div class="mt-4 flex justify-between items-center">
                <span class="text-xs font-mono text-gray-400">Host: {{ $stream->host->name }}</span>
                
                <a href="{{ route('streams.show', $stream) }}" 
                   wire:navigate
                   class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition">
                    Join Stream
                </a>
            </div>
        </div>
    @endforeach
</div>