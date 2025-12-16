importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "AIzaSyBk55n64hvMv0C8IHlfKnqcAy5jXe4LBnU",
    projectId: "golden-b7fb0",
    messagingSenderId: "38557934447",
    appId: "1:38557934447:web:bf253c7b6904b4a9a83e9a"
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({ data: { title, body, icon } }) {
    return self.registration.showNotification(title, { body, icon });
});