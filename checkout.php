<?php
session_start();
if (!isset($_SESSION['success'])) {
    header('Location: ./index.php');
}
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
    <link rel="stylesheet" href="./styles/responsive.css">

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
                <div class="count-top cart_count-top shadow" style="position:fixed; right: -200px;"></div>
            </ul>
        </nav>
    </header>

    <main style="margin: 0 40px 40px;">
    
        <button class="go_top no_bg no_outline"><img src="./images/ic_top.svg" alt="go to top"></button>

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
        if (isset($_SESSION['note_error'])) {
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

        <?php
        require('./config.php');

        $uid = $_SESSION['user'];
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
        if (isset($_SESSION['minimum_error'])) {
        ?>
            <p class="error-container error p_7-20">
                <?php
                echo $_SESSION['minimum_error'];
                unset($_SESSION['minimum_error']);
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
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
                <?php
                $i = 0;
                $totalPrice = 0;
                $food_id_arr = array();
                $qty_arr = array();
                while ($row = mysqli_fetch_assoc($res)) {
                    $i++;
                    $food_id = $row['food_id'];
                    $sql_food = "select * from food where f_id = $food_id";
                    $res_food = mysqli_query($conn, $sql_food) or die("Could not fetch food details from database");
                    $row_food = mysqli_fetch_assoc($res_food);
                    $cart_id = $row['id'];

                    $foodName = $row_food['name'];
                    $foodPrice = $row_food['price'];
                    $quantity = $row['quantity'];
                    $totalPrice += $foodPrice * $row['quantity'];
                    $foodImg = $row_food['img'];
                    $vat = ($totalPrice * 13) / 100;

                    array_push($food_id_arr, $food_id);
                    array_push($qty_arr, $quantity);
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
                            <?php echo $foodPrice; ?>
                        </td>
                        <td>
                            <form action="#" method="post" class="flex items-center justify-evenly checkout_item-form">
                                <button type="button" class="cart_item-btn checkout_inc no_bg no_outline"><img src="./images/ic_add.svg" alt="increment"></button>
                                <input type="text" name="quantity" class="cart_qty no_bg no_outline" value="<?php echo $quantity; ?>" disabled>
                                <input type="hidden" name="id" value="<?php echo $cart_id; ?>">
                                <input type="hidden" name="from_checkout">
                                <button type="button" class="cart_item-btn checkout_dec no_bg no_outline"><img src="./images/ic_remove.svg" alt="decrement"></button>
                            </form>
                        </td>
                        <td>
                            <?php echo $foodPrice * $quantity; ?>
                        </td>
                        <td>
                            <form action="./backend/remove-from-cart.php" method="post" class="checkout_content-form">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="no_bg no_outline btn_remove-from-checkout">
                                    <img src="./images/ic_delete.svg" alt="remove from cart">
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>

            <div class="mt-20 flex justify-center">
                <div>
                    <!--./backend/place-order.php-->
                    <form action="./backend/place-order.php" method="post" class="checkout_form flex direction-col shadow border-curve p-20">
                        <label for="name">Name:*</label>
                        <input type="text" placeholder="John Sharma" name="name" class="p_7-20" id="name" required autofocus>
                        <label for="phone">Phone:*</label>
                        <input type="tel" name="phone" maxlength="10" placeholder="9800000000" class="p_7-20" id="phone" required>
                        <label for="address">Address:*</label>
                        <input type="text" name="address" placeholder="Chardobato, Banepa near check post" class="p_7-20" id="address" required>
                        <label for="note">Note:</label>
                        <input type="text" placeholder="example: without sugar" name="note" class="p_7-20" id="note">
                        <p style="font-weight: 700; margin-top: 10px;">Payment Method</p>
                        <div class="flex items-center justify-start">
                            <input type="radio" name="payment-method" id="payment-method" checked>
                            <label for="payment-method" style="white-space: nowrap; margin-left: 10px;">Cash on Delivery</label>
                        </div>
                        <input type="hidden" name="food_id" value="<?php echo base64_encode(serialize($food_id_arr)); ?>">
                        <input type="hidden" name="quantity" value="<?php echo base64_encode(serialize($qty_arr)); ?>">
                        <button type="submit" class="button mt-20 w-full border-curve place_order" name="place-order">Place Order</a>
                    </form>
                </div>
                <div class="direction-col justify-start ml-35 p-20 shadow border-curve">
                    <div class="checkout_info">
                        <h5>Total: <?php echo $totalPrice; ?></h5>
                        <h5>Vat (13%): <?php echo $vat; ?> </h5>
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
    <!-- <script src="/firebase-messaging-sw.js" type = "module"></script> -->
</body>

</html>