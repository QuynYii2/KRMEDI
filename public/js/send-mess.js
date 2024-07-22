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
        function getDoctorByEmailOnline(email,user_id) {
            const q = query(
                collection(database, 'users'), where('email', '==', email));
            return getDocs(q)
                .then((querySnapshot) => {
                    querySnapshot.forEach((doc) => {
                        if (doc.data()){
                            loadDisplayMessage(doc.data(),user_id);
                            showOrHiddenChat();
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
                const user_id = $(this).data('id');
                getDoctorByEmailOnline(email,user_id);
            });
        });
        document.querySelector('.doctor_mess').addEventListener('click', function(event) {
            const email = $(this).data('mail');
            const user_id = $(this).data('id');
            getDoctorByEmailOnline(email,user_id);
        });

    }

    function loadDisplayMessage(data,user_id) {
        let id = data.id;

        let email = data.email;
        let role = data.role;
        let img = data.image;
        let is_online = data.is_online;
        $('#user_id_2').val(user_id);
        let isShowOpenWidget = true;

        let chatUserId = data.id;
        let emailUser = data.email;

        removeSpanBadges(this);
        var clone = $(this).find('img').eq(0).clone();


        setTimeout(function () {
            $("#profile p").addClass("animate");
            $("#profile").addClass("animate");
        }, 10);
        setTimeout(function () {
            $("#chat-messages").addClass("animate");
        }, 10);

        $("#profile p").html(data.name);
        $("#profile span").html(email);
        $("#chatview-image").attr('src', img);

        const onlineDot = document.querySelector(`#online-div`);
        const offlineDot = document.querySelector(`#offline-div`);

        if (is_online) {
            onlineDot.style.display = 'block';
            offlineDot.style.display = 'none';
        } else {
            onlineDot.style.display = 'none';
            offlineDot.style.display = 'block';
        }

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
                $('#friends-connected').css('display','block');
                $('#friends-all-online').css('display','block');
            }, 10);
        });

        let conversationID = getConversationID(id);

        const messagesCollectionRef = collection(database, `chats/${conversationID}/messages`);

        let htmls = ``;
        let timeout;
        let lastSnapshot = [];
        const unsubscribe = onSnapshot(messagesCollectionRef, (querySnapshot) => {
            let list_message = [];
            $('#chat-messages').html('');

            querySnapshot.forEach((doc) => {
                list_message.push(doc.data());
            });

            function scheduleRender(list_message, htmls) {
                if (timeout) {
                    clearTimeout(timeout);
                }

                timeout = setTimeout(() => {
                    if (JSON.stringify(list_message) !== JSON.stringify(lastSnapshot)) {
                        renderMessage(list_message, htmls);
                        lastSnapshot = list_message;
                    }
                }, 2000);
            }

            scheduleRender(list_message, htmls);

        }, (error) => {
            console.error("Error getting: ", error);
        });

        renderLayOutChat(email, id);

        let user = {
            role: role,
            id: id
        };

        initialChatRoom(user);

        markAllMessagesAsRead(id, conversationID);
    }
    function showOrHiddenChat() {
        const chatCircle = document.getElementById('chat-circle');
        if (chatCircle.style.display !== 'none') {
            chatCircle.click();
        }
    }

    async function markAllMessagesAsRead(userId, conversationId) {
        try {
            let current_users = JSON.parse(localStorage.getItem('current_users'));
            const roomRef = doc(collection(database, "chats"), conversationId);
            await updateDoc(roomRef, {
                [`unreadMessageCount.${current_users.uid}`]: 0
            });

            const messagesCollectionRef = collection(roomRef, 'messages');
            const querySnapshot = await getDocs(query(messagesCollectionRef, where(`readUsers.${current_users.uid}`, '==', false)));

            querySnapshot.forEach(async (doc) => {
                try {
                    const messageRef = doc.ref;
                    await setDoc(messageRef, {
                        readUsers: {
                            [current_users.uid]: true
                        }
                    }, { merge: true });
                    await updateUnreadMessageCount(userId,conversationId);
                } catch (error) {
                    console.error("Error marking message as read: ", error);
                }
            });
        } catch (error) {
            console.error("Error marking messages as read: ", error);
        }
    }

    async function updateUnreadMessageCount(userId,conversationId) {
        try {
            let current_users = JSON.parse(localStorage.getItem('current_users'));
            $('.' + userId).hide();
            const roomRef = doc(collection(database, "chats"), conversationId);
            await updateDoc(roomRef, {
                [`unreadMessageCount.${current_users.uid}`]: 0
            });
            const messagesCollectionRef = collection(roomRef, 'messages');
            const querySnapshot = await getDocs(query(messagesCollectionRef, where(`readUsers.${current_users.uid}`, '==', false)));
            const unreadCount = querySnapshot.size;

            $('.noti_number').html(unreadCount > 0 ? unreadCount : '');
            $('.number_not_screen').html(unreadCount > 0 ? '(' + unreadCount + ')' : '');
        } catch (error) {
            console.error("Error updating unread message count: ", error);
        }
    }

    async function initialChatRoom(user) {
        let current_users = JSON.parse(localStorage.getItem('current_users'));
        const currentChatRoom = await getChatGroup(user);
        let myChannelType;
        let current_role = localStorage.getItem('current_role');

        if (current_role !== 'PHAMACISTS' &&
            current_role !== 'DOCTORS' &&
            current_role !== 'CLINICS' &&
            current_role !== 'HOSPITALS') {
            myChannelType = user.role;
        } else {
            myChannelType = current_role;
        }

        if (currentChatRoom === null) {
            const chatRoomInfo = {
                userIds: [current_users.uid, user.id],
                groupId: getConversationID(user.id),
                createdBy: current_users.uid,
                unreadMessageCount: {[current_users.uid]: 0, [user.id]: 0},
                createdAt: new Date().getTime().toString(),
                channelTypes: [
                    `${current_users.uid}_${myChannelType}`,
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

    function removeSpanBadges(divElement) {
        $(divElement).find('span.badge').html('');

        let countUnseen = $(divElement).data('msg-unseen');
        let totalMessageUnseen = 0;
        totalMessageUnseen -= countUnseen;

        if (totalMessageUnseen <= 0) {
            $('#totalMsgUnseen').html('');
        } else {
            $('#totalMsgUnseen').html(totalMessageUnseen);
        }
    }

    function getConsistentHashCode(s) {
        let hash = 0;
        for (let i = 0; i < s.length; i++) {
            let chr = s.charCodeAt(i);
            hash = ((hash << 5) - hash) + chr;
            hash |= 0;
        }
        return hash >>> 0;
    }

    function getConversationID(userUid) {
        let current_users = JSON.parse(localStorage.getItem('current_users'));
        let id = current_users.uid;

        let hash_value;

        if (getConsistentHashCode(id) <= getConsistentHashCode(userUid)) {
            hash_value = `${id}_${userUid}`;
        } else {
            hash_value = `${userUid}_${id}`;
        }
        return hash_value;
    }

    function renderLayOutChat(email, id) {
        let btn_message = $('.msger-send-btn');
        btn_message.data('to_user', id);
        btn_message.data('to_email', email);
        $('#msger-input').val('');
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
        let current_users = JSON.parse(localStorage.getItem('current_users'));
        $('#chat-messages').html('');
        if (list_message.length > 0) {
            let messageIndex = 0;
            renderNextMessage();
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
                    let url = "{{ route('api.backend.cart.search', ['prescription_id' => 'REPLACE_ID']) }}";
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
                                    <a class="ml-2" type="button" href="{{ route('user.checkout.reorder', ['prescription_id' => '']) }}${response.data[0].prescription_id}">
                                        <button class="btn btn-2 btn-sep icon-cart">Mua lại</button>
                                    </a>
                                </div>`;
                                } else {
                                    html += `<div class="d-flex justify-content-end">
                                    <a href="{{route('user.checkout.index', ['prescription_id' => '']) }}${response.data[0].prescription_id}" class="btn btn-2 btn-sep icon-cart addToCartButton">Mua thuốc</a>
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
                    if (message.fromId === current_users.uid) {
                        html = `<div class="message right">
                        <div class="msg-info">
                        </div>
                        <div class="bubble">
                            <a href="${message.fileUrl}" style="color: white" target="_blank"><i class="fa-solid fa-paperclip mr-1"></i> ${message.fileName}</a>
                            <div class="corner"></div>
                        </div>
                    </div>`;
                    } else {
                        html = `<div class="message">
                        <div class="msg-info">
                        </div>
                        <div class="bubble">
                            <a href="${message.fileUrl}" target="_blank"> <i class="fa-solid fa-paperclip mr-1"></i> ${message.fileName}</a>
                            <div class="corner"></div>
                        </div>
                    </div>`;
                    }
                    $('#chat-messages').append(html);

                    messageIndex++;
                    renderNextMessage();
                }
                else if (message.type == 'image'){
                    if (message.fromId === current_users.uid) {
                        html = `<div class="message right" style="max-height: 200px; height: inherit">
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
                    if (message.fromId === current_users.uid) {
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


        }
    }

    function formatDate(timestamp) {
        const date = new Date(parseInt(timestamp));

        const h = "0" + date.getHours();
        const m = "0" + date.getMinutes();

        return `${h.slice(-2)}:${m.slice(-2)}`;
    }

});
