<?php
session_start();

unset($_SESSION['emp-id'], $_SESSION['emp-name'], $_SESSION['emp-username'], $_SESSION['emp-email'], $_SESSION['emp-department'], $_SESSION['emp-img'], $_SESSION['emp-password']);

header("Location: ../employees.php");
?>