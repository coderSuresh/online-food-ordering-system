<?php
include('../../../config.php');
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = mysqli_real_escape_string($conn, $_POST['cat-id']);
    $name = mysqli_real_escape_string($conn, $_POST['category_name']);

    // update category name
    $sql = "UPDATE category SET name = '$name' WHERE cat_id = $id";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        $response['status'] = "success";
        $response['msg'] = "Category updated successfully";
    } else {
        $response['status'] = "error";
        $response['msg'] = "Could not update category";
    }

    echo json_encode($response);
} else {
    $response['status'] = "error";
    $response['msg'] = "Invalid request";

    echo json_encode($response);
}
