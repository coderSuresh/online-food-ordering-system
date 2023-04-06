<?php 
session_start();
require("../../../config.php");
if(isset($_SESSION['admin-success']) && isset($_POST['cat-filter'])) {
    $term = mysqli_real_escape_string($conn, $_POST['cat-filter']);
    
    switch($term) {
        case "name":
            $_SESSION['cat-filter'] = "order by cat_name asc";
            break;
        case "most-selling":
            $_SESSION['cat-filter'] = "order by total_delivered desc";
            break;
        case "least-selling":
            $_SESSION['cat-filter'] = "order by total_delivered asc";
            break;
        case "last-added":
            $_SESSION['cat-filter'] = "order by cat_id desc";
            break;
        case "first-added":
            $_SESSION['cat-filter'] = "order by cat_id asc";
            break;
        default:
            $_SESSION['cat-filter'] = "order by cat_id desc";
            break;
    }

    header("Location: ../../categories.php");
} else {
    header("Location: ../../../invalid.html");
}
