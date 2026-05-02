<div>
    <div wire:ignore
        id="vue-stream-app"
        data-token="{{ $this->livekitToken }}"
        data-url="{{ $this->livekitUrl }}"
        data-host="{{ $isHost ? 'true' : 'false' }}"
        data-title="{{ $stream->title }}"
        data-description="{{ $stream->description }}">
    </div>

    <div class="fixed bottom-4 right-4 bg-black text-white px-4 py-2 rounded-full shadow-lg z-50 border border-gray-800">
        {{ $viewerCount }} Viewers
    </div>
</div>
