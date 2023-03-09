<?php
// session_start();
// require("../../config.php");
// if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['delivery-login'])) {

//     $username = mysqli_real_escape_string($conn, $_POST['username']);

//     // TODO: password hashing and verification
//     // here we should use password_hash() instead of md5() for password hashing and password_verify() instead of md5() for password verification
//     // $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT);
//     // $password = password_verify(mysqli_real_escape_string($conn, $_POST['password']), $password);

//     // md5() is not secure for password hashing and verification
//     // we will implement it when we create employee account from admin panel

//     $password = md5(mysqli_real_escape_string($conn, $_POST['password']));

//     $sql = "SELECT * FROM employees WHERE username = '$username' AND password = '$password' AND department = 'delivery'";
//     $result = mysqli_query($conn, $sql);
//     if (mysqli_num_rows($result) > 0) {
//         $row = mysqli_fetch_assoc($result);
//         if($row['username'] == $username && $row['password'] == $password) {
//             $_SESSION['delivery-username'] = $username;
//             $_SESSION['delivery-success'] = "Successfully logged in as delivery";
//             $_SESSION['id'] = $row['id'];
//             header("Location: ../index.php");
//         } else {
//             $_SESSION['delivery-error'] = "Invalid username or password";
//             header("Location: ../login.php");
//         }
//     } else {
//         $_SESSION['delivery-error'] = "Invalid username or password";
//         header("Location: ../login.php");
//     }
// } else {
//     header("Location: ../../invalid.html");
// }

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
