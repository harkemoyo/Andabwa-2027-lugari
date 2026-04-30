<style>
    [x-cloak] {
        display: none !important;
    }
</style>
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8" x-data="livekitStream({
    token: '{{ $this->livekitToken }}',
    url: '{{ $this->livekitUrl }}',
    isHost: {{ $isHost ? 'true' : 'false' }},
    isLive: {{ $this->isLive ? 'true' : 'false' }},
    userName: '{{ auth()->user()->name }}'
})">

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <div class="lg:col-span-3 space-y-4">
            <div class="relative bg-black rounded-2xl shadow-2xl overflow-hidden aspect-video border border-gray-800">
                <video id="stream-video" autoplay playsinline class="w-full h-full object-cover" :muted="isHost"></video>

                <div class="absolute top-4 left-4 flex gap-2">
                    <template x-if="isLive">
                        <span class="flex items-center gap-1.5 px-3 py-1 bg-red-600 text-white text-xs font-bold uppercase tracking-wider rounded-full animate-pulse">
                            <span class="w-2 h-2 bg-white rounded-full"></span> Live
                        </span>
                    </template>
                    <span class="px-3 py-1 bg-black/50 backdrop-blur-md text-white text-xs font-semibold rounded-full border border-white/20">
                        {{ $viewerCount }} Viewers
                    </span>
                </div>
            </div>

            <div class="flex justify-between items-start bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $stream->title }}</h1>
                    <p class="text-gray-500 mt-1">{{ $stream->description }}</p>
                </div>
                {{--

           <div class="flex gap-2">
                    @if($isHost)
                    <button x-show="!isLive" @click="startStream" class="inline-flex items-center px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-200">
                        Start Broadcast
                    </button>
                    <button x-show="isLive" @click="endStream" class="px-6 py-2.5 bg-gray-100 hover:bg-red-50 text-red-600 font-bold rounded-xl transition-all">
                        End Stream
                    </button>
                    @endif
                </div>
           
           --}}

                <div class="flex gap-2">
                    {{-- Blade handles the "Host Only" security --}}
                    @if($isHost)
                    <button
                        x-show="!isLive"
                        @click="startStream"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-xl">
                        Start Broadcast
                    </button>

                    <button
                        x-show="isLive"
                        x-cloak {{-- x-cloak prevents the button from flashing on load --}}
                        @click="endStream"
                        class="bg-red-600 text-red px-6 py-2 rounded-xl">
                        End Stream
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 flex flex-col bg-white border-0.5 border-gray-200 rounded-2xl shadow-sm hoer:shadow-md overflow-hidden h-[600px] lg:h-auto">
            <div class="p-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="font-bold text-gray-800">Live Conversation</h3>
            </div>

            <div class="flex-1 overflow-y-auto p-4 space-y-4 scroll-smooth" id="chat-container">
                <template x-for="msg in messages" :key="msg.id">
                    <div class="group flex flex-col">
                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-tight" x-text="msg.sender"></span>
                        <p class="text-sm text-gray-700 leading-relaxed bg-gray-50 rounded-lg p-2 mt-1 group-hover:bg-gray-100 transition-colors" x-text="msg.content"></p>
                    </div>
                </template>
                <div id="chat-anchor"></div>
            </div>

            <div class="p-4 border-t border-gray-100">
                <form @submit.prevent="sendMessage" class="relative">
                    <input type="text" x-model="chatInput" placeholder="Send a message..."
                        class="w-full pl-4 pr-12 py-3 bg-gray-100 border-none rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 transition-all">
                    <button type="submit" class="absolute right-2 top-2 p-1.5 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5 rotate-90" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


