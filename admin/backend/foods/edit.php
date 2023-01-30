<?php
session_start();
require("../../../config.php");

if (isset($_POST['edit'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $cost = mysqli_real_escape_string($conn, $_POST['cost']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $img_name = mysqli_real_escape_string($conn, $_POST['img']);
    $cooking_time = mysqli_real_escape_string($conn, $_POST['cooking-time']);
    $product_id = mysqli_real_escape_string($conn, $_POST['product-id']);
    $description = mysqli_real_escape_string($conn, $_POST['desc']);
    $short_desc = mysqli_real_escape_string($conn, $_POST['short-desc']);
    $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
    $veg = mysqli_real_escape_string($conn, $_POST['veg']);

    $_SESSION['f-id'] = $id;
    $_SESSION['f-name'] = $name;
    $_SESSION['f-img'] = $img_name;
    $_SESSION['f-price'] = $price;
    $_SESSION['f-cost'] = $cost;
    $_SESSION['f-category'] = $category;
    $_SESSION['f-cooking-time'] = $cooking_time;
    $_SESSION['f-product-id'] = $product_id;
    $_SESSION['f-description'] = $description;
    $_SESSION['f-short-desc'] = $short_desc;
    $_SESSION['f-ingredients'] = $ingredients;
    $_SESSION['f-veg'] = $veg;

    header("Location: ../../manage-foods.php");
} else {
    header("Location: ../../manage-foods.php");
}
