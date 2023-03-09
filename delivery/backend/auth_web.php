<?php
require '../../config.php';
session_start();

if (isset($_POST['delivery-login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5((mysqli_real_escape_string($conn, $_POST['password'])));

    $sql = "SELECT * FROM employees WHERE username = '$username' AND password = '$password' AND department = 2";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row['username'] == $username && $row['password'] == $password) {
            $_SESSION['delivery-username'] = $username;
            $_SESSION['delivery-success'] = "Successfully logged in as delivery";
            $_SESSION['id'] = $row['emp_id'];
            header("Location: ../index.php");
        } else {
            $_SESSION['delivery-error'] = "Invalid username or password";
            header("Location: ../login.php");
        }  
    } else {
        $response['status'] = "error";
        $response['message'] = "Invalid username or password";
    }
} else {
    header("Location: ../../invalid.html");
}
?>