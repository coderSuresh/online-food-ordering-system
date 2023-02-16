function checkForUpdates() {
  fetch("./backend/watch-order-table.php")
    .then((response) => response.json())
    .then((current_count) => {
      setTimeout(() => {
        fetch("./backend/watch-order-table.php")
          .then((response) => response.json())
          .then((new_count) => {
            if (new_count.data !== current_count.data) {               
                sendNotification();    
                 location.reload();
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
    if ("Notification" in window) {
      Notification.requestPermission().then(function (permission) {
        if (permission === "granted") {
          const notification = new Notification("New Message", {
            body: "New Order Received",
            icon: "../images/food.png",
            sound: "../audio/dog_bark.mp3"
          });         
          notification.onclick = function () {
            window.open(
              "https://localhost/messy-code/admin/order-details.php"
            );

          };
        }
      });
    }

}
