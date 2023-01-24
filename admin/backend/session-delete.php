<?php
session_start();
if(isset($_SESSION['cat-name'])) {
    unset($_SESSION['cat-name'], $_SESSION['cat-img']);
}
header("Location: ../categories.php");
?>