<?php

session_start();
include("../../config.php");
if (isset($_POST['create-new-password'])) {
    $password = mysqli_real_escape_string($conn, $_POST['new-password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm-password']);
    $email = $_SESSION['email'];

    if (!preg_match("/^[0-9A-Z a-z,!@#$%^&*()_+]{8,50}$/", $password)) {
        $_SESSION["password-error"] = "password should contain minimum 8 characters";
        $_SESSION['cnp_page'] = "create new page"; // for verification purpose
        header("Location:./new-password.php");
    } else {
        if ($password === $confirm_password) {
            $password = md5($password);
            $sql = "update admin set password = '$password' where email = '$email'";
            $res = mysqli_query($conn, $sql) or die("Error");
            if ($res) {
                $_SESSION['password-success'] = "Password changed successfully";
                header("Location:../login.php");
            }
        } else {
            $_SESSION['password-error'] = "Password didn't match";
            $_SESSION['cnp_page'] = "create new page"; // for verification purpose
            header("Location:./new-password.php");
        }
    }
} else {
    header("Location:../login.php");
}
