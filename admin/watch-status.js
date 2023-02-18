function checkForUpdates(backendAPI) {
    fetch(backendAPI)
        .then((response) => response.json())
        .then((current_state) => {
            setTimeout(() => {
                fetch("./backend/watch-status-change.php")
                    .then((response) => response.json())
                    .then((new_state) => {
                        new_state.forEach((item, i) => {
                            if (new_state[i].status !== current_state[i].status) {
                                if (!window.location.href == "https://localhost/messy-code/admin/order-details.php") {
                                    sendNotification();
                                } else {
                                    console.log(new_state[i].status);
                                    let status = new_state[i].status;
                                    let message = ""
                                    let title = ""
                                    let foodName = new_state[i].food_name;
                                    if (status === "accepted") {
                                        title = "Order Accepted";
                                        message = `Order of ${foodName} is accepted by kitchen!`;
                                    }
                                    else if (status === "prepared") {
                                        title = "Order Prepared";
                                        message = `Order of ${foodName} is prepared by kitchen!`;
                                    }
                                    else if (status === "rejected") {
                                        title = "Order Rejected";
                                        message = `Order of ${foodName} is rejected by kitchen!`;
                                    }

                                    playSound();

                                    const alertDialog = document.createElement("div");
                                    alertDialog.classList.add("alert-dialog");
                                    alertDialog.innerHTML = `
                                                        <div class="alert-dialog__content border-curve-md p-20 shadow w-fit">
                                                            <h3 class="alert-dialog__title">${title} !</h3>
                                                            <p class="alert-dialog__text mt-20">${message}</p>
                                                            <div class="alert-dialog__actions mt-20 flex items-center">
                                                            <button class="button border-curve-md w-full alert-dialog__action" onclick="hideAlert()">OK</button>
                                                            ${status === "rejected" ? `
                                        (<button class="button border-curve-md w-full alert-dialog__action" onclick="redirect()">View</button>)`
                                        : ""} 
                                                            </div>
                                                        </div>
                                                        `;
                                    document.body.appendChild(alertDialog);
                                }
                            }
                            else {
                                checkForUpdates(backendAPI);
                            }
                        });
                    })
                    .catch((error) => console.error(error));
            }, 5000);

        })
        .catch((error) => console.error(error));
}
checkForUpdates("./backend/watch-status-change.php");

function redirect() {
    window.open('https://localhost/messy-code/admin/reject-report.php', '_blank')
}

function playSound() {
    const audio = new Audio("../audio/dog_bark.mp3");
    audio.addEventListener("canplaythrough", () => {
        audio.play();
    });
}

function hideAlert() {
    const alertDialog = document.querySelector(".alert-dialog");
    alertDialog.remove();
    location.reload();
}

function sendNotification() {
    if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
    } else {
        Notification.requestPermission().then((permission) => {
            if (permission === "granted") {
                const notification = new Notification("New Order", {
                    body: "You have a new order!",
                    icon: "../images/logo.png",
                });
                notification.onclick = (event) => {
                    event.preventDefault();
                    window.open("https://localhost/messy-code/admin/order-details.php", "_blank");
                };
            }
        });
    }
}
