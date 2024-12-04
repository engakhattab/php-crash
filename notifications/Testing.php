<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Hello</h1>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
<script type="module">
    // Import the functions you need from the SDKs you need
    import {
        initializeApp
    } from "https://www.gstatic.com/firebasejs/11.0.2/firebase-app.js";
    import {
        getAnalytics
    } from "https://www.gstatic.com/firebasejs/11.0.2/firebase-analytics.js";
    import {
        getMessaging,
        getToken
    } from "https://www.gstatic.com/firebasejs/11.0.2/firebase-messaging.js";
    

    // TODO: Add SDKs for Firebase products that you want to use
    // https://firebase.google.com/docs/web/setup#available-libraries

    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    const firebaseConfig = {
    apiKey: "AIzaSyDmxEfuU33JTdDE_-F0bFrmUD3_X5qOMCY",
    authDomain: "ems3-4b249.firebaseapp.com",
    projectId: "ems3-4b249",
    storageBucket: "ems3-4b249.firebasestorage.app",
    messagingSenderId: "36748961491",
    appId: "1:36748961491:web:5bddb5bcf76908b1549626"
  };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const messaging = getMessaging(app);

    navigator.serviceWorker.register("sw.js").then(registration => {
        getToken(messaging, {
            serviceWorkerRegistration: registration,
            vapidKey: 'BOSas7dfqv1EW57BCnsZ7htNj4bO55NfTIlYXBsr0-yfNd6Gqfw8yW-uEUJmKNGXKFZhjEJarUh905HTABP3_Zc'
        }).then((currentToken) => {
            if (currentToken) {
                console.log("Token is: "+currentToken);
                // Send the token to your server and update the UI if necessary
                // ...
            } else {
                // Show permission request UI
                console.log('No registration token available. Request permission to generate one.');
                // ...
            }
        }).catch((err) => {
            console.log('An error occurred while retrieving token. ', err);
            // ...
        });
    })
</script>
</body>
</html>
