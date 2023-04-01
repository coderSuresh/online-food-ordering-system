<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Future Details | RestroHub</title>
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
        echo "<script>window.location.href = 'future-orders.php';</script>";
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
                    orders.delivery_date,
                    orders.delivery_time,
                    future_orders.fo_id,
                    future_orders.status,
                    orders.payment_method,
                    customer.names,
                    customer.email,
                    order_contact_details.address,
                    order_contact_details.phone,
                    order_contact_details.c_name,
                    food.name,
                    food.price,
                    food.img
                    FROM orders
                    INNER JOIN future_orders ON orders.id = future_orders.order_id
                    INNER JOIN customer ON orders.c_id = customer.id
                    INNER JOIN order_contact_details on orders.o_c_id = order_contact_details.o_c_id
                    INNER JOIN food ON orders.f_id = food.f_id
                    WHERE orders.track_id = '$id'";

    $result_all = mysqli_query($conn, $sql_all) or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($result_all);

    $status = $row['status'];
    $delivery_date = $row['delivery_date'];
    $delivery_time = $row['delivery_time'];

    if (mysqli_num_rows($result_all) == 0) {
        echo "Something went wrong.";
    }

    $total_price = 0;
    $id = array();
    $a_id = array();

    foreach ($result_all as $row) {
        $total_price += $row['total_price'];
        array_push($id, $row['id']);
        array_push($a_id, $row['fo_id']);

        if ($row['status'] == 'rejected') {
            $sql_reject = "SELECT reason, rejected_by FROM reject_reason WHERE order_id in (" . implode(',', $id) . ")";
            $result_reject = mysqli_query($conn, $sql_reject) or die(mysqli_error($conn));
            $row_reject = mysqli_fetch_assoc($result_reject);
        }
    }
    ?>

    <main class="admin_dashboard_body">
        <section class="dashboard_inner-head flex items-center">
            <h2 class="heading">Future Order Details</h2>
        </section>

        <?php require './components/order-details.php'; ?>

        <div class="vod_btns flex gap w-full p-20 mt-20">
            <?php if ($status != "rejected" && $status != "accepted") { ?>
                <div class="flex gap row-reverse">
                    <form action="./backend/order/accept.php" method="post" class="flex items-center justify-start">
                        <input type="hidden" name="id" value='<?php echo base64_encode(serialize($id)); ?>'>
                        <input type="hidden" name="fo_id" value='<?php echo base64_encode(serialize($a_id)); ?>'>
                        <button type="submit" name="accept" class="button no_outline border-curve">
                            <div class="flex items-center">
                                <img src="../images/ic_accept.svg" alt="accept icon">
                                <p class="body-text ml-5">Accept</p>
                            </div>
                        </button>
                    </form>

                    <form action="./backend/order/reject.php" method="post" class="flex reject_form mt-20 items-center justify-start">
                        <input type="hidden" name="id" value='<?php echo base64_encode(serialize($id)); ?>'>
                        <input type="hidden" name="fo_id" value='<?php echo base64_encode(serialize($a_id)); ?>'>
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

                </div>
        </div>
    <?php } ?>
    </div>

    </main>

</body>

</html>