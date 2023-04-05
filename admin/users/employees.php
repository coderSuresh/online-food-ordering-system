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
    <?php
    if (!isset($_SESSION['admin-success'])) {
        header("Location: ../../invalid.php");
    }
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
            <h2>Employees</h2>
        </section>

        <section class="modal items-center  <?php if (isset($_SESSION['emp-name'])) echo "flex"; ?> justify-center">
            <div class="modal_form-container p-20 shadow border-curve-md">

                <div class="modal_title-container flex items-center">
                    <h2>
                        <?php
                        if (isset($_SESSION['emp-name']))
                            echo "Update Employee";
                        else
                            echo "Add an Employee";
                        ?>
                    </h2>
                    <a href="./backend/session-delete.php" class="close-icon no_bg no_outline"><img src="../../images/ic_cross.svg" alt="close"></a>

                </div>

                <form action="<?php if (isset($_SESSION['emp-name'])) {
                                    echo "./backend/update-employees.php";
                                } else {
                                    echo "./backend/create-employees.php";
                                } ?> " enctype="multipart/form-data" method="post" name="model_form" class="form_add-employees modal_form">

                    <div class="row">
                        <div class="col">
                            <div class="col">
                                <div class="col">
                                    <label for="name">Name:</label>
                                    <input type="text" name="name" id="name" value="<?php if (isset($_SESSION['emp-name'])) echo $_SESSION['emp-name']; ?>" autofocus required>
                                </div>
                            </div>
                            <div class="col">
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" value="<?php if (isset($_SESSION['emp-email'])) echo $_SESSION['emp-email']; ?>" required>
                            </div>
                        </div>

                        <div class="col text-center flex justify-center">
                            <div class="uploaded-img-preview">
                                <img src="<?php if (isset($_SESSION['emp-img'])) {
                                                echo "../../uploads/employees/" . $_SESSION['emp-img'];
                                            } else
                                                echo "../../images/ic_cloud.svg"; ?>" name="upload-img" class="upload-img" alt="uploaded image">
                            </div>
                            <p class="warning">Image should be less than 200 KB</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="username">Username:</label>
                            <input type="text" name="username" id="username" value="<?php if (isset($_SESSION['emp-username'])) echo $_SESSION['emp-username']; ?>" required>
                        </div>

                        <div class="col">
                            <label for="emp_photo">Image:</label>
                            <input type="file" name="image" class="img_upload-input emp" id="emp_photo" value="<?php if (isset($_SESSION['emp-image'])) echo $_SESSION['emp-image']; ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="password">Password:</label>
                            <input type="text" name="password" id="password" value="<?php if (isset($_SESSION['emp-password'])) echo $_SESSION['emp-password']; ?>" required>
                        </div>

                        <div class="col">
                            <label for="con-password">Confirm Password:</label>
                            <input type="text" name="con-password" id="con-password" value="<?php if (isset($_SESSION['emp-password'])) echo $_SESSION['emp-password']; ?>" required>
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
                                    <option value="<?php echo $dep_row['dept_id']; ?>" <?php if (isset($_SESSION['emp-department']) && $_SESSION["emp-department"] == $dep_row["dept_id"]) echo "selected"; ?>><?php echo $dep_row['department']; ?></option>
                                <?php  }
                                ?>

                            </select>
                        </div>

                        <?php
                        if (isset($_SESSION['emp-id'])) {
                            echo "<input type = 'hidden' name='id' value = '".$_SESSION['emp-id']."'>";
                        }
                        ?>

                        <div class=" col">
                            <label for="add-employee" class="not-required">not required</label>
                            <button type="submit" name="<?php if (isset($_SESSION['emp-name']))
                                                            echo "update";
                                                        else echo "add" ?>" id="add-employee" class="button modal_form-submit-btn form_add-employees">
                                                    <?php
                                                    if (isset($_SESSION['emp-name']))
                                                        echo "Update Employee";
                                                    else echo "Add Employee"
                                                    ?>    
                                                    </button>
                        </div>
                    </div>
                </form>

            </div>
        </section>

        <div class="emplooyee_stat mt-20">

            <div class="flex items-center">
                <div class="emp_button-container flex gap items-center justify-start">
                    <!-- 
                        // popper-btn class listenes for click event and opens modal popup
                        // controlled from admin.js
                    -->
                    <button class="button border-curve-lg popper-btn">Add</button>
                    <?php
                    $sql_all = "SELECT name,username,email,active,department FROM employees";
                    $result_all = mysqli_query($conn, $sql_all);
                    $count_all = mysqli_num_rows($result_all);

                    $sql_active = "SELECT name,username,email,active,department FROM employees WHERE active =1";
                    $result_active = mysqli_query($conn, $sql_active);
                    $count_active = mysqli_num_rows($result_active);

                    $sql_inactive = "SELECT name,username,email,active,department FROM employees WHERE active = 0";
                    $result_inactive = mysqli_query($conn, $sql_inactive);
                    $count_inactive = mysqli_num_rows($result_inactive);

                    ?>

                    <form action="./backend/specific-users.php" method="post">
                        <input type="hidden" name="filter-by" value="all">
                        <button type="submit" name="specific-emp" class="button ml-35 border-curve-lg relative <?php if (isset($_SESSION['filter-by']) && $_SESSION['filter-by'] == "all") echo "active"; ?>">All
                            <div class="count-top shadow"><?php
                                                            echo $count_all;
                                                            ?>
                            </div>
                    </form>
                    <form action="./backend/specific-users.php" method="post">
                        <input type="hidden" name="filter-by" value="active">
                        <button type="submit" name="specific-emp" class="button ml-35 border-curve-lg relative <?php if (isset($_SESSION['filter-by']) && $_SESSION['filter-by'] == "active") echo "active"; ?> ">Active
                            <div class="count-top shadow"><?php
                                                            echo $count_active;
                                                            ?>
                            </div>
                    </form>
                    <form action="./backend/specific-users.php" method="post">
                        <input type="hidden" name="filter-by" value="inactive">
                        <button type="submit" name="specific-emp" class="button ml-35 border-curve-lg relative <?php if (isset($_SESSION['filter-by']) && $_SESSION['filter-by'] == "inactive") echo "active"; ?> ">Inactive
                            <div class="count-top shadow"><?php
                                                            echo $count_inactive;
                                                            ?>
                            </div>
                    </form>

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
            <?php
            // filter by session
            $sql = "select * from employees";
            if (isset($_SESSION['filter-by'])) {
                $filter_by = $_SESSION['filter-by'];
                if ($filter_by == 'all') {
                    $sql = "SELECT * FROM employees";
                } else if ($filter_by == 'active') {
                    $sql = "SELECT * FROM employees WHERE active = 1";
                } else if ($filter_by == 'inactive') {
                    $sql = "SELECT * FROM employees WHERE active = 0";
                }
            } else {
                $sql = "SELECT * FROM employees";
            }

            $result = mysqli_query($conn, $sql) or die("Query Failed.");
            if (mysqli_num_rows($result) > 0) {
            ?>
                <div class="emp_card_container flex wrap gap justify-start">

                    <?php while ($row = mysqli_fetch_assoc($result)) {
                        $sql_dept = "SELECT * FROM department WHERE dept_id = {$row['department']}";
                        $result_dept = mysqli_query($conn, $sql_dept) or die("Query Failed.");
                        $row_dept = mysqli_fetch_assoc($result_dept)['department'];
                        $id = $row['emp_id'];


                    ?>
                        <div class="employee_card p-20 text-center shadow border-curve-md">

                            <!-- overlay for disabled account -->

                            <div class="emp_card-overlay border-curve-md"></div>

                            <img src="../../images/ic_options.svg" alt="options menu" class="emp_card_option-menu table_option-menu">
                            <img src="../../uploads/employees/<?php echo $row["image"] ?>" class="emp_img" alt="user profile">
                            <h3 class="emp_name"><?php echo $row['name']; ?></h3>
                            <p class="emp_id"><?php echo $row_dept; ?></p>
                            <div class="flex emp_card_content items-center justify-start">
                                <img src="../../images/ic_acc.svg" alt="account icon">
                                <p><?php echo $row['username']; ?></p>
                            </div>
                            <div class="flex emp_card_content items-center justify-start">
                                <img src="../../images/ic_mail.svg" alt="mail icon">
                                <p><?php echo $row['email']; ?></p>
                            </div>

                            <!-- options -->
                            <div class="emp_card_options table_action_options shadow border-curve-md p-20">
                                <?php
                                if ($row['active'] == 1) {
                                ?>
                                    <form action="./backend/emp_block.php" method="post">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <div class="flex items-center justify-start">
                                            <img src="../../images/ic_disable.svg" alt="block">
                                            <button type="submit" name="block" class="no_bg no_outline" style="font-size: 1rem;">Block</button>
                                        </div>
                                    </form>
                                <?php
                                } else { ?>
                                    <form action="./backend/emp_enable.php" method="post">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <div class="flex items-center justify-start">
                                            <img src="../../images/ic_enable.svg" alt="activate">
                                            <button type="submit" name="activate" class="no_bg no_outline" style="font-size: 1rem;">Activate</button>
                                        </div>
                                    </form>
                                <?php
                                }
                                ?>
                                <form action="./backend/edit-employee.php" method="post" class="mt-20" class="flex items-center justify-start">
                                    <input type="hidden" name="id" value="<?php echo $id ?>">
                                    <input type="hidden" name="asd" value="asdfasdf">
                                    <input type="hidden" name="name" value="<?php echo $row["name"]; ?>">
                                    <input type="hidden" name="department" value="<?php echo $row["department"]; ?>">
                                    <input type="hidden" name="email" value="<?php echo $row["email"]; ?>">
                                    <input type="hidden" name="password" value="<?php echo $row["password"]; ?>">
                                    <input type="hidden" name="username" value="<?php echo $row["username"]; ?>">
                                    <input type="hidden" name="img" value="<?php echo $row["image"]; ?>">
                                    <div class="flex items-center justify-start">
                                        <img src="../../images/ic_edit.svg" alt="edit">
                                        <button type="submit" name="edit-emp" class="no_bg no_outline" style="font-size: 1rem;">Edit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>

                </div>
        </div>

    </main>

</body>

</html>