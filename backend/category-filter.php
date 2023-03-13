<?php 
session_start();
require("../config.php");
if(isset($_POST['category-filter'])){
    $_SESSION['cat_name'] = mysqli_real_escape_string($conn, $_POST['cat-name']);
    header("Location: ../menu.php");
} else
    header("Location: ../invalid.html");
?>