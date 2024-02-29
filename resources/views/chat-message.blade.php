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
                            <i class="fas fa-comment-alt"></i> SimpleChat
                        </div>
                        <div class="msger-header-options">
                            <span><i class="fas fa-cog"></i></span>
                        </div>
                    </header>

                    <main class="msger-chat">
                        <div class="msg left-msg">
                            <div class="msg-img"
                                 style="background-image: url(https://image.flaticon.com/icons/svg/327/327779.svg)"></div>

                            <div class="msg-bubble">
                                <div class="msg-info">
                                    <div class="msg-info-name">BOT</div>
                                    <div class="msg-info-time">12:45</div>
                                </div>

                                <div class="msg-text">
                                    Hi, welcome to SimpleChat! Go ahead and send me a message. 😄
                                </div>
                            </div>
                        </div>

                        <div class="msg right-msg">
                            <div class="msg-img"
                                 style="background-image: url(https://image.flaticon.com/icons/svg/145/145867.svg)"></div>

                            <div class="msg-bubble">
                                <div class="msg-info">
                                    <div class="msg-info-name">Sajad</div>
                                    <div class="msg-info-time">12:46</div>
                                </div>

                                <div class="msg-text">
                                    You can change your name in JS section!
                                </div>
                            </div>
                        </div>
                    </main>

                    <form class="msger-inputarea">
                        <input type="text" class="msger-input" placeholder="Enter your message...">
                        <button type="button" class="msger-send-btn">Send</button>
                    </form>
                </section>
            </div>
        </div>
    </div>
    <script type="module">
        import {firebaseConfig} from '{{ asset('constants.js') }}';
        import {initializeApp} from "https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js";
        import {
            collection,
            getDocs,
            getFirestore,
            where,
        } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-firestore.js";
        import {
            getAuth,
            signInWithEmailAndPassword,
            createUserWithEmailAndPassword,
            signOut
        } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-auth.js";

        const auth = getAuth();

        /*.collection("users")
.where("name", "==", "")
*/

        let current_user;

        async function login() {
            await signInWithEmailAndPassword(auth, `{{ Auth::user()->email }}`, '123456')
                .then((userCredential) => {
                    current_user = userCredential.user;
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

        const app = initializeApp(firebaseConfig);
        const database = getFirestore(app);

        const usersCollection = collection(database, "users");

        getDocs(usersCollection).then((querySnapshot) => {
            querySnapshot.forEach((doc) => {
                let res = doc.data();
                let role = res.role;
                if (role === 'DOCTORS') {
                    renderUser(res);
                }
            });
        }).catch((error) => {
            console.error("Error getting documents: ", error);
        });

        let new_message = `<p class="read">A new message</p>
                        <p class="number">
                            <span class="p-1 new-message">1</span>
                        </p>`;

        let un_message = `<p class="unread">Not connected!</p>`;

        let online = 'color: green';
        let offline = 'color: grey';

        async function renderUser(res) {
            let html = ``;

            let email = res.email;

            let is_online = res.is_online;

            let show;
            if (is_online === true) {
                show = online;
            } else {
                show = offline;
            }

            html = html + `<div class="card p-1 m-1">
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

            $('#list-user').append(html);
        }


        function logout() {
            signOut(auth).then(() => {
                // Sign-out successful.
            }).catch((error) => {
                // An error happened.
            });
        }

        function renderMessage() {

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

        function formatDate(date) {
            const h = "0" + date.getHours();
            const m = "0" + date.getMinutes();

            return `${h.slice(-2)}:${m.slice(-2)}`;
        }

        function random(min, max) {
            return Math.floor(Math.random() * (max - min) + min);
        }

    </script>
@endsection