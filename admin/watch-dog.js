function checkForUpdates() {
  fetch("./backend/watch-order-table.php")
    .then((response) => response.json())
    .then((current_count) => {
      setTimeout(() => {
        fetch("./backend/watch-order-table.php")
          .then((response) => response.json())
          .then((new_count) => {
            if (new_count.data !== current_count.data) {

              const audio = new Audio("../audio/dog_bark.mp3");
              audio.addEventListener("canplaythrough", () => {
                audio.play();
                if (window.location.href == "https://localhost/messy-code/admin/order-details.php") {
                  setTimeout(() => {
                    const alertDialog = document.createElement("div");
                    alertDialog.classList.add("alert-dialog");
                    // I'm aware that this is not a good practice, but I don't have time to create elements using JS as it takes a lot of time. So, I'm using innerHTML to create elements. :D
                    alertDialog.innerHTML = `
                      <div class="alert-dialog__content border-curve-md p-20 shadow w-fit">
                        <h3 class="alert-dialog__title">New Order!</h3>
                        <p class="alert-dialog__text mt-20">You have a new order!</p>
                        <div class="alert-dialog__actions mt-20">
                          <button class="button border-curve-md alert-dialog__action w-full" onclick="location.reload()">OK</button>
                        </div>
                      </div>
                    `;
                    document.body.appendChild(alertDialog);
                  }, 1000);
                }
                else {
                  sendNotification();
                }
              });

            } else {
              checkForUpdates();
            }
          })
          .catch((error) => console.error(error));
      }, 3000);
    })
    .catch((error) => console.error(error));
}

checkForUpdates();

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

