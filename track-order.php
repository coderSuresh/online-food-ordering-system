<?php
if (isset($_SESSION['order_placed'])) {
    echo $_SESSION['order_placed'];
    unset($_SESSION['order_placed']);
} else if (isset($_SESSION['order_success'])) {
    unset($_SESSION['order_success']);
}
?>

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
    <title>Track Order | RestroHub</title>
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
            <h1 class="heading">Track Order</h1>
            <form action="./track-order.php" method="get" class="search_form border-curve-lg">
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
        // order history
        $sql = "SELECT SUM(orders.total_price) AS total_price,
                       orders.track_id,
                       SUM(orders.qty) AS qty,
                       orders.date,
                       aos.status
                       FROM orders
                       INNER JOIN food ON orders.f_id = food.f_id
                       INNER JOIN aos ON orders.id = aos.order_id
                       WHERE orders.c_id = $user_id
                       AND aos.status IN ('delivered', 'rejected')
                       GROUP BY orders.track_id
                       ORDER BY orders.id DESC";
        $result = mysqli_query($conn, $sql);

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $track_id = mysqli_real_escape_string($conn, $_GET['id']);
            // searched order
            $sql = "SELECT food.img,
                               food.name,
                               orders.total_price,
                               orders.qty,
                               orders.date,
                               aos.status,
                               future_orders.status AS future_status
                               FROM orders
                               INNER JOIN food ON orders.f_id = food.f_id
                               LEFT JOIN aos ON orders.id = aos.order_id
                               LEFT JOIN future_orders on orders.id = future_orders.order_id
                               WHERE orders.track_id = '$track_id' AND 
                               orders.c_id = $user_id
                               GROUP BY orders.track_id
                               ORDER BY orders.id DESC";
            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res) > 0) {
        ?>
                <div class="flex items-center justify-start w-fit mt-20">
                    <h4>Order ID: <?php echo $track_id; ?></h4>
                    <button class="no_bg no_outline ml-35">
                        <a href="./track-order.php">
                            <img src="./images/ic_cross.svg" alt="clear" width="15">
                        </a>
                    </button>
                </div>
                <div class="table">
                    <table class="mt-20">
                        <tr class="shadow">
                            <th>SN</th>
                            <th>Image</th>
                            <th>Date</th>
                            <th>Food</th>
                            <th>Price with VAT</th>
                            <th>Qty</th>
                            <th>Status</th>
                        </tr>
                        <?php
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($res)) {
                            $img = $row['img'];
                            $name = $row['name'];
                            $price = $row['total_price'];
                            $qty = $row['qty'];
                            $status = $row['status'] ? $row['status'] : $row['future_status'];
                            $date = $row['date'];
                        ?>
                            <tr class="shadow">
                                <td> <?php echo $i++; ?></td>
                                <td><img src="./uploads/foods/<?php echo $img; ?>" alt="food" width="80" class="table_food-img"></td>
                                <td><?php echo $date; ?></td>
                                <td><?php echo $name; ?></td>
                                <td><?php echo $price; ?></td>
                                <td><?php echo $qty; ?></td>
                                <td><?php echo $status; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>

            <?php } else {
            ?>
                <!-- no orders -->
                <section class="p-20 mt-40 border-curve w-fit flex direction-col justify-center items-center ml-auto">
                    <h2 class="text-center" style="letter-spacing: 2px">NO ORDER IN PROCESS</h2>
                    <img src="./images/empty.png" alt="empty" width="300" class="empty_box ml-auto">
                    <p class="text-center mt-20">You don't have any order in process.</p>
                </section>
            <?php }
        } else {
            // current order
            $sql_current_order = "SELECT SUM(orders.total_price) AS total_price,
                                        orders.track_id,
                                        SUM(orders.qty) AS qty,
                                        orders.date,
                                        aos.status,
                                        future_orders.status AS future_status
                                        FROM orders
                                        INNER JOIN food ON orders.f_id = food.f_id
                                        LEFT JOIN aos ON orders.id = aos.order_id
                                        LEFT JOIN future_orders on orders.id = future_orders.order_id
                                        WHERE aos.status NOT IN ('delivered', 'rejected')
                                        OR future_orders.status IN ('pending', 'accepted')
                                        AND orders.c_id = $user_id
                                        GROUP BY orders.track_id
                                        ORDER BY orders.id DESC";

            $result_current_order = mysqli_query($conn, $sql_current_order);

            if (mysqli_num_rows($result_current_order) > 0) {
            ?>
                <div class="w-fit">
                    <h3 class="mt-40">Orders in process</h3>
                    <hr class="underline">
                </div>
                <?php
                $i = 1;
                while ($row = mysqli_fetch_assoc($result_current_order)) {
                    $track_id = $row['track_id'];
                    $total_price = $row['total_price'];
                    $qty = $row['qty'];
                    $status = $row['status'] ? $row['status'] : $row['future_status'];
                    $date = $row['date'];

                    $sql_foods_in_current_order = "SELECT food.img,
                                                          food.name,
                                                          orders.total_price,
                                                          orders.qty,
                                                          orders.date,
                                                          aos.status,
                                                          future_orders.status AS future_status
                                                          FROM orders
                                                          INNER JOIN food ON orders.f_id = food.f_id
                                                          LEFT JOIN aos ON orders.id = aos.order_id
                                                          LEFT JOIN future_orders on orders.id = future_orders.order_id
                                                          WHERE orders.track_id = '$track_id' AND 
                                                          orders.c_id = $user_id
                                                          
                                                          ORDER BY orders.id DESC";

                    $res = mysqli_query($conn, $sql_foods_in_current_order);
                ?>
                    <h4 class="mt-20">Order ID: <?php echo $track_id; ?></h4>

                    <?php
                    if (mysqli_num_rows($res) > 0) {
                    ?>

                        <!-- make order tracking icons or something here -->
                        <div class="table">
                            <table class="mt-20">
                                <tr class="shadow">
                                    <th>SN</th>
                                    <th>Image</th>
                                    <th>Date</th>
                                    <th>Food</th>
                                    <th>Price with VAT</th>
                                    <th>Qty</th>
                                    <th>Status</th>
                                </tr>

                                <?php $i = 1;
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $img = $row['img'];
                                    $name = $row['name'];
                                    $price = $row['total_price'];
                                    $qty = $row['qty'];
                                    $status = $row['status'] ? $row['status'] : $row['future_status'];
                                    $date = $row['date'];
                                ?>

                                    <tr class="shadow">
                                        <td><?php echo $i++; ?></td>
                                        <td>
                                            <img src="./uploads/foods/<?php echo $img; ?>" alt="food image" width="80" class="table_food-img">
                                        </td>
                                        <td><?php echo $date; ?></td>
                                        <td><?php echo $name; ?></td>
                                        <td><?php echo $price; ?></td>
                                        <td><?php echo $qty; ?></td>
                                        <td><?php echo $status; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                <?php
                    }
                }
            } else {
                ?>
                <!-- no orders -->
                <section class="p-20 mt-40 border-curve w-fit flex direction-col justify-center items-center ml-auto">
                    <h2 class="text-center" style="letter-spacing: 2px">NO ORDER IN PROCESS</h2>
                    <img src="./images/empty.png" alt="empty" width="300" class="empty_box ml-auto">
                    <p class="text-center mt-20">You don't have any order in process.</p>
                </section>
            <?php }
        }
        if (mysqli_num_rows($result) > 0) {
            ?>

            <h3 class="mt-40">Order History</h3>
            <div class="table">
                <table class="mt-20">
                    <tr class="shadow">
                        <th>SN</th>
                        <th>Date</th>
                        <th>Order ID</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $date = $row['date'];
                        $track_id = $row['track_id'];
                        $price = $row['total_price'];
                        $status = $row['status'];
                    ?>
                        <tr class="shadow">
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $date; ?></td>
                            <td><?php echo $track_id; ?></td>
                            <td><?php echo $price; ?></td>
                            <td><?php echo $status; ?></td>
                            <td><a href="?id=<?php echo $track_id; ?>" class="button gray border-curve">View Details</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        <?php
        } ?>

        <?php require './components/top-selling-food.php'; ?>

    </main>

    <?php require("./components/footer.php"); ?>
    <script type="module" src="./js/app.js"></script>
</body>

</html>