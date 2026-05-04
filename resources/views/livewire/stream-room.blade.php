<div>
    <div
  x-data="livekitRoom({
    token: @js($token),
    url: @js($livekitUrl)
  })"
  x-init="init()"
  wire:ignore



        class="max-w-7xl mx-auto px-4 py-8 lg:py-12">

        <!-- GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- 🎥 VIDEO AREA -->
            <div class="lg:col-span-8 space-y-4">

                <!-- MAIN VIDEO -->
                <div class="relative bg-black rounded-2xl overflow-hidden shadow-xl">

                    <!-- Local Video -->
                    <video
                        id="localVideo"
                        autoplay
                        muted
                        class="w-full h-[420px] md:h-[520px] object-cover"></video>

                    <!-- LIVE BADGE -->
                    <div class="absolute top-4 left-4 flex items-center gap-2 bg-white/60 backdrop-blur px-3 py-1.5 rounded-full text-sm">
                        <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                        <span>LIVE</span>
                    </div>

                    <!-- VIEWERS -->
                    <div class="absolute top-4 right-4 bg-black/60 backdrop-blur px-3 py-1.5 rounded-full text-sm">
                        👁 {{ $viewerCount }}
                    </div>

                </div>

                <!-- REMOTE GRID -->
                <div id="remoteVideos" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3"></div>

            </div>

            <!-- 💬 SIDEBAR -->
            <div class="lg:col-span-4">

                <div class="flex flex-col h-[520px] bg-gray-900 text-white rounded-2xl shadow-xl overflow-hidden">

                    <!-- HEADER -->
                    <div class="flex items-center justify-between px-4 py-3 border-b border-white/10">
                        <h3 class="font-semibold text-lg">Live Chat</h3>
                        <span class="text-xs text-gray-400">
                            {{ $viewerCount }} watching
                        </span>
                    </div>

                    <!-- CHAT BODY -->
                    <div class="flex-1 overflow-y-auto px-4 py-3 space-y-3 scrollbar-thin scrollbar-thumb-gray-700">
                        @livewire('chat', ['room' => $stream->livekit_room])
                    </div>

                </div>

            </div>

        </div>

        <!-- 🎬 HOST CONTROL -->
         
        <template x-if="isHost">
            <button
                @click="startPublishing()"
                class="fixed bottom-6 right-6 flex items-center gap-2 bg-red-600 hover:bg-red-700 active:scale-95 transition px-6 py-3 rounded-full shadow-lg text-white font-medium">
                <span class="w-2 h-2 bg-green-400 text-red-500 rounded-full animate-pulse"></span>
                Go Live
            </button>
        </template>


            <!-- DEBUG -->
            <div class="text-red-500" x-text="'isHost: ' + isHost"></div>

            <button
                x-show="isHost"
                x-transition
                @click="startPublishing()"
                class="fixed z-50 bottom-6 right-6 flex items-center gap-2 bg-red-600 hover:bg-red-700 active:scale-95 transition px-6 py-3 rounded-full shadow-lg text-white font-medium">
                <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                Go Live
            </button>

            <button
                x-show="isLive"
                x-transition
                @click="stopPublishing()"
                class="fixed z-50 bottom-6 right-6 flex items-center gap-2 bg-red-600 hover:bg-red-700 active:scale-95 transition px-6 py-3 rounded-full shadow-lg text-white font-medium">
                <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                Stop Live
            </button>

            


        <div class="fixed bottom-6 right-6 flex gap-2">

            <!-- GO LIVE -->
            <button
                x-show="(isHost || isSpeaker) && !isLive"
                @click="startPublishing()"
                class="bg-red-600 text-white px-4 py-2 rounded">
                Go Live
            </button>

            <!-- LIVE -->
            <div x-show="isLive" class="bg-green-600 text-white px-4 py-2 rounded">
                ● Live
            </div>

            <!-- RECORD -->
            <button wire:click="startRecording" class="bg-blue-600 text-white px-4 py-2 rounded">
                Record
            </button>

            <button wire:click="stopRecording" class="bg-gray-800 text-white px-4 py-2 rounded">
                Stop
            </button>
        </div>

    </div>


</div>