<?php

session_start();
require('../config.php');
header('Content-Type: application/json');

$response = array();

if (isset($_SESSION['success'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $cart_id = $_POST['id'];
        $customer_id = $_SESSION['user'];

        $sql = "delete from cart WHERE id = $cart_id AND customer_id = $customer_id";
        $result = mysqli_query($conn, $sql) or die("Could not remove from cart");
        if ($result) {
            $response['status'] = 'success';
            $response['message'] = 'Item removed from cart';
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
