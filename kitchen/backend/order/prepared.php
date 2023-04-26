<?php
session_start();
require('../../../config.php');

if (!isset($_SESSION['kitchen-success'])) {
    header('location: ../../../invalid.html');
} else {
    if (isset($_POST['prepared'])) {

        $order_id = unserialize(base64_decode(mysqli_real_escape_string($conn, $_POST['id'])));
        $kos_id = unserialize(base64_decode(mysqli_real_escape_string($conn, $_POST['kos_id'])));
        $aos_id = unserialize(base64_decode(mysqli_real_escape_string($conn, $_POST['aos_id'])));

        $sql = "UPDATE kos SET status = 'prepared' WHERE order_id in (" . implode(',', $order_id) . ") AND kos_id in (" . implode(',', $kos_id) . ")";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        $sql_aos = "UPDATE aos SET status = 'prepared' WHERE order_id in (" . implode(',', $order_id) . ") AND aos_id in (" . implode(',', $aos_id) . ")";
        $result_aos = mysqli_query($conn, $sql_aos) or die(mysqli_error($conn));

        if ($result && $result_aos) {
            $_SESSION['order-success'] = "Order status updated successfully";
            header('location: ../../index.php');
        } else {
            $_SESSION['order-error'] = "Something went wrong. Please try again";
            header('location: ../../index.php');
        }
    } else {
        header('location: ../../../invalid.html');
    }
}
?>