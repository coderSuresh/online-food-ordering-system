<?php
session_start();
require '../../../config.php';
header("Content-Type: application/json; charset=UTF-8");

// response holder
$response = array();

if (!isset($_SESSION['admin-success'])) {
    $response['status'] = "error";
    $response['msg'] = "You are not logged in";
    echo json_encode($response);
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        function updateResponse($status, $msg)
        {
            $response['status'] = $status;
            $response['msg'] = $msg;
            echo json_encode($response);
            exit();
        }

        // get image info
        $target_dir = "../../../uploads/employees/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $temp_file = $_FILES["image"]["tmp_name"];
        $file_name = basename($_FILES["image"]["name"]);
        $uploadOk = 1;

        require('../../backend/validate-img.php');

        // get data from form
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $con_password = mysqli_real_escape_string($conn, $_POST['con-password']);
        $department =  mysqli_real_escape_string($conn, $_POST['department']);

        if (!preg_match("/^[A-Z a-z]{2,30}$/", $name)) {
            updateResponse("error", "Name should contain alphabet only");
        } else if (!preg_match("/^[0-9A-Za-z_-]{2,30}$/", $username)) {
            updateResponse("error", "Username should contain minimum 2 characters");
        } else if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
            updateResponse("error", "Invalid email address");
        } else if (!preg_match("/^[0-9A-Z a-z,!@#$%^&*()_+]{8,50}$/", $password)) {
            updateResponse("error", "Password should contain minimum 8 characters");
        } else if ($password != $con_password) {
            updateResponse("error", "Password and confirm password should be same");
        } else {
            if ($uploadOk == 0) {
                updateResponse("error", "Sorry, your file was not uploaded.");
            } else {
                if (move_uploaded_file($temp_file, $target_file)) {
                    $password_md5 = md5($password);
                    $sql = "INSERT INTO employees VALUES (DEFAULT, '$name', $department, '$email', '$username', '$password_md5', '$file_name', 0)";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        updateResponse("success", "Employee has been added successfully");
                    } else {
                        updateResponse("error", "Something went wrong");
                    }
                } else {
                    updateResponse("error", "Sorry, there was an error uploading your file.");
                }
            }
            if ($result) {
                updateResponse("success reset", "Employee has been added successfully");
            } else {
                updateResponse("error", "Something went wrong");
            }
        }
    } else {
        header('location: ../../../invalid.html');
    }
}
