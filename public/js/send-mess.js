import {firebaseConfig} from '../constants.js';
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
    getMessaging,
    getToken,
} from "https://www.gstatic.com/firebasejs/10.8.0/firebase-messaging.js";
import {
    signInWithEmailAndPassword,
    createUserWithEmailAndPassword,
    getAuth
} from "https://www.gstatic.com/firebasejs/10.8.0/firebase-auth.js";
import {
    getStorage,
    ref,
    uploadBytes,
    getDownloadURL
} from "https://www.gstatic.com/firebasejs/10.8.0/firebase-storage.js";
const app = initializeApp(firebaseConfig);
const database = getFirestore(app);
const auth = getAuth();
const storage = getStorage(app);
const usersCollection = collection(database, "users");
const chatsCollection = collection(database, "chats");
document.addEventListener("readystatechange", function() {
    if (document.readyState === "complete") {
        function getDoctorByEmailOnline(email) {
            const q = query(
                collection(database, 'users'), where('email', '==', email));
            return getDocs(q)
                .then((querySnapshot) => {
                    querySnapshot.forEach((doc) => {
                        if (doc.data().is_online == true){
                            hideTabActive();
                            loadDisplayMessage(doc.data().id);
                            showOrHiddenChat();
                        }else{
                            alert('Bác sĩ hiện không online. Vui lòng liên hệ lại sau.');
                        }
                    });
                })
                .catch((error) => {
                    console.error('Lỗi khi truy vấn cơ sở dữ liệu:', error);
                    throw error;
                });
        }

        document.querySelectorAll('.contact_doctor').forEach(function(element) {
            element.addEventListener('click', function() {
                const email = $(this).data('mail');
                getDoctorByEmailOnline(email);
            });
        });

        document.querySelector('.doctor_mess').addEventListener('click', function(event) {
            const email = $(this).data('mail');
            showOrHiddenChat();

            // Show and set attributes for chat-widget-connected
            const chatWidgetConnected = document.getElementById('chat-widget-connected');
            chatWidgetConnected.classList.add('active');
            chatWidgetConnected.classList.add('show');
            chatWidgetConnected.setAttribute('aria-selected', 'true');
            const chatWidgetConnectedBody = document.getElementById('chat-widget-connected-tabs');
            chatWidgetConnectedBody.classList.add('active');
            chatWidgetConnectedBody.classList.add('show');

            // Hide and set attributes for chat-widget-all-online
            const chatWidgetAllOnline = document.getElementById('chat-widget-all-online');
            chatWidgetAllOnline.classList.remove('active');
            chatWidgetAllOnline.classList.remove('show');
            chatWidgetAllOnline.setAttribute('aria-selected', 'false');
            const chatWidgetAllOnlineBody = document.getElementById('chat-widget-all-online-tabs');
            chatWidgetAllOnlineBody.classList.remove('active');
            chatWidgetAllOnlineBody.classList.remove('show');

            const currentUserEmail = window.Laravel.user.email;
            const currentUserUsername = window.Laravel.user.username;
            const currentUserID = window.Laravel.user.id;

            console.log(currentUserUsername,currentUserID )

            let current_user = null;
            let list_user = [], doctorChatList = [], list_user_not_seen = [];
            let current_role = `{{ (new \App\Http\Controllers\MainController())->getRoleUser(Auth::user()->id)}}`;
            let user_chat;

            async function initialize() {
                await login();
                const conversationID = getConversationID('');
                console.log('Conversation ID:', conversationID);
            }

            initialize();

            async function login() {
                try {
                    const userCredential = await signInWithEmailAndPassword(auth, currentUserEmail, '123456');
                    current_user = userCredential.user;
                    console.log(current_user);
                    const userDocRef = doc(database, "users", current_user.uid);
                    const userDoc = await getDoc(userDocRef);

                    if (!userDoc.exists()) {
                        await createUserInFirestore(current_user);
                        await updateFirebaseToken();
                    }

                    let uid = current_user.uid;
                    setOnline(uid, true);
                    setCookie("is_login", true, 1);
                    return current_user; // Return the user for chaining
                } catch (error) {
                    await registerUser();
                    return current_user; // Return the user even if registration is needed
                }
            }

            async function registerUser() {
                try {
                    const email = window.Laravel.user.email;
                    const userCredential = await createUserWithEmailAndPassword(auth, email, '123456');
                    current_user = userCredential.user;
                    await createUserInFirestore(current_user);
                    await updateFirebaseToken();
                } catch (error) {
                    console.error('Register error:', error);
                }
            }

            function setOnline(uid, isOnline) {
                try {
                    updateDoc(doc(database, 'users', uid), {
                        'is_online': isOnline,
                        'last_active': Date.now(),
                    }).then(() => {
                        console.log('Status updated successfully', isOnline);
                        // Assuming each user has a label identified by a unique ID like `status-${uid}`
                        const onlineDot = document.querySelector(`.online-dot`);
                        const offlineDot = document.querySelector(`.offline-dot`);

                        if (isOnline) {
                            onlineDot.style.display = 'block';   // Show online dot
                            offlineDot.style.display = 'none';  // Hide offline dot
                        } else {
                            onlineDot.style.display = 'none';    // Hide online dot
                            offlineDot.style.display = 'block';  // Show offline dot
                        }
                    });
                } catch (error) {
                    console.error('Error updating active status:', error);
                }
            }
            async function createUserInFirestore(user) {
                const time = Date.now().toString();
                const chatUser = {
                    id: user.uid,
                    name: currentUserUsername,
                    email: user.email,
                    about: "Hey, I'm using We Chat!",
                    image: user.photoURL || '',
                    createdAt: time,
                    is_online: true,
                    lastActive: time,
                    role: `{{ Auth::user()->member }}`,
                };

                try {
                    await setDoc(doc(usersCollection, user.uid), chatUser);
                    console.log('User created in Firestore:', chatUser);
                } catch (error) {
                    console.error('Error creating user in Firestore:', error);
                }
            }
            async function updateFirebaseToken() {
                if (auth.currentUser) {
                    try {
                        const token = await getToken(messaging, {vapidKey: 'BIKdl-B84phF636aS0ucw5k-KoGPnivJW4L_a9GNf7gyrWBZt--O9KcEzvsLl3h-3_Ld0rT8YFTsuupknvguW9s'});
                        if (token) {
                            await setDoc(doc(database, 'users', auth.currentUser.uid), {push_token: token}, {merge: true});
                        }
                    } catch (error) {
                        console.error('Error getting token or updating Firestore:', error);
                    }
                }
            }
            let conversationID = 0;
            let id = $(this).data('id');
            let emailData = $(this).data('email');
            let role = $(this).data('role');
            let img = $(this).data('img');
            let nameDoc = $(this).data('name');

            let isShowOpenWidget;
            isShowOpenWidget = true;

            let chatUserId;
            chatUserId = $(this).data('id');
            let emailUser;
            emailUser = $(this).data('email');

            removeSpanBadges(this);

            var childOffset = $(this).offset();
            var parentOffset = $(this).parent().parent().offset();
            var childTop = childOffset.top - parentOffset.top;
            var clone = $(this).find('img').eq(0).clone();
            var top = childTop + 12 + "px";


            setTimeout(function () {
                $("#profile p").addClass("animate");
                $("#profile").addClass("animate");
            }, 10);
            setTimeout(function () {
                $("#chat-messages").addClass("animate");
            }, 10);

            $("#profile p").html(nameDoc);
            $("#profile span").html(emailData);
            $("#chatview-image").attr('src', img);

            $(".message").not(".right").find("img").attr("src", $(clone).attr("src"));
            let parent = $(this).parent();
            parent.hide();
            $('#chat-widget-navbar').hide();
            $('#myTabContent').hide();
            $('#chatview').show();

            $('#close').unbind("click").click(function () {
                isShowOpenWidget = false;

                $("#chat-messages, #profile, #profile p").removeClass("animate");

                setTimeout(function () {
                    $('#chatview').hide();
                    parent.show();
                    $('#myTabContent').show();
                    $('#chat-widget-navbar').show();
                }, 10);
            });

            conversationID = getConversationID(id);

            const messagesCollectionRef = collection(database, `chats/${conversationID}/messages`);

            let html = ``;

            const unsubscribe = onSnapshot(messagesCollectionRef, (querySnapshot) => {
                let list_message = [];

                querySnapshot.forEach((doc) => {
                    list_message.push(doc.data());
                });

                renderMessage(list_message, html);

            }, (error) => {
                console.error("Error getting: ", error);
            });

            renderLayOutChat(emailData, id);

            let user = {
                role: role,
                id: id
            };

            initialChatRoom(user);

            async function initialChatRoom(user) {
                if (!user || !user.role || !user.id) {
                    console.error('User object is not defined or missing properties:', user);
                    return;
                }

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
                            `${current_user.uid}_${myChannelType}`,
                            `${user.id}_${myChannelType}`
                        ]
                    };
                    await createChatRoom(user, chatRoomInfo);
                }
            }
            async function createChatRoom(chatUser, chatRoom) {
                console.log(chatUser);
                try {
                    const chatMessageCollection = collection(database, 'chats');
                    const chatDocRef = doc(chatMessageCollection, getConversationID(chatUser.id));
                    await setDoc(chatDocRef, chatRoom, {merge: true});
                    console.log("Chat room created successfully.");
                } catch (error) {
                    console.error("Error creating chat room:", error);
                }
            }
            String.prototype.hashCode = function () {
                let hash = 0;
                if (this.length === 0) return hash;
                for (let i = 0; i < this.length; i++) {
                    let chr = this.charCodeAt(i);
                    hash = ((hash << 5) - hash) + chr;
                    hash |= 0;
                }
                return hash;
            };

            function getConversationID(userUid) {
                if (!current_user) {
                    console.error('Current user is not set');
                    return null;
                }

                let id = current_user.uid;
                let hash_value;

                if (id <= userUid) {
                    hash_value = `${id}_${userUid}`;
                } else {
                    hash_value = `${userUid}_${id}`;
                }
                return hash_value;
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
            function renderMessage(list_message, html) {
                $('#chat-messages').html('');
                if (list_message.length > 0) {
                    let messageIndex = 0;

                    function renderNextMessage() {
                        if (messageIndex >= list_message.length) {
                            let chatMessages = document.getElementById('chat-messages');
                            chatMessages.scrollTop = chatMessages.scrollHeight;
                            return;
                        }

                        let message = list_message[messageIndex];
                        let time = formatDate(message.sent);

                        if (message.type == 'prescription') {
                            // Search cart
                            let url = window.Laravel.url_1;
                            url = url.replace('REPLACE_ID', message.msg);
                            let accessToken = `Bearer ` + token;
                            let headers = {
                                "Authorization": accessToken
                            };
                            $.ajax({
                                url: url,
                                type: 'GET',
                                dataType: 'json',
                                headers: headers,
                                success: function (response) {
                                    if (response.error == 0 && response.data) {
                                        html = `<a><div class="mb-3 box-order-chat">`;
                                        response.data.forEach(item => {
                                            html += `<div class="content-order-item mb-2">
                                    <div class="d-flex ">
                                        <p class="title-name">Tên thuốc: </p>
                                        <p class="content-order-chat">${item.product_medicine.name}</p>
                                    </div>
                                    <div class="d-flex ">
                                        <p class="title-name">Số lượng: </p>
                                        <p class="content-order-chat">${item.quantity}</p>
                                    </div>
                                    <div class="d-flex ">
                                        <p class="title-name">Sử dụng: </p>
                                        <p class="content-order-chat">${item.note}</p>
                                    </div>
                                    <div class="d-flex ">
                                        <p class="title-name">Số ngày sử dụng: </p>
                                        <p class="content-order-chat">${item.treatment_days}</p>
                                    </div>
                                </div>`;
                                        });

                                        if (response.data[0].status == 'COMPLETE') {
                                            html += `<div class="d-flex justify-content-end">
                                    <a class="ml-2" type="button" href="${window.Laravel.url_2}${response.data[0].prescription_id}">
                                        <button class="btn btn-2 btn-sep icon-cart">Mua lại</button>
                                    </a>
                                </div>`;
                                        } else {
                                            html += `<div class="d-flex justify-content-end">
                                    <a href="${window.Laravel.url_3}${response.data[0].prescription_id}" class="btn btn-2 btn-sep icon-cart addToCartButton">Mua thuốc</a>
                                </div>`;
                                        }

                                        html += `</div></a>`;

                                        $('#chat-messages').append(html);
                                    }
                                    messageIndex++;
                                    renderNextMessage();
                                },
                                error: function (xhr, status, error) {
                                    console.error(error);
                                    messageIndex++;
                                    renderNextMessage();
                                }
                            });
                        }else if (message.type == 'file'){
                            if (message.fromId === current_user.uid) {
                                html = `<div class="message right">
                        <div class="msg-info">
                        </div>
                        <div class="bubble">
                            <a href="${message.fileUrl}" style="color: white"><i class="fa-solid fa-paperclip mr-1"></i> ${message.fileName}</a>
                            <div class="corner"></div>
                        </div>
                    </div>`;
                            } else {
                                html = `<div class="message">
                        <div class="msg-info">
                        </div>
                        <div class="bubble">
                            <a href="${message.fileUrl}"> <i class="fa-solid fa-paperclip mr-1"></i> ${message.fileName}</a>
                            <div class="corner"></div>
                        </div>
                    </div>`;
                            }
                            $('#chat-messages').append(html);

                            messageIndex++;
                            renderNextMessage();
                        }
                        else if (message.type == 'image'){
                            if (message.fromId === current_user.uid) {
                                html = `<div class="message right">
                        <div class="msg-info">
                        </div>
                        <div class="bubble" style="background-color: white">
                            <img src="${message.fileUrl}" class="image-sent" alt="${message.fileName}"/>
                            <div class="corner"></div>
                        </div>
                    </div>`;
                            } else {
                                html = `<div class="message">
                        <div class="msg-info">
                        </div>
                        <div class="bubble" style="background-color: white">
                            <img src="${message.fileUrl}" class="image-sent" alt="${message.fileName}"/>
                            <div class="corner"></div>
                        </div>
                    </div>`;
                            }
                            $('#chat-messages').append(html);

                            messageIndex++;
                            renderNextMessage();
                        }
                        else {
                            if (message.fromId === current_user.uid) {
                                html = `<div class="message right">
                        <div class="msg-info">
                        </div>
                        <div class="bubble">
                            ${message.msg}
                            <div class="corner"></div>
                        </div>
                    </div>`;
                            } else {
                                html = `<div class="message">
                        <div class="msg-info">
                        </div>
                        <div class="bubble">
                            ${message.msg}
                            <div class="corner"></div>
                        </div>
                    </div>`;
                            }
                            $('#chat-messages').append(html);

                            messageIndex++;
                            renderNextMessage();
                        }
                    }

                    renderNextMessage();
                }
            }
            function renderLayOutChat(email, id) {
                let btn_message = $('.msger-send-btn');
                btn_message.data('to_user', id);
                btn_message.data('to_email', email);
                $('#msger-input').val('');
            }
            function removeSpanBadges(divElement) {
                $(divElement).find('span.badge').html('');

                let countUnseen = $(divElement).data('msg-unseen');

                let totalMessageUnseen ;
                totalMessageUnseen -= countUnseen;

                if (totalMessageUnseen <= 0) {
                    $('#totalMsgUnseen').html('');
                } else {
                    $('#totalMsgUnseen').html(totalMessageUnseen);
                }
            }
            $(document).ready(function() {
                $('.file-send-btn').click(function() {
                    $('#file-input').click();
                });
                // File input change handler
                $('#file-input').change(function(e) {
                    var file = e.target.files[0];

                    if (!file) {
                        return;
                    }

                    var fileName = file.name;
                    var fileType = file.type;

                    // Display file name in input box
                    $('#msger-input').val(fileName);

                    if (fileType.startsWith('image/')) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('#image-preview').attr('src', e.target.result).show();
                        };
                        reader.readAsDataURL(file);
                    } else {
                        $('#image-preview').hide();
                    }
                });

                // Send button click handler
                $('.msger-send-btn').click(function () {
                    let file = $('#file-input')[0].files[0];
                    let toUser = $(this).data('to_user');
                    let to_email = $(this).data('to_email');

                    if (file) {
                        // Determine file extension
                        let ext = file.name.split('.').pop();
                        sendMessage(toUser, to_email, file, file.type.startsWith('image/') ? 'image' : 'file', ext);
                    } else {
                        let msg = $('#msger-input').val();
                        sendMessage(toUser, to_email, msg, 'text');
                    }

                    $('#msger-input').val('');
                    $('#file-input').val('');
                    $('#image-preview').hide();
                });

                async function uploadFile(file, ext, chatUserID) {
                    // Create a reference for the new file at Firebase Storage
                    const storageRef = ref(storage, `images/${getConversationID(chatUserID)}/${Date.now()}.${ext}`);

                    try {
                        // Upload the file to the specified reference
                        const snapshot = await uploadBytes(storageRef, file);

                        // After upload, retrieve the download URL
                        return await getDownloadURL(snapshot.ref);
                    } catch (error) {
                        console.error('Failed to upload file:', error);
                        return null; // Handle the error appropriately
                    }
                }
                async function sendMessage(chatUserID, to_email, content, type, ext = null) {
                    const time = Date.now().toString();
                    const receiverId = chatUserID;
                    const message = {
                        toId: receiverId,
                        read: '',
                        type: type,
                        fromId: current_user.uid,
                        readUsers: {[current_user.uid]: true, [receiverId]: false},
                        sent: time
                    };

                    if (type === 'text' || type === 'prescription') {
                        message.msg = content;
                    } else {
                        message.fileUrl = await uploadFile(content, ext, chatUserID);
                        message.fileName = content.name;
                    }

                    let conversationID = getConversationID(chatUserID);
                    const ref = collection(database, `chats/${conversationID}/messages/`);

                    try {
                        await setDoc(doc(ref, time), message);
                        await saveMessage(currentUserEmail, to_email, message);
                        console.log('Message sent successfully');
                        // await pushNotification(to_email, type === 'text' ? content : content.name);
                        // await updateLastMessage(chatUserID, message);

                    } catch (error) {
                        console.error('Error sending message:', error);
                    }
                }
                async function pushNotification(to_email, msg) {
                    const notification = {
                        "title": currentUserUsername,
                        "body": msg,
                        "android_channel_id": "chats"
                    };

                    const data = {
                        email: to_email,
                        data: notification,
                        notification: notification
                    };
                    const headers = {
                        'Authorization': `Bearer ${token}`
                    };
                    let sendNotiUrl = window.Laravel.url_4
                    await $.ajax({
                        url: sendNotiUrl,
                        method: 'POST',
                        data: data,
                        headers: headers,
                        success: function (response) {
                            console.log(response)
                        },
                        error: function (error) {
                            console.log(error.responseJSON.message);
                        }
                    });
                }
                async function saveMessage(from_email, to_email, message) {
                    let saveMessageUrl = window.Laravel.url_5

                    const data = {
                        from_user_email: from_email,
                        to_user_email: to_email,
                        content: message.msg
                    };

                    const headers = {
                        'Authorization': `Bearer ${token}`
                    };

                    await $.ajax({
                        url: saveMessageUrl,
                        method: 'POST',
                        data: data,
                        headers: headers,
                        success: function (response) {
                            console.log(response)
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }
                function _getTypeFromString(name) {
                    return name;
                }
                async function updateLastMessage(chatUserID, lastMessage) {
                    const callType = _getTypeFromString(lastMessage.msg);
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
                }
            });
        });
    }
    function hideTabActive() {
        let tabActive = document.querySelectorAll('.tab-pane.fade');
        tabActive.forEach(function (tab) {
            tab.classList.remove('active');
            tab.classList.remove('show');
        });
    }
    function loadDisplayMessage(id) {
        var friendDivs = document.querySelectorAll('.user_connect');

        friendDivs.forEach(function (div) {
            // Lấy giá trị data-id của từng div
            var dataId = div.getAttribute('data-id');

            // Kiểm tra xem data-id có bằng currentId hay không
            if (dataId === id) {
                div.click();
            }
        });
    }
    function showOrHiddenChat() {
        document.getElementById('chat-circle').click();
    }
});
