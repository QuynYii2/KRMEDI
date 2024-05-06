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
const app = initializeApp(firebaseConfig);
const database = getFirestore(app);

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