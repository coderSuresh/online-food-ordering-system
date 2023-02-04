<?php
session_start();
require("../../../config.php");
if (isset($_POST['specific-food'])) {
    $filter_by = mysqli_real_escape_string($conn, $_POST['filter-by']);
    $_SESSION['filter-by'] = $filter_by;
    header("Location: ../../manage-foods.php");
} else {
    header("Location: ../../manage-foods.php");
}
