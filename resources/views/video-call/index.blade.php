@php
    use Illuminate\Support\Facades\Auth;
    use App\Enums\online_medicine\ObjectOnlineMedicine;
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    {{--    <meta http-equiv='X-UA-Compatible' content='IE=edge'> --}}
    <title>Agora Demo</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300&family=Permanent+Marker&display=swap"
        rel="stylesheet">

    <script>
        const token = `{{ $_COOKIE['accessToken'] ?? '' }}`;
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel='stylesheet' type='text/css' media='screen' href='{{ asset('agora-video/style.css') }}'>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <main>
        @php
            $role_name = null;
            if (Auth::check()) {
                $user = Auth::user();
                $user_id = $user->id;
                $role_user = \App\Models\RoleUser::where('user_id', $user_id)->first();
                $role = \App\Models\Role::find($role_user->role_id);
                $role_name = $role->name;
            }
        @endphp
        <!-- <div id="users-list"></div> -->
        <div id="join-wrapper">
            <input id="username" type="text" placeholder="Enter your name..." />
            <input type="hidden" id="patient" name="patient" value="{{ $patient }}">
            <button id="join-btn">Bắt đầu</button>
        </div>
        <div id="user-streams" class="mt-5"></div>


        <!-- Wrapper for join button -->
        <div id="footer" class="mb-3" style="display: flex">
            <div class="icon-wrapper">
                <img class="control-icon" id="camera-btn" src="{{ asset('img/assets-video-call/video.svg') }}" />
                <p>Cam</p>
            </div>

            <div class="icon-wrapper">
                <img class="control-icon" id="mic-btn" src="{{ asset('img/assets-video-call/microphone.svg') }}" />
                <p>Mic</p>
            </div>

            <div class="icon-wrapper">
                <img class="control-icon" id="leave-btn" src="{{ asset('img/assets-video-call/leave.svg') }}" />
                <p>Leave</p>
            </div>
            @if (!\App\Models\User::isNormal())
                <div class="icon-wrapper" data-toggle="modal" data-target="#modal-create-don-thuoc-widget-chat">
                    <img class="control-icon" id="create-prescription-btn"
                        src="{{ asset('img/assets-video-call/leave.svg') }}" />
                    <p>Tạo đơn thuốc</p>
                </div>
            @else
                <div class="icon-wrapper">
                    <img class="control-icon" id="prescription-btn"
                        src="{{ asset('img/assets-video-call/leave.svg') }}" />
                    <p>Đơn thuốc</p>
                </div>
            @endif

        </div>
        <div class="modal fade" id="modal-create-don-thuoc-widget-chat" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content overflow-scroll">
                    <div class="modal-header">
                    </div>
                    <form id="prescriptionForm" onsubmit="createPrescription_widgetChat(event)" method="post">
                        @csrf
                        <div class="modal-body">

                            <input type="hidden" name="created_by" value="{{ Auth::id() }}">
                            <div class="list-service-result mt-2 mb-3">
                                <div id="list-service-result">

                                </div>
                                <button type="button" class="btn btn-outline-primary mt-3"
                                    onclick="handleAddMedicine_widgetChat()">{{ __('home.Add') }}
                                </button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Tạo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-add-medicine-widget-chat" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header ">
                        <form class="row w-100">
                            <div class="col-sm-4">
                                <div class="form-group position-relative">
                                    <label for="inputSearchNameMedicine" class="form-control-feedback"></label>
                                    <input type="search" id="inputSearchNameMedicine" class="form-control"
                                        oninput="handleSearchMedicine()" placeholder="Tìm kiếm theo tên thuốc">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group position-relative">
                                    <label for="inputSearchDrugIngredient" class="form-control-feedback"></label>
                                    <input type="search" id="inputSearchDrugIngredient" class="form-control"
                                        oninput="handleSearchMedicine()" placeholder="Tìm kếm theo thành phần thuốc">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group position-relative">
                                    <label for="inputSearchNameMedicine" class="form-control-feedback"></label>
                                    <select class="form-select position-relative" id="object_search"
                                        onchange="handleSearchMedicine()">
                                        <option value="{{ \App\Enums\online_medicine\ObjectOnlineMedicine::KIDS }}">
                                            {{ __('home.For kids') }}</option>
                                        <option value="{{ ObjectOnlineMedicine::FOR_WOMEN }}">
                                            {{ __('home.For women') }}
                                        </option>
                                        <option value="{{ ObjectOnlineMedicine::FOR_MEN }}">{{ __('home.For men') }}
                                        </option>
                                        <option value="{{ ObjectOnlineMedicine::FOR_ADULT }}">
                                            {{ __('home.For adults') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-body find-my-medicine-2">
                        <div class="row" id="modal-list-medicine-widget-chat">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.2/dist/echo.iife.js"></script>
    <script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>

    <script>
        let username = document.getElementById('username');

        username.value = '{{ Auth::user()->name ?? 'default name' }}';

        //#1
        let client = AgoraRTC.createClient({
            mode: 'rtc',
            codec: "h264",
            role: 'host'
        })

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
        // document.getElementById('join-btn').addEventListener('click', async () => {
        //     config.uid = document.getElementById('username').value
        //     await joinStreams()
        //     document.getElementById('join-wrapper').style.display = 'none'
        //     document.getElementById('footer').style.display = 'flex'
        // })

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
            document.getElementById('join-wrapper').style.display = 'flex'
        })

        //Method will take all my info and set user stream in frame
        let joinStreams = async () => {
            //Is this place hear strategicly or can I add to end of method?
            console.log('Start join stream!')
            client.on("user-published", handleUserJoined);

            client.on("user-joined", function(event) {
                console.log("user-joined", event)
            });

            client.on("user-left", handleUserLeft);

            client
                .enableAudioVolumeIndicator(); // Triggers the "volume-indicator" callback event every two seconds.
            client.on("volume-indicator", function(evt) {
                for (let i = 0; evt.length > i; i++) {
                    let speaker = evt[i].uid
                    let volume = evt[i].level
                    if (volume > 0) {
                        document.getElementById(`volume-${speaker}`).src =
                            '{{ asset('img/assets-video-call/volume-on.svg') }}'
                    } else {
                        document.getElementById(`volume-${speaker}`).src =
                            '{{ asset('img/assets-video-call/volume-off.svg') }}'
                    }
                }
            });

            //#6 - Set and get back tracks for local user
            console.log('uid', config.uid, {{ $agora_chat->uid }});
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

    {{-- Handle prescription modal --}}
    <script>
        let chatUserId = $('#patient').val();
        let elementInputMedicine_widgetChat;
        let next_elementInputMedicine_widgetChat;
        let next_elementQuantity_widgetChat;
        let next_elementMedicineIngredients_widgetChat;

        let html_widgetChat = `<div class="service-result-item d-flex align-items-center justify-content-between border p-3">
                    <div class="row w-75">
                        <div class="form-group">
                            <label for="medicine_name" class="text-dark">Medicine Name</label>
                            <input type="text" class="form-control medicine_name" value=""
                                   name="medicine_name" onclick="handleClickInputMedicine_widgetChat(this, $(this).next('.medicine_id_hidden'))" data-toggle="modal" data-target="#modal-add-medicine-widget-chat" readonly>
                            <input type="text" hidden class="form-control medicine_id_hidden" name="medicine_id_hidden" value="">

                        </div>
                        <div class="form-group">
                            <label for="medicine_ingredients" class="text-dark">Medicine Ingredients</label>
                            <textarea class="form-control medicine_ingredients" readonly name="medicine_ingredients" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="quantity" class="text-dark">{{ __('home.Quantity') }}</label>
                            <input type="number" min="1" class="form-control quantity" name="quantity">
                        </div>
                        <div class="form-group">
                            <label for="detail_value" class="text-dark">Note</label>
                            <input type="text" class="form-control detail_value" name="detail_value">
                        </div>
                    </div>
                    <div class="action mt-3">
                        <i class="fa-regular fa-trash-can" onclick="loadTrash_widgetChat(this)" style="cursor: pointer; font-size: 24px"></i>
                    </div>
                </div>`;

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: 'e700f994f98dbb41ea9f',
            cluster: 'eu',
            encrypted: true,
        });

        function handleAddMedicine_widgetChat() {
            $('#list-service-result').append(html_widgetChat);
            loadData_widgetChat();
        }

        function loadData_widgetChat() {
            $('.service_name_item').on('click', function() {
                let my_array = null;
                let my_name = null;
                $(this).parent().parent().find(':checkbox:checked').each(function(i) {
                    let value = $(this).val();
                    if (my_array) {
                        my_array = my_array + ',' + value;
                    } else {
                        my_array = value;
                    }

                    let name = $(this).data('name');
                    if (my_name) {
                        my_name = my_name + ', ' + name;
                    } else {
                        my_name = name;
                    }
                });
                $(this).parent().parent().prev().val(my_name);
                $(this).parent().parent().next().find('input').val(my_array);
            })
        }

        function handleClickInputMedicine_widgetChat(element, nextElement) {
            elementInputMedicine_widgetChat = element;
            next_elementInputMedicine_widgetChat = nextElement;
            next_elementQuantity_widgetChat = $(element).parents().parents().find('input.quantity');
            next_elementMedicineIngredients_widgetChat = $(element).parents().parents().find(
                'textarea.medicine_ingredients');
        }

        async function handleSelectInputMedicine_widgetChat(id, name, quantity) {
            elementInputMedicine_widgetChat.value = name;
            next_elementInputMedicine_widgetChat.val(id);
            next_elementQuantity_widgetChat.off('change');

            next_elementQuantity_widgetChat.attr('max', quantity);

            // Thêm sự kiện onchange
            next_elementQuantity_widgetChat.on('change', function() {
                // Lấy giá trị hiện tại của next_elementQuantity_widgetChat
                var currentValue = next_elementQuantity_widgetChat.val();

                // Chuyển đổi giá trị thành số để so sánh
                currentValue = parseInt(currentValue);

                // Kiểm tra nếu giá trị lớn hơn quantity
                if (currentValue > quantity) {
                    // Hiển thị cảnh báo
                    alert('Giá trị không thể lớn hơn ' + quantity);
                    // Cài đặt lại giá trị về quantity
                    next_elementQuantity_widgetChat.val(quantity);
                }
            });

            let resultComponent_name = await getIngredientsByMedicineId(id)
            next_elementMedicineIngredients_widgetChat.val(resultComponent_name.component_name);
        }
        loadListMedicine();

        function loadListMedicine() {
            let inputNameMedicine_Search = $('#inputSearchNameMedicine').val().toLowerCase();
            let inputDrugIngredient_Search = $('#inputSearchDrugIngredient').val().toLowerCase();
            let object_search = $('#object_search').val().toLowerCase();

            let url = '{{ route('view.prescription.result.get-medicine') }}'
            url = url +
                `?name_search=${inputNameMedicine_Search}&drug_ingredient_search=${inputDrugIngredient_Search}&object_search=${object_search}`;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    renderMedicine(response);
                },
                error: function(error) {
                    console.log(error)
                }
            });
        }

        function renderMedicine(data) {
            let html = '';
            data.forEach((medicine) => {
                let url = '{{ route('medicine.detail', ':id') }}';
                url = url.replace(':id', medicine.id);

                html += `<div class="col-sm-6 col-xl-4 mb-3 col-12 find-my-medicine-2">
                                <div class="m-md-2 ">
                                    <div class="frame component-medicine w-100">
                                        <div class="img-pro justify-content-center d-flex img_product--homeNew w-100">
                                            <img loading="lazy" class="rectangle border-img w-100"
                                                 src="${medicine.thumbnail}"/>
                                        </div>
                                        <div class="div">
                                            <div class="div-2">
                                                <a target="_blank" class="w-100"
                                                   href="${url}">
                                                    <div
                                                        class="text-wrapper text-nowrap overflow-hidden text-ellipsis w-100">${medicine.name}</div>
                                                </a>
                                                <div
                                                    class="text-wrapper-3">${medicine.price} ${medicine.unit_price ?? 'VND'}</div>
                                                <div
                                                    class="text-wrapper-3">Còn lại: ${medicine.quantity}</div>
                                            </div>
                                            <div class="div-wrapper">
                                                <a style="cursor: pointer" onclick="handleSelectInputMedicine_widgetChat('${medicine.id}', '${medicine.name}', '${medicine.quantity}')"
                                                   data-dismiss="modal">
                                                    <div class="text-wrapper-4">{{ __('home.Choose...') }}</div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`
            });

            $('#modal-list-medicine-widget-chat').html(html);
        }

        function handleSearchMedicine() {
            loadListMedicine();
        }

        async function createPrescription_widgetChat(event) {
            event.preventDefault();

            let form = document.getElementById('prescriptionForm');
            let formData = new FormData(form);

            let my_array = [];

            // Lấy phần tử cha (div#prescriptionForm)
            var prescriptionForm = document.getElementById('prescriptionForm');

            // Lấy các phần tử con có class 'medicine_name'
            var medicine_name = prescriptionForm.getElementsByClassName('medicine_name');

            // Lấy các phần tử con có class 'medicine_ingredients'
            var medicine_ingredients = prescriptionForm.getElementsByClassName('medicine_ingredients');

            // Lấy các phần tử con có class 'quantity'
            var quantity = prescriptionForm.getElementsByClassName('quantity');

            // Lấy các phần tử con có class 'detail_value'
            var detail = prescriptionForm.getElementsByClassName('detail_value');

            // Lấy các phần tử con có class 'medicine_id_hidden'
            var medicine_id_hidden = prescriptionForm.getElementsByClassName('medicine_id_hidden');

            for (let j = 0; j < medicine_name.length; j++) {
                let name = medicine_name[j].value;
                let ingredients = medicine_ingredients[j].value;
                let quantity_value = quantity[j].value;
                let detail_value = detail[j].value;

                let medicine_id_hidden_value = '';
                if (medicine_id_hidden[j]) {
                    medicine_id_hidden_value = medicine_id_hidden[j].value;
                }

                if (!name && !ingredients && !quantity_value) {
                    alert('Please enter medicine name or medicine ingredients or quantity!')
                    return;
                }

                let item = {
                    medicine_name: name,
                    medicine_ingredients: ingredients,
                    quantity: quantity_value,
                    note: detail_value ?? '',
                    medicine_id: medicine_id_hidden_value ?? '',
                }
                item = JSON.stringify(item);
                my_array.push(item);
            }

            const itemList = [
                'prescriptions',
            ];

            itemList.forEach(item => {
                formData.append(item, my_array.toString());
            });

            formData.append('chatUserId', chatUserId);

            let accessToken = `Bearer ` + token;
            let headers = {
                'Authorization': accessToken,
            };

            try {
                await $.ajax({
                    url: `{{ route('api.backend.prescription.result.create') }}`,
                    method: 'POST',
                    headers: headers,
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        alert('Create success!')
                        // window.location.href = `{{ route('view.prescription.result.doctor') }}`;
                    },
                    error: function(error) {
                        alert(error.responseJSON.message);
                    }
                });
            } catch (e) {
                console.log(e)
                alert('Error, Please try again!');
            }
        }

        async function getIngredientsByMedicineId(id) {
            let url = `{{ route('medicine.get-ingredients-by-medicine-id', ['id' => ':id']) }}`;
            url = url.replace(':id', id);

            let result = await fetch(url, {
                method: 'GET',
            });

            if (result.ok) {
                let data = await result.json();
                return data;
            }

            return {
                'compoent_name': ''
            };
        }
    </script>
</body>

</html>
