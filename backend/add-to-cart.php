<?php
session_start();
require('../config.php');
header('Content-Type: application/json');

$response = array();

if (isset($_SESSION['success'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $food_id = $_POST['f_id'];
        if(isset($_POST['quantity'])) {
            $quantity = $_POST['quantity'];
        } else {
            $quantity = 1;
        }
        $uid = $_SESSION['user'];

        $sql = "SELECT * FROM cart WHERE food_id = $food_id AND customer_id = $uid";
        $result = mysqli_query($conn, $sql) or die("Couldn't fetch cart");

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $qty = $row['quantity'] + $quantity;
            $sql = "UPDATE cart SET quantity = $qty WHERE food_id = $food_id AND customer_id = $uid";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $response['status'] = 'success';
                $response['message'] = 'Item added to cart';
                echo json_encode($response);
                exit();
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Something went wrong';
                echo json_encode($response);
                exit();
            }
        } else {
            $sql = "INSERT INTO cart VALUES (DEFAULT, $uid, $food_id, $quantity)";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $response['status'] = 'success';
                $response['message'] = 'Item added to cart';
                echo json_encode($response);
                exit();
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Something went wrong';
                echo json_encode($response);
                exit();
            }
        }
    } else {
        header('location: ../invalid.html');
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Please login to continue';
    echo json_encode($response);
}
