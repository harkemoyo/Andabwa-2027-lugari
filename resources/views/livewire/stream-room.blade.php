<div
    x-data="livekitRoom({
        token: @js($token),
        url: @js($livekitUrl),
        isHost: @js($isHost)
    })"
    x-cloak
    class="relative min-h-screen bg-slate-transparent text-white">
    <!-- Main Interface -->
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- Video Stage -->
            <div class="lg:col-span-8 space-y-4">
                <div class="relative aspect-video bg-black rounded-3xl overflow-hidden ring-1 ring-white/10 shadow-2xl">

                    <!-- Local Camera (Host View) -->
                    <video id="localVideo" x-show="isHost" autoplay muted class="w-full h-full object-cover"></video>

                    <!-- Remote Stream (Viewer View) -->
                    <div id="remoteVideos" x-show="!isHost" class="w-full h-full bg-slate-900"></div>

                    <!-- Status Badges -->
                    <div class="absolute top-4 left-4 flex gap-2">
                        <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-black/40 backdrop-blur-md border border-white/10">
                            <span class="w-2 h-2 rounded-full" :class="isLive ? 'bg-red-500 animate-pulse' : 'bg-slate-500'"></span>
                            <span class="text-[10px] font-bold tracking-widest uppercase" x-text="isLive ? 'Live' : 'Preview'"></span>
                        </div>
                    </div>
                </div>

                <!-- Info Bar -->
                <div class="flex items-center justify-between p-4 bg-slate-900/50 rounded-2xl border border-white/5">
                    <div>
                        <h1 class="text-xl font-bold">{{ $stream->title }}</h1>
                        <p class="text-slate-400 text-sm">Hosted by {{ $stream->user?->name ?? 'Unknown' }}</p>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-4 h-[560px]">
                <div class="flex flex-col h-full bg-slate-900 rounded-3xl border border-white/10 overflow-hidden">
                    <div class="p-4 border-b border-white/5 bg-white/5">
                        <h3 class="font-bold">Live Interaction</h3>
                    </div>
                    <div class="flex-1 overflow-hidden" wire:ignore>
                        @livewire('chat', ['room' => $stream->livekit_room ?? $stream->uuid ?? (string) $stream->id])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Production Control Bar (Floating) -->
    <template x-if="isHost">
        <div
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-10"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="fixed bottom-8 left-1/2 -translate-x-1/2 z-50 w-full max-w-md">
            <div class="mx-4 p-3 bg-slate-900/90 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl flex items-center justify-between gap-4">
                <div class="flex items-center gap-3 pl-2">
                    <div class="w-10 h-10 rounded-full bg-red-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-white uppercase tracking-tighter">Stream Control</p>
                        <p class="text-[10px] text-slate-400" x-text="isLive ? 'Stream is active' : 'Ready to broadcast'"></p>
                    </div>
                </div>

                <button
                    @click="isLive ? stopPublishing() : startPublishing()"
                    :class="isLive ? 'bg-slate-700 hover:bg-slate-600' : 'bg-red-600 hover:bg-red-500'"
                    class="px-6 py-2.5 rounded-xl font-bold text-sm transition-all active:scale-95 shadow-lg">
                    <span x-text="isLive ? 'Stop Stream' : 'Go Live'"></span>
                </button>
            </div>
        </div>
    </template>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('livekitRoom', (config) => ({
            room: null,
            token: config.token,
            url: config.url,
            isHost: config.isHost,
            isLive: false,
            async init() {
                // Import LiveKit Client dynamically to avoid SSR issues
                const {
                    Room,
                    RoomEvent,
                    VideoPresets
                } = await import('livekit-client');

                this.room = new Room({
                    adaptiveStream: true,
                    dynacast: true,
                    publishDefaults: {
                        videoSimulcast: true,
                        videoCodec: 'vp8',
                        videoEncoding: VideoPresets.h720.encoding,
                    },
                });

                // Handle Incoming Streams (Viewers)
                this.room.on(RoomEvent.TrackSubscribed, (track, publication, participant) => {
                    if (track.kind === 'video') {
                        const el = track.attach();
                        el.className = "w-full h-full object-cover";
                        document.getElementById('remoteVideos').appendChild(el);
                    }
                });

                try {
                    await this.room.connect(this.url, this.token);
                    console.log('Successfully connected to LiveKit');
                } catch (error) {
                    console.error('Connection failed:', error);
                }
            },

            async startPublishing() {
                try {
                    await this.room.localParticipant.enableCameraAndMicrophone();
                    const videoTrack = this.room.localParticipant.getTrack('camera');

                    if (videoTrack && this.isHost) {
                        const localVideo = document.getElementById('localVideo');
                        videoTrack.track.attach(localVideo);
                    }

                    this.isLive = true;
                } catch (e) {
                    console.error('Publishing error:', e);
                }
            },

            async stopPublishing() {
                await this.room.localParticipant.setCameraEnabled(false);
                await this.room.localParticipant.setMicrophoneEnabled(false);
                this.isLive = false;
            }
        }));
    });
</script>