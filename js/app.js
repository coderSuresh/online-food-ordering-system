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
    appId: "1:360310508668:web:0bf9048fd87a2741338df9",
    measurementId: "G-FGTFE1F45W"
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
                        location.reload();
                        window.location.href =
                           "https://localhost/messy-code/customer_auth/google_auth.php";
                    });
                }
            });
        }).catch((error) => {
            // Handle Errors here.
            const errorCode = error.code;
            const errorMessage = error.message;
            // The email of the user's account used.
            const email = error.customData.email;
            // The AuthCredential type that was used.
            const credential = GoogleAuthProvider.credentialFromError(error);
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
    // document.body.scrollTop = 0; // For Safari
    // document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    window.scroll({ top: 0, left: 0, behavior: 'smooth' })
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
    }, 1400);

    modalAlert.textContent = msg

    setTimeout(() => {
        body.removeChild(modalAlert)
    }, 1500)

    body.appendChild(modalAlert)
}

// details page increment or decrement quantity
const incrementBtn = document.querySelector(".details_quantity-btn-inc")
const decrementBtn = document.querySelector(".details_quantity-btn-dec")
const quantity = document.querySelector(".details_quantity")
const price = document.querySelector(".details_price")
const detailsPrice = price && price.textContent.split("Rs. ")[1]

incrementBtn && incrementBtn.addEventListener("click", () => {
    quantity.value = parseInt(quantity.value) + 1
    quantity.value = validateQuantity(quantity.value)
    updateDetailsPrice()
})

decrementBtn && decrementBtn.addEventListener("click", () => {
    quantity.value = parseInt(quantity.value) - 1
    quantity.value = validateQuantity(quantity.value)
    updateDetailsPrice()
})

quantity && quantity.addEventListener("change", () => {
    quantity.value = validateQuantity(quantity.value)
    updateDetailsPrice()
})

function updateDetailsPrice() {
    price.textContent = `Rs. ${detailsPrice * quantity.value}`
    price.style.fontWeight = "bold"
}

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
                btnCheckout.setAttribute("href", "./checkout.php")
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
    const cartForm = document.querySelectorAll(".cart_content-form")

    // increment or decrement quantity in cart and update price
    cartIncrementBtn && cartIncrementBtn.forEach((btn, i) => {
        btn.addEventListener("click", () => {
            const formData = new FormData(cartForm[i])
            quantity && formData.append("quantity", parseInt(cartQuantity[i].value))
            submitForm(formData, "./backend/inc-cart-item-quantity.php")
            updateCartContent()
            calculateCartTotal()
        })
    })

    cartDecrementBtn && cartDecrementBtn.forEach((btn, i) => {
        btn.addEventListener("click", () => {
            const formData = new FormData(cartForm[i])
            quantity && formData.append("quantity", parseInt(cartQuantity[i].value))
            submitForm(formData, "./backend/dec-cart-item-quantity.php")
            updateCartContent()
            calculateCartTotal()
        })
    })

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

    // remove from cart
    const btnRemoveFromCart = document.querySelectorAll(".btn_remove-from-cart")
    const cartContentForm = document.querySelectorAll(".cart_content-form")

    btnRemoveFromCart && btnRemoveFromCart.forEach((btn, i) => {
        btn.addEventListener("click", (e) => {
            console.log("clicked")
            e.preventDefault()
            const formData = new FormData(cartContentForm[i])
            submitForm(formData, './backend/remove-from-cart.php')
        })
    })
}

// remove from checkout page
const btnRemoveFromCheckout = document.querySelectorAll(".btn_remove-from-checkout")
const checkoutContentForm = document.querySelectorAll(".checkout_content-form")

btnRemoveFromCheckout && btnRemoveFromCheckout.forEach((btn, i) => {
    btn.addEventListener("click", (e) => {
        e.preventDefault()
        const formData = new FormData(checkoutContentForm[i])
        const remove = confirm("Are you sure you want to remove this item from cart?")
        if (!remove) {
            e.preventDefault()
        } else {
            submitForm(formData, './backend/remove-from-cart.php')
            location.reload()
        }
    })
})

