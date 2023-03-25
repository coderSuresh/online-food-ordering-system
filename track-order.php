<?php
session_start();
if(isset($_SESSION['order_placed'])) {
    echo $_SESSION['order_placed'];
    unset($_SESSION['order_placed']);
}
else if(isset($_SESSION['order_success'])) {
    unset($_SESSION['order_success']);
}
?>
