<?php
session_start();
include("../../config.php");
if (isset($_POST['verify'])) {
  

    if (!preg_match("/^[0-9]{6}$/", $_POST['otp'])) {
        $_SESSION["invalid-otp"] = "Invalid OTP";
        header("Location:./reset-verify.php");
        exit();
    }
    else{
    $code = $_SESSION['code'];
    $user_email = $_SESSION['user_email'];
    $user_otp_code = mysqli_real_escape_string($conn, $_POST['otp']);

    if ($code == $user_otp_code) {

        $_SESSION['verification'] = "sucessful";
        header("Location:./new-password.php");
    } else {
        
        $sql_count  = "Select count from customer where email = '$user_email'";
        $res =  mysqli_query($conn, $sql_count) or die("could not fetch count");
        $data = mysqli_fetch_array($res);
        $count = $data['count'];
        $count += 1;
        $null_val = 0;

        $sql = "update customer set count = $count where email = '$user_email'";
        mysqli_query($conn, $sql) or die("could not update count");
        

        if ($data['count'] >= 2) {
            $_SESSION["otp-reset-failed"] = "OTP verification failed";
            $sql_delet_count = "update customer set count = $null_val where email = '$user_email' ";
            mysqli_query($conn, $sql_delet_count) or die("could not update count");
            header("Location:../login.php");
        }
        else{
            $_SESSION["otp-reset-count"] = 3 - $count . " attempt left";
            header("Location:./reset-verify.php");
        }
    }   
}   

} else {
    header("Location:../login.php");
}

?>