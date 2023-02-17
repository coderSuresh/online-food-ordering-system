<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details | RestroHub</title>
    <link rel="stylesheet" href="../styles/style.css">
    <script src="./watch-dog.js" defer></script>
    <script src="../js/admin.js" defer></script>
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

        <div class="flex items-center">
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

                $sql = "select id from orders where Date(date) = CURDATE()";
                $result = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($result);

                $sql_pending = "select orders.id, aos.status from orders inner join aos on orders.id = aos.order_id where status = 'pending' and Date(orders.date) = CURDATE()";
                $result_pending = mysqli_query($conn, $sql_pending);
                $count_pending = mysqli_num_rows($result_pending);

                $sql_accepted = "select orders.id, aos.status from orders inner join aos on orders.id = aos.order_id where status = 'accepted' and Date(orders.date) = CURDATE()";
                $result_accepted = mysqli_query($conn, $sql_accepted);
                $count_accepted = mysqli_num_rows($result_accepted);

                $sql_to_deliver = "select orders.id, aos.status from orders inner join aos on orders.id = aos.order_id where status = 'to deliver' and Date(orders.date) = CURDATE()";
                $result_to_deliver = mysqli_query($conn, $sql_to_deliver);
                $count_to_deliver = mysqli_num_rows($result_to_deliver);

                $sql_delivered = "select orders.id, aos.status from orders inner join aos on orders.id = aos.order_id where status = 'delivered' and Date(orders.date) = CURDATE()";
                $result_delivered = mysqli_query($conn, $sql_delivered);
                $count_delivered = mysqli_num_rows($result_delivered);

                $sql_rejected = "select orders.id, aos.status from orders inner join aos on orders.id = aos.order_id where status = 'rejected' and Date(orders.date) = CURDATE()";
                $result_rejected = mysqli_query($conn, $sql_rejected);
                $count_rejected = mysqli_num_rows($result_rejected);

                if (!isset($_SESSION['filter-by'])) {
                    $_SESSION['filter-by'] = "pending";
                }

                ?>

                <form action="./backend/order/specific-order.php" method="post">
                    <input type="hidden" name="filter-by" value="all">
                    <button type="submit" name="specific-order" class="button ml-35 border-curve-lg relative <?php if ($_SESSION['filter-by'] == "all") echo "active"; ?>">All
                        <div class="count-top shadow"><?php
                                                        echo $count;
                                                        ?>
                        </div>
                    </button>
                </form>

                <form action="./backend/order/specific-order.php" method="post">
                    <input type="hidden" name="filter-by" value="pending">
                    <button type="submit" name="specific-order" class="button ml-35 border-curve-lg relative <?php if ($_SESSION['filter-by'] == "pending") echo "active"; ?>">Pending
                        <div class="count-top shadow"><?php
                                                        echo $count_pending;
                                                        ?>
                        </div>
                    </button>
                </form>

                <form action="./backend/order/specific-order.php" method="post">
                    <input type="hidden" name="filter-by" value="accepted">
                    <button type="submit" name="specific-order" class="button ml-35 border-curve-lg relative <?php if ($_SESSION['filter-by'] == "accepted") echo "active"; ?>">Accepted
                        <div class="count-top shadow"><?php
                                                        echo $count_accepted;
                                                        ?>
                        </div>
                    </button>
                </form>

                <form action="./backend/order/specific-order.php" method="post">
                    <input type="hidden" name="filter-by" value="to deliver">
                    <button type="submit" name="specific-order" class="button ml-35 border-curve-lg relative <?php if ($_SESSION['filter-by'] == "to deliver") echo "active"; ?>">To Deliver
                        <div class="count-top shadow"><?php
                                                        echo $count_to_deliver;
                                                        ?>
                        </div>
                    </button>
                </form>

                <form action="./backend/order/specific-order.php" method="post">
                    <input type="hidden" name="filter-by" value="delivered">
                    <button type="submit" name="specific-order" class="button ml-35 border-curve-lg relative <?php if ($_SESSION['filter-by'] == "delivered") echo "active"; ?>">Delivered
                        <div class="count-top shadow"><?php
                                                        echo $count_delivered;
                                                        ?>
                        </div>
                    </button>
                </form>

                <form action="./backend/order/specific-order.php" method="post">
                    <input type="hidden" name="filter-by" value="rejected">
                    <button type="submit" name="specific-order" class="button ml-35 border-curve-lg relative <?php if ($_SESSION['filter-by'] == "rejected") echo "active"; ?>">Rejected
                        <div class="count-top shadow"><?php
                                                        echo $count_rejected;
                                                        ?>
                        </div>
                    </button>
                </form>
            </div>
        </div>

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

        <table class="mt-20 order-table">
            <!-- data from watch-dog.js -->
        </table>
    </main>

</body>

</html>