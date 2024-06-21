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
                        if (doc.data()){
                            hideTabActive();
                            loadDisplayMessage(doc.data().id);
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
                getDoctorByEmailOnline(email);
            });
        });
        document.querySelector('.doctor_mess').addEventListener('click', function(event) {
            const email = $(this).data('mail');
            getDoctorByEmailOnline(email);
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
        const dataDoctor = JSON.parse(localStorage.getItem('data_doctor'));
        for (let i = 0; i < dataDoctor.length; i++) {
            const user = dataDoctor[i];
            if (user.id == id){
                let html_onlines = `<div class="friend user_connect" data-id="${user.id}" data-role="${user.role}" data-email="${user.email}" data-image="${user.image}" data-online="${user.is_online}">
                                                    <img src="${user.image}"/>
                                                    <p>
                                                        <strong class="max-1-line-title-widget-chat">${user.name}</strong>
                                                        <span>${user.name}</span>
                                                    </p>
                                                </div>`;
                $('#friendslist-all-online #friends-all-online').append(html_onlines);
                break;
            }
        }
        var friendDivs = document.querySelectorAll('.user_connect');

        friendDivs.forEach(function (div) {
            var dataId = div.getAttribute('data-id');
            if (dataId === id) {
                div.click();
            }
        });
    }
    function showOrHiddenChat() {
        document.getElementById('chat-circle').click();
    }
});
