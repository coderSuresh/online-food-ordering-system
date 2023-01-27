<?php
session_start();
require('../../../config.php');
if (isset($_POST["delete"])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $img_name = mysqli_real_escape_string($conn, $_POST['img']);

    $folder = "../../../uploads/foods/";
    
    // delete img from upload folder
    unlink($folder . $img_name);

    $sql = "DELETE FROM food WHERE f_id = $id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['delete_success'] = "Food item removed successfully";
        header("Location: ../../manage-foods.php");
    } else {
        $_SESSION['delete_error'] = "Could not delete food item";
        header("Location: ../../manage-foods.php");
    }
} else {
    header("Location: ../../manage-foods.php");
}
?>