<?php
include '../../../config.php';
session_start();
if (isset($_SESSION["admin-success"]) && isset($_POST["activate"])) {
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $sql = "UPDATE employees SET active = 1 WHERE emp_id = $id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION["unblock-success"] = "Employee unblocked successfully";
        header("Location: ../employees.php");
    } else {
        $_SESSION["unblock-error"] = "Cannot unblock employee";
        header("Location: ../employees.php");
    }
}
