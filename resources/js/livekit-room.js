import { connect } from "livekit-client";

window.livekitRoom = function(config) {
    return {
        room: null,
        isHost: config.isHost,

        async init() {
            this.room = await connect(config.url, config.token);

            // 👥 PRESENCE TRACKING
            this.room.on("participantConnected", () => {
                Livewire.dispatch('viewerJoined');
            });

            this.room.on("participantDisconnected", () => {
                Livewire.dispatch('viewerLeft');
            });

            // 🎥 STREAM HANDLING
            this.room.on("trackSubscribed", (track) => {
                if (track.kind === "video") {
                    const el = track.attach();
                    document.getElementById("remoteVideos").appendChild(el);
                }
            });
        },

        async startPublishing() {
            const stream = await navigator.mediaDevices.getUserMedia({
                video: true,
                audio: true
            });

            stream.getTracks().forEach(track => {
                this.room.localParticipant.publishTrack(track);
            });

            document.getElementById("localVideo").srcObject = stream;
        }
    }
}