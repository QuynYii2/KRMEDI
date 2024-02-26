<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    {{--    <meta http-equiv='X-UA-Compatible' content='IE=edge'>--}}
    <title>Agora Demo</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='{{ asset('agora-video/style.css') }}'>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300&family=Permanent+Marker&display=swap"
          rel="stylesheet">
</head>
<body>

<main>
    @php
        $role_name = null;
        if (Auth::check()){
            $user = Auth::user();
            $user_id = $user->id;
            $role_user = \App\Models\RoleUser::where('user_id', $user_id)->first();
            $role = \App\Models\Role::find($role_user->role_id);
            $role_name = $role->name;
        }
    @endphp
        <!-- <div id="users-list"></div> -->
    <div id="join-wrapper">
        <input id="username" type="text" placeholder="Enter your name..."/>
        <button id="join-btn">Bắt đầu</button>
    </div>
    <div id="user-streams"></div>


    <!-- Wrapper for join button -->
    <div id="footer">
        <div class="icon-wrapper">
            <img class="control-icon" id="camera-btn" src="{{ asset('img/assets-video-call/video.svg') }}"/>
            <p>Cam</p>
        </div>

        <div class="icon-wrapper">
            <img class="control-icon" id="mic-btn" src="{{ asset('img/assets-video-call/microphone.svg') }}"/>
            <p>Mic</p>
        </div>

        <div class="icon-wrapper">
            <img class="control-icon" id="leave-btn" src="{{ asset('img/assets-video-call/leave.svg') }}"/>
            <p>Leave</p>
        </div>

    </div>

</main>

<script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>

