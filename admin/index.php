<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | RestroHub</title>
    <link rel="stylesheet" href="../styles/style.css">
    <script src="../js/admin.js" defer></script>
    <script src="./watch-dog.js" defer></script>
</head>

<body>

    <?php
    require("./components/header.php");
    require("./components/sidebar.php");
    ?>

    <main class="admin_dashboard_body">

        <section class="dashboard_inner-head flex items-center">
            <h2>Dashboard</h2>
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

        <div class="admin_dashboard_stat">

            <article class="card flex items-center text-center border-curve-md shadow">
                <img src="../images/ic_total-menu.svg" alt="total menu" aria-hidden="true" class="card_icon">
                <div>
                    <h2>15</h2>
                    <p>Total Menu</p>
                </div>
            </article>
            <article class="card flex items-center text-center border-curve-md shadow">
                <img src="../images/ic_total-revenue.svg" alt="total revenue" aria-hidden="true" class="card_icon">
                <div>
                    <h2>15K</h2>
                    <p>Total Revenue</p>
                </div>
            </article>
            <article class="card flex items-center text-center border-curve-md  shadow">
                <img src="../images/ic_total-order.svg" alt="total order" aria-hidden="true" class="card_icon">
                <div>
                    <h2>15</h2>
                    <p>Total Orders</p>
                </div>
            </article>
            <article class="card flex items-center text-center border-curve-md shadow">
                <img src="../images/ic_total-customer.svg" alt="total customer" aria-hidden="true" class="card_icon">
                <div>
                    <h2>15</h2>
                    <p>Total Customers</p>
                </div>
            </article>
            <article class="card flex items-center text-center border-curve-md shadow">
                <img src="../images/ic_total-category.svg" alt="total category" aria-hidden="true" class="card_icon">
                <div>
                    <h2>5</h2>
                    <p>Total Categories</p>
                </div>
            </article>
            <article class="card flex items-center text-center border-curve-md shadow">
                <img src="../images/ic_order-cancel.svg" alt="order cancel" aria-hidden="true" class="card_icon">
                <div>
                    <h2>3</h2>
                    <p>Order Canceled</p>
                </div>
            </article>

            <section class="top_selling p-20 flex direction-col shadow justify-start border-curve-md">
                <h2>Top selling items</h2>

                <article class="top_selling_item flex items-center">
                    <div class="top_selling_item_intro flex items-center">
                        <img class="top_selling_item_img" src="../images/food.png" alt="">
                        <div>
                            <h3 class="top_selling_item_name">Chinese MoMO</h3>
                            <p class="top_selling_item_sold">153 Items sold</p>
                        </div>
                    </div>

                    <p class="top_selling_item_price">Rs. 230</p>

                </article>

                <article class="top_selling_item flex items-center">
                    <div class="top_selling_item_intro flex items-center">
                        <img class="top_selling_item_img" src="../images/food.png" alt="">
                        <div>
                            <h3 class="top_selling_item_name">Chinese MoMO</h3>
                            <p class="top_selling_item_sold">153 Items sold</p>
                        </div>
                    </div>

                    <p class="top_selling_item_price">Rs. 230</p>

                </article>

                <article class="top_selling_item flex items-center">
                    <div class="top_selling_item_intro flex items-center">
                        <img class="top_selling_item_img" src="../images/food.png" alt="">
                        <div>
                            <h3 class="top_selling_item_name">Chinese MoMO</h3>
                            <p class="top_selling_item_sold">153 Items sold</p>
                        </div>
                    </div>

                    <p class="top_selling_item_price">Rs. 230</p>

                </article>

                <article class="top_selling_item flex items-center">
                    <div class="top_selling_item_intro flex items-center">
                        <img class="top_selling_item_img" src="../images/food.png" alt="">
                        <div>
                            <h3 class="top_selling_item_name">Chinese MoMO</h3>
                            <p class="top_selling_item_sold">153 Items sold</p>
                        </div>
                    </div>

                    <p class="top_selling_item_price">Rs. 230</p>

                </article>

                <article class="top_selling_item flex items-center">
                    <div class="top_selling_item_intro flex items-center">
                        <img class="top_selling_item_img" src="../images/food.png" alt="">
                        <div>
                            <h3 class="top_selling_item_name">Chinese MoMO</h3>
                            <p class="top_selling_item_sold">153 Items sold</p>
                        </div>
                    </div>

                    <p class="top_selling_item_price">Rs. 230</p>

                </article>
            </section>
        </div>
    </main>

</body>

</html>