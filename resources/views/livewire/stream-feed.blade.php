<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($this->streams as $stream)
    <x-blog.stream-card :stream="$stream" wire:key="stream-{{ $stream->id }}" />
    <livewire:stream-room />
    @empty
    <div class="col-span-full p-12 text-center border-2 border-dashed rounded-xl">
        <p class="text-gray-500">No active streams at the moment.</p>
    </div>
    @endforelse

    <div class=" mx-auto py-10">
        <h1 class="text-3xl font-extrabold mb-8">Live Feed</h1>
        <x-blog.stream-card :stream="$stream"/>
        @if($activeStream)
        <livewire:stream-room :stream="$activeStream" />
        @else
        <div class="bg-gray-100 rounded-2xl p-12 text-center">
            <p class="text-gray-500 text-lg">No live streams currently active</p>
        </div>
        @endif
        {{-- --}}
    </div>
</div>