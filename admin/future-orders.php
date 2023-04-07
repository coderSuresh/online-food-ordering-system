<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Future Orders| RestroHub</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="icon" href="../images/logo.png">
    <script src="../js/admin.js" defer></script>
    <script src="./watch-dog.js" defer></script>
    <script src="./watch-status.js" defer></script>
</head>

<body>

    <?php
    require '../config.php';
    require './components/header.php';
    require './components/sidebar.php';
    ?>

    <main class="admin_dashboard_body">

        <?php
        if (isset($_SESSION['order-success-fo'])) {
        ?>
            <p class="error-container success p_7-20">
                <?php
                echo $_SESSION['order-success-fo'];
                unset($_SESSION['order-success-fo']);
                ?>
            </p>
        <?php
        }
        if (isset($_SESSION['order-error-fo'])) {
        ?>
            <p class="error-container error p_7-20">
                <?php
                echo $_SESSION['order-error-fo'];
                unset($_SESSION['order-error-fo']);
                ?>
            </p>
        <?php
        }
        ?>

        <section class="dashboard_inner-head flex items-center">
            <h2>Future Order Details</h2>
        </section>

        <div class="flex items-center mt-20">

            <div class="flex items-center">
                <!-- search form for order -->
                <form action="./future-orders.php" method="get" class="search_form border-curve-lg">
                    <div class="flex items-center">
                        <input type="search" placeholder="Search..." class="no_outline" name="search">
                        <button type="submit" class="no_bg no_outline"><img src="../images/ic_search.svg" alt="search icon"></button>
                    </div>
                </form>

                <?php
                // TODO: maybe filter date wise orders such as for later on today, tomorrow, after 2 days, after 3 days etc.

                $sql = "select future_orders.fo_id
                               from orders
                               inner join future_orders on orders.id = future_orders.order_id
                               group by orders.c_id, orders.date";
                $result = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($result);
                ?>

                <form action="#" method="post">
                    <input type="hidden" name="filter-by" value="all">
                    <button type="submit" name="specific-order" class="button ml-35 border-curve-lg relative">All
                        <div class="count-top shadow"><?php
                                                        echo $count;
                                                        ?>
                        </div>
                    </button>
                </form>
            </div>
        </div>

        <?php
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
                        future_orders.fo_id,
                        future_orders.status
                        from orders 
                        inner join order_contact_details on orders.o_c_id = order_contact_details.o_c_id
                        inner join future_orders on orders.id = future_orders.order_id
                        group by orders.date, orders.c_id
                        order by orders.id desc";

        if (isset($_GET['search'])) {
            $search = $_GET['search'];
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
                        future_orders.fo_id,
                        future_orders.status
                        from orders 
                        inner join order_contact_details on orders.o_c_id = order_contact_details.o_c_id
                        inner join future_orders on orders.id = future_orders.order_id
                        where (orders.track_id like '%{$search}%' or order_contact_details.c_name like '%{$search}%')
                        group by orders.date, orders.c_id
                        order by orders.id desc";
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
            echo "<p class='mt-20'>No Record Found</p>";
        }
        ?>
    </main>

    <script src="./prevent-redirect-onclick-action.js"></script>
    <script>
        function redirectToViewPage(cid, id) {
            window.location = `./future-details.php?cid=${cid}&id=${id}`;
        }
    </script>

</body>

</html>