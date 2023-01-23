<?php
session_start();
include('../config.php');

<<<<<<< HEAD
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
                $_SESSION['success'] = "Login success";
                  header("Location:./dashboard.php");
            }
        }
    } else {
        $_SESSION['username'] = "Incorrect username";
        header("Location:./login.php");
=======
if(isset($_POST['login'])) {   
  
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = md5(mysqli_real_escape_string($conn,$_POST['password']));    
    $sql = "SELECT * from admin";
    $result = mysqli_query($conn,$sql);
    while ($data = mysqli_fetch_array($result)) {
      
      if ($password != $data['password']){
            $_SESSION['password'] = "Invalid password";
              header("Location:Location:./login.php");
              
      }
      elseif ($username != $data['username']){
            $_SESSION['email'] = "Invalid email";
              header("Location:Location:./login.php");
      }
      else {
            $_SESSION['admin'] = "login success";
            header("Location:./dashboard.php");            
      }           
>>>>>>> 2c66034ea3ba4ac3f7ec6b9f47d55376d37b8f7f
    }
} else {
    header("Location:Location:./login.php");
}
<<<<<<< HEAD
=======
else {
      header("Location:Location:./login.php");
}
>>>>>>> 2c66034ea3ba4ac3f7ec6b9f47d55376d37b8f7f
