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
    require("./components/header.php");
    require("./components/sidebar.php");
    ?>

    <main class="admin_dashboard_body">

        <section class="dashboard_inner-head flex items-center">
            <h2>Manage Food Items</h2>
        </section>

        <section class="modal items-center justify-center">
            <div class="modal_form-container border-curve-md p-20 shadow ">

                <div class="modal_title-container flex items-center">
                    <h2 class="modal-title">Add Food Item</h2>
                    <button class="close-icon no_bg no_outline"><img src="../images/ic_cross.svg" alt="close"></button>
                </div>

                <form action="#" method="post" class="form_add-food modal_form">
                    <div class="row">
                        <div class="col">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" autofocus>
                        </div>

                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <label for="price">Price:</label>
                                    <input type="number" class="w-90" name="price" id="price">
                                </div>
                                <div class="col">
                                    <label for="cost">Cost:</label>
                                    <input type="number" class="w-90" name="cost" id="cost">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="col">
                                <label for="category">Category:</label>
                                <select name="category" id="category">

                                    <!-- fetch categories from db -->
                                    <?php
                                    include("../config.php");

                                    $sql = "select * from category";
                                    $res = mysqli_query($conn, $sql) or die("Could not fetch categories from database");

                                    if (mysqli_num_rows($res) > 0) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            $id = $row['cat_id'];
                                            $cat_name = $row['name'];
                                            echo "<option value='$id'>$cat_name</option>";
                                        }
                                    } else {
                                        echo "<option value=''>No categories found</option>";
                                    }
                                    ?>

                                </select>
                            </div>

                            <div class="col">
                                <label for="image">Select an image:</label>
                                <input type="file" name="image" class="img_upload-input" id="image">
                            </div>
                        </div>

                        <div class="col text-center flex justify-center">
                            <div class="uploaded-img-preview">
                                <img src="../images/ic_cloud.svg" class="upload-img" alt="uploaded image">
                            </div>
                            <p class="warning">Image should be less than 200 KB</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="estimated-cooking-time">Estimated Cooking Time:</label>
                            <input type="number" placeholder="in minutes" name="estimated-cooking-time" id="estimated-cooking-time">
                        </div>

                        <div class="col">
                            <label for="product-id">Product Id:</label>
                            <input type="text" name="product-id" id="product-id">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="description">Description: </label>
                            <textarea name="description" id="description" rows="5"></textarea>
                        </div>

                        <div class="col">
                            <div class="col">
                                <label for="veg-non-veg">Veg or Non-veg: </label>
                                <select name="veg-non-veg" id="veg-non-veg">
                                    <option value="">Select one</option>
                                    <option value="veg">Veg</option>
                                    <option value="non-veg">Non-veg</option>
                                </select>
                            </div>

                            <div class="col">
                                <button type="submit" class="button">Add Food Item</button>
                            </div>
                        </div>
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
                <button class="button ml-35 border-curve-lg popper-btn">Add Food</button>
                <button class="button ml-35 border-curve-lg">All</button>
                <button class="button ml-35 border-curve-lg">Enabled</button>
                <button class="button ml-35 border-curve-lg">Disabled</button>

            </div>
            <!-- TODO: make filter here -->
            <div class="filter button">
                place for filter
            </div>
        </div>

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
            <tr class="shadow">
                <td>1</td>
                <td>
                    <img src="../images/food.png" alt="food image" class="table_food-img">
                </td>
                <td>Chinese Momo</td>
                <td>160</td>
                <td>Momo</td>
                <td>123</td>
                <td class="table_action_container">
                    <!-- action menu -->
                    <button class="no_bg no_outline table_option-menu">
                        <img src="../images/ic_options.svg" alt="options menu">
                    </button>
                    <!-- options -->
                    <div class="table_action_options shadow border-curve p-20 flex direction-col">
                        <div>
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_edit.svg" alt="edit icon">
                                    <p>Edit</p>
                                </div>
                            </a>
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
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_delete.svg" alt="delete icon">
                                    <p>Delete</p>
                                </div>
                            </a>
                        </div>
                        <div>
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_disable.svg" alt="disable icon">
                                    <p>Disable</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="shadow">
                <td>2</td>
                <td>
                    <img src="../images/food.png" alt="food image" class="table_food-img">
                </td>
                <td>Chinese Momo</td>
                <td>160</td>
                <td>Momo</td>
                <td>123</td>
                <td class="table_action_container">
                    <!-- action menu -->
                    <button class="no_bg no_outline table_option-menu">
                        <img src="../images/ic_options.svg" alt="options menu">
                    </button>
                    <!-- options -->
                    <div class="table_action_options shadow border-curve p-20 flex direction-col">
                        <div>
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_edit.svg" alt="edit icon">
                                    <p>Edit</p>
                                </div>
                            </a>
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
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_delete.svg" alt="delete icon">
                                    <p>Delete</p>
                                </div>
                            </a>
                        </div>
                        <div>
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_disable.svg" alt="disable icon">
                                    <p>Disable</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="shadow">
                <td>3</td>
                <td>
                    <img src="../images/food.png" alt="food image" class="table_food-img">
                </td>
                <td>Chinese Momo</td>
                <td>160</td>
                <td>Momo</td>
                <td>123</td>
                <td class="table_action_container">
                    <!-- action menu -->
                    <button class="no_bg no_outline table_option-menu">
                        <img src="../images/ic_options.svg" alt="options menu">
                    </button>
                    <!-- options -->
                    <div class="table_action_options shadow border-curve p-20 flex direction-col">
                        <div>
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_edit.svg" alt="edit icon">
                                    <p>Edit</p>
                                </div>
                            </a>
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
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_delete.svg" alt="delete icon">
                                    <p>Delete</p>
                                </div>
                            </a>
                        </div>
                        <div>
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_disable.svg" alt="disable icon">
                                    <p>Disable</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="shadow">
                <td>4</td>
                <td>
                    <img src="../images/food.png" alt="food image" class="table_food-img">
                </td>
                <td>Chinese Momo</td>
                <td>160</td>
                <td>Momo</td>
                <td>123</td>
                <td class="table_action_container">
                    <!-- action menu -->
                    <button class="no_bg no_outline table_option-menu">
                        <img src="../images/ic_options.svg" alt="options menu">
                    </button>
                    <!-- options -->
                    <div class="table_action_options shadow border-curve p-20 flex direction-col">
                        <div>
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_edit.svg" alt="edit icon">
                                    <p>Edit</p>
                                </div>
                            </a>
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
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_delete.svg" alt="delete icon">
                                    <p>Delete</p>
                                </div>
                            </a>
                        </div>
                        <div>
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_disable.svg" alt="disable icon">
                                    <p>Disable</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="shadow">
                <td>5</td>
                <td>
                    <img src="../images/food.png" alt="food image" class="table_food-img">
                </td>
                <td>Chinese Momo</td>
                <td>160</td>
                <td>Momo</td>
                <td>123</td>
                <td class="table_action_container">
                    <!-- action menu -->
                    <button class="no_bg no_outline table_option-menu">
                        <img src="../images/ic_options.svg" alt="options menu">
                    </button>
                    <!-- options -->
                    <div class="table_action_options shadow border-curve p-20 flex direction-col">
                        <div>
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_edit.svg" alt="edit icon">
                                    <p>Edit</p>
                                </div>
                            </a>
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
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_delete.svg" alt="delete icon">
                                    <p>Delete</p>
                                </div>
                            </a>
                        </div>
                        <div>
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_disable.svg" alt="disable icon">
                                    <p>Disable</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="shadow">
                <td>6</td>
                <td>
                    <img src="../images/food.png" alt="food image" class="table_food-img">
                </td>
                <td>Chinese Momo</td>
                <td>160</td>
                <td>Momo</td>
                <td>123</td>
                <td class="table_action_container">
                    <!-- action menu -->
                    <button class="no_bg no_outline table_option-menu">
                        <img src="../images/ic_options.svg" alt="options menu">
                    </button>
                    <!-- options -->
                    <div class="table_action_options shadow border-curve p-20 flex direction-col">
                        <div>
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_edit.svg" alt="edit icon">
                                    <p>Edit</p>
                                </div>
                            </a>
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
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_delete.svg" alt="delete icon">
                                    <p>Delete</p>
                                </div>
                            </a>
                        </div>
                        <div>
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_disable.svg" alt="disable icon">
                                    <p>Disable</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </main>

</body>

</html>