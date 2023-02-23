<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['admin-success'])) {
    $_SESSION['filter-by'] = "pending";
    header('location: ../../order-details.php');
} else {
    header('location: ../../../invalid.html');
}
