const hostURLDog = "https://localhost/messy-code/";
function checkForUpdates() {
  fetch(hostURLDog + "admin/backend/watch-order-table.php")
    .then((response) => response.json())
    .then((current_count) => {
      setTimeout(() => {
        fetch(hostURLDog + "admin/backend/watch-order-table.php")
          .then((response) => response.json())
          .then((new_count) => {

            if (new_count.data !== JSON.parse(localStorage.getItem('old_data') ? localStorage.getItem('old_data') : current_count.data)) {

              localStorage.setItem('old_data', JSON.stringify(new_count.data));

              const audio = new Audio(hostURLDog + "audio/dog_bark.mp3");
              audio.addEventListener("canplaythrough", () => {
                audio.play();
                if (
                  window.location.href ==
                  hostURLDog + "admin/order-details.php"
                ) {
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
                } else {
                  const alertDialog = document.createElement("div");
                  alertDialog.classList.add("alert-dialog");
                  alertDialog.innerHTML = `
                      <div class="alert-dialog__content border-curve-md p-20 shadow w-fit">
                        <h3 class="alert-dialog__title">New Order!</h3>
                        <p class="alert-dialog__text mt-20">You have a new order!</p>
                        <div class="alert-dialog__actions mt-20 flex items-center">
                        <button class="button gray border-curve-md w-50 alert-dialog__action" onclick="hideAlert()">OK</button>
                        <button class="button border-curve-md w-50 alert-dialog__action" onclick="redirectToOrderPage()">View</button>
                        </div>
                      </div>
                    `;
                  document.body.appendChild(alertDialog);
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

function redirectToOrderPage() {
  window.open(hostURLDog + 'admin/backend/order/view-pending-order.php', '_blank')
  hideAlert();
}

function hideAlert() {
  const alertDialog = document.querySelector(".alert-dialog");
  alertDialog.remove();
}

window.onunload = () => {
  localStorage.removeItem('old_data');
}