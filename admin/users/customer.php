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

        <section class="modal items-center justify-center">
            <div class="modal_form-container p-20 small-modal shadow border-curve-md">

                <div class="modal_title-container flex items-center">
                    <h2 class="modal-title">Select an option</h2>
                    <button class="close-icon no_bg no_outline"><img src="../../images/ic_cross.svg" alt="close"></button>
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

        <div class="flex items-center mt-20">
            <div class="flex items-center">

                <form action="#" method="post" class="search_form border-curve-lg">
                    <div class="flex items-center">
                        <input type="search" placeholder="Search..." class="no_outline search_employee" name="search-employee" id="search-employee">
                        <button type="submit" class="no_bg no_outline"><img src="../../images/ic_search.svg" alt="search icon"></button>
                    </div>
                </form>

                <!-- filter customers through buttons -->
                <?php
                $sql_all = "SELECT names,username,email,date,status FROM customer";
                $result_all = mysqli_query($conn, $sql_all);
                $count_all = mysqli_num_rows($result_all);

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
                ?>

                <form action="./backend/specific-users.php" method="post">
                    <input type="hidden" name="filter-by" value="all">
                    <button type="submit" name="specific-users" class="button ml-35 border-curve-lg relative">All
                        <div class="count-top shadow"><?php
                                                        echo $count_all;
                                                        ?>
                        </div>
                </form>

                <form action="./backend/specific-users.php" method="post">
                    <input type="hidden" name="filter-by" value="active">
                    <button type="submit" name="specific-users" class="button ml-35 border-curve-lg relative">Active
                        <div class="count-top shadow"><?php
                                                        echo $count_active;
                                                        ?>
                        </div>
                </form>

                <form action="./backend/specific-users.php" method="post">
                    <input type="hidden" name="filter-by" value="inactive">
                    <button type="submit" name="specific-users" class="button ml-35 border-curve-lg relative">Inactive
                        <div class="count-top shadow"><?php
                                                        echo $count_inactive;
                                                        ?>
                        </div>
                </form>

                <form action="./backend/specific-users.php" method="post">
                    <input type="hidden" name="filter-by" value="verified">
                    <button type="submit" name="specific-users" class="button ml-35 border-curve-lg relative">Verified
                        <div class="count-top shadow"><?php
                                                        echo $count_verified;
                                                        ?>
                        </div>
                </form>

                <form action="./backend/specific-users.php" method="post">
                    <input type="hidden" name="filter-by" value="not verified">
                    <button type="submit" name="specific-users" class="button ml-35 border-curve-lg relative">Not verified
                        <div class="count-top shadow"><?php
                                                        echo $count_not_verified;
                                                        ?>
                        </div>
                </form>

            </div>
        </div>

        <?php
        require("../../config.php");

        // filter by session
        $sql = "SELECT id,names,username,email,date,status,active FROM customer";

        if (isset($_SESSION['filter-by'])) {
            $filter_by = $_SESSION['filter-by'];
            if ($filter_by == 'all') {
                $sql = "SELECT id,names,username,email,date,status,active FROM customer";
            } else if ($filter_by == 'active') {
                $sql = "SELECT id,names,username,email,date,status,active FROM customer WHERE active = 1";
            } else if ($filter_by == 'inactive') {
                $sql = "SELECT id,names,username,email,date,status,active FROM customer WHERE active = 0";
            } else if ($filter_by == 'verified') {
                $sql = "SELECT id,names,username,email,date,status,active FROM customer WHERE status = 'verified'";
            } else if ($filter_by == 'not verified') {
                $sql = "SELECT id,names,username,email,date,status,active FROM customer WHERE status = 'not verified'";
            }
        } else {
            $sql = "SELECT id,names,username,email,date,status,active FROM customer";
        }

        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if (mysqli_num_rows($result) > 0) {
        ?>
            <table class="mt-20">
                <tr class="shadow">
                    <th>SN</th>
                    <th>Image</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Item</th>
                    <th>Email</th>
                    <th>Joined On</th>
                    <th>Action</th>
                </tr>

                <?php
                $i = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $i++;
                    $isActive = $row['active'] == 1 ? "Active" : "Inactive";
                    $id = $row['id'];
                ?>
                    <tr class="shadow">
                        <td><?php echo $i; ?></td>
                        <td>
                            <img src="../../images/logo.png" class="table_food-img">
                        </td>
                        <td><?php echo $row['names']; ?></td>
                        <td><?php echo $row['status'] . " | " . $isActive; ?></td>
                        <td>60</td>
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
        } else {
            echo "No data found";
        }
        ?>
    </main>

</body>

</html>