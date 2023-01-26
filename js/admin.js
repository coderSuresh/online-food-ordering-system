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

imgUploadInput.style.display = "none";

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
    if (!e.target.closest(".table_option-menu")) {
        actionMenus && actionMenus.forEach(menu => {
            menu.classList.remove("visible")
        })
    }

    if (!e.target.closest(".sidebar_accordion")) {
        sidebarSubMenuOpener && sidebarSubMenuOpener.forEach(item => {
            item.classList.remove("active")
        })
    }
})

// to prevent default action of form submit
const form = document.querySelector(".modal_form")
const submitBtn = document.querySelector(".add-category")

// get name attribute
const btnName = submitBtn.getAttribute("name")
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
    const name = document.forms["modal_form"]["name"].value
    const img = document.querySelector(".img_upload-input").files

    if (name && img.length) {
        btnName == "add" ? submitForm("../admin/backend/category/add-category.php") : submitForm("../admin/backend/category/update.php")
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
                // reset form if success
                form.reset()
                // set updated name to input field
                const nameInput = document.querySelector(".name_input")
                nameInput && nameInput.setAttribute("value", data["name"])
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
    }, 2900);

    modalAlert.textContent = msg

    setTimeout(() => {
        body.removeChild(modalAlert)
    }, 3000)

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

// show alert on delete
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
