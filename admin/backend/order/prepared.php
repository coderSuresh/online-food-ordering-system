<?php
session_start();
require('../../../config.php');

if (!isset($_SESSION['admin-success'])) {
    header('location: ../../../invalid.html');
} else {
    if (isset($_POST['prepared'])) {

        $order_id = unserialize(base64_decode(mysqli_real_escape_string($conn, $_POST['id'])));
        $aos_id = unserialize(base64_decode(mysqli_real_escape_string($conn, $_POST['aos_id'])));

        $sql = "UPDATE aos SET status = 'prepared' WHERE order_id in (" . implode(',', $order_id) . ") and aos_id in (" . implode(',', $aos_id) . ")";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if ($result) {
            $_SESSION['order-success-a'] = "Order prepared";
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