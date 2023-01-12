<?php
@include('../config.php');
session_start();
if (isset($_POST['register'])) 
    {
        $name = mysqli_real_escape_string($conn,$_POST['name']);
        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $password =  md5(mysqli_real_escape_string($conn,$_POST['password']));
        $sql = "Insert into customer values (default,'$name','$username','$email', '$password')";
        $res = mysqli_query($conn,$sql) or die("Error");      
    }
    header("Location:./login.php")
?>