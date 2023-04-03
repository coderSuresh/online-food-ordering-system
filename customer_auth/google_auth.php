<?php
session_start();
    if (isset($_COOKIE['user'])) {
        include('../config.php');
        $signin_provider = mysqli_real_escape_string($conn, $_COOKIE['sign_in_provider']);
        $names  = mysqli_real_escape_string($conn, $_COOKIE['profile_name']);
        $email = mysqli_real_escape_string($conn, $_COOKIE['email']);
        $image = mysqli_real_escape_string($conn, $_COOKIE['image']);

        $sql_email = "SELECT active, id FROM customer WHERE email='$email'";
        $res_email = mysqli_query($conn, $sql_email) or die("Error: " . mysqli_error($conn));

        if (mysqli_num_rows($res_email) == 0) {
            $status = "verified";
            $count = 0;
            $sql = "INSERT INTO customer VALUES (default, '$names', NULL, '$email', NULL, '$signin_provider', NOW(), '$status', 1, NULL,$count)";
            mysqli_query($conn, $sql) or die("Error: " . mysqli_error($conn));
            $id = mysqli_insert_id($conn);
            $_SESSION['success'] = "success";
            $_SESSION['user'] = $id;
            header("Location: ../index.php");

        } else {
            $data = mysqli_fetch_assoc($res_email);
            if ($data['active'] == 0) {
                $_SESSION['block'] = "Your account has been blocked";
                header("Location: login.php");

          
            } else {
                $_SESSION['success'] = "success";
                $_SESSION['user'] = $data['id'];
                header("Location: ../index.php");

            }
        }
    }
?>