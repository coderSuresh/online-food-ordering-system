<?php
header('content-type: application/json; charset=utf-8');
require '../../config.php';

$response = array();

$raw_data = file_get_contents('php://input');
$data = json_decode($raw_data, true);

if(!isset($data['username']) || !isset($data['password'])) {
    $response['status'] = "error";
    $response['message'] = "Invalid request";
    echo json_encode($response);
    exit();
} else {
    $username = mysqli_real_escape_string($conn, $data['username']);
    $password = md5((mysqli_real_escape_string($conn, $data['password'])));

    $sql = "SELECT * FROM employees WHERE username = '$username' AND password = '$password' AND department = 2";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row['username'] == $username && $row['password'] == $password) {
            $response['status'] = "success";
            $response['message'] = "Successfully logged in as delivery";
        } else {
            $response['status'] = "error";
            $response['message'] = "Invalid username or password";
        }
    } else {
        $response['status'] = "error";
        $response['message'] = "Invalid username or password";
    }
}

echo json_encode($response);
