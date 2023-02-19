<?php
session_start();
if(isset($_SESSION['delivery-success'])) {
    unset($_SESSION['delivery-success']);
    header("Location: ../login.php");
} else {
    header("Location: ../login.php");
}
?>