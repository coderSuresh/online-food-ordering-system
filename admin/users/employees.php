<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees | RestroHub</title>
    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../../styles/style.css">
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
        
        <section class="dashboard_inner-head flex items-center">
            <h2>Employees</h2>
        </section>

        <section class="modal items-center justify-center">
            <div class="modal_form-container p-20 shadow border-curve-md">

                <div class="modal_title-container flex items-center">
                    <h2 class="modal-title">Add an Employee</h2>
                    <button class="close-icon no_bg no_outline"><img src="../../images/ic_cross.svg" alt="close"></button>
                </div>

                <form action="./backend/create-employee.php" method="post" name="model_form" class="form_add-employees modal_form">

                    <div class="row">
                        <div class="col">
                            <div class="col">
                                <div class="col">
                                    <label for="name">Name:</label>
                                    <input type="text" name="name" id="name" autofocus required>
                                </div>
                            </div>
                            <div class="col">
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" required>
                            </div>
                        </div>

                        <div class="col text-center flex justify-center">
                            <div class="uploaded-img-preview">
                                <img src="../../images/ic_cloud.svg" class="upload-img" alt="uploaded image">
                            </div>
                            <p class="warning">Image should be less than 200 KB</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="username">Username:</label>
                            <input type="text" name="username" id="username" required>
                        </div>

                        <div class="col">
                            <label for="emp_photo">Image:</label>
                            <input type="file" name="emp_photo" class="img_upload-input" id="emp_photo" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="password">Password:</label>
                            <input type="text" name="password" id="password" required>
                        </div>

                        <div class="col">
                            <label for="con-password">Confirm Password:</label>
                            <input type="text" name="con-password" id="con-password" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="department">Department:</label>
                            <select name="department" id="department" required>
                                <?php
                                $dep_sql = "Select * from department";
                                $dep_result = mysqli_query($conn, $dep_sql) or die("Query Failed.");
                                ?>
                                <option value="">Select Deparmtent</option>
                                <?php
                                while ($dep_row = mysqli_fetch_assoc($dep_result)) {
                                ?>
                                    <option value="<?php echo $dep_row['dept_id']; ?>"><?php echo $dep_row['department']; ?></option>
                                <?php  }
                                ?>

                            </select>


                        </div>

                        <div class="col">
                            <label for="add-employee" class="not-required">not required</label>
                            <button type="submit" name="add" id="add-employee" class="button modal_form-submit-btn form_add-employees">Add an
                                Employee</button>
                        </div>
                    </div>

                </form>

            </div>
        </section>

        <div class="emplooyee_stat">

            <div class="flex items-center">
                <!-- buttons for employee management -->
                <div class="emp_button-container">
                    <!-- 
                        // popper-btn class listenes for click event and opens modal popup
                        // controlled from admin.js
                    -->
                    <button class="button border-curve-lg popper-btn">Add</button>
                    <button class="button border-curve-lg">All</button>
                    <button class="button border-curve-lg">Active</button>
                    <button class="button border-curve-lg">Disabled</button>
                </div>

                <!-- search form for employee -->
                <form action="#" method="post" class="search_form border-curve-lg">
                    <div class="flex items-center">
                        <input type="search" placeholder="Search..." class="no_outline search_employee" name="search-employee" id="search-employee">
                        <button type="submit" class="no_bg no_outline"><img src="../../images/ic_search.svg" alt="search icon"></button>
                    </div>
                </form>
            </div>

            <!-- employee cards -->
            <div class="emp_card_container flex wrap gap justify-start">
                <div class="employee_card p-20 text-center shadow border-curve-md">

                    <!-- overlay for disabled account -->
                    <div class="emp_card-overlay border-curve-md"></div>

                    <img src="../../images/ic_options.svg" alt="options menu" class="emp_card_option-menu table_option-menu">
                    <img src="../../images/profile.jpg" alt="user profile">
                    <h3 class="emp_name">Test Employee</h3>
                    <p class="emp_id">#2020295</p>
                    <div class="flex emp_card_content items-center justify-start">
                        <img src="../../images/ic_acc.svg" alt="account icon">
                        <p>testemployee123</p>
                    </div>
                    <div class="flex emp_card_content items-center justify-start">
                        <img src="../../images/ic_mail.svg" alt="mail icon">
                        <p>testemployee@yandex.ru</p>
                    </div>

                    <!-- options -->
                    <div class="emp_card_options table_action_options shadow border-curve-md p-20">
                        <a href="#">
                            <div class="flex items-center justify-start">
                                <img src="../../images/ic_edit.svg" alt="edit icon">
                                <p>Edit</p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="flex items-center justify-start">
                                <img src="../../images/ic_disable.svg" alt="disable icon">
                                <p>Disable</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="employee_card p-20 text-center shadow border-curve-md">

                    <!-- overlay for disabled account -->
                    <div class="emp_card-overlay border-curve-md"></div>

                    <img src="../../images/ic_options.svg" alt="options menu" class="emp_card_option-menu table_option-menu">
                    <img src="../../images/profile.jpg" alt="user profile">
                    <h3 class="emp_name">Test Employee</h3>
                    <p class="emp_id">#2020295</p>
                    <div class="flex emp_card_content items-center justify-start">
                        <img src="../../images/ic_acc.svg" alt="account icon">
                        <p>testemployee123</p>
                    </div>
                    <div class="flex emp_card_content items-center justify-start">
                        <img src="../../images/ic_mail.svg" alt="mail icon">
                        <p>testemployee@yandex.ru</p>
                    </div>

                    <!-- options -->
                    <div class="emp_card_options table_action_options shadow border-curve-md p-20">
                        <a href="#">
                            <div class="flex items-center justify-start">
                                <img src="../../images/ic_edit.svg" alt="edit icon">
                                <p>Edit</p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="flex items-center justify-start">
                                <img src="../../images/ic_disable.svg" alt="disable icon">
                                <p>Disable</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="employee_card p-20 text-center shadow border-curve-md">

                    <!-- overlay for disabled account -->
                    <div class="emp_card-overlay border-curve-md"></div>

                    <img src="../../images/ic_options.svg" alt="options menu" class="emp_card_option-menu table_option-menu">
                    <img src="../../images/profile.jpg" alt="user profile">
                    <h3 class="emp_name">Test Employee</h3>
                    <p class="emp_id">#2020295</p>
                    <div class="flex emp_card_content items-center justify-start">
                        <img src="../../images/ic_acc.svg" alt="account icon">
                        <p>testemployee123</p>
                    </div>
                    <div class="flex emp_card_content items-center justify-start">
                        <img src="../../images/ic_mail.svg" alt="mail icon">
                        <p>testemployee@yandex.ru</p>
                    </div>

                    <!-- options -->
                    <div class="emp_card_options table_action_options shadow border-curve-md p-20">
                        <a href="#">
                            <div class="flex items-center justify-start">
                                <img src="../../images/ic_edit.svg" alt="edit icon">
                                <p>Edit</p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="flex items-center justify-start">
                                <img src="../../images/ic_disable.svg" alt="disable icon">
                                <p>Disable</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="employee_card p-20 text-center shadow border-curve-md">

                    <!-- overlay for disabled account -->
                    <div class="emp_card-overlay border-curve-md"></div>

                    <img src="../../images/ic_options.svg" alt="options menu" class="emp_card_option-menu table_option-menu">
                    <img src="../../images/profile.jpg" alt="user profile">
                    <h3 class="emp_name">Test Employee</h3>
                    <p class="emp_id">#2020295</p>
                    <div class="flex emp_card_content items-center justify-start">
                        <img src="../../images/ic_acc.svg" alt="account icon">
                        <p>testemployee123</p>
                    </div>
                    <div class="flex emp_card_content items-center justify-start">
                        <img src="../../images/ic_mail.svg" alt="mail icon">
                        <p>testemployee@yandex.ru</p>
                    </div>

                    <!-- options -->
                    <div class="emp_card_options table_action_options shadow border-curve-md p-20">
                        <a href="#">
                            <div class="flex items-center justify-start">
                                <img src="../../images/ic_edit.svg" alt="edit icon">
                                <p>Edit</p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="flex items-center justify-start">
                                <img src="../../images/ic_disable.svg" alt="disable icon">
                                <p>Disable</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="employee_card p-20 text-center shadow border-curve-md">

                    <!-- overlay for disabled account -->
                    <div class="emp_card-overlay border-curve-md"></div>

                    <img src="../../images/ic_options.svg" alt="options menu" class="emp_card_option-menu table_option-menu">
                    <img src="../../images/profile.jpg" alt="user profile">
                    <h3 class="emp_name">Test Employee</h3>
                    <p class="emp_id">#2020295</p>
                    <div class="flex emp_card_content items-center justify-start">
                        <img src="../../images/ic_acc.svg" alt="account icon">
                        <p>testemployee123</p>
                    </div>
                    <div class="flex emp_card_content items-center justify-start">
                        <img src="../../images/ic_mail.svg" alt="mail icon">
                        <p>testemployee@yandex.ru</p>
                    </div>

                    <!-- options -->
                    <div class="emp_card_options table_action_options shadow border-curve-md p-20">
                        <a href="#">
                            <div class="flex items-center justify-start">
                                <img src="../../images/ic_edit.svg" alt="edit icon">
                                <p>Edit</p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="flex items-center justify-start">
                                <img src="../../images/ic_disable.svg" alt="disable icon">
                                <p>Disable</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>

</html>