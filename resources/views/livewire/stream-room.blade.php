<style>
    [x-cloak] {
        display: none !important;
    }
</style>
<div
    x-data="livekitRoom({
        token: @js($token),
        url: @js($livekitUrl),
        isHost: @js($isHost)
    })"
    x-init="
    init();

    setTimeout(() => {
        uiReady = true;
    }, 1000);
"
    x-cloak
    class="relative min-h-screen bg-transparent text-white">

    <!-- MAIN -->
    <div class="max-w-7xl mx-auto px-4 py-6">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- VIDEO AREA -->
            <div class="lg:col-span-8 space-y-4">

                <div class="relative aspect-video bg-black rounded-3xl overflow-hidden ring-1 ring-white/10 shadow-2xl">

                    <!-- HOST VIDEO -->
                    <div
                        id="localVideo"
                        x-show="isHost"
                        class="w-full h-full bg-black">
                    </div>

                    <!-- VIEWER VIDEO -->
                    <div
                        id="remoteVideos"
                        x-show="!isHost"
                        class="w-full h-full bg-slate-900">
                    </div>

                    <!-- STATUS -->
                    <div class="absolute top-4 left-4 flex gap-2">

                        <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-black/40 backdrop-blur-md border border-white/10">

                            <span
                                class="w-2 h-2 rounded-full"
                                :class="isLive ? 'bg-red-500 animate-pulse' : 'bg-slate-500'">
                            </span>

                            <span
                                class="text-[10px] font-bold tracking-widest uppercase"
                                x-text="isLive ? 'Live' : 'Preview'">
                            </span>

                        </div>

                    </div>

                </div>

                <!-- STREAM INFO -->
                <div class="flex items-center justify-between p-4 bg-slate-900 rounded-2xl border border-white/5">

                    <div>
                        <h1 class="text-xl font-bold">
                            {{ $stream->title }}
                        </h1>

                        <p class="text-slate-300 text-sm">
                            Hosted by {{ $stream->user?->name ?? 'Unknown' }}
                        </p>
                    </div>

                </div>

            </div>

            <!-- SIDEBAR -->
            <div class="lg:col-span-4 h-[560px]">

                <div class="flex flex-col h-full bg-slate-900 rounded-3xl border border-white/10 overflow-hidden">

                    <div class="p-4 border-b border-white/5 bg-white/5">
                        <h3 class="font-bold">Live Interaction</h3>
                    </div>

                    <div class="flex-1 overflow-hidden p-4" wire:ignore>

                        @livewire('chat', [
                        'room' => $stream->livekit_room
                        ?? $stream->uuid
                        ?? (string) $stream->id
                        ])

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- CONTROL BAR -->
    <div
        x-show="isHost && uiReady"
        x-transition
        class="fixed bottom-8 left-1/2 -translate-x-1/2 z-50 w-full max-w-md">

        <div class="mx-4 p-3 bg-slate-900 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl flex items-center justify-between gap-4">

            <!-- LEFT -->
            <div class="flex items-center gap-3 pl-2">

                <div class="w-10 h-10 rounded-full bg-red-500/10 flex items-center justify-center">

                    <svg
                        class="w-5 h-5 text-red-500"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>

                </div>

                <div>

                    <p class="text-xs font-bold uppercase tracking-widest">
                        Stream Control
                    </p>

                    <p
                        class="text-[10px] text-slate-400"
                        x-text="isLive ? 'Stream is active' : 'Ready to broadcast'">
                    </p>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="flex items-center gap-2">

                <!-- RECORD -->
                <button
                    @click="toggleRecording()"
                    :class="isRecording
                        ? 'bg-red-600 hover:bg-red-500'
                        : 'bg-slate-700 hover:bg-slate-600'"
                    class="relative p-2.5 rounded-xl transition-all active:scale-95 shadow-lg">

                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>

                    <span
                        x-show="isRecording"
                        class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full animate-pulse">
                    </span>

                </button>




                {{-- LIVE BUTTON 
                <button
                    @click="isLive ? stopPublishing() : startPublishing()"
                    :class="isLive
                        ? 'bg-slate-700 hover:bg-slate-600'
                        : 'bg-red-600 hover:bg-red-500'"
                    class="px-6 py-2.5 rounded-xl font-bold text-sm transition-all active:scale-95 shadow-lg">

                    <span x-text="isLive ? 'Stop Stream' : 'Go Live'"></span>

                </button>--}}

                <!-- LIVE BUTTON -->
                <button
                    x-bind:key="isLive ? 'live' : 'offline'"
                    @click="isLive ? stopPublishing() : startPublishing()"
                    :class="isLive
        ? 'bg-slate-700 hover:bg-slate-600'
        : 'bg-red-600 hover:bg-red-500'"
                    class="px-6 py-2.5 rounded-xl font-bold text-sm transition-all active:scale-95 shadow-lg flex items-center justify-center min-w-[140px]">

                    <!-- LIVE STATE -->
                    <template x-if="!isLive">
                        <span>Go Live</span>
                    </template>

                    <!-- STOP STATE -->
                    <template x-if="isLive">
                        <span>Stop Stream</span>
                    </template>

                </button>

            </div>

        </div>

    </div>

