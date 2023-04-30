<?php
session_start();
include("../../config.php");
if (isset($_POST['verify'])) {
    $user_otp_code = mysqli_real_escape_string($conn, $_POST['otp']);

    $sql = "select * from admin where otp = '$user_otp_code'";
    $res = mysqli_query($conn, $sql) or die("Error");
    $data = mysqli_fetch_array($res);

    $code = $data['otp'];

    if ($code == $user_otp_code) {
        $_SESSION['verification-success'] = "OTP verified successfully";
        $sql = "update admin set otp = 0 where otp = '$user_otp_code'";
        $res = mysqli_query($conn, $sql) or die("Error");
        header("Location:./new-password.php");
    } else {
        $_SESSION['verification-failed'] = "OTP didn't match";
        header("Location:./reset-verify.php");
    }
} else {
    header("Location:../login.php");
}
