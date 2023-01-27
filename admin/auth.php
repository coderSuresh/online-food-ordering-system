<?php
session_start();
require('../config.php');

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5(mysqli_real_escape_string($conn, $_POST['password']));
    $sql = "SELECT username,password from admin where username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($data = mysqli_fetch_array($result)) {
            if ($password != $data['password']) {
                $_SESSION['password'] = "Incorrect password";
                header("Location:./login.php"); 
            }else{
                $_SESSION['admin-success'] = "Login success";
                  header("Location:./index.php");
            }
        }
    } else {
        $_SESSION['username'] = "Incorrect username";
        header("Location:./login.php");
    }
} else {
    header("Location:Location:./login.php");
}
