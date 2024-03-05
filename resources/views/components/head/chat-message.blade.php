@php use Illuminate\Support\Facades\Auth; use \App\Enums\online_medicine\ObjectOnlineMedicine @endphp

<link href="{{ asset('css/chatmessage.css') }}" rel="stylesheet">

<style>
    .frame.component-medicine.w-100 {
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
    }

    .max-1-line-title-widget-chat {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    @media (max-width: 575px) {
        .div .div-2 a .text-wrapper {
            font-size: 12px;
        }

        .text-wrapper-4 {
            font-size: 12px !important;
        }
    }


    .find-my-medicine-2 .frame {
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        position: relative;
        background-color: #088180;
        border-radius: 24px;
        border: 1px solid;
        border-color: var(--grey-medium);
    }

    .find-my-medicine-2 .frame .rectangle {
        position: relative;
        object-fit: cover;
    }

    .find-my-medicine-2 .frame .div {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 16px;
        position: relative;
        align-self: stretch;
        width: 100%;
        flex: 0 0 auto;
    }

    .find-my-medicine-2 .frame .div-2 {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
        padding: 0px 16px;
        position: relative;
        align-self: stretch;
        width: 100%;
        flex: 0 0 auto;
    }

    .find-my-medicine-2 .frame .text-wrapper {
        position: relative;
        width: fit-content;
        margin-top: -1px;
        font-weight: var(--body-1-extra-font-weight);
        color: var(--white);
        font-size: var(--body-1-extra-font-size);
        text-align: center;
        letter-spacing: var(--body-1-extra-letter-spacing);
        line-height: var(--body-1-extra-line-height);
        font-style: var(--body-1-extra-font-style);
    }

    .find-my-medicine-2 .frame .text-wrapper-3 {
        position: relative;
        width: fit-content;
        font-weight: var(--subtitle-1-extra-font-weight);
        color: var(--white);
        font-size: var(--subtitle-1-extra-font-size);
        text-align: center;
        letter-spacing: var(--subtitle-1-extra-letter-spacing);
        line-height: var(--subtitle-1-extra-line-height);
        font-style: var(--subtitle-1-extra-font-style);
    }

    .find-my-medicine-2 .frame .div-wrapper {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 16px 40px;
        position: relative;
        flex: 0 0 auto;
        margin-bottom: -1px;
        margin-right: -1px;
        background-color: var(--white);
        border-radius: 60px 0px 24px 0px;
        overflow: hidden;
    }

    .find-my-medicine-2 .frame .text-wrapper-4 {
        position: relative;
        width: fit-content;
        font-weight: var(--subtitle-1-extra-font-weight);
        color: var(--black);
        font-size: var(--subtitle-1-extra-font-size);
        letter-spacing: var(--subtitle-1-extra-letter-spacing);
        line-height: var(--subtitle-1-extra-line-height);
        font-style: var(--subtitle-1-extra-font-style);
    }

    .find-my-medicine-2 .frame .img {
        position: absolute;
        width: 24px;
        height: 24px;
        top: 20px;
        left: 225px;
    }


    .find-my-medicine-2 .text-wrapper.text-ellipsis {
        text-overflow: ellipsis;
    }


    .find-my-medicine-2 .border-img {
        border-radius: 13px 13px 100px 0px;
        object-fit: cover;
    }

    .find-my-medicine .frame:hover, .find-my-medicine-2 .frame:hover {
        border-radius: 22px;
        background: #088180;
        box-shadow: 0px 8px 10px 0px rgba(0, 0, 0, 0.25);
    }


    /* General button style */
    #widget-chat .btn {
        border: none;
        font-family: 'Lato';
        font-size: inherit;
        color: inherit;
        background: none;
        cursor: pointer;
        display: inline-block;
        letter-spacing: 1px;
        outline: none;
        position: relative;
        -webkit-transition: all 0.3s;
        -moz-transition: all 0.3s;
        transition: all 0.3s;
    }

    #widget-chat .btn:after {
        content: '';
        position: absolute;
        z-index: -1;
        -webkit-transition: all 0.3s;
        -moz-transition: all 0.3s;
        transition: all 0.3s;
    }

    /* Pseudo elements for icons */
    #widget-chat .btn:before {
        font-family: 'FontAwesome';
        speak: none;
        font-style: normal;
        font-weight: normal;
        font-variant: normal;
        text-transform: none;
        line-height: 1;
        position: relative;
        -webkit-font-smoothing: antialiased;
    }


    #widget-chat .btn-sep:before {
        background: rgba(0, 0, 0, 0.15);
    }

    /* Button 1 */
    #widget-chat .btn-1 {
        background: #3498db;
        color: #fff;
        padding-left: 30px;
    }

    #widget-chat .btn-1:hover {
        background: #2980b9;
    }

    #widget-chat .btn-1:active {
        background: #2980b9;
        top: 2px;
    }

    #widget-chat .btn-1:before {
        position: absolute;
        height: 100%;
        left: 0;
        top: 0;
        line-height: 2;
        width: 25px;
    }

    /* Button 2 */
    #widget-chat .btn-2 {
        background: #2ecc71;
        color: #fff;
        padding-left: 30px;
    }

    #widget-chat .btn-2:hover {
        background: #27ae60;
    }

    #widget-chat .btn-2:active {
        background: #27ae60;
        top: 2px;
    }

    #widget-chat .btn-2:before {
        position: absolute;
        height: 100%;
        left: 0;
        top: 0;
        line-height: 2;
        width: 25px;
    }

    /* Icons */

    #widget-chat .icon-cart:before {
        content: "\f07a";
    }

    #widget-chat .icon-info:before {
        content: "\f05a";
    }

