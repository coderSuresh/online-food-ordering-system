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
const addBtn = document.querySelector(".btn-add-food")

closeBtn && (
    closeBtn.addEventListener("click", () => {
        modal.style.display = "none"
    })
)

addBtn && (
    addBtn.addEventListener("click", () => {
        modal.style.display = "flex"
    })
)
