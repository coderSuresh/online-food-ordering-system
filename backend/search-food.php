<?php
require("../config.php");
$searchKey = mysqli_real_escape_string($conn, $_POST['search-key']);
$searchKey = strtolower($searchKey);
header("Location: ../menu.php?search=$searchKey");
?>