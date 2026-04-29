export default class WebRTCStream {
    constructor({ isHost, streamId, userId, videoElement }) {
        this.isHost = isHost;
        this.streamId = streamId;
        this.userId = userId;
        this.video = videoElement;

        this.localStream = null;
        this.peerConnections = {};
        this.channel = null;

        this.rtcConfig = {
            iceServers: [{ urls: 'stun:stun.l.google.com:19302' }]
        };
    }

    init(Echo) {
        this.channel = Echo.join(`stream.${this.streamId}`);

        if (this.isHost) {
            this.setupHost();
        } else {
            this.setupViewer();
        }
    }

    async startStream() {
        this.localStream = await navigator.mediaDevices.getUserMedia({
            video: true,
            audio: true
        });

        this.video.srcObject = this.localStream;

        this.channel.whisper('host-ready', {
            hostId: this.userId
        });
    }

    setupHost() {
        this.channel
            .joining(user => {
                if (this.localStream) this.initiateConnection(user.id);
            })
            .listenForWhisper('viewer-ready', data => {
                if (this.localStream) this.initiateConnection(data.viewerId);
            })
            .listenForWhisper('answer', async data => {
                if (data.targetId === this.userId) {
                    await this.peerConnections[data.senderId]
                        .setRemoteDescription(new RTCSessionDescription(data.sdp));
                }
            })
            .listenForWhisper('ice-candidate', data => {
                if (data.targetId === this.userId) {
                    this.peerConnections[data.senderId]
                        .addIceCandidate(new RTCIceCandidate(data.candidate));
                }
            });
    }

    async initiateConnection(viewerId) {
        const pc = new RTCPeerConnection(this.rtcConfig);

        this.peerConnections[viewerId] = pc;

        this.localStream.getTracks().forEach(track => {
            pc.addTrack(track, this.localStream);
        });

        pc.onicecandidate = e => {
            if (e.candidate) {
                this.channel.whisper('ice-candidate', {
                    targetId: viewerId,
                    senderId: this.userId,
                    candidate: e.candidate
                });
            }
        };

        const offer = await pc.createOffer();
        await pc.setLocalDescription(offer);

        this.channel.whisper('offer', {
            targetId: viewerId,
            senderId: this.userId,
            sdp: pc.localDescription
        });
    }

    setupViewer() {
        const pc = new RTCPeerConnection(this.rtcConfig);

        pc.ontrack = e => {
            this.video.srcObject = e.streams[0];
        };

        pc.onicecandidate = e => {
            if (e.candidate) {
                this.channel.whisper('ice-candidate', {
                    targetId: 'host',
                    senderId: this.userId,
                    candidate: e.candidate
                });
            }
        };

        this.channel
            .listenForWhisper('host-ready', () => {
                this.channel.whisper('viewer-ready', {
                    viewerId: this.userId
                });
            })
            .listenForWhisper('offer', async data => {
                if (data.targetId === this.userId) {
                    await pc.setRemoteDescription(new RTCSessionDescription(data.sdp));

                    const answer = await pc.createAnswer();
                    await pc.setLocalDescription(answer);

                    this.channel.whisper('answer', {
                        targetId: data.senderId,
                        senderId: this.userId,
                        sdp: pc.localDescription
                    });
                }
            })
            .listenForWhisper('ice-candidate', data => {
                if (data.targetId === this.userId) {
                    pc.addIceCandidate(new RTCIceCandidate(data.candidate));
                }
            });

        setTimeout(() => {
            this.channel.whisper('viewer-ready', {
                viewerId: this.userId
            });
        }, 1000);
    }
}