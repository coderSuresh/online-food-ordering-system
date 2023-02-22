<?php
session_start();
require('../../../config.php');
if (isset($_POST["disable"])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $sql_fetch_food_status = "SELECT aos.status FROM orders inner join aos on orders.id = aos.order_id WHERE orders.f_id = $id and aos.status not in ('delivered', 'rejected');";
    $result_fetch_food_status = mysqli_query($conn, $sql_fetch_food_status);
    $row_fetch_food_status = mysqli_fetch_assoc($result_fetch_food_status);

    if ($row_fetch_food_status > 0) {
        $_SESSION['disable_error'] = "Cannot disable food item. It is currently in pending orders";
        header("Location: ../../manage-foods.php");
        exit();
    } else {
        $sql = "update food set disabled = 1 WHERE f_id = $id";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $_SESSION['disable_success'] = "Food item disabled successfully";
            header("Location: ../../manage-foods.php");
        } else {
            $_SESSION['disable_error'] = "Could not disable food item";
            header("Location: ../../manage-foods.php");
        }
    }
} else {
    header("Location: ../../manage-foods.php");
}
