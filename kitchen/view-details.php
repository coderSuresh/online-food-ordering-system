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
</head>

<body>

    <?php
    require '../config.php';
    require './components/header.php';

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
                    kos.kos_id,
                    kos.status,
                    aos.aos_id,
                    food.name,
                    food.img
                    FROM orders
                    INNER JOIN kos ON orders.id = kos.order_id
                    INNER JOIN aos ON orders.id = aos.order_id
                    INNER JOIN food ON orders.f_id = food.f_id
                    WHERE orders.track_id = '$id'";

    $result_all = mysqli_query($conn, $sql_all) or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($result_all);

    if (mysqli_num_rows($result_all) == 0) {
        echo "Something went wrong.";
    }

    $id = array();
    $k_id = array();
    $a_id = array();

    foreach ($result_all as $row) {
        array_push($id, $row['id']);
        array_push($k_id, $row['kos_id']);
        array_push($a_id, $row['aos_id']);
    }

    $status = $row['status'];
    $track_id = $row['track_id'];

    if ($status == 'rejected') {
        $sql_get_reject_reason = "SELECT reason FROM reject_reason WHERE track_id = '$track_id'";
        $result_get_reject_reason = mysqli_query($conn, $sql_get_reject_reason) or die(mysqli_error($conn));
        $row_get_reject_reason = mysqli_fetch_assoc($result_get_reject_reason);
        $reject_reason = $row_get_reject_reason['reason'];
    }
    ?>

    <main style="margin: 40px 5%;">
        <section class="dashboard_inner-head flex items-center">
            <h2 class="heading">Order Details</h2>
        </section>

        <?php
        if ($status == 'rejected') {
        ?>
            <p class="mt-20"><b>Reject reason : </b> <?php echo $reject_reason; ?></p>
        <?php
        }
        ?>

        <div>
            <table class="table_order-items mt-20">
                <tr class="shadow">
                    <th>SN</th>
                    <th>Image</th>
                    <th>Food Name</th>
                    <th>Quantity</th>
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
                        <td><?php echo $row['qty']; ?></td>
                    </tr>
                <?php
                }
                ?>
            </table>
            <p class="mt-20"><b>NOTE :</b> <?php echo $row['note']; ?></p>
        </div>

        <div class="vod_btns flex gap w-full p-20 mt-20">
            <?php if ($status != "rejected" && $status != "delivered") { ?>
                <div class="flex gap row-reverse">
                    <?php
                    if ($status == "pending") {
                    ?>
                        <form action="./backend/order/accept.php" method="post" class="flex items-center justify-start">
                            <input type="hidden" name="id" value='<?php echo base64_encode(serialize($id)); ?>'>
                            <input type="hidden" name="kos_id" value='<?php echo base64_encode(serialize($k_id)); ?>'>
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
                            <input type="hidden" name="kos_id" value='<?php echo base64_encode(serialize($k_id)); ?>'>
                            <input type="hidden" name="aos_id" value='<?php echo base64_encode(serialize($a_id)); ?>'>
                            <button type="submit" name="prepared" class="button no_outline border-curve">
                                <div class="flex items-center">
                                    <img src="../images/ic_prepared.svg" alt="prepared">
                                    <p class="body-text ml-5">Prepared</p>
                                </div>
                            </button>
                        </form>
                    <?php
                    } ?>
                </div>
                <?php if ($status == "pending" || $status == "accepted") { ?>
                    <form action="./backend/order/reject.php" method="post" class="flex reject_form items-center justify-start">
                        <input type="hidden" name="id" value='<?php echo base64_encode(serialize($id)); ?>'>
                        <input type="hidden" name="kos_id" value='<?php echo base64_encode(serialize($k_id)); ?>'>
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