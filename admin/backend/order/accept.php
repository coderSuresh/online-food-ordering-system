<?php
session_start();
require '../../../config.php';
require '../../../components/get-current-timestamp.php';

if (!isset($_SESSION['admin-success'])) {
    header('location: ../../../invalid.html');
} else {
    if (isset($_POST['accept'])) {

        $order_id = mysqli_real_escape_string($conn, $_POST['id']);

        function redirect()
        {
            if (isset($_POST['aos_id']) && !empty($_POST['aos_id'])) {
                header('location: ../../order-details.php');
            } elseif (isset($_POST['fo_id']) && !empty($_POST['fo_id'])) {
                header('location: ../../future-details.php');
            }
        }

        if (isset($_POST['aos_id']) && !empty($_POST['aos_id'])) {
            $id = mysqli_real_escape_string($conn, $_POST['aos_id']);
        } elseif (isset($_POST['fo_id']) && !empty($_POST['fo_id'])) {
            $id = mysqli_real_escape_string($conn, $_POST['fo_id']);
        }

        $order_id = unserialize(base64_decode($order_id));
        $id = unserialize(base64_decode($id));

        if (isset($_POST['aos_id']) && !empty($_POST['aos_id'])) {
            $sql = "UPDATE aos SET status = 'accepted' WHERE order_id in (" . implode(',', $order_id) . ") and aos_id in (" . implode(',', $id) . ")";
        } elseif (isset($_POST['fo_id']) && !empty($_POST['fo_id'])) {
            $sql = "UPDATE future_orders SET status = 'accepted' WHERE order_id in (" . implode(',', $order_id) . ") and fo_id in (" . implode(',', $id) . ")";
        }

        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        $date = getCurrentTimestamp();

        if (isset($_POST['aos_id'])) {
            foreach ($order_id as $id) {
                $sql_insert = "insert into kos values (DEFAULT, $id, 'pending', '$date')";
                $result_insert = mysqli_query($conn, $sql_insert) or die(mysqli_error($conn));
            }
        }

        if ($result) {
            $_SESSION['order-success-a'] = "Order accepted successfully";
            redirect();
        } else {
            $_SESSION['order-error-a'] = "Something went wrong. Please try again";
            redirect();
        }
    } else {
        header('location: ../../../invalid.html');
    }
}
