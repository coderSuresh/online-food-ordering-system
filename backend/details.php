<?php
session_start();
require("../config.php");

if(isset($_POST['view'])) {
    $id = mysqli_real_escape_string($conn, $_POST['f_id']);
    echo $id;
} else
    header("location: ../invalid.html");
?>