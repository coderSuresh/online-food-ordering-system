<?php
session_start();
if (isset($_SESSION["success"])){
    unset($_SESSION["success"]);
}
if (isset($_COOKIE["user"])){
    setcookie("email", "", time() - 3600);    
    setcookie("image", "", time() - 3600);
    setcookie("profile_name", "", time() - 3600);
    setcookie("sign_in_provider", "", time() - 3600);
    setcookie("user", "", time() - 3600);
}
header("Location:./login.php");