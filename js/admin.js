// for hamburger menu icon (for sidebar)
const menu = document.querySelector(".menu__for-sidebar")
const sidebar = document.querySelector(".sidebar")

menu && (
    menu.addEventListener("click", () => {
        menu.classList.toggle("open")
        sidebar.classList.toggle("open")
    })
)

// for modal popup 
const modal = document.querySelector(".modal")
const closeBtn = document.querySelector(".close-icon")
const popperBtn = document.querySelector(".popper-btn")

closeBtn && (
    closeBtn.addEventListener("click", () => {
        modal.style.display = "none"
        location.reload()
    })
)

popperBtn && (
    popperBtn.addEventListener("click", () => {
        modal.style.display = "flex"
    })
)

// toggle dark light mode 
const darkModeIcon = document.querySelector(".dark-mode-icon")
darkModeIcon && (
    darkModeIcon.addEventListener("click", () => {
        darkModeIcon.getAttribute("src") == "../images/ic_light_mode.svg" ? setDarkMode() : setLightMode()
    })
)

const setLightMode = () => {
    darkModeIcon && darkModeIcon.setAttribute("src", "../images/ic_light_mode.svg")
    console.log("set light mode")
}

const setDarkMode = () => {
    darkModeIcon && darkModeIcon.setAttribute("src", "../images/ic_dark_mode.svg")
    console.log("set dark mode")
}

// toggle admin profile
const adminProfile = document.querySelector(".admin_profile_image")
adminProfile && (
    adminProfile.classList.remove("open")
)
adminProfile && (
    adminProfile.addEventListener("click", () => {
        adminProfile.classList.toggle("open")
    })
)

// filter by date custom option
const filterForm = document.querySelector(".date_filter_modal_form")
const customBtn = document.getElementById("filter_option-custom")

filterForm && filterForm.addEventListener("change", (e) => {
    customBtn && customBtn.checked ? showCustomOption() : hideCustomOption()
})

const customOption = document.querySelector(".date_filter_form_option-custom")
const showCustomOption = () => {
    customOption && (
        customOption.classList.add("visible")
    )
}

const hideCustomOption = () => {
    customOption && (
        customOption.classList.remove("visible")
    )
}

// for sidebar accordion
const sidebarSubMenuOpener = document.querySelectorAll(".sidebar_accordion")

sidebarSubMenuOpener && sidebarSubMenuOpener.forEach(item => {
    item.addEventListener("click", () => {

        const arr = Object.values(sidebarSubMenuOpener) //convert objects to array
        const otherItems = arr.filter(otherItem => otherItem !== item) //filter currently clicked element
        //remove class from all other elements
        otherItems.forEach(oItem => {
            oItem.classList.remove("active")
        })
        // toggle class from clicked element
        item.classList.toggle("active")
    })
})

// toggle password icon
const passwordToggleBtn = document.querySelector(".password_toggle_btn")

passwordToggleBtn && passwordToggleBtn.addEventListener("click", () => {
    passwordToggleBtn.getAttribute("src") == "../../images/ic_eye-off.svg" ? showPassword() : hidePassword()
})

const showPassword = () => {
    passwordToggleBtn && passwordToggleBtn.setAttribute("src", "../../images/ic_eye.svg")
}

const hidePassword = () => {
    passwordToggleBtn && passwordToggleBtn.setAttribute("src", "../../images/ic_eye-off.svg")
}

// show preview of uploaded image
const uploadedImg = document.querySelector(".upload-img")
const imgUploadInput = document.querySelector(".img_upload-input")

imgUploadInput && imgUploadInput.addEventListener("change", (e) => {

    const url = URL.createObjectURL(e.target.files[0])
    uploadedImg && uploadedImg.setAttribute("src", url)

    uploadedImg && (
        uploadedImg.onload = () => {
            URL.revokeObjectURL(uploadedImg.src)
        }
    )
})

// for action menu of any table
const actionMenus = document.querySelectorAll(".table_option-menu")
const actionOptions = document.querySelectorAll(".table_action_options")

