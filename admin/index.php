<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | RestroHub</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="icon" href="../images/logo.png" type="image/png">
    <script src="../js/admin.js" defer></script>
    <script src="./watch-dog.js" defer></script>
    <script src="./watch-status.js" defer></script>
</head>

<body>
    <?php
    require '../config.php';
    require("./components/header.php");
    require("./components/sidebar.php");
    ?>

    <main class="admin_dashboard_body">

        <section class="dashboard_inner-head flex items-center">
            <h2 class="heading">Dashboard</h2>
            <img src="../images/ic_calender.svg" class="filter_by_date popper-btn" alt="filter">
        </section>

        <?php require "./components/filter.php"; ?>

        <p class="mt-20"><b>Filter :</b> <?php echo $filter_text; ?></p>
        <div class="admin_dashboard_stat mt-20">
            <article class="card flex items-center text-center border-curve-md shadow">
                <img src="../images/ic_total-menu.svg" alt="total menu" aria-hidden="true" class="card_icon">
                <div>
                    <h2><?php echo $count_food; ?></h2>
                    <p>Menu Items</p>
                </div>
            </article>
            <article class="card flex items-center text-center border-curve-md shadow">
                <img src="../images/ic_total-revenue.svg" alt="total revenue" aria-hidden="true" class="card_icon">
                <div>
                    <h2><?php echo $total_rev; ?></h2>
                    <p>Total Revenue</p>
                </div>
            </article>
            <article class="card flex items-center text-center border-curve-md  shadow">
                <img src="../images/ic_total-order.svg" alt="total order" aria-hidden="true" class="card_icon">
                <div>
                    <h2><?php echo $count_order; ?></h2>
                    <p>Total Orders</p>
                </div>
            </article>
            <article class="card flex items-center text-center border-curve-md shadow">
                <img src="../images/ic_total-customer.svg" alt="total customer" aria-hidden="true" class="card_icon">
                <div>
                    <h2><?php echo $count_customer; ?></h2>
                    <p>Total Customers</p>
                </div>
            </article>
            <article class="card flex items-center text-center border-curve-md shadow">
                <img src="../images/ic_total-category.svg" alt="total category" aria-hidden="true" class="card_icon">
                <div>
                    <h2><?php echo $count_cat; ?></h2>
                    <p>Total Categories</p>
                </div>
            </article>
            <article class="card flex items-center text-center border-curve-md shadow">
                <img src="../images/ic_order-cancel.svg" alt="order cancel" aria-hidden="true" class="card_icon">
                <div>
                    <h2><?php echo $count_order_canceled; ?></h2>
                    <p>Order Canceled</p>
                </div>
            </article>

            <section class="top_selling p-20 flex direction-col shadow justify-start border-curve-md">
                <h2 class="heading">Top selling items</h2>

                <?php
                $res_fetch_food = mysqli_query($conn, $sql_fetch_food);
                $count_fetch_food = mysqli_num_rows($res_fetch_food);
                $i = 0;
                while ($top_data = mysqli_fetch_assoc($res_fetch_food)) {
                    $i++;

                    $total_sold = $top_data['total_sold'];
                    $f_id = $top_data['f_id'];

                    $sql_food = "SELECT name, price, img FROM food where f_id = $f_id";
                    $res_food = mysqli_query($conn, $sql_food);
                    $row_food = mysqli_fetch_assoc($res_food);
                    $food_name = $row_food['name'];
                    $food_price = $row_food['price'];
                ?>
                    <article class="top_selling_item flex items-center">
                        <div class="top_selling_item_intro flex items-center">
                            <img class="top_selling_item_img" src="../uploads/foods/<?php echo $row_food['img']; ?>" alt="food image">
                            <div>
                                <h3 class="top_selling_item_name"><?php echo $food_name; ?></h3>
                                <p class="top_selling_item_sold"><?php echo $total_sold; ?> Items sold</p>
                            </div>
                        </div>
                        <div class="top_selling_item_price">
                            <p class="top_selling_item_price_text">Rs. <?php echo $food_price; ?></p>
                        </div>
                    </article>
                <?php
                } ?>

            </section>
        </div>
    </main>

</body>

</html>