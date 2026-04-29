<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($this->streams as $stream)
        <x-blog.stream-card :stream="$stream" wire:key="stream-{{ $stream->id }}" />
    @empty
        <div class="col-span-full p-12 text-center border-2 border-dashed rounded-xl">
            <p class="text-gray-500">No active streams at the moment.</p>
        </div>
    @endforelse
</div>