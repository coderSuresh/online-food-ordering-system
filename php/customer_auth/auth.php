<?php
session_start();
@include('../../config.php');
if(isset($_POST['login'])){   
  
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = md5(mysqli_real_escape_string($conn,$_POST['password']));    
    $sql = "SELECT * from customer";
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
            $_SESSION['success'] = "login success";
            header("Location:../../");            
      }           
    }
}

else {
      header("Location:Location:./login.php");
}
?>