<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <title>View Details | RestroHub</title>
    <link rel="icon" href="../images/logo.png" type="image/png">
    <link rel="stylesheet" href="../styles/style.css">
    <script src="../js/admin.js" defer></script>
    <script src="./watch-dog.js" defer></script>
    <script src="./watch-status.js" defer></script>
</head>

<body>

    <?php
    session_start();
    require '../config.php';
    require './components/header.php';

    if (!isset($_GET['cid']) && !isset($_GET['date'])) {
        echo "<script>window.location.href = './index.php';</script>";
    } else {
        $cid = unserialize(base64_decode(mysqli_real_escape_string($conn, $_GET['cid'])));
        $id = unserialize(base64_decode(mysqli_real_escape_string($conn, $_GET['id'])));
    }

    $sql_all = "SELECT orders.date,
                    orders.qty,
                    orders.id,
                    orders.track_id,
                    orders.total_price,
                    orders.note,
                    orders.payment_method,
                    to_be_delivered.tbd_id,
                    to_be_delivered.status,
                    customer.names,
                    customer.email,
                    order_contact_details.address,
                    order_contact_details.phone,
                    order_contact_details.c_name,
                    food.name,
                    food.price,
                    food.img
                    FROM orders
                    INNER JOIN customer ON orders.c_id = customer.id
                    INNER JOIN order_contact_details ON orders.o_c_id = order_contact_details.o_c_id
                    INNER JOIN food ON orders.f_id = food.f_id
                    INNER JOIN to_be_delivered ON orders.id = to_be_delivered.order_id
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
        array_push($a_id, $row['tbd_id']);

        if ($row['status'] == 'rejected') {
            $sql_reject = "SELECT reason FROM reject_reason WHERE order_id in (" . implode(',', $id) . ")";
            $result_reject = mysqli_query($conn, $sql_reject) or die(mysqli_error($conn));
            $row_reject = mysqli_fetch_assoc($result_reject);
        }
    }

    $status = $row['status'];

    ?>

    <main style="margin: 40px;">
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
                                    <td><?php echo $row['payment_method']; ?></td>
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
                        <form action="./backend/order/delivered.php" method="post" class="flex items-center justify-start">
                            <input type="hidden" name="id" value='<?php echo base64_encode(serialize($id)); ?>'>
                            <input type="hidden" name="tbd_id" value='<?php echo base64_encode(serialize($a_id)); ?>'>
                            <button type="submit" name="delivered" class="button no_outline border-curve">
                                <div class="flex items-center">
                                    <img src="../images/ic_accept.svg" alt="accept icon">
                                    <p class="body-text ml-5">Delivered</p>
                                </div>
                            </button>
                        </form>
                    <?php } ?>
                    <form action="./backend/order/reject.php" method="post" class="flex reject_form mt-20 items-center justify-start">
                        <input type="hidden" name="id" value='<?php echo base64_encode(serialize($id)); ?>'>
                        <input type="hidden" name="tbd_id" value='<?php echo base64_encode(serialize($a_id)); ?>'>
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

    </main>

</body>

</html>