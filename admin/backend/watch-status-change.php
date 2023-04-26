<?php
session_start();
require("../../config.php");
if (isset($_SESSION['admin-success'])) {
    $sql = "Select * from kos";
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $count = mysqli_num_rows($res);

    $response = array();

    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($res)) {

            $sql_fetch_food = "select food.name, orders.track_id, orders.c_id from orders inner join food on orders.f_id = food.f_id where orders.id = {$row['order_id']}";
            $res_fetch_food = mysqli_query($conn, $sql_fetch_food) or die(mysqli_error($conn));
            $row_fetch_food = mysqli_fetch_assoc($res_fetch_food);
            $food_name = $row_fetch_food['name'];

            if ($row['status'] == "rejected") {
                $sql_fetch_reason = "select reason from reject_reason where track_id = '{$row_fetch_food['track_id']}'";
                $res_fetch_reason = mysqli_query($conn, $sql_fetch_reason) or die(mysqli_error($conn));
                $reason = mysqli_fetch_assoc($res_fetch_reason)['reason'];
                $row['reason'] = $reason;
            }

            // serialize food id and customer id
            $row['t_id'] = base64_encode(serialize($row_fetch_food['track_id']));
            $row['c_id'] = base64_encode(serialize($row_fetch_food['c_id']));
            $row['food_name'] = $food_name;
            $row['track_id'] = $row_fetch_food['track_id'];
            $response[] = $row;
        }
        echo json_encode($response);
    } else {
        $response[] = 0;
        echo json_encode($response);
    }
} else {
    header('location: ../../invalid.html');
}
