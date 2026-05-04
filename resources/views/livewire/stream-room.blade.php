<div x-data="livekitRoom({ 
     token: @js($token), 
     url: @js($livekitUrl), 
     isHost: {{ auth()->id() === $stream->user_id ? 'true' : 'false' }} })"
     x-init="init()" class="grid grid-cols-12 gap-4">
    <!-- VIDEO -->
    <div class="col-span-9">
        <video id="localVideo" autoplay muted class="w-full rounded-xl"></video>
        <div id="remoteVideos" class="grid grid-cols-2 gap-2 mt-4"></div>
    </div>
    <!-- SIDEBAR -->
    <div class="col-span-3 bg-gray-900 text-white p-4 rounded-xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold">Live</h3>
            <span class="text-sm">
                👁 {{ $viewerCount }} watching
            </span>
        </div>
        <!-- CHAT -->
        @livewire('chat', ['room' => $stream->livekit_room])
    </div>

    <!-- HOST BUTTON -->
    <template x-if="isHost">
        <button
            @click="startPublishing()"
            class="fixed bottom-6 right-6 bg-red-600 px-6 py-3 rounded-full">
            🔴 Go Live
        </button>
    </template>

</div>