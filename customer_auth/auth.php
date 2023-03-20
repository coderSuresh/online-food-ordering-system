<?php
session_start();
include('../config.php');
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $sql_username = "SELECT active FROM customer WHERE username = '$username'";
    $result = mysqli_query($conn, $sql_username);
    $row = mysqli_fetch_assoc($result);
    if ($row['active'] == 1) {
        $sql_status = "Select status,username from customer where username";
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = md5(mysqli_real_escape_string($conn, $_POST['password']));
        $sql = "SELECT id,username,password,status from customer where username='$username'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($data = mysqli_fetch_array($result)) {
                if ($data['status'] == "verified") {
                    if ($password != $data['password']) {
                        $_SESSION['password'] = "Incorrect password";
                        header("Location:./login.php");
                    } else {
                        $id = $data['id'];
                        $_SESSION['success'] = "Login success";
                        $_SESSION['user'] = $id;
                        header("Location:../index.php");
                    }
                } else {
                    $_SESSION["usr"] = $data["username"];
                    header("Location:./re-verify/resend-otp.php");
                }
            }
        } else {
            $_SESSION['username'] = "Incorrect username";
            header("Location:./login.php");
        }
    } else {
        $_SESSION["block"] = "You account has been blocked";
    }
} else {
    header("Location:Location:./login.php");
}
