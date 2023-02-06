<?php
session_start();
require('../config.php');
if (isset($_SESSION['user'])) {
    $uid = $_SESSION['user'];

    $sql = "SELECT * FROM cart where customer_id = $uid";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    $data = array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // get item details
            $food_id = $row['food_id'];
            $sql_food = "SELECT * FROM food WHERE f_id = $food_id";
            $result_food = mysqli_query($conn, $sql_food) or die(mysqli_error($conn));
            $row_food = mysqli_fetch_assoc($result_food);
            $row['food_name'] = $row_food['name'];
            $row['food_price'] = $row_food['price'];
            $row['food_image'] = $row_food['img'];
            $data[] = $row;
        }
        echo json_encode($data);
    }
    else {
        echo json_encode(array('status' => 'error', 'message' => 'No items in cart'));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Please login to continue'));
}
