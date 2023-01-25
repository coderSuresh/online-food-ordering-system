<?php
session_start();
if (!isset($_SESSION['admin-success'])) {
    header('location: ../invalid.html');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | RestroHub</title>
    <link rel="stylesheet" href="../styles/style.css">
    <script src="../js/admin.js" defer></script>
</head>

<body>

    <header>
        <nav class="top_nav flex items-center">
            <div class="flex items-center">
                <a href="#" class="logo heading flex items-center"><img src="../images/logo.png" alt="logo">Restro
                    <span>Hub</span>
                </a>

                <div class="menu__for-sidebar ml-35">
                    <div class="bar bar1"></div>
                    <div class="bar bar2"></div>
                    <div class="bar bar3"></div>
                </div>
            </div>

            <ul class="flex items-center">

                <li>
                    <a href="#">
                        <img src="../images/ic_dark_mode.svg" class="dark-mode-icon" alt="toggle night mode">
                    </a>

                </li>

                <li>
                    <img src="../images/profile.jpg" alt="admin profile picture" class="admin_profile_image">

                    <ul class="admin_profile p-20 shadow border-curve-md">
                        <li>
                            <div class="admin_profile_info flex items-center">
                                <img src="../images/profile.jpg" class="admin_profile_img" alt="admin profile picture" aria-hidden="true">
                                <div>
                                    <h4>Admin Kumar</h4>
                                    <p class="body-text">adminkumar@yandex.ru</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <hr class="no_outline">
                        </li>
                        <li>
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img class="admin_profile_icon" alt="manage account" src="../images/ic_manage_account.svg" aria-hidden="true">
                                    <p>Manage account</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
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

    <aside class="sidebar shadow cursor-pointer">

        <ul>
            <li class="sidebar_accordion">
                <a href="#">
                    <article class="dashboard_sidebar_content border-curve-lg flex items-center justify-center">
                        <div class="flex items-center justify-start">
                            <img class="dashboard_sidebar_content_img" src="../images/ic_dashboard.svg" alt="dashboard" aria-hidden="true">
                            <h4 class="dashboard_sidebar_content_text hide-on-close">Dashboard</h4>
                        </div>
                        <img src="../images/ic_accordion_arrow.svg" class="accordion_arrow hide-on-close" aria-hidden="true" alt="accordion arrow">
                    </article>
                </a>

                <ul class="sidebar_sub-menu p-20 shadow border-curve-md">
                    <li class="border-curve-lg">
                        <a href="./order-details.html">Order Details</a>
                    </li>
                    <li class="border-curve-lg">
                        <a href="#">Cutomer Details</a>
                    </li>
                    <li class="border-curve-lg">
                        <a href="#">Revenue Details</a>
                    </li>
                    <li class="border-curve-lg">
                        <a href="#">Reviews</a>
                    </li>
                </ul>

            </li>
            <li class="sidebar_accordion">
                <a href="#">
                    <article class="dashboard_sidebar_content border-curve-lg flex items-center justify-center">
                        <div class="flex items-center justify-start">
                            <img class="dashboard_sidebar_content_img" src="../images/ic_view.svg" alt="view" aria-hidden="true">
                            <h4 class="dashboard_sidebar_content_text hide-on-close">Food Items</h4>
                        </div>
                        <img src="../images/ic_accordion_arrow.svg" class="accordion_arrow hide-on-close" aria-hidden="true" alt="accordion arrow">
                    </article>
                </a>
            </li>
            <li class="sidebar_accordion">
                <a href="#">
                    <article class="dashboard_sidebar_content border-curve-lg flex items-center justify-center">
                        <div class="flex items-center justify-start">
                            <img class="dashboard_sidebar_content_img" src="../images/ic_category.svg" alt="category" aria-hidden="true">
                            <h4 class="dashboard_sidebar_content_text hide-on-close">Category</h4>
                        </div>
                        <img src="../images/ic_accordion_arrow.svg" class="accordion_arrow hide-on-close" aria-hidden="true" alt="accordion arrow">
                    </article>
                </a>
            </li>
            <li class="sidebar_accordion">
                <a href="#">
                    <article class="dashboard_sidebar_content border-curve-lg flex items-center justify-center">
                        <div class="flex items-center justify-start">
                            <img class="dashboard_sidebar_content_img" src="../images/ic_user_edit.svg" alt="edit user" aria-hidden="true">
                            <h4 class="dashboard_sidebar_content_text hide-on-close">Users</h4>
                        </div>
                        <img src="../images/ic_accordion_arrow.svg" class="accordion_arrow hide-on-close" aria-hidden="true" alt="accordion arrow">
                    </article>
                </a>
            </li>
        </ul>

    </aside>

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

                <form action="./backend/foods/add-food.php" method="post" class="date_filter_modal_form">

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