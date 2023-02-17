function createTableRow(i, date, order_id, aos_id, c_name, address, food_name, qty, total_price, status) {
  const rowTable = document.querySelector(".order-table");
  rowTable.innerHTML += `
  <tr class="shadow">
  <td>${i}</td>
                        <td>
                            ${date}
                        </td>
                        <td>${c_name}</td>
                        <td>${address}</td>
                        <td>${food_name} x ${qty}</td>
                        <td>${total_price}</td>
                        <td><span class="${status} border-curve-lg p_7-20">${status}</span></td>
                        <td class="table_action_container">
                            <!-- action menu -->
                            <button class="no_bg no_outline table_option-menu">
                                <img src="../images//ic_options.svg" alt="options menu">
                            </button>
                            <!-- options -->
                            ${status != "rejected" && `
                                <div class="table_action_options shadow border-curve p-20 r_70 flex direction-col">
                                    <div>
                                       
                                         ${status == "pending" && `                          
                                            <form action="./backend/order/accept.php" method="post" class="flex items-center justify-start">
                                                <input type="hidden" name="id" value="${order_id}">
                                                <input type="hidden" name="aos_id" value="${aos_id}">
                                                <button type="submit" name="accept" class="no_bg no_outline">
                                                    <div class="flex items-center justify-start">
                                                        <img src="../images/ic_accept.svg" alt="accept icon">
                                                        <p class="body-text">Accept</p>
                                                    </div>
                                                </button>
                                                </form>
                                          `}
                                        ${status == "accepted" && `
                                            <form action="./backend/order/prepared.php" method="post" class="flex items-center justify-start">
                                                <input type="hidden" name="id" value="${order_id}">
                                                <input type="hidden" name="aos_id" value="${aos_id}">
                                                <button type="submit" name="prepared" class="no_bg no_outline">
                                                    <div class="flex items-center justify-start">
                                                        <img src="../images/ic_prepared.svg" alt="prepared">
                                                        <p class="body-text">Prepared</p>
                                                    </div>
                                                </button>
                                            </form>
                                         ` }
                                       </div>
                                    <div>
                                        ${status == "pending" || status == "accepted" && k_o_s == "pending" && `
                                            <form action="./backend/order/reject.php" method="post" class="flex items-center justify-start">
                                                <input type="hidden" name="id" value="${order_id}">
                                                <input type="hidden" name="aos_id" value="${aos_id}">
                                                <button type="submit" name="reject" class="no_bg no_outline reject_btn">
                                                    <div class="flex items-center justify-start">
                                                        <img src="../images/ic_reject.svg" alt="reject icon">
                                                        <p class="body-text">Reject</p>
                                                    </div>
                                                </button>
                                            </form>
                                        ` } 
                                    </div>
                                </div>
                            `} 
                        </td>
              </tr>
                        `;
}

function createTableHeader() {
  const orderTable = document.querySelector(".order-table");
  orderTable.innerHTML = `
    <tr class="shadow">
      <th>SN</th>
      <th>Date</th>
      <th>Customer</th>
      <th>Location</th>
      <th>Item</th>
      <th>Amount</th>
      <th>Order Status</th>
      <th>Action</th>
    </tr>
  `;
}

function updateTableRow() {
  fetch("./backend/order/update-table.php")
    .then((response) => response.json())
    .then((data) => {
      createTableHeader();
      data.forEach((order, i) => {
        createTableRow(
          i + 1,
          order.date,
          order.order_id,
          order.aos_id,
          order.c_name,
          order.address,
          order.food_name,
          order.qty,
          order.total_price,
          order.status
        );
      });
    })
    .catch((error) => console.error(error));
}

updateTableRow();

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

              const audio = new Audio("../audio/dog_bark.mp3");
              audio.addEventListener('canplaythrough', () => {
                audio.play();
              });

              updateTableRow();
              checkForUpdates();
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
    Notification.requestPermission().then((permission) => {
      if (permission === "granted") {
        const notification = new Notification("New Message", {
          body: "New Order Received",
          icon: "../images/food.png",
        });
        notification.onclick = () => {
          window.open(
            "https://localhost/messy-code/admin/order-details.php"
          );

        };
      }
    });
  }
}
