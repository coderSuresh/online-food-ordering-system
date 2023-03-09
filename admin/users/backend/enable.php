<?php
include '../../../config.php';
session_start();
if (isset($_SESSION["admin-success"]) && isset($_POST["activate"])){
    $id = mysqli_real_escape_string($conn,$_POST["id"]);
        $sql = "UPDATE customer SET active = 1 WHERE id = '$id'";
        $result = mysqli_query($conn,$sql);
        if ($result){
            $_SESSION["unblock-success"] = "Customer unblocked successfully";
            header("Location: ../customer.php");
        }else{
            $_SESSION["unblock-error"] = "Cannot unblock customer";
            header("Location: ../customer.php");
        }
    }
