<?php
session_start();
require("../../config.php");
if (isset($_SESSION['admin-success'])) {

    require '../../components/get-current-timestamp.php';

    $current_time = getCurrentTime();
    $current_timestamp = getCurrentTimestamp();

    $sql = "Select id, delivery_time from orders where Date(delivery_date) = Date(NOW())";
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    while ($data = mysqli_fetch_assoc($res)) {

        $order_id = $data['id'];
        $delivery_time = $data['delivery_time'];
        $calculated_delivery_time = date('H:i', strtotime($delivery_time . ' -30 minutes'));

        if ($delivery_time != "00:00:00" && $calculated_delivery_time <= $current_time) {

            $check_if_inserted = "select * from aos where order_id = $order_id";
            $res_check = mysqli_query($conn, $check_if_inserted) or die("Could not check if inserted");

            if (mysqli_num_rows($res_check) == 0) {
                $sql_aos = "insert into aos values (DEFAULT, $order_id, 'pending', '$current_timestamp')";
                $res_aos = mysqli_query($conn, $sql_aos) or die("Could not insert into aos");
            }
        }
    }

    $sql = "select * from aos where status = 'pending'";
    $res = mysqli_query($conn, $sql) or die("Could not get pending orders");
    $count = mysqli_num_rows($res);

    $count_arr = array();
    $count_arr['data'] = $count;
    echo json_encode($count_arr);
} else {
    header('location: ../../invalid.html');
}
