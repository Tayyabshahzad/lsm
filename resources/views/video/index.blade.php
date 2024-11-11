<div>
    <h2>Video Call</h2>
    <video id="localVideo" autoplay playsinline></video>
    <video id="remoteVideo" autoplay playsinline></video>
    <button onclick="startCall()">Start Call</button>
</div>
<script>
    let localStream;
    let remoteStream;
    let peerConnection;

    document.addEventListener('livewire:load', () => {
        Livewire.on('initiateCall', startVideoCall);

        Echo.channel('video-call')
            .listen('SignalEvent', (e) => {
                if (e.data.sdp) {
                    peerConnection.setRemoteDescription(new RTCSessionDescription(e.data.sdp))
                        .catch(error => console.error('Error setting remote description:', error));
                    
                    if (e.data.sdp.type === 'offer') {
                        peerConnection.createAnswer()
                            .then(answer => peerConnection.setLocalDescription(answer))
                            .then(() => {
                                Livewire.emit('sendSignal', { sdp: peerConnection.localDescription });
                            })
                            .catch(error => console.error('Error creating answer:', error));
                    }
                } else if (e.data.candidate) {
                    peerConnection.addIceCandidate(new RTCIceCandidate(e.data.candidate))
                        .catch(error => console.error('Error adding ice candidate:', error));
                }
            });
    });

    function startVideoCall() {
        navigator.mediaDevices.getUserMedia({ video: true, audio: true })
            .then(stream => {
                localStream = stream;
                document.getElementById('localVideo').srcObject = stream;

                const configuration = { iceServers: [{ urls: 'stun:stun.l.google.com:19302' }] };
                peerConnection = new RTCPeerConnection(configuration);

                peerConnection.onicecandidate = ({ candidate }) => {
                    if (candidate) {
                        Livewire.emit('sendSignal', { candidate: candidate.toJSON() });
                    }
                };

                peerConnection.ontrack = (event) => {
                    document.getElementById('remoteVideo').srcObject = event.streams[0];
                };

                localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));

                peerConnection.createOffer()
                    .then(offer => peerConnection.setLocalDescription(offer))
                    .then(() => {
                        Livewire.emit('sendSignal', { sdp: peerConnection.localDescription });
                    })
                    .catch(error => console.error('Error creating offer:', error));
            })
            .catch(error => console.error('Error accessing media devices.', error));
    }
</script>
