<?php
session_start();
require('../../../config.php');

if (!isset($_SESSION['delivery-success'])) {
    header('location: ../../../invalid.html');
} else {
    if (isset($_POST['reject-reason'])) {

        $order_id = unserialize(base64_decode(mysqli_real_escape_string($conn, $_POST['id'])));
        $tbd_id = unserialize(base64_decode(mysqli_real_escape_string($conn, $_POST['tbd_id'])));
        $reject_reason = mysqli_real_escape_string($conn, $_POST['reject-reason']);

        $sql = "UPDATE to_be_delivered SET status = 'rejected' WHERE order_id in (" . implode(',', $order_id) . ") and tbd_id in (" . implode(',', $tbd_id) . ")";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        foreach ($order_id as $id) {
            $sql_reason = "INSERT INTO reject_reason VALUES (DEFAULT, $id, 'delivery', '$reject_reason')";
            $result_reason = mysqli_query($conn, $sql_reason) or die(mysqli_error($conn));
        }

        if ($result && $result_reason) {
            $_SESSION['order-success-a'] = "Order rejected successfully";
            header('location: ../../index.php');
        } else {
            $_SESSION['order-error-a'] = "Something went wrong. Please try again";
            header('location: ../../index.php');
        }
    } else {
        header('location: ../../../invalid.html');
    }
}
