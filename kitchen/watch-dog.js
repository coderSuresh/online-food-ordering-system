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

function updateTable() {
  fetch("./backend/order/update-table.php")
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
    })
    .catch((error) => console.error(error));
}

function createTable() {
  const rowTable = document.querySelector(".order-row");
  table.innerHTML = `
  <td><?php echo $i; ?></td>
                        <td>
                            <?php echo $row['date']; ?>
                        </td>
                        <td><?php echo $row['c_name']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td><?php echo $food_name . " x " . $row['qty']; ?></td>
                        <td><?php echo $row['total_price']; ?></td>
                        <td><span class="<?php echo $row['status']; ?> border-curve-lg p_7-20"><?php echo $row['status']; ?></span></td>
                        <td class="table_action_container">
                            <!-- action menu -->
                            <button class="no_bg no_outline table_option-menu">
                                <img src="../images//ic_options.svg" alt="options menu">
                            </button>
                            <!-- options -->
                            <?php if ($status != "rejected") { ?>
                                <div class="table_action_options shadow border-curve p-20 r_70 flex direction-col">
                                    <div>
                                        <?php
                                        if ($status == "pending") {
                                        ?>
                                            <form action="./backend/order/accept.php" method="post" class="flex items-center justify-start">
                                                <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                                                <input type="hidden" name="aos_id" value="<?php echo $row["aos_id"]; ?>">
                                                <button type="submit" name="accept" class="no_bg no_outline">
                                                    <div class="flex items-center justify-start">
                                                        <img src="../images/ic_accept.svg" alt="accept icon">
                                                        <p class="body-text">Accept</p>
                                                    </div>
                                                </button>
                                            </form>
                                        <?php } else if ($status == "accepted") {
                                        ?>
                                            <form action="./backend/order/prepared.php" method="post" class="flex items-center justify-start">
                                                <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                                                <input type="hidden" name="aos_id" value="<?php echo $row["aos_id"]; ?>">
                                                <button type="submit" name="prepared" class="no_bg no_outline">
                                                    <div class="flex items-center justify-start">
                                                        <img src="../images/ic_prepared.svg" alt="prepared">
                                                        <p class="body-text">Prepared</p>
                                                    </div>
                                                </button>
                                            </form>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div>
                                        <?php if ($status == "pending" || $status == "accepted" && $k_o_s == "pending") { ?>
                                            <form action="./backend/order/reject.php" method="post" class="flex items-center justify-start">
                                                <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                                                <input type="hidden" name="aos_id" value="<?php echo $row["aos_id"]; ?>">
                                                <button type="submit" name="reject" class="no_bg no_outline reject_btn">
                                                    <div class="flex items-center justify-start">
                                                        <img src="../images/ic_reject.svg" alt="reject icon">
                                                        <p class="body-text">Reject</p>
                                                    </div>
                                                </button>
                                            </form>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </td>
  
  `
}
