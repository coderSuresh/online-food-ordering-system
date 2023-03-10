<?php
include '../../../config.php';
session_start();
if (isset($_SESSION["admin-success"]) && isset($_POST["block"])){
    $id = mysqli_real_escape_string($conn,$_POST["id"]);
        $sql = "UPDATE employees SET active = 0 WHERE emp_id = $id";
        $result = mysqli_query($conn,$sql);
        if ($result){
            $_SESSION["block-success"] = "Employee blocked successfully";
            header("Location: ../employees.php");
        }else{
            $_SESSION["block-error"] = "Cannot block employee";
            header("Location: ../employees.php");
        }
    }