// hide dropdown on click outside
window.addEventListener("click", (e) => {
    if (!e.target.closest(".cart_dropdown") && !e.target.closest(".cart")) {
        cartDropdown && cartDropdown.classList.remove("visible")
    }
    if (!e.target.closest(".logout-dropdown") && !e.target.closest(".user_profile_icon") && !e.target.closest(".user_profile_icon_text") && !e.target.closest(".user_profile_icon")) {
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
            }
            else if (data['status'] == "hidden") {
                showAlert(data['message'], "hidden")
            }
            else {
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
    divCartQtyBtnInc.setAttribute("type", "button")
    divCartQtyBtnInc.setAttribute("name", "cart_inc")
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
    cartQuantity.disabled = true
    cartQuantityContainer.appendChild(cartQuantity)

    const divCartQtyBtnDec = document.createElement("button")
    divCartQtyBtnDec.setAttribute("class", "cart_item-btn no_outline shadow cart_dec")
    divCartQtyBtnInc.setAttribute("type", "button")
    divCartQtyBtnInc.setAttribute("name", "cart_dec")
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

// details page handle buy now btn
const btnBuyNow = document.querySelector(".btn_buy-now")
const buyQty = document.querySelector(".buy_qty")

btnBuyNow && btnBuyNow.addEventListener("click", (e) => {
    buyQty && (buyQty.value = quantity.value)
})

// =========================== for FAQ page =========================
const questions = document.querySelectorAll(".question");

questions && questions.forEach((question) => {
    question.addEventListener("click", () => {
        question.classList.toggle("open");
    });
});

// ==================== inc / dec from checkout page ==================
const checkoutInc = document.querySelectorAll(".checkout_inc")
const checkoutDec = document.querySelectorAll(".checkout_dec")
const checkoutItemForm = document.querySelectorAll(".checkout_item-form")

checkoutInc && checkoutInc.forEach((btn, i) => {
    btn.addEventListener("click", () => {
        checkoutItemForm[i].setAttribute("action", "./backend/inc-cart-item-quantity.php")
        checkoutItemForm[i].submit()
    })
})

checkoutDec && checkoutDec.forEach((btn, i) => {
    btn.addEventListener("click", () => {
        checkoutItemForm[i].setAttribute("action", "./backend/dec-cart-item-quantity.php")
        checkoutItemForm[i].submit()
    })
})

// ==================== inc / dec from buy page ==================
const buyInc = document.querySelector(".buy_inc")
const buyDec = document.querySelector(".buy_dec")
const buyPageQty = document.querySelector(".buy_page_qty")
const hiddenQuantity = document.querySelector(".hidden_quantity")
const buyPrice = document.querySelector(".buy_price")
const priceTotal = document.querySelector(".price_total")
const finalPriceWithoutVat = document.querySelector(".final_price_without_vat")
const vat = document.querySelector(".vat")
const finalPrice = document.querySelector(".final_price")

buyInc && buyInc.addEventListener("click", () => {
    buyPageQty.textContent = parseInt(buyPageQty.textContent) + 1
    hiddenQuantity && (hiddenQuantity.value = buyPageQty.textContent)
    calculatePrice()
})

buyDec && buyDec.addEventListener("click", () => {
    if (parseInt(buyPageQty.textContent) > 1) {
        buyPageQty.textContent = parseInt(buyPageQty.textContent) - 1
        hiddenQuantity && (hiddenQuantity.value = buyPageQty.textContent)
        calculatePrice()
    }
    else {
        buyPageQty.textContent = 1
        hiddenQuantity && (hiddenQuantity.value = buyPageQty.textContent)
        calculatePrice()
        showAlert("Quantity cannot be less than 1", "error")
    }
})

function calculatePrice() {
    priceTotal && (priceTotal.textContent = parseInt(hiddenQuantity.value) * parseInt(buyPrice.textContent))
    finalPriceWithoutVat && (finalPriceWithoutVat.textContent = priceTotal.textContent)
    vat && (vat.textContent = "Vat (13%): " + parseInt(priceTotal.textContent) * 0.13)
    finalPrice && (finalPrice.textContent = "Grand Total: Rs. " + (parseInt(priceTotal.textContent) + parseInt(vat.textContent.split("Vat (13%): ")[1])))
    finalPriceWithoutVat && (finalPriceWithoutVat.textContent = "Total: " + priceTotal.textContent)
}

// ==================== for menu sidebar filter ==================
const filterCheckbox = document.querySelectorAll(".cbox-veg_nonveg")
const vegFilterForm = document.querySelector(".veg_filter_form")

filterCheckbox && filterCheckbox.forEach((checkbox) => {
    checkbox.addEventListener("click", () => {
        if (checkbox.checked) {
            vegFilterForm.submit()
        }
    })
})

// ==================== create user profile img ==================
const profileImg = document.querySelector(".user_profile_icon")
const imgSRC = profileImg && profileImg.getAttribute("src")

if (imgSRC === "") {
    const profileName = document.querySelector(".user_name")
    const profileNameText = profileName && profileName.textContent
    const firstLetter = profileNameText && profileNameText[0].toUpperCase()
    profileName.style.display = "none"
    const profileImgText = document.createElement("p")
    profileImgText.setAttribute("class", "user_profile_icon_text")
    profileImgText.textContent = firstLetter

    profileImg && profileImg.replaceWith(profileImgText)
}

document.body.addEventListener("click", (e) => {
    if (e.target.classList.contains("user_profile_icon_text")) {
        userLogoutDropdown.classList.toggle("visible")
    }
})

// ==================== for home page slider (don't code below this block) ==================
const swiper = new Swiper('.swiper', {
    direction: 'horizontal',
    loop: true,

    pagination: {
        el: '.swiper-pagination',
    },

    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    }
});