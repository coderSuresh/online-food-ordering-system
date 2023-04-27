<?php
session_start();
require("../../config.php");
if (isset($_SESSION['admin-success']) && isset($_POST['customer-filter'])) {
    $term = mysqli_real_escape_string($conn, $_POST['customer-filter']);

    switch ($term) {
        case "name":
            $_SESSION['customer-filter'] = "order by customer.names asc";
            break;
        case "most-selling":
            $_SESSION['customer-filter'] = "order by item_bought desc";
            break;
        case "least-selling":
            $_SESSION['customer-filter'] = "order by item_bought asc";
            break;
        case "last-added":
            $_SESSION['customer-filter'] = "order by customer.id desc";
            break;
        case "first-added":
            $_SESSION['customer-filter'] = "order by customer.id asc";
            break;
    }

    header("Location: ./customer.php");
} else {
    header("Location: ../../../invalid.html");
}
