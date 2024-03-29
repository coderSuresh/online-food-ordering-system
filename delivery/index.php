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
    <link rel="stylesheet" href="../styles/responsive.css">
    <script src="../js/admin.js" defer></script>
    <script src="./watch-dog.js" defer></script>
</head>

<body>

    <?php
    require '../config.php';
    require './components/header.php'
    ?>

    <main style="margin: 40px 5%;">

        <?php
        if (isset($_SESSION['deliver-success'])) {
        ?>
            <p class="error-container success p_7-20">
                <?php
                echo $_SESSION['deliver-success'];
                unset($_SESSION['deliver-success']);
                ?>
            </p>
        <?php
        }
        if (isset($_SESSION['deliver-error'])) {
        ?>
            <p class="error-container error p_7-20">
                <?php
                echo $_SESSION['deliver-error'];
                unset($_SESSION['deliver-error']);
                ?>
            </p>
        <?php
        }
        ?>

        <div class="flex items-center mt-20 scroll">

            <!-- filter by status -->
            <?php

            // delete older orders
            $sql = "delete from to_be_delivered where Date(date) < DATE_SUB(NOW(), INTERVAL 1 DAY)";
            mysqli_query($conn, $sql) or die("Something went wrong");

            $sql_all = "select tbd_id from to_be_delivered inner join orders on to_be_delivered.order_id  = orders.id group by orders.c_id, orders.date";
            $result_all = mysqli_query($conn, $sql_all) or die("Query Failed");
            $data_all = mysqli_num_rows($result_all);

            $sql_pending = "select tbd_id from to_be_delivered inner join orders on to_be_delivered.order_id = orders.id where status = 'pending' group by orders.c_id, orders.date";
            $result_pending = mysqli_query($conn, $sql_pending) or die("Query Failed");
            $data_pending = mysqli_num_rows($result_pending);

            $sql_delivered = "select tbd_id from to_be_delivered inner join orders on to_be_delivered.order_id = orders.id where status = 'delivered' group by orders.c_id, orders.date";
            $result_delivered  = mysqli_query($conn, $sql_delivered) or die("Query Failed");
            $data_delivered = mysqli_num_rows($result_delivered);

            $sql_rejected = "select tbd_id from to_be_delivered inner join orders on to_be_delivered.order_id = orders.id where status = 'rejected' group by orders.c_id, orders.date";
            $result_rejected = mysqli_query($conn, $sql_rejected) or die("Query Failed");
            $data_rejected = mysqli_num_rows($result_rejected);

            if (!isset($_GET['filter']) && !isset($_GET['search'])) {
                $_GET['filter'] = "pending";
            }

            ?>

            <a href="?filter=all" class="ml-35">
                <button class="button border-curve-lg relative <?php if (isset($_GET['filter']) && $_GET['filter'] == "all") echo "active"; ?>">All
                    <div class="count-top shadow"><?php
                                                    echo $data_all;
                                                    ?>
                    </div>
                </button>
            </a>

            <a href="?filter=pending" class="ml-35">
                <button class="button border-curve-lg relative <?php if (isset($_GET['filter']) && $_GET['filter'] == "pending") echo "active"; ?>">Pending
                    <div class="count-top shadow"><?php
                                                    echo $data_pending;
                                                    ?>
                    </div>
                </button>
            </a>

            <a href="?filter=delivered" class="ml-35">
                <button class="button border-curve-lg relative <?php if (isset($_GET['filter']) && $_GET['filter'] == "delivered") echo "active"; ?>">Delivered
                    <div class="count-top shadow"><?php
                                                    echo $data_delivered;
                                                    ?>
                    </div>
                </button>
            </a>

            <a href="?filter=rejected" class="ml-35">
                <button class="button border-curve-lg relative <?php if (isset($_GET['filter']) && $_GET['filter'] == "rejected") echo "active"; ?>">Rejected
                    <div class="count-top shadow"><?php
                                                    echo $data_rejected;
                                                    ?>
                    </div>
                </button>
            </a>

            <!-- search form for order in case someone is calling delivery staff and asking if he has their order -->
            <form action="./index.php" method="get" class="search_form relative border-curve-lg" style="margin-left: 35px !important">
                <div class="flex items-center">
                    <input type="search" placeholder="Search..." class="no_outline search_order" name="search" id="search-order">
                    <button type="submit" class="no_bg no_outline"><img src="../images/ic_search.svg" alt="search icon"></button>
                </div>
            </form>

        </div>

        <?php

        $sql_base = "select count(orders.id) as total_item_bought,
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
                    to_be_delivered.tbd_id,
                    to_be_delivered.status,
                    aos.aos_id
                    from orders 
                    inner join order_contact_details on orders.o_c_id = order_contact_details.o_c_id
                    inner join to_be_delivered on orders.id = to_be_delivered.order_id
                    inner join aos on orders.id = aos.order_id";

        if (isset($_GET['filter']) && $_GET['filter'] != 'all') {
            $filter_by = $_GET['filter'];
            $sql = $sql_base . "
                    where to_be_delivered.status = '{$filter_by}'
                    group by orders.c_id, orders.date
                    order by orders.id desc
                    ";
            unset($_GET['filter']);
        } elseif (isset($_GET['search'])) {
            $search_key = mysqli_real_escape_string($conn, $_GET['search']);
            $sql = $sql_base . "
                    where orders.track_id like '%{$search_key}%'
                    or order_contact_details.c_name like '{$search_key}%'
                    or order_contact_details.phone like '%{$search_key}%'
                    group by orders.c_id, orders.date
                    order by orders.id desc
                    ";
        } else {
            $sql = $sql_base . "
                    group by orders.c_id, orders.date
                    order by orders.id desc
                    ";
            if (isset($_GET['filter']))
                unset($_GET['filter']);
        }

        $result = mysqli_query($conn, $sql) or die("Query Failed");

        if (mysqli_num_rows($result) > 0) {
        ?>
            <div class="scroll">
                <table class="mt-20">
                    <tr class="shadow">
                        <th>SN</th>
                        <th>Track ID</th>
                        <th>Customer Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Order Status</th>
                    </tr>
                    <?php
                    $i = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $i++;

                        $address = $row["address"];
                        $phone = $row["phone"];

                        $status = $row["status"];
                        $quantity = $row["qty"];

                        $cid = $row["c_id"];
                        $id = $row["track_id"];
                    ?>
                        <tr class="shadow pointer" onclick="redirectToViewPage('<?php echo base64_encode(serialize($cid)); ?>', '<?php echo base64_encode(serialize($id)); ?>');">
                            <td><?php echo $i; ?> </td>
                            <td><?php echo $row["track_id"]; ?> </td>
                            <td><?php echo $row["c_name"]; ?> </td>
                            <td><?php echo $address; ?> </td>
                            <td><?php echo $phone; ?> </td>
                            <td><?php echo $row['total_item_bought']; ?> </td>
                            <td><?php echo $row["total_price"]; ?> </td>
                            <td><span class="<?php echo $status ?> border-curve-lg p_7-20"><?php echo $status; ?></span></td>
                        </tr>

                    <?php
                    }
                } else {
                    ?>
                    <p class="mt-20 text-center">No records found</p>
                <?php
                }
                ?>
                </table>
            </div>
    </main>
    <script>
        function redirectToViewPage(cid, id) {
            window.location = `./view-details.php?cid=${cid}&id=${id}`;
        }
    </script>
</body>

</html>