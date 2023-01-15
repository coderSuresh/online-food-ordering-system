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

passwordToggleBtn && passwordToggleBtn.forEach((btn,i) => {
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