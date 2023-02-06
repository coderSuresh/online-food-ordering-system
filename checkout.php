<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | RestroHub</title>
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>
    <header>
        <nav class="top_nav flex items-center">
            <div class="logo__back-btn flex items-center">
                <!-- back btn -->
                <button class="nav__btn-back no_bg no_outline"><img src="./images/ic_back.svg" alt="go back"></button>
                <a href="./index.php" class="logo heading flex items-center"><img src="./images/logo.png" alt="logo">Restro
                    <span>Hub</span>
                </a>
            </div>

            <ul class="flex items-center">
                <li class="flex direction-col"><a href="menu.php">Menu</a></li>

                <!-- nav search form -->
                <li>
                    <form action="#" method="post" class="search_form flex items-center border-curve-lg">
                        <input type="search" name="search" placeholder="search..." id="search" class="search no_outline">
                        <button type="submit" class="btn_search no_outline no_bg"><img src="./images/ic_search.svg" alt="search icon" class="icon_search"></button>
                    </form>
                </li>

                <!-- show profile icon if the user is logged in -->
                <?php
                if (isset($_SESSION['success'])) {
                    echo '<li class="flex direction-col">
                            <img src="./images/logo.png" class="user_profile_icon" alt="account">
                            <div class="logout-dropdown border-curve shadow p-20">
                                <a href="./customer_auth/logout.php">Logout</a>   
                            </div>                         
                          </li>
                          ';
                } else {
                    echo '<li class="flex direction-col"><a href="./customer_auth/login.php"><img src="./images/ic_acc.svg" alt="account">
                    <span class="nav__tooltip shadow p-20">Login</span></a>';
                }
                ?>
        </nav>

    </header>

    <main style="margin: 0 40px 40px;">

        <section class="mt-20">
            <h2 class="heading">Checkout</h2>
        </section>

        <?php
        session_start();
        // include config file
        require('./config.php');

        $username = $_SESSION['user'];

        // get user id
        $sql_uid = "SELECT id FROM customer WHERE username = '$username'";
        $result_uid = mysqli_query($conn, $sql_uid) or die("Couldn't fetch user id");
        $row_uid = mysqli_fetch_assoc($result_uid);
        $uid = $row_uid['id'];

        $sql = "select * from cart where customer_id = $uid";

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
                    <th>Options</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
                <?php
                $i = 0;
                $totalPrice = 0;
                while ($row = mysqli_fetch_assoc($res)) {
                    $i++;

                    // fetch category name
                    $food_id = $row['food_id'];
                    $sql_food = "select * from food where f_id = $food_id";
                    $res_food = mysqli_query($conn, $sql_food) or die("Could not fetch food details from database");
                    $row_food = mysqli_fetch_assoc($res_food);

                    $foodName = $row_food['name'];
                    $foodPrice = $row_food['price'];
                    $quantity = $row['quantity'];

                    $totalPrice += $foodPrice * $row['quantity'];

                    $foodImg = $row_food['img'];
                ?>
                    <tr class="shadow">
                        <td>
                            <?php echo $i; ?>
                        </td>
                        <td>
                            <img src="./uploads/foods/<?php echo $foodImg; ?>" alt="food image" class="table_food-img">
                        </td>
                        <td>
                            <?php echo $foodName; ?>
                        </td>
                        <td>
                            <select name="options" class="p_7-20" id="options">
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                                <option value="3">Option 3</option>
                            </select>
                        <td>
                            <?php echo $foodPrice; ?>
                        </td>
                        <td>
                            <?php echo $quantity; ?>
                        </td>
                        <td>
                            <?php echo $foodPrice * $quantity; ?>
                        </td>
                        <td>
                            <img src="./images/ic_delete.svg" class="pointer" alt="remove from cart">
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>

            <div class="mt-20 flex justify-center">
                <div>
                    <form action="#" method="post" class="checkout_form flex direction-col shadow border-curve p-20">
                        <label for="name">Name:*</label>
                        <input type="text" placeholder="John Sharma" name="name" class="p_7-20" id="name" required autofocus>
                        <label for="phone">Phone:*</label>
                        <input type="tel" name="phone" placeholder="9800000000" class="p_7-20" id="phone" required>
                        <label for="address">Address:*</label>
                        <input type="text" name="address" placeholder="Chardobato, Banepa near check post" class="p_7-20" id="address" required>
                        <label for="note">Note:</label>
                        <input type="text" placeholder="example: with extra cheese" name="note" class="p_7-20" id="note">
                        <p>Payment Method</p>
                        <div class="flex items-center justify-start">
                            <input type="radio" name="payment-method" id="payment-method">
                            <label for="payment-method">Cash on Delivery</label>
                        </div>
                        <button type="submit" class="button mt-20 w-full border-curve">Place Order</a>
                    </form>
                </div>
                <div class="direction-col justify-start ml-35 p-20 shadow border-curve">
                    <div class="checkout_info">
                        <h5>Total: <?php echo $totalPrice; ?></h5>
                        <h5>Vat (13%): <?php echo $vat = ($totalPrice * 13) / 100; ?> </h5>
                        <h5>Grand Total: Rs. <?php echo $totalPrice + $vat; ?></h5>
                    </div>
                    <div class="mt-20 flex direction-col">
                        <a href="./index.php" class="button mt-20 border-curve" style="background-color: #F7922F0a;">Continue Shopping</a>
                    </div>
                </div>
            <?php
        } else
            echo "No records found";
            ?>
    </main>

    <?php require('./components/footer.php') ?>

    <script type="module" src="./js/app.js"></script>
</body>

</html>