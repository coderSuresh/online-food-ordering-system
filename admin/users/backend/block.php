<?php
include '../../../config.php';
session_start();
if (isset($_SESSION["admin-success"]) && isset($_POST["block"])){
    $id = mysqli_real_escape_string($conn,$_POST["id"]);
        $sql = "UPDATE customer SET active = 0 WHERE id = '$id'";
        $result = mysqli_query($conn,$sql);
        if ($result){
            $_SESSION["block-success"] = "Customer blocked successfully";
            header("Location: ../customer.php");
        }else{
            $_SESSION["block-error"] = "Cannot block customer";
            header("Location: ../customer.php");
        }
    }


?>