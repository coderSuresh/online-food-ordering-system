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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body>
    <?php

    require './components/header.php';
    if (!isset($_SESSION['success'])) {
        echo '<script>alert("Please login first to access this page")</script>';
        header("Location: ./customer_auth/login.php");
    }
    require('./config.php');
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

        <div class="checkout_table">

            <table class="mt-20">
                <tr class="shadow">
                    <th>SN</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
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
                        <div class="w-fit" style="margin: auto;">
                            <a href="./details.php?name=<?php echo str_replace(" ", "-", strtolower($foodName)); ?>">
                                <?php echo $foodName; ?>
                            </a>
                            <hr>
                        </div>
                    </td>
                    <td>
                        <div class="flex items-center justify-evenly">
                            <button class="buy_inc no_bg no_outline"><img src="./images/ic_add.svg"></button>
                            <p class="buy_page_qty"><?php echo $quantity; ?></p>
                            <button class="buy_dec no_bg no_outline"><img src="./images/ic_remove.svg"></button>
                        </div>
                    </td>
                    <td class="buy_price">
                        <?php echo $foodPrice; ?>
                    </td>
                    <td class="price_total">
                        <?php echo $foodPrice * $quantity; ?>
                    </td>
                </tr>
            </table>
        </div>

        <?php
        $isFromBuy = true;
        require './components/checkout-form.php'; 
        ?>

    </main>

    <?php require './components/get-footer-script.php'; ?>