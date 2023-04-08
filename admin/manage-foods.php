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
    <script src="./watch-dog.js" defer></script>
    <script src="./watch-status.js" defer></script>

</head>

<body>

    <?php
    require("./components/header.php");
    require("./components/sidebar.php");
    ?>

    <main class="admin_dashboard_body">

        <section class="dashboard_inner-head flex items-center">
            <h2>Manage Food Items <?php if (isset($_GET['filter-by']))
                                        echo "(" . $_GET['filter-by'] . ")"; ?></h2>
        </section>

        <section class="modal <?php if (isset($_SESSION['f-id']))
                                    echo "flex"; ?> items-center justify-center">
            <div class="modal_form-container border-curve-md p-20 shadow ">

                <div class="modal_title-container flex items-center">
                    <h2 class="modal-title">
                        <?php
                        if (isset($_SESSION['f-id']))
                            echo "Update Food Item";
                        else
                            echo "Add Food Item";
                        ?>
                    </h2>
                    <a href="./backend/foods/session-delete.php" class="close-icon no_bg no_outline"><img src="../images/ic_cross.svg" alt="close"></a>
                </div>

                <form action="<?php if (isset($_SESSION['f-id']))
                                    echo "./backend/foods/update.php";
                                else echo "./backend/foods/add-food.php" ?>" method="post" name="modal_form" class="form_add-food modal_form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col">
                            <label for="name">Name:</label>

                            <?php
                            require("../config.php");
                            if (isset($_SESSION['f-id'])) {
                                $sql = "SELECT * FROM food WHERE f_id = {$_SESSION['f-id']}";
                                $result = mysqli_query($conn, $sql);
                                $data = mysqli_fetch_assoc($result);
                            }
                            ?>

                            <input type="text" name="name" value="<?php if (isset($_SESSION['f-id']))
                                                                        echo $data['name'];
                                                                    else
                                                                        echo ""; ?>" id="name" autofocus required>
                        </div>

                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <label for="price">Price:</label>
                                    <input type="number" name="price" value="<?php if (isset($_SESSION['f-id']))
                                                                                    echo $data['price'];
                                                                                else
                                                                                    echo ""; ?>" id="price" required>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="col">
                                <label for="category">Category:</label>
                                <select name="cat_id" id="category" required>
                                    <!-- fetch categories from db -->
                                    <?php
                                    $sql = "select * from category";
                                    $res = mysqli_query($conn, $sql) or die("Could not fetch categories from database");

                                    if (isset($_SESSION['f-category']))
                                        $selected_cat = $_SESSION['f-category'];
                                    else
                                        $selected_cat = "";

                                    if (mysqli_num_rows($res) > 0) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            $id = $row['cat_id'];
                                            $cat_name = $row['cat_name'];
                                    ?>
                                            <option value="<?php echo $id; ?>" <?php if ($selected_cat == $cat_name) echo "selected"; ?>><?php echo $cat_name; ?></option>
                                    <?php
                                        }
                                    } else {
                                        echo "<option value=''>No categories found</option>";
                                    }
                                    ?>

                                </select>
                            </div>

                            <div class="col">
                                <label for="image">Select an image:</label>
                                <input type="file" name="image" class="img_upload-input" id="image" required>
                            </div>
                        </div>

                        <div class="col text-center flex justify-center">
                            <div class="uploaded-img-preview">
                                <img src="<?php if (isset($_SESSION['f-id']))
                                                echo "../uploads/foods/" . $data['img'];
                                            else echo '../images/ic_cloud.svg'; ?>" class="upload-img" alt="uploaded image">
                            </div>
                            <p class="warning">Image should be less than 200 KB</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="estimated-cooking-time">Estimated Cooking Time:</label>
                            <input type="number" placeholder="in minutes" name="estimated-cooking-time" value="<?php if (isset($_SESSION['f-id']))
                                                                                                                    echo $data['cooking_time']; ?>" id="estimated-cooking-time" required>
                        </div>

                        <div class="col">
                            <label for="product-id">Product Id:</label>
                            <input type="text" name="product-id" value="<?php if (isset($_SESSION['f-id']))
                                                                            echo $data['product_id']; ?>" id="product-id" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="short-desc">Short Description: </label>
                            <textarea name="short-desc" id="short-desc" rows="3" required><?php if (isset($_SESSION['f-id']))
                                                                                                echo $data['short_desc']; ?></textarea>
                        </div>
                        <div class="col">
                            <label for="ingredients">Ingredients: </label>
                            <textarea name="ingredients" id="ingredients" rows="3" required><?php
                                                                                            if (isset($_SESSION['f-id'])) {
                                                                                                echo $data['ingredients'];
                                                                                            } ?>
                            </textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="description">Description: </label>
                            <textarea name="description" id="description" rows="5" required><?php if (isset($_SESSION['f-id']))
                                                                                                echo $data['description']; ?></textarea>
                        </div>

                        <div class="col">
                            <div class="col">
                                <label for="veg-non-veg">Veg or Non-veg: </label>
                                <select name="veg-non-veg" id="veg-non-veg" required>
                                    <?php
                                    $isVeg = false;
                                    if (isset($_SESSION['f-veg'])) {
                                        if ($_SESSION['f-veg'] == 0) {
                                            $isVeg = false;
                                        } else {
                                            $isVeg = true;
                                        }
                                    }
                                    ?>
                                    <option value="" selected>Select one</option>
                                    <option value="veg" <?php if ($isVeg)
                                                            echo "selected"; ?>>Veg</option>
                                    <option value="non-veg" <?php if (!$isVeg)
                                                                echo "selected"; ?>>Non-veg</option>
                                </select>
                            </div>

                            <?php
                            if (isset($_SESSION['f-id'])) {
                                echo "<input type='hidden' name='f-id' value='" . $_SESSION['f-id'] . "'>";
                            }
                            ?>

                            <div class="col">
                                <button type="submit" class="button modal_form-submit-btn" name="<?php if (isset($_SESSION['f-id']))
                                                                                                        echo "update";
                                                                                                    else
                                                                                                        echo "add"; ?>"><?php if (isset($_SESSION['f-id']))
                                                                                                                            echo "Update";
                                                                                                                        else echo "Add" ?> Food Item</button>
                            </div>
                        </div>
                    </div>
            </div>
            </form>

            </div>
        </section>

        <div class="flex items-center mt-20">
            <!-- buttons for food management -->
            <div class="flex items-center">

                <form action="./manage-foods.php" method="get" class="search_form border-curve-lg">
                    <div class="flex items-center">
                        <input type="search" placeholder="Search..." class="no_outline search_employee" name="search" id="search-employee">
                        <button type="submit" class="no_bg no_outline"><img src="../images/ic_search.svg" alt="search icon"></button>
                    </div>
                </form>
                <!-- 
                        // popper-btn class listenes for click event and opens modal popup
                        // controlled from admin.js
                    -->
                <button class="button ml-35 border-curve popper-btn">Add Food</button>

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

                <a href="?filter-by=all" class="ml-35">
                    <button class="button border-curve relative">All
                        <div class="count-top rect shadow"><?php
                                                        echo $count;
                                                        ?>
                        </div>
                    </button>
                </a>

                <a href="?filter-by=enabled" class="ml-35">
                    <button class="button border-curve relative">Enabled
                        <div class="count-top rect shadow"><?php
                                                        echo $count_enabled;
                                                        ?>
                        </div>
                    </button>
                </a>

                <a href="?filter-by=disabled" class="ml-35">
                    <button class="button border-curve relative">Disabled
                        <div class="count-top rect shadow"><?php
                                                        echo $count_disabled;
                                                        ?>
                        </div>
                    </button>
                </a>

                <a href="?filter-by=special" class="ml-35">
                    <button class="button border-curve relative">Special
                        <div class="count-top rect shadow"><?php
                                                        echo $count_special;
                                                        ?>
                        </div>
                    </button>
                </a>

            </div>

            <div class="filter flex items-center">
                <form action="./manage-foods.php" method="get" class="filter-form">
                    <select name="filter" class="p_7-20 border-curve pointer">
                        <option value="name" class="pointer" <?php if (isset($_GET['filter']) && $_GET['filter'] == "name")
                                                                    echo "selected"; ?>>Sort by name</option>
                        <option value="expensive" class="pointer" <?php if (isset($_GET['filter']) && $_GET['filter'] == "expensive")
                                                                        echo "selected"; ?>>Expensive first</option>
                        <option value="cheap" class="pointer" <?php if (isset($_GET['filter']) && $_GET['filter'] == "cheap")
                                                                    echo "selected"; ?>>Cheapest first</option>
                        <option value="most-selling" class="pointer" <?php if (isset($_GET['filter']) && $_GET['filter'] == "most-selling")
                                                                            echo "selected"; ?>>Most selling</option>
                        <option value="least-selling" class="pointer" <?php if (isset($_GET['filter']) && $_GET['filter'] == "least-selling")
                                                                            echo "selected"; ?>>Least selling</option>
                        <option value="first-added" class="pointer" <?php if (isset($_GET['filter']) && $_GET['filter'] == "first-added")
                                                                        echo "selected"; ?>>First added</option>
                        <option value="last-added" class="pointer" <?php if (isset($_GET['filter']) && $_GET['filter'] == "last-added")
                                                                        echo "selected";
                                                                    if (!isset($_GET['filter']))
                                                                        echo "selected"; ?>>Last added</option>
                    </select>
                </form>
            </div>
        </div>

        <?php
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

        $limit = 10;

        if (isset($_GET['filter-by']) && $_GET['filter-by'] != 'all') {
            $filter_by = mysqli_real_escape_string($conn, $_GET['filter-by']);
            switch ($filter_by) {
                case 'enabled':
                    $count = $count_enabled;
                    break;
                case 'disabled':
                    $count = $count_disabled;
                    break;
                case 'special':
                    $count = $count_special;
                    break;
            }
        }

        require './components/calculate-offset.php';

        $sql_food = "SELECT 
                            f.f_id,
                            f.img,
                            f.name,
                            f.price,
                            f.veg,
                            f.disabled,
                            f.special,
                            c.cat_name,
                            COALESCE(total_sold, 0) AS total_sold
                        FROM food f
                        LEFT JOIN (
                            SELECT 
                                f.f_id,
                                SUM(CASE WHEN aos.status = 'delivered' THEN o.qty ELSE 0 END) AS total_sold
                            FROM orders o
                            INNER JOIN food f ON o.f_id = f.f_id
                            LEFT JOIN aos ON o.id = aos.order_id
                            GROUP BY f.f_id
                        ) AS sd ON f.f_id = sd.f_id
                            INNER JOIN category c ON f.category = c.cat_id";

        if (isset($_GET['filter-by'])) {

            $filter_by = mysqli_real_escape_string($conn, $_GET['filter-by']);
            if ($filter_by == 'all') {
                $sql = $sql_food . " order by f.f_id desc limit $offset, $limit";
            } else if ($filter_by == 'enabled') {
                $sql = $sql_food . " where disabled = 0 order by f.f_id desc limit $offset, $limit";
            } else if ($filter_by == 'disabled') {
                $sql = $sql_food . " where disabled = 1 order by f.f_id desc limit $offset, $limit";
            } else if ($filter_by == 'special') {
                $sql = $sql_food . " where special = 1 order by f.f_id desc limit $offset, $limit";
            }
        } else {
            $_SESSION['filter-by'] = 'all';
            $sql = $sql_food . " order by f.f_id desc limit $offset, $limit";
        }

        // filter by name, expensive, cheap, most selling, least selling, last added, first added
        if (isset($_GET['filter'])) {
            $filter = mysqli_real_escape_string($conn, $_GET['filter']);

            switch ($filter) {
                case 'name':
                    $sql = $sql_food . " order by f.name asc limit $offset, $limit";
                    break;
                case 'expensive':
                    $sql = $sql_food . " order by f.price desc limit $offset, $limit";
                    break;
                case 'cheap':
                    $sql = $sql_food . " order by f.price asc limit $offset, $limit";
                    break;
                case 'most-selling':
                    $sql = $sql_food . " order by total_sold desc limit $offset, $limit";
                    break;
                case 'least-selling':
                    $sql = $sql_food . " order by total_sold asc limit $offset, $limit";
                    break;
                case 'last-added':
                    $sql = $sql_food . " order by f.f_id desc limit $offset, $limit";
                    break;
                case 'first-added':
                    $sql = $sql_food . " order by f.f_id asc limit $offset, $limit";
                    break;
                default:
                    $sql = $sql_food . " order by f.f_id desc limit $offset, $limit";
                    break;
            }
        }

        // search food by name
        if (isset($_GET['search'])) {
            $search = mysqli_real_escape_string($conn, $_GET['search']);
            $sql = $sql_food . " where f.name like '%$search%' 
                    or c.cat_name like '%$search%'
                    order by f.f_id desc";
        }

        $res = mysqli_query($conn, $sql) or die("Could not fetch food items from database");
        if (mysqli_num_rows($res) > 0) {
        ?>
            <table class="mt-20">
                <tr class="shadow">
                    <th>SN</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Sold</th>
                    <th>Action</th>
                </tr>
                <?php
                $i = $offset;
                while ($row = mysqli_fetch_assoc($res)) {
                    $i++;
                    $cat_name = $row['cat_name'];
                    $total_sold = $row['total_sold'];

                    if ($total_sold == null) {
                        $total_sold = 0;
                    }
                ?>
                    <tr class="shadow">
                        <td><?php echo $i; ?></td>
                        <td>
                            <img src="../uploads/foods/<?php echo $row['img']; ?>" alt="food image" class="table_food-img">
                        </td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $cat_name; ?></td>
                        <td><?php echo $total_sold; ?></td>
                        <td class="table_action_container">
                            <!-- action menu -->
                            <button class="no_bg no_outline table_option-menu">
                                <img src="../images/ic_options.svg" alt="options menu">
                            </button>
                            <!-- options -->
                            <div class="table_action_options shadow border-curve long p-20 flex direction-col">
                                <div>
                                    <form action="./backend/foods/edit.php" method="post" class="flex items-center justify-start">
                                        <input type="hidden" name="id" value="<?php echo $row["f_id"]; ?>">
                                        <input type="hidden" name="category" value="<?php echo $cat_name; ?>">
                                        <input type="hidden" name="veg" value="<?php echo $row['veg']; ?>">
                                        <button type="submit" name="edit" class="no_bg no_outline">
                                            <div class="flex items-center justify-start">
                                                <img src="../images/ic_edit.svg" alt="edit icon">
                                                <p>Edit</p>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                                <div>
                                    <a href="#">
                                        <div class="flex items-center justify-start">
                                            <img src="../images/ic_view.svg" alt="view icon">
                                            <p>View</p>
                                        </div>
                                    </a>
                                </div>
                                <!-- add to special food -->
                                <div>
                                    <form action="./backend/foods/<?php
                                                                    if ($row['special'] == 0)
                                                                        echo "add-to-special";
                                                                    else
                                                                        echo "remove-from-special";
                                                                    ?>.php" method="post" class="flex items-center justify-start">
                                        <input type="hidden" name="id" value="<?php echo $row["f_id"]; ?>">
                                        <button type="submit" name="add-to-special" class="no_bg no_outline">
                                            <div class="flex items-center justify-start">
                                                <img src="../images/<?php
                                                                    if ($row['special'] == 0)
                                                                        echo "ic_add.svg";
                                                                    else
                                                                        echo "ic_remove.svg";
                                                                    ?>" alt="toggle special food">
                                                <p>
                                                    <?php
                                                    if ($row['special'] == 0)
                                                        echo "Add to special";
                                                    else
                                                        echo "Remove special";
                                                    ?>
                                                </p>
                                            </div>
                                        </button>
                                    </form>
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
                <?php } ?>
            </table>
        <?php
            $isForSearch = isset($_GET['search']);
            require './components/pagination.php';
        } else
            echo "<p class='mt-20'>No Record Found</p>";
        ?>
    </main>

    <script>
        const formFilter = document.querySelector('.filter-form');
        formFilter.addEventListener('change', () => {
            formFilter.submit();
        });
    </script>
</body>

</html>