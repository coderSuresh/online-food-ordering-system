<?php
session_start();
require('../config.php');
if (isset($_POST['place-order']) || isset($_POST['place-order-buy'])) {
    $f_id = $_POST['food_id'];
    $quantity = $_POST['quantity'];
    $total_price = $_POST['total_price'];
    $uid = $_SESSION['user'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $note = $_POST['note'];

    if ($note == "") {
        $note = "No note";
    }

    function redirect() {
        if(isset($_POST['place-order'])) {
            header("location: ../checkout.php");
        }
        else if (isset($_POST['place-order-buy'])) {
            header("location: ../buy.php");
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
        $sql = "insert into orders values (DEFAULT, $uid, $quantity, $f_id, $total_price, '$note', NOW())";
        $res = mysqli_query($conn, $sql) or die("Could not place order");
        $order_id = mysqli_insert_id($conn);

        $sql_o_c_t = "insert into order_contact_details values (DEFAULT, $order_id, '$address', '$phone', '$name')";
        $res_o_c_t = mysqli_query($conn, $sql_o_c_t) or die("Could not insert order contact details");

        if ($res && $res_o_c_t) {
            $_SESSION['order_placed'] = "Order placed successfully";
            header("Location: ../track-order.php");
        }
    }
} else {
    header("Location: ../invalid.html");
}
?>