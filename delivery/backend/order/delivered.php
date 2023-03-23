<?php
session_start();
require('../../../config.php');

if (!isset($_SESSION['delivery-success'])) {
    header('location: ../../../invalid.html');
} else {
    if (isset($_POST['delivered'])) {

        $order_id = mysqli_real_escape_string($conn, $_POST['id']);
        $tbd_id = mysqli_real_escape_string($conn, $_POST['tbd_id']);

        $order_id = unserialize(base64_decode($order_id));
        $tbd_id = unserialize(base64_decode($tbd_id));

        $sql = "UPDATE to_be_delivered SET status = 'delivered' WHERE order_id in (" . implode(',', $order_id) . ") and tbd_id in (" . implode(',', $tbd_id) . ")";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if ($result) {
            $_SESSION['delivery-success'] = "Order status updated successfully";
            header('location: ../../index.php');
        } else {
            $_SESSION['delivery-error'] = "Something went wrong. Please try again";
            header('location: ../../index.php');
        }
    } else {
        header('location: ../../../invalid.html');
    }
}