actionMenus && actionMenus.forEach((actionMenu) => {
    actionMenu.addEventListener("click", () => {
        const arr = Object.values(actionMenus)
        const otherActionMenus = arr.filter(otherActionMenu => otherActionMenu !== actionMenu)
        otherActionMenus.forEach(menu => {
            menu.classList.remove("visible")
        })
        actionMenu.classList.toggle("visible")
    })
})

// for closing action menu when clicked outside
window.addEventListener("click", (e) => {
    if (!e.target.closest(".table_option-menu") && !e.target.closest(".table_action_options")) {
        actionMenus && actionMenus.forEach(menu => {
            menu.classList.remove("visible")
        })
    }

    if (!e.target.closest(".sidebar_accordion") && !e.target.closest(".sidebar_sub-menu")) {
        sidebarSubMenuOpener && sidebarSubMenuOpener.forEach(item => {
            item.classList.remove("active")
        })
    }
})

// to prevent default action of form submit
const form = document.querySelector(".modal_form")

// check if form is for add food
const isForFood = form && form.getAttribute("class").includes("form_add-food")
const isForCategory = form && form.getAttribute("class").includes("form_add-category")

const submitBtn = document.querySelector(".modal_form-submit-btn")

// get name attribute
const btnName = submitBtn && submitBtn.getAttribute("name")
if (btnName == "update") {
    // set uploaded image to input field
    const imgURL = uploadedImg && uploadedImg.getAttribute("src")

    const imgInput = document.querySelector(".img_upload-input")
    const dt = new DataTransfer()
    const img = imgURL && imgURL.split("/")[3]
    dt.items.add(new File([img], img))
    imgInput && (imgInput.files = dt.files)
}

form && form.addEventListener("submit", (e) => {

    e.preventDefault()

    //validate for empty fields
    const itemName = document.forms["modal_form"]["name"].value
    const img = document.querySelector(".img_upload-input").files

    if (isForFood) {
        const price = document.forms["modal_form"]["price"].value
        const cost = document.forms["modal_form"]["cost"].value
        const desc = document.forms["modal_form"]["description"].value
        const category = document.forms["modal_form"]["cat_id"].value
        const productId = document.forms["modal_form"]["product-id"].value
        const estimatedCookingTime = document.forms["modal_form"]["estimated-cooking-time"].value
        const vegNonVeg = document.forms["modal_form"]["veg-non-veg"].value

        if (itemName && price && cost && desc && category && productId && estimatedCookingTime && vegNonVeg && img.length) {
            btnName == "add" ? submitForm("./backend/foods/add-food.php") : submitForm("./backend/foods/update.php")
        }
    }
    else if (isForCategory) {
        if (itemName && img.length) {
            btnName == "add" ? submitForm("./backend/category/add-category.php") : submitForm("./backend/category/update.php")
        }
    }
})

// submit form
function submitForm(backendAPI) {
    const formData = new FormData(form)
    fetch(backendAPI, {
        method: "POST",
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            showAlert(data["msg"], data["status"].split(" ")[0])
            if (data['status'].includes("reset")) {
                form.reset()
                if (btnName == "update") {
                    // set updated name to input field
                    itemName && itemName.setAttribute("value", data["name"])
                }
            }
        })
        .catch(err => {
            console.log(err)
        })
}

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
    }, 1900);

    modalAlert.textContent = msg

    setTimeout(() => {
        body.removeChild(modalAlert)
    }, 2000)

    body.appendChild(modalAlert)
}

// warn before delete
const deleteBtn = document.querySelectorAll(".delete_btn")

deleteBtn && deleteBtn.forEach(btn => {
    btn.addEventListener("click", (e) => {
        const confirm = window.confirm("Are you sure to delete?")
        if (!confirm) {
            e.preventDefault()
        }
    })
})

// warn before reject
const rejectBtn = document.querySelectorAll(".reject_btn")

rejectBtn && rejectBtn.forEach(btn => {
    btn.addEventListener("click", (e) => {
        const confirm = window.confirm("Are you sure to reject this order?")
        if (!confirm) {
            e.preventDefault()
        }
    })
})

// show error alert
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

// show alert on max short description
const shortDesc = document.querySelector("#short-desc")
shortDesc && shortDesc.addEventListener("input", () => {
    if (shortDesc.value.length >= 50) {
        shortDesc.setAttribute("maxlength", "50")
        alert("Max 50 characters allowed")
    }
})
