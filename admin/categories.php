<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location: ../invalid.html');
}
?>
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
</head>

<body>

    <header>
        <nav class="top_nav flex items-center">
            <div class="flex items-center">
                <a href="#" class="logo heading flex items-center"><img src="   ../images/logo.png" alt="logo">Restro
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

                    <ul class="admin_profile p-20 shadow ">
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
                        <img class="dashboard_sidebar_content_img" src="../images/ic_dashboard.svg" alt="dashboard" aria-hidden="true">
                        <div class="flex items-center">
                            <h4 class="dashboard_sidebar_content_text hide-on-close">Dashboard</h4>
                            <img src="../images/ic_accordion_arrow.svg" class="accordion_arrow hide-on-close" aria-hidden="true" alt="accordion arrow">
                        </div>
                    </article>
                </a>

                <ul class="sidebar_sub-menu shadow ">
                    <li class="border-curve-lg">
                        <a href="#">Order Details</a>
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
                        <img class="dashboard_sidebar_content_img" src="../images/ic_view.svg" alt="view" aria-hidden="true">
                        <h4 class="dashboard_sidebar_content_text hide-on-close">Food Items</h4>
                        <img src="../images/ic_accordion_arrow.svg" class="accordion_arrow hide-on-close" aria-hidden="true" alt="accordion arrow">
                    </article>
                </a>
            </li>
            <li class="sidebar_accordion">
                <a href="#">
                    <article class="dashboard_sidebar_content border-curve-lg flex items-center justify-center">
                        <img class="dashboard_sidebar_content_img" src="../images/ic_category.svg" alt="category" aria-hidden="true">
                        <h4 class="dashboard_sidebar_content_text hide-on-close">Category</h4>
                        <img src="../images/ic_accordion_arrow.svg" class="accordion_arrow hide-on-close" aria-hidden="true" alt="accordion arrow">
                    </article>
                </a>
            </li>
            <li class="sidebar_accordion">
                <a href="#">
                    <article class="dashboard_sidebar_content border-curve-lg flex items-center justify-center">
                        <img class="dashboard_sidebar_content_img" src="../images/ic_user_edit.svg" alt="edit user" aria-hidden="true">
                        <h4 class="dashboard_sidebar_content_text hide-on-close">Users</h4>
                        <img src="../images/ic_accordion_arrow.svg" class="accordion_arrow hide-on-close" aria-hidden="true" alt="accordion arrow">
                    </article>
                </a>
            </li>
        </ul>

    </aside>

    <main class="admin_dashboard_body">

        <section class="dashboard_inner-head flex items-center">
            <h2>Manage Categories</h2>
        </section>

        <section class="modal items-center justify-center">
            <div class="modal_form-container small-modal p-20 shadow border-curve-md">

                <div class="modal_title-container flex items-center">
                    <h2 class="modal-title">Add Category</h2>
                    <button class="close-icon no_bg no_outline"><img src="../images/ic_cross.svg" alt="close"></button>
                </div>

                <form action="./backend/add-category.php" method="post" name="modal_form" enctype="multipart/form-data" class="form_add-category modal_form">

                    <div class="row">
                        <div class="col">
                            <label for="name">Name:</label>
                            <input type="text" class="category_name" name="category" id="name" required>
                        </div>
                    </div>

                    <div class="col items-center">
                        <div class="uploaded-img-preview text-center">
                            <img src="../images/ic_cloud.svg" name="upload-img" class="upload-img" alt="uploaded image">
                        </div>
                        <p class="warning warning-no_margin">Image should be less than 200 KB</p>
                    </div>

                    <div class="row mt-20">
                        <div class="col">
                            <label for="image">Select an image:</label>
                            <input type="file" name="image" class="img_upload-input" id="image" required>
                        </div>
                    </div>

                    <div class="row">
                        <button type="submit" class="button" name="add-category">Add Category</button>
                    </div>
            </div>

            </form>

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
            <div class="filter button">
                place for filter
            </div>
        </div>

        <table class="mt-20">
            <tr class="shadow">
                <th>SN</th>
                <th>Image</th>
                <th>Name</th>
                <th>Total Items</th>
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
                    </div>
                </td>
            </tr>
        </table>
    </main>

</body>

</html>