<?php 
session_start();
require("../../../config.php");
if(isset($_SESSION['admin-success']) && isset($_POST['search-category'])) {
    $_SESSION['search-category'] = mysqli_real_escape_string($conn, $_POST['search-category']);
    header("Location: ../../categories.php");
} else {
    header("Location: ../../../invalid.php");
}
?>