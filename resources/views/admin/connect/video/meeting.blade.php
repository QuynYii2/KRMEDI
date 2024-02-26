@php use Illuminate\Support\Facades\Auth; @endphp
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">


    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>

    <script src="https://cdn.metered.ca/sdk/video/1.4.5/sdk.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        window.METERED_DOMAIN = "{{ $METERED_DOMAIN ?? 'krmedic.metered.live' }}";
        window.MEETING_ID = "{{ $MEETING_ID }}";

    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    <div id="waitingArea" class="max-h-screen">
        <div class="py-4">
            <h1 class="text-2xl">{{ __('home.Meeting Lobby') }}</h1>
        </div>


        <div class="max-w-2xl  flex flex-col space-y-4 ">

            <div class="flex items-center justify-center w-full rounded-3xl bg-gray-900">
                <video id='waitingAreaLocalVideo' class="h-96" autoplay muted></video>
            </div>

            <div class="flex space-x-4 mb-4 justify-center">

                <button id='waitingAreaToggleMicrophone' class="bg-gray-400 w-10 h-10 rounded-md p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                              d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                    </svg>
                </button>

                <button id='waitingAreaToggleCamera' class="bg-gray-400 w-10 h-10 rounded-md p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                              d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </button>

            </div>
            <div class="flex flex-col space-y-4 space-x-2 text-sm">
                <div class="flex space-x-2 items-center">
                    <label>
                        {{ __('home.Name') }}:
                        <input class="text-xs" id="username" type="text"
                               value="{{ Auth::user()->name ?? 'default name' }}"
                               placeholder="Name"/>
                    </label>

                    <label>
                        {{ __('home.Camera') }}:
                        <select class="text-xs" id='cameraSelectBox'>
                        </select>
                    </label>

                    <label>
                        {{ __('home.Microphone') }}:
                        <select class="text-xs" id='microphoneSelectBox'>
                        </select>
                    </label>
                </div>

                <div>
                    <button id='joinMeetingBtn'
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('home.Join Meeting') }}
                    </button>
                </div>
            </div>

        </div>

    </div>
</div>

<div id='meetingView' class="hidden flex w-screen h-screen space-x-4 p-10">

    <div id="activeSpeakerContainer" class=" bg-gray-900 rounded-3xl flex-1 flex relative">
        <video id="activeSpeakerVideo" src="" autoplay class=" object-contain w-full rounded-t-3xl"></video>
        <div id="activeSpeakerUsername"
             class="hidden absolute h-8 w-full bg-gray-700 rounded-b-3xl bottom-0 text-white text-center font-bold pt-1">

        </div>
    </div>

    <div id="remoteParticipantContainer" class="flex flex-col space-y-4">
        <div id="localParticiapntContainer" class="w-48 h-48 rounded-3xl bg-gray-900 relative">
            <video id="localVideoTag" src="" autoplay class="object-contain w-full rounded-t-3xl"></video>
            <div id="localUsername"
                 class="absolute h-8 w-full bg-gray-700 rounded-b-3xl bottom-0 text-white text-center font-bold pt-1">
                {{ __('home.Me') }}
            </div>
        </div>
    </div>

    <div class="flex flex-col space-y-2">
        <button id='toggleMicrophone' class="bg-gray-400 w-10 h-10 rounded-md p-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
            </svg>
        </button>

        <button id='toggleCamera' class="bg-gray-400 w-10 h-10 rounded-md p-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
        </button>

        <button id='toggleScreen' class="bg-gray-400 w-10 h-10 rounded-md p-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
        </button>

        <button id='leaveMeeting' class="bg-red-400 text-white w-10 h-10 rounded-md p-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
        </button>

    </div>
</div>

<div id="leaveMeetingView" class="hidden">
    <h1 class="text-center text-3xl mt-10 font-bold">
        {{ __('home.You have left the meeting') }}
    </h1>
</div>
</body>

