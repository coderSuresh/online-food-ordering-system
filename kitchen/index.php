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
</head>

<body>

    <?php
    require("../config.php");
    require("./components/header.php");
    require("./components/sidebar.php");
    ?>

    <main class="admin_dashboard_body">

        <section class="dashboard_inner-head flex items-center">
            <h2>Order Details</h2>
        </section>

        <div class="flex items-center">
            <!-- buttons for order management -->
            <div class="flex items-center">

                <!-- search form for orders -->
                <form action="#" method="post" class="search_form border-curve-lg">
                    <div class="flex items-center">
                        <input type="search" placeholder="Search..." class="no_outline search_employee" name="search-employee" id="search-employee">
                        <button type="submit" class="no_bg no_outline"><img src="../images/ic_search.svg" alt="search icon"></button>
                    </div>
                </form>

                <!-- filter by status -->

                <?php

                $sql_all = "select kos_id as total from kos";
                $result_all = mysqli_query($conn, $sql_all) or die("Query Failed");
                $data_all = mysqli_num_rows($result_all);

                $sql_pending = "select kos_id as total from kos where status = 'pending'";
                $result_pending = mysqli_query($conn, $sql_pending) or die("Query Failed");
                $data_pending = mysqli_num_rows($result_pending);

                $sql_accepted = "select kos_id as total from kos where status = 'accepted'";
                $result_accepted = mysqli_query($conn, $sql_accepted) or die("Query Failed");
                $data_accepted = mysqli_num_rows($result_accepted);
                ?>

                <form action="./backend/order/specific-order.php" method="post">
                    <input type="hidden" name="filter-by" value="all">
                    <button type="submit" name="specific-order" class="button ml-35 border-curve-lg relative">All
                        <div class="count-top shadow"><?php
                                                        echo $data_all;
                                                        ?>
                        </div>
                    </button>
                </form>

                <form action="./backend/order/specific-order.php" method="post">
                    <input type="hidden" name="filter-by" value="pending">
                    <button type="submit" name="specific-order" class="button ml-35 border-curve-lg relative">Pending
                        <div class="count-top shadow"><?php
                                                        echo $data_pending;
                                                        ?>
                        </div>
                    </button>
                </form>

                <form action="./backend/order/specific-order.php" method="post">
                    <input type="hidden" name="filter-by" value="accepted">
                    <button type="submit" name="specific-order" class="button ml-35 border-curve-lg relative">Accepted
                        <div class="count-top shadow"><?php
                                                        echo $data_accepted;
                                                        ?>
                        </div>
                    </button>
                </form>
            </div>
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
                    kos.kos_id,
                    kos.status
                    from orders 
                    inner join order_contact_details on orders.id = order_contact_details.o_id
                    inner join kos on orders.id = kos.order_id
                    where kos.status = '{$filter_by}'
                    order by orders.id desc
                    ";
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
                    kos.kos_id,
                    kos.status
                    from orders 
                    inner join order_contact_details on orders.id = order_contact_details.o_id
                    inner join kos on orders.id = kos.order_id
                    order by orders.id desc
                    ";
        }

        $result = mysqli_query($conn, $sql) or die("Query Failed");
        ?>
        <table class="mt-20">
            <tr class="shadow">
                <th>SN</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Note</th>
                <th>Order Status</th>
                <th>Action</th>
            </tr>
            <tr class="shadow">
                <?php

                $i = 0;
                while ($data = mysqli_fetch_assoc($result)) {
                    $i++;
                    $sql_food_name = "Select name from food where f_id ={$data['f_id']}";
                    $res_food_name = mysqli_query($conn, $sql_food_name);
                    $data_food_name = mysqli_fetch_assoc($res_food_name);

                    $status = $data["status"];
                    $quantity = $data["qty"];
                    $note = $data["note"];
                ?>
            <tr class="shadow">
                <td><?php echo $i; ?> </td>
                <td><?php echo $data_food_name["name"]; ?> </td>
                <td><?php echo $quantity; ?> </td>
                <td><?php echo $note; ?> </td>
                <td><span class="<?php echo $status ?> border-curve-lg p_7-20"><?php echo $status; ?></span></td>

                <td class="table_action_container">
                    <!-- action menu -->
                    <button class="no_bg no_outline table_option-menu">
                        <img src="../images//ic_options.svg" alt="options menu">
                    </button>
                    <!-- options -->
                    <?php if ($status != "rejected") { ?>
                        <div class="table_action_options shadow border-curve p-20 r_80 flex direction-col">
                            <div>
                                <?php
                                if ($status == "pending") {
                                ?>
                                    <form action="./backend/order/accept.php" method="post" class="flex items-center justify-start">
                                        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                                        <input type="hidden" name="aos_id" value="<?php echo $row["kos_id"]; ?>">
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
                                        <input type="hidden" name="aos_id" value="<?php echo $row["kos_id"]; ?>">
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
            </tr>

        <?php
                }
        ?>



        </table>
    </main>
</body>

</html>