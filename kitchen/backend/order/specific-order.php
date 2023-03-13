<?php
session_start();
require("../../../config.php");
if(isset($_SESSION['kitchen-success'])) {
    if (isset($_POST['specific-order'])) {
        $filter_by = mysqli_real_escape_string($conn, $_POST['filter-by']);
        $_SESSION['filter-by'] = $filter_by;
        header("Location: ../../index.php");
    } else {
        header("Location: ../../index.php");
    }
} else {
    header("location: ../../../invalid.html");
}
?>