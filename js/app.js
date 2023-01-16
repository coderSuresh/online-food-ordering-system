const navBackBtn = document.querySelector(".nav__btn-back")

navBackBtn && (navBackBtn.style.display = "none")

if (history.length > 1 && navBackBtn !== null) {
    navBackBtn.style.display = "block"
    navBackBtn.addEventListener("click", () => {
        history.back()
    })
}

// toggle password icon
const passwordToggleBtn = document.querySelectorAll(".password_toggle_btn")
const passwordInput = document.querySelectorAll(".password_input")

passwordToggleBtn && passwordToggleBtn.forEach((btn, i) => {
    btn.addEventListener("click", () => {
        btn.getAttribute("src") == "../../images/ic_eye-off.svg" ? showPassword(i) : hidePassword(i)
    })
})

const showPassword = (i) => {
    passwordToggleBtn && passwordToggleBtn[i].setAttribute("src", "../../images/ic_eye.svg")
    passwordInput && passwordInput[i].setAttribute("type", "text")
}

const hidePassword = (i) => {
    passwordToggleBtn && passwordToggleBtn[i].setAttribute("src", "../../images/ic_eye-off.svg")
    passwordInput && passwordInput[i].setAttribute("type", "password")
}

// show error alert (for login / register)
const errorContainer = document.querySelectorAll(".error-container")

const showErrorAlert = () => {

    errorContainer && errorContainer.forEach((container) => {

        setTimeout(() => {
            container.classList.remove("active")
        }, 3000)

        container.classList.add("active")
    })
}

showErrorAlert()

// ================ Google authentication =======================

// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js";
import { getAuth, GoogleAuthProvider, signInWithPopup } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-auth.js";

// Your web app's Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyAgWmm70VliKQ68Cod0MgzmsncJ2R8h_jI",
    authDomain: "annular-magnet-374810.firebaseapp.com",
    projectId: "annular-magnet-374810",
    storageBucket: "annular-magnet-374810.appspot.com",
    messagingSenderId: "360310508668",
    appId: "1:360310508668:web:0bf9048fd87a2741338df9"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const provider = new GoogleAuthProvider(app);

const google = document.querySelector(".google")
google.addEventListener('click', (e) => {

    signInWithPopup(auth, provider)
        .then((result) => {
            // This gives you a Google Access Token. You can use it to access the Google API.
            const credential = GoogleAuthProvider.credentialFromResult(result);
            const token = credential.accessToken;
            // The signed-in user info.
            const user = result.user;

            alert(user.displayName);
            // ...
        }).catch((error) => {
            // Handle Errors here.
            const errorCode = error.code;
            const errorMessage = error.message;
            // The email of the user's account used.
            const email = error.customData.email;
            // The AuthCredential type that was used.
            const credential = GoogleAuthProvider.credentialFromError(error);
            // ...
            alert(errorMessage);
        });
});
