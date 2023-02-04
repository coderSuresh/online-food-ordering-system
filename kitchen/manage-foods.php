<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Foods | RestroHub</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../styles/style.css">
    <script src="../js/admin.js" defer></script>
</head>

<body>

    <?php
    require("../config.php");
    require("./components/header.php");
    require("./components/sidebar.php");
    ?>

    <main class="admin_dashboard_body">

        <section class="dashboard_inner-head flex items-center">
            <h2>Manage Food Items</h2>
        </section>

        <div class="flex items-center">
            <!-- buttons for food management -->
            <div class="flex items-center">

                <!-- search form -->
                <form action="#" method="post" class="search_form border-curve-lg">
                    <div class="flex items-center">
                        <input type="search" placeholder="Search..." class="no_outline search_employee" name="search-employee" id="search-employee">
                        <button type="submit" class="no_bg no_outline"><img src="../images/ic_search.svg" alt="search icon"></button>
                    </div>
                </form>
                <!-- 
                        // popper-btn class listenes for click event and opens modal popup
                        // controlled from admin.js
                    -->
                <?php
                $sql = "SELECT * FROM food";
                $result = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($result);

                $sql_enabled = "SELECT * FROM food where disabled = 0";
                $result_enabled = mysqli_query($conn, $sql_enabled);
                $count_enabled = mysqli_num_rows($result_enabled);

                $sql_disabled = "SELECT * FROM food where disabled = 1";
                $result_disabled = mysqli_query($conn, $sql_disabled);
                $count_disabled = mysqli_num_rows($result_disabled);

                $sql_special = "SELECT * FROM food where special = 1";
                $result_special = mysqli_query($conn, $sql_special);
                $count_special = mysqli_num_rows($result_special);
                ?>

                <form action="./backend/foods/specific-food.php" method="post">
                    <input type="hidden" name="filter-by" value="all">
                    <button type="submit" name="specific-food" class="button ml-35 border-curve-lg relative">All
                        <div class="count-top shadow"><?php
                                                        echo $count;
                                                        ?>
                        </div>
                    </button>
                </form>

                <form action="./backend/foods/specific-food.php" method="post">
                    <input type="hidden" name="filter-by" value="enabled">
                    <button type="submit" name="specific-food" class="button ml-35 border-curve-lg relative">Enabled
                        <div class="count-top shadow"><?php
                                                        echo $count_enabled;
                                                        ?>
                        </div>
                </form>

                <form action="./backend/foods/specific-food.php" method="post">
                    <input type="hidden" name="filter-by" value="disabled">
                    <button type="submit" name="specific-food" class="button ml-35 border-curve-lg relative">Disabled
                        <div class="count-top shadow"><?php
                                                        echo $count_disabled;
                                                        ?>
                        </div>
                    </button>
                </form>

                <form action="./backend/foods/specific-food.php" method="post">
                    <input type="hidden" name="filter-by" value="special">
                    <button type="submit" name="specific-food" class="button ml-35 border-curve-lg relative">Special
                        <div class="count-top shadow"><?php
                                                        echo $count_special;
                                                        ?>
                        </div>
                    </button>
                </form>
            </div>
            <!-- TODO: make filter here -->
            <div class="filter flex items-center">
                <form action="#" method="post" class="filter-form">
                    <select name="cat-filter" class="p_7-20 border-curve pointer" id="cat-filter">
                        <option value="name" class="pointer">Sort by name</option>
                        <option value="expensive" class="pointer">Expensive first</option>
                        <option value="cheap" class="pointer">Cheapest first</option>
                        <option value="most-selling" class="pointer">Most selling</option>
                        <option value="least-selling" class="pointer">Least selling</option>
                        <option value="last-added" class="pointer" selected>Last added</option>
                        <option value="first-added" class="pointer">First added</option>
                    </select>
                </form>
                <img src="../images/ic_calender.svg" class="filter_by_date popper-btn" alt="filter">
            </div>
        </div>

        <?php

        // filter content by sessions
        if (isset($_SESSION['filter-by'])) {
            $filter_by = $_SESSION['filter-by'];
            unset($_SESSION['filter-by']);
            if ($filter_by == 'all') {
                $sql = "SELECT * FROM food";
            } else if ($filter_by == 'enabled') {
                $sql = "SELECT * FROM food where disabled = 0";
            } else if ($filter_by == 'disabled') {
                $sql = "SELECT * FROM food where disabled = 1";
            } else if ($filter_by == 'special') {
                $sql = "SELECT * FROM food where special = 1";
            }
        } else {
            $sql = "SELECT * FROM food order by f_id desc";
        }

        $res = mysqli_query($conn, $sql) or die("Could not fetch food items from database");

        if (isset($_SESSION['delete_success'])) {
        ?>
            <!-- to show error alert -->
            <p class="error-container success p_7-20">
                <?php
                echo $_SESSION['delete_success'];
                unset($_SESSION['delete_success']);
                ?>
            </p>
        <?php
        }
        if (isset($_SESSION['delete_error'])) {
        ?>
            <p class="error-container error p_7-20">
                <?php
                echo $_SESSION['delete_error'];
                unset($_SESSION['delete_error']);
                ?>
            </p>
        <?php
        }
        if (isset($_SESSION['disable_success'])) {
        ?>
            <p class="error-container success p_7-20">
                <?php
                echo $_SESSION['disable_success'];
                unset($_SESSION['disable_success']);
                ?>
            </p>
        <?php
        }
        if (isset($_SESSION['disable_error'])) {
        ?>
            <p class="error-container error p_7-20">
                <?php
                echo $_SESSION['disable_error'];
                unset($_SESSION['disable_error']);
                ?>
            </p>
        <?php
        }
        if (mysqli_num_rows($res) > 0) {
        ?>
            <table class="mt-20">
                <tr class="shadow">
                    <th>SN</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Cost</th>
                    <th>Category</th>
                    <th>Sold</th>
                    <th>Action</th>
                </tr>
                <?php
                $i = 0;
                while ($row = mysqli_fetch_assoc($res)) {
                    $i++;

                    // fetch category name
                    $cat_id = $row['category'];
                    $sql_cat = "select cat_name from category where cat_id = $cat_id";
                    $res_cat = mysqli_query($conn, $sql_cat) or die("Could not fetch category name from database");
                    $row_cat = mysqli_fetch_assoc($res_cat);
                    $cat_name = $row_cat['cat_name'];
                ?>
                    <tr class="shadow">
                        <td><?php echo $i; ?></td>
                        <td>

                            <img src="../uploads/foods/<?php echo $row['img']; ?>" alt="food image" class="table_food-img">
                        </td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['cost']; ?></td>
                        <td><?php echo $cat_name; ?></td>
                        <td><?php echo 125; ?></td>
                        <td class="table_action_container">
                            <!-- action menu -->
                            <button class="no_bg no_outline table_option-menu">
                                <img src="../images/ic_options.svg" alt="options menu">
                            </button>
                            <!-- options -->
                            <div class="table_action_options shadow border-curve long r_80 p-20 flex direction-col">
                                <div>
                                    <a href="#">
                                        <div class="flex items-center justify-start">
                                            <img src="../images/ic_view.svg" alt="view icon">
                                            <p>View</p>
                                        </div>
                                    </a>
                                </div>
                                
                                <div>
                                    <form action="./backend/foods/<?php if ($row['disabled'] == 0)
                                                                        echo "disable";
                                                                    else
                                                                        echo "enable"; ?>.php" method="post" class="flex items-center justify-start">
                                        <input type="hidden" name="id" value="<?php echo $row["f_id"]; ?>">
                                        <button type="submit" name="disable" class="no_bg no_outline">
                                            <div class="flex items-center justify-start">
                                                <img src="../images/<?php if ($row['disabled'] == 0)
                                                                        echo "ic_disable.svg";
                                                                    else
                                                                        echo "ic_enable.svg"; ?>" alt="enable disable icon">
                                                <p>
                                                    <?php
                                                    if ($row['disabled'] == 0)
                                                        echo "Disable";
                                                    else
                                                        echo "Enable";
                                                    ?>
                                                </p>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>
        <?php
        } else
            echo "No records found";
        ?>
    </main>

</body>

</html>