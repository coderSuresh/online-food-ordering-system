<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Details | RestroHub</title>
    <link rel="icon" href="../images/logo.png" type="image/png">
    <link rel="stylesheet" href="../styles/style.css">
    <script src="../js/admin.js" defer></script>
    <script src="./watch-dog.js" defer></script>
    <script src="./watch-status.js" defer></script>
</head>

<body>

    <?php
    require '../config.php';
    require './components/header.php';
    require './components/sidebar.php';

    if (!isset($_GET['cid']) && !isset($_GET['date'])) {
        echo "<script>window.location.href = 'order-details.php';</script>";
    } else {
        $cid = unserialize(base64_decode(mysqli_real_escape_string($conn, $_GET['cid'])));
        $id = unserialize(base64_decode(mysqli_real_escape_string($conn, $_GET['id'])));
    }

    $sql_all = "SELECT orders.date,
                    orders.qty,
                    orders.id,
                    orders.total_price,
                    orders.note,
                    orders.track_id,
                    aos.aos_id,
                    aos.status,
                    customer.names,
                    customer.email,
                    customer.date as c_date,
                    order_contact_details.address,
                    order_contact_details.phone,
                    order_contact_details.c_name,
                    food.name,
                    food.price,
                    food.img
                    FROM orders
                    INNER JOIN aos ON orders.id = aos.order_id
                    INNER JOIN customer ON orders.c_id = customer.id
                    INNER JOIN order_contact_details ON orders.id = order_contact_details.o_id
                    INNER JOIN food ON orders.f_id = food.f_id
                    WHERE orders.track_id = '$id'";

    $result_all = mysqli_query($conn, $sql_all) or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($result_all);

    if (mysqli_num_rows($result_all) == 0) {
        echo "Something went wrong.";
    }

    $total_price = 0;
    $id = array();
    $a_id = array();

    foreach ($result_all as $row) {
        $total_price += $row['total_price'];
        array_push($id, $row['id']);
        array_push($a_id, $row['aos_id']);

        if ($row['status'] == 'rejected') {
            $sql_reject = "SELECT reason, rejected_by FROM reject_reason WHERE order_id in (" . implode(',', $id) . ")";
            $result_reject = mysqli_query($conn, $sql_reject) or die(mysqli_error($conn));
            $row_reject = mysqli_fetch_assoc($result_reject);
        }
    }

    $status = $row['status'];

    $sql_k_o_s = "select status from kos where order_id in (" . implode(',', $id) . ")";
    $result_k_o_s = mysqli_query($conn, $sql_k_o_s) or die("Query Failed");

    if (mysqli_num_rows($result_k_o_s) > 0) {
        $data = mysqli_fetch_assoc($result_k_o_s);
        $k_o_s = $data['status'];
    }

    ?>

    <main class="admin_dashboard_body">
        <section class="dashboard_inner-head flex items-center">
            <h2 class="heading">View Order Details</h2>
        </section>
        <div class="vod_container flex gap wrap mt-20">
            <div class="vod_left shadow p-20 border-curve">
                <div class="vod_left-head w-fit">
                    <h3 class="heading">Order Details</h3>
                    <hr class="underline">
                </div>
                <div class="vod_left-body mt-20">
                    <div class="vod_left-body-inner">
                        <div class="vod_left-body-inner-content">
                            <table class="table_order-details">
                                <tr>
                                    <td>Order ID</td>
                                    <td>:</td>
                                    <td><?php echo $row['track_id']; ?></td>
                                </tr>
                                <tr>
                                    <td>Order Date</td>
                                    <td>:</td>
                                    <td><?php echo $row['date']; ?></td>
                                </tr>
                                <tr>
                                    <td>Order Status</td>
                                    <td>:</td>
                                    <td><?php echo $row['status']; ?></td>
                                </tr>
                                <tr>
                                    <td>Order Total</td>
                                    <td>:</td>
                                    <td>Rs. <?php echo $total_price; ?></td>
                                </tr>
                                <tr>
                                    <td>Payment Method</td>
                                    <td>:</td>
                                    <td>COD</td> <!-- TODO: Change this to dynamic -->
                                </tr>
                                <tr>
                                    <td>Note</td>
                                    <td>:</td>
                                    <td><?php echo $row['note']; ?></td>
                                </tr>
                                <?php
                                if ($row['status'] == 'rejected') {
                                ?> <tr>
                                        <td>Reason</td>
                                        <td>:</td>
                                        <td><?php echo $row_reject['reason']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Rejected by</td>
                                        <td>:</td>
                                        <td><?php echo $row_reject['rejected_by']; ?></td>
                                    </tr>
                                <?php }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="vod_right shadow p-20 border-curve">
                <div class="vod_right-head w-fit">
                    <h3 class="heading">Customer Details</h3>
                    <hr class="underline">
                </div>
                <div class="vod_right-body mt-20">
                    <div class="vod_right-body-inner">
                        <div class="vod_right-body-inner-content">
                            <table class="table_order-details">
                                <tr>
                                    <td>Customer's Name</td>
                                    <td>:</td>
                                    <td><?php echo $row['names']; ?></td>
                                </tr>
                                <tr>
                                    <td>Receiver's Name</td>
                                    <td>:</td>
                                    <td><?php echo $row['c_name']; ?></td>
                                </tr>
                                <tr>
                                    <td>Customer's Email</td>
                                    <td>:</td>
                                    <td>
                                        <a href="mailto:<?php echo $row['email']; ?>">
                                            <div class="w-fit">
                                                <?php echo $row['email']; ?>
                                                <hr>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Receiver's Contact</td>
                                    <td>:</td>
                                    <td>
                                        <a href="tel:<?php echo $row['phone']; ?>">
                                            <div class="w-fit">
                                                <?php echo $row['phone']; ?>
                                                <hr>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Shipping Address</td>
                                    <td>:</td>
                                    <td><?php echo $row['address']; ?></td>
                                </tr>
                                <tr>
                                    <td>Joined On</td>
                                    <td>:</td>
                                    <td><?php echo $row['c_date']; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-20 p-20 shadow border-curve">
            <div class="w-fit">
                <h3 class="heading">Order Items</h3>
                <hr class="underline">
            </div>

            <div>
                <table class="table_order-items mt-20">
                    <tr class="shadow">
                        <th>SN</th>
                        <th>Image</th>
                        <th>Food Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                    <?php
                    $i = 0;
                    foreach ($result_all as $row) {
                        $i++;
                    ?>
                        <tr class="shadow">
                            <td><?php echo $i; ?></td>
                            <td>
                                <img src="../uploads/foods/<?php echo $row['img']; ?>" alt="food image" class="table_food-img">
                            </td>
                            <td><?php echo $row['name']; ?></td>
                            <td>Rs. <?php echo $row['price']; ?></td>
                            <td><?php echo $row['qty']; ?></td>
                            <td>Rs. <?php echo $row['total_price']; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>

        </div>

        <div class="vod_btns flex gap w-full p-20 mt-20">
            <?php if ($status != "rejected" && $status != "delivered") { ?>
                <div class="flex gap row-reverse">
                    <?php
                    if ($status == "pending") {
                    ?>
                        <form action="./backend/order/accept.php" method="post" class="flex items-center justify-start">
                            <input type="hidden" name="id" value='<?php echo base64_encode(serialize($id)); ?>'>
                            <input type="hidden" name="aos_id" value='<?php echo base64_encode(serialize($a_id)); ?>'>
                            <button type="submit" name="accept" class="button no_outline border-curve">
                                <div class="flex items-center">
                                    <img src="../images/ic_accept.svg" alt="accept icon">
                                    <p class="body-text ml-5">Accept</p>
                                </div>
                            </button>
                        </form>
                    <?php } else if ($status == "accepted") {
                    ?>
                        <form action="./backend/order/prepared.php" method="post" class="flex items-center justify-start">
                            <input type="hidden" name="id" value='<?php echo base64_encode(serialize($id)); ?>'>
                            <input type="hidden" name="aos_id" value='<?php echo base64_encode(serialize($a_id)); ?>'>
                            <button type="submit" name="prepared" class="button no_outline border-curve">
                                <div class="flex items-center">
                                    <img src="../images/ic_prepared.svg" alt="prepared">
                                    <p class="body-text ml-5">Prepared</p>
                                </div>
                            </button>
                        </form>
                    <?php
                    } else if ($status == "prepared") {
                    ?>
                        <form action="./backend/order/notify-delivery.php" method="post" class="flex items-center justify-start">
                            <input type="hidden" name="id" value='<?php echo base64_encode(serialize($id)); ?>'>
                            <input type="hidden" name="aos_id" value='<?php echo base64_encode(serialize($a_id)); ?>'>
                            <button type="submit" name="notify-delivery" class="button no_outline border-curve">
                                <div class="flex items-center">
                                    <img src="../images/ic_bell.svg" alt="notify">
                                    <p class="body-text ml-5">Call Delivery</p>
                                </div>
                            </button>
                        </form>
                        <form action="./backend/order/reject.php" method="post" class="flex reject_form mt-20 items-center justify-start">
                            <input type="hidden" name="id" value='<?php echo base64_encode(serialize($id)); ?>'>
                            <input type="hidden" name="aos_id" value='<?php echo base64_encode(serialize($a_id)); ?>'>
                            <input type="hidden" class="hidden-reject_reason" name="reject-reason" value="">
                        </form>
                        <div class="flex items-center justify-start">
                            <button type="submit" name="reject" class="button gray no_outline border-curve reject_btn">
                                <div class="flex items-center">
                                    <img src="../images/ic_reject.svg" alt="reject icon">
                                    <p class="body-text ml-5">Reject</p>
                                </div>
                            </button>
                        </div>
                    <?php
                    } else if ($status == "delivering") {
                    ?>
                        <form action="./backend/order/delivered.php" method="post" class="flex items-center justify-start">
                            <input type="hidden" name="id" value='<?php echo base64_encode(serialize($id)); ?>'>
                            <input type="hidden" name="aos_id" value='<?php echo base64_encode(serialize($a_id)); ?>'>
                            <button type="submit" name="delivered" class="button no_outline border-curve">
                                <div class="flex items-center">
                                    <img src="../images/ic_accept.svg" alt="notify">
                                    <p class="body-text ml-5">Delivered</p>
                                </div>
                            </button>
                        </form>
                        <form action="./backend/order/reject.php" method="post" class="flex reject_form mt-20 items-center justify-start">
                            <input type="hidden" name="id" value='<?php echo base64_encode(serialize($id)); ?>'>
                            <input type="hidden" name="aos_id" value='<?php echo base64_encode(serialize($a_id)); ?>'>
                            <input type="hidden" class="hidden-reject_reason" name="reject-reason" value="">
                        </form>
                        <div class="flex items-center justify-start">
                            <button type="submit" name="reject" class="button gray no_outline border-curve reject_btn">
                                <div class="flex items-center">
                                    <img src="../images/ic_reject.svg" alt="reject icon">
                                    <p class="body-text ml-5">Reject</p>
                                </div>
                            </button>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <?php if ($status == "pending" || $status == "accepted" && $k_o_s == "pending") { ?>
                    <form action="./backend/order/reject.php" method="post" class="flex reject_form items-center justify-start">
                        <input type="hidden" name="id" value='<?php echo base64_encode(serialize($id)); ?>'>
                        <input type="hidden" name="aos_id" value='<?php echo base64_encode(serialize($a_id)); ?>'>
                        <input type="hidden" class="hidden-reject_reason" name="reject-reason" value="">
                    </form>
                    <div class="flex items-center justify-start">
                        <button type="submit" name="reject" class="button gray no_outline border-curve reject_btn">
                            <div class="flex items-center">
                                <img src="../images/ic_reject.svg" alt="reject icon">
                                <p class="body-text ml-5">Reject</p>
                            </div>
                        </button>
                    </div>
                <?php } ?>
        </div>
        </div>
    <?php } ?>
    </div>

    </main>

</body>

</html>