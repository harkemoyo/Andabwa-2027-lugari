// // livekit-room.js
// // import { connect } from "livekit-client";

// // window.livekitRoom = function(config) {
// //     return {
// //         room: null,
// //         isHost: config.isHost,

// //         async init() {
// //             this.room = await connect(config.url, config.token);

// //             // 👥 PRESENCE TRACKING
// //             this.room.on("participantConnected", () => {
// //                 Livewire.dispatch('viewerJoined');
// //             });

// //             this.room.on("participantDisconnected", () => {
// //                 Livewire.dispatch('viewerLeft');
// //             });

// //             // 🎥 STREAM HANDLING
// //             this.room.on("trackSubscribed", (track) => {
// //                 if (track.kind === "video") {
// //                     const el = track.attach();
// //                     document.getElementById("remoteVideos").appendChild(el);
// //                 }
// //             });
// //         },

// //         async startPublishing() {
// //             const stream = await navigator.mediaDevices.getUserMedia({
// //                 video: true,
// //                 audio: true
// //             });

// //             stream.getTracks().forEach(track => {
// //                 this.room.localParticipant.publishTrack(track);
// //             });

// //             document.getElementById("localVideo").srcObject = stream;
// //         }
// //     }
// // }





// // livekit-room.js


// import {
//     connect
// } from "livekit-client";

// window.livekitRoom = function(config) {
//     return {
//         room: null,
//         isHost: config.isHost,

//         async init() {
//             this.room = await connect(config.url, config.token);

//             // 👥 PRESENCE TRACKING
//             this.room.on("participantConnected", () => {
//                 Livewire.dispatch('viewerJoined');
//             });

//             this.room.on("participantDisconnected", () => {
//                 Livewire.dispatch('viewerLeft');
//             });

//             // 🎥 STREAM HANDLING
//             this.room.on("trackSubscribed", (track) => {
//                 if (track.kind === "video") {
//                     const el = track.attach();
//                     document.getElementById("remoteVideos").appendChild(el);
//                 }
//             });
//         },

//         async startPublishing() {
//             const stream = await navigator.mediaDevices.getUserMedia({
//                 video: true,
//                 audio: true
//             });

//             stream.getTracks().forEach(track => {
//                 this.room.localParticipant.publishTrack(track);
//             });

//             document.getElementById("localVideo").srcObject = stream;
//         }
//     }
// }


// // import { connect } from "livekit-client";

// document.addEventListener('alpine:init', () => {
//     Alpine.data('livekitRoom', (config) => ({
//         room: null,

//         isHost: false,
//         isSpeaker: false,
//         isLive: false,

//         reconnecting: false,

//         async init() {
//             this.room = await connect(config.url, config.token);

//             this.setRole();

//             this.handleEvents();
//         },

//         setRole() {
//             const meta = JSON.parse(this.room.localParticipant.metadata || '{}');

//             this.isHost = meta.role === 'host';
//             this.isSpeaker = meta.role === 'speaker';
//         },

//         handleEvents() {
//             this.room.on("participantConnected", () => {
//                 Livewire.dispatch('viewerJoined');
//             });

//             this.room.on("participantDisconnected", () => {
//                 Livewire.dispatch('viewerLeft');
//             });

//             this.room.on("trackSubscribed", (track) => {
//                 const el = track.attach();
//                 this.$refs.remoteVideos.appendChild(el);
//             });

//             // 🔁 reconnect logic
//             this.room.on("reconnecting", () => {
//                 this.reconnecting = true;
//             });

//             this.room.on("reconnected", async() => {
//                 this.reconnecting = false;

//                 if (this.isHost || this.isSpeaker) {
//                     await this.restorePublishing();
//                 }
//             });

//             // 🔄 speaker upgrade
//             window.addEventListener('speakerTokenGenerated', async(e) => {
//                 await this.room.disconnect();

//                 this.room = await connect(config.url, e.detail.token);

//                 this.setRole();
//             });
//         },

//         async startPublishing() {
//             if (this.isLive) return;

//             if (this.room.localParticipant.videoTracks.size > 0) {
//                 this.isLive = true;
//                 return;
//             }

//             const stream = await navigator.mediaDevices.getUserMedia({
//                 video: true,
//                 audio: true
//             });

//             stream.getTracks().forEach(track => {
//                 this.room.localParticipant.publishTrack(track);
//             });

//             this.$refs.localVideo.srcObject = stream;

//             this.isLive = true;
//         },

//         async restorePublishing() {
//             if (this.room.localParticipant.videoTracks.size > 0) return;

//             const stream = await navigator.mediaDevices.getUserMedia({
//                 video: true,
//                 audio: true
//             });

//             stream.getTracks().forEach(track => {
//                 this.room.localParticipant.publishTrack(track);
//             });

//             this.$refs.localVideo.srcObject = stream;

//             this.isLive = true;
//         }
//     }));
// });