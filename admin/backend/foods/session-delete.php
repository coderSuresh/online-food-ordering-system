<?php
session_start();

unset($_SESSION['f-name'], $_SESSION['f-img'], $_SESSION['f-id'], $_SESSION['f-price'], $_SESSION['f-cost'], $_SESSION['f-category'], $_SESSION['f-cooking-time'], $_SESSION['f-product-id'], $_SESSION['f-description'], $_SESSION['f-veg']);

header("Location: ../../manage-foods.php");
