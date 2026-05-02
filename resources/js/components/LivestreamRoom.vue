<template>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            
            <div class="lg:col-span-3 space-y-4">
                <div class="relative bg-black rounded-2xl shadow-2xl overflow-hidden aspect-video border border-gray-800">
                    <video ref="videoEl" autoplay playsinline class="w-full h-full object-cover" :muted="isHost" />

                    <div class="absolute top-4 left-4 flex gap-2">
                        <span v-if="isLive" class="flex items-center gap-1.5 px-3 py-1 bg-red-600 text-white text-xs font-bold uppercase tracking-wider rounded-full animate-pulse">
                            <span class="w-2 h-2 bg-white rounded-full"></span> Live
                        </span>
                    </div>
                </div>

                <div class="flex justify-between items-start bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ title }}</h1>
                        <p class="text-gray-500 mt-1">{{ description }}</p>
                    </div>

                    <div class="flex gap-2">
                        <button v-if="isHost && !isPublishing" @click="startStream" 
                            class="bg-indigo-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-indigo-700 transition-all shadow-lg">
                            Start Broadcast
                        </button>

                        <button v-if="isHost && isPublishing" @click="endStream" 
                            class="bg-red-50 text-red-600 px-6 py-2 rounded-xl font-bold hover:bg-red-100 transition-all">
                            End Stream
                        </button>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 flex flex-col bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden h-[600px] lg:h-auto">
                <div class="p-4 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-bold text-gray-800">Live Conversation</h3>
                </div>

                <div class="flex-1 overflow-y-auto p-4 space-y-4 scroll-smooth" ref="chatContainer">
                    <div v-for="msg in messages" :key="msg.id" class="group flex flex-col">
                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-tight">{{ msg.sender }}</span>
                        <p class="text-sm text-gray-700 leading-relaxed bg-gray-50 rounded-lg p-2 mt-1">{{ msg.content }}</p>
                    </div>
                </div>

                <div class="p-4 border-t border-gray-100">
                    <form @submit.prevent="sendMessage" class="relative">
                        <input type="text" v-model="chatInput" placeholder="Send a message..."
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
</template>

<script>
export default {
    name: 'LivestreamRoom',
    props: {
        token: String,
        url: String,
        isHost: Boolean,
        title: String,
        description: String
    },
    data() {
        return {
            isLive: false,
            isPublishing: false,
            messages: [],
            chatInput: '',
            videoEl: null,
            room: null,
            lk: null
        };
    },
    mounted() {
        this.videoEl = this.$refs.videoEl;
        this.initializeLiveKit();
    },
    methods: {
        async initializeLiveKit() {
            try {
                this.lk = await import('https://esm.sh/livekit-client@2.0.0');
                this.room = new this.lk.Room();

                this.room.on(this.lk.RoomEvent.Connected, () => console.log("Connected to LiveKit"));
                this.room.on(this.lk.RoomEvent.ConnectFailed, (error) => console.error("Connection Failed:", error));
                this.room.on(this.lk.RoomEvent.Disconnected, () => {
                    this.isLive = false;
                    this.isPublishing = false;
                });

                this.room.on(this.lk.RoomEvent.DataReceived, (payload, participant) => {
                    try {
                        const decoder = new TextDecoder();
                        const data = JSON.parse(decoder.decode(payload));
                        if (data.type === 'chat') {
                            this.messages.push({
                                id: Date.now() + Math.random(),
                                sender: participant.name || 'Guest',
                                content: data.message
                            });
                        }
                    } catch (e) {
                        console.error("Failed to parse data", e);
                    }
                });

                this.room.on(this.lk.RoomEvent.TrackSubscribed, (track) => {
                    if (track.kind === 'video' || track.kind === 'audio') {
                        track.attach(this.videoEl);
                        this.isLive = true;
                    }
                });

                await this.room.connect(this.url, this.token);
            } catch (e) {
                console.error("Critical Connection Error:", e);
            }
        },
        async startStream() {
            if (!this.isHost) return;

            try {
                const videoTrack = await this.lk.createLocalVideoTrack({
                    resolution: { width: 1280, height: 720 }
                });
                const audioTrack = await this.lk.createLocalAudioTrack();

                await this.room.localParticipant.publishTrack(videoTrack);
                await this.room.localParticipant.publishTrack(audioTrack);

                videoTrack.attach(this.videoEl);
                this.isPublishing = true;
                this.isLive = true;
            } catch (error) {
                console.error("Failed to publish tracks:", error);
                alert("Could not access camera or microphone.");
            }
        },
        async endStream() {
            if (this.room) {
                this.room.localParticipant.videoTracks.forEach(publication => {
                    publication.track.stop();
                });
                await this.room.disconnect();
            }

            this.isLive = false;
            this.isPublishing = false;
            if (this.videoEl) this.videoEl.srcObject = null;
        },
        sendMessage() {
            const content = this.chatInput.trim();
            if (!content) return;

            this.messages.push({
                id: Date.now() + Math.random(),
                sender: 'You',
                content
            });
            this.chatInput = '';

            const encoder = new TextEncoder();
            const payload = encoder.encode(JSON.stringify({
                type: 'chat',
                message: content
            }));

            try {
                this.room.localParticipant.publishData(payload, { reliable: true });
            } catch (e) {
                console.error("Message send failed:", e);
            }
        }
    }
};
</script>