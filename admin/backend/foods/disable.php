<?php
session_start();
require('../../../config.php');
if (isset($_POST["disable"])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $sql = "update food set disabled = 1 WHERE f_id = $id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['disable_success'] = "Food item disabled successfully";
        header("Location: ../../manage-foods.php");
    } else {
        $_SESSION['disable_error'] = "Could not disable food item";
        header("Location: ../../manage-foods.php");
    }
} else {
    header("Location: ../../manage-foods.php");
}
