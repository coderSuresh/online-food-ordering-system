import { initializeApp } from 'https://www.gstatic.com/firebasejs/9.17.1/firebase-app.js';
import {
  getMessaging,
  getToken,
} from "https://www.gstatic.com/firebasejs/9.17.1/firebase-messaging.js";

const firebaseConfig = {
  apiKey: "AIzaSyAgWmm70VliKQ68Cod0MgzmsncJ2R8h_jI",
  authDomain: "annular-magnet-374810.firebaseapp.com",
  projectId: "annular-magnet-374810",
  storageBucket: "annular-magnet-374810.appspot.com",
  messagingSenderId: "360310508668",
  appId: "1:360310508668:web:0bf9048fd87a2741338df9",
};
const app = initializeApp(firebaseConfig);
const checkout = document.querySelector(".place_order");
console.log("hello");
console.log("clickho ja");
checkout &&
  checkout.addEventListener("click", (e) => {
    e.preventDefault();
    console.log("hello");
    const messaging = getMessaging(app);
    getToken(messaging, {
      vapidKey:
        "BNOZSqkmFSqdPe6xdQNnsI2nu6gamgXCIw-IIhklyK2sXu-ckHCWggjVCl94_OlnPU1wRjJpXExy1lW38xiGNA8",
    })
      .then((currentToken) => {
        if (currentToken) {
          // Send the token to your server and update the UI if necessary
          alert("hello");
          console.log(currentToken);

          // ...
        } else {
          // Show permission request UI
          console.log(
            "No registration token available. Request permission to generate one."
          );
          // ...
        }
      })
      .catch((err) => {
        console.log("An error occurred while retrieving token. ", err);
        // ...
      });

    // function requestPermission() {
    //     console.log("Requesting permission...");
    //     Notification.requestPermission().then((permission) => {
    //         if (permission === "granted") {
    //             console.log("Notification permission granted.");

    //         }
    //     });
    // }
  });
