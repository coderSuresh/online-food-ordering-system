<?php
session_start();
require('../config.php');
header('Content-Type: application/json');

$response = array();

if (isset($_SESSION['success'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $food_id = mysqli_real_escape_string($conn, $_POST['f_id']);
        if (isset($_POST['quantity'])) {
            $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
        } else {
            $quantity = 1;
        }
        $uid = mysqli_real_escape_string($conn, $_SESSION['user']);

        $stmt = mysqli_prepare($conn, "SELECT * FROM cart WHERE food_id = ? AND customer_id = ?");
        mysqli_stmt_bind_param($stmt, "ii", $food_id, $uid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $qty = $row['quantity'] + $quantity;
            $stmt = mysqli_prepare($conn, "UPDATE cart SET quantity = ? WHERE food_id = ? AND customer_id = ?");
            mysqli_stmt_bind_param($stmt, "iii", $qty, $food_id, $uid);
            $result = mysqli_stmt_execute($stmt);
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
            $stmt = mysqli_prepare($conn, "INSERT INTO cart (customer_id, food_id, quantity) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "iii", $uid, $food_id, $quantity);
            $result = mysqli_stmt_execute($stmt);
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
