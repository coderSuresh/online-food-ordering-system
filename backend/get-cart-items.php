<?php
session_start();
require_once('../config.php');

if (isset($_SESSION['user'])) {
    $uid = mysqli_real_escape_string($conn, $_SESSION['user']);

    $sql = "SELECT * FROM cart WHERE customer_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $uid);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $data = array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // get item details
            $food_id = mysqli_real_escape_string($conn, $row['food_id']);
            $sql_food = "SELECT * FROM food WHERE f_id = ?";
            $stmt_food = mysqli_prepare($conn, $sql_food);
            mysqli_stmt_bind_param($stmt_food, "i", $food_id);
            mysqli_stmt_execute($stmt_food);
            $result_food = mysqli_stmt_get_result($stmt_food);
            $row_food = mysqli_fetch_assoc($result_food);
            $row['food_name'] = $row_food['name'];
            $row['food_price'] = $row_food['price'];
            $row['food_image'] = $row_food['img'];
            $data[] = $row;
        }
        echo json_encode($data);
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'No items in cart'));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Please login to continue'));
}