<script>
    let username = document.getElementById('username');

    username.value = '{{ Auth::user()->name ?? 'default name' }}';

    //#1
    let client = AgoraRTC.createClient({mode: 'live', codec: "h264", role: 'host'})

    //#2
    let config = {
        appid: '{{ $agora_chat->appid }}',
        token: '{{ $agora_chat->token }}',
        uid: '{{ $agora_chat->uid }}',
        channel: '{{ $agora_chat->channel }}',
    }

    //#3 - Setting tracks for when user joins
    let localTracks = {
        audioTrack: null,
        videoTrack: null
    }

    //#4 - Want to hold state for users audio and video so user can mute and hide
    let localTrackState = {
        audioTrackMuted: false,
        videoTrackMuted: false
    }

    //#5 - Set remote tracks to store other users
    let remoteTracks = {}

    document.getElementById('mic-btn').addEventListener('click', async () => {
        //Check if what the state of muted currently is
        //Disable button
        if (!localTrackState.audioTrackMuted) {
            //Mute your audio
            await localTracks.audioTrack.setMuted(true);
            localTrackState.audioTrackMuted = true
            document.getElementById('mic-btn').style.backgroundColor = 'rgb(255, 80, 80, 0.7)'
        } else {
            await localTracks.audioTrack.setMuted(false)
            localTrackState.audioTrackMuted = false
            document.getElementById('mic-btn').style.backgroundColor = '#1f1f1f8e'
        }
    })


    document.getElementById('camera-btn').addEventListener('click', async () => {
        //Check if what the state of muted currently is
        //Disable button
        if (!localTrackState.videoTrackMuted) {
            //Mute your audio
            await localTracks.videoTrack.setMuted(true);
            localTrackState.videoTrackMuted = true
            document.getElementById('camera-btn').style.backgroundColor = 'rgb(255, 80, 80, 0.7)'
        } else {
            await localTracks.videoTrack.setMuted(false)
            localTrackState.videoTrackMuted = false
            document.getElementById('camera-btn').style.backgroundColor = '#1f1f1f8e'
        }
    })


    document.getElementById('leave-btn').addEventListener('click', async () => {
        //Loop threw local tracks and stop them so unpublish event gets triggered, then set to undefined
        //Hide footer
        for (trackName in localTracks) {
            let track = localTracks[trackName]
            if (track) {
                track.stop()
                track.close()
                localTracks[trackName] = null
            }
        }

        //Leave the channel
        await client.leave()
        document.getElementById('footer').style.display = 'none'
        document.getElementById('user-streams').innerHTML = ''
        document.getElementById('join-wrapper').style.display = 'block'
    })


    //Method will take all my info and set user stream in frame
    let joinStreams = async () => {
        //Is this place hear strategicly or can I add to end of method?

        client.on("user-published", handleUserJoined);
        client.on("user-left", handleUserLeft);

        client.enableAudioVolumeIndicator(); // Triggers the "volume-indicator" callback event every two seconds.
        client.on("volume-indicator", function (evt) {
            for (let i = 0; evt.length > i; i++) {
                let speaker = evt[i].uid
                let volume = evt[i].level
                if (volume > 0) {
                    document.getElementById(`volume-${speaker}`).src = '{{ asset('img/assets-video-call/volume-on.svg') }}'
                } else {
                    document.getElementById(`volume-${speaker}`).src = '{{ asset('img/assets-video-call/volume-off.svg') }}'
                }
            }
        });

        //#6 - Set and get back tracks for local user
        console.log('uid')
        console.log(config.uid, {{ $agora_chat->uid }});
        [config.uid, localTracks.audioTrack, localTracks.videoTrack] = await Promise.all([
            client.join(config.appid, config.channel, config.token || null, config.uid || null),
            AgoraRTC.createMicrophoneAudioTrack(),
            AgoraRTC.createCameraVideoTrack()

        ])

        client.enableDualStream().then(() => {
            console.log("Enable Dual stream success!");
        }).catch(err => {
            console.log(err);
        })

        //#7 - Create player and add it to player list
        let player = `<div class="video-containers" id="video-wrapper-${config.uid}">
                        <p class="user-uid"><img class="volume-icon" id="volume-${config.uid}" src="{{ asset('img/assets-video-call/volume-on.svg') }}" /> ${config.uid}</p>
                        <div class="video-player player" id="stream-${config.uid}"></div>
                  </div>`

        document.getElementById('user-streams').insertAdjacentHTML('beforeend', player);
        //#8 - Player user stream in div
        localTracks.videoTrack.play(`stream-${config.uid}`)

        //#9 Add user to user list of names/ids

        //#10 - Publish my local video tracks to entire channel so everyone can see it
        await client.publish([localTracks.audioTrack, localTracks.videoTrack])
    }

    let handleUserJoined = async (user, mediaType) => {
        console.log('Handle user joined')
        console.log(user);
        //#11 - Add user to list of remote users
        remoteTracks[user.uid] = user

        //#12 Subscribe ro remote users
        await client.subscribe(user, mediaType)

        if (mediaType === 'video') {
            let player = document.getElementById(`video-wrapper-${user.uid}`)
            console.log('player:', player)
            if (player != null) {
                player.remove()
            }

            player = `<div class="video-containers" id="video-wrapper-${user.uid}">
                        <p class="user-uid"><img class="volume-icon" id="volume-${user.uid}" src="{{ asset('img/assets-video-call/volume-on.svg') }}" /> ${user.uid}</p>
                        <div  class="video-player player" id="stream-${user.uid}"></div>
                      </div>`
            document.getElementById('user-streams').insertAdjacentHTML('beforeend', player);
            user.videoTrack.play(`stream-${user.uid}`)
        }

        if (mediaType === 'audio') {
            user.audioTrack.play();
        }
    }

    let handleUserLeft = (user) => {
        console.log('Handle user left!')
        //Remove from remote users and remove users video wrapper
        delete remoteTracks[user.uid]
        document.getElementById(`video-wrapper-${user.uid}`).remove()
    }

    window.addEventListener('load', async () => {
        await joinStreams();
        const joinWrapper = document.querySelector('#join-wrapper');
        const footer = document.querySelector('#footer');
        joinWrapper.style.display = 'none';
        footer.style.display = 'flex';
    });
</script>
</body>
</html>
