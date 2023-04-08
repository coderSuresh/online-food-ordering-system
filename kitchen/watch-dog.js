const url = "http://localhost/messy-code/";
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

                setTimeout(() => {
                  location.reload();
                }, 1000);
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
