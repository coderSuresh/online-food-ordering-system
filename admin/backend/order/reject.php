<?php
session_start();
require('../../../config.php');

$response = array();

if (!isset($_SESSION['admin-success'])) {
    header('location: ../../../invalid.html');
} else {
    if (isset($_POST['reject'])) {

        $order_id = mysqli_real_escape_string($conn, $_POST['id']);
        $aos_id = mysqli_real_escape_string($conn, $_POST['aos_id']);

        $sql = "UPDATE aos SET status = 'rejected' WHERE order_id = {$order_id} and aos_id = {$aos_id}";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        $sql_fetch_kitchen_status = "select status from kos where order_id = {$order_id}";
        $result_fetch_kitchen_status = mysqli_query($conn, $sql_fetch_kitchen_status) or die(mysqli_error($conn));
        $row = mysqli_fetch_assoc($result_fetch_kitchen_status);

        if ($row['status'] == 'pending') {
            $sql_insert = "delete from kos where order_id = {$order_id}";
            $result_insert = mysqli_query($conn, $sql_insert) or die(mysqli_error($conn));
        }

        if ($result) {
            $_SESSION['order-success'] = "Order rejected successfully";
            header('location: ../../order-details.php');
        } else {
            $_SESSION['order-error'] = "Something went wrong. Please try again";
            header('location: ../../order-details.php');
        }
    } else {
        header('location: ../../../invalid.html');
    }
}