</div>

<script>
    document.addEventListener('alpine:init', () => {

        Alpine.data('livekitRoom', (config) => ({

            room: null,

            token: config.token,

            url: config.url,

            isHost: !!config.isHost,

            isLive: false,

            isRecording: false,

            livekit: null,

            ConnectionState: null,

            localTracks: [],

            mediaRecorder: null,

            recordedChunks: [],

            uiReady: false,

            /*
            |--------------------------------------------------------------------------
            | LOAD LIVEKIT LIBRARY
            |--------------------------------------------------------------------------
            */

            async getLib() {

                if (this.livekit) {
                    return this.livekit;
                }

                this.livekit = await import(
                    'https://cdn.jsdelivr.net/npm/livekit-client/dist/livekit-client.esm.mjs'
                );

                return this.livekit;
            },

            /*
            |--------------------------------------------------------------------------
            | INITIALIZE ROOM
            |--------------------------------------------------------------------------
            */

            async init() {

                try {

                    const lib = await this.getLib();

                    const {
                        Room,
                        RoomEvent,
                        VideoPresets,
                        ConnectionState
                    } = lib;

                    this.ConnectionState = ConnectionState;

                    // const {
                    //     Room,
                    //     RoomEvent,
                    //     VideoPresets,
                    //     ConnectionState
                    // } = await this.getLib();

                    this.room = new Room({

                        adaptiveStream: true,

                        dynacast: true,

                        publishDefaults: {

                            videoSimulcast: true,

                            videoCodec: 'vp8',

                            videoEncoding: VideoPresets.h720.encoding,
                        },
                    });

                    /*
                    |--------------------------------------------------------------------------
                    | REMOTE TRACK SUBSCRIBED
                    |--------------------------------------------------------------------------
                    */

                    this.room.on(
                        RoomEvent.TrackSubscribed,
                        (track, publication, participant) => {

                            if (track.kind === 'video') {

                                const remoteContainer =
                                    document.getElementById('remoteVideos');

                                if (!remoteContainer) return;

                                remoteContainer.innerHTML = '';

                                const element = track.attach();

                                element.className =
                                    'w-full h-full object-cover';

                                element.autoplay = true;

                                element.playsInline = true;

                                remoteContainer.appendChild(element);

                                console.log(
                                    '✅ Remote participant video attached'
                                );
                            }
                        }
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | CONNECT TO ROOM
                    |--------------------------------------------------------------------------
                    */

                    await this.room.connect(this.url, this.token);

                    console.log('✅ Connected to LiveKit');

                    /*
                    |--------------------------------------------------------------------------
                    | LOAD EXISTING TRACKS
                    |--------------------------------------------------------------------------
                    */

                    this.room.remoteParticipants.forEach((participant) => {

                        participant.trackPublications.forEach((publication) => {

                            if (
                                publication.track &&
                                publication.track.kind === 'video'
                            ) {

                                const remoteContainer =
                                    document.getElementById('remoteVideos');

                                if (!remoteContainer) return;

                                remoteContainer.innerHTML = '';

                                const element =
                                    publication.track.attach();

                                element.className =
                                    'w-full h-full object-cover';

                                element.autoplay = true;

                                element.playsInline = true;

                                remoteContainer.appendChild(element);

                                console.log(
                                    '✅ Existing remote track attached'
                                );
                            }
                        });
                    });

                } catch (error) {

                    console.error(
                        '❌ LiveKit initialization failed:',
                        error
                    );
                }
            },

            /*
            |--------------------------------------------------------------------------
            | START PUBLISHING
            |--------------------------------------------------------------------------
            */

            async startPublishing() {

                try {

                    if (this.isLive) {
                        return;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | CLEAN PREVIOUS TRACKS
                    |--------------------------------------------------------------------------
                    */

                    if (this.localTracks.length) {

                        for (const track of this.localTracks) {

                            try {

                                track.stop();

                                track.detach();

                            } catch (e) {}
                        }

                        this.localTracks = [];
                    }

                    const {
                        createLocalVideoTrack,
                        createLocalAudioTrack
                    } = await this.getLib();

                    /*
                    |--------------------------------------------------------------------------
                    | CREATE TRACKS
                    |--------------------------------------------------------------------------
                    */

                    const videoTrack =
                        await createLocalVideoTrack({

                            resolution: {

                                width: 1280,

                                height: 720,

                                frameRate: 30,
                            },
                        });

                    const audioTrack =
                        await createLocalAudioTrack();

                    /*
                    |--------------------------------------------------------------------------
                    | STORE TRACKS
                    |--------------------------------------------------------------------------
                    */

                    this.localTracks = [
                        videoTrack,
                        audioTrack
                    ];

                    /*
                    |--------------------------------------------------------------------------
                    | LOCAL PREVIEW
                    |--------------------------------------------------------------------------
                    */

                    const localContainer =
                        document.getElementById('localVideo');

                    if (localContainer) {

                        localContainer.innerHTML = '';

                        /*
                        |--------------------------------------------------------------------------
                        | VIDEO ELEMENT
                        |--------------------------------------------------------------------------
                        */

                        const videoElement =
                            videoTrack.attach();

                        videoElement.className =
                            'w-full h-full object-cover';

                        videoElement.autoplay = true;

                        videoElement.playsInline = true;

                        /*
                        |--------------------------------------------------------------------------
                        | IMPORTANT:
                        | KEEP VIDEO MUTED TO AVOID ECHO
                        |--------------------------------------------------------------------------
                        */

                        videoElement.muted = true;

                        localContainer.appendChild(videoElement);

                        /*
                        |--------------------------------------------------------------------------
                        | LOCAL AUDIO MONITOR
                        |--------------------------------------------------------------------------
                        */

                        const audioElement =
                            audioTrack.attach();

                        audioElement.autoplay = true;

                        audioElement.controls = false;

                        /*
                        |--------------------------------------------------------------------------
                        | IMPORTANT:
                        | HEAR YOUR OWN STREAM
                        |--------------------------------------------------------------------------
                        */

                        audioElement.muted = false;

                        audioElement.style.display = 'none';

                        localContainer.appendChild(audioElement);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | PUBLISH TRACKS
                    |--------------------------------------------------------------------------
                    */

                    if (
                        // this.room &&
                        // this.room.state === 'connected'
                        this.room &&
                        this.room.state === this.ConnectionState.Connected
                    ) {

                        await this.room.localParticipant.publishTrack(
                            videoTrack
                        );

                        await this.room.localParticipant.publishTrack(
                            audioTrack
                        );

                        // this.isLive = true;
                        // this.$nextTick(() => {
                        //     this.isLive = true;
                        // });

                        this.isLive = true;

                        await this.$nextTick();

                        this.uiReady = false;

                        setTimeout(() => {

                            this.uiReady = true;

                        }, 50);

                        // requestAnimationFrame(() => {

                        //     requestAnimationFrame(() => {

                        //         this.isLive = true;
                        //     });
                        // });

                        console.log(
                            '✅ Stream published successfully'
                        );

                    } else {

                        console.error(
                            '❌ Room not connected'
                        );
                    }

                } catch (error) {

                    console.error(
                        '❌ Publishing failed:',
                        error
                    );
                }
            },

            /*
            |--------------------------------------------------------------------------
            | STOP STREAM
            |--------------------------------------------------------------------------
            */

            async stopPublishing() {

                if (!this.room?.localParticipant) return;

                try {

                    /*
                    |--------------------------------------------------------------------------
                    | UNPUBLISH + STOP TRACKS
                    |--------------------------------------------------------------------------
                    */

                    for (const track of this.localTracks) {

                        try {

                            await this.room.localParticipant
                                .unpublishTrack(track);

                        } catch (e) {

                            console.warn(
                                'Track already unpublished',
                                e
                            );
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | DETACH ELEMENTS
                        |--------------------------------------------------------------------------
                        */

                        const attachedElements =
                            track.detach();

                        attachedElements.forEach(el => el.remove());

                        /*
                        |--------------------------------------------------------------------------
                        | STOP MEDIA
                        |--------------------------------------------------------------------------
                        */

                        track.stop();
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | RESET STATE
                    |--------------------------------------------------------------------------
                    */

                    this.localTracks = [];


                    await new Promise(resolve =>
                        setTimeout(resolve, 300)
                    );

                    // this.isLive = false;
                    // this.$nextTick(() => {
                    //     this.isLive = false;
                    // });

                    this.isLive = true;

                    await this.$nextTick();

                    this.uiReady = false;

                    setTimeout(() => {

                        this.uiReady = true;

                    }, 50);

                    // requestAnimationFrame(() => {

                    //     requestAnimationFrame(() => {

                    //         this.isLive = false;
                    //     });
                    // });

                    /*
                    |--------------------------------------------------------------------------
                    | STOP RECORDING IF ACTIVE
                    |--------------------------------------------------------------------------
                    */

                    if (
                        this.mediaRecorder &&
                        this.mediaRecorder.state !== 'inactive'
                    ) {

                        this.mediaRecorder.stop();
                    }

                    this.isRecording = false;

                    /*
                    |--------------------------------------------------------------------------
                    | CLEAR LOCAL VIDEO
                    |--------------------------------------------------------------------------
                    */

                    const localContainer =
                        document.getElementById('localVideo');

                    if (localContainer) {

                        localContainer.innerHTML = '';
                    }

                    console.log('✅ Stream stopped');

                } catch (error) {

                    console.error(
                        '❌ Failed to stop stream:',
                        error
                    );
                }
            },

            /*
            |--------------------------------------------------------------------------
            | RECORD STREAM
            |--------------------------------------------------------------------------
            */



            toggleRecording() {

                /*
                |--------------------------------------------------------------------------
                | REQUIRE LIVE TRACKS
                |--------------------------------------------------------------------------
                */

                if (!this.localTracks.length) {

                    alert(
                        'Start streaming before recording.'
                    );

                    return;
                }

                /*
                |--------------------------------------------------------------------------
                | START RECORDING
                |--------------------------------------------------------------------------
                */

                if (!this.isRecording) {

                    try {

                        this.recordedChunks = [];

                        /*
                        |--------------------------------------------------------------------------
                        | COMBINE VIDEO + AUDIO TRACKS
                        |--------------------------------------------------------------------------
                        */

                        const combinedStream =
                            new MediaStream();

                        this.localTracks.forEach(track => {

                            if (track.mediaStreamTrack) {

                                combinedStream.addTrack(
                                    track.mediaStreamTrack
                                );
                            }
                        });

                        /*
                        |--------------------------------------------------------------------------
                        | CREATE RECORDER
                        |--------------------------------------------------------------------------
                        */

                        this.mediaRecorder =
                            new MediaRecorder(combinedStream, {

                                mimeType: 'video/webm'
                            });

                        /*
                        |--------------------------------------------------------------------------
                        | STORE CHUNKS
                        |--------------------------------------------------------------------------
                        */

                        this.mediaRecorder.ondataavailable =
                            (event) => {

                                if (event.data.size > 0) {

                                    this.recordedChunks.push(
                                        event.data
                                    );
                                }
                            };

                        /*
                        |--------------------------------------------------------------------------
                        | DOWNLOAD RECORDING
                        |--------------------------------------------------------------------------
                        */

                        this.mediaRecorder.onstop = () => {

                            const blob = new Blob(
                                this.recordedChunks, {
                                    type: 'video/webm'
                                }
                            );

                            const url =
                                URL.createObjectURL(blob);

                            const a =
                                document.createElement('a');

                            a.href = url;

                            a.download =
                                `recording-${Date.now()}.webm`;

                            document.body.appendChild(a);

                            a.click();

                            a.remove();

                            URL.revokeObjectURL(url);
                        };

                        /*
                        |--------------------------------------------------------------------------
                        | START
                        |--------------------------------------------------------------------------
                        */

                        this.mediaRecorder.start(1000);

                        this.isRecording = true;

                        console.log(
                            '✅ Recording started with audio'
                        );

                    } catch (error) {

                        console.error(
                            '❌ Recording failed:',
                            error
                        );
                    }

                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | STOP RECORDING
                    |--------------------------------------------------------------------------
                    */

                    if (
                        this.mediaRecorder &&
                        this.mediaRecorder.state !== 'inactive'
                    ) {

                        this.mediaRecorder.stop();

                        this.isRecording = false;

                        console.log(
                            '✅ Recording stopped'
                        );
                    }
                }
            }

        }));
    });
</script>