@script
<script>
    // PRO FIX: Removed type="module". This is now a standard script.
    
    document.addEventListener('alpine:init', () => {
        Alpine.data('livekitStream', (config) => ({
            room: null,
            isLive: config.isLive || false,
            isHost: config.isHost,
            messages: [],
            chatInput: '',
            videoEl: null,
            encoder: new TextEncoder(),
            decoder: new TextDecoder(),
            // We will store the LiveKit library instance here once loaded
            lk: null, 

            async init() {
                console.log("🔍 Alpine check - IsHost:", this.isHost);
                this.videoEl = document.getElementById('stream-video');
                
                // 1. DYNAMICALLY IMPORT LIVEKIT
                // This replaces the module import at the top of the file
                this.lk = await import('https://esm.sh/livekit-client@2.0.0');
                
                this.room = new this.lk.Room();

                // --- EVENT LISTENERS ---
                this.room.on(this.lk.RoomEvent.Connected, () => console.log("✅ Connected to LiveKit SFU"));
                this.room.on(this.lk.RoomEvent.ConnectFailed, (error) => console.error("❌ Connection Failed:", error));
                this.room.on(this.lk.RoomEvent.Disconnected, () => {
                    this.isLive = false;
                    console.log("🔌 Disconnected from Room");
                });

                // 2. Real-time Chat Listener
                this.room.on(this.lk.RoomEvent.DataReceived, (payload, participant) => {
                    try {
                        const data = JSON.parse(this.decoder.decode(payload));
                        if (data.type === 'chat') {
                            this.appendMessage(participant.name || 'Guest', data.message);
                        }
                    } catch (e) {
                        console.error("Failed to parse incoming data", e);
                    }
                });

                // 3. Video Track Handling (For Viewers)
                this.room.on(this.lk.RoomEvent.TrackSubscribed, (track) => {
                    if (track.kind === 'video' || track.kind === 'audio') {
                        track.attach(this.videoEl);
                        this.isLive = true;
                    }
                });

                // --- CONNECT ---
                try {
                    await this.room.connect(config.url, config.token);
                } catch (e) {
                    console.error("Critical Connection Error:", e);
                }
            },

            async startStream() {
                if (!this.isHost) return;
                console.log("🎬 Publishing Phase Started...");

                // First, update backend status
                await $wire.startStream();

                try {
                    // Request High-Quality Media using the dynamically loaded library
                    const videoTrack = await this.lk.createLocalVideoTrack({
                        resolution: { width: 1280, height: 720 }
                    });
                    const audioTrack = await this.lk.createLocalAudioTrack();

                    // Publish to SFU
                    await this.room.localParticipant.publishTrack(videoTrack);
                    await this.room.localParticipant.publishTrack(audioTrack);

                    // Attach locally for the host to see
                    videoTrack.attach(this.videoEl);
                    this.isLive = true;

                    console.log("📡 Stream is now PUBLISHING live!");
                } catch (error) {
                    console.error("Failed to publish tracks:", error);
                    alert("Could not access camera or microphone.");
                }
            },

            async sendMessage() {
                const content = this.chatInput.trim();
                if (!content) return;

                // UI Update
                this.appendMessage('You', content);
                this.chatInput = '';

                // Transmit via LiveKit
                const payload = this.encoder.encode(JSON.stringify({
                    type: 'chat',
                    message: content
                }));

                try {
                    await this.room.localParticipant.publishData(payload, { reliable: true });
                    $wire.saveChatMessage(content);
                } catch (e) {
                    console.error("Message send failed:", e);
                }
            },

            appendMessage(sender, content) {
                this.messages.push({
                    id: Date.now() + Math.random(),
                    sender,
                    content
                });

                this.$nextTick(() => {
                    const container = document.getElementById('chat-container');
                    if (container) container.scrollTop = container.scrollHeight;
                });
            },

            async endStream() {
                if (this.room) {
                    this.room.localParticipant.videoTracks.forEach(publication => {
                        publication.track.stop();
                    });
                    await this.room.disconnect();
                }
                
                this.isLive = false;
                if (this.videoEl) this.videoEl.srcObject = null;
                
                await $wire.markStreamAsEnded();
            }
        }));
    });
</script>
@endscript

