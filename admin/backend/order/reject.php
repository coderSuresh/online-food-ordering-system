<?php
session_start();
require('../../../config.php');

if (!isset($_SESSION['admin-success'])) {
    header('location: ../../../invalid.html');
} else {
    if (isset($_POST['reject-reason'])) {

        function redirect()
        {
            if (isset($_POST['aos_id']) && !empty($_POST['aos_id'])) {
                header('location: ../../order-details.php');
            } elseif (isset($_POST['fo_id']) && !empty($_POST['fo_id'])) {
                header('location: ../../future-details.php');
            }
        }

        $order_id = unserialize(base64_decode(mysqli_real_escape_string($conn, $_POST['id'])));

        if (isset($_POST['aos_id']))
            $id = unserialize(base64_decode(mysqli_real_escape_string($conn, $_POST['aos_id'])));
        elseif (isset($_POST['fo_id']))
            $id = unserialize(base64_decode(mysqli_real_escape_string($conn, $_POST['fo_id'])));

        $reject_reason = mysqli_real_escape_string($conn, $_POST['reject-reason']);

        if (isset($_POST['aos_id']))
            $sql = "UPDATE aos SET status = 'rejected' WHERE order_id in (" . implode(',', $order_id) . ") and aos_id in (" . implode(',', $id) . ")";
        elseif (isset($_POST['fo_id']))
            $sql = "UPDATE future_orders SET status = 'rejected' WHERE order_id in (" . implode(',', $order_id) . ") and fo_id in (" . implode(',', $id) . ")";

        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if (isset($_POST['aos_id'])) {
            $sql_fetch_kitchen_status = "select status from kos where order_id in (" . implode(',', $order_id) . ")";
            $result_fetch_kitchen_status = mysqli_query($conn, $sql_fetch_kitchen_status) or die(mysqli_error($conn));
            $row = mysqli_fetch_assoc($result_fetch_kitchen_status);

            if (mysqli_num_rows($result_fetch_kitchen_status) > 0) {
                if ($row['status'] == 'pending') {
                    $sql_delete = "delete from kos where order_id in (" . implode(',', $order_id) . ")";
                    $result_delete = mysqli_query($conn, $sql_delete) or die(mysqli_error($conn));
                }
            }
        } else {
            $sql_delete = "delete from future_orders where order_id in (" . implode(',', $order_id) . ")";
            $result_delete = mysqli_query($conn, $sql_delete) or die(mysqli_error($conn));
        }

        $track_id = "";

        $sql_get_track_id = "select track_id from orders where id in (" . implode(',', $order_id) . ") limit 1";
        $result_get_track_id = mysqli_query($conn, $sql_get_track_id) or die("err: " . mysqli_error($conn));
        $row = mysqli_fetch_assoc($result_get_track_id);
        $track_id = $row['track_id'];

        $sql_reason = "INSERT INTO reject_reason VALUES (DEFAULT, '$track_id', 'admin', '$reject_reason')";
        $result_reason = mysqli_query($conn, $sql_reason) or die(mysqli_error($conn));

        if ($result && $result_reason) {
            $_SESSION['order-success-a'] = "Order rejected successfully";
            redirect();
        } else {
            $_SESSION['order-error-a'] = "Something went wrong. Please try again";
            redirect();
        }
    } else {
        header('location: ../../../invalid.html');
    }
}
