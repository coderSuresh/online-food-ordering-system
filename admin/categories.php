<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories | RestroHub</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
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
            <h2>Manage Categories</h2>
        </section>

        <section class="modal <?php if (isset($_SESSION['cat-name'])) echo "flex"; ?> items-center justify-center">

            <div class="modal_form-container small-modal p-20 shadow border-curve-md">
                <div class="modal_title-container flex items-center">
                    <h2 class="modal-title">
                        <?php
                        if (isset($_SESSION['cat-name']))
                            echo "Update Category";
                        else
                            echo "Add Category";
                        ?>
                    </h2>
                    <a href="./backend/category/session-delete.php" class="close-icon no_bg no_outline"><img src="../images/ic_cross.svg" alt="close"></a>
                </div>

                <form action="<?php if (isset($_SESSION['cat-name'])) {
                                    echo "./backend/category/update.php";
                                } else {
                                    echo "./backend/category/add-category.php";
                                } ?>" method="post" name="modal_form" enctype="multipart/form-data" class="form_add-category modal_form">

                    <div class="row">
                        <div class="col">
                            <label for="name">Name:</label>
                            <input type="text" class="category_name name_input" value="<?php if (isset($_SESSION['cat-name'])) echo $_SESSION['cat-name']; ?>" name="category" id="name" autofocus required>
                        </div>
                    </div>

                    <div class="col items-center">
                        <div class="uploaded-img-preview text-center">
                            <label for="image">
                                <img src="<?php if (isset($_SESSION['cat-img'])) {
                                                echo "../uploads/category/" . $_SESSION['cat-img'];
                                            } else
                                                echo "../images/ic_cloud.svg"; ?>" name="upload-img" class="upload-img" alt="uploaded image">

                            </label>
                        </div>
                        <p class="warning warning-no_margin">Image should be less than 200 KB</p>
                    </div>

                    <div class="row mt-20">
                        <div class="col">
                            <label for="image">Select an image:</label>
                            <input type="file" name="image" class="img_upload-input" id="image" required>
                        </div>
                    </div>

                    <?php
                    if (isset($_SESSION['cat-name'])) {
                    ?>
                        <input type="hidden" name="cat-id" value="<?php echo $_SESSION['cat-id']; ?>">
                    <?php
                    }

                    ?>

                    <div class="row">
                        <button type="submit" class="button modal_form-submit-btn" name="<?php if (isset($_SESSION['cat-name']))
                                                                                                echo "update";
                                                                                            else echo "add" ?>">
                            <?php
                            if (isset($_SESSION['cat-name']))
                                echo "Update Category";
                            else
                                echo "Add Category";
                            ?>
                        </button>
                    </div>
                </form>
            </div>

        </section>

        <div class="flex items-center">
            <!-- buttons for food management -->
            <div class="flex items-center">

                <!-- search form for employee -->
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
                <button class="button ml-35 border-curve-lg popper-btn">Add Category</button>

            </div>
            <!-- TODO: make filter here -->
            <div class="filter flex items-center">
                <form action="#" method="post" class="filter-form">
                    <select name="cat-filter" class="p_7-20 border-curve" id="cat-filter">
                        <option value="name">Sort by name</option>
                        <option value="most-selling">Most selling</option>
                        <option value="least-selling">Least selling</option>
                        <option value="last-added" selected>Last added</option>
                        <option value="first-added">First added</option>
                    </select>
                </form>
                <img src="../images/ic_calender.svg" class="filter_by_date popper-btn" alt="filter">
            </div>

        </div>

        <?php
        require("../config.php");
        $sql = "select * from category order by cat_id desc";
        $res = mysqli_query($conn, $sql);

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
            <!-- to show error alert -->
            <p class="error-container error p_7-20">
                <?php
                echo $_SESSION['delete_error'];
                unset($_SESSION['delete_error']);
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
                    <th>Total Items</th>
                    <th>Sold</th>
                    <th>Action</th>
                </tr>

                <?php
                $i = 0;
                while ($data = mysqli_fetch_assoc($res)) {
                    $i++;
                ?>
                    <tr class="shadow">
                        <td> <?php echo $i; ?> </td>
                        <td>
                            <img src="../uploads/category/<?php echo $data["image"]; ?>" alt="food image" class="table_food-img">
                        </td>
                        <td> <?php echo $data["cat_name"]; ?> </td>
                        <td>160</td>
                        <td>123</td>
                        <td class="table_action_container">
                            <!-- action menu -->
                            <button class="no_bg no_outline table_option-menu">
                                <img src="../images/ic_options.svg" alt="options menu">
                            </button>
                            <!-- options -->
                            <div class="table_action_options shadow border-curve p-20 flex direction-col">
                                <div>
                                    <form action="./backend/category/edit.php" method="post" class="flex items-center justify-start">
                                        <input type="hidden" name="id" value="<?php echo $data["cat_id"]; ?>">
                                        <input type="hidden" name="name" value="<?php echo $data["cat_name"]; ?>">
                                        <input type="hidden" name="img" value="<?php echo $data["image"]; ?>">
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
                                <div>
                                    <form action="./backend/category/delete.php" method="post" class="flex items-center justify-start">
                                        <input type="hidden" name="id" value="<?php echo $data["cat_id"]; ?>">
                                        <input type="hidden" name="img" value="<?php echo $data["image"]; ?>">
                                        <button type="submit" name="delete" class="no_bg no_outline delete_btn">
                                            <div class="flex items-center justify-start">
                                                <img src="../images/ic_delete.svg" alt="delete icon">
                                                <p>Delete</p>
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
        } else {
        ?>
            <p class="mt-20 text-center">
            <?php
            echo "No data found";
        }
            ?>
            </p>
    </main>

</body>

</html>

<?php
// unset($_SESSION['cat-name']); 
?>