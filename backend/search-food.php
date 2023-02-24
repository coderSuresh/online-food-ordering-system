<?php
require("../config.php");
if(isset($_POST['search-btn'])){
    $searchKey = mysqli_real_escape_string($conn, $_POST['search-key']);
    $searchKey = strtolower($searchKey);
    header("Location: ../menu.php?search=$searchKey");
}
?>