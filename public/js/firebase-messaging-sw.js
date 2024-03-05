importScripts('https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/10.8.0/firebase-messaging.js');

const firebaseConfig = {
    apiKey: "AIzaSyAW-1uaHUA8tAaA3IQD9ypNkbVzFji88bE",
    authDomain: "chat-firebase-de134.firebaseapp.com",
    projectId: "chat-firebase-de134",
    storageBucket: "chat-firebase-de134.appspot.com",
    messagingSenderId: "867778569957",
    appId: "1:867778569957:web:7f3a6b87d83cefd8e8d60c"
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();
