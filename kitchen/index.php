<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders | RestroHub</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../styles/style.css">
    <script src="../js/admin.js" defer></script>
    <script src="./watch-dog.js" defer></script>
</head>

<body>

    <?php
    require("../config.php");
    require("./components/header.php");
    ?>

    <main style="margin: 40px 5%;">

        <?php
        if (isset($_SESSION['order-success-k'])) {
        ?>
            <p class="error-container success p_7-20">
                <?php
                echo $_SESSION['order-success-k'];
                unset($_SESSION['order-success-k']);
                ?>
            </p>
        <?php
        }
        if (isset($_SESSION['order-error-k'])) {
        ?>
            <p class="error-container error p_7-20">
                <?php
                echo $_SESSION['order-error-k'];
                unset($_SESSION['order-error-k']);
                ?>
            </p>
        <?php
        }
        ?>

        <div class="flex items-center mt-20 justify-center">
            <!-- filter by status -->
            <?php

            // delete older orders
            $sql = "delete from kos where Date(date) < DATE_SUB(NOW(), INTERVAL 1 DAY)";
            mysqli_query($conn, $sql) or die("Something went wrong");

            $sql_all = "select kos_id as total from kos";
            $result_all = mysqli_query($conn, $sql_all) or die("Query Failed");
            $data_all = mysqli_num_rows($result_all);

            $sql_pending = "select kos_id as total from kos where status = 'pending'";
            $result_pending = mysqli_query($conn, $sql_pending) or die("Query Failed");
            $data_pending = mysqli_num_rows($result_pending);

            $sql_accepted = "select kos_id as total from kos where status = 'accepted'";
            $result_accepted = mysqli_query($conn, $sql_accepted) or die("Query Failed");
            $data_accepted = mysqli_num_rows($result_accepted);

            $sql_rejected = "select kos_id as total from kos where status = 'rejected'";
            $result_rejected = mysqli_query($conn, $sql_rejected) or die("Query Failed");
            $data_rejected = mysqli_num_rows($result_rejected);

            $sql_prepared = "select kos_id as total from kos where status = 'prepared'";
            $result_prepared = mysqli_query($conn, $sql_prepared) or die("Query Failed");
            $data_prepared = mysqli_num_rows($result_prepared);

            if (!isset($_SESSION['filter-by'])) {
                $_SESSION['filter-by'] = "pending";
            }

            ?>

            <form action="./backend/order/specific-order.php" method="post">
                <input type="hidden" name="filter-by" value="all">
                <button type="submit" name="specific-order" class="button border-curve-lg relative filter <?php if ($_SESSION['filter-by'] == "all") echo "active"; ?>">All
                    <div class="count-top shadow"><?php
                                                    echo $data_all;
                                                    ?>
                    </div>
                </button>
            </form>

            <form action="./backend/order/specific-order.php" method="post">
                <input type="hidden" name="filter-by" value="pending">
                <button type="submit" name="specific-order" class="button ml-35 border-curve-lg relative filter <?php if ($_SESSION['filter-by'] == "pending") echo "active"; ?>">Pending
                    <div class="count-top shadow"><?php
                                                    echo $data_pending;
                                                    ?>
                    </div>
                </button>
            </form>

            <form action="./backend/order/specific-order.php" method="post">
                <input type="hidden" name="filter-by" value="accepted">
                <button type="submit" name="specific-order" class="button ml-35 border-curve-lg relative filter <?php if ($_SESSION['filter-by'] == "accepted") echo "active"; ?>">Accepted
                    <div class="count-top shadow"><?php
                                                    echo $data_accepted;
                                                    ?>
                    </div>
                </button>
            </form>

            <form action="./backend/order/specific-order.php" method="post">
                <input type="hidden" name="filter-by" value="rejected">
                <button type="submit" name="specific-order" class="button ml-35 border-curve-lg relative filter <?php if ($_SESSION['filter-by'] == "rejected") echo "active"; ?>">Rejected
                    <div class="count-top shadow"><?php
                                                    echo $data_rejected;
                                                    ?>
                    </div>
                </button>
            </form>

            <form action="./backend/order/specific-order.php" method="post">
                <input type="hidden" name="filter-by" value="prepared">
                <button type="submit" name="specific-order" class="button ml-35 border-curve-lg relative filter <?php if ($_SESSION['filter-by'] == "prepared") echo "active"; ?>">Prepared
                    <div class="count-top shadow"><?php
                                                    echo $data_prepared;
                                                    ?>
                    </div>
                </button>
            </form>
        </div>

        <?php
        // TODO: show appropriate information only
        if (isset($_SESSION['filter-by']) && $_SESSION['filter-by'] != 'all') {
            $filter_by = $_SESSION['filter-by'];
            $sql = "select count(orders.id) as total_item_bought,
                    orders.id,
                    orders.c_id,
                    orders.qty,
                    orders.track_id,
                    sum(orders.total_price) as total_price,
                    orders.note,
                    orders.f_id,
                    order_contact_details.address,
                    order_contact_details.phone,
                    order_contact_details.c_name,
                    kos.kos_id,
                    kos.status
                    from orders 
                    inner join order_contact_details on orders.o_c_id = order_contact_details.o_c_id
                    inner join kos on orders.id = kos.order_id
                    where (Date(orders.date) = CURDATE()
                    or Date(kos.date) = CURDATE())
                    group by orders.date, orders.c_id
                    order by orders.id desc
                    ";
            unset($_SESSION['filter-by']);
        } else {
            $sql = "select orders.id,
                    orders.c_id,
                    orders.qty,
                    orders.note,
                    orders.f_id,
                    orders.track_id,
                    kos.kos_id,
                    kos.status,
                    aos.aos_id
                    from orders 
                    inner join kos on orders.id = kos.order_id
                    inner join aos on orders.id = aos.order_id
                    order by orders.id desc
                    ";
            if (isset($_SESSION['filter-by']))
                unset($_SESSION['filter-by']);
        }

        $result = mysqli_query($conn, $sql) or die("Query Failed");
        ?>
        <table class="mt-20">
            <tr class="shadow">
                <th>SN</th>
                <th>Track ID</th>
                <th>Total Items</th>
                <th>Note</th>
                <th>Order Status</th>
            </tr>
            <?php
            $i = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $i++;
                $sql_food_name = "Select name from food where f_id ={$row['f_id']}";
                $res_food_name = mysqli_query($conn, $sql_food_name);
                $data_food_name = mysqli_fetch_assoc($res_food_name);

                $status = $row["status"];
                $quantity = $row["total_item_bought"];
                $note = $row["note"];
                $id = $row["track_id"];
                $cid = $row["c_id"];
            ?>
                <tr class="shadow pointer" onclick="redirectToViewPage('<?php echo base64_encode(serialize($cid)); ?>', '<?php echo base64_encode(serialize($id)); ?>');">
                    <td><?php echo $i; ?> </td>
                    <td><?php echo $id; ?> </td>
                    <td><?php echo $quantity; ?> </td>
                    <td><?php echo $note; ?> </td>
                    <td><span class="<?php echo $status ?> border-curve-lg p_7-20"><?php echo $status; ?></span></td>
                </tr>
            <?php
            }
            ?>
        </table>
    </main>

    <script src="../admin/prevent-redirect-onclick-action.js"></script>
    <script>
        function redirectToViewPage(cid, id) {
            window.location = `./view-details.php?cid=${cid}&id=${id}`;
        }
    </script>

</body>

</html>