<?php

session_start();
require('../config.php');
header('Content-Type: application/json');

$response = array();

if (isset($_SESSION['success']) && isset($_SESSION['user'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $cart_id = $_POST['id'];
        $customer_id = $_SESSION['user'];

        $sql = "select quantity from cart WHERE id = $cart_id AND customer_id = $customer_id";
        $result = mysqli_query($conn, $sql) or die("Could not fetch from cart");
        $row = mysqli_fetch_assoc($result);
        $qty = $row['quantity'];

        if ($qty < 1) {
            $qty = 1;
        } else {
            $qty = $qty + 1;
        }

        $sql_update = "update cart set quantity=$qty WHERE id = $cart_id AND customer_id = $customer_id";
        $result = mysqli_query($conn, $sql_update) or die("Could not remove from cart");
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
