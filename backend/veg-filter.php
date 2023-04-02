<?php
require("../config.php");
if (isset($_POST['veg-filter'])) {
    $veg = mysqli_real_escape_string($conn, $_POST['veg-filter']);

    if ($veg == "veg") {
        if (isset($_GET['searchKey'])) {
            header("Location: ../menu.php?veg=1&searchKey=" . $_GET['searchKey']);
        } else {
            header("Location: ../menu.php?veg=1");
        }
    } else if ($veg == "non-veg") {
        if (isset($_GET['searchKey'])) {
            header("Location: ../menu.php?veg=0&searchKey=" . $_GET['searchKey']);
        } else {
            header("Location: ../menu.php?veg=0");
        }
    } else {
        if (isset($_GET['searchKey'])) {
            header("Location: ../menu.php?searchKey=" . $_GET['searchKey']);
        } else {
            header("Location: ../menu.php");
        }
    }
} else {
    header("Location: ../menu.php");
}
