<?php
session_start();

include '../../../config.php';

// response holder
$response = array();

if (!isset($_SESSION['admin-success'])) {
    $response['status'] = "error";
    $response['msg'] = "You are not logged in";
    echo json_encode($response);
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // upload image to server 
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

            if ($uploadOk == 0) {
                $response["status"] = "error";
                $response["msg"] = "Sorry, your file was not uploaded.";
                echo json_encode($response);
                exit();
            } else {
                if (move_uploaded_file($temp_file, $target_file)) {
                    $response["status"] = "success";
                    $response["msg"] = "The file has been uploaded.";

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
