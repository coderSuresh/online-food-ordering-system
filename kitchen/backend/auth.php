<?php
session_start();

require("../../config.php");
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['kitchen-login'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);

    // TODO: password hashing and verification
    // here we should use password_hash() instead of md5() for password hashing and password_verify() instead of md5() for password verification
    // $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT);
    // $password = password_verify(mysqli_real_escape_string($conn, $_POST['password']), $password);

    // md5() is not secure for password hashing and verification
    // we will implement it when we create employee account from admin panel

    $password = md5(mysqli_real_escape_string($conn, $_POST['password']));

    $sql_dept = "select dept_id from department where department = 'kitchen'";
    $result_dept = mysqli_query($conn, $sql_dept);
    $row_dept = mysqli_fetch_assoc($result_dept);
    $dept_id = $row_dept['dept_id'];

    $sql = "SELECT * FROM employees WHERE username = '$username' AND password = '$password' AND department = $dept_id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if($row['username'] == $username && $row['password'] == $password) {
            $_SESSION['kitchen-username'] = $username;
            $_SESSION['kitchen-success'] = "Successfully logged in as kitchen";
            $_SESSION['id'] = $row['id'];
            header("Location: ../index.php");
        } else {
            $_SESSION['kitchen-error'] = "Invalid username or password";
            header("Location: ../login.php");
        }
    } else {
        $_SESSION['kitchen-error'] = "Invalid username or password";
        header("Location: ../login.php");
    }
} else {
    header("Location: ../../invalid.html");
}
