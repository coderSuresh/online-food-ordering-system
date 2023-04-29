<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Are you hungry? You are at the right place. We offer mouth watering foods at your doorstep. Click now and order food online.">
    <meta name="author" content="Ashish Acharya, Bibek Mahat, Parask K. Bhandari, Suresh Dahal">
    <meta name="theme-color" content="#F7922F">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
    <title>Order Details | RestroHub</title>
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/responsive.css">
</head>

<body>

    <?php
    require './config.php';
    require './components/header.php'; ?>

    <main class="track_order_body">

        <button class="go_top no_bg no_outline"><img src="./images/ic_top.svg" alt="go to top"></button>

        <section class="flex items-center gap wrap">
            <h1 class="heading">Order Details</h1>
            <form action="./order-details.php" method="get" class="search_form border-curve-lg">
                <div class="flex items-center">
                    <input type="search" placeholder="Track ID..." class="no_outline search" name="id" id="order-search">
                    <button type="submit" class="no_bg no_outline"><img src="./images/ic_search.svg" alt="search icon"></button>
                </div>
            </form>
        </section>

        <?php
        $user_id = 0;
        if (isset($_SESSION['user'])) {
            $user_id = $_SESSION['user'];
        }

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $track_id = mysqli_real_escape_string($conn, $_GET['id']);
            // searched order
            $sql = "SELECT food.img,
                               food.name,
                               food.price,
                               orders.total_price,
                               orders.qty,
                               orders.date,
                               orders.note,
                               orders.payment_method,
                               customer.email,
                               aos.status,
                               future_orders.status AS future_status,
                               order_contact_details.c_name,
                               order_contact_details.phone AS c_phone,
                               order_contact_details.address AS c_address
                               FROM orders
                               INNER JOIN food ON orders.f_id = food.f_id
                               LEFT JOIN aos ON orders.id = aos.order_id
                               LEFT JOIN future_orders ON orders.id = future_orders.order_id
                               INNER JOIN order_contact_details ON orders.o_c_id = order_contact_details.o_c_id
                               INNER JOIN customer ON orders.c_id = customer.id
                               WHERE orders.track_id = '$track_id' AND 
                               orders.c_id = $user_id
                               ORDER BY orders.id DESC";
            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res) > 0) {
                $data = mysqli_fetch_assoc($res);
                $status = $data['status'] ? $data['status'] : $data['future_status'];

                mysqli_data_seek($res, 0); // reset the pointer
        ?>
                <div class="shadow p-40 border-curve mt-20">
                    <div class="flex items-center gap wrap">
                        <div>
                            <h4 class="yellow-text">Order ID : <?php echo $track_id; ?></h4>
                            <p>Placed On : <?php echo $data['date']; ?></p>
                        </div>
                    </div>

                    <div class="tracking_icons flex items-center mt-40 justify-center">
                        <?php
                        require './components/tracking-icons.php';
                        ?>
                    </div>

                    <?php
                    // show reject reason
                    if ($status == 'rejected') {
                        $sql_get_reject_reason = "SELECT reason, rejected_by FROM reject_reason WHERE track_id = '$track_id'";
                        $result_reject_reason = mysqli_query($conn, $sql_get_reject_reason);
                        $row_reject_reason = mysqli_fetch_assoc($result_reject_reason);
                        $reject_reason = $row_reject_reason['reason'];
                        $rejected_by = $row_reject_reason['rejected_by'];
                    ?>
                        <div class="mt-40 text-center">
                            <h4 class="mt-20">Reject reason: <?php echo $reject_reason; ?></h4>
                            <p class="mt-10">Rejected by: <?php echo $rejected_by; ?></p>

                        </div>
                    <?php
                    }
                    ?>

                    <div class="mt-20 table">
                        <table>
                            <tr class="shadow">
                                <th>SN</th>
                                <th>Image</th>
                                <th>Food</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>

                            <?php
                            $sn = 1;
                            $subtotal = 0;
                            while ($row = mysqli_fetch_assoc($res)) {
                                $subtotal += $row['price'] * $row['qty'];
                            ?>
                                <tr class="shadow">
                                    <td><?php echo $sn++; ?></td>
                                    <td><img src="./uploads/foods/<?php echo $row['img'] ?>" alt="food image" class="table_food-img"></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td>Rs. <?php echo $row['price']; ?></td>
                                    <td><?php echo $row['qty']; ?></td>
                                    <td>Rs. <?php echo $row['qty'] * $row['price']; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>

                    <?php
                    mysqli_data_seek($res, 0);
                    $row = mysqli_fetch_assoc($res);
                    ?>

                    <div class="flex delivery_and_payment_info mt-20 gap wrap">
                        <div>
                            <h4 class="yellow-text">Delivery Information</h4>
                            <p class="mt-10"><b>Name : </b> <?php echo $row['c_name']; ?></p>
                            <p class="mt-10"><b>Phone : </b> <?php echo $row['c_phone']; ?></p>
                            <p class="mt-10"><b>Email : </b> <?php echo $row['email']; ?></p>
                            <p class="mt-10"><b>Address : </b> <?php echo $row['c_address']; ?></p>
                            <p class="mt-10"><b>Note : </b> <?php echo $row['note']; ?></p>
                        </div>

                        <div>
                            <h4 class="yellow-text">Payment Information</h4>
                            <p class="mt-10"><b>Payment Method : </b> <?php echo $data['payment_method'] == "COD" ? "Cash on Delivery" : $data['payment_method']; ?></p>
                            <p class="mt-10"><b>Subtotal : </b> Rs. <?php echo $subtotal; ?></p>
                            <p class="mt-10"><b>VAT (13%) : </b> Rs. <?php echo $vat = intval($subtotal * 0.13); ?></p>
                            <p class="mt-10"><b>Total : </b> Rs. <?php echo $subtotal + $vat; ?></p>
                        </div>
                    </div>

                </div>
            <?php
            } else {
                echo "<h3 class='mt-20 text-center'>No order found</h3>";
            }
        } else {
            ?>
            <!-- no orders -->
            <section class="p-20 mt-40 border-curve w-fit flex direction-col justify-center items-center ml-auto">
                <h2 class="text-center" style="letter-spacing: 2px">NO ORDER IN PROCESS</h2>
                <img src="./images/empty.png" alt="empty" width="300" class="empty_box ml-auto">
                <p class="text-center mt-20">You don't have any order in process.</p>
            </section>
        <?php
        }
        ?>
        <?php require './components/top-selling-food.php'; ?>

    </main>

    <?php require("./components/footer.php"); ?>
    <script type="module" src="./js/app.js"></script>
</body>

</html>