<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details | RestroHub</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="icon" href="../images/logo.png">
    <script src="../js/admin.js" defer></script>
    <script src="./watch-dog.js" defer></script>
    <script src="./watch-status.js" defer></script>
</head>

<body>

    <?php
    require("./components/header.php");
    require("./components/sidebar.php");
    ?>

    <main class="admin_dashboard_body">

        <section class="dashboard_inner-head flex items-center">
            <h2>Current Order Details</h2>
            <img src="../images/ic_calender.svg" class="filter_by_date popper-btn" alt="filter">
        </section>

        <section class="modal items-center justify-center">
            <div class="modal_form-container p-20 small-modal shadow border-curve-md">

                <div class="modal_title-container flex items-center">
                    <h2 class="modal-title">Select an option</h2>
                    <button class="close-icon no_bg no_outline"><img src="../images/ic_cross.svg" alt="close"></button>
                </div>

                <form action="#" method="post" class="date_filter_modal_form">

                    <div class="date_filter_form_options flex justify-start items-center wrap">
                        <div class="flex justify-start items-center">
                            <input type="radio" name="filter_option" id="filter_option-today" checked>
                            <label for="filter_option-today"> &nbsp; Today</label>
                        </div>
                        <div class="flex justify-start items-center">
                            <input type="radio" name="filter_option" id="filter_option-yesterday">
                            <label for="filter_option-yesterday"> &nbsp; Yesterday</label>
                        </div>
                        <div class="flex justify-start items-center">
                            <input type="radio" name="filter_option" id="filter_option-last-week">
                            <label for="filter_option-last-week"> &nbsp; Last week</label>
                        </div>
                        <div class="flex justify-start items-center">
                            <input type="radio" name="filter_option" id="filter_option-last-month">
                            <label for="filter_option-last-month"> &nbsp; Last month</label>
                        </div>
                        <div class="flex justify-start items-center">
                            <input type="radio" name="filter_option" id="filter_option-custom">
                            <label for="filter_option-custom"> &nbsp; Custom</label>
                        </div>

                    </div>

                    <!-- filter using custom date range start -->
                    <div class="flex justify-evenly date_filter_form_option-custom">
                        <div class="flex direction-col">
                            <label for="start-date">From:</label>
                            <input type="date" name="start-date" id="start-date">
                        </div>
                        <div class="flex direction-col">
                            <label for="end-date">To:</label>
                            <input type="date" name="end-date" id="end-date">
                        </div>
                    </div>
                    <!-- filter using custom date range end -->
                    <button type="submit" class="no_outline border-curve-md w-full button mt-20">Filter</button>
                </form>
            </div>
        </section>

        <div class="flex items-center mt-20">
            <!-- buttons for order management -->
            <div class="flex items-center">

                <!-- search form for order -->
                <form action="#" method="post" class="search_form border-curve-lg">
                    <div class="flex items-center">
                        <input type="search" placeholder="Search..." class="no_outline search_employee" name="search-employee" id="search-employee">
                        <button type="submit" class="no_bg no_outline"><img src="../images/ic_search.svg" alt="search icon"></button>
                    </div>
                </form>

                <!-- filter by status -->
                <?php
                require("../config.php");

                $sql = "select id from orders where Date(date) = CURDATE() group by orders.c_id, orders.date";
                $result = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($result);

                $sql_pending = "select orders.id, aos.status from orders inner join aos on orders.id = aos.order_id where status = 'pending' and Date(orders.date) = CURDATE() group by orders.c_id, orders.date";
                $result_pending = mysqli_query($conn, $sql_pending);
                $count_pending = mysqli_num_rows($result_pending);

                $sql_accepted = "select orders.id, aos.status from orders inner join aos on orders.id = aos.order_id where status = 'accepted' and Date(orders.date) = CURDATE() group by orders.c_id, orders.date";
                $result_accepted = mysqli_query($conn, $sql_accepted);
                $count_accepted = mysqli_num_rows($result_accepted);

                $sql_to_deliver = "select orders.id, aos.status from orders inner join aos on orders.id = aos.order_id where status in ('prepared', 'delivering') and Date(orders.date) = CURDATE() group by orders.c_id, orders.date";
                $result_to_deliver = mysqli_query($conn, $sql_to_deliver);
                $count_to_deliver = mysqli_num_rows($result_to_deliver);

                $sql_delivered = "select orders.id, aos.status from orders inner join aos on orders.id = aos.order_id where status = 'delivered' and Date(orders.date) = CURDATE() group by orders.c_id, orders.date";
                $result_delivered = mysqli_query($conn, $sql_delivered);
                $count_delivered = mysqli_num_rows($result_delivered);

                $sql_rejected = "select orders.id, aos.status from orders inner join aos on orders.id = aos.order_id where status = 'rejected' and Date(orders.date) = CURDATE() group by orders.c_id, orders.date";
                $result_rejected = mysqli_query($conn, $sql_rejected);
                $count_rejected = mysqli_num_rows($result_rejected);

                ?>

                <form action="./backend/order/specific-order.php" method="post">
                    <input type="hidden" name="filter-by" value="all">
                    <button type="submit" name="specific-order" class="button ml-35 border-curve-lg relative <?php if (isset($_SESSION['filter-by']) && $_SESSION['filter-by'] == "all") echo "active"; ?>">All
                        <div class="count-top shadow"><?php
                                                        echo $count;
                                                        ?>
                        </div>
                    </button>
                </form>

                <form action="./backend/order/specific-order.php" method="post">
                    <input type="hidden" name="filter-by" value="pending">
                    <button type="submit" name="specific-order" class="button ml-35 border-curve-lg relative <?php if (isset($_SESSION['filter-by']) && $_SESSION['filter-by'] == "pending") echo "active"; ?>">Pending
                        <div class="count-top shadow"><?php
                                                        echo $count_pending;
                                                        ?>
                        </div>
                    </button>
                </form>

                <form action="./backend/order/specific-order.php" method="post">
                    <input type="hidden" name="filter-by" value="accepted">
                    <button type="submit" name="specific-order" class="button ml-35 border-curve-lg relative <?php if (isset($_SESSION['filter-by']) && $_SESSION['filter-by'] == "accepted") echo "active"; ?>">Accepted
                        <div class="count-top shadow"><?php
                                                        echo $count_accepted;
                                                        ?>
                        </div>
                    </button>
                </form>

                <form action="./backend/order/specific-order.php" method="post">
                    <input type="hidden" name="filter-by" value="prepared">
                    <button type="submit" name="specific-order" class="button ml-35 border-curve-lg relative <?php if (isset($_SESSION['filter-by']) && $_SESSION['filter-by'] == "prepared") echo "active"; ?>">To Deliver
                        <div class="count-top shadow"><?php
                                                        echo $count_to_deliver;
                                                        ?>
                        </div>
                    </button>
                </form>

                <form action="./backend/order/specific-order.php" method="post">
                    <input type="hidden" name="filter-by" value="delivered">
                    <button type="submit" name="specific-order" class="button ml-35 border-curve-lg relative <?php if (isset($_SESSION['filter-by']) && $_SESSION['filter-by'] == "delivered") echo "active"; ?>">Delivered
                        <div class="count-top shadow"><?php
                                                        echo $count_delivered;
                                                        ?>
                        </div>
                    </button>
                </form>

                <form action="./backend/order/specific-order.php" method="post">
                    <input type="hidden" name="filter-by" value="rejected">
                    <button type="submit" name="specific-order" class="button ml-35 border-curve-lg relative <?php if (isset($_SESSION['filter-by']) && $_SESSION['filter-by'] == "rejected") echo "active"; ?>">Rejected
                        <div class="count-top shadow"><?php
                                                        echo $count_rejected;
                                                        ?>
                        </div>
                    </button>
                </form>
            </div>
        </div>

        <?php
        if (isset($_SESSION['order-success-a'])) {
        ?>
            <p class="error-container success p_7-20">
                <?php
                echo $_SESSION['order-success-a'];
                unset($_SESSION['order-success-a']);
                ?>
            </p>
        <?php
        }
        if (isset($_SESSION['order-error-a'])) {
        ?>
            <p class="error-container error p_7-20">
                <?php
                echo $_SESSION['order-error-a'];
                unset($_SESSION['order-error-a']);
                ?>
            </p>
        <?php
        }
        ?>

        <?php
        // filter content by session 
        if (isset($_SESSION['filter-by']) && $_SESSION['filter-by'] != 'all' && $_SESSION['filter-by'] != "") {
            $filter_by = $_SESSION['filter-by'];
            if ($filter_by == 'delivering' || $filter_by == 'prepared') {

                $sql = "select count(orders.id) as total_item_bought,
                        orders.id,
                        orders.c_id,
                        orders.qty,
                        orders.track_id,
                        sum(orders.total_price) as total_price,
                        orders.note,
                        orders.date,
                        orders.f_id,
                        order_contact_details.address,
                        order_contact_details.phone,
                        order_contact_details.c_name,
                        aos.aos_id,
                        aos.status
                        from orders 
                        inner join order_contact_details on orders.o_c_id = order_contact_details.o_c_id
                        inner join aos on orders.id = aos.order_id
                        where aos.status in ('prepared', 'delivering') and
                        Date(orders.date) = CURDATE()
                        group by orders.date, orders.c_id
                        order by orders.id desc";
            } else {
                $sql =
                    "select count(orders.id) as total_item_bought,
                        orders.id,
                        orders.c_id,
                        orders.qty,
                        orders.track_id,
                        sum(orders.total_price) as total_price,
                        orders.note,
                        orders.date,
                        orders.f_id,
                        order_contact_details.address,
                        order_contact_details.phone,
                        order_contact_details.c_name,
                        aos.aos_id,
                        aos.status
                        from orders 
                        inner join order_contact_details on orders.o_c_id = order_contact_details.o_c_id
                        inner join aos on orders.id = aos.order_id
                        where aos.status = '$filter_by' and
                        Date(orders.date) = CURDATE()
                        group by orders.date, orders.c_id
                        order by orders.id desc";
            }
        } else {
            $sql = "select count(orders.id) as total_item_bought,
                    orders.id,
                    orders.c_id,
                    orders.qty,
                    orders.track_id,
                    sum(orders.total_price) as total_price,
                    orders.note,
                    orders.date,
                    orders.f_id,
                    order_contact_details.address,
                    order_contact_details.phone,
                    order_contact_details.c_name,
                    aos.aos_id,
                    aos.status
                    from orders 
                    inner join order_contact_details on orders.o_c_id = order_contact_details.o_c_id
                    inner join aos on orders.id = aos.order_id
                    where Date(orders.date) = CURDATE()
                    group by orders.date, orders.c_id
                    order by orders.id desc
                    ";
        }

        $result = mysqli_query($conn, $sql) or die("Query Failed");

        if (mysqli_num_rows($result) > 0) {
        ?>
            <table class="mt-20">
                <tr class="shadow">
                    <th>SN</th>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Location</th>
                    <th>Item</th>
                    <th>Amount</th>
                    <th>Order Status</th>
                </tr>

                <?php
                $i = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $i++;

                    $food_id = $row['f_id'];
                    $sql_food = "select name from food where f_id = {$food_id}";
                    $result_food = mysqli_query($conn, $sql_food) or die("Query Failed");
                    $row_food = mysqli_fetch_assoc($result_food);
                    $food_name = $row_food['name'];
                    $order_id = $row['id'];

                    $cid = $row['c_id'];
                    $id = $row['track_id'];

                    $status = $row['status'];

                    $sql_k_o_s = "select status from kos where order_id = {$order_id}";
                    $result_k_o_s = mysqli_query($conn, $sql_k_o_s) or die("Query Failed");

                    if (mysqli_num_rows($result_k_o_s) > 0) {
                        $data = mysqli_fetch_assoc($result_k_o_s);
                        $k_o_s = $data['status'];
                    }
                ?>
                    <tr class="shadow pointer" onclick="redirectToViewPage('<?php echo base64_encode(serialize($cid)); ?>', '<?php echo base64_encode(serialize($id)); ?>');">
                        <td><?php echo $i; ?></td>
                        <td>
                            <?php echo $row['track_id']; ?>
                        </td>
                        <td><?php echo $row['c_name']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td><?php echo $row['total_item_bought']; ?></td>
                        <td><?php echo $row['total_price']; ?></td>
                        <td><span class="<?php echo $row['status']; ?> border-curve-lg p_7-20"><?php echo $row['status']; ?></span></td>
                    </tr>
                <?php } ?>
            </table>
        <?php
        } else {
            echo "No Record Found";
        }
        ?>
    </main>

    <script src="./prevent-redirect-onclick-action.js"></script>
    <script>
        function redirectToViewPage(cid, id) {
            window.location = `./view-details.php?cid=${cid}&id=${id}`;
        }
    </script>

</body>

</html>