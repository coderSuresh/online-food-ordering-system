<?php 
session_start();
require '../../../config.php';
if(isset($_SESSION['admin-success'])) {
    header("Content-Type: application/json; charset=UTF-8");
    $response = array();
    $sql_current_order = "select orders.id,
                    orders.c_id,
                    orders.qty,
                    orders.total_price,
                    orders.note,
                    orders.date,
                    orders.f_id,
                    order_contact_details.address,
                    order_contact_details.phone,
                    order_contact_details.c_name,
                    aos.aos_id,
                    aos.status
                    from orders 
                    inner join order_contact_details on orders.id = order_contact_details.o_id
                    inner join aos on orders.id = aos.order_id
                    where Date(orders.date) = CURDATE()
                    order by orders.id desc";
    $res = mysqli_query($conn, $sql_current_order) or die(mysqli_error($conn));
    $count = mysqli_num_rows($res);

    if($count > 0) {
        while($row = mysqli_fetch_assoc($res)) {
            $food_id = $row['f_id'];
            $sql_food = "select name from food where f_id = {$food_id}";
            $result_food = mysqli_query($conn, $sql_food) or die("Query Failed");
            $row_food = mysqli_fetch_assoc($result_food);
           
            $food_name = $row_food['name'];
            $order_id = $row['id'];

            $row['food_name'] = $food_name;
            $row['order_id'] = $order_id;
            $response[] = $row;
        }
        echo json_encode($response);
    } else {
        $response['status'] = 0;
        $response['message'] = "No data found";
        echo json_encode($response);
    }
} else {
    $response['status'] = 0;
    $response['message'] = "Access Denied";
    echo json_encode($response);
}