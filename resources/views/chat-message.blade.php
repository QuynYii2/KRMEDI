@extends('layouts.master')
@section('title', 'Chat Message')
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')
    <style>
        .msger {
            display: flex;
            flex-flow: column wrap;
            justify-content: space-between;
            width: 100%;
            max-width: 867px;
            margin: 0 10px 25px 10px;
            height: calc(100% - 50px);
            border: var(--border);
            border-radius: 5px;
            background: var(--msger-bg);
            box-shadow: 0 15px 15px -5px rgba(0, 0, 0, 0.2);
        }

        .msger-header {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: var(--border);
            background: #eee;
            color: #666;
        }

        .msger-chat {
            flex: 1;
            overflow-y: auto;
            padding: 10px;
        }

        .msger-chat::-webkit-scrollbar {
            width: 6px;
        }

        .msger-chat::-webkit-scrollbar-track {
            background: #ddd;
        }

        .msger-chat::-webkit-scrollbar-thumb {
            background: #bdbdbd;
        }

        .msg {
            display: flex;
            align-items: flex-end;
            margin-bottom: 10px;
        }

        .msg:last-of-type {
            margin: 0;
        }

        .msg-img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
            background: #ddd;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            border-radius: 50%;
        }

        .msg-bubble {
            max-width: 450px;
            padding: 15px;
            border-radius: 15px;
            background: var(--left-msg-bg);
        }

        .msg-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .msg-info-name {
            margin-right: 10px;
            font-weight: bold;
        }

        .msg-info-time {
            font-size: 0.85em;
        }

        .left-msg .msg-bubble {
            border-bottom-left-radius: 0;
        }

        .right-msg {
            flex-direction: row-reverse;
        }

        .right-msg .msg-bubble {
            background: var(--right-msg-bg);
            border-bottom-right-radius: 0;
        }

        .right-msg .msg-img {
            margin: 0 0 0 10px;
        }

        .msger-inputarea {
            display: flex;
            padding: 10px;
            border-top: var(--border);
            background: #eee;
        }

        .msger-inputarea * {
            padding: 10px;
            border: none;
            border-radius: 3px;
            font-size: 1em;
        }

        .msger-input {
            flex: 1;
            background: #ddd;
        }

        .msger-send-btn {
            margin-left: 10px;
            background: rgb(0, 196, 65);
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.23s;
        }

        .msger-send-btn:hover {
            background: rgb(0, 180, 50);
        }

        .msger-chat {
            background-color: #fcfcfe;
        }

        .new-message {
            border: 1px solid #ccc;
            border-radius: 50px;
            color: #fff;
            background-color: red
        }

        .read {
            color: #000;
        }

        .unread {
            color: gray;
        }
    </style>
    <div class="container">
        <div class="layout-chat d-flex justify-content-start align-items-start">
            <div class="list-user border" id="list-user" style="max-height: 500px; overflow: scroll">

            </div>
            <div class="main-chat">
                <section class="msger">
                    <header class="msger-header">
                        <div class="msger-header-title">
                            <i class="fas fa-comment-alt"></i> <span id="chat_to_user">Open chat</span>
                        </div>
                        <div class="msger-header-options">
                            <span><i class="fas fa-cog"></i></span>
                        </div>
                    </header>

                    <main class="msger-chat" id="main_chat_area">
                        <p class="text-center">No message</p>
                    </main>

                    <div class="msger-inputarea">
                        <input type="text" class="msger-input" placeholder="Enter your message..." id="msger-input"
                               onkeypress="supSendMessage()">
                        <button type="button" class="msger-send-btn">Send</button>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <script>
        function supSendMessage() {
            if (event.keyCode === 13 && !event.shiftKey) {
                $('.msger-send-btn').trigger('click');
            }
        }

        function setCookie(name, value, hours) {
            var expires = 5;
            if (hours) {
                var date = new Date();
                date.setTime(date.getTime() + (hours * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }

        function getCookie(name) {
            let cookies = document.cookie.split(';').map(cookie => cookie.trim());
            for (let i = 0; i < cookies.length; i++) {
                let cookie = cookies[i];
                if (cookie.startsWith(name + '=')) {
                    return cookie.substring(name.length + 1);
                }
            }
            return null;
        }

    </script>
    <script type="module">
        import {firebaseConfig} from '{{ asset('constants.js') }}';
        import {initializeApp} from "https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js";
        import {
            collection,
            getDocs,
            updateDoc,
            doc,
            onSnapshot,
            setDoc,
            getFirestore,
            getDoc,
            where,
            query,
        } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-firestore.js";
        import {
            getAuth,
            signInWithEmailAndPassword,
            createUserWithEmailAndPassword,
            signOut
        } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-auth.js";

        const app = initializeApp(firebaseConfig);
        const database = getFirestore(app);
        const auth = getAuth();

        let current_user, list_user = [],
            current_role = `{{ (new \App\Http\Controllers\MainController())->getRoleUser(Auth::user()->id)}}`,
            user_chat;

        login();

        async function login() {
            await signInWithEmailAndPassword(auth, `{{ Auth::user()->email }}`, '123456')
                .then((userCredential) => {
                    current_user = userCredential.user;
                    let uid = current_user.uid;

                    setOnline(uid, true);
                    setCookie("is_login", true, 1);
                })
                .catch((error) => {
                    const errorCode = error.code;
                    const errorMessage = error.message;
                    registerUser();
                });
        }

        async function registerUser() {
            await createUserWithEmailAndPassword(auth, `{{ Auth::user()->email }}`, '123456')
                .then((userCredential) => {
                    current_user = userCredential.user;
                })
                .catch((error) => {
                    const errorCode = error.code;
                    const errorMessage = error.message;
                });
        }

        async function logout() {
            let uid = current_user.uid;
            await signOut(auth).then(() => {
                setOnline(uid, false)
                current_user = null;
            }).catch((error) => {
                // An error happened.
            });
        }

        async function setOnline(uid, isOnline) {
            try {
                await updateDoc(doc(database, 'users', uid), {
                    'is_online': isOnline,
                    'last_active': Date.now(),
                });
                console.log('Status updated successfully', isOnline);
            } catch (error) {
                console.error('Error updating active status:', error);
            }
        }

        const usersCollection = collection(database, "users");

        const chatsCollection = collection(database, "chats");

        function getConversationID(userUid) {
            let id = current_user.uid;

            let hash_value;
            String.prototype.hashCode = function () {
                let hash = 0,
                    i, chr;
                if (this.length === 0) return hash;
                for (i = 0; i < this.length; i++) {
                    chr = this.charCodeAt(i);
                    hash = ((hash << 5) - hash) + chr;
                    hash |= 0;
                }
                return hash;
            }

            if (id.hashCode() <= userUid.hashCode()) {
                hash_value = `${userUid}_${id}`;
            } else {
                hash_value = `${id}_${userUid}`;
            }
            console.log(hash_value)
            return hash_value;
        }

        const unsubscribe = onSnapshot(usersCollection, (querySnapshot) => {
            querySnapshot.forEach((doc) => {
                let res = doc.data();
                list_user.push(res);
            });
            renderUser();
            getMessageFirebase();
        }, (error) => {
            console.error("Error getting: ", error);
        });

        let new_message = `<p class="read">A new message</p>
                        <p class="number">
                            <span class="p-1 new-message">1</span>
                        </p>`;

        let un_message = `<p class="unread">Not connected!</p>`;

        let online = 'color: green';
        let offline = 'color: grey';

        async function renderUser() {
            let html = ``;
            for (let i = 0; i < list_user.length; i++) {
                let res = list_user[i];
                let email = res.email;

                let is_online = res.is_online;

                let show;
                if (is_online === true) {
                    show = online;
                } else {
                    show = offline;
                }

                html = html + `<div class="card p-1 m-1 user_connect" data-id="${res.id}"
                                   data-role="${res.role}" data-email="${email}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <b class="">${email}</b>
                                    <span class="d-flex align-items-center justify-content-between ml-2">
                                        <i style="font-size: 10px; ${show}" class="fa-solid fa-circle"></i>
                                    </span>
                                </div>
                                <div class="small d-flex justify-content-between align-items-center">
                                    ${un_message}
                                </div>
                            </div>`;

            }
            $('#list-user').empty().append(html);
        }

        btnSendMessage();

        function btnSendMessage() {
            let msger_input = $('#msger-input');
            $('.msger-send-btn').click(function () {
                let msg = msger_input.val();
                let toUser = $(this).data('to_user');
                let to_email = $(this).data('to_email');
                sendMessage(toUser, to_email, msg, 'text');
                msger_input.val('');
            })
        }

        async function sendMessage(chatUserID, to_email, msg, type) {
            const time = Date.now().toString();
            const receiverId = chatUserID;

            const message = {
                toId: receiverId,
                msg: msg,
                read: '',
                type: type,
                fromId: current_user.uid,
                readUsers: {[current_user.uid]: true, [receiverId]: false},
                sent: time
            };

            let conversationID = getConversationID(chatUserID);

            const ref = collection(database, `chats/${conversationID}/messages/`);

            try {
                await setDoc(doc(ref, time), message);
                await pushNotification(to_email, msg);
                await updateLastMessage(chatUserID, message);
                await saveMessage(`{{ Auth::user()->email }}`, to_email, message);
                console.log('Message sent successfully');
            } catch (error) {
                console.error('Error sending message:', error);
            }
        }

        function renderLayOutChat(email, id) {
            $('#chat_to_user').text(email);
            $('.msger-send-btn').data('to_user', id);
            $('#msger-input').val('');
        }

        function getMessageFirebase() {
            $('.user_connect').click(function () {
                let id = $(this).data('id');
                let email = $(this).data('email');
                let role = $(this).data('role');

                let conversationID = getConversationID(id);

                const messagesCollectionRef = collection(database, `chats/${conversationID}/messages`);

                let html = ``;

                const unsubscribe = onSnapshot(messagesCollectionRef, (querySnapshot) => {
                    let list_message = [];

                    querySnapshot.forEach((doc) => {
                        console.log(doc.data())
                        list_message.push(doc.data());
                    });

                    renderMessage(list_message, html);
                }, (error) => {
                    console.error("Error getting: ", error);
                });

                renderLayOutChat(email, id);

                let user = {
                    role: role,
                    id: id
                };

                initialChatRoom(user);
            })
        }

        function renderMessage(list_message, html) {

            if (list_message.length > 0) {
                for (let i = 0; i < list_message.length; i++) {
                    let message = list_message[i];

                    let time = formatDate(message.sent);

                    if (message.fromId === current_user.uid) {
                        html = html + `<div class="msg right-msg">
                            <div class="msg-img"
                                 style="background-image: url(https://image.flaticon.com/icons/svg/145/145867.svg)"></div>

                            <div class="msg-bubble">
                                <div class="msg-info">
                                    <div class="msg-info-name">Me</div>
                                    <div class="msg-info-time">${time}</div>
                                </div>

                                <div class="msg-text">
                                    ${message.msg}
                                </div>
                            </div>
                        </div>`;
                    } else {
                        html = html + `<div class="msg left-msg">
                            <div class="msg-img"
                                 style="background-image: url(https://image.flaticon.com/icons/svg/327/327779.svg)"></div>

                            <div class="msg-bubble">
                                <div class="msg-info">
                                    <div class="msg-info-name">You</div>
                                    <div class="msg-info-time">${time}</div>
                                </div>

                                <div class="msg-text">
                                    ${message.msg}
                                </div>
                            </div>
                        </div>`;
                    }
                }
            }

            $('#main_chat_area').empty().append(html);
        }

        async function initialChatRoom(user) {
            const currentChatRoom = await getChatGroup(user);
            const targetChannelType = user.role;
            let myChannelType;

            if (current_role !== '{{ \App\Enums\Role::PHAMACISTS }}' &&
                current_role !== '{{ \App\Enums\Role::DOCTORS }}' &&
                current_role !== '{{ \App\Enums\Role::CLINICS }}' &&
                current_role !== '{{ \App\Enums\Role::HOSPITALS }}') {
                myChannelType = user.role;
            } else {
                myChannelType = current_role;
            }

            if (currentChatRoom === null) {
                const chatRoomInfo = {
                    userIds: [current_user.uid, user.id],
                    groupId: getConversationID(user.id),
                    createdBy: current_user.uid,
                    unreadMessageCount: {[current_user.uid]: 0, [user.id]: 0},
                    createdAt: new Date().getTime().toString(),
                    channelTypes: [
                        `${current_user.uid}_${targetChannelType}`,
                        `${user.id}_${myChannelType}`
                    ]
                };
                await createChatRoom(user, chatRoomInfo);
            }
        }

        async function createChatRoom(chatUser, chatRoom) {
            try {
                const chatMessageCollection = collection(database, 'chats');
                const chatDocRef = doc(chatMessageCollection, getConversationID(chatUser.id));
                await setDoc(chatDocRef, chatRoom, {merge: true});
                console.log("Chat room created successfully.");
            } catch (error) {
                console.error("Error creating chat room:", error);
            }
        }

        async function getChatGroup(chatUser) {
            try {
                const chatMessageCollection = collection(database, 'chats');
                const chatDocSnapshot = await doc(chatMessageCollection, getConversationID(chatUser.id));

                if (chatDocSnapshot.exists) {
                    const data = chatDocSnapshot.data();
                    console.log("Chat group data:", data);
                    return data;
                } else {
                    console.log("Chat group does not exist.");
                    return null;
                }
            } catch (error) {
                console.error("Error getting chat group:", error);
                return null;
            }
        }

        async function updateLastMessage(chatUserID, lastMessage) {
            const callType = _getTypeFromString(lastMessage.type);
            let updatedMessage = JSON.parse(JSON.stringify(lastMessage));

            if (callType !== "") {
                updatedMessage.msg = callType;
            }

            try {
                const chatMessageCollection = collection(database, 'chats');
                const chatDocRef = doc(chatMessageCollection, getConversationID(chatUserID));
                if (updatedMessage && updatedMessage.msg) {
                    await setDoc(chatDocRef, {lastMessage: updatedMessage}, {merge: true});
                    console.log("Chat set successfully.");
                } else {
                    throw new Error("Invalid or missing updated message data.");
                }
            } catch (error) {
                console.error("Error set chat:", error);
            }

            // await countUnreadMessages(chatUserID, updatedMessage);
        }

        function _getTypeFromString(name) {
            return name;
        }

        async function countUnreadMessages(chatUserID, message) {
            try {
                const chatMessageCollection = collection(database, 'chats');
                const chatDocRef = doc(chatMessageCollection, getConversationID(chatUserID));
                const messagesRef = collection(chatDocRef, "messages");

                const chatDocSnapshot = await getDoc(chatDocRef);
                const chatDocData = chatDocSnapshot.data();

                if (chatDocData) {
                    const unreadUserId = chatDocData.lastMessage?.fromId === chatUserID ? message.fromId : chatUserID;

                    const unreadSnapshot = await getDocs(query(messagesRef, where(`readUsers.${unreadUserId}`, "==", false)));
                    const unreadCount = unreadSnapshot.size;

                    await chatDocRef.set({
                        unreadMessageCount: {[chatUserID]: 0, [unreadUserId]: unreadCount}
                    }, {merge: true});
                } else {
                    console.log("Chat room not found.");
                }
            } catch (error) {
                console.error("Error counting unread messages:", error);
            }
        }

        function getTokenUser() {

        }

        async function pushNotification(to_email, msg) {

            const body = {
                "to": to_email,
                "notification": {
                    "title": `{{ Auth::user()->username }}`,
                    "body": msg,
                    "android_channel_id": "chats"
                },
            };

            const notification = {
                "title": `{{ Auth::user()->username }}`,
                "body": msg,
                "android_channel_id": "chats"
            };

            const data = {
                email: to_email,
                data: notification,
                notification: notification
            };

            let sendNotiUrl = `{{ route('restapi.mobile.fcm.send') }}`
            await $.ajax({
                url: sendNotiUrl,
                method: 'POST',
                data: data,
                success: function (response) {
                    console.log(response)
                },
                error: function (error) {
                    console.log(error.responseJSON.message);
                }
            });
        }


        async function saveMessage(from_email, to_email, message) {

        }
    </script>
    <script>
        let accessToken = `Bearer ` + token;

        async function getUserFromEmail(email) {
            try {
                let url_getUser = `{{ route('api.backend.user.get.user.email') }}?email=${email}`;
                let response = await fetch(url_getUser, {
                    method: 'GET',
                    headers: {
                        "Authorization": accessToken
                    }
                });
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return await response.json();
            } catch (error) {
                console.error('Error fetching user:', error);
                throw error;
            }
        }
    </script>
    <script>
        function get(selector, root = document) {
            return root.querySelector(selector);
        }

        function formatDate(timestamp) {
            const date = new Date(parseInt(timestamp));

            console.log(date);
            const h = "0" + date.getHours();
            const m = "0" + date.getMinutes();

            return `${h.slice(-2)}:${m.slice(-2)}`;
        }

        function random(min, max) {
            return Math.floor(Math.random() * (max - min) + min);
        }

    </script>
@endsection
