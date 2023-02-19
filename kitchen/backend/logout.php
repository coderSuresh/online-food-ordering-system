<?php
session_start();
if(isset($_SESSION['kitchen-success'])){
    unset($_SESSION['kitchen-success']);
    header('location: ../login.php');
}
else{
    header('location: ../invalid.html');
}
?>