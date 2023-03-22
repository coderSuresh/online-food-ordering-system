<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#F7922F">
    <title>Checkout | RestroHub</title>
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/responsive.css">

</head>

<body>
    <?php
    require './components/header.php';
    if (!isset($_SESSION['success'])) {
        header('Location: ./index.php');
    }
    ?>

    <main class="checkout_page" style="margin: 0 40px 40px;">

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
            <div class="checkout_table">
                <table class="mt-20">
                    <tr class="shadow">
                        <th>SN</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
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
                                <div class="w-fit" style="margin: auto;">
                                    <a href="./details.php?name=<?php echo str_replace(" ", "-", strtolower($foodName)); ?>">
                                        <?php echo $foodName; ?>
                                    </a>
                                    <hr>
                                </div>
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
                                <?php echo $foodPrice; ?>
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
            </div>

            <?php
            $isFromCheckout = true;
            require './components/checkout-form.php';
            ?>

        <?php
        } else
            echo "No records found";
        ?>
    </main>

    <?php require './components/get-footer-script.php'; ?>