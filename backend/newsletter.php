<?php

require '../config.php';

$response = array();

if(!isset($_POST['email'])){
    $response['status'] = 'error';
    $response['message'] = 'Email is required';
    echo json_encode($response);
    exit();
} else {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if(!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/", $email)){
        $response['status'] = 'error';
        $response['message'] = 'Invalid email address';
        echo json_encode($response);
        exit();
    } else {
        $sql = "SELECT * FROM newsletter WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
            $response['status'] = 'error';
            $response['message'] = 'You have already subscribed';
            echo json_encode($response);
            exit();
        } else {
            require '../components/get-current-timestamp.php';
            $date = getCurrentTimestamp();

            $sql = "INSERT INTO newsletter VALUES (DEFAULT, '$email', '$date')";
            $result = mysqli_query($conn, $sql);
            if($result){
                $response['status'] = 'success';
                $response['message'] = 'Thank you for subscribing';
                echo json_encode($response);
                exit();
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Something went wrong';
                echo json_encode($response);
                exit();
            }
        }
    }

}

?>