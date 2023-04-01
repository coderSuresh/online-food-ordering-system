<?php
session_start();
require("../../config.php");
if (isset($_SESSION['kitchen-success'])) {

    require '../../components/get-current-timestamp.php';
    $current_timestamp = getCurrentTimestamp();

    $sql = "Select * from aos where status = 'accepted'";
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    while ($data = mysqli_fetch_assoc($res)) {

        $sql_check_kos = "select * from kos where order_id = $data[order_id]";
        $res_check_kos = mysqli_query($conn, $sql_check_kos) or die("Could not check if order is present in kos");

        if (mysqli_num_rows($res_check_kos) > 0) {
            continue;
        }

        $order_id = $data['order_id'];
        $sql_aos = "insert into kos values (DEFAULT, $order_id, 'pending', '$current_timestamp')";
        $res_aos = mysqli_query($conn, $sql_aos) or die("Could not insert into table");
    }

    $sql = "Select * from kos";
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $count = mysqli_num_rows($res);
    $count_arr = array();
    $count_arr['data'] = $count;
    echo json_encode($count_arr);
}
