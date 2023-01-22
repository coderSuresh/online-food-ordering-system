<?php
session_start();
include('../../config.php');

if (isset($_POST['login'])) {
      $username = mysqli_real_escape_string($conn, $_POST['username']);
      $password = md5(mysqli_real_escape_string($conn, $_POST['password']));
      $sql = "SELECT username,password from customer";
      $result = mysqli_query($conn, $sql);

      while ($data = mysqli_fetch_array($result)) {
            if ($username != $data['username']) {
                  $_SESSION['username'] = "Invalid username";
                  header("Location:./login.php");
            } else if ($password != $data['password']) {
                  $_SESSION['pass'] = "Invalid password";
                  header("Location:./login.php");
            } else {
                  $_SESSION['success'] = "Login success";
                  header("Location:../../index.php");
            }
      }
} else {
      header("Location:Location:./login.php");
}