</style>

<div id="widget-chat">

    <div id="chat-circle" class="btn btn-raised">
        <div id="chat-overlay"></div>
        <i class="fa-solid fa-message"></i>
    </div>

    <div class="chat-box">
        <div class="chat-box-header">
            <span class="chat-box-toggle"><i class="fa-solid fa-x"></i></span>
        </div>
        <div class="chat-box-body">

            <ul class="nav nav-tabs" role="tablist" id="chat-widget-navbar">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="chat-widget-all-online" data-toggle="tab"
                            data-target="#chat-widget-all-online-tabs" type="button" role="tab" aria-controls="home"
                            aria-selected="true">{{ __('home.Đang trực tuyến') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="chat-widget-connected" data-toggle="tab"
                            data-target="#chat-widget-connected-tabs" type="button" role="tab" aria-controls="profile"
                            aria-selected="false">{{ __('home.Connected') }}
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="chat-widget-all-online-tabs" role="tabpanel"
                     aria-labelledby="chat-widget-all-online">
                    <div id="friendslist-all-online">
                        <div id="friends-all-online"></div>
                    </div>
                </div>
                <div class="tab-pane fade" id="chat-widget-connected-tabs" role="tabpanel"
                     aria-labelledby="chat-widget-connected">
                    <div id="friendslist-connected">
                        <div id="friends-connected"></div>
                    </div>
                </div>

            </div>

            <div id="chatview" class="p1">
                <div id="profile">
                    <div id="close">
                        <i class="fa-solid fa-x"></i>
                    </div>

                    <p></p>
                    <span></span>
                </div>
                <div id="chat-messages"></div>

                <div id="sendmessage">
                    <input type="text" value="Send message..." id="text-chatMessage"/>
                    @if(!\App\Models\User::isNormal())
                        <span class="mr-3" data-toggle="modal" data-target="#modal-create-don-thuoc-widget-chat"><i
                                class="fa-solid fa-plus"></i></span>
                    @endif
                    <span id="send-chatMessage" onclick="sendMessageChatWidget()"><i
                            class="fa-regular fa-paper-plane"></i></span>

                </div>
            </div>

        </div>


    </div>
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
                        <button type="button"
                                class="btn btn-outline-primary mt-3"
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
                                   oninput="handleSearchMedicine()"
                                   placeholder="Tìm kiếm theo tên thuốc">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group position-relative">
                            <label for="inputSearchDrugIngredient" class="form-control-feedback"></label>
                            <input type="search" id="inputSearchDrugIngredient" class="form-control"
                                   oninput="handleSearchMedicine()"
                                   placeholder="Tìm kếm theo thành phần thuốc">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group position-relative">
                            <label for="inputSearchNameMedicine" class="form-control-feedback"></label>
                            <select class="form-select position-relative" id="object_search"
                                    onchange="handleSearchMedicine()">
                                <option
                                    value="{{ \App\Enums\online_medicine\ObjectOnlineMedicine::KIDS }}">{{ __('home.For kids') }}</option>
                                <option value="{{ ObjectOnlineMedicine::FOR_WOMEN }}">{{ __('home.For women') }}
                                </option>
                                <option value="{{ ObjectOnlineMedicine::FOR_MEN }}">{{ __('home.For men') }}</option>
                                <option value="{{ ObjectOnlineMedicine::FOR_ADULT }}">{{ __('home.For adults') }}
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

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.2/dist/echo.iife.js"></script>

<script>

    const CHAT_TYPE_ALL_ONLINE = 'all-online';
    const CHAT_TYPE_CONNECTED = 'connected';

    let chatUserId;
    let isShowOpenWidget;
    let uuid_session;
    let elementInputMedicine_widgetChat;
    let next_elementInputMedicine_widgetChat;
    let next_elementQuantity_widgetChat;
    let next_elementMedicineIngredients_widgetChat;

    let currentUserIdChat = '{{ Auth::check() ? Auth::user()->id : '' }}';

    let totalMessageUnseen = 0;

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: 'e700f994f98dbb41ea9f',
        cluster: 'eu',
        encrypted: true,
    });

    window.Echo.private("messages." + currentUserIdChat).listen('NewMessage', function (e) {
        renderMessageReceive(e);
        // handleSeenMessage();
        calculateTotalMessageUnseen(e);
    });

    function handleSeenMessage() {
        if (!chatUserId) {
            return;
        }

        let url = `{{ route('api.backend.connect.chat.seen-message', ['id' => ':id']) }}`;
        url = url.replace(':id', chatUserId);


        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",

            success: function (data) {
            },
            error: function (e) {
                console.log(e);
            }
        });

    }

    function calculateTotalMessageUnseen(e) {

        if (isShowOpenWidget) {
            return;
        }

        totalMessageUnseen++;

        $('#totalMsgUnseen').html(totalMessageUnseen);

        // duyệt class friend, tìm ra div có data-id = e.message.from
        // tăng thêm 1 span.badge
        $("#friendslist-connected .friend").each(function () {

            if ($(this).data('id') === e.message.from) {
                let countUnseen = $(this).data('msg-unseen');
                countUnseen++;
                $(this).data('msg-unseen', countUnseen);

                $(this).find('span.badge-light').html(countUnseen);
            }

        });
    }

    function genListUserWasConnect(data, type) {
        let html = '';

        if (data.length == 0) {
            // html hiển thị "Bạn chưa chat với bác sĩ nào"


            switch (type) {
                case CHAT_TYPE_ALL_ONLINE:

                    html = `<p>
                            <strong>Không có ai đang online</strong>
                        </p>`;

                    $('#friendslist-all-online #friends-all-online').html(html);
                    break;
                case CHAT_TYPE_CONNECTED:

                    html = `<p>
                            <strong>Bạn chưa chat với ai</strong>
                        </p>`;

                    $('#friendslist-connected #friends-connected').html(html);
                    break;
            }

            return;
        }

        let isShowBadge = false;

        if (type === CHAT_TYPE_CONNECTED) {
            isShowBadge = true;
        }

        $.each(data, function (index, item) {
            let countUnseen = item.count_unread_message;
            if (countUnseen === 0 || !countUnseen) {
                countUnseen = '';
            }
            if (!isShowBadge) {
                countUnseen = '';
            }

            html += `<div class="friend" data-id=${item.id} data-msg-unseen="${countUnseen}">
                        <img src="${item.avt}"/>
                        <p>
                            <strong class="max-1-line-title-widget-chat">${item.name}
                                <span class="badge badge-light text-black">${countUnseen}</span>
                            </strong>
                            <span>${item.email}</span>

                        </p>

                    </div>`;
        });

        switch (type) {
            case CHAT_TYPE_ALL_ONLINE:
                $('#friendslist-all-online #friends-all-online').html(html);
                break;
            case CHAT_TYPE_CONNECTED:
                $('#friendslist-connected #friends-connected').html(html);
                break;
        }


        setOnclickFriend();
    }

    function renderMessageReceive(element) {
        let html = '';
        element = element.message;

        if (element.type != null) {
            if (!element.text) {
                return;
            }

            if (element.type == 'DonThuocMoi') {
                let url = `{{ route('view.prescription.result.detail', ['id' => ':id']) }}`;
                url = url.replace(':id', element.uuid_session);

                html = `<div class="mb-3 d-flex justify-content-center">
                        <a href="${url}">
                        <button class="btn btn-1 btn-sep icon-info">Xem đơn thuốc</button>
                        </a>
                        <a class="ml-2" onclick="addToCart_WidgetChat(${element.uuid_session})">
                        <button class="btn btn-2 btn-sep icon-cart">Mua thuốc</button>
                        </a>
                        </div>`


            }

            if (element.type == 'TaoDonThuoc') {
                html = `<div class="message ">
                        <span >
                            ${element.text}`;

                if ('{{ !\App\Models\User::isNormal() }}') {
                    html += `, <a class="color-blue" data-toggle="modal" data-target="#modal-create-don-thuoc-widget-chat">tạo ngay?</a>
                             </span></div>`;
                }
            }

        } else {
            html = `<div class="message">
                        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1_copy.jpg"/>
                        <div class="bubble">
                            ${element.text}
                            <div class="corner"></div>
                        </div>
                    </div>`
        }

        $('#chat-messages').append(html);
        autoScrollChatBox();
    }

    function setOnclickFriend() {
        $(".friend").each(function () {
            $(this).click(function () {
                isShowOpenWidget = true;

                chatUserId = $(this).data('id');
                // handleSeenMessage();
                handleStartChat(chatUserId);
                removeSpanBadges(this);

                var childOffset = $(this).offset();
                var parentOffset = $(this).parent().parent().offset();
                var childTop = childOffset.top - parentOffset.top;
                var clone = $(this).find('img').eq(0).clone();
                var top = childTop + 12 + "px";


                setTimeout(function () {
                    $("#profile p").addClass("animate");
                    $("#profile").addClass("animate");
                }, 100);
                setTimeout(function () {
                    $("#chat-messages").addClass("animate");
                }, 150);

                var name = $(this).find("p strong").html();
                var email = $(this).find("p span").html();
                $("#profile p").html(name);
                $("#profile span").html(email);

                $(".message").not(".right").find("img").attr("src", $(clone).attr("src"));
                let parent = $(this).parent();
                parent.hide();
                $('#chat-widget-navbar').hide();
                $('#chatview').show();

                $('#close').unbind("click").click(function () {
                    isShowOpenWidget = false;

                    handleCloseButton(uuid_session);

                    uuid_session = '';

                    $("#chat-messages, #profile, #profile p").removeClass("animate");

                    setTimeout(function () {
                        $('#chatview').hide();
                        // $(this).parent().show();
                        parent.show();
                        $('#chat-widget-navbar').show();
                    }, 50);
                });
            });
        });
    }

    function handleCloseButton(uuid_session) {
        let currentUserId = '{{ Auth::check() ? Auth::user()->id : '' }}';

        $.ajax({
            url: "{{ route('chat.send-message.renew-uuid') }}",
            type: "POST",
            dataType: "json",
            data: {
                sender_id: currentUserId,
                receiver_id: chatUserId,
                text: '',
                uuid_session: uuid_session,
                type: uuid_session
            },
            success: function (data) {
                uuid_session = data.uuid_session;
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    function removeSpanBadges(divElement) {
        $(divElement).find('span.badge').html('');

        let countUnseen = $(divElement).data('msg-unseen');

        totalMessageUnseen -= countUnseen;

        if (totalMessageUnseen <= 0) {
            $('#totalMsgUnseen').html('');
        } else {
            $('#totalMsgUnseen').html(totalMessageUnseen);
        }
    }

    // Gắn sự kiện keyup cho input
    $('#text-chatMessage').keypress(function (event) {
        // Kiểm tra xem nút nhấn có phải là Enter (mã 13) hay không
        if (event.keyCode === 13) {
            // Xử lý sự kiện khi nhấn Enter
            sendMessageChatWidget();
        }
    });


    function sendMessageChatWidget() {
        let textChat = $('#text-chatMessage').val();
        if (textChat.trim() == '') {
            return;
        }

        let currentUserId = '{{ Auth::check() ? Auth::user()->id : '' }}';

        $.ajax({
            url: "{{ route('chat.send-message') }}",
            type: "POST",
            dataType: "json",
            data: {
                sender_id: currentUserId,
                receiver_id: chatUserId,
                text: textChat,
                uuid_session: uuid_session
            },
            success: function (data) {
                uuid_session = data.uuid_session;

                renderMessageFromThisUser(textChat);
                afterSendMessageChatWidget();
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    function renderMessageFromThisUser(textChat) {
        let html = `<div class="message right">
                        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1_copy.jpg"/>
                        <div class="bubble">
                            ${textChat}
                            <div class="corner"></div>
                        </div>
                    </div>`
        $('#chat-messages').append(html);
    }

    function afterSendMessageChatWidget() {
        $('#text-chatMessage').val('');

        //scroll to bottom
        autoScrollChatBox();
    }

    function autoScrollChatBox() {
        $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
    }


    $(function () {

        $("#chat-circle").click(function () {
            $("#chat-circle").toggle("scale");
            $(".chat-box").toggle("scale");
        });

        $(".chat-box-toggle").click(function () {
            isShowOpenWidget = false;
            $("#chat-circle").toggle("scale");
            $(".chat-box").toggle("scale");
        });

    });

    $(document).ready(function () {


        var preloadbg = document.createElement("img");
        preloadbg.src = "https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/timeline1.png";

        $("#sendmessage input").focus(function () {
            if ($(this).val() == "Send message...") {
                $(this).val("");
            }
        });
        $("#sendmessage input").focusout(function () {
            if ($(this).val() == "") {
                $(this).val("Send message...");

            }
        });

    });

    function handleStartChat(id) {
        getMessage(id);
    }

    async function getMessage(id) {
        document.getElementById('chat-messages').innerHTML = '';

        let accessToken = `Bearer ` + token;

        let url = `{{ route('api.backend.connect.chat.getMessageByUserId', ['id' => ':id']) }}`;
        url = url.replace(':id', id);
        let data = [];

        let result = await fetch(url, {
            method: 'GET',
            headers: {
                'Authorization': accessToken
            },
        })

        if (result.ok) {
            data = await result.json();
            renderMessage(data);
        }
    }

    function renderMessage(data) {
        let html = '';

        let currentUserId = '{{ Auth::check() ? Auth::user()->id : '' }}';
        data.forEach((msg) => {
            if (msg.type) {
                if (!msg.chat_message) {
                    return;
                }

                if (msg.type == 'DonThuocMoi') {
                    console.log(msg)
                    let url = `{{ route('view.prescription.result.detail', ['id' => ':id']) }}`;
                    url = url.replace(':id', msg.uuid_session);

                    html += `<div class="mb-3 d-flex justify-content-center">
                            <a href="${url}">

                            <button class="btn btn-1 btn-sep icon-info">Xem đơn thuốc</button>

                            </a>
                            <a class="ml-2" onclick="addToCart_WidgetChat(${msg.uuid_session})">
                            <button class="btn btn-2 btn-sep icon-cart">Mua thuốc</button>
                            </a>
                            </div>`;

                    return;
                }

                if (msg.type == 'TaoDonThuoc') {
                    html += `<div class="message ">
                        <span >
                            ${msg.chat_message}`;

                    if ('{{ !\App\Models\User::isNormal() }}') {
                        html += `, <a class="color-blue" data-toggle="modal" data-target="#modal-create-don-thuoc-widget-chat">tạo ngay?</a>`;
                    }
                    html += `</span></div>`;
                }

                return;
            }

            if (!msg.chat_message) {
                return;
            }

            let isMySeen = msg.from_user_id === currentUserId ? 'right' : '';


            html += `<div class="message ${isMySeen}">
                        <img src="${msg.from_avatar}"/>
                        <div class="bubble">
                            ${msg.chat_message}
                            <div class="corner"></div>
                        </div>
                    </div>`
        });

        document.getElementById('chat-messages').innerHTML = html;
        autoScrollChatBox();
    }

    function addToCart_WidgetChat(id) {
        loadingMasterPage();
        let data = {
            prescription_id: id,
            user_id: `{{ Auth::user()->id }}`,
        };
        let accessToken = `Bearer ` + token;
        let headers = {
            "Authorization": accessToken
        };

        try {
            $.ajax({
                url: `{{ route('api.backend.prescription.result.add.cart.v2') }}`,
                method: 'POST',
                headers: headers,
                data: data,

                success: function (response, textStatus, xhr) {
                    loadingMasterPage();
                    alert(response.message);
                    var statusCode = xhr.status;
                    if (statusCode === 200) {
                        window.location.href = `{{ route('user.checkout.index') }}`;
                    }
                },
                error: function (xhr, status, error) {
                    loadingMasterPage();
                    alert(xhr.responseJSON.message);
                }
            });
        } catch (e) {
        }
    }


    function getListUserWasConnect() {
        if (!'{{ Auth::check() }}') {
            return;
        }
        $.ajax({
            url: "{{ route('api.backend.connect.chat.getListUserWasConnect') }}",
            type: "GET",
            dataType: "json",
            success: function (data) {
                genListUserWasConnect(data.connected, CHAT_TYPE_CONNECTED);
                genListUserWasConnect(data.online, CHAT_TYPE_ALL_ONLINE);
                renderTotalMessageUnseen(data.connected);
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    function renderTotalMessageUnseen(data) {
        if (data.length < 1) {
            return;
        }
        totalMessageUnseen = data[0]['total_unread_message'];

        if (totalMessageUnseen <= 1) {
            totalMessageUnseen = '';
        }
        $('#chat-circle').append(`<span class="badge badge-light text-black" id="totalMsgUnseen">${totalMessageUnseen}</span>`);
    }

    getListUserWasConnect();

    function handleStartChatWithDoctor(id = 0) {
        /* tất cả các hàm dưới đây đều ở trong file chat-message.blade.php
              * id nhận vào là id của người dùng cần chat
              * hàm hideTabActive() dùng để ẩn tất cả các tab đang active
              * hàm getMessage(id) dùng để lấy tin nhắn của người dùng đó với người dùng hiện tại
              * hàm loadDisplayMessage(id) dùng để load tin nhắn của người dùng đó với người dùng hiện tại
              * hàm showOrHiddenChat() dùng để hiển thị widget chat
              */

        hideTabActive();
        getMessage(id);
        loadDisplayMessage(id);
        showOrHiddenChat();
    }

    function hideTabActive() {
        let tabActive = document.querySelectorAll('.tab-pane.fade');
        tabActive.forEach(function (tab) {
            tab.classList.remove('active');
            tab.classList.remove('show');
        });
    }

    function showOrHiddenChat() {
        document.getElementById('chat-circle').click();
    }

    let html_widgetChat = `<div class="service-result-item d-flex align-items-center justify-content-between border p-3">
                    <div class="row w-75">
                        <div class="form-group">
                            <label for="medicine_name">Medicine Name</label>
                            <input type="text" class="form-control medicine_name" value=""
                                   name="medicine_name" onclick="handleClickInputMedicine_widgetChat(this, $(this).next('.medicine_id_hidden'))" data-toggle="modal" data-target="#modal-add-medicine-widget-chat" readonly>
                            <input type="text" hidden class="form-control medicine_id_hidden" name="medicine_id_hidden" value="">

                        </div>
                        <div class="form-group">
                            <label for="medicine_ingredients">Medicine Ingredients</label>
                            <textarea class="form-control medicine_ingredients" readonly name="medicine_ingredients" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="quantity">{{ __('home.Quantity') }}</label>
                            <input type="number" min="1" class="form-control quantity" name="quantity">
                        </div>
                        <div class="form-group">
                            <label for="detail_value">Note</label>
                            <input type="text" class="form-control detail_value" name="detail_value">
                        </div>
                    </div>
                    <div class="action mt-3">
                        <i class="fa-regular fa-trash-can" onclick="loadTrash_widgetChat(this)" style="cursor: pointer; font-size: 24px"></i>
                    </div>
                </div>`;

    function handleAddMedicine_widgetChat() {
        $('#list-service-result').append(html_widgetChat);
        loadData_widgetChat();
    }

    function loadDisplayMessage(id) {
        var friendDivs = document.querySelectorAll('.friend');

        friendDivs.forEach(function (div) {
            // Lấy giá trị data-id của từng div
            var dataId = div.getAttribute('data-id');

            // Kiểm tra xem data-id có bằng currentId hay không
            if (dataId === id) {
                div.click();
            }
        });
    }

    loadListMedicine();

    function loadListMedicine() {
        let inputNameMedicine_Search = $('#inputSearchNameMedicine').val().toLowerCase();
        let inputDrugIngredient_Search = $('#inputSearchDrugIngredient').val().toLowerCase();
        let object_search = $('#object_search').val().toLowerCase();

        let url = '{{ route('view.prescription.result.get-medicine') }}'
        url = url + `?name_search=${inputNameMedicine_Search}&drug_ingredient_search=${inputDrugIngredient_Search}&object_search=${object_search}`;

        $.ajax({
            url: url,
            method: 'GET',
            success: function (response) {
                renderMedicine(response);
            },
            error: function (error) {
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
                success: function (response) {
                    alert('Create success!')
                    window.location.href = `{{ route('view.prescription.result.doctor') }}`;
                },
                error: function (error) {
                    alert(error.responseJSON.message);
                }
            });
        } catch (e) {
            console.log(e)
            alert('Error, Please try again!');
        }
    }

    async function handleSelectInputMedicine_widgetChat(id, name, quantity) {
        elementInputMedicine_widgetChat.value = name;
        next_elementInputMedicine_widgetChat.val(id);
        next_elementQuantity_widgetChat.off('change');

        next_elementQuantity_widgetChat.attr('max', quantity);

        // Thêm sự kiện onchange
        next_elementQuantity_widgetChat.on('change', function () {
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

    function handleClickInputMedicine_widgetChat(element, nextElement) {
        elementInputMedicine_widgetChat = element;
        next_elementInputMedicine_widgetChat = nextElement;
        next_elementQuantity_widgetChat = $(element).parents().parents().find('input.quantity');
        next_elementMedicineIngredients_widgetChat = $(element).parents().parents().find('textarea.medicine_ingredients');
    }

    loadData_widgetChat();

    function loadTrash_widgetChat(element) {
        $(element).parent().parent().remove();
    }


    function loadData_widgetChat() {
        $('.service_name_item').on('click', function () {
            let my_array = null;
            let my_name = null;
            $(this).parent().parent().find(':checkbox:checked').each(function (i) {
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

    function handleSearchMedicine() {
        loadListMedicine();
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

        return {'compoent_name': ''};
    }
</script>

