<?php
session_start();
if (!isset($_SESSION['delivery-success'])) {
    header("Location: ../invalid.html");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ashish Acharya, Bibek Mahat, Parask K. Bhandari, Suresh Dahal">
    <meta name="robots" content="noindex">
    <title>Delivery | RestroHub</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>

    <header>
        <nav class="top_nav flex items-center">
            <div class="logo__back-btn flex items-center">
                <a href="./index.php" class="logo heading flex items-center"><img src="../images/logo.png" alt="logo">Restro
                    <span>Hub</span>
                </a>
            </div>

            <h2 class="heading">Delivery Department</h2>

            <ul class="flex items-center">
                <li>
                    <img src="../images/profile.jpg" alt="admin profile picture" class="admin_profile_image">

                    <ul class="admin_profile p-20 shadow border-curve-md">
                        <li>
                            <a href="./backend/logout.php">
                                <div class="flex items-center justify-start">
                                    <img class="admin_profile_icon" src="../images/ic_logout.svg" alt="logout icon" aria-hidden="true">
                                    <p>Logout</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

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
        if (!isset($_SESSION['delivery-success'])) {
            header("Location: ../invalid.html");
        }
        ?>

        <main style="margin: 40px 5%;">

            <?php
            if (isset($_SESSION['order-success'])) {
            ?>
                <p class="error-container success p_7-20">
                    <?php
                    echo $_SESSION['order-success'];
                    unset($_SESSION['order-success']);
                    ?>
                </p>
            <?php
            }
            if (isset($_SESSION['order-error'])) {
            ?>
                <p class="error-container error p_7-20">
                    <?php
                    echo $_SESSION['order-error'];
                    unset($_SESSION['order-error']);
                    ?>
                </p>
            <?php
            }
            ?>

            <div class="flex items-center mt-20 justify-center">

                <!-- filter by status -->
                <?php

                // delete older orders
                $sql = "delete from to_be_delivered where Date(date) < DATE_SUB(NOW(), INTERVAL 1 DAY)";
                mysqli_query($conn, $sql) or die("Something went wrong");

                // TODO: fix this based on filters and status provided to the delivery person
                $sql_all = "select tbd_id as total from to_be_delivered";
                $result_all = mysqli_query($conn, $sql_all) or die("Query Failed");
                $data_all = mysqli_num_rows($result_all);

                $sql_pending = "select tbd_id as total from to_be_delivered where status = 'pending'";
                $result_pending = mysqli_query($conn, $sql_pending) or die("Query Failed");
                $data_pending = mysqli_num_rows($result_pending);

                $sql_accepted = "select tbd_id as total from to_be_delivered where status = 'accepted'";
                $result_accepted = mysqli_query($conn, $sql_accepted) or die("Query Failed");
                $data_accepted = mysqli_num_rows($result_accepted);

                $sql_rejected = "select tbd_id as total from to_be_delivered where status = 'rejected'";
                $result_rejected = mysqli_query($conn, $sql_rejected) or die("Query Failed");
                $data_rejected = mysqli_num_rows($result_rejected);

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

                <!-- search form for order in case someone is calling delivery staff and asking if he has their order -->
                <form action="#" method="post" class="search_form relative border-curve-lg" style="margin-left: 35px !important">
                    <div class="flex items-center">
                        <input type="search" placeholder="Search..." class="no_outline search_order" name="search-order" id="search-order">
                        <button type="submit" class="no_bg no_outline"><img src="../images/ic_search.svg" alt="search icon"></button>
                    </div>
                </form>

            </div>

            <!-- food cards -->
            <?php
            if (isset($_SESSION['filter-by']) && $_SESSION['filter-by'] != 'all') {
                $filter_by = $_SESSION['filter-by'];
                $sql = "select orders.id,
                    orders.c_id,
                    orders.qty,
                    orders.total_price,
                    orders.note,
                    orders.date,
                    orders.f_id,
                    order_contact_details.address,
                    order_contact_details.phone,
                    order_contact_details.c_name,
                    to_be_delivered.tbd_id,
                    to_be_delivered.status,
                    aos.aos_id
                    from orders 
                    inner join order_contact_details on orders.id = order_contact_details.o_id
                    inner join to_be_delivered on orders.id = to_be_delivered.order_id
                    inner join aos on orders.id = aos.order_id
                    where to_be_delivered.status = '{$filter_by}'
                    order by orders.id desc
                    ";
                unset($_SESSION['filter-by']);
            } else {
                $sql = "select orders.id,
                    orders.c_id,
                    orders.qty,
                    orders.total_price,
                    orders.note,
                    orders.date,
                    orders.f_id,
                    order_contact_details.address,
                    order_contact_details.phone,
                    order_contact_details.c_name,
                    to_be_delivered.tbd_id,
                    to_be_delivered.status,
                    aos.aos_id
                    from orders 
                    inner join order_contact_details on orders.id = order_contact_details.o_id
                    inner join to_be_delivered on orders.id = to_be_delivered.order_id
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
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Customer Name</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Order Status</th>
                    <th>Action</th>
                </tr>
                <?php
                $i = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $i++;
                    $sql_food_name = "Select name from food where f_id ={$row['f_id']}";
                    $res_food_name = mysqli_query($conn, $sql_food_name);
                    $data_food_name = mysqli_fetch_assoc($res_food_name);

                    $address = $row["address"];
                    $phone = $row["phone"];

                    $status = $row["status"];
                    $quantity = $row["qty"];
                ?>
                    <tr class="shadow">
                        <td><?php echo $i; ?> </td>
                        <td><?php echo $data_food_name["name"]; ?> </td>
                        <td><?php echo $quantity; ?> </td>
                        <td><?php echo $row["total_price"]; ?> </td>
                        <td><?php echo $row["c_name"]; ?> </td>
                        <td><?php echo $address; ?> </td>
                        <td><?php echo $phone; ?> </td>
                        <td><span class="<?php echo $status ?> border-curve-lg p_7-20"><?php echo $status; ?></span></td>

                        <td class="table_action_container">
                            <!-- action menu -->
                            <button class="no_bg no_outline table_option-menu">
                                <img src="../images//ic_options.svg" alt="options menu">
                            </button>
                            <!-- options -->
                            <?php if ($status != "rejected" && $status != "prepared") { ?>
                                <div class="table_action_options shadow border-curve p-20 r_80 flex direction-col">
                                    <div>
                                        <?php
                                        if ($status == "pending") {
                                        ?>
                                            <form action="./backend/order/accept.php" method="post" class="flex items-center justify-start">
                                                <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                                                <input type="hidden" name="tbd_id" value="<?php echo $row["tbd_id"]; ?>">
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
                                                <input type="hidden" name="tbd_id" value="<?php echo $row["tbd_id"]; ?>">
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
                                        <?php if ($status == "pending" || $status == "accepted") { ?>
                                            <form action="./backend/order/reject.php" method="post" class="flex reject_form items-center justify-start">
                                                <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                                                <input type="hidden" name="tbd_id" value="<?php echo $row["tbd_id"]; ?>">
                                                <input type="hidden" name="aos_id" value="<?php echo $row["aos_id"]; ?>">
                                                <input type="hidden" class="hidden-reject_reason" name="reject-reason" value="">
                                            </form>
                                            <div class="flex items-center justify-start">
                                                <button type="submit" name="reject" class="no_bg no_outline reject_btn">
                                                    <div class="flex items-center justify-start">
                                                        <img src="../images/ic_reject.svg" alt="reject icon">
                                                        <p class="body-text">Reject</p>
                                                    </div>
                                                </button>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>

                <?php
                }
                ?>



            </table>
        </main>
    </body>

    </html>