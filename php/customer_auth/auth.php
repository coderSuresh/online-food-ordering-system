<?php
session_start();
include('../../config.php');

if (isset($_POST['login'])) {
      $username = mysqli_real_escape_string($conn, $_POST['username']);
      $password = md5(mysqli_real_escape_string($conn, $_POST['password']));
      $sql = "SELECT username,password from customer";
      $result = mysqli_query($conn, $sql);

   if (mysqli_num_rows($result)>0)
      while ($data = mysqli_fetch_array($result)) {
          if(($password == $data['password'] and $username ==$data['username'])){
            $_SESSION['username'] = $data['username'];
            $_SESSION['success'] = "Login success";
            header("Location:../../index.php");
        }else{
            $_SESSION['pass'] = "Invalid password";
            header("Location:./login.php");
        }
    }else{
        $_SESSION['username'] = "Invalid username";
        header("Location:./login.php");
    }
}else{
    header("Location:./login.php");
}
   
?>
