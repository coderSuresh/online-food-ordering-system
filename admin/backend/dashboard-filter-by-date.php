<?php
session_start();
require '../../config.php';
if (isset($_POST['dashboard-filter']) && isset($_POST['filter_option'])) {

    $filter_option = mysqli_real_escape_string($conn, $_POST['filter_option']);
    $page = mysqli_real_escape_string($conn, $_POST['page']);

    $isForReport = false;
    $isForCustomer = false;

    if ($page == "report") {
        $isForReport = true;
    } elseif ($page == "customer") {
        $isForCustomer = true;
    }

    $_SESSION['filter_option'] = $filter_option;
    if (isset($_POST['start-date']) && isset($_POST['end-date'])) {
        $from_date = mysqli_real_escape_string($conn, $_POST['start-date']);
        $to_date = mysqli_real_escape_string($conn, $_POST['end-date']);
        $_SESSION['start_date'] = $from_date;
        $_SESSION['end_date'] = $to_date;
    }

    if ($isForReport) {
        header("Location: ../report.php");
    } elseif ($isForCustomer) {
        header("Location: ../users/customer.php");
    } else {
        header("Location: ../index.php");
    }
} else {
    if ($isForReport) {
        header("Location: ../report.php");
    } elseif ($isForCustomer) {
        header("Location: ../users/customer.php");
    } else {
        header("Location: ../index.php");
    }
}
