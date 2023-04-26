<?php
session_start();
require('../../../config.php');

if (!isset($_SESSION['kitchen-success'])) {
    header('location: ../../../invalid.html');
} else {
    if (isset($_POST['reject-reason']) && isset($_POST['kos_id'])) {

        $order_id = unserialize(base64_decode(mysqli_real_escape_string($conn, $_POST['id'])));
        $id = unserialize(base64_decode(mysqli_real_escape_string($conn, $_POST['kos_id'])));

        $reject_reason = mysqli_real_escape_string($conn, $_POST['reject-reason']);

        $sql = "UPDATE kos SET status = 'rejected' WHERE order_id in (" . implode(',', $order_id) . ") and kos_id in (" . implode(',', $id) . ")";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        $track_id = "";

        $sql_get_track_id = "select track_id from orders where id in (" . implode(',', $order_id) . ") limit 1";
        $result_get_track_id = mysqli_query($conn, $sql_get_track_id) or die("err: " . mysqli_error($conn));
        $row = mysqli_fetch_assoc($result_get_track_id);
        $track_id = $row['track_id'];

        $sql_reason = "INSERT INTO reject_reason VALUES (DEFAULT, '$track_id', 'kitchen', '$reject_reason')";
        $result_reason = mysqli_query($conn, $sql_reason) or die(mysqli_error($conn));

        $sql_aos = "UPDATE aos SET status = 'rejected' WHERE order_id in (" . implode(',', $order_id) . ")";
        $result_aos = mysqli_query($conn, $sql_aos) or die(mysqli_error($conn));

        if ($result && $result_reason) {
            $_SESSION['order-success-k'] = "Order rejected successfully";
            header('location: ../../index.php');
        } else {
            $_SESSION['order-error-k'] = "Something went wrong. Please try again";
            header('location: ../../index.php');
        }
    } else {
        header('location: ../../../invalid.html');
    }
}
