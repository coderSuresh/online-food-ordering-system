<?php
session_start();
include("../../../../config.php");
if (isset($_POST['verify'])) {
    $otp = mysqli_real_escape_string($conn, $_POST['otp']);
    $user = $_SESSION['username'];


    $sql_otp = "select otp from customer where username = '$user'";
    $res_otp = mysqli_query($conn, $sql_otp) or die("Error");

    $data  = mysqli_fetch_array($res_otp);
    if (mysqli_num_rows($res_otp) > 0) {
        if ($otp === $data['otp']) {
            $sql_update = "update customer set status = 'verified' where username = '$user'";
            $res_update = mysqli_query($conn, $sql_update) or die("Error");
            if ($res_update) {
                $_SESSION['verification'] = "sucessful";
                header("Location:../login.php");
            }
        }
    }
} else {
    header("Location:../login.php");
}
?>