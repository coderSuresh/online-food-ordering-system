<?php

echo "jpt";

// session_start();
// require('../config.php');
// header('Content-Type: application/json');

// $response = array();

// if (isset($_SESSION['success'])) {
//     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//         $cart_id = $_POST['id'];
//         $username = $_SESSION['user'];

//         // get user id
//         $sql_uid = "SELECT id FROM customer WHERE username = '$username'";
//         $result_uid = mysqli_query($conn, $sql_uid) or die("Couldn't fetch user id");
//         $row_uid = mysqli_fetch_assoc($result_uid);
//         $customer_id = $row_uid['id'];

//         $sql = "delete from cart WHERE id = $cart_id AND customer_id = $customer_id";
//         $result = mysqli_query($conn, $sql) or die("Could not remove from cart");
//         if ($result) {
//             $response['status'] = 'success';
//             $response['message'] = 'Item removed from cart';
//             echo json_encode($response);
//             return;
//             // exit();
//         } else {
//             $response['status'] = 'error';
//             $response['message'] = 'Something went wrong';
//             echo json_encode($response);
//             return;
//             // exit();
//         }
//     } else {
//         header('location: ../invalid.html');
//     }

//     // header("location:" .$_SERVER['HTTP_REFERER']);
//     // header("location: ../index.php");
// } else {
//     $response['status'] = 'error';
//     $response['message'] = 'Please login to continue';
//     echo json_encode($response);
//     exit();
// }
?>