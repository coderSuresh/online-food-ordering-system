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

let extraPath = "/"

passwordToggleBtn && passwordToggleBtn.forEach((btn, i) => {
    btn.addEventListener("click", () => {
        const attr = btn.getAttribute("src")
        // handle path
        attr.includes("../../images") ? extraPath = "/../" : extraPath = "/"
        // handle toggle
        attr.includes("ic_eye-off.svg") ? showPassword(i, extraPath) : hidePassword(i, extraPath)
    })
})

const showPassword = (i, extra_path) => {
    passwordToggleBtn && passwordToggleBtn[i].setAttribute("src", `..${extra_path}images/ic_eye.svg`)
    passwordInput && passwordInput[i].setAttribute("type", "text")
}

const hidePassword = (i, extra_path) => {
    passwordToggleBtn && passwordToggleBtn[i].setAttribute("src", `..${extra_path}images/ic_eye-off.svg`)
    passwordInput && passwordInput[i].setAttribute("type", "password")
}

// show error alert (for login / register)
const errorContainer = document.querySelectorAll(".error-container")

const showErrorAlert = () => {
    errorContainer && errorContainer.forEach((container) => {

        setTimeout(() => {
            container.classList.remove("active")
        }, 1500)

        container.classList.add("active")
    })
}

showErrorAlert()

// ================ authentication =======================

// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js";
import { getAuth, GoogleAuthProvider, signInWithPopup, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-auth.js";

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
google && google.addEventListener('click', (_e) => {

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
                if (user) {
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

// handle menu categories (client side validation)
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

// to toggle user logout dropdown
const userProfileIcon = document.querySelector(".user_profile_icon")
const userLogoutDropdown = document.querySelector(".logout-dropdown")

userProfileIcon && userProfileIcon.addEventListener("click", () => {
    userLogoutDropdown.classList.toggle("visible")
})

// go to top 
const goToTopBtn = document.querySelector(".go_top")

// show btn on scroll
window.onscroll = () => {
    goToTopBtn && (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) ? (goToTopBtn && (goToTopBtn.style.display = "block")) : (goToTopBtn && (goToTopBtn.style.display = "none"))
}

goToTopBtn && goToTopBtn.addEventListener("click", () => {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
})

// show alert message for modal form
function showAlert(msg, level) {
    const modalAlert = document.createElement("p")
    const body = document.querySelector("body")

    modalAlert.setAttribute("class", `error-container ${level} p_7-20`)

    // for animation
    setInterval(() => {
        modalAlert.classList.add("active")
    }, 100)

    setInterval(() => {
        modalAlert.classList.remove("active")
    }, 900);

    modalAlert.textContent = msg

    setTimeout(() => {
        body.removeChild(modalAlert)
    }, 1000)

    body.appendChild(modalAlert)
}

// details page increment or decrement quantity
const incrementBtn = document.querySelector(".details_quantity-btn-inc")
const decrementBtn = document.querySelector(".details_quantity-btn-dec")
const quantity = document.querySelector(".details_quantity")

incrementBtn && incrementBtn.addEventListener("click", () => {
    quantity.value = parseInt(quantity.value) + 1
    quantity.value = validateQuantity(quantity.value)
})

decrementBtn && decrementBtn.addEventListener("click", () => {
    quantity.value = parseInt(quantity.value) - 1
    quantity.value = validateQuantity(quantity.value)
})

quantity && quantity.addEventListener("change", () => {
    validateQuantity(quantity.value)
})

//validate quantity
function validateQuantity(val) {
    if (val < 1) {
        showAlert("Minimum order quantity is 1 item", "error")
        return parseInt(val = 1)
    } else return parseInt(val)
}

// for cart drop down
const cartIcon = document.querySelector(".cart")
const cartDropdown = document.querySelector(".cart_dropdown")

cartIcon && cartIcon.addEventListener("click", () => {
    cartDropdown.classList.toggle("visible")
})

const cartCountTop = document.querySelector(".cart_count-top")

function checkCartCount() {
    cartCountTop && (
        parseInt(cartCountTop.textContent) > 0 ? (cartCountTop.style.display = "block") : (cartCountTop.style.display = "none")
    )
}

function getData(backendAPI) {
    fetch(backendAPI)
        .then(response => response.json())
        .then(data => {
            cartCountTop && (cartCountTop.textContent = data.length)
            checkCartCount()
            cartDropdown && (cartDropdown.innerHTML = "")
            let totalPrice = 0;

            if (data.length >= 0) {

                data.forEach((item) => {
                    totalPrice += parseInt(item['food_price'])
                    const cartItem = createCartItemContainer(item['id'], item['food_name'], item['food_image'], item['food_price'], item['quantity'])
                    cartDropdown && cartDropdown.appendChild(cartItem)
                    const hr = document.createElement("hr")
                    cartDropdown && cartDropdown.appendChild(hr)
                })
                // for total price and checkout button
                const cartTotalContainer = document.createElement("div")
                cartTotalContainer.setAttribute("class", "flex items-center cart_total_checkout mt-20")

                const divCartTotal = document.createElement("p")
                divCartTotal.setAttribute("class", "cart_total")
                divCartTotal.textContent = "Total: Rs. " + totalPrice

                const btnCheckout = document.createElement("a")
                btnCheckout.setAttribute("class", "button border-curve checkout-btn")
                btnCheckout.textContent = "Checkout"

                cartTotalContainer.appendChild(divCartTotal)
                cartTotalContainer.appendChild(btnCheckout)

                cartDropdown && cartDropdown.appendChild(cartTotalContainer)

                getElem()
            } else {
                const cartEmpty = document.createElement("p")
                cartEmpty.setAttribute("class", "cart_empty")
                cartEmpty.textContent = "Cart is empty"
                cartDropdown && cartDropdown.appendChild(cartEmpty)
            }
        })
        .catch((e) => showAlert("Something went wrong " + e, "error"))
}

function updateCartContent() {
    getData('./backend/get-cart-items.php')
}

cartCountTop && updateCartContent()

function getElem() {
    // increment or decrement quantity in cart and update price
    const cartIncrementBtn = document.querySelectorAll(".cart_inc")
    const cartDecrementBtn = document.querySelectorAll(".cart_dec")
    const cartQuantity = document.querySelectorAll(".cart_qty")
    const cartItemPrice = document.querySelectorAll(".cart_price")
    const cartTotal = document.querySelector(".cart_total")
    const hiddenPrice = document.querySelectorAll(".cart_hidden-price")

    // initially display correct price
    cartItemPrice && cartItemPrice.forEach((price, i) => {
        price.textContent = "Rs. " + parseInt(hiddenPrice[i].textContent) * parseInt(cartQuantity[i].value)
    })

    // calculate total price
    function calculateCartTotal() {
        let total = 0
        cartItemPrice && cartItemPrice.forEach((price) => {
            total += parseInt(price.textContent.split("Rs. ")[1])
        })

        cartTotal && (cartTotal.textContent = "Total: Rs. " + total)
    }

    calculateCartTotal()

    cartIncrementBtn && cartIncrementBtn.forEach((btn, i) => {
        const price = parseInt(hiddenPrice[i].textContent)
        btn.addEventListener("click", () => {
            cartQuantity[i].value = parseInt(cartQuantity[i].value) + 1
            cartItemPrice[i].textContent = "Rs. " + parseInt(price) * parseInt(cartQuantity[i].value)
            calculateCartTotal()
        })
    })

    cartDecrementBtn && cartDecrementBtn.forEach((btn, i) => {
        const price = parseInt(hiddenPrice[i].textContent)
        btn.addEventListener("click", () => {
            cartQuantity[i].value = parseInt(cartQuantity[i].value) - 1
            cartQuantity[i].value = validateQuantity(cartQuantity[i].value)
            cartItemPrice[i].textContent = "Rs. " + parseInt(price) * parseInt(cartQuantity[i].value)
            calculateCartTotal()
        })
    })

    // remove from cart
    const btnRemoveFromCart = document.querySelectorAll(".btn_remove-from-cart")
    const cartContentForm = document.querySelectorAll(".cart_content-form")

    btnRemoveFromCart && btnRemoveFromCart.forEach((btn, i) => {
        btn.addEventListener("click", (e) => {
            e.preventDefault()
            const formData = new FormData(cartContentForm[i])
            submitForm(formData, './backend/remove-from-cart.php')
        })
    })
}

// hide dropdown on click outside
window.addEventListener("click", (e) => {
    if (!e.target.closest(".cart_dropdown") && !e.target.closest(".cart")) {
        cartDropdown && cartDropdown.classList.remove("visible")
    }
    if (!e.target.closest(".logout-dropdown") && !e.target.closest(".user_profile_icon")) {
        userLogoutDropdown && userLogoutDropdown.classList.remove("visible")
    }
})

// add to cart
const formFoodCard = document.querySelectorAll(".form_food-card")
const btnAddToCart = document.querySelectorAll(".btn_add-to-cart")

btnAddToCart && btnAddToCart.forEach((btn, i) => {

    btn.addEventListener("click", (e) => {
        e.preventDefault()
        const formData = new FormData(formFoodCard[i])
        quantity && formData.append("quantity", quantity.value)
        submitForm(formData, './backend/add-to-cart.php')
    })
})

function submitForm(formData, backendAPI) {
    fetch(backendAPI, {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data['status'] == "success") {
                showAlert(data['message'], "success")
                updateCartContent()
            } else {
                showAlert(data['message'], "error")
            }
        })
        .catch((e) => showAlert("Something went wrong " + e, "error"))
}

// create cart item container
function createCartItemContainer(id, name, img, price, quantity) {
    const divCartContent = document.createElement("div")
    divCartContent.setAttribute("class", "cart_content flex items-center")

    const cartImg = document.createElement("img")
    cartImg.setAttribute("class", "cart_img")
    cartImg.setAttribute("src", "./uploads/foods/" + img)
    divCartContent.appendChild(cartImg)

    const div1 = document.createElement("div")
    div1.setAttribute("class", "flex items-center")
    divCartContent.appendChild(div1)

    const div2 = document.createElement("div")
    div1.appendChild(div2)

    const cartTitle = document.createElement("h3")
    cartTitle.setAttribute("class", "title cart_title")
    cartTitle.textContent = name
    div2.appendChild(cartTitle)

    const divCartQty = document.createElement("div")
    divCartQty.setAttribute("class", "qty_container flex items-center")
    div2.appendChild(divCartQty)

    const divCartQtyBtnInc = document.createElement("button")
    divCartQtyBtnInc.setAttribute("class", "cart_item-btn no_outline shadow cart_inc")
    divCartQty.appendChild(divCartQtyBtnInc)

    const cartItemIconPlus = document.createElement("img")
    cartItemIconPlus.setAttribute("class", "cart_item-icon")
    cartItemIconPlus.setAttribute("src", "./images/ic_add.svg")
    divCartQtyBtnInc.appendChild(cartItemIconPlus)

    const cartQuantityContainer = document.createElement("p")
    cartQuantityContainer.setAttribute("class", "qty")
    cartQuantityContainer.textContent = "Qty: "
    divCartQty.appendChild(cartQuantityContainer)

    const cartQuantity = document.createElement("input")
    cartQuantity.setAttribute("class", "cart_qty no_outline")
    cartQuantity.setAttribute("type", "text")
    cartQuantity.setAttribute("value", quantity)
    cartQuantityContainer.appendChild(cartQuantity)

    const divCartQtyBtnDec = document.createElement("button")
    divCartQtyBtnDec.setAttribute("class", "cart_item-btn no_outline shadow cart_dec")
    divCartQty.appendChild(divCartQtyBtnDec)

    const cartItemIconMinus = document.createElement("img")
    cartItemIconMinus.setAttribute("class", "cart_item-icon")
    cartItemIconMinus.setAttribute("src", "./images/ic_remove.svg")
    divCartQtyBtnDec.appendChild(cartItemIconMinus)

    const cartHiddenPrice = document.createElement("p")
    cartHiddenPrice.setAttribute("class", "cart_hidden-price")
    cartHiddenPrice.textContent = price
    div1.appendChild(cartHiddenPrice)

    const cartItemPrice = document.createElement("p")
    cartItemPrice.setAttribute("class", "cart_price ml-35")
    cartItemPrice.textContent = "Rs. " + (parseInt(price) * parseInt(quantity))
    div1.appendChild(cartItemPrice)

    const cartContentForm = document.createElement("form")
    cartContentForm.setAttribute("class", "cart_content-form")
    cartContentForm.setAttribute("method", "POST")
    divCartContent.appendChild(cartContentForm)

    const cartHiddenId = document.createElement("input")
    cartHiddenId.setAttribute("name", "id")
    cartHiddenId.setAttribute("type", "hidden")
    cartHiddenId.setAttribute("value", id)
    cartContentForm.appendChild(cartHiddenId)

    const cartSubmitBtn = document.createElement("button")
    cartSubmitBtn.setAttribute("class", "no_bg no_outline ml-35 btn_remove-from-cart")
    cartSubmitBtn.setAttribute("type", "submit")
    cartContentForm.appendChild(cartSubmitBtn)

    const cartItemIconRemove = document.createElement("img")
    cartItemIconRemove.setAttribute("alt", "cart_item-icon")
    cartItemIconRemove.setAttribute("src", "./images/ic_cross.svg")
    cartSubmitBtn.appendChild(cartItemIconRemove)

    return divCartContent
}
