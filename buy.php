<?php
session_start();
if (!isset($_SESSION['success'])) {
    echo '<script>alert("Please login first to access this page")</script>';
    header("Location: ./customer_auth/login.php");
}
require('./config.php');
?>
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

        <?php
        if (isset($_SESSION["name_error"])) {
        ?>
            <p class="error-container error p_7-20">
                <?php echo $_SESSION["name_error"]; ?>
            </p>
        <?php
            unset($_SESSION["name_error"]);
        }
        ?>

        <?php
        if (isset($_SESSION["phone_error"])) {
        ?>
            <p class="error-container error p_7-20">
                <?php echo $_SESSION["phone_error"]; ?>
            </p>
        <?php
            unset($_SESSION["phone_error"]);
        }

        if (isset($_SESSION["address_error"])) {
        ?>
            <p class="error-container error p_7-20">
                <?php echo $_SESSION["address_error"]; ?>
            </p>
        <?php
            unset($_SESSION["address_error"]);
        }
        ?>

        <?php
        if(isset($_SESSION['note_error'])) {
        ?>
            <p class="error-container error p_7-20">
                <?php echo $_SESSION['note_error']; ?>
            </p>
        }
        <?php
            unset($_SESSION['note_error']);
        }
        ?>

        <section class="mt-20">
            <h2 class="heading">Checkout</h2>
        </section>

        <table class="mt-20">
            <tr class="shadow">
                <th>SN</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
            </tr>
            <?php
            $totalPrice = 0;

            if (isset($_POST['f_id'])) {
                $_SESSION['food_id'] = $_POST['f_id'];
                $_SESSION['quantity'] = $_POST['quantity'];
            }

            $food_id = $_SESSION['food_id'];
            $quantity = $_SESSION['quantity'];

            $sql_food = "select * from food where f_id = $food_id";
            $res_food = mysqli_query($conn, $sql_food) or die("Could not fetch food details from database");
            $row_food = mysqli_fetch_assoc($res_food);

            $foodName = $row_food['name'];
            $foodPrice = $row_food['price'];
            $totalPrice += $foodPrice * $quantity;
            $foodImg = $row_food['img'];

            $vat = ($totalPrice * 13) / 100;
            ?>
            <tr class="shadow">
                <td>1</td>
                <td>
                    <img src="./uploads/foods/<?php echo $foodImg; ?>" alt="food image" class="table_food-img">
                </td>
                <td>
                    <?php echo $foodName; ?>
                </td>
                <td>
                    <?php echo $foodPrice; ?>
                </td>
                <td>
                    <?php echo $quantity; ?>
                </td>
                <td>
                    <?php echo $foodPrice * $quantity; ?>
                </td>
            </tr>
        </table>

        <div class="mt-20 flex justify-center">
            <div>
                <form action="./backend/place-order.php" method="post" class="checkout_form flex direction-col shadow border-curve p-20">
                    <label for="name">Name:*</label>
                    <input type="text" placeholder="John Sharma" name="name" class="p_7-20" id="name" required autofocus>
                    <label for="phone">Phone:*</label>
                    <input type="tel" name="phone" placeholder="9800000000" maxlength="10" class="p_7-20" id="phone" required>
                    <label for="address">Address:*</label>
                    <input type="text" name="address" placeholder="Chardobato, Banepa near check post" class="p_7-20" id="address" required>
                    <label for="note">Note:</label>
                    <input type="text" placeholder="example: with extra cheese" name="note" class="p_7-20" id="note">
                    <p style="font-weight: 700; margin-top: 10px;">Payment Method</p>
                    <div class="flex items-center justify-start">
                        <input type="radio" name="payment-method" id="payment-method" checked>
                        <label for="payment-method" style="white-space: nowrap; margin-left: 10px;">Cash on Delivery</label>
                    </div>
                    <input type="hidden" name="food_id" value="<?php echo $food_id; ?>">
                    <input type="hidden" name="quantity" value="<?php echo $quantity; ?>">
                    <input type="hidden" name="total_price" value="<?php echo $totalPrice; ?>">
                    <button type="submit" name="place-order" class="button mt-20 w-full border-curve">Place Order</a>
                </form>
            </div>
            <div class="direction-col justify-start ml-35 p-20 shadow border-curve">
                <div class="checkout_info">
                    <h5>Total: <?php echo $totalPrice; ?></h5>
                    <h5>Vat (13%): <?php echo $vat; ?> </h5>
                    <h5>Grand Total: Rs. <?php echo $totalPrice + $vat; ?></h5>
                </div>
                <div class="mt-20 flex direction-col">
                    <a href="./menu.php" class="button mt-20 border-curve" style="background-color: #F7922F0a;">Continue Shopping</a>
                </div>
            </div>
    </main>

    <?php require('./components/footer.php') ?>

    <script type="module" src="./js/app.js"></script>
</body>

</html>