<?php
session_start();
if (isset($_SESSION['user'])) {
    $username = $_SESSION['user'];
    $sql_uid = "select id from customer where username = '$username'";
    $result_uid = mysqli_query($conn, $sql_uid);
    $row_uid = mysqli_fetch_assoc($result_uid) or die(mysqli_error($conn));
    $uid = $row_uid['id'];

    $sql = "SELECT * FROM cart where customer_id = $uid";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    $data = array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        echo json_encode($data);
    }
}
?>
