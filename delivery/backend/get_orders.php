<?php
require '../../config.php';

header('content-type: application/json; charset=utf-8');

$sql = "select order_id from to_be_delivered";
$result = mysqli_query($conn, $sql);

$response = array();
$data = array();

if ($result) {

    $response['status'] = "success";
    $response['count'] = mysqli_num_rows($result);

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {

            $order_id = $row['order_id'];
            $sql_order = "select qty, total_price, f_id from orders where id = $order_id";
            $result_order = mysqli_query($conn, $sql_order);
            $row_order = mysqli_fetch_assoc($result_order);

            $food_id = $row_order['f_id'];
            $sql_food = "select name from food where f_id = $food_id";
            $result_food = mysqli_query($conn, $sql_food);
            $row_food = mysqli_fetch_assoc($result_food);

            $qty = $row_order['qty'];
            $price = $row_order['total_price'];
            $food_name = $row_food['name'];

            $sql_contact = "select c_name, address, c_name, phone from order_contact_details where o_id = $order_id";
            $result_contact = mysqli_query($conn, $sql_contact);
            $row_contact = mysqli_fetch_assoc($result_contact);

            $phone = $row_contact['phone'];
            $address = $row_contact['address'];
            $name = $row_contact['c_name'];

            $row['food_name'] = $food_name;
            $row['qty'] = $qty;
            $row['price'] = $price;
            $row['phone'] = $phone;
            $row['address'] = $address;
            $row['name'] = $name;

            $data[] = $row;
        }

        $response['data'] = $data;

    } else {
        $response['message'] = "No orders to be delivered";
    }

    echo json_encode($response);
} 
else {
    $response['status'] = "error";
    $response['message'] = "Error fetching orders";
    echo json_encode($response);
}
?>