<script>

    let meetingJoined = false;
    const meeting = new Metered.Meeting();
    let cameraOn = false;
    let micOn = false;
    let screenSharingOn = false;
    let localVideoStream = null;
    let activeSpeakerId = null;
    let meetingInfo = {};

    async function initializeView() {
        /**
         * Populating the cameras
         */
        const videoInputDevices = await meeting.listVideoInputDevices();
        const videoOptions = [];
        for (let item of videoInputDevices) {
            videoOptions.push(
                `<option value="${item.deviceId}">${item.label}</option>`
            )
        }
        $("#cameraSelectBox").html(videoOptions.join(""));

        /**
         * Populating Microphones
         */
        const audioInputDevices = await meeting.listAudioInputDevices();
        const audioOptions = [];
        for (let item of audioInputDevices) {
            audioOptions.push(
                `<option value="${item.deviceId}">${item.label}</option>`
            )
        }
        $("#microphoneSelectBox").html(audioOptions.join(""));


        /**
         * Mute/Unmute Camera and Microphone
         */
        $("#waitingAreaToggleMicrophone").on("click", function () {
            if (micOn) {
                micOn = false;
                $("#waitingAreaToggleMicrophone").removeClass("bg-gray-500");
                $("#waitingAreaToggleMicrophone").addClass("bg-gray-400");
            } else {
                micOn = true;
                $("#waitingAreaToggleMicrophone").removeClass("bg-gray-400");
                $("#waitingAreaToggleMicrophone").addClass("bg-gray-500");
            }
        });

        $("#waitingAreaToggleCamera").on("click", async function () {
            if (cameraOn) {
                cameraOn = false;
                $("#waitingAreaToggleCamera").removeClass("bg-gray-500");
                $("#waitingAreaToggleCamera").addClass("bg-gray-400");
                const tracks = localVideoStream.getTracks();
                tracks.forEach(function (track) {
                    track.stop();
                });
                localVideoStream = null;
                $("#waitingAreaLocalVideo")[0].srcObject = null;
            } else {
                cameraOn = true;
                $("#waitingAreaToggleCamera").removeClass("bg-gray-400");
                $("#waitingAreaToggleCamera").addClass("bg-gray-500");
                localVideoStream = await meeting.getLocalVideoStream();
                $("#waitingAreaLocalVideo")[0].srcObject = localVideoStream;
                cameraOn = true;
            }
        });

        /**
         * Adding Event Handlers
         */
        $("#cameraSelectBox").on("change", async function () {
            const deviceId = $("#cameraSelectBox").val();
            await meeting.chooseVideoInputDevice(deviceId);
            if (cameraOn) {
                localVideoStream = await meeting.getLocalVideoStream();
                $("#waitingAreaLocalVideo")[0].srcObject = localVideoStream;
            }
        });

        $("#microphoneSelectBox").on("change", async function () {
            const deviceId = $("#microphoneSelectBox").val();
            await meeting.chooseAudioInputDevice(deviceId);
        });

    }

    initializeView();

    $("#joinMeetingBtn").on("click", async function () {
        var username = $("#username").val();
        if (!username) {
            return alert("Please enter a username");
        }

        try {
            meetingInfo = await meeting.join({
                roomURL: `${window.METERED_DOMAIN}/${window.MEETING_ID}`,
                name: username,
            });

            $("#waitingArea").addClass("hidden");
            $("#meetingView").removeClass("hidden");
            $("#meetingAreaUsername").text(username);

            /**
             * If camera button is clicked on the meeting view
             * then sharing the camera after joining the meeting.
             */
            if (cameraOn) {
                await meeting.startVideo();
                $("#localVideoTag")[0].srcObject = localVideoStream;
                $("#localVideoTag")[0].play();
                $("#toggleCamera").removeClass("bg-gray-400");
                $("#toggleCamera").addClass("bg-gray-500");
            }

            /**
             * Microphone button is clicked on the meeting view then
             * sharing the microphone after joining the meeting
             */
            if (micOn) {
                $("#toggleMicrophone").removeClass("bg-gray-400");
                $("#toggleMicrophone").addClass("bg-gray-500");
                await meeting.startAudio();
            }

        } catch (ex) {
            console.log("Error occurred when joining the meeting", ex);
        }
    });

    /**
     * Handling Events
     */
    meeting.on("onlineParticipants", function (participants) {

        for (let participantInfo of participants) {
            if (!$(`#participant-${participantInfo._id}`)[0] && participantInfo._id !== meeting.participantInfo._id) {
                $("#remoteParticipantContainer").append(
                    `
          <div id="participant-${participantInfo._id}" class="w-48 h-48 rounded-3xl bg-gray-900 relative">
            <video id="video-${participantInfo._id}" src="" autoplay class="object-contain w-full rounded-t-3xl"></video>
            <video id="audio-${participantInfo._id}" src="" autoplay class="hidden"></video>
            <div class="absolute h-8 w-full bg-gray-700 rounded-b-3xl bottom-0 text-white text-center font-bold pt-1">
                ${participantInfo.name}
            </div>
          </div>
          `
                );
            }
        }
    });

    meeting.on("participantLeft", function (participantInfo) {
        $("#participant-" + participantInfo._id).remove();
        if (participantInfo._id === activeSpeakerId) {
            $("#activeSpeakerUsername").text("");
            $("#activeSpeakerUsername").addClass("hidden");
        }
    });

    meeting.on("remoteTrackStarted", function (remoteTrackItem) {
        $("#activeSpeakerUsername").removeClass("hidden");

        if (remoteTrackItem.type === "video") {
            let mediaStream = new MediaStream();
            mediaStream.addTrack(remoteTrackItem.track);
            if ($("#video-" + remoteTrackItem.participantSessionId)[0]) {
                $("#video-" + remoteTrackItem.participantSessionId)[0].srcObject = mediaStream;
                $("#video-" + remoteTrackItem.participantSessionId)[0].play();
            }
        }

        if (remoteTrackItem.type === "audio") {
            let mediaStream = new MediaStream();
            mediaStream.addTrack(remoteTrackItem.track);
            if ($("#video-" + remoteTrackItem.participantSessionId)[0]) {
                $("#audio-" + remoteTrackItem.participantSessionId)[0].srcObject = mediaStream;
                $("#audio-" + remoteTrackItem.participantSessionId)[0].play();
            }
        }
        setActiveSpeaker(remoteTrackItem);
    });

    meeting.on("remoteTrackStopped", function (remoteTrackItem) {
        if (remoteTrackItem.type === "video") {
            if ($("#video-" + remoteTrackItem.participantSessionId)[0]) {
                $("#video-" + remoteTrackItem.participantSessionId)[0].srcObject = null;
                $("#video-" + remoteTrackItem.participantSessionId)[0].pause();
            }

            if (remoteTrackItem.participantSessionId === activeSpeakerId) {
                $("#activeSpeakerVideo")[0].srcObject = null;
                $("#activeSpeakerVideo")[0].pause();
            }
        }

        if (remoteTrackItem.type === "audio") {
            if ($("#audio-" + remoteTrackItem.participantSessionId)[0]) {
                $("#audio-" + remoteTrackItem.participantSessionId)[0].srcObject = null;
                $("#audio-" + remoteTrackItem.participantSessionId)[0].pause();
            }
        }
    });


    meeting.on("activeSpeaker", function (activeSpeaker) {
        setActiveSpeaker(activeSpeaker);
    });

    function setActiveSpeaker(activeSpeaker) {

        if (activeSpeakerId != activeSpeaker.participantSessionId) {
            $(`#participant-${activeSpeakerId}`).show();
        }

        activeSpeakerId = activeSpeaker.participantSessionId;
        $(`#participant-${activeSpeakerId}`).hide();

        $("#activeSpeakerUsername").text(activeSpeaker.name || activeSpeaker.participant.name);

        if ($(`#video-${activeSpeaker.participantSessionId}`)[0]) {
            let stream = $(
                `#video-${activeSpeaker.participantSessionId}`
            )[0].srcObject;
            $("#activeSpeakerVideo")[0].srcObject = stream.clone();
        }

        if (activeSpeaker.participantSessionId === meeting.participantSessionId) {
            let stream = $(`#localVideoTag`)[0].srcObject;
            if (stream) {
                $("#localVideoTag")[0].srcObject = stream.clone();
            }
        }
    }

    $("#toggleMicrophone").on("click", async function () {
        if (micOn) {
            $("#toggleMicrophone").removeClass("bg-gray-500");
            $("#toggleMicrophone").addClass("bg-gray-400");
            micOn = false;
            await meeting.stopAudio();
        } else {
            $("#toggleMicrophone").removeClass("bg-gray-400");
            $("#toggleMicrophone").addClass("bg-gray-500");
            micOn = true;
            await meeting.startAudio();
        }
    });


    $("#toggleCamera").on("click", async function () {
        if (cameraOn) {
            $("#toggleCamera").removeClass("bg-gray-500");
            $("#toggleCamera").addClass("bg-gray-400");
            $("#toggleScreen").removeClass("bg-gray-500");
            $("#toggleScreen").addClass("bg-gray-400");
            cameraOn = false;
            await meeting.stopVideo();
            const tracks = localVideoStream.getTracks();
            tracks.forEach(function (track) {
                track.stop();
            });
            localVideoStream = null;
            $("#localVideoTag")[0].srcObject = null;
        } else {
            $("#toggleCamera").removeClass("bg-gray-400");
            $("#toggleCamera").addClass("bg-gray-500");
            cameraOn = true;
            await meeting.startVideo();
            localVideoStream = await meeting.getLocalVideoStream();
            $("#localVideoTag")[0].srcObject = localVideoStream;
        }
    });


    $("#toggleScreen").on("click", async function () {
        if (screenSharingOn) {
            $("#toggleScreen").removeClass("bg-gray-500");
            $("#toggleScreen").addClass("bg-gray-400");
            screenSharingOn = false;
            await meeting.stopVideo();
            const tracks = localVideoStream.getTracks();
            tracks.forEach(function (track) {
                track.stop();
            });
            localVideoStream = null;
            $("#localVideoTag")[0].srcObject = null;

        } else {
            $("#toggleScreen").removeClass("bg-gray-400");
            $("#toggleScreen").addClass("bg-gray-500");
            $("#toggleCamera").removeClass("bg-gray-500");
            $("#toggleCamera").addClass("bg-gray-400");
            screenSharingOn = true;
            localVideoStream = await meeting.startScreenShare();
            $("#localVideoTag")[0].srcObject = localVideoStream;
        }
    });


    $("#leaveMeeting").on("click", async function () {
        await meeting.leaveMeeting();
        handleChangeStatusDownloadRecord();
        $("#meetingView").addClass("hidden");
        $("#leaveMeetingView").removeClass("hidden");
    });

    function handleChangeStatusDownloadRecord() {
        let thisUrl = window.location.href;
        thisUrl = thisUrl.split('/');
        let roomName = thisUrl[thisUrl.length - 1];
        let url = "{{ route('download.change.status', ['roomName' => ':roomName']) }}";
        url = url.replace(':roomName', roomName);

        axios.get(url,
            {
                Accept: 'application/json',
            }).then((response) => {
        });
    }

</script>
</html>
