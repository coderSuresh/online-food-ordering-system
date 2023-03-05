<?php
session_start();
require '../../config.php';
if (isset($_POST['dashboard-filter']) && isset($_POST['filter_option'])) {
    $filter_option = mysqli_real_escape_string($conn, $_POST['filter_option']);
    $_SESSION['filter_option'] = $filter_option;
    if (isset($_POST['start-date']) && isset($_POST['end-date'])) {
        $from_date = mysqli_real_escape_string($conn, $_POST['start-date']);
        $to_date = mysqli_real_escape_string($conn, $_POST['end-date']);
        $_SESSION['start_date'] = $from_date;
        $_SESSION['end_date'] = $to_date;
    }
    header("Location: ../index.php");
} else {
    header("Location: ../index.php");
}
?>