// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyA4Ge5dtO15F8mmD5tPIK_V7QspM01qGoQ",
    authDomain: "puch-notification-d468e.firebaseapp.com",
    projectId: "puch-notification-d468e",
    storageBucket: "puch-notification-d468e.appspot.com",
    messagingSenderId: "778819694326",
    appId: "1:778819694326:web:4ad0f3bc62f96d9bc086d7",
    measurementId: "G-8JHSB8KZY2"


});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log("Message received.", payload);
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});