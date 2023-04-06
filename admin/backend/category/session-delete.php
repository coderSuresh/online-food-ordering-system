<?php
session_start();

unset($_SESSION['cat-id'], $_SESSION['cat-name'], $_SESSION['cat-img']);

header("Location: ../../categories.php");
?>