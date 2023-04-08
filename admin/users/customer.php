<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details | RestroHub</title>
    <link rel="stylesheet" href="../../styles/style.css">
    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">
    <script src="../../js/admin.js" defer></script>
    <script src="../watch-dog.js" defer></script>
    <script src="../watch-status.js" defer></script>

</head>

<body>
    <?php
    require("./components/header.php");
    require("./components/sidebar.php");
    require("../../config.php");
    ?>

    <main class="admin_dashboard_body">
        <?php
        if (isset($_SESSION['block-success'])) {
        ?>
            <!-- to show error alert -->
            <p class="error-container success p_7-20">
                <?php
                echo $_SESSION['block-success'];
                unset($_SESSION['block-success']);
                ?>
            </p>
        <?php
        }
        ?>
        <?php
        if (isset($_SESSION['block-error'])) {
        ?>
            <!-- to show error alert -->
            <p class="error-container error p_7-20">
                <?php
                echo $_SESSION['block-error'];
                unset($_SESSION['block-error']);
                ?>
            </p>
        <?php
        }
        ?>
        <?php
        if (isset($_SESSION['unblock-success'])) {
        ?>
            <!-- to show error alert -->
            <p class="error-container success p_7-20">
                <?php
                echo $_SESSION['unblock-success'];
                unset($_SESSION['unblock-success']);
                ?>
            </p>
        <?php
        }
        ?>
        <?php
        if (isset($_SESSION['unblock-error'])) {
        ?>
            <!-- to show error alert -->
            <p class="error-container error p_7-20">
                <?php
                echo $_SESSION['unblock-error'];
                unset($_SESSION['unblock-error']);
                ?>
            </p>
        <?php
        }
        ?>
        <section class="dashboard_inner-head flex items-center">
            <h2>Customer Details</h2>
            <img src="../../images/ic_calender.svg" class="filter_by_date popper-btn" alt="filter">
        </section>

        <div class="flex items-center mt-20">
            <div class="flex items-center">

                <form action="./customer.php" method="get" class="search_form border-curve-lg">
                    <div class="flex items-center">
                        <input type="search" placeholder="Search..." class="no_outline" name="search">
                        <button type="submit" class="no_bg no_outline"><img src="../../images/ic_search.svg" alt="search icon"></button>
                    </div>
                </form>

                <!-- filter customers through buttons -->
                <?php
                $sql_all = "SELECT names,username,email,date,status FROM customer";
                $result_all = mysqli_query($conn, $sql_all);
                $count = mysqli_num_rows($result_all);

                $sql_active = "SELECT names,username,email,date,status FROM customer WHERE active = 1";
                $result_active = mysqli_query($conn, $sql_active);
                $count_active = mysqli_num_rows($result_active);

                $sql_inactive = "SELECT names,username,email,date,status FROM customer WHERE active = 0";
                $result_inactive = mysqli_query($conn, $sql_inactive);
                $count_inactive = mysqli_num_rows($result_inactive);

                $sql_verified = "SELECT names,username,email,date,status FROM customer WHERE status = 'verified'";
                $result_verified = mysqli_query($conn, $sql_verified);
                $count_verified = mysqli_num_rows($result_verified);

                $sql_not_verified = "SELECT names,username,email,date,status FROM customer WHERE status = 'not verified'";
                $result_not_verified = mysqli_query($conn, $sql_not_verified);
                $count_not_verified = mysqli_num_rows($result_not_verified);

                // require filter by date component
                $whichPage = "customer";
                require '../components/filter.php';
                $sql_date_filter = isset($sql_temp_cus) ? $sql_temp_cus : "";
                ?>

                <a href="?filter-by=all" class="ml-35">
                    <button type="submit" name="specific-users" class="button border-curve relative <?php if (isset($_GET['filter-by']) && $_GET['filter-by'] == 'all')
                                                                                                        echo "active"; ?>">All
                        <div class="count-top rect shadow"><?php
                                                            echo $count;
                                                            ?>
                        </div>
                    </button>
                </a>

                <a href="?filter-by=active" class="ml-35">
                    <button type="submit" name="specific-users" class="button border-curve relative <?php if (isset($_GET['filter-by']) && $_GET['filter-by'] == 'active')
                                                                                                        echo "active"; ?>">Active
                        <div class="count-top rect shadow"><?php
                                                            echo $count_active;
                                                            ?>
                        </div>
                    </button>
                </a>

                <a href="?filter-by=inactive" class="ml-35">
                    <button type="submit" name="specific-users" class="button border-curve relative <?php if (isset($_GET['filter-by']) && $_GET['filter-by'] == 'inactive')
                                                                                                        echo "active"; ?>">Inactive
                        <div class="count-top rect shadow"><?php
                                                            echo $count_inactive;
                                                            ?>
                        </div>
                    </button>
                </a>

                <a href="?filter-by=verified" class="ml-35">
                    <button type="submit" name="specific-users" class="button border-curve relative <?php if (isset($_GET['filter-by']) && $_GET['filter-by'] == 'verified')
                                                                                                        echo "active"; ?>">Verified
                        <div class="count-top rect shadow"><?php
                                                            echo $count_verified;
                                                            ?>
                        </div>
                    </button>
                </a>

                <a href="?filter-by=not-verified" class="ml-35">
                    <button type="submit" name="specific-users" class="button border-curve relative <?php if (isset($_GET['filter-by']) && $_GET['filter-by'] == 'not-verified')
                                                                                                        echo "active"; ?>">Not Verified
                        <div class="count-top rect shadow"><?php
                                                            echo $count_not_verified;
                                                            ?>
                        </div>
                    </button>
                </a>

            </div>
        </div>

        <?php
        // filter by session
        $sql_cus = "SELECT id, names,username,email,date,status,active FROM customer";

        if (isset($_GET['filter-by'])) {
            $filter_by = mysqli_real_escape_string($conn, $_GET['filter-by']);
            if ($filter_by == 'all') {
                $sql_cus = "SELECT id, names,username,email,date,status,active FROM customer";
            } else if ($filter_by == 'active') {
                $sql_cus = "SELECT id, names,username,email,date,status,active FROM customer WHERE active = 1";
            } else if ($filter_by == 'inactive') {
                $sql_cus = "SELECT id, names,username,email,date,status,active FROM customer WHERE active = 0";
            } else if ($filter_by == 'verified') {
                $sql_cus = "SELECT id, names,username,email,date,status,active FROM customer WHERE status = 'verified'";
            } else if ($filter_by == 'not-verified') {
                $sql_cus = "SELECT id, names,username,email,date,status,active FROM customer WHERE status = 'not verified'";
            }
        } else {
            $sql_cus = "SELECT id, names,username,email,date,status,active FROM customer";
        }

        $sql_all = "SELECT id, names,username,email,date,status,active FROM customer";

        // search
        if (isset($_GET['search'])) {
            $search = mysqli_real_escape_string($conn, $_GET['search']);
            $sql_cus = "SELECT id, names,username,email,date,status,active FROM customer WHERE names LIKE '%$search%' OR username LIKE '%$search%' OR email LIKE '%$search%'";
        }

        if (isset($sql_date_filter) && !empty($sql_date_filter) && $sql_date_filter != $sql_all) {
            $sql_cus = $sql_date_filter;
        }

        $count = mysqli_num_rows(mysqli_query($conn, $sql_cus));

        $limit = 10;
        require '../components/calculate-offset.php';

        $sql_cus .= " LIMIT $limit OFFSET $offset";

        if (isset($filter_text)) {
            echo "<h4 class='mt-20'>Filter : " . $filter_text . "</h4>";
        }

        $result = mysqli_query($conn, $sql_cus) or die(mysqli_error($conn));

        if (mysqli_num_rows($result) > 0) {
        ?>
            <table class="mt-20">
                <tr class="shadow">
                    <th>SN</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Item</th>
                    <th>Email</th>
                    <th>Joined On</th>
                    <th>Action</th>
                </tr>

                <?php
                $i = $offset;
                while ($row = mysqli_fetch_assoc($result)) {
                    $i++;
                    $isActive = $row['active'] == 1 ? "Active" : "Inactive";
                    $id = $row['id'];

                    // find number of items bought
                    $sql_item_bought = "select count(orders.id) as total
                                        from orders
                                        inner join aos on orders.id = aos.order_id
                                        where aos.status = 'delivered' and
                                        orders.c_id = $id
                                        group by orders.c_id";

                    $res_item_bought = mysqli_query($conn, $sql_item_bought);
                    $row_item_bought = mysqli_fetch_assoc($res_item_bought);

                    $item_bought = 0;

                    if (mysqli_num_rows($res_item_bought) > 0) {
                        $item_bought = $row_item_bought['total'];
                    }
                ?>
                    <tr class="shadow">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['names']; ?></td>
                        <td><?php echo $row['status'] . " | " . $isActive; ?></td>
                        <td><?php echo $item_bought; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td class="table_action_container">
                            <!-- action menu -->
                            <button class="no_bg no_outline table_option-menu">
                                <img src="../../images//ic_options.svg" alt="options menu">
                            </button>
                            <!-- options -->
                            <div class="table_action_options shadow border-curve p-20 r_70 flex direction-col">
                                <?php
                                if ($row['active'] == 1) {
                                ?>
                                    <form action="./backend/block.php" method="post">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <div class="flex items-center justify-start">
                                            <img src="../../images/ic_disable.svg" alt="activate">
                                            <button type="submit" name="block" class="no_bg no_outline" style="font-size: 1rem;">Block</button>
                                        </div>
                                    </form>
                                <?php
                                } else {
                                ?>
                                    <form action="./backend/enable.php" method="post">

                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <div class="flex items-center justify-start">
                                            <img src="../../images/ic_enable.svg" alt="activate">
                                            <button type="submit" name="activate" class="no_bg no_outline" style="font-size: 1rem;">Activate</button>
                                        </div>
                                    </form>
                                <?php
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>
        <?php
            $isForSearch = isset($_GET['search']);
            require '../components/pagination.php';
        } else {
            echo "<p class='text-center mt-20'>No data found</p>";
        }
        ?>
    </main>

</body>

</html>