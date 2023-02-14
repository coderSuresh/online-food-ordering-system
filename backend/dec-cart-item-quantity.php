<?php

session_start();
require('../config.php');
header('Content-Type: application/json');

$response = array();

if (isset($_SESSION['success']) && isset($_SESSION['user'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $cart_id = mysqli_real_escape_string($conn, $_POST['id']);
        $customer_id = mysqli_real_escape_string($conn, $_SESSION['user']);

        $stmt = mysqli_prepare($conn, "SELECT quantity FROM cart WHERE id = ? AND customer_id = ?");
        mysqli_stmt_bind_param($stmt, "ii", $cart_id, $customer_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $qty = $row['quantity'];

            if ($qty - 1 == 0) {
                $qty = 1;
                $response['status'] = 'error';
                $response['message'] = 'Minimum order quantity is 1';
                echo json_encode($response);
                exit();
            } else {
                $qty = $qty - 1;
            }

            $stmt_update = mysqli_prepare($conn, "UPDATE cart SET quantity = ? WHERE id = ? AND customer_id = ?");
            mysqli_stmt_bind_param($stmt_update, "iii", $qty, $cart_id, $customer_id);
            $result = mysqli_stmt_execute($stmt_update);

            if ($result) {
                $response['status'] = 'hidden';
                $response['message'] = 'Item updated from cart';

                if (isset($_POST['from_checkout'])) {
                    header('Location: ../checkout.php');
                }

                echo json_encode($response);
                exit();
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Something went wrong';
                echo json_encode($response);
                exit();
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Item not found in cart';
            echo json_encode($response);
            exit();
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Invalid request';
        echo json_encode($response);
        exit();
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Please login to continue';
    echo json_encode($response);
    exit();
}
