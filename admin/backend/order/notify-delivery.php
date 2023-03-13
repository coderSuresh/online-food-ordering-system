<?php
session_start();
require('../../../config.php');

if (!isset($_SESSION['admin-success'])) {
    header('location: ../../../invalid.html');
} else {
    if (isset($_POST['notify-delivery'])) {

        $order_id = mysqli_real_escape_string($conn, $_POST['id']);
        $aos_id = mysqli_real_escape_string($conn, $_POST['aos_id']);

        $sql = "UPDATE aos SET status = 'delivering' WHERE order_id = {$order_id} and aos_id = {$aos_id}";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        // remove older order from to_be_delivered table
        $sql_delete_tbd = "delete from to_be_delivered where date <= DATE_SUB(NOW(), INTERVAL 1 DAY)";
        mysqli_query($conn, $sql_delete_tbd) or die(mysqli_error($conn));

        $sql_insert_tbd = "insert into to_be_delivered values(DEFAULT, $order_id, 'pending', NOW())";
        $res_insert_tbd = mysqli_query($conn, $sql_insert_tbd) or die(mysqli_error($conn));

        if ($result && $res_insert_tbd) {
            $_SESSION['order-success-a'] = "Delivery staff notified successfully";
            header('location: ../../order-details.php');
        } else {
            $_SESSION['order-error-a'] = "Something went wrong. Please try again";
            header('location: ../../order-details.php');
        }
    } else {
        header('location: ../../../invalid.html');
    }
}
