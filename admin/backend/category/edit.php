<?php
session_start();
require("../../../config.php");

if(isset($_POST['edit'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $img_name = mysqli_real_escape_string($conn, $_POST['img']);

    $_SESSION['cat-id'] = $id;
    $_SESSION['cat-name'] = $name;
    $_SESSION['cat-img'] = $img_name;

    header("Location: ../../categories.php");
   
}
else {
    header("Location: ../../categories.php");
}
