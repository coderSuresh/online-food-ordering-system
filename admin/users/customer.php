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
                $sql_temp_cus = '';
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

            <div class="filter">
                <form action="./filter-customer.php" method="post" class="filter-form" style="margin: 0 !important">
                    <select name="customer-filter" class="p_7-20 border-curve" id="customer-filter">
                        <option value="name" <?php if (isset($_SESSION['customer-filter']) && $_SESSION['customer-filter'] == "order by customer.names asc") echo "selected" ?>>Sort by name</option>
                        <option value="most-selling" <?php if (isset($_SESSION['customer-filter']) && $_SESSION['customer-filter'] == "order by item_bought desc") echo "selected" ?>>Most buying</option>
                        <option value="least-selling" <?php if (isset($_SESSION['customer-filter']) && $_SESSION['customer-filter'] == "order by item_bought asc") echo "selected" ?>>Least buying</option>
                        <option value="last-added" <?php if (isset($_SESSION['customer-filter']) && $_SESSION['customer-filter'] == "order by customer.id desc")
                                                        echo "selected";
                                                    if (!isset($_SESSION['customer-filter']))
                                                        echo "selected"; ?>>Last added</option>
                        <option value="first-added" <?php if (isset($_SESSION['customer-filter']) && $_SESSION['customer-filter'] == "order by customer.id asc") echo "selected" ?>>First added</option>
                    </select>
                </form>
            </div>
        </div>
        <?php
        $sql_base = "SELECT customer.id,
                customer.names,
                customer.status,
                COALESCE(COUNT(orders.f_id * orders.qty), 0) as item_bought,
                customer.email,
                customer.date,
                customer.active
            FROM customer
            LEFT JOIN orders ON orders.c_id = customer.id
            LEFT JOIN aos ON orders.id = aos.order_id
           
        ";

        if (isset($_SESSION["customer-filter"])) {
            $filter = $_SESSION["customer-filter"];
            $sql_cus = $sql_base . " WHERE aos.status = 'delivered' OR aos.status IS NULL
                    GROUP By customer.id" . " $filter";
            unset($_SESSION['cat-filter']);
        } else {
            $sql_cus = $sql_base . " WHERE aos.status = 'delivered' OR aos.status IS NULL
                    GROUP By customer.id";
        }

        // filter by session
        if (isset($_GET['filter-by'])) {
            $filter_by = mysqli_real_escape_string($conn, $_GET['filter-by']);
            if ($filter_by == 'all') {
                $sql_cus = $sql_base . " WHERE aos.status = 'delivered' OR aos.status IS NULL
                    GROUP By customer.id";
            } else if ($filter_by == 'active') {
                $sql_cus =  $sql_base . " WHERE customer.active = 1 AND (aos.status = 'delivered' OR aos.status IS NULL) GROUP By customer.id";
            } else if ($filter_by == 'inactive') {
                $sql_cus = $sql_base . " WHERE customer.active = 0 AND (aos.status = 'delivered' OR aos.status IS NULL) GROUP By customer.id";
            } else if ($filter_by == 'verified') {
                $sql_cus = $sql_base . " WHERE customer.status = 'verified' AND (aos.status = 'delivered' OR aos.status IS NULL) GROUP By customer.id";
            } else if ($filter_by == 'not-verified') {
                $sql_cus = $sql_base . " WHERE customer.status = 'not verified'AND (aos.status = 'delivered' OR aos.status IS NULL) GROUP By customer.id";
            }
        }

        if (isset($_GET['search'])) {
            $search = mysqli_real_escape_string($conn, $_GET['search']);
            $sql_cus = $sql_base . " WHERE names LIKE '%$search%' OR username LIKE '%$search%' OR email LIKE '%$search%' AND (aos.status = 'delivered' OR aos.status IS NULL
                ) GROUP By customer.id";
        }
        $limit = 10;
        require '../components/calculate-offset.php';
        $sql_cus .= " LIMIT $limit OFFSET $offset";
        if (isset($filter_text)) {
            echo "<h4 class='mt-20'>Filter : " . $filter_text . "</h4>";
        }

        if (isset($sql_date_filter) && !empty($sql_date_filter) && $sql_date_filter != $sql_all) {
            $sql_cus_df = $sql_base . $sql_date_filter;
            $count = mysqli_num_rows(mysqli_query($conn, $sql_cus_df));
            $result = mysqli_query($conn, $sql_cus_df) or die(mysqli_error($conn));
             
        } else {
            $count_query = mysqli_query($conn, $sql_cus) or die(mysqli_error($conn));
            $count = mysqli_num_rows($count_query);
            $result = mysqli_query($conn, $sql_cus) or die(mysqli_error($conn));
        }
        
        if (mysqli_num_rows($result) > 0)  {
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
                    $item_bought = $row['item_bought'];
                ?>
                    <tr class="shadow">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['names']; ?></td>
                        <td><?php echo $row['status'] . " | " . $isActive; ?></td>
                        <td><?php echo $row['item_bought']; ?></td>
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
    <script>
        const fForm = document.querySelector('.filter-form')
        fForm.addEventListener('change', () => {
            fForm.submit()
        });
    </script>
</body>

</html>