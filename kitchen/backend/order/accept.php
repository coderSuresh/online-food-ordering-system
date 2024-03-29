<?php
session_start();
require('../../../config.php');

if (!isset($_SESSION['kitchen-success'])) {
    header('location: ../../../invalid.html');
} else {
    if (isset($_POST['accept'])) {

        $order_id = unserialize(base64_decode(mysqli_real_escape_string($conn, $_POST['id'])));
        $kos_id = unserialize(base64_decode(mysqli_real_escape_string($conn, $_POST['kos_id'])));
       
        $sql = "UPDATE kos SET status = 'accepted' WHERE order_id in (" . implode(',', $order_id) . ") AND kos_id in (" . implode(',', $kos_id) . ")";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if ($result) {
            $_SESSION['order-success'] = "Order accepted successfully";
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