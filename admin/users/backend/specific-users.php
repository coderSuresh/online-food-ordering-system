<?php
session_start();
require("../../../config.php");
if (isset($_POST['specific-users'])) {
    $filter_by = mysqli_real_escape_string($conn, $_POST['filter-by']);
    $_SESSION['filter-by'] = $filter_by;
    header("Location: ../customer.php");
} else if(isset($_POST['specific-emp'])) {
    $filter_by = mysqli_real_escape_string($conn, $_POST['filter-by']);
    $_SESSION['filter-by'] = $filter_by;
    header("Location: ../employees.php");
}
else {
    header("Location: ../../../invalid.html");
}
?>