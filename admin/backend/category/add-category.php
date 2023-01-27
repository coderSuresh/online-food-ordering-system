<?php
session_start();
require('../../../config.php');
header("Content-Type: application/json; charset=UTF-8");

// response holder
$response = array();

if (!isset($_SESSION['admin-success'])) {
    $response['status'] = "error";
    $response['msg'] = "You are not logged in";
    echo json_encode($response);
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // get image info
        $target_dir = "../../../uploads/category/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $temp_file = $_FILES["image"]["tmp_name"];
        $file_name = basename($_FILES["image"]["name"]);
        $uploadOk = 1;

        require('../validate-img.php');

        $category = mysqli_real_escape_string($conn, $_POST['category']);

        if (!preg_match("/^[A-Z a-z]{2,30}$/", $category)) {
            $response['status'] = "error";
            $response['msg'] = "Name should contain alphabet only";
            echo json_encode($response);
            exit();
        } else {

            // Check if category already exists
            $sql = "SELECT name FROM category WHERE name = '$category'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $response['status'] = "error";
                $response['msg'] = "Category already exists";
                echo json_encode($response);
                exit();
            }

            if ($uploadOk == 0) {
                $response["status"] = "error";
                $response["msg"] = "Sorry, your file was not uploaded.";
                echo json_encode($response);
                exit();
            } else {
                if (move_uploaded_file($temp_file, $target_file)) {
                    // insert into database
                    $sql = "INSERT INTO category VALUES (DEFAULT, '$file_name', '$category')";
                    $result = mysqli_query($conn, $sql);
                } else {
                    $response["status"] = "error";
                    $response["msg"] = "Sorry, there was an error uploading your file.";
                    echo json_encode($response);
                    exit();
                }
            }

            if ($result) {
                $response['status'] = "success reset";
                $response['msg'] = "Category added successfully";
            } else {
                $response['status'] = "error";
                $response['msg'] = "Failed to add category";
                echo json_encode($response);
                exit();
            }
        }

        echo json_encode($response);
    } else {
        header('location: ../../../invalid.html');
    }
}
