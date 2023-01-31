<?php
session_start();
require("../../../config.php");

if (isset($_POST['edit'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $veg = mysqli_real_escape_string($conn, $_POST['veg']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    $_SESSION['f-id'] = $id;
    $_SESSION['f-veg'] = $veg;
    $_SESSION['f-category'] = $category;
    header("Location: ../../manage-foods.php");
} else {
    header("Location: ../../manage-foods.php");
}
