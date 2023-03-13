<?php
session_start();
require('../../../config.php');
if (isset($_POST["add-to-special"])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $sql = "update food set special = 1 WHERE f_id = $id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['delete_success'] = "Food item successfully added to special";
        header("Location: ../../manage-foods.php");
    } else {
        $_SESSION['delete_error'] = "Could not add food item to special";
        header("Location: ../../manage-foods.php");
    }
} else {
    header("Location: ../../manage-foods.php");
}
