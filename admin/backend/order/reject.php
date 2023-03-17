<?php
session_start();
require('../../../config.php');

if (!isset($_SESSION['admin-success'])) {
    header('location: ../../../invalid.html');
} else {
    if (isset($_POST['reject-reason'])) {

        $order_id = unserialize(base64_decode(mysqli_real_escape_string($conn, $_POST['id'])));
        $aos_id = unserialize(base64_decode(mysqli_real_escape_string($conn, $_POST['aos_id'])));
        $reject_reason = mysqli_real_escape_string($conn, $_POST['reject-reason']);

        $sql = "UPDATE aos SET status = 'rejected' WHERE order_id in (" . implode(',', $order_id) . ") and aos_id in (" . implode(',', $aos_id) . ")";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        $sql_fetch_kitchen_status = "select status from kos where order_id in (" . implode(',', $order_id) . ")";
        $result_fetch_kitchen_status = mysqli_query($conn, $sql_fetch_kitchen_status) or die(mysqli_error($conn));
        $row = mysqli_fetch_assoc($result_fetch_kitchen_status);

        if ($row['status'] == 'pending') {
            $sql_insert = "delete from kos where order_id in (" . implode(',', $order_id) . ")";
            $result_insert = mysqli_query($conn, $sql_insert) or die(mysqli_error($conn));
        }

        foreach ($order_id as $id) {
            $sql_reason = "INSERT INTO reject_reason VALUES (DEFAULT, $id, 'admin', '$reject_reason')";
            $result_reason = mysqli_query($conn, $sql_reason) or die(mysqli_error($conn));
        }

        if ($result && $result_reason) {
            $_SESSION['order-success-a'] = "Order rejected successfully";
            header('location: ../../order-details.php');
        } else {
            $_SESSION['order-error-a'] = "Something went wrong. Please try again";
            header('location: ../../order-details.php');
        }
    } else {
        header('location: ../../../invalid.html');
    }
}
