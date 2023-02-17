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
                    location.reload();
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
  if(!("Notification" in window)) {
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

