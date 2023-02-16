<?php
    require("../../config.php");
    $sql = "Select * from kos";
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $count = mysqli_num_rows($res);
    $count_arr = array();
    $count_arr['data'] = $count;
    echo json_encode($count_arr);
?>