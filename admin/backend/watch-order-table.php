<?php
session_start();
require("../../config.php");
if (isset($_SESSION['admin-success'])) {
    $sql = "Select * from aos";
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $count = mysqli_num_rows($res);

    if ($count <= 0) {
        $count = 0;
    }

    $count_arr = array();
    $count_arr['data'] = $count;
    echo json_encode($count_arr);
} else {
    header('location: ../../invalid.html');
}
