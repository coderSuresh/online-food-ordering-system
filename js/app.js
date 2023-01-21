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

// ================ authentication =======================

// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js";
import { getAuth, GoogleAuthProvider, signInWithPopup, FacebookAuthProvider, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-auth.js";

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
const google_auth = getAuth(app);
const googel_provider = new GoogleAuthProvider(app);

const google = document.querySelector(".google")
google && google.addEventListener('click', (e) => {

    signInWithPopup(google_auth, googel_provider)
        .then((result) => {
            // This gives you a Google Access Token. You can use it to access the Google API.
            const credential = GoogleAuthProvider.credentialFromResult(result);
            const token = credential.accessToken;
            // The signed-in user info.
            const user = result.user;

            alert(user.displayName);
            // console.log(window.location)
            // window.location.assign("../../index.php ")
            const auth = getAuth();
            onAuthStateChanged(auth, (user) => {
                if (user !== null) {
                    document.cookie = "user=" + user
                    user.providerData.forEach((profile) => {
                        let sign_in_provider = profile.providerId;
                        document.cookie = "sign_in_provider=" + sign_in_provider;
                        let profile_name = profile.displayName;
                        document.cookie = "profile_name=" + profile_name;
                        let email = profile.email;
                        document.cookie = "email=" + email;
                        let image = profile.photoURL;
                        document.cookie = "image=" + image;
                        location.reload();//
                    });
                }
                else {
                    alert("user not found");
                }
            });
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

const facebook_provider = new FacebookAuthProvider(app);
const facebook_auth = getAuth(app);
const facebook = document.querySelector(".facebook")

facebook && facebook.addEventListener('click', (e) => {
    signInWithPopup(facebook_auth, facebook_provider)
        .then((result) => {
            // The signed-in user info.
            const user = result.user;

            // This gives you a Facebook Access Token. You can use it to access the Facebook API.
            const credential = FacebookAuthProvider.credentialFromResult(result);
            const accessToken = credential.accessToken;
            alert(user.displayName);
            // ...

            const auth = getAuth();
            onAuthStateChanged(auth, (user) => {
                if (user !== null) {
                    document.cookie = "user=" + user
                    user.providerData.forEach((profile) => {
                        let sign_in_provider = profile.providerId;
                        document.cookie = "sign_in_provider=" + sign_in_provider;
                        let profile_name = profile.displayName;
                        document.cookie = "profile_name=" + profile_name;
                        let email = profile.email;
                        document.cookie = "email=" + email;
                        let image = profile.photoURL;
                        document.cookie = "image=" + image;
                        location.reload();
                        window.location("../index.php");
                    });
                }
                else {
                    alert("user not found");
                }
            });
        })
        .catch((error) => {
            // Handle Errors here.
            const errorCode = error.code;
            const errorMessage = error.message;
            // The email of the user's account used.
            const email = error.customData.email;
            // The AuthCredential type that was used.
            const credential = FacebookAuthProvider.credentialFromError(error);
            alert(errorMessage);
            // ...
        });
});

// handle menu categories (client side validation)
// TODO: replace this with server side validation
const categories = document.querySelectorAll(".food_category")
const categoryHolder = document.querySelector(".category_container")
const categoryHolderTitle = document.querySelector(".food_category-title")
const btnToggleCategories = document.querySelector(".toggle_categories")

let isFull = false

toggleCategories()

const checkCategoryState = () => {
    btnToggleCategories && btnToggleCategories.addEventListener("click", () => {
        isFull = !isFull
        toggleCategories()
    })
}

checkCategoryState()

function toggleCategories() {
    categories && categories.forEach((category, i) => {
        if (isFull) {
            categoryHolder.appendChild(category)
            categoryHolderTitle.textContent = "All Categories"
            btnToggleCategories.textContent = "View Less"
        }
        else {
            i >= 5 && categoryHolder.removeChild(category)
            categoryHolderTitle.textContent = "Top Categories"
            btnToggleCategories.textContent = "View all"
        }
    })
}

// display current year on footer
const year = document.querySelector(".footer_year")
year && (year.textContent = new Date().getFullYear())
