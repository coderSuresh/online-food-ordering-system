<?php
session_start();
if(isset($_SESSION['kitchen-success'])){
    session_destroy();
    header('location: ../login.php');
}
else{
    header('location: ../invalid.html');
}
?>