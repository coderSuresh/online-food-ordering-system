<?php
session_start();

unset($_SESSION['cat-name'], $_SESSION['cat-img'], $_SESSION['cat-id']);

header("Location: ../manage-foods.php");