{{-- 

@script
<script>
    // PRO FIX: Removed type="module". This is now a standard script.

    document.addEventListener('alpine:init', () => {
        Alpine.data('livekitStream', (config) => ({
            room: null,
            isLive: config.isLive || false,
            isHost: config.isHost,
            messages: [],
            chatInput: '',
            videoEl: null,
            encoder: new TextEncoder(),
            decoder: new TextDecoder(),
            // We will store the LiveKit library instance here once loaded
            lk: null,

            async init() {
                console.log("🔍 Alpine check - IsHost:", this.isHost);
                this.videoEl = document.getElementById('stream-video');

                // 1. DYNAMICALLY IMPORT LIVEKIT
                // This replaces the module import at the top of the file
                this.lk = await import('https://esm.sh/livekit-client@2.0.0');

                this.room = new this.lk.Room();

                // --- EVENT LISTENERS ---
                this.room.on(this.lk.RoomEvent.Connected, () => console.log("✅ Connected to LiveKit SFU"));
                this.room.on(this.lk.RoomEvent.ConnectFailed, (error) => console.error("❌ Connection Failed:", error));
                this.room.on(this.lk.RoomEvent.Disconnected, () => {
                    this.isLive = false;
                    console.log("🔌 Disconnected from Room");
                });

                // 2. Real-time Chat Listener
                this.room.on(this.lk.RoomEvent.DataReceived, (payload, participant) => {
                    try {
                        const data = JSON.parse(this.decoder.decode(payload));
                        if (data.type === 'chat') {
                            this.appendMessage(participant.name || 'Guest', data.message);
                        }
                    } catch (e) {
                        console.error("Failed to parse incoming data", e);
                    }
                });

                // 3. Video Track Handling (For Viewers)
                this.room.on(this.lk.RoomEvent.TrackSubscribed, (track) => {
                    if (track.kind === 'video' || track.kind === 'audio') {
                        track.attach(this.videoEl);
                        this.isLive = true;
                    }
                });

                // --- CONNECT ---
                try {
                    await this.room.connect(config.url, config.token);
                } catch (e) {
                    console.error("Critical Connection Error:", e);
                }
            },

            async startStream() {
                if (!this.isHost) return;
                console.log("🎬 Publishing Phase Started...");

                try {
                    // Request High-Quality Media using the dynamically loaded library
                    const videoTrack = await this.lk.createLocalVideoTrack({
                        resolution: {
                            width: 1280,
                            height: 720
                        }
                    });
                    const audioTrack = await this.lk.createLocalAudioTrack();

                    // Publish to SFU
                    await this.room.localParticipant.publishTrack(videoTrack);
                    await this.room.localParticipant.publishTrack(audioTrack);

                    // Attach locally for the host to see
                    videoTrack.attach(this.videoEl);
                    this.isLive = true;

                    console.log("📡 Stream is now PUBLISHING live!");
                } catch (error) {
                    console.error("Failed to publish tracks:", error);
                    alert("Could not access camera or microphone.");
                }
            },

            async sendMessage() {
                const content = this.chatInput.trim();
                if (!content) return;

                // UI Update
                this.appendMessage('You', content);
                this.chatInput = '';

                // Transmit via LiveKit
                const payload = this.encoder.encode(JSON.stringify({
                    type: 'chat',
                    message: content
                }));

                try {
                    await this.room.localParticipant.publishData(payload, {
                        reliable: true
                    });
                    $wire.saveChatMessage(content);
                } catch (e) {
                    console.error("Message send failed:", e);
                }
            },

            appendMessage(sender, content) {
                this.messages.push({
                    id: Date.now() + Math.random(),
                    sender,
                    content
                });

                this.$nextTick(() => {
                    const container = document.getElementById('chat-container');
                    if (container) container.scrollTop = container.scrollHeight;
                });
            },

            async endStream() {
                if (this.room) {
                    this.room.localParticipant.videoTracks.forEach(publication => {
                        publication.track.stop();
                    });
                    await this.room.disconnect();
                }

                this.isLive = false;
                if (this.videoEl) this.videoEl.srcObject = null;

                await $wire.markStreamAsEnded();
            }
        }));
    });
</script>
@endscript

--}}
