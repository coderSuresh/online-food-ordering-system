<?php
session_start();
require('../../../config.php');

if (!isset($_SESSION['admin-success'])) {
    header('location: ../../../invalid.html');
} else {
    if (isset($_POST['accept'])) {

        $order_id = mysqli_real_escape_string($conn, $_POST['id']);
        $aos_id = mysqli_real_escape_string($conn, $_POST['aos_id']);

        $sql = "UPDATE aos SET status = 'accepted' WHERE order_id = {$order_id} and aos_id = {$aos_id}";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        $sql_insert = "insert into kos values (DEFAULT, $order_id, 'pending', NOW())";
        $result_insert = mysqli_query($conn, $sql_insert) or die(mysqli_error($conn));

        if ($result && $result_insert) {
            $_SESSION['order-success-a'] = "Order accepted successfully";
            header('location: ../../order-details.php');
        } else {
            $_SESSION['order-error-a'] = "Something went wrong. Please try again";
            header('location: ../../order-details.php');
        }
    } else {
        header('location: ../../../invalid.html');
    }
}
?>