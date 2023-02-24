<?php
session_start();
require("../config.php");
if(isset($_POST['veg-filter'])){
    $veg = mysqli_real_escape_string($conn, $_POST['veg-filter']);
    $_SESSION['veg'] = $veg;

    if($veg == "veg"){
        $_SESSION['veg-int'] = "1";
    }
    else if($veg == "non-veg"){
        $_SESSION['veg-int'] = "0";
    } 
    else{
        unset($_SESSION['veg-int']);
    }

    header("Location: ../menu.php");
}
else{
    header("Location: ../menu.php");
}
