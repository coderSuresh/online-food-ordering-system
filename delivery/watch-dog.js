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

                const alertDialog = document.createElement("div");
                alertDialog.classList.add("alert-dialog");
                alertDialog.innerHTML = `
                      <div class="alert-dialog__content border-curve-md p-20 shadow w-fit">
                        <h3 class="alert-dialog__title">New Order!</h3>
                        <p class="alert-dialog__text mt-20">You have a new order!</p>
                        <div class="alert-dialog__actions mt-20 flex items-center">
                        <button class="button border-curve-md w-full alert-dialog__action" onclick="hideAlert()">OK</button>
                        </div>
                      </div>
                    `;
                document.body.appendChild(alertDialog);
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

function hideAlert() {
  const alertDialog = document.querySelector(".alert-dialog");
  alertDialog.remove();
  location.reload();
}
