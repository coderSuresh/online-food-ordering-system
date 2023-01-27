<?php
session_start();
require('../../../config.php');
if (isset($_POST["delete"])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $img_name = mysqli_real_escape_string($conn, $_POST['img']);

    $folder = "../../../uploads/category/";
    
    // delete img from upload folder
    unlink($folder . $img_name);

    $sql = "DELETE FROM category WHERE cat_id = $id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['delete_success'] = "Category removed successfully";
        header("Location: ../../categories.php");
    } else {
        $_SESSION['delete_error'] = "Could not delete category";
        header("Location: ../../categories.php");
    }
} else {
    header("Location: ../../categories.php");
}
?>