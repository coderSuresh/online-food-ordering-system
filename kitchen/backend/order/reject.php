<?php
session_start();
require('../../../config.php');

// TODO: replace this with the kitchen-success session
if (!isset($_SESSION['kitchen-success'])) {
    header('location: ../../../invalid.html');
} else {
    if (isset($_POST['reject-reason'])) {

        $order_id = mysqli_real_escape_string($conn, $_POST['id']);
        $kos_id = mysqli_real_escape_string($conn, $_POST['kos_id']);
        $aos_id = mysqli_real_escape_string($conn, $_POST['aos_id']);
        $reject_reason = mysqli_real_escape_string($conn, $_POST['reject-reason']);

        $sql = "UPDATE kos SET status = 'rejected' WHERE order_id = {$order_id} and kos_id = {$kos_id}";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
 
        $sql_aos = "UPDATE aos SET status = 'rejected' WHERE order_id = {$order_id} and aos_id = {$aos_id}";
        $result_aos = mysqli_query($conn, $sql_aos) or die(mysqli_error($conn));

        $sql_reason = "INSERT INTO reject_reason VALUES (DEFAULT, $order_id, 'kitchen', '$reject_reason')";
        $result_reason = mysqli_query($conn, $sql_reason) or die(mysqli_error($conn));

        if ($result && $result_reason && $result_aos) {
            $_SESSION['order-success'] = "Order rejected successfully";
            header('location: ../../index.php');
        } else {
            $_SESSION['order-error'] = "Something went wrong. Please try again";
            header('location: ../../index.php');
        }
    } else {
        header('location: ../../../invalid.html');
    }
}
