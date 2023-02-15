<?php
session_start();
require('../config.php');
if (isset($_POST['place-order']) || isset($_POST['place-order-buy'])) {

    $isFromBuy = false;

    if (isset($_POST['place-order-buy'])) {
        $isFromBuy = true;
        $f_id = mysqli_real_escape_string($conn, $_POST['f_id']);
        $q = mysqli_real_escape_string($conn, $_POST['qty']);
    } else {
        $food_id = mysqli_real_escape_string($conn, $_POST['food_id']);
        $qty = mysqli_real_escape_string($conn, $_POST['quantity']);

        $fo_id = unserialize(base64_decode($food_id));
        $quantity = unserialize(base64_decode($qty));
    }

    $uid = $_SESSION['user'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $note = mysqli_real_escape_string($conn, $_POST['note']);

    if ($note == "") {
        $note = "No note";
    }

    function redirect()




    {
        if (isset($_POST['place-order'])) {
            header("location: ../checkout.php");
        } else if (isset($_POST['place-order-buy'])) {
            header("location: ../buy.php");
        }
    }

    function placeOrder($f_id, $q, $uid, $name, $phone, $address, $note, $conn)
    {
        $sql_food_info = "select price from food where f_id = $f_id";
        $res_food_info = mysqli_query($conn, $sql_food_info) or die("Could not get food info");
        $row_food_info = mysqli_fetch_assoc($res_food_info);
        $price = $row_food_info['price'];

        $total_price = (intval($price) * intval($q));
        $vat = $total_price * 13 / 100;
        $total_price = $total_price + $vat;

        $sql = "insert into orders values (DEFAULT, $uid, $q, $f_id, $total_price, '$note', NOW())";
        $res = mysqli_query($conn, $sql) or die("Could not place order");
        $order_id = mysqli_insert_id($conn);

        $sql_o_c_t = "insert into order_contact_details values (DEFAULT, $order_id, '$address', '$phone', '$name')";
        $res_o_c_t = mysqli_query($conn, $sql_o_c_t) or die("Could not insert order contact details");

        $sql_aos = "insert into aos values (DEFAULT, $order_id, 'pending')";
        $res_aos = mysqli_query($conn, $sql_aos) or die("Could not insert into aos");

        if ($res && $res_o_c_t && $res_aos) {
            $sql_remove_cart = "delete from cart where food_id = $f_id and customer_id = $uid";
            $res_remove_cart = mysqli_query($conn, $sql_remove_cart) or die("Could not remove from cart");
        } else {
            $_SESSION['order_placed'] = "Order could not be placed";
            header("Location: ../track-order.php");
        }

        if ($res && $res_o_c_t && $res_aos) {
            $_SESSION['order_placed'] = "Order placed successfully";
            // header("Location: ../track-order.php");
        } else {
            $_SESSION['order_placed'] = "Order could not be placed";
            header("Location: ../track-order.php");
        }
    }

    if (!preg_match("/^[a-z A-z]{2,}$/", $name)) {
        $_SESSION['name_error'] = "Name must contain only letters and must be at least 2 characters long";
        redirect();
    } else if (!preg_match("/^[0-9]{10}$/", $phone)) {
        $_SESSION['phone_error'] = "Phone number must contain only 10 digits";
        redirect();
    } else if (!preg_match("/^[a-zA-z,0-9 -]{5,}$/", $address)) {
        $_SESSION['address_error'] = "Address must contain only letters, numbers, commas and must be at least 5 characters long";
        redirect();
    } else if (!preg_match("/^[a-z A-z\/0-9]{5,}$/", $note)) {
        $_SESSION['note_error'] = "Note must contain only letters, numbers and must be at least 5 characters long";
        redirect();
    } else {

        if ($isFromBuy) {
            placeOrder($f_id, $q, $uid, $name, $phone, $address, $note, $conn);
        } else {
            foreach (array_combine($fo_id, $quantity) as $f_id => $q) {
                placeOrder($f_id, $q, $uid, $name, $phone, $address, $note, $conn);
            }
        }
    }
} else {
    header("Location: ../invalid.html");
}
