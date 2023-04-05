<?php
session_start();
require("../../../config.php");

if (isset($_POST['edit-emp'])) {
    $emp_id = mysqli_real_escape_string($conn, $_POST['id']);
    $name =  mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $image = mysqli_real_escape_string($conn, $_POST['img']);

    $_SESSION['emp-id'] = $emp_id;
    $_SESSION['emp-name'] = $name;
    $_SESSION['emp-username'] = $username;
    $_SESSION['emp-email'] = $email;
    $_SESSION['emp-password'] = $password;
    $_SESSION['emp-department'] = $department;
    $_SESSION['emp-img'] = $image;
    header("Location: ../employees.php");
} else {
    header("Location: ../employees.php");
}
